<?php

namespace App\Services\Achievements;

use App\Models\User;
use App\Models\Achievement;

class AchievementService 
{
    public function assignee(User $user, Achievement $achievement): bool
    {
        $contains = $this->contains($user, $achievement);

        if ($contains) {
            return false;
        }

        $user->achievements()->attach($achievement->id);

        return true;
    }

    public function unassign(User $user, Achievement $achievement): bool
    {
        $contains = $this->contains($user, $achievement);

        if (! $contains) {
            return false;
        }

        $user->achievements()->detach($achievement->id);

        return true;
    }

    protected function contains(User $user, Achievement $achievement): bool
    {
        return $user->achievements->contains($achievement->id);
    }
}