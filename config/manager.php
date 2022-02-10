<?php

return [
    'twitch' => [
        'default_driver' => 'rawapi',
        'drivers' => [
            'api' => [
                'client_id' => env('HELIX_CLIENT_ID'),
                'channel' => env('TWITCH_CHANNEL_NAME', 'lamegaforgelive'),
                'channel_id' => env('TWITCH_CHANNEL_ID', '50119422'),
            ],
            'rawapi' => [
                'client_id' => env('TWITCH_RAWAPI_CLIENT_ID'),
                'client_secret' => env('TWITCH_RAWAPI_CLIENT_SECRET'),
                'endpoints' => [
                    'oauth2' => 'https://id.twitch.tv/oauth2/token',
                    'user' => 'https://api.twitch.tv/helix/users',
                    'clips' => 'https://api.twitch.tv/kraken/clips/top',
                ],
            ]
        ],
    ],
    'oauth' => [
        'default_driver' => 'vertisan',
        'drivers' => [
            'helix' => [
                'client_id' => env('HELIX_CLIENT_ID'),
                'client_secret' => env('HELIX_CLIENT_SECRET'),
                'redirect_uri' => env('HELIX_REDIRECT_URI'),
                'url_authorize' => 'https://id.twitch.tv/oauth2/authorize',
                'url_access_token' => 'https://id.twitch.tv/oauth2/token',
                'url_resource_owner_details' => 'https://api.twitch.tv/helix/users',
            ],
            'vertisan' => [
                'client_id' => env('HELIX_CLIENT_ID'),
                'client_secret' => env('HELIX_CLIENT_SECRET'),
                'redirect_uri' => env('HELIX_REDIRECT_URI'),
            ],
        ],
    ],
];
