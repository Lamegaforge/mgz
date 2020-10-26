<?php

namespace App\Services\Achievements\Triggers;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Contracts\Trigger;

class TwentyActiveClips extends Triggers implements Trigger 
{
    use Traits\ActiveClips;

    protected const THRESHOLD = 20;

    protected $slug = 'twenty_active_clips';
}