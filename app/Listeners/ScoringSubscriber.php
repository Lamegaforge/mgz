<?php

namespace App\Listeners;

use App\Models\User;
use App\Services\ScoringService;

class ScoringSubscriber
{
    public function refresh(User $user, int $score) 
    {   
        $user->points = $score;

        $user->save();
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
            'ScoringSubscriber@refresh',
            [ScoringSubscriber::class, 'refresh']
        );
    }
}