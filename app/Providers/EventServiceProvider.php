<?php

namespace App\Providers;

use App\Events;
use App\Listeners;
use App\Listeners\NotifySubscriber;
use App\Listeners\CounterSubscriber;
use App\Listeners\ScoringSubscriber;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Events\AchievementWon::class => [
            Listeners\NotifyUser::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        ScoringSubscriber::class,
        NotifySubscriber::class,
        CounterSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
