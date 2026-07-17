<?php

namespace App\Jobs;

use App\Mail\BookingConfirmation;
use App\Models\Booking;
use App\Services\GoogleCalendarService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class CreateGoogleCalendarEvent implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $backoff = 60;

    public function __construct(
        public Booking $booking,
    ) {}

    public function handle(GoogleCalendarService $calendarService): void
    {
        $booking = $this->booking->fresh(['service']);

        if ($booking === null) {
            return;
        }

        if ($booking->status === 'cancelled' || $booking->google_calendar_event_id) {
            return;
        }

        $result = $calendarService->createEvent($booking);

        $booking->update([
            'google_calendar_event_id' => $result['event_id'],
            'google_meet_link' => $result['meet_link'],
            'status' => 'confirmed',
        ]);

        Mail::to($booking->email)->send(new BookingConfirmation($booking->fresh(['service'])));
    }

    public function failed(?Throwable $exception): void
    {
        Log::error('Failed to create Google Calendar event for booking.', [
            'booking_id' => $this->booking->id,
            'error' => $exception?->getMessage(),
        ]);
    }
}
