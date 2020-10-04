<?php

namespace App\Managers\Twitch;

use Illuminate\Support\Manager;
use App\Managers\Twitch\Contracts\Former;
use App\Managers\Twitch\Contracts\Driver;

class TwitchManager extends Manager
{
    public function createApiDriver()
    {
        $config = $this->app['config']['manager']['twitch']['drivers']['api'];

        $driver = new Drivers\Api($config);
        $former = new Formers\Api();

        return $this->getRepository($driver, $former);
    }
   
    public function getRepository(Driver $driver, Former $former)
    {
        return new Repository($driver, $former);
    }

    public function getDefaultDriver()
    {
        return $this->app['config']['manager']['twitch']['default_driver'];
    }
}
