<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketScan;
use App\Services\QrCodeService;
use Illuminate\Http\Request;

class TicketScanController extends Controller
{
    protected QrCodeService $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    public function scan(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'event_id' => 'required|exists:events,id',
        ]);

        $ticket = $this->qrCodeService->validateToken($request->token);

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Token invalide ou expiré'
            ], 400);
        }

        if ($ticket->event_id != $request->event_id) {
            return response()->json([
                'success' => false,
                'message' => 'Ce billet ne correspond pas à cet événement'
            ], 400);
        }

        if (!$ticket->canBeScanned()) {
            return response()->json([
                'success' => false,
                'message' => $ticket->isScanned() ? 'Billet déjà scanné' : 'Billet non payé',
                'scanned_at' => $ticket->scanned_at?->toIso8601String(),
            ], 400);
        }

        // Enregistrer le scan
        $scan = TicketScan::create([
            'ticket_id' => $ticket->id,
            'event_id' => $ticket->event_id,
            'scanned_by' => auth()->id(),
            'scan_type' => 'entry',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_valid' => true,
        ]);

        // Marquer le billet comme scanné
        $ticket->update([
            'scanned_at' => now(),
            'scanned_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Billet validé avec succès',
            'ticket' => [
                'code' => $ticket->code,
                'buyer_name' => $ticket->buyer_name,
                'event' => $ticket->event->title,
            ],
            'scan' => [
                'id' => $scan->id,
                'scanned_at' => $scan->created_at->toIso8601String(),
            ]
        ]);
    }
}

