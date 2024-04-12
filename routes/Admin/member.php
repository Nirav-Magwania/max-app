<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;


Route::group(['middleware'=>['auth:sanctum','admin'], 'prefix' => 'admin'],function()
{
    Route::controller(MemberController::class)->group(function() 
    {
        //member role update
        Route::post('/member/{member}/role-update/','memberUpdate');
        //member delete
        Route::delete('/member/{member}/delete/','memberDelete');
        //create a new member and attach to role
        Route::post('/member','attachMemberToRole');

    });
});