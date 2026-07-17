<x-mail::message>
# Atgādinājums par tikšanos

Sveiki, **{{ $booking->full_name }}**!

Atgādinām, ka jūsu konsultācija notiks **{{ $reminderLabel }}**.

**Pakalpojums:** {{ $booking->service?->name }}  
**Datums:** {{ $booking->date->translatedFormat('d.m.Y') }}  
**Laiks:** {{ \Illuminate\Support\Str::of($booking->time)->substr(0, 5) }}  
**Tikšanās veids:** {{ $booking->meeting_type === 'online' ? 'Tiešsaistē' : 'Klātienē' }}

@if ($booking->meeting_type === 'online' && $booking->google_meet_link)
**Google Meet:** [Pievienoties tikšanās]({{ $booking->google_meet_link }})
@endif

<x-mail::button :url="$booking->managementUrl()">
Pārvaldīt rezervāciju
</x-mail::button>

Ar cieņu,<br>
{{ config('app.name') }}
</x-mail::message>
