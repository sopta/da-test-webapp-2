<?php

declare(strict_types=1);

return [
    'mode'                  => 'utf-8',
    'format'                => 'A4',
    'author'                => 'Czechitas',
    'subject'               => '',
    'keywords'              => '',
    'creator'               => 'Czechitas',
    'display_mode'          => 'fullpage',
    'tempDir'               => storage_path('framework/cache/pdf'),

    'dpi'                   => 96,
    'img_dpi'               => 300,

    'font_path' => resource_path('assets/fonts/'), // don't forget the trailing slash!
    'font_data' => [
        'montserrat' => [
            'R' => 'Montserrat-Regular.ttf',
            'B' => 'Montserrat-SemiBold.ttf',
        ],
    ],
];
