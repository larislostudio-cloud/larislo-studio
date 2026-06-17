<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController; // Contoh

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public API
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

// Protected API (Sanctum)
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // API untuk generate caption via mobile app, dll
    // Route::post('/ai/caption', [Api\AIController::class, 'generateCaption']);

});
