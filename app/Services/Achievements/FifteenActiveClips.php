<?php

namespace App\Services\Achievements;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Contracts\Achievement;

class FifteenActiveClips extends Achievements implements Achievement 
{
    use Traits\ActiveClips;

    protected const THRESHOLD = 15;

    protected $slug = 'fifteen_active_clips';
}