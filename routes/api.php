<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->as('v1:')->group(function () {
    // Authentication Routes
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    Route::get('/user', [AuthController::class, 'user'])->name('user')->middleware('auth:sanctum');

    // User Routes
    Route::prefix('users')->as('users.')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
    });

    Route::prefix('transactions')->as('transactions.')->middleware(['auth:sanctum'])->group(function () {
        Route::post('/deposit', [TransactionController::class, 'deposit'])->name('deposit');
        Route::post('/withdraw', [TransactionController::class, 'withdraw'])->name('withdraw');
        Route::get('/history', [TransactionController::class, 'history'])->name('history');
    });
});
