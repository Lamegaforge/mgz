<?php

namespace App\Services\Achievements\Triggers;

use App\Services\CounterService;
use App\Services\Achievements\Contracts\Trigger;

class Random extends Triggers implements Trigger 
{
    protected $slug = 'random';

    public function eligible(): bool
    {
        $count = app(CounterService::class)->count($this->user, 'random');

        return $count >= 500;

    }
}