<?php

namespace App\Services\Achievements;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Contracts\Achievement;

class TenActiveClips extends Achievements implements Achievement 
{
    use Traits\ActiveClips;

    protected const THRESHOLD = 10;

    protected $slug = 'ten_active_clips';
}