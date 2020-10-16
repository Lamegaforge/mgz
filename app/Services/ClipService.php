<?php

namespace App\Services;

use App\Models\Clip;
use App\Repositories\ClipRepository;

class ClipService
{
    public function getHighlightClip(): Clip
    {
        return app(ClipRepository::class)->first();
    }
}
