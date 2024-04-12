<?php

use App\Http\Controllers\TaskController;



// Routes accessible by admin users
Route::group(['middleware' => ['auth:sanctum', 'admin'], 'prefix' => 'admin'], function () {

    // Task controller routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks'); // Get all tasks
    Route::get('/task/{taskId}', [TaskController::class, 'show'])->name('task_show'); // Show a task
    Route::delete('/task/{taskId}', [TaskController::class, 'destroy'])->name('delete_task'); // Delete a task

});
