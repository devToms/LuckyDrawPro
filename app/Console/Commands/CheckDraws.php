<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Draws;
use App\Models\Lotteries;
use App\Services\LuckyNumberGeneratorService;

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

    public function __construct(LuckyNumberGeneratorService $wonNumberGenerator)
    {
        // We will go ahead and set the name, description, and parameters on console
        // commands just to make things a little easier on the developer. This is
        // so they don't have to all be manually specified in the constructors.
        if (isset($this->signature)) {
            $this->configureUsingFluentDefinition();
        } else {
            parent::__construct($this->name);
        }

        // Once we have constructed the command, we'll set the description and other
        // related properties of the command. If a signature wasn't used to build
        // the command we'll set the arguments and the options on this command.
        if (! isset($this->description)) {
            $this->setDescription((string) static::getDefaultDescription());
        } else {
            $this->setDescription((string) $this->description);
        }

        $this->setHelp((string) $this->help);

        $this->setHidden($this->isHidden());

        if (isset($this->aliases)) {
            $this->setAliases((array) $this->aliases);
        }

        if (! isset($this->signature)) {
            $this->specifyParameters();
        }

        if ($this instanceof Isolatable) {
            $this->configureIsolation();
        }
        $this->wonNumberGenerator = $wonNumberGenerator;
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
