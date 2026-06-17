<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $amount;
    protected $planName;

    public function __construct($amount, $planName)
    {
        $this->amount = $amount;
        $this->planName = $planName;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pembayaran Berhasil - LARISLO')
            ->greeting('Terima kasih, ' . $notifiable->name . '!')
            ->line('Pembayaran Anda sebesar Rp ' . number_format($this->amount, 0, ',', '.') . ' untuk paket ' . $this->planName . ' telah berhasil.')
            ->line('Sekarang Anda dapat mengakses semua fitur premium.')
            ->action('Mulai Sekarang', route('dashboard'))
            ->line('Simpan email ini sebagai bukti transaksi.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pembayaran Berhasil',
            'message' => 'Pembayaran untuk paket ' . $this->planName . ' telah dikonfirmasi.',
            'icon' => 'credit-card',
            'color' => 'primary',
        ];
    }
}
