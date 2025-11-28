<?php

namespace App\Http\Controllers;

use App\Models\Event;
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

        // Statistiques
        $stats = [
            'total_events' => Event::where('is_published', true)->where('status', 'published')->count(),
            'upcoming_events' => Event::where('is_published', true)
                ->where('status', 'published')
                ->where('start_date', '>=', now())
                ->count(),
        ];

        return view('home', compact('upcomingEvents', 'popularEvents', 'stats'));
    }
}

