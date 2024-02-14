<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lotteries;

class LotteriesController extends Controller
{
    private LuckyNumberGeneratorService $luckyNumberGeneratorService;

    public function __construct(LuckyNumberGeneratorService $luckyNumberGeneratorService)
    {
        $this->luckyNumberGeneratorService = $luckyNumberGeneratorService;
    }

    public function index()
    {
        // Pobierz wszystkie loterie z bazy danych
        $lotteries = Lotteries::all();

        // Przekaz loterie do widoku i wyrenderuj go
        return view('lotteries.index', ['lotteries' => $lotteries]);
    }
}
