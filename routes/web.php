<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LotteriesController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\WinnersController;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lotteries', [LotteriesController::class, 'index']);
//Route::post('/tickets/purchase', [TicketsController::class, 'purchaseTicket']);
Route::post('/tickets/purchase', [TicketsController::class, 'purchaseTicket'])->name('tickets.purchase');
Route::post('/tickets/prizes', [TicketsController::class, 'assignPrizes'])->name('tickets.prize');

Route::match(['get', 'post'], '/test', [TestController::class, 'purchaseTicket']);

Route::get('/lotteries/winners', [WinnersController::class, 'index'])->name('winners');
// Route::get('/lotteries/winning/{lotteryName}', [WinnersController::class, 'getWinningDrawsForLotteryName'])->name('lotteries.winning');
Route::get('/lotteries/winning/{lotteryId}', [WinnersController::class, 'showWinningDrawsForLotteryName'])->name('lotteries.winning');

Route::controller(AuthController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});
