@extends('layouts.public')

@section('content')
<section class="py-24">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-secondary-900 dark:text-white mb-4">Pārcelt konsultāciju</h1>
            <p class="text-secondary-600 dark:text-slate-400">Izvēlieties jaunu datumu un laiku.</p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="glass-card mb-6">
            <p class="text-sm text-secondary-500 dark:text-slate-400 mb-1">Pašreizējā rezervācija</p>
            <p class="font-semibold text-secondary-900 dark:text-white">
                {{ $booking->date->translatedFormat('d. F Y') }}, {{ substr($booking->time, 0, 5) }}
            </p>
        </div>

        <form method="POST" action="{{ route('booking.reschedule', ['token' => $booking->management_token]) }}" class="glass-card space-y-5">
            @csrf
            <div>
                <label for="reschedule-date" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Jauns datums *</label>
                <input type="date" id="reschedule-date" name="date" value="{{ old('date') }}" min="{{ now()->format('Y-m-d') }}" required
                       class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary">
                @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="reschedule-time" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Jauns laiks *</label>
                <input type="time" id="reschedule-time" name="time" value="{{ old('time') }}" required
                       class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary">
                @error('time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 px-6 py-3 rounded-xl bg-primary text-white font-semibold hover:bg-primary-600 transition-colors">
                    Apstiprināt pārcelšanu
                </button>
                <a href="{{ route('booking.manage', ['token' => $booking->management_token]) }}"
                   class="px-6 py-3 rounded-xl border border-secondary-200 dark:border-slate-600 text-secondary-600 dark:text-slate-300 font-semibold hover:bg-white/50 dark:hover:bg-white/5 transition-colors">
                    Atcelt
                </a>
            </div>
        </form>
    </div>
</section>
@endsection
