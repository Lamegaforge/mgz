<?php

namespace App\Listeners;

use App\Models\User;
use App\Services\CounterService;

class CounterSubscriber
{
    public function banner(User $user) 
    {   
        // app(CounterService::class)->increment($user, 'banner');
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
    }
}