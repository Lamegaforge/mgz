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
        $format = 'Félicitations, tu viens de remporter le succes : %s';

        $message = sprintf($format, $achievement->title);

        $this->store($user, $message);
    }

    public function removeAchievement(User $user, Achievement $achievement): void
    {   
        $format = "Désolé, tu ne réponds plus aux conditions du succès, on doit te retirer : %s";

        $message = sprintf($format, $achievement->title);

        $this->store($user, $message);
    }

    public function clip(User $user, Clip $clip): void
    {   
        $format = "Félicitations, l'un de tes clips vient d'être validé : %s";

        $message = sprintf($format, $clip->title);

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
            'NotifySubscriber@removeAchievement',
            [NotifySubscriber::class, 'removeAchievement']
        );

        $events->listen(
            'NotifySubscriber@clip',
            [NotifySubscriber::class, 'clip']
        );
    }
}