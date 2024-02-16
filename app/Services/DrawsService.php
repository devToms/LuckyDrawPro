<?php

namespace App\Services;

use App\Models\Draws;

class DrawsService
{
    public function getActiveDraws()
    {
        return Draws::with('lotteries')
        ->whereNull('won_number')
        ->where(function ($query) {
            $query->where('draw_date', '>', now())
                  ->orWhereNull('draw_date');
        })
        ->get();
    }
}
