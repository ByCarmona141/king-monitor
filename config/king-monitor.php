<?php

return [
    'users' => [
        'user_errors_limit' => env('USER_ERRORS_LIMIT', 3),
        'user_request_limit' => env('USER_REQUEST_LIMIT', 1000),
    ],
    
    'tokens' => [
        'token_errors_limit' => env('TOKEN_ERRORS_LIMIT', 3),
        'token_request_limit' => env('TOKEN_REQUEST_LIMIT', 1000),
    ],

    'alerts' => [
        'monitor_alert' => env('MONITOR_ALERT', true),
        'user_between_alert' => env('USER_BETWEEN_ALERT', 3600),
        'emails' => [
            'to' => [],
            'from' => env('MAIL_FROM_ADDRESS'),
        ],
    ],

    'monitor' => [
        'use_resource' => env('USE_RESOURCE', false),
        'endpoint_statistics' => [],
        'endpoint_protected' => []
    ],
];
