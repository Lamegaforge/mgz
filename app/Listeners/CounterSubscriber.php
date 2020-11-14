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

    public function clipShow(User $user) 
    {   
        app(CounterService::class)->increment($user, 'clip_show');
    }

    public function seeOwnAccount(User $user) 
    {   
        app(CounterService::class)->increment($user, 'see_own_account');
    }

    public function seeAnotherAccount(User $user) 
    {   
        app(CounterService::class)->increment($user, 'see_another_account');
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

        $events->listen(
            'CounterSubscriber@clipShow',
            [CounterSubscriber::class, 'clipShow']
        );

        $events->listen(
            'CounterSubscriber@seeOwnAccount',
            [CounterSubscriber::class, 'seeOwnAccount']
        );

        $events->listen(
            'CounterSubscriber@seeAnotherAccount',
            [CounterSubscriber::class, 'seeAnotherAccount']
        );
    }
}