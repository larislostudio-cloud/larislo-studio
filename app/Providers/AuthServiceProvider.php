<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     * Daftarkan Policy Model di sini jika ada.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Business::class => \App\Policies\BusinessPolicy::class,
        \App\Models\ScheduledPost::class => \App\Policies\ScheduledPostPolicy::class,
        \App\Models\AIContent::class => \App\Policies\AIContentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Definisi Gate tambahan bisa diletakkan di sini atau di AppServiceProvider
    }
}
