<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lotteries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Services\DrawsService;

class LotteriesController extends Controller
{
    public function __construct(DrawsService $drawsService)
    {
        $this->drawsService = $drawsService;
    }

    public function index()
    {
        $draws = $this->drawsService->drawsList();
        return view('lotteries.index', ['draws' => $draws]);
    }
}
