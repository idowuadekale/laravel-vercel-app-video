<?php

return [
    'name' => 'My Lite App',
    'short_name' => 'LiteApp',
    'start_url' => '/',
    'display' => 'standalone',
    'background_color' => '#ffffff',
    'theme_color' => '#ffffff',
    'orientation' => 'portrait',
    'status_bar' => 'black',

    'icons' => [
        [
            'src' => '/assets/img/iconp.png',
            'sizes' => '192x192',
            'type' => 'image/png',
        ],
        [
            'src' => '/assets/img/favicon.png',
            'sizes' => '512x512',
            'type' => 'image/png',
        ],
    ],
];
