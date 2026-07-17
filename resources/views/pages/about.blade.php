@extends('layouts.public')

@section('content')
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-accent/5"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
        <span class="text-primary font-semibold text-sm uppercase tracking-wider">Par mums</span>
        <h1 class="text-4xl sm:text-5xl font-bold text-secondary-900 dark:text-white mt-2 mb-6">
            Mēs esam <span class="text-gradient">Lairin</span>
        </h1>
        <p class="text-lg text-secondary-600 dark:text-slate-400 max-w-2xl mx-auto">
            Uzticams IT partneris, kas palīdz uzņēmumiem Latvijā sasniegt digitālos mērķus ar moderniem risinājumiem.
        </p>
    </div>
</section>

<section class="pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center mb-24">
            <div class="relative">
                <div class="aspect-[4/3] rounded-3xl bg-gradient-to-br from-primary/20 via-accent/10 to-secondary-900/20 overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center p-12">
                        <div class="grid grid-cols-2 gap-4 w-full">
                            @foreach([['10+', 'Gadi pieredzē'], ['200+', 'Projekti'], ['50+', 'Klienti'], ['24/7', 'Atbalsts']] as [$num, $label])
                                <div class="glass-card !p-5 text-center">
                                    <div class="text-3xl font-bold text-gradient">{{ $num }}</div>
                                    <div class="text-sm text-secondary-600 dark:text-slate-400 mt-1">{{ $label }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-secondary-900 dark:text-white">Mūsu stāsts</h2>
                <p class="text-secondary-600 dark:text-slate-400 leading-relaxed">
                    Lairin ir Latvijas IT uzņēmums ar dziļu pieredzi uzņēmumu infrastruktūras, kibernētiskās drošības un digitālās transformācijas jomā. Mēs apvienojam tehnoloģisko ekspertīzi ar biznesa izpratni, lai sniegtu risinājumus, kas reāli uzlabo jūsu darba procesus.
                </p>
                <p class="text-secondary-600 dark:text-slate-400 leading-relaxed">
                    Mūsu komanda nodrošina pilnu cikla atbalstu — no sākotnējās konsultācijas un vajadzību analīzes līdz projektēšanai, ieviešanai, apmācībai un pastāvīgai uzturēšanai.
                </p>
                <p class="text-secondary-600 dark:text-slate-400 leading-relaxed">
                    Mēs sadarbojamies ar uzņēmumiem visos izmēros — no maziem uzņēmumiem līdz lieliem korporatīviem klientiem dažādās nozarēs.
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6 mb-24">
            @foreach([
                ['icon' => 'shield', 'title' => 'Uzticamība', 'desc' => 'Mēs garantējam augstākos drošības un kvalitātes standartus visos mūsu projektos.'],
                ['icon' => 'users', 'title' => 'Komanda', 'desc' => 'Certificēti speciālisti ar pieredzi starptautiskos IT projektos un modernās tehnoloģijās.'],
                ['icon' => 'cpu', 'title' => 'Inovācijas', 'desc' => 'Sekojam līdzi jaunākajām tendencēm — mākoņi, AI, IoT un digitālā transformācija.'],
            ] as $value)
                <div class="glass-card text-center">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center text-white mb-4">
                        <x-icon :name="$value['icon']" class="w-7 h-7" />
                    </div>
                    <h3 class="text-lg font-bold text-secondary-900 dark:text-white mb-2">{{ $value['title'] }}</h3>
                    <p class="text-sm text-secondary-600 dark:text-slate-400">{{ $value['desc'] }}</p>
                </div>
            @endforeach
        </div>

        @if($testimonials->isNotEmpty())
            <div class="mb-24">
                <div class="text-center mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold text-secondary-900 dark:text-white">Ko saka mūsu klienti</h2>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($testimonials->take(6) as $testimonial)
                        <div class="glass-card">
                            <div class="flex gap-1 mb-3">
                                @for($i = 0; $i < ($testimonial->rating ?? 5); $i++)
                                    <x-icon name="star" class="w-4 h-4 text-amber-400" />
                                @endfor
                            </div>
                            <p class="text-sm text-secondary-600 dark:text-slate-300 italic mb-4">"{{ $testimonial->content }}"</p>
                            <div class="font-semibold text-secondary-900 dark:text-white text-sm">{{ $testimonial->name }}</div>
                            @if($testimonial->company)
                                <div class="text-xs text-secondary-500">{{ $testimonial->company }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="glass-card bg-gradient-to-br from-primary/5 to-accent/5 text-center !p-12">
            <h2 class="text-2xl font-bold text-secondary-900 dark:text-white mb-4">Gatavi sadarboties?</h2>
            <p class="text-secondary-600 dark:text-slate-400 mb-8 max-w-xl mx-auto">Pieteiciet bezmaksas konsultāciju un uzziniet, kā mēs varam palīdzēt jūsu uzņēmumam.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('booking.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-primary to-accent text-white font-semibold hover:-translate-y-1 transition-all">
                    Pieteikt konsultāciju
                </a>
                <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl border border-primary/30 text-primary font-semibold hover:bg-primary/10 transition-colors">
                    Sazināties
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
