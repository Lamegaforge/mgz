<?php

namespace App\Services\Achievements;

use App\Models\User;
use App\Services\Achievements\Contracts\Achievement;

class ValerieDamidot extends Achievements implements Achievement 
{
    protected $slug = 'valerie_damidot';

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

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
            (bool) $this->user->twitch,
            (bool) $this->user->instagram,
            (bool) $this->user->twitter,
        ];

        return in_array(true, $socialNetworks);
    }
}