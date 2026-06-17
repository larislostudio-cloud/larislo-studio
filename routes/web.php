<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Planner\ContentPlannerController;
use App\Http\Controllers\WhatsApp\WhatsAppBotController; // Tambahkan ini
use App\Http\Controllers\StoreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page (Public)
Route::get('/', function () {
    return view('landing.index');
})->name('landing');

// ==========================================
// WHATSAPP WEBHOOK (Harus Public / Tanpa Auth)
// Dipanggil oleh server Fonnte/Wablas
// ==========================================
Route::post('/whatsapp/webhook', [WhatsAppBotController::class, 'handleWebhook'])->name('whatsapp.webhook');
// ^ Pastikan method handleWebhook() ada di Controller Anda

// Group untuk User yang sudah login
Route::middleware(['auth'])->group(function () {

    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==========================================
    // PLANNER ROUTES
    // ==========================================
    Route::get('/planner', [ContentPlannerController::class, 'index'])->name('planner.index');
    Route::post('/planner', [ContentPlannerController::class, 'store'])->name('planner.store');
    Route::post('/planner/generate', [ContentPlannerController::class, 'generateAI'])->name('planner.generate');

    // Affiliate Tools
    Route::get('/affiliate', function () {
        return view('affiliate.index');
    })->name('affiliate.index');

    // Analytics
    Route::get('/analytics', function () {
        return view('analytics.index');
    })->name('analytics.index');

    // Store
    Route::get('/biodata', [StoreController::class, 'create'])->name('biodata.create');
    Route::post('/biodata', [StoreController::class, 'store'])->name('biodata.store');

    require __DIR__.'/admin.php';
    require __DIR__.'/ai.php';
    require __DIR__.'/billing.php';
    require __DIR__.'/social.php';
    require __DIR__.'/whatsapp.php'; // Dashboard routes tetap di dalam auth
    require __DIR__.'/marketplace.php';
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

require __DIR__.'/auth.php';
