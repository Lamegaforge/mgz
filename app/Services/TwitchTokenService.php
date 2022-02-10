<?php

namespace App\Services;

use App\Dtos\BearerToken;
use Illuminate\Contracts\Cache\Repository;

class TwitchTokenService
{
    public const KEY = 'TWITCH_BEARER_TOKEN_VALUE';

    public function __construct(
        protected Repository $cache,
    ){}

    public function expired(): bool
    {
        return $this->cache->missing(self::KEY);
    }

    public function get(): BearerToken
    {
        $value = $this->cache->get(self::KEY);

        return new BearerToken(
            value: $value,
        );
    }

    public function save(BearerToken $bearerToken): void
    {
        $this->cache->put(
            self::KEY, 
            $bearerToken->value, 
            $bearerToken->expiresIn
        );
    }
}
