<?php

namespace App\Http\Controllers\Collaborator;

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
        $user = auth()->user();
        
        // Vérifier l'accès
        $hasAccess = $this->checkEventAccess($user, $event);
        if (!$hasAccess) {
            abort(403, 'Vous n\'avez pas accès à cet événement.');
        }

        $scans = TicketScan::whereHas('ticket', function ($q) use ($event) {
            $q->where('event_id', $event->id);
        })
        ->where('scanned_by', $user->id)
        ->with('ticket.buyer', 'ticket.ticketType')
        ->latest()
        ->paginate(20);

        // Statistiques
        $myValidScans = TicketScan::whereHas('ticket', function ($q) use ($event) {
            $q->where('event_id', $event->id);
        })->where('scanned_by', $user->id)->where('is_valid', true)->count();

        $myInvalidScans = TicketScan::whereHas('ticket', function ($q) use ($event) {
            $q->where('event_id', $event->id);
        })->where('scanned_by', $user->id)->where('is_valid', false)->count();

        $stats = [
            'my_valid_scans' => $myValidScans,
            'my_invalid_scans' => $myInvalidScans,
            'total_tickets' => $event->tickets()->where('status', 'paid')->count(),
        ];

        return view('dashboard.collaborator.scans.index', compact('event', 'scans', 'stats'));
    }

    public function scan(Request $request, Event $event)
    {
        $user = auth()->user();
        
        // Vérifier l'accès
        $hasAccess = $this->checkEventAccess($user, $event);
        if (!$hasAccess) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'avez pas accès à cet événement.',
            ], 403);
        }

        $request->validate([
            'qr_token' => 'nullable|string',
            'code' => 'nullable|string',
        ]);

        if (!$request->filled('qr_token') && !$request->filled('code')) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez fournir un token QR ou un code de billet.',
            ], 400);
        }

        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        // Rate limiting
        $rateLimitKey = "scan_rate_limit:{$ipAddress}";
        $attempts = Cache::get($rateLimitKey, 0);
        if ($attempts >= 10) {
            $this->logFailedScan(null, $event->id, 'Rate limit dépassé', $ipAddress, $userAgent, $user->id);
            return response()->json([
                'success' => false,
                'message' => 'Trop de tentatives de scan. Veuillez patienter.',
            ], 429);
        }
        Cache::put($rateLimitKey, $attempts + 1, 60);

        // Trouver le billet
        $ticket = null;
        
        if ($request->filled('qr_token')) {
            $ticket = $this->qrCodeService->validateToken($request->qr_token);
            if (!$ticket) {
                $this->logFailedScan(null, $event->id, 'Token QR invalide', $ipAddress, $userAgent, $user->id);
                return response()->json([
                    'success' => false,
                    'message' => 'Token QR invalide ou expiré.',
                ], 400);
            }
        } elseif ($request->filled('code')) {
            $ticket = Ticket::where('code', strtoupper(trim($request->code)))
                ->where('event_id', $event->id)
                ->first();
            
            if (!$ticket) {
                $this->logFailedScan(null, $event->id, 'Code billet invalide', $ipAddress, $userAgent, $user->id);
                return response()->json([
                    'success' => false,
                    'message' => 'Code de billet invalide ou introuvable.',
                ], 404);
            }
        }

        if (!$ticket || $ticket->event_id !== $event->id) {
            return response()->json([
                'success' => false,
                'message' => 'Billet invalide ou ne correspond pas à cet événement.',
            ], 400);
        }

        if ($ticket->status !== 'paid') {
            $this->logFailedScan($ticket->id, $event->id, 'Billet non payé', $ipAddress, $userAgent, $user->id);
            return response()->json([
                'success' => false,
                'message' => 'Ce billet n\'est pas payé.',
            ], 400);
        }

        // Vérifier si déjà scanné
        $existingValidScan = TicketScan::where('ticket_id', $ticket->id)
            ->where('is_valid', true)
            ->first();

        if ($existingValidScan) {
            return response()->json([
                'success' => false,
                'message' => 'Ce billet a déjà été scanné.',
                'ticket' => [
                    'id' => $ticket->id,
                    'code' => $ticket->code,
                    'buyer' => $ticket->buyer->name ?? $ticket->buyer_name ?? 'N/A',
                    'scanned_at' => $existingValidScan->created_at->translatedFormat('d/m/Y H:i:s'),
                    'scanned_by' => $existingValidScan->scanner->name ?? 'N/A',
                ],
            ], 400);
        }

        // Enregistrer le scan
        $scan = TicketScan::create([
            'ticket_id' => $ticket->id,
            'event_id' => $event->id,
            'scanned_by' => $user->id,
            'scan_type' => 'entry',
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'is_valid' => true,
        ]);

        $ticket->update([
            'scanned_at' => now(),
            'scanned_by' => $user->id,
        ]);

        Cache::forget($rateLimitKey);

        return response()->json([
            'success' => true,
            'message' => 'Billet validé avec succès.',
            'ticket' => [
                'id' => $ticket->id,
                'code' => $ticket->code,
                'buyer' => $ticket->buyer->name ?? $ticket->buyer_name ?? 'N/A',
                'type' => $ticket->ticketType->name ?? 'N/A',
            ],
        ]);
    }

    protected function checkEventAccess($user, Event $event): bool
    {
        if ($user->hasRole('agent') && $user->agentEvents->contains($event->id)) {
            return true;
        }
        
        if ($user->team_id) {
            $team = \App\Models\Team::find($user->team_id);
            if ($team && $team->organizer_id === $event->organizer_id) {
                return true;
            }
        }
        
        return false;
    }

    protected function logFailedScan($ticketId, $eventId, $reason, $ipAddress, $userAgent, $scannerId)
    {
        TicketScan::create([
            'ticket_id' => $ticketId,
            'event_id' => $eventId,
            'scanned_by' => $scannerId,
            'scan_type' => 'entry',
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'is_valid' => false,
            'notes' => $reason,
        ]);
    }
}

