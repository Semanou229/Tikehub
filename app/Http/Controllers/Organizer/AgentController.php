<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        $organizerId = auth()->id();
        
        // Récupérer les événements de l'organisateur
        $eventIds = Event::where('organizer_id', $organizerId)->pluck('id');
        
        // Récupérer les agents assignés à ces événements
        $agents = User::role('agent')
            ->whereHas('agentEvents', function ($query) use ($eventIds) {
                $query->whereIn('events.id', $eventIds);
            })
            ->with(['agentEvents' => function ($query) use ($eventIds) {
                $query->whereIn('events.id', $eventIds);
            }])
            ->distinct()
            ->paginate(15);

        return view('dashboard.organizer.agents.index', compact('agents'));
    }

    public function create()
    {
        $events = Event::where('organizer_id', auth()->id())
            ->where('is_published', true)
            ->get();

        return view('dashboard.organizer.agents.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'event_ids' => 'required|array',
            'event_ids.*' => 'exists:events,id',
        ]);

        $agent = User::where('email', $validated['email'])->first();

        // Vérifier que l'utilisateur est un agent
        if (!$agent->hasRole('agent')) {
            return back()->with('error', 'Cet utilisateur n\'est pas un agent.');
        }

        // Vérifier que les événements appartiennent à l'organisateur
        $events = Event::whereIn('id', $validated['event_ids'])
            ->where('organizer_id', auth()->id())
            ->get();

        if ($events->count() !== count($validated['event_ids'])) {
            return back()->with('error', 'Certains événements ne vous appartiennent pas.');
        }

        // Assigner l'agent aux événements
        foreach ($events as $event) {
            $event->agents()->syncWithoutDetaching([$agent->id]);
        }

        return redirect()->route('organizer.agents.index')
            ->with('success', 'Agent assigné avec succès.');
    }

    public function destroy(Event $event, User $agent)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $event->agents()->detach($agent->id);

        return back()->with('success', 'Agent retiré de l\'événement avec succès.');
    }
}

