<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WinnersDrawsService;

class WinnersController extends Controller
{
    protected WinnersDrawsService $winnersService;

    public function __construct(WinnersDrawsService $winnersDrawsService)
    {
        $this->winnersDrawsService = $winnersDrawsService;
    }

    public function index()
    {
        $winners = $this->winnersDrawsService->getWinners();
        return view('winners.index', ['winners' => $winners]);
    }
    
    public function showWinningDrawsForLotteryName($lotteryName)
    {
        $winningDraws = $this->winnersDrawsService->getWinningDrawsForLotteryName($lotteryName);
        dd($winningDraws);
      //  return view('winners.index', ['winningDraws' => $winningDraws]);
    }

    public function showWinningDrawsForLotteryId($lotteryId)
    {
        $winningDraws = $this->winnersDrawsService->getWinningDrawsForLotteryId($lotteryId);
        dd($winningDraws);
        return view('winners.index', ['winningDraws' => $winningDraws]);
    }
}
