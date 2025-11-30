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
        
        // Événements pour le slider Hero (mélange d'événements, concours et collectes)
        $heroItems = collect();
        
        // Ajouter des événements
        foreach ($upcomingEvents->take(3) as $event) {
            $heroItems->push([
                'type' => 'event',
                'id' => $event->id,
                'title' => $event->title,
                'description' => \Illuminate\Support\Str::limit($event->description, 150),
                'image' => $event->cover_image,
                'category' => $event->category,
                'date' => $event->start_date,
                'location' => $event->venue_city,
                'url' => route('events.show', $event),
                'is_virtual' => $event->is_virtual,
                'is_free' => $event->is_free,
            ]);
        }
        
        // Ajouter des concours
        foreach ($activeContests->take(2) as $contest) {
            $heroItems->push([
                'type' => 'contest',
                'id' => $contest->id,
                'title' => $contest->name,
                'description' => \Illuminate\Support\Str::limit($contest->description, 150),
                'image' => $contest->cover_image,
                'category' => 'Concours',
                'date' => $contest->end_date,
                'location' => null,
                'url' => route('contests.show', $contest),
                'price_per_vote' => $contest->price_per_vote,
                'votes_count' => $contest->votes_count ?? 0,
            ]);
        }
        
        // Ajouter des collectes
        foreach ($activeFundraisings->take(2) as $fundraising) {
            $heroItems->push([
                'type' => 'fundraising',
                'id' => $fundraising->id,
                'title' => $fundraising->name,
                'description' => \Illuminate\Support\Str::limit($fundraising->description, 150),
                'image' => $fundraising->cover_image,
                'category' => 'Collecte',
                'date' => $fundraising->end_date,
                'location' => null,
                'url' => route('fundraisings.show', $fundraising),
                'current_amount' => $fundraising->current_amount,
                'goal_amount' => $fundraising->goal_amount,
                'progress' => $fundraising->progress_percentage,
            ]);
        }
        
        // Mélanger et prendre 6 items
        $heroItems = $heroItems->shuffle()->take(6);
        
        return view('home', compact('upcomingEvents', 'popularEvents', 'activeContests', 'activeFundraisings', 'stats', 'commissionRate', 'heroItems'));
    }
}

