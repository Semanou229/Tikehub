<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Moneroo Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour l'intégration avec Moneroo Payment Orchestration.
    | Les clés peuvent être obtenues depuis votre dashboard Moneroo.
    |
    */

    'public_key' => env('MONEROO_PUBLIC_KEY'),
    'secret_key' => env('MONEROO_SECRET_KEY'),
    'webhook_secret' => env('MONEROO_WEBHOOK_SECRET'),
    
    // Anciennes clés pour compatibilité
    'api_key' => env('MONEROO_PUBLIC_KEY', env('MONEROO_API_KEY')),
    'api_secret' => env('MONEROO_SECRET_KEY', env('MONEROO_API_SECRET')),
    
    'mode' => env('MONEROO_MODE', 'sandbox'),
    'base_url' => env('MONEROO_MODE') === 'production' 
        ? 'https://api.moneroo.com/v1' 
        : 'https://api-sandbox.moneroo.com/v1',
];

