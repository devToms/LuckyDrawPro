<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DrawsService;

class LotteriesController extends Controller
{
    public function __construct(DrawsService $drawsService)
    {
        $this->drawsService = $drawsService;
    }

    public function index()
    {
        $draws = $this->drawsService->getActiveDraws();
        return view('lotteries.index', ['draws' => $draws]);
    }
}
