<?php

namespace App\Services\Achievements\Triggers;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Triggers\Triggers;
use App\Services\Achievements\Contracts\Trigger;

class FiveActiveClips extends Triggers implements Trigger 
{
    use Traits\ActiveClips;

    protected const THRESHOLD = 5;

    protected $slug = 'five_active_clips';
}