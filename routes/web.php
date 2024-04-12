<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{FlightController};
//use App\Http\Controllers\NotifyController;

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
Route::get('/flight',[FlightController::class, 'index']);
Route::get('/plane',[FlightController::class, 'UDP']);
Route::get('/airline',[FlightController::class, 'Aline']);

//Route::resource('/tests',TestController::class);
//Route::get('/send','NotifyController@index');
Route::get('/mail', function(){
    $order = App\User::find(1);
    return (new App\Notifications\StatusUpdate($order))
             ->toMail($order->user);
});