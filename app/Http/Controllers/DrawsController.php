<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DrawsService;

class DrawsController extends Controller
{
    private DrawsService $drawsService;

    public function __construct(DrawsService $drawsService)
    {
        $this->drawsService = $drawsService;
    }

    public function showWinningDrawsForLotteryName($lotteryName)
    {
        $winningDraws = $this->drawsService->getWinningDrawsForLotteryName($lotteryName);
        return view('draws.winning-draws', ['winningDraws' => $winningDraws]);
    }

    public function showWinningDrawsForLotteryId($lotteryId)
    {
        $winningDraws = $this->drawsService->getWinningDrawsForLotteryId($lotteryId);
        return view('draws.winning-draws', ['winningDraws' => $winningDraws]);
    }
}
