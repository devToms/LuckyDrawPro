<?php

namespace App\Services;

use App\Models\WinnersTicket;

class WinnersDrawsService
{
    public function getWinners()
    {
        return WinnersTicket::with(['draws', 'user', 'tickets'])->get();
    }

    public function getWinningDrawsForLotteryName($lotteryName)
    {
        $winningDraws = Draws::whereHas('lotteries', function ($query) use ($lotteryName) {
            $query->where('name', $lotteryName);
        })
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tickets')
                    ->whereRaw('tickets.draw_id = draws.id')
                    ->whereRaw('tickets.number = draws.won_number');
            })
            ->pluck('id');

        return $winningDraws;
    }

    public function getWinningDrawsForLotteryId($lotteryId)
    {
     //  $winningDraws = Draws::where('lottery_id', $lotteryId)
     // ->where('won_number', DB::raw('(SELECT number FROM tickets WHERE tickets.draw_id = draws.id)'))
     // ->pluck('id');

        $winningDraws = Draws::where('lottery_id', $lotteryId)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tickets')
                    ->whereRaw('tickets.draw_id = draws.id')
                    ->whereRaw('tickets.number = draws.won_number');
            })
            ->pluck('id');

        return $winningDraws;
    }

}
