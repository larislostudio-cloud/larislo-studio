<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     * Biasanya digunakan untuk redirect setelah login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // Konfigurasi Rate Limiter untuk API
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            // Load API Routes
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Load Web Routes
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // CATATAN:
            // Jika Anda sudah mendefinisikan route grouping di bootstrap/app.php
            // seperti pada panduan sebelumnya, Anda tidak perlu memanggil
            // routes/admin.php, routes/ai.php, dll di sini lagi untuk menghindari duplikasi.
            // Namun, jika Anda ingin memusatkan semua di sini, Anda bisa menambahkannya:

            /*
            Route::middleware(['web', 'auth'])
                ->name('admin.')
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));
            */
        });
    }
}
