<?php

namespace App\Services;

use App\Models\WinnersTicket;

class WinnersDrawsService
{
    public function getWinners()
    {
        return WinnersTicket::with(['draws', 'user', 'tickets'])->get();
    }
}
