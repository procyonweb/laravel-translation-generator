<?php

return [
    'generator' => [
        'patterns' => [
            'app' => '/^.+\.php$/i',
            'resources' => '/^.+\.(?:php|vue|js)$/i',
        ]
    ],
    'phrase' => [
        'apiToken' => env('PHRASE_API_TOKEN', null),
        'projectId' => '',
        'downloadOptions' => [
            'query' => [
                'include_empty_translations' => true,
                'fallback_locale_id' => 'en',
            ]
        ],
        'locales' => [
            'en',
        ]
    ]
];