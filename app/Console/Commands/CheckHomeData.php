<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Contest;
use App\Models\Fundraising;

class CheckHomeData extends Command
{
    protected $signature = 'check:home-data';
    protected $description = 'Vérifier les données disponibles pour la page d\'accueil';

    public function handle()
    {
        $this->info('=== Vérification des données pour la page d\'accueil ===');
        
        // Événements
        $totalEvents = Event::count();
        $publishedEvents = Event::where('is_published', true)->where('status', 'published')->count();
        $upcomingEvents = Event::where('is_published', true)
            ->where('status', 'published')
            ->where('start_date', '>=', now())
            ->count();
        
        $this->info("Événements:");
        $this->line("  - Total: {$totalEvents}");
        $this->line("  - Publiés: {$publishedEvents}");
        $this->line("  - À venir: {$upcomingEvents}");
        
        // Concours
        $totalContests = Contest::count();
        $publishedContests = Contest::where('is_published', true)->count();
        $activeContests = Contest::where('is_published', true)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->count();
        
        $this->info("Concours:");
        $this->line("  - Total: {$totalContests}");
        $this->line("  - Publiés: {$publishedContests}");
        $this->line("  - Actifs: {$activeContests}");
        
        // Collectes
        $totalFundraisings = Fundraising::count();
        $publishedFundraisings = Fundraising::where('is_published', true)->count();
        $activeFundraisings = Fundraising::where('is_published', true)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->count();
        
        $this->info("Collectes de fonds:");
        $this->line("  - Total: {$totalFundraisings}");
        $this->line("  - Publiées: {$publishedFundraisings}");
        $this->line("  - Actives: {$activeFundraisings}");
        
        return 0;
    }
}

