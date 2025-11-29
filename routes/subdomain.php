<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Subdomain\EventSubdomainController;
use App\Http\Controllers\Subdomain\ContestSubdomainController;
use App\Http\Controllers\Subdomain\FundraisingSubdomainController;

/*
|--------------------------------------------------------------------------
| Routes pour les sous-domaines
|--------------------------------------------------------------------------
|
| Ces routes sont chargées pour les sous-domaines personnalisés
| Exemple: misstogo2025.tikehub.com
|
*/

Route::domain('{subdomain}.' . parse_url(config('app.url'), PHP_URL_HOST))
    ->group(function () {
        // Route pour les événements
        Route::get('/', function ($subdomain) {
            // Essayer de trouver un événement, concours ou collecte avec ce sous-domaine
            $event = \App\Models\Event::where('subdomain', $subdomain)
                ->where('subdomain_enabled', true)
                ->where('is_published', true)
                ->first();
            
            if ($event) {
                return app(EventSubdomainController::class)->show(request(), $subdomain);
            }
            
            $contest = \App\Models\Contest::where('subdomain', $subdomain)
                ->where('subdomain_enabled', true)
                ->where('is_published', true)
                ->first();
            
            if ($contest) {
                return app(ContestSubdomainController::class)->show(request(), $subdomain);
            }
            
            $fundraising = \App\Models\Fundraising::where('subdomain', $subdomain)
                ->where('subdomain_enabled', true)
                ->where('is_published', true)
                ->first();
            
            if ($fundraising) {
                return app(FundraisingSubdomainController::class)->show(request(), $subdomain);
            }
            
            abort(404, 'Sous-domaine non trouvé');
        })->name('subdomain.show');
    });
