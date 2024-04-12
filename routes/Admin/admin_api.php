<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;



Route::group(['middleware'=>['auth:sanctum','admin'], 'prefix' => 'admin'],function()
{
    Route::get('users',[AdminController::class,'index']);
    Route::patch('users/{user}',[AdminController::class,'update']);
    Route::get('users/{user}',[AdminController::class,'show']);
    Route::post('user',[AdminController::class,'create']);
    Route::delete('users/{user}',[AdminController::class,'delete']);

});
//  Route::post('/order', [OrderController::class, 'placeorder']);