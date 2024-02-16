<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Draws;
use App\Services\TicketService;
use App\Services\LuckyNumberGeneratorService;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            \Log::info('Zadanie harmonogramu jest uruchamiane.');
            //Dodaj resztę kodu związanej z zadaniem harmonogramu tutaj
            $currentDate = '2024-02-15 16:26:00';
            $drawsToCheck = Draws::where('draw_date', '<=', $currentDate)
                ->whereNull('won_number')
                ->get();

            foreach ($drawsToCheck as $draw) {
                // Poniżej dodaj kod generowania i zapisywania wygenerowanego losowego numeru
                $wonNumberGenerator = new LuckyNumberGeneratorService();
                $wonNumber = $wonNumberGenerator->generate();

                $draw->update(['won_number' => $wonNumber]);

                //Poniżej dodaj kod z TicketService do przypisania nagród użytkownikom
                // $ticketService = new TicketService();
                // $ticketService->assignPrizes($draw->id, $wonNumber);

                $lotteries = Lotteries::all();

                foreach ($lotteries as $lottery) {
                    // Poniżej dodaj kod tworzenia nowego losowania
                    $newDraw = new Draws([
                        'draw_date' => '2024-02-16 16:26:00', // Przykład - nowe losowanie za 1 dzień
                    ]);
                    $lottery->draws()->save($newDraw);
                }
            }
        })->everyMinute();

        // $schedule->call(function () {
        //
        // })->daily();

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
