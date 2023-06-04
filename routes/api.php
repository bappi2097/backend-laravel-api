<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsFeedController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsSourceContorller;

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

Route::middleware('auth:sanctum')->get('/user/{user}', function (User $user) {
    return $user;
});


Route::post('/login', [AuthController::class, "login"]);
Route::post('/register', [AuthController::class, "register"]);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, "logout"]);
    Route::get('/user', [UserController::class, "show"]);
    Route::put('/user', [UserController::class, "update"]);
    Route::prefix('news-source')->controller(NewsSourceContorller::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{newsSource}', 'show');
    });
    Route::get('/news-feed', [NewsFeedController::class, "getNews"]);
});
