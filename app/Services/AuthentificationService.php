<?php

namespace App\Services;

use Event;
use App\Models\User;
use App\Services\UserService;
use App\Repositories\UserRepository;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class AuthentificationService
{
    protected $userService;
    protected $userRepository;

    public function __construct(UserService $userService, UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    public function getUser(array $attributes): User
    {
        $user = $this->userService->findOrCreateUser($attributes['tracking_id'], $attributes);

        $this->update($user, $attributes);

        $user->refresh();

        return $user;
    }

    protected function update(User $user, array $attributes): void
    {
        $updateableAttributes = [
            'display_name' => $attributes['display_name'],
            'profile_image_url' => $attributes['profile_image_url'],
            'email' => $attributes['email'],
        ];

        $this->userRepository->update($updateableAttributes, $user->id);
    }
}
