@extends('layouts.public')

@section('content')
<section class="relative py-20 overflow-hidden">
    @if($project->image)
        <div class="absolute inset-0">
            <img src="{{ asset('storage/' . $project->image) }}" alt="" class="w-full h-full object-cover opacity-20 dark:opacity-10">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-50/90 to-slate-50 dark:from-secondary-900/95 dark:to-secondary-900"></div>
        </div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-accent/5"></div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <nav class="text-sm text-secondary-500 dark:text-slate-400 mb-6">
            <a href="{{ route('projects.index') }}" class="hover:text-primary">Projekti</a>
            <span class="mx-2">/</span>
            <span class="text-secondary-900 dark:text-white">{{ $project->title }}</span>
        </nav>

        @if($project->industry)
            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold uppercase tracking-wider mb-4">{{ $project->industry }}</span>
        @endif

        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-secondary-900 dark:text-white mb-4">{{ $project->title }}</h1>

        @if($project->client)
            <p class="text-secondary-600 dark:text-slate-400">Klients: <span class="font-medium">{{ $project->client }}</span></p>
        @endif
    </div>
</section>

<section class="pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                @if($project->image)
                    <div class="rounded-2xl overflow-hidden shadow-glass-lg">
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="w-full">
                    </div>
                @endif

                <div class="glass-card prose prose-lg dark:prose-invert max-w-none">
                    @if($project->description)
                        <p class="text-lg text-secondary-600 dark:text-slate-300 leading-relaxed">{{ $project->description }}</p>
                    @endif
                    @if($project->content)
                        {!! $project->content !!}
                    @endif
                </div>

                @if($project->gallery && count($project->gallery) > 0)
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($project->gallery as $image)
                            <div class="rounded-xl overflow-hidden">
                                <img src="{{ asset('storage/' . $image) }}" alt="" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                @if($project->technologies && count($project->technologies) > 0)
                    <div class="glass-card">
                        <h3 class="font-bold text-secondary-900 dark:text-white mb-4">Tehnoloģijas</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($project->technologies as $tech)
                                <span class="px-3 py-1 rounded-lg bg-primary/10 text-primary text-sm font-medium">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="glass-card">
                    <h3 class="font-bold text-secondary-900 dark:text-white mb-4">Interesē līdzīgs projekts?</h3>
                    <p class="text-sm text-secondary-600 dark:text-slate-400 mb-4">Sazinieties ar mums, lai apspriestu jūsu ideju.</p>
                    <a href="{{ route('booking.index') }}" class="block w-full text-center px-6 py-3 rounded-xl bg-gradient-to-r from-primary to-accent text-white font-semibold hover:-translate-y-0.5 transition-all">
                        Pieteikt konsultāciju
                    </a>
                </div>
            </div>
        </div>

        @if($relatedProjects->isNotEmpty())
            <div class="mt-20">
                <h2 class="text-2xl font-bold text-secondary-900 dark:text-white mb-8">Saistītie projekti</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedProjects as $related)
                        <a href="{{ route('projects.show', $related->slug) }}" class="group glass-card !p-0 overflow-hidden">
                            @if($related->image)
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                </div>
                            @endif
                            <div class="p-5">
                                <h3 class="font-bold text-secondary-900 dark:text-white group-hover:text-primary transition-colors">{{ $related->title }}</h3>
                                <p class="text-sm text-secondary-500 dark:text-slate-400 mt-1 line-clamp-2">{{ $related->description }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
