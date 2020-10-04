<?php

namespace App\Managers\Oauth;

use Config;
use DeGraciaMathieu\Manager\Manager;
use App\Managers\Oauth\Contracts\Driver;

class OauthManager extends Manager
{
    public function createHelixDriver()
    {
        $config = Config::get('manager.oauth.drivers.helix');

        $driver = new Drivers\Helix($config);

        return $this->getRepository($driver);
    }

    public function createVertisanDriver()
    {
        $config = Config::get('manager.oauth.drivers.vertisan');

        $driver = new Drivers\Vertisan($config);

        return $this->getRepository($driver);
    }
   
    public function getRepository(Driver $driver)
    {
        return new Repository($driver);
    }

    public function getDefaultDriver()
    {
        return Config::get('manager.oauth.default_driver');
    }
}
