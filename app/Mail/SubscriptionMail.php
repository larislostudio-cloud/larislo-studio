<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;
    public $type; // 'upgraded', 'downgraded', 'expired'

    /**
     * Create a new message instance.
     */
    public function __construct($data, string $type = 'upgraded')
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjects = [
            'upgraded'   => 'Paket Anda Berhasil Diupgrade',
            'downgraded' => 'Perubahan Paket Langganan',
            'expired'    => 'Langganan Anda Telah Berakhir',
        ];

        return new Envelope(
            subject: $subjects[$this->type] ?? 'Update Langganan LARISLO',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription-update',
        );
    }
}
