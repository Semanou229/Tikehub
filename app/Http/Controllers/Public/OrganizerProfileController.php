<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Contest;
use App\Models\Fundraising;
use Illuminate\Http\Request;

class OrganizerProfileController extends Controller
{
    public function show(User $organizer)
    {
        // Vérifier que l'utilisateur est un organisateur
        if (!$organizer->hasRole('organizer')) {
            abort(404);
        }

        // Événements en cours
        $activeEvents = Event::where('organizer_id', $organizer->id)
            ->where('is_published', true)
            ->where('start_date', '>=', now())
            ->withCount(['tickets', 'ticketTypes'])
            ->latest()
            ->get();

        // Événements terminés
        $pastEvents = Event::where('organizer_id', $organizer->id)
            ->where('is_published', true)
            ->where('end_date', '<', now())
            ->withCount(['tickets', 'ticketTypes'])
            ->latest()
            ->take(10)
            ->get();

        // Concours en cours
        $activeContests = Contest::where('organizer_id', $organizer->id)
            ->where('is_published', true)
            ->where('is_active', true)
            ->where('end_date', '>=', now())
            ->withCount('votes')
            ->withCount('candidates')
            ->latest()
            ->get();

        // Concours terminés
        $pastContests = Contest::where('organizer_id', $organizer->id)
            ->where('is_published', true)
            ->where(function ($q) {
                $q->where('is_active', false)
                  ->orWhere('end_date', '<', now());
            })
            ->withCount('votes')
            ->withCount('candidates')
            ->latest()
            ->take(10)
            ->get();

        // Collectes en cours
        $activeFundraisings = Fundraising::where('organizer_id', $organizer->id)
            ->where('is_active', true)
            ->where('end_date', '>=', now())
            ->latest()
            ->get();

        // Collectes terminées
        $pastFundraisings = Fundraising::where('organizer_id', $organizer->id)
            ->where(function ($q) {
                $q->where('is_active', false)
                  ->orWhere('end_date', '<', now());
            })
            ->latest()
            ->take(10)
            ->get();

        // Statistiques
        $stats = [
            'total_events' => Event::where('organizer_id', $organizer->id)->where('is_published', true)->count(),
            'total_contests' => Contest::where('organizer_id', $organizer->id)->where('is_published', true)->count(),
            'total_fundraisings' => Fundraising::where('organizer_id', $organizer->id)->count(),
            'total_tickets_sold' => \App\Models\Ticket::whereHas('event', function ($q) use ($organizer) {
                $q->where('organizer_id', $organizer->id);
            })->where('status', 'paid')->count(),
        ];

        return view('organizer.profile', compact(
            'organizer',
            'activeEvents',
            'pastEvents',
            'activeContests',
            'pastContests',
            'activeFundraisings',
            'pastFundraisings',
            'stats'
        ));
    }
}
