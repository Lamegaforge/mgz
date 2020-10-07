<?php

namespace App\Managers\Twitch;

use Config;
use DeGraciaMathieu\Manager\Manager;
use App\Managers\Twitch\Contracts\Former;
use App\Managers\Twitch\Contracts\Driver;

class TwitchManager extends Manager
{
    public function createApiDriver()
    {
        $config = Config::get('manager.twitch.drivers.api');

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
        return Config::get('manager.twitch.default_driver');
    }
}
