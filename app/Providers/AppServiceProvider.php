<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use App\Models\Payment;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\Ticket;
use App\Observers\PaymentObserver;
use App\Observers\UserObserver;
use App\Observers\WithdrawalObserver;
use App\Observers\TicketObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        // Configurer Carbon pour utiliser le français
        \Carbon\Carbon::setLocale('fr');
        
        // Charger les helpers
        require_once app_path('Helpers/PlatformHelper.php');

        // Enregistrer les observers
        Payment::observe(PaymentObserver::class);
        User::observe(UserObserver::class);
        Withdrawal::observe(WithdrawalObserver::class);
        Ticket::observe(TicketObserver::class);
    }
}

