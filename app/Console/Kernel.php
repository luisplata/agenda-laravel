<?php

namespace App\Console;

use App\Jobs\CheckSubscriptionsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Ejecutar la verificación de suscripciones cada día a las 2:00 AM
        $schedule->job(CheckSubscriptionsJob::class)->dailyAt('02:00');
        
        // Alternativas de ejecución:
        // $schedule->job(CheckSubscriptionsJob::class)->daily();        // Cada día a medianoche
        // $schedule->job(CheckSubscriptionsJob::class)->hourly();       // Cada hora
        // $schedule->job(CheckSubscriptionsJob::class)->everyMinute();  // Cada minuto
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
