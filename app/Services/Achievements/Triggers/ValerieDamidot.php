<?php

namespace App\Services\Achievements\Triggers;

use App\Services\Achievements\Contracts\Trigger;

class ValerieDamidot extends Triggers implements Trigger 
{
    protected $slug = 'valerie_damidot';

    public function eligible(): bool
    {
        return false;
    }
}