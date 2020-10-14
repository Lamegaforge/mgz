<?php

namespace App\Services;

use App\Managers\Twitch\TwitchManager;
use Illuminate\Database\Eloquent\Collection;

class VideoService
{
    protected $twitchManager;

    public function __construct(TwitchManager $twitchManager)
    {
        $this->twitchManager = $twitchManager;
    }

    public function getLastGames(): array
    {
        $videos = $this->aggregateVideos();

        return (new Collection($videos))
            ->flatten($depth = 1)
            ->map(function ($video) {
                return $video['game'];
            })
            ->filter(function ($game) {
                return $game;
            })
            ->unique()
            ->values()
            ->toArray();
    }

    protected function aggregateVideos(): array
    {
        $offsets = [0, 100, 200];

        return array_map(function ($offset) {
            return $this->twitchManager->driver('api')->getLastVideos($limit = 100, $offset);
        }, $offsets);
    }
}
