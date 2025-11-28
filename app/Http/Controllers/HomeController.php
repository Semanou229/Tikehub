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
            ->orderBy('start_date', 'asc')
            ->take(6)
            ->get();

        // Événements populaires (par nombre de billets vendus)
        $popularEvents = Event::where('is_published', true)
            ->where('status', 'published')
            ->withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->take(6)
            ->get();

        // Concours actifs (6 premiers)
        $activeContests = Contest::where(function($query) {
                $query->where('is_published', true)
                      ->orWhereNull('is_published'); // Pour les anciens concours sans cette colonne
            })
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->take(6)
            ->get();

        // Collectes de fonds actives (6 premières)
        $activeFundraisings = Fundraising::where(function($query) {
                $query->where('is_published', true)
                      ->orWhereNull('is_published'); // Pour les anciennes collectes sans cette colonne
            })
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
            'active_contests' => Contest::where(function($query) {
                    $query->where('is_published', true)
                          ->orWhereNull('is_published');
                })
                ->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->count(),
            'active_fundraisings' => Fundraising::where(function($query) {
                    $query->where('is_published', true)
                          ->orWhereNull('is_published');
                })
                ->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->count(),
        ];

        return view('home', compact('upcomingEvents', 'popularEvents', 'activeContests', 'activeFundraisings', 'stats'));
    }
}

