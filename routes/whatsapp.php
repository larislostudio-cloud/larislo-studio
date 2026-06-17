<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsApp\WhatsAppBotController;
use App\Http\Controllers\WhatsApp\WhatsAppWebhookController;
use App\Http\Controllers\WhatsApp\WhatsAppMessageController;

Route::name('whatsapp.')->prefix('whatsapp')->group(function () {

    // Grup yang butuh Auth (UI Customer)
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [WhatsAppMessageController::class, 'index'])->name('index');
        Route::post('/send', [WhatsAppMessageController::class, 'sendManual'])->name('send');
        Route::post('/train', [WhatsAppBotController::class, 'trainAI'])->name('train');

        // BARU: Route simpan pengaturan bot
        Route::post('/settings', [WhatsAppBotController::class, 'saveSettings'])->name('settings.save');
    });

    // Public Webhook (Untuk menerima pesan dari Provider WA)
    Route::get('webhook', [WhatsAppWebhookController::class, 'verify'])->name('webhook.verify');
    Route::post('webhook', [WhatsAppWebhookController::class, 'handle'])->name('webhook.handle');

});
