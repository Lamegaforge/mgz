<?php

namespace App\Services;

use App\Models\User;
use App\Models\Clip;

class FavoriteService
{
    public function toggle(User $user, Clip $clip): void
    {
        $exist = $user->favorites->contains($clip->id);

        ($exist) 
            ? $this->detach($user, $clip)
            : $this->attach($user, $clip);
    }

    protected function detach(User $user, Clip $clip): void
    {
        $user->favorites()->detach($clip->id);
    }

    protected function attach(User $user, Clip $clip): void
    {
        $user->favorites()->attach($clip->id);
    }
}
