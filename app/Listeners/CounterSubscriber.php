<?php

namespace App\Listeners;

use App\Models\User;
use App\Services\CounterService;

class CounterSubscriber
{
    public function banner(User $user) 
    {   
        app(CounterService::class)->increment($user, 'banner');
    }

    public function random(User $user) 
    {   
        app(CounterService::class)->increment($user, 'random');
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
            'CounterSubscriber@banner',
            [CounterSubscriber::class, 'banner']
        );

        $events->listen(
            'CounterSubscriber@random',
            [CounterSubscriber::class, 'random']
        );
    }
}