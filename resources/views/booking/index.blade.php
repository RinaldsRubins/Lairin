@extends('layouts.public')

@section('content')
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-enterprise opacity-10"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
        <span class="text-primary font-semibold text-sm uppercase tracking-wider">Konsultācija</span>
        <h1 class="text-4xl sm:text-5xl font-bold text-secondary-900 dark:text-white mt-2 mb-6">
            Pieteikt <span class="text-gradient">konsultāciju</span>
        </h1>
        <p class="text-lg text-secondary-600 dark:text-slate-400 max-w-2xl mx-auto">
            Izvēlieties ērtu laiku bezmaksas konsultācijai ar mūsu IT ekspertu — tiešsaistē vai klātienē.
        </p>
    </div>
</section>

<section class="pb-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-card">
            @livewire('booking-form')
        </div>

        @if($services->isNotEmpty())
            <div class="mt-12 grid sm:grid-cols-2 gap-4">
                @foreach($services->where('is_bookable', true) as $service)
                    <div class="glass-card !p-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <x-icon :name="$service->icon ?? 'calendar'" class="w-5 h-5" />
                        </div>
                        <div>
                            <div class="font-semibold text-secondary-900 dark:text-white text-sm">{{ $service->name }}</div>
                            @if($service->duration_minutes)
                                <div class="text-xs text-secondary-500">{{ $service->duration_minutes }} min</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
