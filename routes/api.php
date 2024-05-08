<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register']);

// Example resourceful route
// Route::resource('users', AuthController::class);

// Individual routes if resourceful routes are not needed
Route::get('users', [AuthController::class, 'index']);
// Route::post('users', [AuthController::class, 'store']);
// Route::get('users/{user}', [AuthController::class, 'show']);
// Route::put('users/{user}', [AuthController::class, 'update']);
// Route::delete('users/{user}', [AuthController::class, 'destroy']);
