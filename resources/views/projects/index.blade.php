@extends('layouts.public')

@section('content')
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-secondary-900/5"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
        <span class="text-primary font-semibold text-sm uppercase tracking-wider">Projekti</span>
        <h1 class="text-4xl sm:text-5xl font-bold text-secondary-900 dark:text-white mt-2 mb-6">
            Mūsu <span class="text-gradient">realizētie projekti</span>
        </h1>
        <p class="text-lg text-secondary-600 dark:text-slate-400 max-w-2xl mx-auto">
            Apskatiet mūsu veiksmīgi īstenotos IT projektus dažādās nozarēs.
        </p>
    </div>
</section>

<section class="pb-24" x-data="{
    filter: '{{ $activeIndustry }}',
    projects: {{ $projects->map(fn($p) => ['slug' => $p->slug, 'title' => $p->title, 'description' => $p->description, 'industry' => $p->industry, 'image' => $p->image, 'client' => $p->client])->values()->toJson() }},
    get filtered() {
        if (!this.filter) return this.projects;
        return this.projects.filter(p => p.industry === this.filter);
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Category filters --}}
        <div class="flex flex-wrap gap-2 justify-center mb-12">
            <button @click="filter = ''"
                    :class="filter === '' ? 'bg-primary text-white shadow-glow-primary' : 'glass text-secondary-600 dark:text-slate-300 hover:text-primary'"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300">
                Visi
            </button>
            @foreach($industries as $industry)
                <button @click="filter = '{{ $industry }}'"
                        :class="filter === '{{ $industry }}' ? 'bg-primary text-white shadow-glow-primary' : 'glass text-secondary-600 dark:text-slate-300 hover:text-primary'"
                        class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300">
                    {{ $industry }}
                </button>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="project in filtered" :key="project.slug">
                <a :href="'/projekti/' + project.slug" class="group glass-card !p-0 overflow-hidden">
                    <div class="aspect-video overflow-hidden bg-gradient-to-br from-primary/20 to-accent/20">
                        <template x-if="project.image">
                            <img :src="'/storage/' + project.image" :alt="project.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        </template>
                        <template x-if="!project.image">
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-primary/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2"/></svg>
                            </div>
                        </template>
                    </div>
                    <div class="p-6">
                        <template x-if="project.industry">
                            <span class="text-xs font-medium text-primary uppercase tracking-wider" x-text="project.industry"></span>
                        </template>
                        <h2 class="text-lg font-bold text-secondary-900 dark:text-white mt-1 group-hover:text-primary transition-colors" x-text="project.title"></h2>
                        <p class="text-sm text-secondary-500 dark:text-slate-400 mt-2 line-clamp-2" x-text="project.description"></p>
                        <template x-if="project.client">
                            <p class="text-xs text-secondary-400 dark:text-slate-500 mt-3" x-text="'Klients: ' + project.client"></p>
                        </template>
                    </div>
                </a>
            </template>
        </div>

        <div x-show="filtered.length === 0" class="text-center py-16" x-cloak>
            <p class="text-secondary-500 dark:text-slate-400">Nav atrasti projekti šajā kategorijā.</p>
        </div>
    </div>
</section>
@endsection
