<?php

namespace App\Services;

use Event;
use App\Models\User;
use App\Services\UserService;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class AuthentificationService
{
    public function getUserByResource(ResourceOwnerInterface $resourceOwner): User
    {
        $concret = $resourceOwner->toArray();

        $attributes = [
            'tracking_id' => $concret['id'],
            'login' => $concret['login'],
            'display_name' => $concret['display_name'],
            'profile_image_url' => $concret['profile_image_url'],
            'email' => $concret['email'],
        ];

        return app(UserService::class)->firstOrCreate($concret['id'], $attributes);
    }
}
