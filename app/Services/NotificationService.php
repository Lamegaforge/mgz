<?php

namespace App\Services;

use Auth;
use DateTime;
use App\Models\User;

class NotificationService
{
    public function readAll(User $user): void
    {
        $notifications = $user->notifications()->whereNull('readed_at');

        $notifications->update([
            'readed_at' => (new DateTime())->format('Y-m-d'),
        ]);
    }

    public function count(): int
    {
        if (Auth::guest()) {
            return 0;
        }

        return Auth::user()->notifications()->count();
    }
}
