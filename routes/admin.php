<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Middleware\AdminMiddleware;

// Tambahkan 'auth' di middleware agar sesi user pasti terdeteksi
Route::middleware(['auth', AdminMiddleware::class])->name('admin.')->prefix('admin')->group(function () {

    // URL: /admin
    // View: resources/views/admin/index.blade.php
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);

    // Subscription Management
    Route::resource('subscriptions', SubscriptionController::class);

    // Analytics
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Transactions (Daftar Pembelian & Validasi)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/{transaction}/validate', [TransactionController::class, 'validatePayment'])->name('transactions.validate');
    Route::post('/transactions/{transaction}/reject', [TransactionController::class, 'reject'])->name('transactions.reject');

});
