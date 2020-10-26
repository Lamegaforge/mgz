<?php

namespace App\Services\Achievements\Triggers;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Contracts\Trigger;

class TenActiveClips extends Triggers implements Trigger 
{
    use Traits\ActiveClips;

    protected const THRESHOLD = 10;

    protected $slug = 'ten_active_clips';
}