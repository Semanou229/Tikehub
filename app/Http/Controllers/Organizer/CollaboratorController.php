<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;

class CollaboratorController extends Controller
{
    public function index(Event $event)
    {
        $this->authorize('update', $event);

        // Récupérer les collaborateurs assignés (agents + membres d'équipe)
        $assignedCollaborators = $event->agents()->get();
        
        // Récupérer les membres d'équipe de l'organisateur
        $teamMembers = collect();
        $teams = Team::where('organizer_id', auth()->id())->get();
        foreach ($teams as $team) {
            $teamMembers = $teamMembers->merge($team->members);
        }
        $teamMembers = $teamMembers->unique('id');

        // Récupérer les agents disponibles
        $availableAgents = User::role('agent')
            ->whereDoesntHave('agentEvents', function ($q) use ($event) {
                $q->where('events.id', $event->id);
            })
            ->get();

        return view('dashboard.organizer.events.collaborators', compact('event', 'assignedCollaborators', 'teamMembers', 'availableAgents'));
    }

    public function store(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'collaborator_id' => 'required|exists:users,id',
            'type' => 'required|in:agent,team_member',
        ]);

        $collaborator = User::findOrFail($validated['collaborator_id']);

        // Vérifier que c'est un agent ou un membre d'équipe de l'organisateur
        if ($validated['type'] === 'agent' && !$collaborator->hasRole('agent')) {
            return back()->with('error', 'Cet utilisateur n\'est pas un agent.');
        }

        if ($validated['type'] === 'team_member') {
            $team = Team::where('organizer_id', auth()->id())
                ->whereHas('members', function ($q) use ($collaborator) {
                    $q->where('users.id', $collaborator->id);
                })
                ->first();

            if (!$team) {
                return back()->with('error', 'Ce collaborateur n\'appartient pas à une de vos équipes.');
            }
        }

        // Assigner le collaborateur à l'événement
        $event->agents()->syncWithoutDetaching([$collaborator->id]);

        return back()->with('success', 'Collaborateur assigné avec succès.');
    }

    public function destroy(Event $event, User $collaborator)
    {
        $this->authorize('update', $event);

        $event->agents()->detach($collaborator->id);

        return back()->with('success', 'Collaborateur retiré de l\'événement avec succès.');
    }
}

