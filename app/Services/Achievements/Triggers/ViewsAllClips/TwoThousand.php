<?php

namespace App\Services\Achievements\Triggers\ViewsAllClips;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Triggers\Triggers;
use App\Services\Achievements\Contracts\Trigger;

class TwoThousand extends Triggers implements Trigger 
{
    use Traits\ClipsViews;

    protected const THRESHOLD = 2000;

    protected $slug = 'two_thousand_views_all_clips';
}
