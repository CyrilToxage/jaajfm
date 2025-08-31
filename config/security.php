<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Headers
    |--------------------------------------------------------------------------
    |
    | Headers de sécurité à ajouter aux réponses JSON
    |
    */
    'json_headers' => [
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options' => 'DENY',
        'X-XSS-Protection' => '1; mode=block',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sensitive Routes
    |--------------------------------------------------------------------------
    |
    | Routes sensibles qui ne doivent pas être mises en cache
    |
    */
    'sensitive_routes' => [
        '*/analytics/*',
        '*/user/*',
        '*/profile/*',
        '*/admin/*',
        '*/music/*/like',
        '*/music/*/view',
        '*/playlists/*',
        '*/posts/*',
        '*/comments/*',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Limites de taux pour les API
    |
    */
    'rate_limits' => [
        'api' => [
            'max_attempts' => 60,
            'decay_minutes' => 1,
        ],
        'auth' => [
            'max_attempts' => 5,
            'decay_minutes' => 15,
        ],
    ],
];
