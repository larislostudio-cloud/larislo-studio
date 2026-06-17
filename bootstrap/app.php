<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route; // Penting: Import Route Facade

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        // Tambahkan custom routes di sini
        then: function () {
            Route::middleware(['web', 'auth'])
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('ai')
                ->group(base_path('routes/ai.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('billing')
                ->group(base_path('routes/billing.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('social')
                ->group(base_path('routes/social.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('whatsapp')
                ->group(base_path('routes/whatsapp.php'));

            Route::middleware(['web'])
                ->prefix('marketplace')
                ->group(base_path('routes/marketplace.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Tambahkan ini untuk membolehkan request dari Midtrans tanpa CSRF token
        $middleware->validateCsrfTokens(except: [
            'midtrans/callback',
             '/whatsapp/webhook',
        ]);

            $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
