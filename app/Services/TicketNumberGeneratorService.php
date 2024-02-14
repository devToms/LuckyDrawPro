<?php

namespace App\Services;

use App\Services\NumberGeneratorInterface;

class TicketNumberGeneratorService implements NumberGeneratorInterface
{
    public function generate(): int
    {
      // ticket number generation logic
      return random_int(1, 49);
    }
}
