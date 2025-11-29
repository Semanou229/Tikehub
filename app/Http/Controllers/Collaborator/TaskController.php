<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\TeamTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $tasks = TeamTask::where('assigned_to', $user->id)
            ->with(['team', 'assignedTo'])
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => TeamTask::where('assigned_to', $user->id)->count(),
            'pending' => TeamTask::where('assigned_to', $user->id)->where('status', 'pending')->count(),
            'in_progress' => TeamTask::where('assigned_to', $user->id)->where('status', 'in_progress')->count(),
            'completed' => TeamTask::where('assigned_to', $user->id)->where('status', 'completed')->count(),
        ];

        return view('dashboard.collaborator.tasks.index', compact('tasks', 'stats'));
    }

    public function show(TeamTask $task)
    {
        $user = auth()->user();
        
        if ($task->assigned_to !== $user->id) {
            abort(403, 'Vous n\'avez pas accès à cette tâche.');
        }

        $task->load(['team', 'assignedTo', 'createdBy']);

        return view('dashboard.collaborator.tasks.show', compact('task'));
    }

    public function updateStatus(Request $request, TeamTask $task)
    {
        $user = auth()->user();
        
        if ($task->assigned_to !== $user->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update([
            'status' => $request->status,
            'completed_at' => $request->status === 'completed' ? now() : null,
        ]);

        return redirect()->back()->with('success', 'Statut de la tâche mis à jour.');
    }
}

