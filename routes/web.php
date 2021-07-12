<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

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

Route::get('/cashback/?token={token}', function () {
    return view('display_forecast_data');
});

Route::get('/created', function($account){
    return view ('account_created',$account);
})->name('created');

Route::resource('/account', AccountController::class);