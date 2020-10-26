<?php

namespace App\Services\Achievements\Traits;

trait ClipsViews
{
    public function eligible(): bool
    {
        $clips = $this->user->clips;

        $views = $clips->where('state', 'active')->sum('views');

        return $views >= self::THRESHOLD;
    }
}
