<?php

namespace App\Jobs;

use App\Mail\BookingReminder;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendBookingReminders implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $this->sendReminders('24h', 24, 'reminder_24h_sent_at');
        $this->sendReminders('1h', 1, 'reminder_1h_sent_at');
    }

    protected function sendReminders(string $type, int $hoursAhead, string $sentAtColumn): void
    {
        $windowStart = now()->addHours($hoursAhead)->subMinutes(7);
        $windowEnd = now()->addHours($hoursAhead)->addMinutes(7);

        $bookings = Booking::query()
            ->with('service')
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereNull($sentAtColumn)
            ->whereNull('cancelled_at')
            ->get()
            ->filter(function (Booking $booking) use ($windowStart, $windowEnd) {
                $scheduledAt = $booking->scheduled_at;

                return $scheduledAt->between($windowStart, $windowEnd);
            });

        foreach ($bookings as $booking) {
            Mail::to($booking->email)->send(new BookingReminder($booking, $type));

            $booking->forceFill([
                $sentAtColumn => Carbon::now(),
            ])->save();
        }
    }
}
