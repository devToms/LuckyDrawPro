<?php

namespace App\Services;

use App\Models\Tickets;
use App\Models\WinnersTicket;
use App\Models\Draws;
use App\Services\NumberGeneratorInterface;
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

        if (!is_numeric($userId) || !is_numeric($drawId)) {
            return ['error' => 'Invalid input data.'];
        }

        try {
            $existingTicket = Tickets::where('user_id', $userId)
                ->where('draw_id', $drawId)
                ->first();

            if ($existingTicket) {
                return ['message' => 'You already have a ticket for this lottery.'];
            }

            $ticket = new Tickets([
                'user_id' => $userId,
                'draw_id' => $drawId,
                'number' => $this->numberGenerator->generate(),
                'bought_date' => now(),
            ]);

            $ticket->save();


            return ['message' => 'Ticket purchased successfully.'];
        } catch (\Exception $e) {
            return [['message' => 'An error occurred while purchasing the ticket.'], 500];
        }
    }

    public function assignPrizes($drawId, $wonNumber)
    {
        try {
            $winningTicket = Tickets::where('draw_id', $drawId)
            ->where('number', $wonNumber)
            ->first();

            if ($winningTicket) {
                WinnersTicket::create([
                    'draw_id' => $winningTicket->draw_id,
                    'user_id' => $winningTicket->user_id,
                    'ticket_id' => $winningTicket->id,
                ]);
            }

            return ['message' => 'Prizes assigned successfully.'];
        } catch (\Exception $e) {
            return ['message' => 'An error occurred while assigning prizes.'];
        }
    }
}
