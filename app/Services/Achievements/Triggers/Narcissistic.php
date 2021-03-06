<?php

namespace App\Services\Achievements\Triggers;

use App\Services\CounterService;
use App\Services\Achievements\Contracts\Trigger;

class Narcissistic extends Triggers implements Trigger 
{
    protected $slug = 'narcissistic';

    public function eligible(): bool
    {
        $count = app(CounterService::class)->count($this->user, 'see_own_account');

        return $count >= 30;
    }
}
