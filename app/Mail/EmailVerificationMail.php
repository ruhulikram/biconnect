<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $token,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi Email — BiConnect',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.email-verification',
            with: [
                'verificationUrl' => url('/verifikasi-email/' . $this->token),
            ],
        );
    }
}
