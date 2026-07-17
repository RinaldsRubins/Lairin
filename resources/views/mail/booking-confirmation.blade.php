<x-mail::message>
# Rezervācijas apstiprinājums

Paldies, **{{ $booking->full_name }}**! Jūsu konsultācija ir apstiprināta.

**Pakalpojums:** {{ $booking->service?->name }}  
**Datums:** {{ $booking->date->translatedFormat('d.m.Y') }}  
**Laiks:** {{ \Illuminate\Support\Str::of($booking->time)->substr(0, 5) }}  
**Tikšanās veids:** {{ $booking->meeting_type === 'online' ? 'Tiešsaistē' : 'Klātienē' }}

@if ($booking->meeting_type === 'online' && $booking->google_meet_link)
**Google Meet:** [Pievienoties tikšanās]({{ $booking->google_meet_link }})
@endif

@if ($booking->comments)
**Komentāri:** {{ $booking->comments }}
@endif

Kalendāra ielūgums ir pievienots šim e-pastam (.ics fails).

<x-mail::button :url="$booking->managementUrl()">
Pārvaldīt rezervāciju
</x-mail::button>

Ar cieņu,<br>
{{ config('app.name') }}
</x-mail::message>
