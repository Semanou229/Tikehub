<?php

return [
    'api_key' => env('MONEROO_API_KEY'),
    'api_secret' => env('MONEROO_API_SECRET'),
    'webhook_secret' => env('MONEROO_WEBHOOK_SECRET'),
    'mode' => env('MONEROO_MODE', 'sandbox'),
    'base_url' => env('MONEROO_MODE') === 'production' 
        ? 'https://api.moneroo.com/v1' 
        : 'https://api-sandbox.moneroo.com/v1',
];

