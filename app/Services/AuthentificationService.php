<?php

namespace App\Services;

use Event;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Events\UserHasJustBeenCreated;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class AuthentificationService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserByResource(ResourceOwnerInterface $resourceOwner): User
    {
        $concret = $resourceOwner->toArray();

        $user = $this->userRepository->findByField('tracking_id', $concret['id']);

        if ($user->isNotEmpty()) {
            return $user->first();
        }
        
        return $this->createUser($concret);
    }

    protected function createUser(array $concret): User
    {
        $attributes = [
            'tracking_id' => $concret['id'],
            'login' => $concret['login'],
            'display_name' => $concret['display_name'],
            'profile_image_url' => $concret['profile_image_url'],
            'email' => $concret['email'],
        ];

        $user = $this->userRepository->create($attributes);

        Event::dispatch(new UserHasJustBeenCreated($user));

        return $user;
    }
}
