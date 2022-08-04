<?php

return [
    'github' => [
        'client_id' => '',
        'client_secret' => '',
        'url_authorize' => env('OAUTH_GITHUB_URL_AUTHORIZE'),
        'url_accesstoken' => env('OAUTH_GITHUB_URL_ACCESSTOKEN'),
        'url_userprofile' => env('OAUTH_GITHUB_URL_USERPROFILE'),
    ],
];
