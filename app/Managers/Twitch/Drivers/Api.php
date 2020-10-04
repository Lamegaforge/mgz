<?php

namespace App\Managers\Twitch\Drivers;

use TwitchApi\TwitchApi;
use App\Managers\Twitch\Contracts\Driver;

class Api implements Driver
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getLastClips() :array
    {
        $client = $this->getClient();

        $response = $client->getTopClips($this->config['channel'], $cursor = null, $game = null, $limit = 50, $period = 'week');

        return $response['clips'];
    }

    public function get(string $slug) :array
    {
        $client = $this->getClient();

        $response = $client->getClip($slug);

        return $response;
    }    

    protected function getClient() :TwitchApi
    {
        $options = [
            'client_id' => $this->config['client_id'],
        ];

        return new TwitchApi($options);
    }
}
