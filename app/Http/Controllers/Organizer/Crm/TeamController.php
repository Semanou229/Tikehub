<?php

namespace App\Http\Controllers\Organizer\Crm;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamTask;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $organizerId = auth()->id();
        
        $teams = Team::where('organizer_id', $organizerId)
            ->with(['members', 'tasks'])
            ->latest()
            ->get();

        // Récupérer aussi les agents (pour migration depuis l'ancien système)
        $agents = User::role('agent')
            ->whereHas('agentEvents', function ($q) use ($organizerId) {
                $q->whereHas('event', function ($query) use ($organizerId) {
                    $query->where('organizer_id', $organizerId);
                });
            })
            ->get();

        return view('dashboard.organizer.crm.teams.index', compact('teams', 'agents'));
    }

    public function create()
    {
        return view('dashboard.organizer.crm.teams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['organizer_id'] = auth()->id();
        $team = Team::create($validated);

        return redirect()->route('organizer.crm.teams.show', $team)
            ->with('success', 'Équipe créée avec succès.');
    }

    public function show(Team $team)
    {
        $this->authorize('view', $team);

        $team->load(['members', 'tasks.assignedUser', 'tasks.creator']);

        $stats = [
            'members_count' => $team->members()->count(),
            'tasks_todo' => $team->tasks()->where('status', 'todo')->count(),
            'tasks_in_progress' => $team->tasks()->where('status', 'in_progress')->count(),
            'tasks_done' => $team->tasks()->where('status', 'done')->count(),
        ];

        return view('dashboard.organizer.crm.teams.show', compact('team', 'stats'));
    }

    public function edit(Team $team)
    {
        $this->authorize('update', $team);

        return view('dashboard.organizer.crm.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $team->update($validated);

        return redirect()->route('organizer.crm.teams.show', $team)
            ->with('success', 'Équipe mise à jour avec succès.');
    }

    public function destroy(Team $team)
    {
        $this->authorize('delete', $team);

        $team->delete();

        return redirect()->route('organizer.crm.teams.index')
            ->with('success', 'Équipe supprimée avec succès.');
    }

    public function addMember(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'team_role' => 'required|in:manager,agent,staff,volunteer',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->update([
            'team_id' => $team->id,
            'team_role' => $request->team_role,
        ]);

        return back()->with('success', 'Membre ajouté à l\'équipe.');
    }

    public function removeMember(Team $team, User $user)
    {
        $this->authorize('update', $team);

        if ($user->team_id === $team->id) {
            $user->update([
                'team_id' => null,
                'team_role' => null,
            ]);
        }

        return back()->with('success', 'Membre retiré de l\'équipe.');
    }
}
