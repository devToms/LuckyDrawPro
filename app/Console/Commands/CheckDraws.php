<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Draws;
use App\Models\Lotteries;
use App\Services\LuckyNumberGeneratorService;
use App\Services\TicketService;

/*
  Open Task Manager (Ctrl + Shift + Esc).
  Go to the "Create Task" or "Task Scheduler" tab (depending on your system version).
  Add a new task.
  In the "Program/script" field, enter the path to the php.exe file. For example: php.exe
  In the "Arguments" field, enter the full path to the artisan schedule:run command in your Laravel project. For example: path\to\project\LuckyDrawPro\artisan schedule:run.
  Configure the task according to your preferred schedule preferences.
  Click "OK" to create the task.
  The task will now run automatically according to the schedule.
*/
class CheckDraws extends Command
{
    protected $signature = 'check:draws';
    protected $description = 'Check draws and perform necessary actions';

    protected LuckyNumberGeneratorService $wonNumberGenerator;
    protected TicketService $ticketService;

    public function __construct(
      LuckyNumberGeneratorService $wonNumberGenerator,
      TicketService $ticketService
    ){
        parent::__construct();
        $this->wonNumberGenerator = $wonNumberGenerator;
        $this->ticketService = $ticketService;
    }

    public function handle()
    {
        \Log::info('Zadanie harmonogramu jest uruchamiane.');
        $currentDate = now();

        $lottery = Lotteries::whereHas('draws', function ($query) use ($currentDate) {
            $query->where('draw_date', '<=', $currentDate)
                ->whereNull('won_number');
        })->first();

        if ($lottery) {

            $wonNumber = $this->wonNumberGenerator->generate();

            $draw = $lottery->draws()->where('draw_date', '<=', $currentDate)
                ->whereNull('won_number')
                ->first();

            if ($draw) {
                $draw->update(['won_number' => $wonNumber]);

                $this->ticketService->assignPrizes($draw->id, $draw->won_number);

                $newDraw = new Draws([
                    'draw_date' => now()->addDay(2)
                ]);
                $lottery->draws()->save($newDraw);
            }
        }
    }

}
