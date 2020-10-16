<?php

namespace App\Managers\Twitch\Drivers;

use TwitchApi\TwitchApi;
use Illuminate\Support\Collection;
use App\Managers\Twitch\Contracts\Driver;

class Api implements Driver
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getLastClips(): array
    {
        $client = $this->getClient();

        $parameters = [
            $this->config['channel'],
            $cursor = null,
            $game = null,
            $limit = 100,
            $period = 'all',
        ];

        $response = $client->getTopClips(... $parameters);

        return $response['clips'];
    }

    public function getLastVideos(int $limit = 100, int $offset = 0): array
    {
        $client = $this->getClient();

        $parameters = [
            $this->config['channel_id'],
            $limit,
            $offset,
            $broadcastType = 'highlight',
            $language = null,
            $sort = 'time',
        ];

        $response = $client->getChannelVideos(... $parameters);

        return $response['videos'];
    }

    public function get(string $slug): array
    {
        $client = $this->getClient();

        $response = $client->getClip($slug);

        return $response;
    }    

    protected function getClient(): TwitchApi
    {
        $options = [
            'client_id' => $this->config['client_id'],
        ];

        return new TwitchApi($options);
    }
}
