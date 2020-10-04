<?php

namespace App\Managers\Twitch;

use App\Managers\Twitch\Contracts\Driver;
use App\Managers\Twitch\Contracts\Former;

class Repository
{
    protected $driver;
    protected $former;

    public function __construct(Driver $driver, Former $former)
    {
        $this->driver = $driver;
        $this->former = $former;
    }

    public function getLastClips() :array
    {
        $clips = $this->driver->getLastClips();

        return $this->former->clips($clips);
    }

    public function get(string $slug) :array
    {
        $clip = $this->driver->get($slug);

        return $this->former->clip($clip);
    }    
}
