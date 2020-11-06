<?php

namespace App\Services\Achievements\Triggers;

use Carbon\Carbon;
use App\Services\Achievements\Contracts\Trigger;

class OldMan extends Triggers implements Trigger 
{
    protected $slug = 'old_man';

    public function eligible(): bool
    {
        $clips = $this->user->clips();

        $threshold = Carbon::now()->subYears(3);

        $count = $clips->where('created_at', '<', $threshold)->count();

        return $count != 0;
    }
}
