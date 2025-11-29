<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketScan;
use App\Models\TeamTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;

        // Événements assignés (via agentEvents ou via team)
        $assignedEvents = collect();
        
        // Événements assignés directement (agents)
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
        
        $assignedEvents = $assignedEvents->unique('id')->take(10);

        // Tâches assignées
        $myTasks = TeamTask::where('assigned_to', $userId)
            ->with(['team', 'assignedTo'])
            ->latest()
            ->take(10)
            ->get();

        // Statistiques des scans
        $totalScans = TicketScan::where('scanned_by', $userId)
            ->where('is_valid', true)
            ->count();
        
        $todayScans = TicketScan::where('scanned_by', $userId)
            ->where('is_valid', true)
            ->whereDate('created_at', today())
            ->count();

        // Statistiques des billets scannés par événement
        $scansByEvent = TicketScan::where('scanned_by', $userId)
            ->where('is_valid', true)
            ->select('event_id', DB::raw('count(*) as count'))
            ->groupBy('event_id')
            ->with('event')
            ->get();

        // Tâches en cours
        $pendingTasks = TeamTask::where('assigned_to', $userId)
            ->where('status', 'pending')
            ->count();
        
        $completedTasks = TeamTask::where('assigned_to', $userId)
            ->where('status', 'completed')
            ->count();

        // Activité récente (scans)
        $recentScans = TicketScan::where('scanned_by', $userId)
            ->with(['ticket.ticketType', 'ticket.buyer', 'event'])
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'total_scans' => $totalScans,
            'today_scans' => $todayScans,
            'pending_tasks' => $pendingTasks,
            'completed_tasks' => $completedTasks,
            'assigned_events_count' => $assignedEvents->count(),
        ];

        return view('dashboard.collaborator.index', compact(
            'assignedEvents',
            'myTasks',
            'stats',
            'scansByEvent',
            'recentScans'
        ));
    }
}

