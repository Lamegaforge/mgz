<?php

namespace App\Services\Achievements\Triggers;

use App\Models\User;
use App\Services\Achievements\Contracts\Trigger;

class Unloved extends Triggers implements Trigger 
{
    protected $slug = 'unloved';

    public function eligible(): bool
    {
        $clips = $this->user->clips();

        $count = $clips->where('state', 'rejected')->count();

        return $count >= 20;
    }
}
