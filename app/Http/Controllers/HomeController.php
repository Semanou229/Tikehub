<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Contest;
use App\Models\Fundraising;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Événements à venir (6 premiers)
        $upcomingEvents = Event::where('is_published', true)
            ->where('status', 'published')
            ->where('start_date', '>=', now())
            ->with('organizer')
            ->orderBy('start_date', 'asc')
            ->take(6)
            ->get();

        // Événements populaires (par nombre de billets vendus)
        // Si pas assez d'événements à venir, afficher tous les événements publiés
        $popularEvents = Event::where('is_published', true)
            ->where('status', 'published')
            ->with('organizer')
            ->withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->orderBy('start_date', 'desc')
            ->take(6)
            ->get();

        // Concours actifs (6 premiers)
        $activeContests = Contest::where('is_published', true)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->take(6)
            ->get();

        // Collectes de fonds actives (6 premières)
        $activeFundraisings = Fundraising::where('is_published', true)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('current_amount', 'desc')
            ->take(6)
            ->get();

        // Statistiques
        $stats = [
            'total_events' => Event::where('is_published', true)->where('status', 'published')->count(),
            'upcoming_events' => Event::where('is_published', true)
                ->where('status', 'published')
                ->where('start_date', '>=', now())
                ->count(),
            'active_contests' => Contest::where('is_published', true)
                ->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->count(),
            'active_fundraisings' => Fundraising::where('is_published', true)
                ->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->count(),
        ];

        // Récupérer le pourcentage de commission dynamique
        $commissionRate = get_commission_rate();
        
        return view('home', compact('upcomingEvents', 'popularEvents', 'activeContests', 'activeFundraisings', 'stats', 'commissionRate'));
    }
}

