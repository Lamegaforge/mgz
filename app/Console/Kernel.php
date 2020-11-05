<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('clips:aggregate')
            ->everyTenMinutes()
            ->between('17:00', '01:00');

        $schedule->command('clips:aggregate')->dailyAt('10:00');
        $schedule->command('clips:aggregate')->dailyAt('12:00');
        $schedule->command('clips:aggregate')->dailyAt('16:00');

        $schedule->command('clips:update')->daily();

        $schedule->command('cards:aggregate')->daily();

        $schedule->command('achievements')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
