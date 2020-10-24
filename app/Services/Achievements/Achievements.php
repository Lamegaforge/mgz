<?php

namespace App\Services\Achievements;

abstract class Achievements 
{
    protected $slug;

    public function slug(): string
    {
        return $this->slug;
    }
}