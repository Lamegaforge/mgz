<?php

namespace App\Services\Achievements;

use App\Models\User;
use App\Models\Achievement;

class AchievementService 
{
    public function assignee(User $user, Achievement $achievement): void
    {
        $exist = $user->achievements->contains($achievement->id);

        if ($exist) {
            return;
        }

        $user->achievements()->attach($achievement->id);
    }

    public function unassign(User $user, Achievement $achievement): void
    {
        $user->achievements()->detach($achievement->id);
    }
}