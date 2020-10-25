<?php

namespace App\Services\Achievements;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Contracts\Achievement;

class TwentyActiveClips extends Achievements implements Achievement 
{
    use Traits\ActiveClips;

    protected const THRESHOLD = 20;

    protected $slug = 'twenty_active_clips';
}