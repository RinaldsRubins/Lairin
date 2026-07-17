<?php

namespace App\Mail;

use App\Models\Booking;
use App\Services\IcsGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
    ) {
        $this->booking->loadMissing('service');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rezervācijas apstiprinājums — '.$this->booking->service?->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.booking-confirmation',
            with: [
                'booking' => $this->booking,
            ],
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn () => app(IcsGenerator::class)->generate($this->booking),
                'tikšanās.ics',
            )->withMime('text/calendar; method=REQUEST'),
        ];
    }
}
