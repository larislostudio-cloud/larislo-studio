<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * Bisa di-handle secara spesifik per event atau generic.
     */
    public function handle(object $event): void
    {
        $user = auth()->user();
        $userName = $user ? $user->name : 'Guest';

        // Contoh logic logging sederhana
        if ($event instanceof Login) {
            $message = "User [{$userName}] logged in.";
        } elseif ($event instanceof Logout) {
            $message = "User [{$userName}] logged out.";
        } else {
            $message = "Activity triggered by [{$userName}].";
        }

        // Tulis ke file log (storage/logs/laravel.log)
        Log::info($message, [
            'user_id' => $user->id ?? null,
            'ip' => request()->ip(),
        ]);
    }
}
