<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function firstOrCreate($trackingId, array $attributes): User
    {
        $user = $this->userRepository->findByField('tracking_id', $trackingId);

        if ($user->isEmpty()) {
            $user = $this->userRepository->create($attributes);
        }

        return $user->first();
    }
}