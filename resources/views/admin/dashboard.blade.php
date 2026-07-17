@extends('admin.layout')

@section('page_title', 'Panelis')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    @foreach([
        ['label' => 'Gaida apstiprinājumu', 'value' => $stats['bookings_pending'], 'color' => 'amber'],
        ['label' => 'Šodienas rezervācijas', 'value' => $stats['bookings_today'], 'color' => 'primary'],
        ['label' => 'Nelasītas ziņas', 'value' => $stats['unread_messages'], 'color' => 'accent'],
        ['label' => 'Projekti', 'value' => $stats['published_projects'], 'color' => 'green'],
        ['label' => 'Raksti', 'value' => $stats['published_posts'], 'color' => 'blue'],
    ] as $stat)
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <div class="text-2xl font-bold text-secondary-900">{{ $stat['value'] }}</div>
            <div class="text-sm text-secondary-500 mt-1">{{ $stat['label'] }}</div>
        </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-2 gap-6">
    {{-- Recent bookings --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="font-bold text-secondary-900">Jaunākās rezervācijas</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-primary hover:underline">Visas →</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($recentBookings as $booking)
                <a href="{{ route('admin.bookings.show', $booking) }}" class="block px-6 py-4 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-semibold text-secondary-900 text-sm">{{ $booking->full_name }}</div>
                            <div class="text-xs text-secondary-500">{{ $booking->service?->name }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-secondary-500">{{ $booking->date->format('d.m.Y') }} {{ substr($booking->time, 0, 5) }}</div>
                            <span class="text-xs font-medium {{ $booking->status === 'pending' ? 'text-amber-600' : 'text-green-600' }}">{{ ucfirst($booking->status) }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="px-6 py-8 text-center text-secondary-500 text-sm">Nav rezervāciju</div>
            @endforelse
        </div>
    </div>

    {{-- Recent messages --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="font-bold text-secondary-900">Jaunākās ziņas</h2>
            <a href="{{ route('admin.contact-messages.index') }}" class="text-sm text-primary hover:underline">Visas →</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($recentMessages as $message)
                <a href="{{ route('admin.contact-messages.show', $message) }}" class="block px-6 py-4 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <div class="font-semibold text-secondary-900 text-sm truncate">{{ $message->subject }}</div>
                            <div class="text-xs text-secondary-500">{{ $message->name }} · {{ $message->email }}</div>
                        </div>
                        @if(!$message->is_read)
                            <span class="shrink-0 w-2 h-2 rounded-full bg-primary"></span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="px-6 py-8 text-center text-secondary-500 text-sm">Nav ziņu</div>
            @endforelse
        </div>
    </div>
</div>

<div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach([
        ['route' => 'admin.service-categories.create', 'label' => 'Jauns pakalpojums'],
        ['route' => 'admin.projects.create', 'label' => 'Jauns projekts'],
        ['route' => 'admin.blog-posts.create', 'label' => 'Jauns raksts'],
        ['route' => 'admin.seo.index', 'label' => 'SEO iestatījumi'],
    ] as $action)
        <a href="{{ route($action['route']) }}" class="bg-white rounded-xl border border-slate-200 p-4 text-center text-sm font-semibold text-primary hover:border-primary/30 hover:bg-primary/5 transition-colors">
            + {{ $action['label'] }}
        </a>
    @endforeach
</div>
@endsection
