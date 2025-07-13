<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Private\PaymentsController;
use App\Http\Controllers\Private\ChatController;
use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;

// Route::get('/', [HomeController::class, 'create'])->name('home');
Route::get('/', [HomeController::class, 'create'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('payments', [PaymentsController::class, 'create'])->name('payments');
    Route::post('payments', [PaymentsController::class, 'store']);
    
    Route::get('chat', [ChatController::class, 'create'])->name('chat');
    Route::post('chat', [ChatController::class, 'store'])->name('chat');
   
});

