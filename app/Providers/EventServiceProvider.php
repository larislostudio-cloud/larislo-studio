<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// Import Listeners custom yang sudah dibuat
use App\Listeners\SendWelcomeEmail;
use App\Listeners\GenerateDefaultWorkspace;
use App\Listeners\LogActivity;

// Import Events custom
use App\Events\SubscriptionActivated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Event bawaan Laravel saat user register
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendWelcomeEmail::class,        // Custom Listener
            GenerateDefaultWorkspace::class, // Custom Listener
        ],

        // Event saat user login
        Login::class => [
            LogActivity::class,
        ],

        // Contoh event custom
        SubscriptionActivated::class => [
            // Tambahkan listener jika ada, contoh: UpdateUsageStats::class
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
