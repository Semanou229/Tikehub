<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketScanController;
use App\Http\Controllers\Api\PaymentController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tickets/scan', [TicketScanController::class, 'scan'])->middleware('auth:sanctum');
Route::post('/moneroo/webhook', [PaymentController::class, 'webhook']);


