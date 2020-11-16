<?php

namespace App\Services\Achievements\Triggers;

use App\Services\CounterService;
use App\Services\Achievements\Contracts\Trigger;

class Stalker extends Triggers implements Trigger 
{
    protected $slug = 'stalker';

    public function eligible(): bool
    {
        $count = app(CounterService::class)->count($this->user, 'see_another_account');

        return $count >= 100;
    }
}
