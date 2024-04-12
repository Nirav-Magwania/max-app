<?php
use App\Http\Middleware\IsAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\FlightUserController;

// Public routes
Route::get('flight-all', [FlightController::class, 'index']);
Route::post('flight-store', [FlightController::class, 'store']);
Route::get('flight-get/{filename}', [FlightController::class, 'getImage']);
Route::delete('flight-delete/{filename}', [FlightController::class, 'destroy']);
Route::post('flight-update/{id}', [FlightController::class, 'update']);

// Admin routes
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    // Flight routes
    Route::post('flight', [FlightController::class, 'store']); // Duplicate route removed
    Route::post('upload', [FlightController::class, 'upload']); // Image upload route moved here

    // UserFlightController routes
    Route::get('attach/user/{user}/flight/{flight}', [FlightUserController::class, 'attachUserToFlight']);
    Route::get('detach/user/{user}/flight/{flight}', [FlightUserController::class, 'detachUserFromFlight']);
    Route::get('getuserofflight/{flight}', [FlightUserController::class, 'getUsersOfFlight']);
    Route::get('getflightofusers/{user}', [FlightUserController::class, 'getFlightsOfUserAll']);
});

// Authenticated user routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/getflightofuser', [FlightUserController::class, 'getFlightsOfUser']);
});
