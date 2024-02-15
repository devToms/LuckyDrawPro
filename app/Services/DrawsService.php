<?php

namespace App\Services;

use App\Models\Draws;

class DrawsService
{
    public function drawsList()
    {
        return  Draws::with('lotteries')
          ->where('draw_date', '>', now())
          ->get();
    }
}
