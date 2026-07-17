@extends('layouts.public')

@section('content')
<section class="relative py-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-accent/5"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <nav class="text-sm text-secondary-500 dark:text-slate-400 mb-6">
            <a href="{{ route('services.index') }}" class="hover:text-primary">Pakalpojumi</a>
            <span class="mx-2">/</span>
            @if($service->category)
                <span>{{ $service->category->name }}</span>
                <span class="mx-2">/</span>
            @endif
            <span class="text-secondary-900 dark:text-white">{{ $service->name }}</span>
        </nav>

        <div class="flex items-start gap-6">
            <div class="hidden sm:flex w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-accent items-center justify-center text-white shrink-0">
                <x-icon :name="$service->icon ?? $service->category?->icon ?? 'server'" class="w-8 h-8" />
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-secondary-900 dark:text-white mb-4">{{ $service->name }}</h1>
                @if($service->description)
                    <p class="text-lg text-secondary-600 dark:text-slate-400 max-w-3xl">{{ $service->description }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="glass-card prose prose-lg dark:prose-invert max-w-none">
                    @if($service->content ?? false)
                        {!! $service->content !!}
                    @else
                        <p class="text-secondary-600 dark:text-slate-400 leading-relaxed">
                            {{ $service->name }} ir viens no mūsu galvenajiem pakalpojumiem. Sazinieties ar mums, lai uzzinātu vairāk par risinājumu, kas pielāgots tieši jūsu uzņēmuma vajadzībām.
                        </p>
                        <h3>Ko mēs piedāvājam</h3>
                        <ul>
                            <li>Profesionāla konsultācija un vajadzību analīze</li>
                            <li>Risinājuma projektēšana un plānošana</li>
                            <li>Ieviešana un integrācija ar esošajiem sistēmām</li>
                            <li>Apmācība un tehniskais atbalsts</li>
                            <li>Monitorings un uzturēšana</li>
                        </ul>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="glass-card sticky top-24">
                    <h3 class="font-bold text-secondary-900 dark:text-white mb-4">Sākt sadarbību</h3>
                    <p class="text-sm text-secondary-600 dark:text-slate-400 mb-6">
                        Pieteiciet bezmaksas konsultāciju un uzziniet, kā šis pakalpojums var palīdzēt jūsu biznesam.
                    </p>
                    @if($service->duration_minutes)
                        <div class="flex items-center gap-2 text-sm text-secondary-500 dark:text-slate-400 mb-4">
                            <x-icon name="clock" class="w-4 h-4" />
                            Konsultācijas ilgums: {{ $service->duration_minutes }} min
                        </div>
                    @endif
                    <a href="{{ route('booking.index') }}" class="block w-full text-center px-6 py-3 rounded-xl bg-gradient-to-r from-primary to-accent text-white font-semibold hover:-translate-y-0.5 transition-all">
                        Pieteikt konsultāciju
                    </a>
                    <a href="{{ route('contact.index') }}" class="block w-full text-center px-6 py-3 rounded-xl mt-3 border border-primary/30 text-primary font-semibold hover:bg-primary/10 transition-colors">
                        Sazināties
                    </a>
                </div>

                @if($service->category)
                    <div class="glass-card">
                        <h3 class="font-bold text-secondary-900 dark:text-white mb-3">Kategorija</h3>
                        <a href="{{ route('services.index') }}#{{ $service->category->slug }}" class="flex items-center gap-3 text-primary hover:underline">
                            <x-icon :name="$service->category->icon ?? 'server'" class="w-5 h-5" />
                            {{ $service->category->name }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
