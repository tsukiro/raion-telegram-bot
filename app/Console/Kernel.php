<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
        Log::info("ENABLE_CURRENCY_NOTIFICATIONS : ". env("ENABLE_CURRENCY_NOTIFICATIONS",""));
        try {
            //code...
            $schedule->command('notify:currency')->dailyAt("09:00");
            $schedule->command('notify:currency')->dailyAt("18:00");
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("Hubo un problema al ejecutar los comandos de cron");
            Log::error($th);
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
