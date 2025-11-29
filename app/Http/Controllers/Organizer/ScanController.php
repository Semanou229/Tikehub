<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketScan;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ScanController extends Controller
{
    protected QrCodeService $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    public function index(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $scans = TicketScan::whereHas('ticket', function ($q) use ($event) {
            $q->where('event_id', $event->id);
        })
        ->with('ticket.buyer', 'ticket.ticketType', 'scanner')
        ->latest()
        ->paginate(20);

        // Statistiques
        $validScans = TicketScan::whereHas('ticket', function ($q) use ($event) {
            $q->where('event_id', $event->id);
        })->where('is_valid', true)->count();

        $invalidScans = TicketScan::whereHas('ticket', function ($q) use ($event) {
            $q->where('event_id', $event->id);
        })->where('is_valid', false)->count();

        $stats = [
            'total_scans' => $validScans,
            'invalid_scans' => $invalidScans,
            'unique_tickets' => TicketScan::whereHas('ticket', function ($q) use ($event) {
                $q->where('event_id', $event->id);
            })->where('is_valid', true)->distinct('ticket_id')->count('ticket_id'),
            'total_tickets' => $event->tickets()->where('status', 'paid')->count(),
            'unscanned_tickets' => $event->tickets()
                ->where('status', 'paid')
                ->whereDoesntHave('scans', function ($q) {
                    $q->where('is_valid', true);
                })
                ->count(),
        ];

        return view('dashboard.organizer.scans.index', compact('event', 'scans', 'stats'));
    }

    public function scan(Request $request, Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'qr_token' => 'nullable|string',
            'code' => 'nullable|string',
        ]);

        // Vérifier qu'au moins un des deux est fourni
        if (!$request->filled('qr_token') && !$request->filled('code')) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez fournir un token QR ou un code de billet.',
            ], 400);
        }

        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        // Rate limiting par IP (max 10 scans par minute)
        $rateLimitKey = "scan_rate_limit:{$ipAddress}";
        $attempts = Cache::get($rateLimitKey, 0);
        if ($attempts >= 10) {
            $this->logFailedScan(null, $event->id, 'Rate limit dépassé', $ipAddress, $userAgent);
            return response()->json([
                'success' => false,
                'message' => 'Trop de tentatives de scan. Veuillez patienter.',
                'fraud_detected' => true,
            ], 429);
        }
        Cache::put($rateLimitKey, $attempts + 1, 60);

        // Trouver le billet soit par token QR soit par code
        $ticket = null;
        
        if ($request->filled('qr_token')) {
            // Validation du token QR
            $ticket = $this->qrCodeService->validateToken($request->qr_token);
            if (!$ticket) {
                $this->logFailedScan(null, $event->id, 'Token QR invalide ou expiré', $ipAddress, $userAgent);
                return response()->json([
                    'success' => false,
                    'message' => 'Token QR invalide ou expiré.',
                    'fraud_detected' => true,
                ], 400);
            }
        } elseif ($request->filled('code')) {
            // Recherche par code unique
            $ticket = Ticket::where('code', strtoupper(trim($request->code)))
                ->where('event_id', $event->id)
                ->first();
            
            if (!$ticket) {
                $this->logFailedScan(null, $event->id, 'Code billet invalide', $ipAddress, $userAgent);
                return response()->json([
                    'success' => false,
                    'message' => 'Code de billet invalide ou introuvable.',
                    'fraud_detected' => true,
                ], 404);
            }
        }

        if (!$ticket) {
            $this->logFailedScan(null, $event->id, 'Token invalide ou expiré', $ipAddress, $userAgent);
            return response()->json([
                'success' => false,
                'message' => 'Token QR invalide ou expiré.',
                'fraud_detected' => true,
            ], 400);
        }

        // Vérification 1: Le billet appartient à l'événement
        if ($ticket->event_id !== $event->id) {
            $this->logFailedScan($ticket->id, $event->id, 'Billet ne correspond pas à l\'événement', $ipAddress, $userAgent);
            return response()->json([
                'success' => false,
                'message' => 'Ce billet ne correspond pas à cet événement.',
                'fraud_detected' => true,
            ], 400);
        }

        // Vérification 2: Le billet est payé
        if ($ticket->status !== 'paid') {
            $this->logFailedScan($ticket->id, $event->id, 'Billet non payé', $ipAddress, $userAgent);
            return response()->json([
                'success' => false,
                'message' => 'Ce billet n\'est pas payé.',
                'fraud_detected' => true,
            ], 400);
        }

        // Vérification 3: Le billet n'a pas déjà été scanné (scan valide)
        $existingValidScan = TicketScan::where('ticket_id', $ticket->id)
            ->where('is_valid', true)
            ->first();

        if ($existingValidScan) {
            // Détecter les tentatives de double scan
            $recentAttempts = TicketScan::where('ticket_id', $ticket->id)
                ->where('is_valid', false)
                ->where('created_at', '>', now()->subMinutes(5))
                ->count();

            if ($recentAttempts > 0) {
                $this->logFailedScan($ticket->id, $event->id, 'Tentative de double scan détectée', $ipAddress, $userAgent);
                Log::warning('Tentative de fraude détectée', [
                    'ticket_id' => $ticket->id,
                    'event_id' => $event->id,
                    'ip' => $ipAddress,
                    'scanned_at' => $existingValidScan->created_at,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Ce billet a déjà été scanné.',
                'ticket' => [
                    'id' => $ticket->id,
                    'code' => $ticket->code,
                    'buyer' => $ticket->buyer->name ?? $ticket->buyer_name ?? 'N/A',
                    'scanned_at' => $existingValidScan->created_at->format('d/m/Y H:i:s'),
                    'scanned_by' => $existingValidScan->scanner->name ?? 'N/A',
                ],
                'fraud_detected' => $recentAttempts > 0,
            ], 400);
        }

        // Vérification 4: L'événement est en cours ou a commencé
        $now = now();
        if ($event->start_date > $now) {
            $this->logFailedScan($ticket->id, $event->id, 'Événement pas encore commencé', $ipAddress, $userAgent);
            return response()->json([
                'success' => false,
                'message' => 'L\'événement n\'a pas encore commencé.',
            ], 400);
        }

        // Vérification 5: Détection de tentatives suspectes depuis la même IP
        $suspiciousAttempts = TicketScan::where('event_id', $event->id)
            ->where('ip_address', $ipAddress)
            ->where('is_valid', false)
            ->where('created_at', '>', now()->subMinutes(10))
            ->count();

        if ($suspiciousAttempts >= 5) {
            Log::alert('Activité suspecte détectée', [
                'event_id' => $event->id,
                'ip' => $ipAddress,
                'failed_attempts' => $suspiciousAttempts,
            ]);
        }

        // Enregistrer le scan valide
        $scan = TicketScan::create([
            'ticket_id' => $ticket->id,
            'event_id' => $event->id,
            'scanned_by' => auth()->id(),
            'scan_type' => 'entry',
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'is_valid' => true,
        ]);

        // Marquer le billet comme scanné
        $ticket->update([
            'scanned_at' => now(),
            'scanned_by' => auth()->id(),
        ]);

        // Réinitialiser le rate limit en cas de succès
        Cache::forget($rateLimitKey);

        Log::info('Billet scanné avec succès', [
            'ticket_id' => $ticket->id,
            'event_id' => $event->id,
            'scanner_id' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Billet validé avec succès.',
            'ticket' => [
                'id' => $ticket->id,
                'code' => $ticket->code,
                'buyer' => $ticket->buyer->name ?? $ticket->buyer_name ?? 'N/A',
                'type' => $ticket->ticketType->name ?? 'N/A',
                'price' => number_format($ticket->price, 0, ',', ' '),
            ],
            'scan' => [
                'id' => $scan->id,
                'scanned_at' => $scan->created_at->format('d/m/Y H:i:s'),
            ],
        ]);
    }

    protected function logFailedScan($ticketId, $eventId, $reason, $ipAddress, $userAgent)
    {
        TicketScan::create([
            'ticket_id' => $ticketId,
            'event_id' => $eventId,
            'scanned_by' => auth()->id(),
            'scan_type' => 'entry',
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'is_valid' => false,
            'notes' => $reason,
        ]);
    }
}

