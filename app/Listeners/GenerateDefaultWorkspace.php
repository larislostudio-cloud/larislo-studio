<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Business;

class GenerateDefaultWorkspace
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
     */
    public function handle(object $event): void
    {
        $user = $event->user;

        // Cek agar tidak membuat duplikat jika sudah ada
        if (!$user->business) {
            Business::create([
                'user_id'       => $user->id,
                'business_name' => $user->name . "'s Business",
                'niche'         => 'General', // Default value
            ]);
        }
    }
}
