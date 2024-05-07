<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingController;

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

Route::get('/training', function () {
    return view('training');
});

Route::get('/edit-training', function () {
    return view('edit-training');
});


// Route::get('{view}', TrainingController::class)->where('view', '(.*)')->name('view');