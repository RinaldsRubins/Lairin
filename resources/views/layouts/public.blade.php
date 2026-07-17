<!DOCTYPE html>
<html lang="lv" x-data="{ mobileOpen: false, cookieConsent: localStorage.getItem('cookieConsent') === 'accepted' }">
<head>
    @include('partials.seo-meta', ['seo' => $seo ?? null])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('head')
    @if(config('lairin.ga4_measurement_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('lairin.ga4_measurement_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('lairin.ga4_measurement_id') }}', { 'anonymize_ip': true });
    </script>
    @endif
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ config('lairin.company.name') }}",
        "legalName": "{{ config('lairin.company.legal_name') }}",
        "url": "{{ config('app.url') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "image": "{{ asset('images/og-image.png') }}",
        "email": "{{ config('lairin.company.email') }}",
        "telephone": "{{ config('lairin.company.phone') }}",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "LV",
        "addressLocality": "Jelgava",
            "streetAddress": "Loka maģistrāle 30",
            "postalCode": "LV-3004",
        },
        "areaServed": {
            "@type": "Country",
            "name": "Latvija"
        },
        "sameAs": []
    }
    </script>
    @stack('schema')
    <script>document.documentElement.classList.remove('dark'); localStorage.removeItem('darkMode');</script>
</head>
<body class="font-sans min-h-screen flex flex-col" x-data="{ loading: true }" x-init="window.addEventListener('load', () => setTimeout(() => loading = false, 600))">

    {{-- Page loader --}}
    <div x-show="loading" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-50">
        <div class="text-center">
            <div class="loader mx-auto mb-4">
                <div class="loader-ring"></div>
                <div class="loader-ring"></div>
                <div class="loader-ring"></div>
            </div>
            <p class="text-sm text-secondary-500">Ielādē...</p>
        </div>
    </div>

    {{-- Sticky glass navbar --}}
    <header class="sticky top-0 z-50 transition-all duration-300">
        <nav class="glass border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20">
                    {{-- Brand --}}
                    <a href="{{ route('home') }}" class="group transition-opacity hover:opacity-90">
                        <x-brand-logo size="md" />
                    </a>

                    {{-- Desktop nav --}}
                    <div class="hidden lg:flex items-center gap-1">
                        @foreach(array_filter([
                            ['route' => 'home', 'label' => 'Sākums', 'pattern' => '/'],
                            ['route' => 'services.index', 'label' => 'Pakalpojumi', 'pattern' => 'pakalpojumi*'],
                            ['route' => 'industries.index', 'label' => 'Nozares', 'pattern' => 'nozares*'],
                            ['route' => 'projects.index', 'label' => 'Projekti', 'pattern' => 'projekti*'],
                            config('lairin.show_blog') ? ['route' => 'blog.index', 'label' => 'Blogs', 'pattern' => 'blogs*'] : null,
                            ['route' => 'pages.about', 'label' => 'Par mums', 'pattern' => 'par-mums*'],
                            ['route' => 'contact.index', 'label' => 'Kontakti', 'pattern' => 'kontakti*'],
                        ]) as $link)
                            <a href="{{ route($link['route']) }}"
                               class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                                      {{ request()->is($link['pattern']) ? 'nav-link-active text-primary' : 'text-secondary-600 hover:text-primary' }}">
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    </div>

                    {{-- Right actions --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('booking.index') }}"
                           class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-primary to-primary-600 text-white text-sm font-semibold shadow-lg shadow-primary/25 hover:shadow-glow-primary hover:-translate-y-0.5 transition-all duration-300">
                            Pieteikt konsultāciju
                        </a>

                        <button @click="mobileOpen = !mobileOpen" type="button"
                                class="lg:hidden p-2 rounded-xl text-secondary-600 hover:bg-white/50"
                                aria-label="Izvēlne">
                            <x-icon name="menu" class="w-6 h-6" x-show="!mobileOpen" />
                            <x-icon name="x" class="w-6 h-6" x-show="mobileOpen" x-cloak />
                        </button>
                    </div>
                </div>
            </div>

            {{-- Mobile menu --}}
            <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="lg:hidden border-t border-white/10 bg-white/95 backdrop-blur-xl" x-cloak>
                <div class="px-4 py-4 space-y-1">
                    @foreach(array_filter([
                        ['route' => 'home', 'label' => 'Sākums'],
                        ['route' => 'services.index', 'label' => 'Pakalpojumi'],
                        ['route' => 'industries.index', 'label' => 'Nozares'],
                        ['route' => 'projects.index', 'label' => 'Projekti'],
                        config('lairin.show_blog') ? ['route' => 'blog.index', 'label' => 'Blogs'] : null,
                        ['route' => 'pages.about', 'label' => 'Par mums'],
                        ['route' => 'contact.index', 'label' => 'Kontakti'],
                    ]) as $link)
                        <a href="{{ route($link['route']) }}" @click="mobileOpen = false"
                           class="block px-4 py-3 rounded-xl text-sm font-medium text-secondary-700 hover:bg-primary/10 hover:text-primary transition-colors">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                    <a href="{{ route('booking.index') }}" @click="mobileOpen = false"
                       class="block mt-3 px-4 py-3 rounded-xl text-center bg-primary text-white text-sm font-semibold">
                        Pieteikt konsultāciju
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-secondary-900 text-slate-300 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/10 via-transparent to-accent/10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="lg:col-span-1">
                    <a href="{{ route('home') }}" class="inline-block mb-4 transition-opacity hover:opacity-90">
                        <x-brand-logo variant="light" size="lg" />
                    </a>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        {{ config('lairin.site_description') }}
                    </p>
                </div>

                <div>
                    <h3 class="text-white font-semibold mb-4">Navigācija</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('services.index') }}" class="hover:text-primary-400 transition-colors">Pakalpojumi</a></li>
                        <li><a href="{{ route('industries.index') }}" class="hover:text-primary-400 transition-colors">Nozares</a></li>
                        <li><a href="{{ route('projects.index') }}" class="hover:text-primary-400 transition-colors">Projekti</a></li>
                        @if(config('lairin.show_blog'))
                        <li><a href="{{ route('blog.index') }}" class="hover:text-primary-400 transition-colors">Blogs</a></li>
                        @endif
                        <li><a href="{{ route('pages.faq') }}" class="hover:text-primary-400 transition-colors">BUJ</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-semibold mb-4">Kontakti</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-2">
                            <x-icon name="mail" class="w-4 h-4 text-primary-400 shrink-0" />
                            <a href="mailto:{{ config('lairin.company.email') }}" class="hover:text-primary-400 transition-colors">{{ config('lairin.company.email') }}</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <x-icon name="phone" class="w-4 h-4 text-primary-400 shrink-0" />
                            <a href="tel:{{ str_replace(' ', '', config('lairin.company.phone')) }}" class="hover:text-primary-400 transition-colors">{{ config('lairin.company.phone') }}</a>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="location" class="w-4 h-4 text-primary-400 shrink-0 mt-0.5" />
                            <span>{{ config('lairin.company.legal_address') }}</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-semibold mb-4">Uzņēmums</h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li>{{ config('lairin.company.legal_name') }}</li>
                        <li>Reģ. {{ config('lairin.company.registration') }}</li>
                        <li>{{ config('lairin.company.legal_address') }}</li>
                        @if(config('lairin.company.bank_name') && config('lairin.company.bank_account'))
                        <li>{{ config('lairin.company.bank_name') }}</li>
                        <li>{{ config('lairin.company.bank_account') }}</li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="section-divider my-10"></div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} {{ config('lairin.company.name') }}. Visas tiesības aizsargātas.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('pages.about') }}" class="hover:text-primary-400 transition-colors">Par mums</a>
                    <a href="{{ route('contact.index') }}" class="hover:text-primary-400 transition-colors">Kontakti</a>
                    <a href="{{ route('booking.index') }}" class="hover:text-primary-400 transition-colors">Konsultācija</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Cookie consent (GDPR) --}}
    <div x-show="!cookieConsent" x-transition
         class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-6 sm:max-w-md z-50 glass-card !p-5 shadow-glass-lg" x-cloak>
        <p class="text-sm text-secondary-700 mb-4">
            Mēs izmantojam sīkdatnes, lai uzlabotu jūsu pieredzi mūsu vietnē. Turpinot lietot vietni, jūs piekrītat sīkdatņu izmantošanai saskaņā ar mūsu privātuma politiku.
        </p>
        <div class="flex gap-3">
            <button @click="cookieConsent = true; localStorage.setItem('cookieConsent', 'accepted')"
                    class="flex-1 px-4 py-2 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-600 transition-colors">
                Piekrītu
            </button>
            <button @click="cookieConsent = true; localStorage.setItem('cookieConsent', 'declined')"
                    class="px-4 py-2 rounded-xl border border-secondary-200 text-sm font-medium text-secondary-600 hover:bg-white/50 transition-colors">
                Noraidīt
            </button>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('{{ asset('sw.js') }}').catch(function () {});
        }
    </script>
    <style>[x-cloak] { display: none !important; }</style>
</body>
</html>
