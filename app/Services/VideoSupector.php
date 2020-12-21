<?php

namespace App\Services;

use App\Managers\Twitch\TwitchManager;

class VideoSupector
{
    protected $twitchManager;
    protected $videos;

    public function __construct(TwitchManager $twitchManager)
    {
        $this->twitchManager = $twitchManager;
        $this->videos = [];
    }

    public function isClean(array $clip): bool
    {
        $video = $this->retrieveVideo($clip['vod']['id']);

        return $video['title'] !== $clip['title'];
    }

    protected function retrieveVideo(int $id)
    {
        $video = $this->videos[$id] ?? null;

        if (! $video) {

            $video = $this->twitchManager->getVideo($id);

            $this->videos[$id] = $video;
        }

        return $video;
    }
}
