<?php

namespace App\Http\Controllers\Organizer\Crm;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamTask;
use App\Models\User;
use Illuminate\Http\Request;

class TeamTaskController extends Controller
{
    public function index(Team $team)
    {
        $this->authorize('view', $team);

        $status = $request->get('status');
        $query = $team->tasks()
            ->with(['assignedUser']);
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $tasks = $query->latest()->paginate(20);

        return view('dashboard.organizer.crm.teams.tasks.index', compact('team', 'tasks'));
    }

    public function create(Team $team)
    {
        $this->authorize('update', $team);

        $members = User::where('team_id', $team->id)->get();
        $allUsers = User::where('id', '!=', auth()->id())->get();

        return view('dashboard.organizer.crm.teams.tasks.create', compact('team', 'members', 'allUsers'));
    }

    public function store(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to_user_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date|after:today',
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $validated['team_id'] = $team->id;

        $task = TeamTask::create($validated);

        return redirect()->route('organizer.crm.teams.tasks.index', $team)
            ->with('success', 'Tâche créée avec succès.');
    }

    public function edit(Team $team, TeamTask $task)
    {
        $this->authorize('update', $team);

        if ($task->team_id !== $team->id) {
            abort(404);
        }

        $members = User::where('team_id', $team->id)->get();
        $allUsers = User::where('id', '!=', auth()->id())->get();

        return view('dashboard.organizer.crm.teams.tasks.edit', compact('team', 'task', 'members', 'allUsers'));
    }

    public function update(Request $request, Team $team, TeamTask $task)
    {
        $this->authorize('update', $team);

        if ($task->team_id !== $team->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to_user_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update($validated);

        return redirect()->route('organizer.crm.teams.tasks.index', $team)
            ->with('success', 'Tâche mise à jour avec succès.');
    }

    public function destroy(Team $team, TeamTask $task)
    {
        $this->authorize('update', $team);

        if ($task->team_id !== $team->id) {
            abort(404);
        }

        $task->delete();

        return redirect()->route('organizer.crm.teams.tasks.index', $team)
            ->with('success', 'Tâche supprimée avec succès.');
    }
}
