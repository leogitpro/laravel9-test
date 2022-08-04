<?php

return [
    'github' => [
        'client_id' => env('OAUTH_GITHUB_CLIENT_ID'),
        'client_secret' => env('OAUTH_GITHUB_CLIENT_SECRET'),
        'url_authorize' => env('OAUTH_GITHUB_URL_AUTHORIZE'),
        'url_accesstoken' => env('OAUTH_GITHUB_URL_ACCESSTOKEN'),
        'url_userprofile' => env('OAUTH_GITHUB_URL_USERPROFILE'),
    ],
    'ukr' => [
        'client_id' => env('OAUTH_UKR_CLIENT_ID'),
        'client_secret' => env('OAUTH_UKR_CLIENT_SECRET'),
        'url_authorize' => env('OAUTH_UKR_URL_AUTHORIZE'),
        'url_accesstoken' => env('OAUTH_UKR_URL_ACCESSTOKEN'),
        'url_userprofile' => env('OAUTH_UKR_URL_USERPROFILE'),
    ],
];
