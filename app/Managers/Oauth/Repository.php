<?php

namespace App\Managers\Oauth;

use App\Managers\Oauth\Contracts\Driver;

class Repository
{
    protected $driver;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    public function checkAuthorizationToken(string $token)
    {
        $this->driver->checkAuthorizationToken($token);
    }

    public function getAuthorizationUrl(): string
    {
        return $this->driver->getAuthorizationUrl();
    }

    public function consume(string $code): array
    {
        return $this->driver->consume($code);
    }
}
