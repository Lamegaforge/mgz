<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AuthorityService;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClipPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function reject(User $user): bool
    {
        $goal = AuthorityService::CAN_REJECT_CLIP;

        return app(AuthorityService::class)->can($user, $goal);
    }
}
