<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostPublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $platform;
    protected $postId;

    public function __construct(string $platform, int $postId)
    {
        $this->platform = $platform;
        $this->postId = $postId;
    }

    public function via(object $notifiable): array
    {
        // Biasanya notifikasi ini hanya perlu disimpan di database (dashboard)
        // Email bisa diaktifkan jika user menginginkannya
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Post Berhasil Diterbitkan')
            ->line('Postingan Anda di ' . ucfirst($this->platform) . ' telah berhasil diterbitkan.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Post Berhasil Diterbitkan',
            'message' => 'Postingan Anda di ' . ucfirst($this->platform) . ' sudah live!',
            'link' => route('scheduler.show', $this->postId),
            'icon' => 'check-circle',
            'color' => 'success',
        ];
    }
}
