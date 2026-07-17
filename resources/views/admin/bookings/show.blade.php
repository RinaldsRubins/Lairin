@extends('admin.layout')

@section('page_title', 'Rezervācija — ' . $booking->full_name)

@section('content')
@php
    $statusLabels = [
        'pending' => 'Gaida apstiprinājumu',
        'confirmed' => 'Apstiprināts',
        'cancelled' => 'Atcelts',
        'rescheduled' => 'Pārcelts',
    ];
@endphp

<div class="mb-6">
    <a href="{{ route('admin.bookings.index') }}" class="text-sm text-secondary-500 hover:text-primary">← Atpakaļ uz sarakstu</a>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-secondary-900">{{ $booking->full_name }}</h2>
                    @if($booking->company)
                        <p class="text-sm text-secondary-500 mt-1">{{ $booking->company }}</p>
                    @endif
                </div>
                @php
                    $statusColors = [
                        'pending' => 'bg-amber-100 text-amber-700',
                        'confirmed' => 'bg-green-100 text-green-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                        'rescheduled' => 'bg-blue-100 text-blue-700',
                    ];
                @endphp
                <span class="shrink-0 inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$booking->status] ?? 'bg-slate-100 text-slate-600' }}">
                    {{ $statusLabels[$booking->status] ?? $booking->status }}
                </span>
            </div>

            <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-secondary-500">E-pasts</dt>
                    <dd class="font-medium text-secondary-900 mt-1">
                        <a href="mailto:{{ $booking->email }}" class="text-primary hover:underline">{{ $booking->email }}</a>
                    </dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Tālrunis</dt>
                    <dd class="font-medium text-secondary-900 mt-1">
                        <a href="tel:{{ $booking->phone }}" class="text-primary hover:underline">{{ $booking->phone }}</a>
                    </dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Pakalpojums</dt>
                    <dd class="font-medium text-secondary-900 mt-1">{{ $booking->service?->name ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Tikšanās veids</dt>
                    <dd class="font-medium text-secondary-900 mt-1">{{ $booking->meeting_type === 'online' ? 'Tiešsaistē' : 'Klātienē' }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Datums</dt>
                    <dd class="font-medium text-secondary-900 mt-1">{{ $booking->date->format('d.m.Y') }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Laiks</dt>
                    <dd class="font-medium text-secondary-900 mt-1">{{ substr($booking->time, 0, 5) }}</dd>
                </div>
            </dl>

            @if($booking->comments)
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <dt class="text-sm text-secondary-500 mb-2">Komentāri</dt>
                    <dd class="text-sm text-secondary-800 whitespace-pre-line">{{ $booking->comments }}</dd>
                </div>
            @endif
        </div>

        @if($booking->google_meet_link)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-sm font-bold text-secondary-900 mb-2">Google Meet</h3>
                <a href="{{ $booking->google_meet_link }}" target="_blank" class="text-sm text-primary hover:underline break-all">
                    {{ $booking->google_meet_link }}
                </a>
            </div>
        @endif
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-bold text-secondary-900 mb-4">Mainīt statusu</h3>
            <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label for="status" class="block text-sm font-medium text-secondary-700 mb-1">Statuss</label>
                    <select id="status" name="status" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        @foreach(['pending', 'confirmed', 'cancelled', 'rescheduled'] as $status)
                            <option value="{{ $status }}" @selected($booking->status === $status)>{{ $statusLabels[$status] ?? $status }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors">
                    Atjaunināt statusu
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-bold text-secondary-900 mb-4">Pārvaldība</h3>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-secondary-500">Izveidots</dt>
                    <dd class="text-secondary-900 mt-1">{{ $booking->created_at->format('d.m.Y H:i') }}</dd>
                </div>
                @if($booking->cancelled_at)
                    <div>
                        <dt class="text-secondary-500">Atcelts</dt>
                        <dd class="text-secondary-900 mt-1">{{ $booking->cancelled_at->format('d.m.Y H:i') }}</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-secondary-500">Klienta saite</dt>
                    <dd class="mt-1">
                        <a href="{{ $booking->managementUrl() }}" target="_blank" class="text-xs text-primary hover:underline break-all">
                            Pārvaldīt rezervāciju →
                        </a>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
