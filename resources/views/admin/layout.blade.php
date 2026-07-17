<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('lairin.company.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans bg-slate-100 text-secondary-800 antialiased min-h-screen">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-secondary-900 text-slate-300 flex flex-col shrink-0">
            <div class="p-6 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                        <span class="text-white font-bold">L</span>
                    </div>
                    <div>
                        <div class="text-white font-bold">Lairin</div>
                        <div class="text-xs text-slate-500">Administrācija</div>
                    </div>
                </a>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary/20 text-primary-300' : 'hover:bg-white/5 hover:text-white' }}">
                    Panelis
                </a>
                @foreach([
                    ['route' => 'admin.bookings.index', 'pattern' => 'admin.bookings.*', 'label' => 'Rezervācijas'],
                    ['route' => 'admin.contact-messages.index', 'pattern' => 'admin.contact-messages.*', 'label' => 'Ziņas'],
                    ['route' => 'admin.service-categories.index', 'pattern' => 'admin.service-categories.*', 'label' => 'Pakalpojumi'],
                    ['route' => 'admin.projects.index', 'pattern' => 'admin.projects.*', 'label' => 'Projekti'],
                    ['route' => 'admin.blog-posts.index', 'pattern' => 'admin.blog-posts.*', 'label' => 'Blogs'],
                    ['route' => 'admin.seo.index', 'pattern' => 'admin.seo.*', 'label' => 'SEO'],
                    ['route' => 'admin.settings.index', 'pattern' => 'admin.settings.*', 'label' => 'Iestatījumi'],
                ] as $link)
                    <a href="{{ route($link['route']) }}"
                       class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs($link['pattern']) ? 'bg-primary/20 text-primary-300' : 'hover:bg-white/5 hover:text-white' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="p-4 border-t border-white/10 space-y-2">
                <a href="{{ route('home') }}" target="_blank" class="block px-4 py-2 text-sm text-slate-400 hover:text-white transition-colors">
                    ← Atvērt vietni
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-slate-400 hover:text-red-400 transition-colors">
                        Iziet
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b border-slate-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-bold text-secondary-900">@yield('page_title', 'Panelis')</h1>
                    <div class="text-sm text-secondary-500">{{ auth()->user()?->name }}</div>
                </div>
            </header>

            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">{{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @livewireScripts
    @stack('scripts')
</body>
</html>
