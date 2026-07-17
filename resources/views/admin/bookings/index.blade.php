@extends('admin.layout')

@section('page_title', 'Rezervācijas')

@section('content')
@php
    $statusLabels = [
        'pending' => 'Gaida',
        'confirmed' => 'Apstiprināts',
        'cancelled' => 'Atcelts',
        'rescheduled' => 'Pārcelts',
    ];
@endphp

<div class="mb-6">
    <form method="GET" action="{{ route('admin.bookings.index') }}" class="flex flex-wrap items-end gap-4">
        <div>
            <label for="status" class="block text-xs font-medium text-secondary-500 mb-1">Statuss</label>
            <select id="status" name="status"
                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                <option value="">Visi</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $statusLabels[$status] ?? $status }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="date" class="block text-xs font-medium text-secondary-500 mb-1">Datums</label>
            <input type="date" id="date" name="date" value="{{ $filters['date'] ?? '' }}"
                   class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
        </div>
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors">
            Filtrēt
        </button>
        @if(!empty(array_filter($filters ?? [])))
            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-secondary-500 hover:text-primary">Notīrīt</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Klients</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Pakalpojums</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Datums / laiks</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Tikšanās</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Statuss</th>
                    <th class="text-right px-6 py-3 font-semibold text-secondary-700">Darbības</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-secondary-900">{{ $booking->full_name }}</div>
                            <div class="text-xs text-secondary-500">{{ $booking->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-secondary-600">{{ $booking->service?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-secondary-600">
                            {{ $booking->date->format('d.m.Y') }} {{ substr($booking->time, 0, 5) }}
                        </td>
                        <td class="px-6 py-4 text-secondary-600">
                            {{ $booking->meeting_type === 'online' ? 'Tiešsaistē' : 'Klātienē' }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'confirmed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    'rescheduled' => 'bg-blue-100 text-blue-700',
                                ];
                            @endphp
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$booking->status] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ $statusLabels[$booking->status] ?? $booking->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="text-primary hover:underline text-xs font-medium">Skatīt</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-secondary-500">Nav rezervāciju</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">{{ $bookings->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
