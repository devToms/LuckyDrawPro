<?php

namespace App\Services;

class LuckyNumberGeneratorService
{
    public function generate(): int
    {
        // Generowanie losowej liczby z przedziału 1-49
        return random_int(1, 49);
    }
}
