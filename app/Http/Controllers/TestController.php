<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Draws;
use App\Models\Lotteries;
use App\Models\WinnersTicket;
use App\Services\LuckyNumberGeneratorService;
use App\Services\TicketService;

class TestController extends Controller
{
    private TicketService $ticketService;
    public function __construct(
        LuckyNumberGeneratorService $numberGenerator,
        TicketService $ticketService
    ) {
        $this->ticketService = $ticketService;
    }

    public function purchaseTicket(Request $request)
    {
        //$currentDate = now();
        $currentDate = '2024-02-23 17:02:00';

        // Pobierz loterię, dla której aktualnie trwa sprawdzanie losowań
        $lottery = Lotteries::whereHas('draws', function ($query) use ($currentDate) {
            $query->where('draw_date', '<=', $currentDate)
                ->whereNull('won_number');
        })->first();

        if ($lottery) {

            // Znaleziono loterię, dla której trwa sprawdzanie losowań

            $wonNumberGenerator = new LuckyNumberGeneratorService();
            $wonNumber = $wonNumberGenerator->generate();

            // Zaktualizuj pierwsze losowanie znalezione dla danej loterii
            $draw = $lottery->draws()->where('draw_date', '<=', $currentDate)
                ->whereNull('won_number')
                ->first();

            if ($draw) {
                $draw->update(['won_number' => 32]);

                $this->ticketService->assignPrizes($draw->id, $draw->won_number);
                // Poniżej dodaj kod tworzenia nowego losowania
                $newDraw = new Draws([
                    'draw_date' => now()->addDay(2), // Przykład - nowe losowanie za 2 dni
                ]);
                $lottery->draws()->save($newDraw);
            }


            return response()->json(['ok']);
        }
    }
}
