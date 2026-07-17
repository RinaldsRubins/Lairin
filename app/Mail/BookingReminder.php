<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingReminder extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
        public string $reminderType,
    ) {
        $this->booking->loadMissing('service');
    }

    public function envelope(): Envelope
    {
        $subject = $this->reminderType === '1h'
            ? 'Atgādinājums: tikšanās pēc 1 stundas'
            : 'Atgādinājums: tikšanās rīt';

        return new Envelope(
            subject: $subject.' — '.$this->booking->service?->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.booking-reminder',
            with: [
                'booking' => $this->booking,
                'reminderType' => $this->reminderType,
                'reminderLabel' => $this->reminderType === '1h'
                    ? 'pēc 1 stundas'
                    : 'rīt',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
