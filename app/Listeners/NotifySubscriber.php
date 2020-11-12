<?php

namespace App\Listeners;

use Log;
use App\Models\Clip;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Achievement;
use App\Models\Notification;

class NotifySubscriber
{
    public function achievementWon(User $user, Achievement $achievement): void
    {   
        $format = 'Félicitations, tu viens de remporter le succès : %s';

        $message = sprintf($format, $achievement->title);

        $content = [
            'type' => 'achievement',
            'message' => $message,
        ];

        Log::info($user->display_name . ' won ' . $achievement->slug . ' achievement.');

        $this->store($user, $content);
    }

    public function achievementLost(User $user, Achievement $achievement): void
    {   
        $format = "Désolé, tu ne réponds plus aux conditions du succès, on doit te retirer : %s";

        $message = sprintf($format, $achievement->title);

        $content = [
            'type' => 'achievement',
            'message' => $message,
        ];

        Log::info($user->display_name . ' lost ' . $achievement->slug . ' achievement.');

        $this->store($user, $content);
    }

    public function clipWon(Clip $clip): void
    {   
        $format = "Félicitations, l'un de tes clips vient d'être validé : %s";

        $message = sprintf($format, $clip->title);

        $content = [
            'type' => 'clip',
            'message' => $message,
        ];

        Log::info($user->display_name . ' add "' . Str::limit($clip->title) . '" clip.');

        $this->store($clip->user, $content);
    }

    public function clipLost(Clip $clip): void
    {   
        $format = "Désolé, le clip suivant est finalement rejeté : %s";

        $message = sprintf($format, $clip->title);

        $content = [
            'type' => 'clip',
            'message' => $message,
        ];

        Log::info($user->display_name . ' lost "' . Str::limit($clip->title) . '" clip.');

        $this->store($clip->user, $content);
    }

    protected function store(User $user, array $content): void
    {
        Notification::create([
            'user_id' => $user->id,
            'content' => $content,
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
            'NotifySubscriber@achievementWon',
            [NotifySubscriber::class, 'achievementWon']
        );

        $events->listen(
            'NotifySubscriber@achievementLost',
            [NotifySubscriber::class, 'achievementLost']
        );

        $events->listen(
            'NotifySubscriber@clipWon',
            [NotifySubscriber::class, 'clipWon']
        );

        $events->listen(
            'NotifySubscriber@clipLost',
            [NotifySubscriber::class, 'clipLost']
        );
    }
}