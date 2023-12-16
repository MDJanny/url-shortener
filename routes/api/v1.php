<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\LinkController;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/links', [LinkController::class, 'index']);
    Route::post('/shorten', [LinkController::class, 'shorten']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
