@extends('layouts.public')

@section('content')
<section class="relative min-h-[70vh] flex items-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-red-900/30 via-secondary-900 to-primary/20"></div>
    <div class="data-flow opacity-20">
        <div class="data-flow-line"></div>
        <div class="data-flow-line"></div>
    </div>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <div class="text-8xl font-bold text-gradient mb-4">500</div>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-4">Servera kļūda</h1>
        <p class="text-lg text-slate-300 mb-10">
            Radās neparedzēta kļūda. Mūsu komanda ir informēta. Lūdzu, mēģiniet vēlreiz vēlāk vai sazinieties ar mums.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-white text-secondary-900 font-semibold hover:-translate-y-1 transition-all">
                Uz sākumu
            </a>
            <a href="mailto:{{ config('lairin.company.email') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl border-2 border-white/30 text-white font-semibold hover:bg-white/10 transition-all">
                Rakstīt e-pastu
            </a>
        </div>
    </div>
</section>
@endsection
