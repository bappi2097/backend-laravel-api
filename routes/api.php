<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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


Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [AuthController::class, "logout"]);
    Route::get('/user/{user}', [UserController::class, "show"]);
    Route::put('/user/{user}', [UserController::class, "update"]);

});
