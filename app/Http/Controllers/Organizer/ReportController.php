<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $organizerId = auth()->id();

        // Statistiques générales
        $stats = [
            'total_events' => Event::where('organizer_id', $organizerId)->count(),
            'total_tickets_sold' => Ticket::whereHas('event', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })->where('status', 'paid')->count(),
            'total_revenue' => Ticket::whereHas('event', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })->where('status', 'paid')->sum('price'),
            'pending_payments' => Payment::whereHas('event', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })->where('status', 'pending')->count(),
        ];

        // Événements avec statistiques
        $events = Event::where('organizer_id', $organizerId)
            ->withCount(['tickets as tickets_sold' => function ($query) {
                $query->where('status', 'paid');
            }])
            ->withSum(['tickets as revenue' => function ($query) {
                $query->where('status', 'paid');
            }], 'price')
            ->latest()
            ->get();

        return view('dashboard.organizer.reports.index', compact('stats', 'events'));
    }

    public function eventReport(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $tickets = $event->tickets()
            ->with('buyer', 'ticketType')
            ->where('status', 'paid')
            ->latest()
            ->get();

        $stats = [
            'total_sold' => $tickets->count(),
            'total_revenue' => $tickets->sum('price'),
            'by_type' => $tickets->groupBy('ticket_type_id')->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'revenue' => $group->sum('price'),
                ];
            }),
        ];

        return view('dashboard.organizer.reports.event', compact('event', 'tickets', 'stats'));
    }

    public function exportEvent(Event $event, $format = 'csv')
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $tickets = $event->tickets()
            ->with('buyer', 'ticketType')
            ->where('status', 'paid')
            ->get();

        $data = $tickets->map(function ($ticket) {
            return [
                'ID' => $ticket->id,
                'Type' => $ticket->ticketType->name ?? 'N/A',
                'Acheteur' => $ticket->buyer->name ?? 'N/A',
                'Email' => $ticket->buyer->email ?? 'N/A',
                'Prix' => $ticket->price,
                'Date d\'achat' => $ticket->created_at->format('d/m/Y H:i'),
                'Statut' => $ticket->status,
            ];
        });

        $filename = 'rapport_' . $event->slug . '_' . now()->format('Y-m-d');

        if ($format === 'excel') {
            $export = new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection {
                public function __construct(private Collection $data) {}
                public function collection() { return $this->data; }
            };
            return Excel::download($export, $filename . '.xlsx');
        }

        // Export CSV
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            // BOM pour Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['ID', 'Type', 'Acheteur', 'Email', 'Prix', 'Date d\'achat', 'Statut'], ';');

            foreach ($data as $row) {
                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

