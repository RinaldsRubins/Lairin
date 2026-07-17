@extends('layouts.public')

@section('content')
<section class="py-24">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-secondary-900 dark:text-white mb-4">
                Pārvaldīt <span class="text-gradient">rezervāciju</span>
            </h1>
            <p class="text-secondary-600 dark:text-slate-400">Skatiet, atceliet vai pārceliet savu konsultāciju.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="glass-card mb-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-secondary-900 dark:text-white">Rezervācijas detaļas</h2>
                @php
                    $statusLabels = [
                        'pending' => ['Gaida apstiprinājumu', 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300'],
                        'confirmed' => ['Apstiprināta', 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300'],
                        'cancelled' => ['Atcelta', 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'],
                        'rescheduled' => ['Pārcelta', 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300'],
                        'completed' => ['Pabeigta', 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300'],
                    ];
                    [$statusLabel, $statusClass] = $statusLabels[$booking->status] ?? [$booking->status, 'bg-slate-100 text-slate-800'];
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
            </div>

            <dl class="space-y-4">
                <div class="flex justify-between py-3 border-b border-white/10">
                    <dt class="text-secondary-500 dark:text-slate-400">Vārds</dt>
                    <dd class="font-semibold text-secondary-900 dark:text-white">{{ $booking->full_name }}</dd>
                </div>
                @if($booking->company)
                    <div class="flex justify-between py-3 border-b border-white/10">
                        <dt class="text-secondary-500 dark:text-slate-400">Uzņēmums</dt>
                        <dd class="font-semibold text-secondary-900 dark:text-white">{{ $booking->company }}</dd>
                    </div>
                @endif
                <div class="flex justify-between py-3 border-b border-white/10">
                    <dt class="text-secondary-500 dark:text-slate-400">E-pasts</dt>
                    <dd class="font-semibold text-secondary-900 dark:text-white">{{ $booking->email }}</dd>
                </div>
                <div class="flex justify-between py-3 border-b border-white/10">
                    <dt class="text-secondary-500 dark:text-slate-400">Pakalpojums</dt>
                    <dd class="font-semibold text-secondary-900 dark:text-white">{{ $booking->service?->name ?? '—' }}</dd>
                </div>
                <div class="flex justify-between py-3 border-b border-white/10">
                    <dt class="text-secondary-500 dark:text-slate-400">Datums un laiks</dt>
                    <dd class="font-semibold text-secondary-900 dark:text-white">
                        {{ $booking->date->translatedFormat('d. F Y') }}, {{ substr($booking->time, 0, 5) }}
                    </dd>
                </div>
                <div class="flex justify-between py-3 border-b border-white/10">
                    <dt class="text-secondary-500 dark:text-slate-400">Tikšanās veids</dt>
                    <dd class="font-semibold text-secondary-900 dark:text-white">{{ $booking->meeting_type === 'online' ? 'Tiešsaistē' : 'Klātienē' }}</dd>
                </div>
                @if($booking->google_meet_link)
                    <div class="flex justify-between py-3 border-b border-white/10">
                        <dt class="text-secondary-500 dark:text-slate-400">Google Meet</dt>
                        <dd><a href="{{ $booking->google_meet_link }}" target="_blank" class="text-primary font-semibold hover:underline">Pievienoties</a></dd>
                    </div>
                @endif
            </dl>
        </div>

        @if($booking->isCancellable())
            <div class="grid sm:grid-cols-2 gap-4">
                <a href="{{ route('booking.reschedule', ['token' => $booking->management_token]) }}"
                   class="flex items-center justify-center gap-2 px-6 py-4 rounded-xl bg-primary text-white font-semibold hover:bg-primary-600 transition-colors">
                    <x-icon name="calendar" class="w-5 h-5" />
                    Pārcelt
                </a>

                <form method="POST" action="{{ route('booking.cancel', ['token' => $booking->management_token]) }}"
                      onsubmit="return confirm('Vai tiešām vēlaties atcelt šo rezervāciju?')">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-6 py-4 rounded-xl border-2 border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 font-semibold hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        <x-icon name="x" class="w-5 h-5" />
                        Atcelt
                    </button>
                </form>
            </div>
        @elseif($booking->status === 'cancelled')
            <div class="glass-card text-center !p-8">
                <p class="text-secondary-600 dark:text-slate-400 mb-4">Šī rezervācija ir atcelta.</p>
                <a href="{{ route('booking.index') }}" class="inline-flex items-center gap-2 text-primary font-semibold hover:underline">
                    Pieteikt jaunu konsultāciju
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
