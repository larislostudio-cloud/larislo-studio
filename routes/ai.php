<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AI\AICaptionController;
use App\Http\Controllers\AI\AIImageController;
use App\Http\Controllers\AI\AIVideoController;
use App\Http\Controllers\AI\AIVoiceController;

/*
|--------------------------------------------------------------------------
| AI Routes
|--------------------------------------------------------------------------
|
| Route untuk mengakses fitur AI.
| Semua route di sini memerlukan autentikasi ('auth').
|
*/

Route::middleware(['auth'])->name('ai.')->prefix('ai')->group(function () {

    // ==================================================================
    // ROUTES UNTUK TAMPILAN (GET)
    // Tidak dibatasi throttle ketat karena hanya menampilkan view.
    // ==================================================================

    Route::get('/caption', [AICaptionController::class, 'index'])->name('caption.index');
    Route::get('/image', [AIImageController::class, 'index'])->name('image.index');
    Route::get('/video', [AIVideoController::class, 'index'])->name('video.index');
    Route::get('/voice', [AIVoiceController::class, 'index'])->name('voice.index');


    // ==================================================================
    // ROUTES UNTUK PROSES (POST)
    // ==================================================================

    // 1. Autosave Video Editor (Diluar throttle ketat)
    // Ini dipisahkan karena autosave berjalan berkala (setiap 15 detik),
    // jika masuk throttle akan terkena block/spam detection.
    Route::post('/video/autosave', [AIVideoController::class, 'autosave'])->name('video.autosave');

    Route::post('/video/ai-generate', [AIVideoController::class, 'aiGenerate'])->name('video.ai-generate');

    // 2. Routes AI Generate (Dengan throttle ketat)
    // Mencegah spam request yang menguras kredit/server AI.
    Route::middleware(['throttle:ai-generate'])->group(function () {

        Route::post('/caption/generate', [AICaptionController::class, 'generate'])->name('caption.generate');
        Route::post('/image/generate', [AIImageController::class, 'generate'])->name('image.generate');
        Route::post('/video/generate', [AIVideoController::class, 'generate'])->name('video.generate');
        Route::post('/voice/generate', [AIVoiceController::class, 'generate'])->name('voice.generate');

    });

});
