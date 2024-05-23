<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgentTrainingController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register']);

Route::resource('trainings', TrainingController::class);
Route::resource('agents', AgentController::class);
Route::resource('agent-training', AgentTrainingController::class);
Route::post('/update-expired-status', [AgentTrainingController::class, 'updateExpiredStatus']);
Route::post('/check-email', [AuthController::class, 'checkEmail']);
// Example resourceful route
// Route::resource('users', AuthController::class);


// Individual routes if resourceful routes are not needed
Route::get('users', [AuthController::class, 'index']);
// Route::post('users', [AuthController::class, 'store']);
// Route::get('users/{user}', [AuthController::class, 'show']);
// Route::put('users/{user}', [AuthController::class, 'update']);
// Route::delete('users/{user}', [AuthController::class, 'destroy']);
