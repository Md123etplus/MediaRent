<?php

return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [ 
            'driver' => 'session',
            'provider' => 'admin',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admin' => [ 
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],

        'admin' => [ 
            'provider' => 'admin',
            'table' => 'admin_password_reset_tokens',
            'expire' => 30,  
            'throttle' => 120,
        ],
    ],

    'basic' => [
        'username' => env('BASIC_AUTH_USER', 'admin'),
        'password_hash' => env('BASIC_AUTH_PASSWORD_HASH'),
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];