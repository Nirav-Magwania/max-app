<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;


// Routes accessible by admin users
Route::group(['middleware' => ['auth:sanctum', 'admin'], 'prefix' => 'admin'], function () {
 
    // Order controller routes
    Route::post('/order', [OrderController::class, 'placeorder']); // Place an order
});
