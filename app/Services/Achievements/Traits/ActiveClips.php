<?php

namespace App\Services\Achievements\Traits;

trait ActiveClips
{
	public function eligible(): bool
	{
        $clips = $this->user->clips();

        $count = $clips->where('state', 'active')->count();

        return $count >= self::THRESHOLD;
	}
}