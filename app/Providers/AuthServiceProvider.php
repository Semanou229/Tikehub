<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Event::class => \App\Policies\EventPolicy::class,
        \App\Models\Contest::class => \App\Policies\ContestPolicy::class,
        \App\Models\Fundraising::class => \App\Policies\FundraisingPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}

