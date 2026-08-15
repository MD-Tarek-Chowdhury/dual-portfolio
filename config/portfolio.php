<?php

return [
    'defaults' => [
        'academic_mood' => 'day',
        'music_mood' => 'studio',
    ],

    'images' => [
        'max_size' => 2048, // 2MB in KB
        'allowed_types' => ['image/jpeg', 'image/png'],
        'hero_path' => 'images/heroes',
    ],

    'contact' => [
        'rate_limit' => 5, // attempts
        'rate_window' => 60, // seconds
    ],

    'world_map' => [
        'academic' => [
            'bio' => 'band',
            'research' => 'discography',
            'teaching' => 'courses',
            'contact' => 'contact',
        ],
        'music' => [
            'band' => 'bio',
            'discography' => 'research',
            'courses' => 'teaching',
            'contact' => 'contact',
        ],
    ],
];
