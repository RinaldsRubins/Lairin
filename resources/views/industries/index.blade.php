@extends('layouts.public')

@section('content')
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-accent/10 via-primary/5 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
        <span class="text-accent font-semibold text-sm uppercase tracking-wider">Nozares</span>
        <h1 class="text-4xl sm:text-5xl font-bold text-secondary-900 dark:text-white mt-2 mb-6">
            IT risinājumi <span class="text-gradient">jūsu nozarei</span>
        </h1>
        <p class="text-lg text-secondary-600 dark:text-slate-400 max-w-2xl mx-auto">
            Mēs izprotam specifiskās prasības dažādās nozarēs un piedāvājam pielāgotus IT risinājumus, kas atbilst jūsu biznesa vajadzībām.
        </p>
    </div>
</section>

<section class="pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($industries as $industry)
                <div class="glass-card group">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center text-primary mb-5 group-hover:scale-110 group-hover:bg-gradient-to-br group-hover:from-primary group-hover:to-accent group-hover:text-white transition-all duration-300">
                        <x-icon :name="$industry->icon ?? 'building'" class="w-7 h-7" />
                    </div>
                    <h2 class="text-xl font-bold text-secondary-900 dark:text-white mb-3">{{ $industry->name }}</h2>
                    @if($industry->description)
                        <p class="text-secondary-600 dark:text-slate-400 text-sm leading-relaxed mb-4">{{ $industry->description }}</p>
                    @endif
                    <a href="{{ route('projects.index', ['industry' => $industry->name]) }}"
                       class="inline-flex items-center gap-2 text-sm text-primary font-semibold hover:gap-3 transition-all">
                        Skatīt projektus <x-icon name="arrow-right" class="w-4 h-4" />
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-16 bg-secondary-900 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-enterprise opacity-30"></div>
    <div class="max-w-4xl mx-auto px-4 text-center relative">
        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4">Neredzat savu nozari?</h2>
        <p class="text-slate-300 mb-8">Sazinieties ar mums — mēs atradīsim risinājumu jebkurai industrijai.</p>
        <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-white text-secondary-900 font-semibold hover:-translate-y-1 transition-all">
            Sazināties ar mums
        </a>
    </div>
</section>
@endsection
