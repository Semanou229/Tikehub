<?php

return [
    'commission_rate' => env('PLATFORM_COMMISSION', 5),
    'subdomain_pattern' => env('APP_SUBDOMAIN_PATTERN', 'ev-{slug}.tikehub.com'),
    'kyc_required' => true,
    'max_votes_per_user' => 100,
    'max_votes_per_ip' => 1000,
    'vote_cooldown_minutes' => 1,
];


