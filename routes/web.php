<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Événements
    Route::resource('events', EventController::class)->except(['index', 'show']);
    Route::post('/events/{event}/publish', [EventController::class, 'publish'])->name('events.publish');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    // Billets
    Route::get('/events/{event}/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/tickets/purchase', [TicketController::class, 'purchase'])->name('tickets.purchase');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/download', [TicketController::class, 'download'])->name('tickets.download');

    // Paiements
    Route::get('/payments/{payment}/return', [PaymentController::class, 'return'])->name('payments.return');
    Route::post('/payments/callback', [PaymentController::class, 'callback'])->name('payments.callback');
});

