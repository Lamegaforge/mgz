<?php

namespace App\Managers\Oauth\Drivers;

use App\Managers\Oauth\Contracts\Driver;

class Mock implements Driver
{
    public function checkAuthorizationToken(string $token): void
    {
        //
    }

    public function getAuthorizationUrl(): string
    {
        return '';
    }

    public function consume(string $code): array
    {
        return [
            'tracking_id' => 'id',
            'login' => 'login',
            'display_name' => 'display_name',
            'profile_image_url' => 'profile_image_url',
            'email' => 'email',
        ];
    }
}
