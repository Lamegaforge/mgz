<?php

namespace App\Services\Achievements;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Contracts\Achievement;

class FiveActiveClips extends Achievements implements Achievement 
{
    use Traits\ActiveClips;

    protected const THRESHOLD = 5;

    protected $slug = 'five_active_clips';
}