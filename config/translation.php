<?php

return [
    'generator' => [
        'patterns' => [
            'app' => '/^.+\.php$/i',
            'resources' => '/^.+\.(?:php|vue|js)$/i',
        ]
    ],
    'lokalise' => [
        'apiToken' => env('LOKALISE_API_TOKEN', null),
        'projectId' => '',
        'downloadOptions' => []
    ]
];