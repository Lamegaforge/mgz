<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Managers\Twitch\TwitchManager;

class GameService
{
    protected $twitchManager;

    public function __construct(TwitchManager $twitchManager)
    {
        $this->twitchManager = $twitchManager;
    }

    public function get(): Collection
    {
        $games = $this->aggregateGames();

        return (new Collection($games))->flatten($depth = 1);
    }

    protected function aggregateGames(): array
    {
        return array_map(function ($offset) {
            return $this->twitchManager->getTopGames($limit = 100, $offset);
        }, range(0, 5000, 100));
    }
}
