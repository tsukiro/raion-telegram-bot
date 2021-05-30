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
        if (env("ENABLE_CURRENCY_NOTIFICATIONS_DAILY","false") === "true"){
            $schedule->command('notify:currency')->dailyAt("09:00");
            $schedule->command('notify:currency')->dailyAt("18:00");
        }
        if (env("ENABLE_CURRENCY_NOTIFICATIONS_TEN_MINUTES","false") === "true"){
            $schedule->command('notify:currency')->everyTenMinutes();	;
        }
        //          ->hourly();
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
