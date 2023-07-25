<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\TahunAjaranController;
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

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authentication'])->name('login.post');
});
Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/builder', [UserController::class, 'builder'])->name('builder');
    });
    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('index');
        Route::get('/builder', [KelasController::class, 'builder'])->name('builder');
        Route::post('/store', [KelasController::class, 'store'])->name('store');
        Route::put('/update/{id}', [KelasController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [KelasController::class, 'destroy'])->name('delete');
    });
    Route::prefix('tahun-ajaran')->name('tahun-ajaran.')->group(function () {
        Route::get('/', [TahunAjaranController::class, 'index'])->name('index');
        Route::get('/builder', [TahunAjaranController::class, 'builder'])->name('builder');
        Route::post('/store', [TahunAjaranController::class, 'store'])->name('store');
        Route::put('/update/{id}', [TahunAjaranController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [TahunAjaranController::class, 'destroy'])->name('delete');
    });
});
