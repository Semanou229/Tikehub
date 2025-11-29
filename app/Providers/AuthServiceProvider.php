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
        \App\Models\Contact::class => \App\Policies\ContactPolicy::class,
        \App\Models\EmailCampaign::class => \App\Policies\EmailCampaignPolicy::class,
        \App\Models\Team::class => \App\Policies\TeamPolicy::class,
        \App\Models\Automation::class => \App\Policies\AutomationPolicy::class,
        \App\Models\Sponsor::class => \App\Policies\SponsorPolicy::class,
        \App\Models\CustomForm::class => \App\Policies\CustomFormPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}

