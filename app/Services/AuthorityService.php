<?php

namespace App\Services;

use Config;
use App\Models\User;

class AuthorityService
{
    public const CAN_REJECT_CLIP = 'can_reject_clip';

    public function can(User $user, string $goal): bool
    {
        if ($this->privilegedUser($user)) {
            return true;
        }

        $authorizedUsers = $this->authorizedUsers($goal);

        return in_array($user->tracking_id, $authorizedUsers, true);
    }

    protected function privilegedUser(User $user): bool
    {
        $privilegedUsers = Config::get('authority.privileged');

        return in_array($user->tracking_id, $privilegedUsers, true);
    }

    protected function authorizedUsers(string $goal): array
    {
        return Config::get('authority.' . $goal);
    }
}
