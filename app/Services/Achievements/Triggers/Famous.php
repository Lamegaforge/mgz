<?php

namespace App\Services\Achievements\Triggers;

use App\Models\User;
use App\Services\Achievements\Contracts\Trigger;

class Famous extends Triggers implements Trigger 
{
    protected $slug = 'famous';

    public function eligible(): bool
    {
        $clips = $this->user->clips();

        $views = $clips->where('state', 'active')->max('views');

        return $views >= 500;
    }
}
