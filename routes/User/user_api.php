<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Middleware\IsAdmin;


//we will write user apis here !!!!!!!!!

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});        
Route::post('user',[UserAuthController::class,'register']);
Route::post('user-login',[UserAuthController::class,'login']);

Route::group(['middleware'=>['auth:sanctum']],function()
{
    Route::patch('user/api-access/{status}', [UserAuthController::class, 'apiAccess']);
    Route::post('user/changepass', [UserAuthController::class, 'changepass']);

    Route::patch('user/activity',[ActivityController::class,'Activitylog']);//--------------//-----------//

    Route::controller(RolePermissionController::class)->group(function() {
        Route::get('/role','roleIndex');
        Route::get('/permission','permissionIndex');
    });

});







Route::middleware('auth:external_api')->get('/nn-user', function(Request $request) {
    return $request->user();
});


