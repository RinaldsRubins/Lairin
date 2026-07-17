@extends('layouts.public')

@section('content')
@php
    $homeFaqs = \App\Models\Faq::query()->where('is_active', true)->orderBy('sort_order')->limit(6)->get();
@endphp

{{-- Hero --}}
<section class="relative min-h-screen flex items-center overflow-hidden bg-secondary-900">
    {{-- Hero photo --}}
    <img
        src="{{ asset('images/hero-riga.png') }}"
        alt="Rīga — Lairin IT risinājumi"
        class="absolute inset-0 w-full h-full object-cover object-center scale-105 hero-photo-zoom"
        width="1920"
        height="1080"
        fetchpriority="high"
    >

    {{-- Overlay for text readability --}}
    <div class="absolute inset-0 bg-gradient-to-r from-secondary-900/75 via-secondary-900/45 to-secondary-900/25"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-secondary-900/60 via-transparent to-secondary-900/20"></div>

    <div class="particles">
        @for($i = 1; $i <= 8; $i++)
            <div class="particle"></div>
        @endfor
    </div>

    <div class="data-flow">
        @for($i = 1; $i <= 4; $i++)
            <div class="data-flow-line"></div>
        @endfor
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 w-full">
        <div class="max-w-3xl">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight mb-6 animate-fade-in-up">
                Veidojam <span class="text-gradient">nākotnes IT risinājumus</span> uzņēmumiem.
            </h1>

            <p class="text-lg sm:text-xl text-slate-200/90 leading-relaxed mb-10 max-w-2xl animate-fade-in-up animate-delay-200">
                Lairin palīdz uzņēmumiem automatizēt procesus, samazināt izmaksas, uzlabot darba efektivitāti un ieviest drošus tehnoloģiju risinājumus, kas rada ilgtermiņa vērtību un konkurences priekšrocības.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up animate-delay-300">
                <a href="{{ route('booking.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-primary to-accent text-white font-semibold shadow-glow-primary hover:-translate-y-1 transition-all duration-300">
                    Pieteikt konsultāciju
                    <x-icon name="arrow-right" class="w-5 h-5" />
                </a>
                <a href="{{ route('services.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl glass-dark text-white font-semibold hover:bg-white/20 transition-all duration-300">
                    Apskatīt pakalpojumus
                </a>
            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <x-icon name="chevron-down" class="w-6 h-6 text-white/60" />
    </div>
</section>

{{-- Services --}}
<section class="py-24 bg-slate-50 dark:bg-secondary-900 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary font-semibold text-sm uppercase tracking-wider">Pakalpojumi</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-secondary-900 dark:text-white mt-2 mb-4">
                Visaptveroši <span class="text-gradient">IT risinājumi</span>
            </h2>
            <p class="text-secondary-600 dark:text-slate-400 max-w-2xl mx-auto">
                No infrastruktūras un mākoņiem līdz AI un digitalizācijai — viss, kas nepieciešams jūsu uzņēmuma attīstībai.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($serviceCategories as $category)
                <div class="glass-card group hover:border-primary/30 dark:hover:border-primary/40">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center text-primary mb-5 group-hover:scale-110 transition-transform duration-300">
                        <x-icon :name="$category->icon ?? 'server'" class="w-7 h-7" />
                    </div>
                    <h3 class="text-xl font-bold text-secondary-900 dark:text-white mb-2">{{ $category->name }}</h3>
                    @if($category->description)
                        <p class="text-sm text-secondary-600 dark:text-slate-400 mb-4">{{ $category->description }}</p>
                    @endif
                    <ul class="space-y-2">
                        @foreach($category->services->take(5) as $service)
                            <li>
                                <a href="{{ route('services.show', $service->slug) }}"
                                   class="flex items-center gap-2 text-sm text-secondary-600 dark:text-slate-400 hover:text-primary transition-colors">
                                    <x-icon name="check" class="w-4 h-4 text-primary shrink-0" />
                                    {{ $service->name }}
                                </a>
                            </li>
                        @endforeach
                        @if($category->services->count() > 5)
                            <li class="text-sm text-primary font-medium pt-1">
                                + vēl {{ $category->services->count() - 5 }} pakalpojumi
                            </li>
                        @endif
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 text-primary font-semibold hover:gap-3 transition-all">
                Visi pakalpojumi <x-icon name="arrow-right" class="w-5 h-5" />
            </a>
        </div>
    </div>
</section>

{{-- Industries --}}
<section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-primary/5 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-16">
            <span class="text-accent font-semibold text-sm uppercase tracking-wider">Nozares</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-secondary-900 dark:text-white mt-2">
                Pieredze <span class="text-gradient">dažādās nozarēs</span>
            </h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($industries as $industry)
                <div class="glass-card text-center !p-5 group cursor-default">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-gradient-to-br from-primary to-accent flex items-center justify-center text-white mb-3 group-hover:scale-110 transition-transform">
                        <x-icon :name="$industry->icon ?? 'building'" class="w-6 h-6" />
                    </div>
                    <h3 class="font-semibold text-secondary-900 dark:text-white text-sm">{{ $industry->name }}</h3>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('industries.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-primary/30 text-primary font-semibold hover:bg-primary/10 transition-colors">
                Uzzināt vairāk par nozarēm
            </a>
        </div>
    </div>
</section>

{{-- Featured Projects --}}
<section class="py-24 bg-secondary-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-enterprise opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-16 gap-4">
            <div>
                <span class="text-primary-300 font-semibold text-sm uppercase tracking-wider">Projekti</span>
                <h2 class="text-3xl sm:text-4xl font-bold mt-2">Ievērojamākie <span class="text-gradient">projekti</span></h2>
            </div>
            <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 text-primary-300 hover:text-white transition-colors font-semibold">
                Visi projekti <x-icon name="arrow-right" class="w-5 h-5" />
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredProjects as $project)
                <a href="{{ route('projects.show', $project->slug) }}" class="group glass-dark rounded-2xl overflow-hidden hover:-translate-y-2 transition-all duration-300">
                    @if($project->image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-br from-primary/30 to-accent/30 flex items-center justify-center">
                            <x-icon name="server" class="w-16 h-16 text-white/40" />
                        </div>
                    @endif
                    <div class="p-6">
                        @if($project->industry)
                            <span class="text-xs font-medium text-primary-300 uppercase tracking-wider">{{ $project->industry }}</span>
                        @endif
                        <h3 class="text-lg font-bold mt-1 group-hover:text-primary-300 transition-colors">{{ $project->title }}</h3>
                        <p class="text-sm text-slate-400 mt-2 line-clamp-2">{{ $project->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- About snippet --}}
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <div class="aspect-square rounded-3xl bg-gradient-to-br from-primary/20 via-accent/10 to-secondary-900/20 overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-48 h-48 rounded-full bg-gradient-to-br from-primary to-accent opacity-30 blur-3xl animate-pulse-slow"></div>
                    </div>
                    <div class="relative p-12 flex flex-col justify-center h-full">
                        <div class="grid grid-cols-2 gap-4">
                            @foreach([['10+', 'Gadi pieredzē'], ['200+', 'Projekti'], ['50+', 'Klienti'], ['24/7', 'Atbalsts']] as [$num, $label])
                                <div class="glass-card !p-4 text-center">
                                    <div class="text-2xl font-bold text-gradient">{{ $num }}</div>
                                    <div class="text-xs text-secondary-600 dark:text-slate-400 mt-1">{{ $label }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">Par mums</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-secondary-900 dark:text-white mt-2 mb-6">
                    Jūsu uzticamais <span class="text-gradient">IT partneris</span>
                </h2>
                <p class="text-secondary-600 dark:text-slate-400 leading-relaxed mb-4">
                    Lairin ir Latvijas IT uzņēmums, kas specializējas uzņēmumu infrastruktūras, kibernētiskās drošības un digitālās transformācijas risinājumos. Mēs apvienojam tehnoloģisko ekspertīzi ar biznesa izpratni.
                </p>
                <p class="text-secondary-600 dark:text-slate-400 leading-relaxed mb-8">
                    Mūsu komanda nodrošina pilnu cikla atbalstu — no konsultācijām un projektēšanas līdz ieviešanai, monitorēšanai un uzturēšanai.
                </p>
                <a href="{{ route('pages.about') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-secondary-900 dark:bg-white dark:text-secondary-900 text-white font-semibold hover:-translate-y-0.5 transition-all">
                    Uzzināt vairāk <x-icon name="arrow-right" class="w-5 h-5" />
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Testimonials --}}
@if($testimonials->isNotEmpty())
<section class="py-24 bg-slate-50 dark:bg-secondary-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary font-semibold text-sm uppercase tracking-wider">Atsauksmes</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-secondary-900 dark:text-white mt-2">Ko saka mūsu <span class="text-gradient">klienti</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $testimonial)
                <div class="glass-card">
                    <div class="flex gap-1 mb-4">
                        @for($i = 0; $i < ($testimonial->rating ?? 5); $i++)
                            <x-icon name="star" class="w-4 h-4 text-amber-400 fill-amber-400" />
                        @endfor
                    </div>
                    <p class="text-secondary-600 dark:text-slate-300 text-sm leading-relaxed mb-6 italic">"{{ $testimonial->content }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-accent flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-secondary-900 dark:text-white text-sm">{{ $testimonial->name }}</div>
                            @if($testimonial->position || $testimonial->company)
                                <div class="text-xs text-secondary-500 dark:text-slate-400">
                                    {{ collect([$testimonial->position, $testimonial->company])->filter()->join(', ') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- FAQ --}}
@if($homeFaqs->isNotEmpty())
<section class="py-24 bg-slate-50 dark:bg-secondary-900/50" x-data="{ openFaq: null }">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary font-semibold text-sm uppercase tracking-wider">BUJ</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-secondary-900 dark:text-white mt-2">Biežāk uzdotie <span class="text-gradient">jautājumi</span></h2>
        </div>

        <div class="space-y-3">
            @foreach($homeFaqs as $index => $faq)
                <div class="glass-card !p-0 overflow-hidden">
                    <button @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                            class="w-full flex items-center justify-between p-5 text-left font-semibold text-secondary-900 dark:text-white hover:text-primary transition-colors">
                        {{ $faq->question }}
                        <x-icon name="chevron-down" class="w-5 h-5 shrink-0 transition-transform duration-300" ::class="{ 'rotate-180': openFaq === {{ $index }} }" />
                    </button>
                    <div x-show="openFaq === {{ $index }}"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         x-cloak>
                        <div class="px-5 pb-5 text-secondary-600 dark:text-slate-400 text-sm leading-relaxed border-t border-white/10 pt-4">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('pages.faq') }}" class="text-primary font-semibold hover:underline">Visi jautājumi un atbildes →</a>
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-enterprise"></div>
    <div class="absolute inset-0 opacity-30">
        <div class="data-flow"><div class="data-flow-line"></div><div class="data-flow-line"></div></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">Gatavi sākt sadarbību?</h2>
        <p class="text-lg text-white/80 mb-10 max-w-2xl mx-auto">
            Pieteiciet bezmaksas konsultāciju un uzziniet, kā Lairin var palīdzēt jūsu uzņēmumam sasniegt digitālos mērķus.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('booking.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-white text-secondary-900 font-semibold hover:-translate-y-1 transition-all shadow-lg">
                Pieteikt konsultāciju
            </a>
            <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl border-2 border-white/30 text-white font-semibold hover:bg-white/10 transition-all">
                Sazināties ar mums
            </a>
        </div>
    </div>
</section>
@endsection
