<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Billing\BillingController;
use App\Http\Controllers\Billing\MidtransController; // 1. TAMBAHKAN INI (Penting!)

Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
Route::post('/billing/buy/{id}', [BillingController::class, 'buy'])->name('billing.buy');

// Callback Midtrans
// CATATAN: Route ini nanti harus dikecualikan dari CSRF verifikasi di bootstrap/app.php
Route::post('midtrans/callback', [MidtransController::class, 'callback'])->name('midtrans.callback');
