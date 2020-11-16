<?php

namespace App\Services\Achievements\Triggers\ViewsAllClips;

use App\Models\User;
use App\Services\Achievements\Traits;
use App\Services\Achievements\Triggers\Triggers;
use App\Services\Achievements\Contracts\Trigger;

class FourThousand extends Triggers implements Trigger 
{
    use Traits\ClipsViews;

    protected const THRESHOLD = 4000;

    protected $slug = 'four_thousand_views_all_clips';
}
