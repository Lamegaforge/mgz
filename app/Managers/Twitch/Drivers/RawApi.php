<?php

namespace App\Managers\Twitch\Drivers;

use Http;
use App\Dtos\BearerToken;
use App\Services\TwitchTokenService;
use App\Managers\Twitch\Contracts\Driver;
use Illuminate\Http\Client\PendingRequest;

class RawApi implements Driver
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getBearerToken(): BearerToken
    {
        $url = $this->config['endpoints']['oauth2'] 
            . '?client_id=' . $this->config['client_id']
            . '&client_secret=' . $this->config['client_secret']
            . '&grant_type=client_credentials';

        $response = Http::post($url);

        $attributes = $response->json();

        return new BearerToken(
            value: $attributes['access_token'],
            expiresIn: $attributes['expires_in'],
        );
    }

    public function getLastClips(string $period, ?string $cursor = null): array
    {
        // $url = $this->config['endpoints']['clips'] 
            // . '?channel=' . 'lamegaforgelive'
            // . '&period=' . $period
            // . '&cursor=' . $cursor;

        // $attributes = $this->callClient($url);
    }

    public function getLastVideos(int $limit = 100, int $offset = 0): array
    {
        //
    }

    public function getTopGames(int $limit = 100, int $offset = 0): array
    {
        //
    }

    public function getVideo(int $id): array
    {
        //
    }

     protected function callClient(string $url): array
    {
        $client = $this->getClient();

        $response = $client->get($url);

        return $response->json();
    }

    protected function getClient(): PendingRequest
    {
        $headers = [
            'Client-Id' => $this->config['client_id'],
        ];

        $bearerToken = app(TwitchTokenService::class)->get();

        return Http::withToken($bearerToken->value)
            ->withHeaders($headers);
    }
}
