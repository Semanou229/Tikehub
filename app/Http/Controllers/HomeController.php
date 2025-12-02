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
        
        // Créer une collection pour le slider Hero qui alterne entre événements, concours et collectes
        $heroSliderItems = collect();
        
        // Préparer les collections avec tous les éléments disponibles
        $eventsForSlider = $upcomingEvents->map(function ($event) {
            return [
                'type' => 'event',
                'id' => $event->id,
                'title' => $event->title,
                'date' => $event->start_date,
                'location' => $event->venue_city,
                'image' => $event->cover_image,
                'url' => route('events.show', $event),
            ];
        })->values();
        
        $contestsForSlider = $activeContests->map(function ($contest) {
            return [
                'type' => 'contest',
                'id' => $contest->id,
                'title' => $contest->name,
                'date' => $contest->end_date,
                'location' => null,
                'image' => $contest->cover_image,
                'url' => route('contests.show', $contest),
                'price_per_vote' => $contest->price_per_vote,
            ];
        })->values();
        
        $fundraisingsForSlider = $activeFundraisings->map(function ($fundraising) {
            return [
                'type' => 'fundraising',
                'id' => $fundraising->id,
                'title' => $fundraising->name,
                'date' => $fundraising->end_date,
                'location' => null,
                'image' => $fundraising->cover_image,
                'url' => route('fundraisings.show', $fundraising),
                'progress' => $fundraising->progress_percentage,
            ];
        })->values();
        
        // Alterner entre les types : événement, concours, collecte, événement, etc.
        $maxItems = max($eventsForSlider->count(), $contestsForSlider->count(), $fundraisingsForSlider->count());
        
        for ($i = 0; $i < $maxItems; $i++) {
            // Ajouter un événement
            if (isset($eventsForSlider[$i])) {
                $heroSliderItems->push($eventsForSlider[$i]);
            }
            
            // Ajouter un concours
            if (isset($contestsForSlider[$i])) {
                $heroSliderItems->push($contestsForSlider[$i]);
            }
            
            // Ajouter une collecte
            if (isset($fundraisingsForSlider[$i])) {
                $heroSliderItems->push($fundraisingsForSlider[$i]);
            }
        }
        
        // Limiter à 12 items maximum pour éviter un slider trop long
        $heroSliderItems = $heroSliderItems->take(12);
        
        return view('home', compact('upcomingEvents', 'popularEvents', 'activeContests', 'activeFundraisings', 'stats', 'commissionRate', 'heroSliderItems'));
    }
}

