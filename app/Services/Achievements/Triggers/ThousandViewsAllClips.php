<?php

namespace App\Services\Achievements\Triggers;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Contracts\Trigger;

class ThousandViewsAllClips extends Triggers implements Trigger 
{
    use Traits\ClipsViews;

    protected const THRESHOLD = 1000;

    protected $slug = 'thousand_views_all_clips';
}
