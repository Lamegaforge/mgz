<?php

namespace App\Services\Achievements\Triggers;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Contracts\Trigger;

class FifteenActiveClips extends Triggers implements Trigger 
{
    use Traits\ActiveClips;

    protected const THRESHOLD = 15;

    protected $slug = 'fifteen_active_clips';
}