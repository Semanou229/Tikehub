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

    'publicKey' => env('MONEROO_PUBLIC_KEY'),
    'secretKey' => env('MONEROO_SECRET_KEY'),
    'webhook_secret' => env('MONEROO_WEBHOOK_SECRET'),
    
    // Anciennes clés pour compatibilité
    'public_key' => env('MONEROO_PUBLIC_KEY'),
    'secret_key' => env('MONEROO_SECRET_KEY'),
    'api_key' => env('MONEROO_PUBLIC_KEY', env('MONEROO_API_KEY')),
    'api_secret' => env('MONEROO_SECRET_KEY', env('MONEROO_API_SECRET')),
    
    'mode' => env('MONEROO_MODE', 'sandbox'),
    'devMode' => env('MONEROO_DEV_MODE', false),
    'devBaseUrl' => env('MONEROO_DEV_BASE_URL', 'https://api-sandbox.moneroo.io/v1'),
    'base_url' => env('MONEROO_MODE') === 'production' 
        ? 'https://api.moneroo.io/v1' 
        : 'https://api-sandbox.moneroo.io/v1',
];

