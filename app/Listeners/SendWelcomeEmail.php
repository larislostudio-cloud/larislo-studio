<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Registered; // Atau event custom Anda

class SendWelcomeEmail implements ShouldQueue
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
        // Asumsi event memiliki properti 'user'
        $user = $event->user;

        // Kirim email
        Mail::to($user->email)->send(new WelcomeMail($user));
    }
}
