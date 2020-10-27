<?php

namespace App\Services;

use Auth;
use App\Models\Clip;

class IframeService
{
    public function url(Clip $clip): string
    {
        $autoplay = $this->getAutoplay();

        $parts = [
            'clip=' . $clip->slug,
            'parent=megasaurus.fr',
            'parent=staging.megasaurus.fr',
            'autoplay=' . $autoplay,
        ];

        $format = 'https://clips.twitch.tv/embed?%s&%s&%s&%s';

        return sprintf($format, ... $parts);
    }

    protected function getAutoplay(): string
    {
        if (Auth::guest()) {
            return 'false';
        }

        return Auth::user()->autoplay ? 'true' : 'false';
    }
}
