<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function firstOrCreate($trackingId, array $attributes): User
    {
        $user = $this->findByTracking($trackingId);

        if ($user->isEmpty()) {

            $this->userRepository->create($attributes);

            $user = $this->findByTracking($trackingId);
        }

        return $user->first();
    }

    protected function findByTracking(string $trackingId): Collection
    {
        return $this->userRepository->findByField('tracking_id', $trackingId);
    }
}