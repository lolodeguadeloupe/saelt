<?php

return [
    'api_key' => env('alma_key', 'sk_test_7Yk9wFaDcucUIcQ84OGuQx19'),
    'base_url' => env('alma_base_url', 'https://api.sandbox.getalma.eu'),
    'version' => env('alma_api_ver', 'v1'),
    'auth' => env('alma_auth', 'Alma-Auth'),
    /** */
    'uri' => [
        'payment' => [
            'create' => 'payments'
        ]
    ],
];
