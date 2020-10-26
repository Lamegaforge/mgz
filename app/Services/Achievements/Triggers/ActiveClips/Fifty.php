<?php

namespace App\Services\Achievements\Triggers\ActiveClips;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Triggers\Triggers;
use App\Services\Achievements\Contracts\Trigger;

class Fifty extends Triggers implements Trigger 
{
    use Traits\ActiveClips;

    protected const THRESHOLD = 50;

    protected $slug = 'fifty_active_clips';
}