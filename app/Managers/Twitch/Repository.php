<?php

namespace App\Managers\Twitch;

use App\Managers\Twitch\Contracts\Driver;
use App\Managers\Twitch\Contracts\Former;

use Http;
use App\Dtos\BearerToken;

class Repository
{
    protected $driver;
    protected $former;

    public function __construct(Driver $driver, Former $former)
    {
        $this->driver = $driver;
        $this->former = $former;
    }

    public function getBearerToken(): BearerToken
    {
        return $this->driver->getBearerToken();
    }

    public function getLastClips(string $period, ?string $cursor = null): array
    {
        $clips = $this->driver->getLastClips($period, $cursor);

        return $this->former->clips($clips);
    }

    public function getLastVideos(int $limit = 100, int $offset = 0): array
    {
        $videos = $this->driver->getLastVideos($limit, $offset);

        return $this->former->videos($videos);
    }

    public function getVideo(int $id): array
    {
        $video = $this->driver->getVideo($id);

        return $this->former->video($video);
    }

    public function getTopGames(int $limit = 100, int $offset = 0): array
    {
        $games = $this->driver->getTopGames($limit, $offset);

        return $this->former->games($games);
    }

    public function get(string $slug): array
    {
        $clip = $this->driver->get($slug);

        return $this->former->clip($clip);
    }    
}
