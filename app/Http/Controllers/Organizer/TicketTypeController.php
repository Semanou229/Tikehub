<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    public function index(Event $event)
    {
        // Vérifier que l'événement appartient à l'organisateur
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $ticketTypes = $event->ticketTypes()->withCount('tickets')->get();

        return view('dashboard.organizer.ticket-types.index', compact('event', 'ticketTypes'));
    }

    public function create(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        return view('dashboard.organizer.ticket-types.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after:sale_start_date',
        ]);

        $event->ticketTypes()->create($validated);

        return redirect()->route('organizer.ticket-types.index', $event)
            ->with('success', 'Type de billet créé avec succès.');
    }

    public function edit(Event $event, TicketType $ticketType)
    {
        if ($event->organizer_id !== auth()->id() || $ticketType->event_id !== $event->id) {
            abort(403);
        }

        return view('dashboard.organizer.ticket-types.edit', compact('event', 'ticketType'));
    }

    public function update(Request $request, Event $event, TicketType $ticketType)
    {
        if ($event->organizer_id !== auth()->id() || $ticketType->event_id !== $event->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after:sale_start_date',
        ]);

        $ticketType->update($validated);

        return redirect()->route('organizer.ticket-types.index', $event)
            ->with('success', 'Type de billet mis à jour avec succès.');
    }

    public function destroy(Event $event, TicketType $ticketType)
    {
        if ($event->organizer_id !== auth()->id() || $ticketType->event_id !== $event->id) {
            abort(403);
        }

        // Vérifier qu'il n'y a pas de billets vendus
        if ($ticketType->tickets()->where('status', 'paid')->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un type de billet avec des billets vendus.');
        }

        $ticketType->delete();

        return redirect()->route('organizer.ticket-types.index', $event)
            ->with('success', 'Type de billet supprimé avec succès.');
    }
}


