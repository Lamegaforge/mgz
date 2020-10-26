<?php

namespace App\Services\Achievements\Triggers\ActiveClips;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Triggers\Triggers;
use App\Services\Achievements\Contracts\Trigger;

class Twenty extends Triggers implements Trigger 
{
    use Traits\ActiveClips;

    protected const THRESHOLD = 20;

    protected $slug = 'twenty_active_clips';
}