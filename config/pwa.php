<?php 
return [
    'name' => 'MediaRent',
    'short_name' => 'MediaRent',
    'start_url' => '/',
    'background_color' => '#ffffff',
    'theme_color' => '#000000', // Changed to black for better contrast
    'display' => 'standalone',
    'orientation' => 'portrait', // Changed to portrait (better for media apps)
    'icons' => [
        '72x72' => [
            'path' => '/pwa-icons/icon-72x72.png',
            'purpose' => 'any'
        ],
        '96x96' => [
            'path' => '/pwa-icons/icon-96x96.png',
            'purpose' => 'any'
        ],
        '128x128' => [
            'path' => '/pwa-icons/icon-128x128.png',
            'purpose' => 'any'
        ],
        '144x144' => [
            'path' => '/pwa-icons/icon-144x144.png',
            'purpose' => 'any'
        ],
        '152x152' => [
            'path' => '/pwa-icons/icon-152x152.png',
            'purpose' => 'any'
        ],
        '192x192' => [
            'path' => '/pwa-icons/icon-192x192.png',
            'purpose' => 'any'
        ],
        '384x384' => [
            'path' => '/pwa-icons/icon-384x384.png',
            'purpose' => 'any'
        ],
        '512x512' => [
            'path' => '/pwa-icons/icon-512x512.png',
            'purpose' => 'any'
        ],
    ],
    'offline' => [
        'page' => '/offline' // Matches the route we created
    ],
    // Additional recommended settings for media apps
    'prefer_related_applications' => false,
    'description' => 'Your media rental platform',
    'categories' => ['entertainment', 'media', 'rental'],
    'screenshots' => [
        [
            'src' => '/pwa-screenshots/screenshot1.png',
            'sizes' => '1280x720',
            'type' => 'image/png'
        ]
    ]
];