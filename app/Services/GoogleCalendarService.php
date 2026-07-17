<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\GoogleOAuthToken;
use Carbon\Carbon;
use Google\Service\Calendar;
use Google\Service\Calendar\ConferenceData;
use Google\Service\Calendar\ConferenceSolutionKey;
use Google\Service\Calendar\CreateConferenceRequest;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;
use Google\Service\Calendar\FreeBusyRequest;
use RuntimeException;

class GoogleCalendarService
{
    public function getAvailableSlots(Carbon|string $date, ?int $durationMinutes = null): array
    {
        $timezone = config('services.google.timezone', 'Europe/Riga');
        $date = Carbon::parse($date, $timezone)->startOfDay();
        $durationMinutes ??= (int) config('services.google.slot_interval_minutes', 30);
        $interval = (int) config('services.google.slot_interval_minutes', 30);

        $dayStart = $date->copy()->setTimeFromTimeString(config('services.google.business_hours.start', '09:00'));
        $dayEnd = $date->copy()->setTimeFromTimeString(config('services.google.business_hours.end', '17:00'));

        if ($dayEnd->lte($dayStart)) {
            return [];
        }

        $busyPeriods = $this->fetchBusyPeriods($dayStart, $dayEnd);
        $existingBookings = Booking::query()
            ->with('service')
            ->whereDate('date', $date->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $slots = [];
        $current = $dayStart->copy();

        while ($current->copy()->addMinutes($durationMinutes)->lte($dayEnd)) {
            $slotEnd = $current->copy()->addMinutes($durationMinutes);

            if ($date->isToday() && $current->lte(now($timezone))) {
                $current->addMinutes($interval);
                continue;
            }

            if (
                ! $this->overlapsBusyPeriod($current, $slotEnd, $busyPeriods)
                && ! $this->overlapsExistingBooking($current, $slotEnd, $existingBookings)
            ) {
                $slots[] = $current->format('H:i');
            }

            $current->addMinutes($interval);
        }

        return $slots;
    }

    /**
     * @return array{event_id: string, meet_link: string|null}
     */
    public function createEvent(Booking $booking): array
    {
        $booking->loadMissing('service');
        $calendar = $this->getCalendarService();
        $event = $this->buildEvent($booking);

        if ($booking->meeting_type === 'online') {
            $event->setConferenceData($this->buildConferenceData($booking));
        }

        $created = $calendar->events->insert(
            config('services.google.calendar_id', 'primary'),
            $event,
            ['conferenceDataVersion' => $booking->meeting_type === 'online' ? 1 : 0]
        );

        return [
            'event_id' => $created->getId(),
            'meet_link' => $this->extractMeetLink($created),
        ];
    }

    public function updateEvent(Booking $booking): void
    {
        if (empty($booking->google_calendar_event_id)) {
            throw new RuntimeException('Booking does not have a linked Google Calendar event.');
        }

        $booking->loadMissing('service');
        $calendar = $this->getCalendarService();
        $event = $this->buildEvent($booking);
        $event->setId($booking->google_calendar_event_id);

        $calendar->events->update(
            config('services.google.calendar_id', 'primary'),
            $booking->google_calendar_event_id,
            $event
        );
    }

    public function cancelEvent(Booking $booking): void
    {
        if (empty($booking->google_calendar_event_id)) {
            return;
        }

        $calendar = $this->getCalendarService();

        $calendar->events->delete(
            config('services.google.calendar_id', 'primary'),
            $booking->google_calendar_event_id
        );
    }

    protected function getCalendarService(): Calendar
    {
        $token = GoogleOAuthToken::current();

        if ($token === null) {
            throw new RuntimeException('Google Calendar is not connected. Please authorize via Google OAuth.');
        }

        return new Calendar($token->getValidClient());
    }

    /**
     * @return array<int, array{start: Carbon, end: Carbon}>
     */
    protected function fetchBusyPeriods(Carbon $dayStart, Carbon $dayEnd): array
    {
        $calendar = $this->getCalendarService();
        $calendarId = config('services.google.calendar_id', 'primary');

        $request = new FreeBusyRequest;
        $request->setTimeMin($dayStart->toRfc3339String());
        $request->setTimeMax($dayEnd->toRfc3339String());
        $request->setTimeZone(config('services.google.timezone', 'Europe/Riga'));
        $request->setItems([['id' => $calendarId]]);

        $response = $calendar->freebusy->query($request);
        $calendarBusy = $response->getCalendars()[$calendarId] ?? null;

        if ($calendarBusy === null) {
            return [];
        }

        $timezone = config('services.google.timezone', 'Europe/Riga');

        return collect($calendarBusy->getBusy())
            ->map(fn ($period) => [
                'start' => Carbon::parse($period->getStart(), $timezone),
                'end' => Carbon::parse($period->getEnd(), $timezone),
            ])
            ->all();
    }

    protected function buildEvent(Booking $booking): Event
    {
        $timezone = config('services.google.timezone', 'Europe/Riga');
        $start = $booking->scheduled_at->timezone($timezone);
        $end = $start->copy()->addMinutes($booking->service?->duration_minutes ?? 30);

        $event = new Event;
        $event->setSummary('Konsultācija: '.$booking->full_name);
        $event->setDescription($this->buildEventDescription($booking));
        $event->setLocation($this->resolveLocation($booking));

        $startTime = new EventDateTime;
        $startTime->setDateTime($start->toRfc3339String());
        $startTime->setTimeZone($timezone);
        $event->setStart($startTime);

        $endTime = new EventDateTime;
        $endTime->setDateTime($end->toRfc3339String());
        $endTime->setTimeZone($timezone);
        $event->setEnd($endTime);

        $event->setAttendees([
            ['email' => $booking->email, 'displayName' => $booking->full_name],
        ]);

        return $event;
    }

    protected function buildConferenceData(Booking $booking): ConferenceData
    {
        $conferenceData = new ConferenceData;
        $createRequest = new CreateConferenceRequest;
        $createRequest->setRequestId('booking-'.$booking->id.'-'.uniqid());
        $createRequest->setConferenceSolutionKey(
            new ConferenceSolutionKey(['type' => 'hangoutsMeet'])
        );
        $conferenceData->setCreateRequest($createRequest);

        return $conferenceData;
    }

    protected function buildEventDescription(Booking $booking): string
    {
        $lines = [
            'Pakalpojums: '.($booking->service?->name ?? 'Konsultācija'),
            'Klients: '.$booking->full_name,
            'E-pasts: '.$booking->email,
            'Tālrunis: '.$booking->phone,
            'Tikšanās veids: '.($booking->meeting_type === 'online' ? 'Tiešsaistē' : 'Klātienē'),
        ];

        if ($booking->company) {
            $lines[] = 'Uzņēmums: '.$booking->company;
        }

        if ($booking->comments) {
            $lines[] = 'Komentāri: '.$booking->comments;
        }

        if ($booking->management_token) {
            $lines[] = 'Pārvaldīt rezervāciju: '.$booking->managementUrl();
        }

        return implode("\n", $lines);
    }

    protected function resolveLocation(Booking $booking): string
    {
        if ($booking->meeting_type === 'online') {
            return $booking->google_meet_link ?? 'Google Meet';
        }

        return config('services.google.onsite_location', 'Lairin birojs');
    }

    protected function extractMeetLink(Event $event): ?string
    {
        $entryPoints = $event->getConferenceData()?->getEntryPoints() ?? [];

        foreach ($entryPoints as $entryPoint) {
            if ($entryPoint->getEntryPointType() === 'video') {
                return $entryPoint->getUri();
            }
        }

        return $event->getHangoutLink();
    }

    /**
     * @param  array<int, array{start: Carbon, end: Carbon}>  $busyPeriods
     */
    protected function overlapsBusyPeriod(Carbon $slotStart, Carbon $slotEnd, array $busyPeriods): bool
    {
        foreach ($busyPeriods as $period) {
            if ($slotStart->lt($period['end']) && $slotEnd->gt($period['start'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  \Illuminate\Support\Collection<int, Booking>  $bookings
     */
    protected function overlapsExistingBooking(Carbon $slotStart, Carbon $slotEnd, $bookings): bool
    {
        foreach ($bookings as $booking) {
            $bookingStart = $booking->scheduled_at;
            $bookingEnd = $bookingStart->copy()->addMinutes($booking->service?->duration_minutes ?? 30);

            if ($slotStart->lt($bookingEnd) && $slotEnd->gt($bookingStart)) {
                return true;
            }
        }

        return false;
    }
}
