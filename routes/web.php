<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/messages/unread', [ChatController::class, 'getUnreadMessages']);
    Route::get('/messages/{user}', [ChatController::class, 'getMessages'])->name('messages.index');
    Route::post('/messages', [ChatController::class, 'sendMessage'])->name('messages.store');

    Route::get('/impersonate/{user}', [ImpersonationController::class, 'loginAs'])
        ->middleware('role:admin')
        ->name('impersonate')
        ->where('user', '[0-9]+');

    Route::post('/impersonate/leave', [ImpersonationController::class, 'leave'])
        ->name('impersonate.leave');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
