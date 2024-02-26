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
}
