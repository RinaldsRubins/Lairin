@extends('layouts.public')

@section('content')
<section class="relative min-h-[70vh] flex items-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-secondary-900 via-primary/20 to-accent/20"></div>
    <div class="particles">
        @for($i = 1; $i <= 4; $i++)<div class="particle"></div>@endfor
    </div>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <div class="text-8xl font-bold text-gradient mb-4">404</div>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-4">Lapa nav atrasta</h1>
        <p class="text-lg text-slate-300 mb-10">
            Atvainojiet, meklētā lapa neeksistē vai ir pārvietota. Atgriezieties sākumlapā vai izmantojiet navigāciju.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-white text-secondary-900 font-semibold hover:-translate-y-1 transition-all">
                Uz sākumu
            </a>
            <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl border-2 border-white/30 text-white font-semibold hover:bg-white/10 transition-all">
                Sazināties
            </a>
        </div>
    </div>
</section>
@endsection
