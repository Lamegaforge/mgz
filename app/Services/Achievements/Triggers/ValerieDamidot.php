<?php

namespace App\Services\Achievements\Triggers;

use App\Services\CounterService;
use App\Services\Achievements\Contracts\Trigger;

class ValerieDamidot extends Triggers implements Trigger 
{
    protected $slug = 'valerie_damidot';

    public function eligible(): bool
    {
    	$count = app(CounterService::class)->count($this->user, 'banner');

        return $count >= 5;
    }
}