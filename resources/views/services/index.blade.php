@extends('layouts.public')

@section('content')
{{-- Page header --}}
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/10 via-transparent to-accent/10"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
        <span class="text-primary font-semibold text-sm uppercase tracking-wider">Pakalpojumi</span>
        <h1 class="text-4xl sm:text-5xl font-bold text-secondary-900 dark:text-white mt-2 mb-6">
            Mūsu <span class="text-gradient">pakalpojumi</span>
        </h1>
        <p class="text-lg text-secondary-600 dark:text-slate-400 max-w-2xl mx-auto">
            Pilns IT pakalpojumu klāsts — no infrastruktūras un drošības līdz AI, digitalizācijai un pielāgotai programmatūras izstrādei.
        </p>
    </div>
</section>

<section class="pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        @foreach($categories as $category)
            <div id="{{ $category->slug }}" class="scroll-mt-24">
                <div class="flex items-start gap-4 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center text-white shrink-0">
                        <x-icon :name="$category->icon ?? 'server'" class="w-7 h-7" />
                    </div>
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-secondary-900 dark:text-white">{{ $category->name }}</h2>
                        @if($category->description)
                            <p class="text-secondary-600 dark:text-slate-400 mt-2 max-w-3xl">{{ $category->description }}</p>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($category->services as $service)
                        <a href="{{ route('services.show', $service->slug) }}"
                           class="glass-card group flex items-start gap-4 hover:border-primary/30">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0 group-hover:bg-primary group-hover:text-white transition-colors">
                                <x-icon :name="$service->icon ?? $category->icon ?? 'check'" class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-secondary-900 dark:text-white group-hover:text-primary transition-colors">{{ $service->name }}</h3>
                                @if($service->description)
                                    <p class="text-sm text-secondary-500 dark:text-slate-400 mt-1 line-clamp-2">{{ Str::limit($service->description, 100) }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @if(!$loop->last)<div class="section-divider"></div>@endif
        @endforeach
    </div>
</section>

<section class="py-16 bg-gradient-enterprise relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 text-center relative">
        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4">Nepieciešama konsultācija?</h2>
        <p class="text-white/80 mb-8">Mūsu eksperti palīdzēs izvēlēties optimālo risinājumu jūsu uzņēmumam.</p>
        <a href="{{ route('booking.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-white text-secondary-900 font-semibold hover:-translate-y-1 transition-all">
            Pieteikt konsultāciju <x-icon name="arrow-right" class="w-5 h-5" />
        </a>
    </div>
</section>
@endsection
