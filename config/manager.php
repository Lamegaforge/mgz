<?php

return [
    'twitch' => [
        'default_driver' => 'api',
        'drivers' => [
            'api' => [
                'client_id' => env('HELIX_CLIENT_ID'),
                'channel' => env('TWITCH_CHANNEL_NAME', 'lamegaforgelive'),
                'channel_id' => env('TWITCH_CHANNEL_ID', '50119422'),
            ],
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
