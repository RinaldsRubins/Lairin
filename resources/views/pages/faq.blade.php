@extends('layouts.public')

@section('content')
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
        <span class="text-primary font-semibold text-sm uppercase tracking-wider">BUJ</span>
        <h1 class="text-4xl sm:text-5xl font-bold text-secondary-900 dark:text-white mt-2 mb-6">
            Biežāk uzdotie <span class="text-gradient">jautājumi</span>
        </h1>
        <p class="text-lg text-secondary-600 dark:text-slate-400 max-w-2xl mx-auto">
            Atbildes uz populārākajiem jautājumiem par mūsu pakalpojumiem un sadarbības procesu.
        </p>
    </div>
</section>

<section class="pb-24" x-data="{ openFaq: null, activeCategory: 'all' }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($faqs->count() > 1)
            <div class="flex flex-wrap gap-2 justify-center mb-12">
                <button @click="activeCategory = 'all'"
                        :class="activeCategory === 'all' ? 'bg-primary text-white' : 'glass text-secondary-600 dark:text-slate-300'"
                        class="px-5 py-2 rounded-full text-sm font-semibold transition-all">
                    Visi
                </button>
                @foreach($faqs->keys() as $category)
                    <button @click="activeCategory = '{{ $category }}'"
                            :class="activeCategory === '{{ $category }}' ? 'bg-primary text-white' : 'glass text-secondary-600 dark:text-slate-300'"
                            class="px-5 py-2 rounded-full text-sm font-semibold transition-all">
                        {{ $category }}
                    </button>
                @endforeach
            </div>
        @endif

        @php $globalIndex = 0; @endphp
        @foreach($faqs as $category => $categoryFaqs)
            <div x-show="activeCategory === 'all' || activeCategory === '{{ $category }}'" class="mb-10">
                @if($faqs->count() > 1)
                    <h2 class="text-xl font-bold text-secondary-900 dark:text-white mb-4">{{ $category }}</h2>
                @endif

                <div class="space-y-3">
                    @foreach($categoryFaqs as $faq)
                        @php $idx = $globalIndex++; @endphp
                        <div class="glass-card !p-0 overflow-hidden">
                            <button @click="openFaq = openFaq === {{ $idx }} ? null : {{ $idx }}"
                                    class="w-full flex items-center justify-between p-5 text-left font-semibold text-secondary-900 dark:text-white hover:text-primary transition-colors">
                                {{ $faq->question }}
                                <x-icon name="chevron-down" class="w-5 h-5 shrink-0 transition-transform duration-300" ::class="{ 'rotate-180': openFaq === {{ $idx }} }" />
                            </button>
                            <div x-show="openFaq === {{ $idx }}"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 max-h-0"
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
            </div>
        @endforeach

        <div class="glass-card text-center !p-10 mt-16">
            <h2 class="text-xl font-bold text-secondary-900 dark:text-white mb-3">Neatradāt atbildi?</h2>
            <p class="text-secondary-600 dark:text-slate-400 mb-6">Sazinieties ar mums — ar prieku palīdzēsim.</p>
            <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-primary text-white font-semibold hover:bg-primary-600 transition-colors">
                Sazināties <x-icon name="arrow-right" class="w-5 h-5" />
            </a>
        </div>
    </div>
</section>
@endsection
