<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Social\SchedulerController;
use App\Http\Controllers\Social\InstagramController;
use App\Http\Controllers\Social\FacebookController;
use App\Http\Controllers\Social\TikTokController;

Route::name('social.')->prefix('social')->group(function () {

    // Scheduler
    Route::get('/scheduler', [SchedulerController::class, 'create'])->name('scheduler.create');
    Route::post('/scheduler', [SchedulerController::class, 'schedule'])->name('scheduler.store');

    // Instagram OAuth
    Route::get('instagram/connect', [InstagramController::class, 'connect'])->name('instagram.connect');
    Route::get('instagram/callback', [InstagramController::class, 'callback'])->name('instagram.callback');

    // Facebook OAuth
    Route::get('facebook/connect', [FacebookController::class, 'connect'])->name('facebook.connect');
    Route::get('facebook/callback', [FacebookController::class, 'callback'])->name('facebook.callback');

    // TikTok OAuth
    Route::get('tiktok/connect', [TikTokController::class, 'connect'])->name('tiktok.connect');
    Route::get('tiktok/callback', [TikTokController::class, 'callback'])->name('tiktok.callback');

});
