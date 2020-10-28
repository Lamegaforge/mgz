<?php

namespace App\Listeners;

use Auth;
use App\Services\Achievements\CounterService;

class CounterSubscriber
{
    /**
     * Handle user login events.
     */
    public function increment(string $slug) 
    {   
        $user = Auth::user();

        if (! $user) {
            return;
        }

        app(CounterService::class)->increment($user, $slug);
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
            'CounterSubscriber',
            [CounterSubscriber::class, 'increment']
        );
    }
}