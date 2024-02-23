<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Draws;
use App\Models\Lotteries;
use App\Services\LuckyNumberGeneratorService;

class TestController extends Controller
{
    public function purchaseTicket(Request $request)
    {
        $currentDate = now();

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
                $draw->update(['won_number' => $wonNumber]);

                // Poniżej dodaj kod z TicketService do przypisania nagród użytkownikom
                // $ticketService = new TicketService(new TicketNumberGeneratorService());
                // $ticketService->assignPrizes($draw->id, $wonNumber);

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
