<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CashbackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/cashback', function () {
    return view('display_forecast_data');
})->name('cashback_data');

Route::get('/cashback/token={token}',[CashbackController::class, 'cashbackUser'])->name('cashback.token');

Route::get('/created', function($account){
    return view ('account_created',$account);
})->name('created');

Route::resource('/account', AccountController::class);