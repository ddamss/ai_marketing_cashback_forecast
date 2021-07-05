<?php

use App\Models\Cashback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashbackController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('cashback',CashbackController::class);
// Route::apiResource('cashback',CashbackController::class)->only([
//     'store','getLastInsert'
// ]);

// Route::get('/test',CashbackController::class)->only([
//         'getLastInsert'
//     ]);

// Route::get('/test','CashbackController@getLastInsert');

Route::get('getLastInsert', [CashbackController::class, 'getLastInsert'])->name('cashback.getLastInsert');

Route::get('cashbacksDate', [CashbackController::class, 'cashbacksDate'])->name('cashback.cashbacksDate');
