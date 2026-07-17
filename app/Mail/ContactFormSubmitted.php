<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactMessage $message,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Jauna kontaktformas ziņa: '.$this->message->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.contact-form-submitted',
            with: [
                'contactMessage' => $this->message,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
