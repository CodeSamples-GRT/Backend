<?php

use App\Http\Controllers\ChatMessageIndexController;
use App\Http\Controllers\ChatMessageStoreController;
use App\Http\Controllers\ChatShowController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'chats'], function () {
        Route::get('{chatRoom:slug}', ChatShowController::class)
            ->name('chat.show');

        Route::get('{chatRoom:slug}/messages', ChatMessageIndexController::class)
            ->name('chat.messages.index');

        Route::post('{chatRoom:slug}/messages', ChatMessageStoreController::class)
            ->name('chat.messages.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
