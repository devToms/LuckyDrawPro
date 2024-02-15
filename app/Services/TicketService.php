<?php

namespace App\Services;

use App\Models\Tickets;
use App\Models\Draws;
use App\Services\TicketNumberGeneratorService;
use Illuminate\Support\Facades\Auth;

class TicketService
{
    protected $numberGenerator;

    public function __construct(TicketNumberGeneratorService $numberGenerator)
    {
        $this->numberGenerator = $numberGenerator;
    }

    public function purchaseTicket($userId, $drawId)
    {
        $existingTicket = Tickets::where('user_id', $userId)
            ->where('draw_id', $drawId)
            ->first();

        if ($existingTicket) {
            return response()->json(['message' => 'Posiadasz już bilet do tej loterii.']);
        }

        $ticket = new Tickets([
            'user_id' => $userId,
            'draw_id' => $drawId,
            'number' => $this->numberGenerator->generate(),
            'bought_date' => now(),
        ]);
        $ticket->save();

        return response()->json(['message' => 'Bilet zakupiony pomyślnie.']);
    }
}
