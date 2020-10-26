<?php

namespace App\Services\Achievements\Triggers;

use App\Services\Achievements\Contracts\Trigger;

class ValerieDamidot extends Triggers implements Trigger 
{
    protected $slug = 'valerie_damidot';

    public function eligible(): bool
    {
        $prerequisites = [
            $this->hasBanner(),
            $this->hasDescription(),
            $this->hasAtLeastOneSocialNetwork(),
        ];

        return ! in_array(false, $prerequisites);
    }

    protected function hasBanner(): bool
    {
        return (bool) $this->user->banner_image_slug;
    }

    protected function hasDescription(): bool
    {
        return (bool) $this->user->description;
    }

    protected function hasAtLeastOneSocialNetwork(): bool
    {
        $socialNetworks = [
            (bool) $this->user->youtube,
            (bool) $this->user->instagram,
            (bool) $this->user->twitter,
        ];

        return in_array(true, $socialNetworks);
    }
}