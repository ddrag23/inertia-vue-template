<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/builder', [UserController::class, 'builder'])->name('builder');
});
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
});
