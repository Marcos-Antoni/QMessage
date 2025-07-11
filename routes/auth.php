<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PaymentsController;
use App\Http\Controllers\Auth\ChatController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [RegisteredUserController::class, 'create'])->name('home');
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    
    
});

Route::middleware('auth')->group(function () {
    Route::get('payments', [PaymentsController::class, 'create'])->name('payments');
    Route::get('chat', [ChatController::class, 'create'])->name('chat');
   
});

