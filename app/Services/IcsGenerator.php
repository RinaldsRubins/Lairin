<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;

class IcsGenerator
{
    public function generate(Booking $booking): string
    {
        $booking->loadMissing('service');

        $start = $booking->scheduled_at;
        $end = $start->copy()->addMinutes($booking->service?->duration_minutes ?? 30);
        $uid = "booking-{$booking->id}@".parse_url(config('app.url'), PHP_URL_HOST);
        $now = now()->utc()->format('Ymd\THis\Z');
        $dtStart = $start->utc()->format('Ymd\THis\Z');
        $dtEnd = $end->utc()->format('Ymd\THis\Z');

        $summary = 'Konsultācija: '.$booking->full_name;
        $description = $this->escapeText($this->buildDescription($booking));
        $location = $booking->meeting_type === 'online'
            ? ($booking->google_meet_link ?? 'Tiešsaistes tikšanās')
            : config('services.google.onsite_location', 'Lairin birojs');

        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Lairin//Konsultācijas//LV',
            'CALSCALE:GREGORIAN',
            'METHOD:REQUEST',
            'BEGIN:VEVENT',
            'UID:'.$uid,
            'DTSTAMP:'.$now,
            'DTSTART:'.$dtStart,
            'DTEND:'.$dtEnd,
            'SUMMARY:'.$this->escapeText($summary),
            'DESCRIPTION:'.$description,
            'LOCATION:'.$this->escapeText($location),
            'ORGANIZER;CN=Lairin:MAILTO:'.config('mail.from.address'),
            'ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE:MAILTO:'.$booking->email,
            'STATUS:CONFIRMED',
            'SEQUENCE:0',
            'END:VEVENT',
            'END:VCALENDAR',
        ];

        return implode("\r\n", $lines)."\r\n";
    }

    protected function buildDescription(Booking $booking): string
    {
        $parts = [
            'Pakalpojums: '.($booking->service?->name ?? 'Konsultācija'),
            'Klients: '.$booking->full_name,
            'E-pasts: '.$booking->email,
            'Tālrunis: '.$booking->phone,
            'Tikšanās veids: '.($booking->meeting_type === 'online' ? 'Tiešsaistē' : 'Klātienē'),
        ];

        if ($booking->company) {
            $parts[] = 'Uzņēmums: '.$booking->company;
        }

        if ($booking->google_meet_link) {
            $parts[] = 'Google Meet: '.$booking->google_meet_link;
        }

        if ($booking->comments) {
            $parts[] = 'Komentāri: '.$booking->comments;
        }

        return implode('\\n', $parts);
    }

    protected function escapeText(string $text): string
    {
        return str_replace(["\r\n", "\n", "\r", ',', ';'], ['\\n', '\\n', '\\n', '\\,', '\\;'], $text);
    }
}
