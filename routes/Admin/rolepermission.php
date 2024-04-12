<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;

Route::group(['middleware'=>['auth:sanctum','admin'], 'prefix' => 'admin'],function()
{
    //routes for role and permission
  
    Route::controller(RolePermissionController::class)->group(function() {
        Route::post('/create/role','roleStore');
        Route::delete('/delete/roles/{role}','roleDestroy');
        Route::post('/create/permission','permissionStore');
        Route::delete('/delete/permission/{id}','permissionDestroy');
        //attach detach and sync
        
        Route::post('/roles/permissions/attach', 'attach');
        Route::post('/roles/{role}/permissions/{permission}/detach', 'detach');
        Route::post('/roles/{role}/permissions/sync', 'sync');
        //role permission update
        Route::post('/roles/{role}/permissions/update', 'roleUpdate');
       
    
        
        
        // super index
        Route::get('/role/{role}', 'superIndex');

        
    });
});