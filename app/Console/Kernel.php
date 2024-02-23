<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Draws;
use App\Services\TicketService;
use App\Services\LuckyNumberGeneratorService;
use App\Console\Commands\CheckDraws;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\CheckDraws::class
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('check:draws')->everyMinute();
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
