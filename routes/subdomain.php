<?php

use App\Http\Controllers\Subdomain\EventPageController;
use App\Http\Controllers\Subdomain\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventPageController::class, 'show'])->name('subdomain.event.show');
Route::get('/tickets', [TicketController::class, 'index'])->name('subdomain.tickets.index');
Route::post('/tickets/purchase', [TicketController::class, 'purchase'])->name('subdomain.tickets.purchase');

