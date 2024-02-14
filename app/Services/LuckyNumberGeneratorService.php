<?php

namespace App\Services;

use App\Services\NumberGeneratorInterface;

class LuckyNumberGeneratorService implements NumberGeneratorInterface
{
    public function generate(): int
    {
        // logic for generating the lucky number for the draw
        return random_int(1, 49);
    }
}
