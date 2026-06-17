<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // Import Gate untuk Auth
use Illuminate\Support\Facades\RateLimiter; // Import RateLimiter
use Illuminate\Cache\RateLimiting\Limit; // Import Limit
use Illuminate\Http\Request; // Import Request
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Konfigurasi Gate untuk Authorization (Role Management)
        // Ini mendefinisikan siapa yang boleh mengakses apa

        Gate::define('access-admin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('access-agency', function (User $user) {
            return in_array($user->role, ['admin', 'agency']);
        });

        Gate::define('access-pro', function (User $user) {
            return in_array($user->role, ['admin', 'agency', 'pro']);
        });

        // Konfigurasi Rate Limiter untuk AI Generate
        RateLimiter::for('ai-generate', function (Request $request) {
            // Maksimal 10 request per menit per user
            return Limit::perMinute(10)->by($request->user()->id);
        });
    }
}
