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
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization,X-Requested-With');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('cashback',CashbackController::class);

Route::get('getLastInsert', [CashbackController::class, 'getLastInsert'])->name('cashback.getLastInsert');

Route::get('cashbacksDate/token={token}', [CashbackController::class, 'cashbacksDate'])->name('cashback.cashbacksDate');

Route::get('test', [CashbackController::class, 'test'])->name('test');
