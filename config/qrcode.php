<?php

return [
    'secret_key' => env('QR_CODE_SECRET_KEY', env('APP_KEY')),
    'ttl' => env('QR_CODE_TTL', 3600),
    'size' => 300,
    'margin' => 2,
    'format' => 'png',
];


