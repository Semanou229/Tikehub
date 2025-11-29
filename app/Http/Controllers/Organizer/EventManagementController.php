<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventManagementController extends Controller
{
    public function index()
    {
        $events = Event::where('organizer_id', auth()->id())
            ->withCount(['tickets', 'ticketTypes'])
            ->latest()
            ->paginate(15);

        return view('dashboard.organizer.events.index', compact('events'));
    }

    public function destroy(Event $event)
    {
        // Vérifier que l'événement appartient à l'organisateur
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        // Vérifier qu'il n'y a pas de billets vendus
        if ($event->tickets()->where('status', 'paid')->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un événement avec des billets vendus.');
        }

        $event->delete();

        return redirect()->route('organizer.events.index')
            ->with('success', 'Événement supprimé avec succès.');
    }
}

