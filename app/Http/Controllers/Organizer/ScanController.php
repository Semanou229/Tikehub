<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketScan;
use Illuminate\Http\Request;

class ScanController extends Controller
{
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

        $stats = [
            'total_scans' => $scans->total(),
            'unique_tickets' => TicketScan::whereHas('ticket', function ($q) use ($event) {
                $q->where('event_id', $event->id);
            })->distinct('ticket_id')->count('ticket_id'),
            'total_tickets' => $event->tickets()->where('status', 'paid')->count(),
        ];

        return view('dashboard.organizer.scans.index', compact('event', 'scans', 'stats'));
    }

    public function scan(Request $request, Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'qr_code' => 'required|string',
        ]);

        // Trouver le billet par QR code
        $ticket = Ticket::where('qr_code', $request->qr_code)
            ->where('event_id', $event->id)
            ->where('status', 'paid')
            ->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Billet non trouvé ou invalide.',
            ], 404);
        }

        // Vérifier si déjà scanné
        $alreadyScanned = TicketScan::where('ticket_id', $ticket->id)
            ->where('is_valid', true)
            ->exists();

        if ($alreadyScanned) {
            return response()->json([
                'success' => false,
                'message' => 'Ce billet a déjà été scanné.',
                'ticket' => [
                    'id' => $ticket->id,
                    'buyer' => $ticket->buyer->name ?? 'N/A',
                    'scanned_at' => TicketScan::where('ticket_id', $ticket->id)->first()->created_at->format('d/m/Y H:i'),
                ],
            ], 400);
        }

        // Enregistrer le scan
        $scan = TicketScan::create([
            'ticket_id' => $ticket->id,
            'scanned_by' => auth()->id(),
            'is_valid' => true,
            'scanned_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Billet scanné avec succès.',
            'ticket' => [
                'id' => $ticket->id,
                'buyer' => $ticket->buyer->name ?? 'N/A',
                'type' => $ticket->ticketType->name ?? 'N/A',
            ],
            'scan' => [
                'id' => $scan->id,
                'scanned_at' => $scan->created_at->format('d/m/Y H:i'),
            ],
        ]);
    }
}

