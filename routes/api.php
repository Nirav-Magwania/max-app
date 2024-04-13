<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\Mail\MailController;
use App\Http\Middleware\IsAdmin;

require __DIR__ .'/Admin/admin_api.php';
require __DIR__ .'/Admin/member.php';
require __DIR__ .'/Admin/rolepermission.php';
require __DIR__ .'/Admin/order.php';
require __DIR__ .'/Admin/task.php';
require __DIR__ .'/User/user_api.php';
require __DIR__ .'/Flight/flight.php';

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/',function(){ return view('welcome');});
Route::post('/sendMyMail',[MailController::class,'sendMail'])->name('send.email');

Route::get('/countusers',[MemberController::class,'UserCount']);
 
