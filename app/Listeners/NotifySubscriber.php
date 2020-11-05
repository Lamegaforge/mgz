<?php

namespace App\Listeners;

use App\Models\Clip;
use App\Models\User;
use App\Models\Achievement;
use App\Models\Notification;

class NotifySubscriber
{
    public function achievement(User $user, Achievement $achievement): void
    {   
        $message = 'Félicitations, tu viens de remporter le succes : ' . $achievement->title;

        $this->store($user, $message);
    }

    public function clip(User $user, Clip $clip): void
    {   
        $message = "Félicitations, l'un de tes clips vient d'être validé : " . $clip->title;

        $this->store($user, $message);
    }

    protected function store(User $user, string $message): void
    {
        Notification::create([
            'user_id' => $user->id,
            'message' => $message,
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            'NotifySubscriber@achievement',
            [NotifySubscriber::class, 'achievement']
        );

        $events->listen(
            'NotifySubscriber@clip',
            [NotifySubscriber::class, 'clip']
        );
    }
}