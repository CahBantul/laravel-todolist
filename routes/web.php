<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, "home"]);

Route::view('/template', 'template');

Route::controller(UserController::class)->group(function () {
    Route::get('/login', "login")->middleware([OnlyGuestMiddleware::class]);
    Route::post('/login', "doLogin")->middleware([OnlyGuestMiddleware::class]);
    Route::post('/logout', "logout")->middleware([OnlyMemberMiddleware::class]);
});
