<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $assignedEvents = collect();
        
        // Événements assignés directement via event_agents (collaborateurs assignés)
        $directlyAssignedEvents = Event::whereHas('agents', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->with('organizer')->get();
        $assignedEvents = $assignedEvents->merge($directlyAssignedEvents);
        
        // Événements assignés via agentEvents (agents)
        if ($user->hasRole('agent')) {
            $assignedEvents = $assignedEvents->merge($user->agentEvents()->with('organizer')->get());
        }
        
        // Événements de l'équipe (événements de l'organisateur qui a créé l'équipe)
        if ($user->team_id) {
            $team = \App\Models\Team::find($user->team_id);
            if ($team && $team->organizer_id) {
                $teamEvents = Event::where('organizer_id', $team->organizer_id)
                    ->with('organizer')
                    ->get();
                $assignedEvents = $assignedEvents->merge($teamEvents);
            }
        }
        
        $assignedEvents = $assignedEvents->unique('id')->sortByDesc('start_date');

        return view('dashboard.collaborator.events.index', compact('assignedEvents'));
    }

    public function show(Event $event)
    {
        $user = auth()->user();
        
        // Vérifier que l'utilisateur a accès à cet événement
        $hasAccess = false;
        
        // Vérifier si l'utilisateur est assigné directement à l'événement (via event_agents)
        if ($event->agents->contains('id', $user->id)) {
            $hasAccess = true;
        }
        
        // Vérifier si l'utilisateur est un agent assigné à l'événement
        if ($user->hasRole('agent') && $user->agentEvents->contains($event->id)) {
            $hasAccess = true;
        }
        
        // Vérifier si l'utilisateur est membre d'une équipe de l'organisateur
        if ($user->team_id) {
            $team = \App\Models\Team::find($user->team_id);
            if ($team && $team->organizer_id === $event->organizer_id) {
                $hasAccess = true;
            }
        }
        
        if (!$hasAccess) {
            abort(403, 'Vous n\'avez pas accès à cet événement.');
        }

        // Statistiques de l'événement
        $totalTickets = $event->tickets()->where('status', 'paid')->count();
        $scannedTickets = $event->tickets()
            ->where('status', 'paid')
            ->whereHas('scans', function ($q) {
                $q->where('is_valid', true);
            })
            ->count();
        
        $myScans = TicketScan::where('event_id', $event->id)
            ->where('scanned_by', $user->id)
            ->where('is_valid', true)
            ->count();

        $stats = [
            'total_tickets' => $totalTickets,
            'scanned_tickets' => $scannedTickets,
            'unscanned_tickets' => $totalTickets - $scannedTickets,
            'my_scans' => $myScans,
        ];

        return view('dashboard.collaborator.events.show', compact('event', 'stats'));
    }
}

