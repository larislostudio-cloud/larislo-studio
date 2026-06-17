<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $planName;

    public function __construct($planName = 'Pro')
    {
        $this->planName = $planName;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Langganan LARISLO Anda Telah Berakhir')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Langganan paket ' . $this->planName . ' Anda telah berakhir.')
            ->line('Upgrade sekarang untuk tetap menikmati fitur AI dan Auto Posting tanpa gangguan.')
            ->action('Perpanjang Sekarang', route('billing.index'))
            ->line('Terima kasih telah menggunakan LARISLO!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Langganan Berakhir',
            'message' => 'Paket ' . $this->planName . ' Anda telah berakhir. Upgrade untuk melanjutkan.',
            'icon' => 'exclamation-circle',
            'color' => 'danger',
        ];
    }
}
