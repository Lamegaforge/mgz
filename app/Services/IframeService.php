<?php

namespace App\Services;

use Auth;
use App\Models\Clip;

class IframeService
{
    public function url(Clip $clip): string
    {
        $autoplay = Auth::check() ? Auth::user()->autoplay : false;

        $parts = [
            'clip=' . $clip->slug,
            'parent=megasaurus.fr',
            'parent=staging.megasaurus.fr',
            'autoplay=' . $autoplay,
        ];

        $format = 'https://clips.twitch.tv/embed?%s&%s&%s&%s';

        return sprintf($format, ... $parts);
    }
}
