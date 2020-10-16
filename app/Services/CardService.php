<?php

namespace App\Services;

use App\Models\Card;
use App\Repositories\CardRepository;
use Illuminate\Database\Eloquent\Collection;

class CardService
{
    protected $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->userRepository = $cardRepository;
    }

    public function findOrCreateCard(string $game, array $attributes): Card
    {
        $user = $this->findByTracking($game);

        if ($user->isEmpty()) {

            $this->userRepository->create($attributes);

            $user = $this->findByTracking($game);
        }

        return $user->first();
    }

    protected function findByTracking(string $game): Collection
    {
        return $this->userRepository->findByField('game', $game);
    }
}