@extends('layouts.public')

@section('title', 'MC-COMERCIAL - Centro de Formação Profissional')

@push('styles')
<link rel="preload" as="image"
      href="{{ asset('assets/images-preview/carousel/slide-1.jpg') }}"
      fetchpriority="high">
@endpush

@section('content')

{{-- Hero Carousel --}}
<section x-data="{
    active: 0,
    total: 4,
    autoplay: null,
    init() { this.autoplay = setInterval(() => this.next(), 5500); },
    next() { this.active = (this.active + 1) % this.total; this.resetAutoplay(); },
    prev() { this.active = (this.active - 1 + this.total) % this.total; this.resetAutoplay(); },
    goTo(i) { this.active = i; this.resetAutoplay(); },
    resetAutoplay() { clearInterval(this.autoplay); this.autoplay = setInterval(() => this.next(), 5500); }
}" class="relative overflow-hidden h-[80vh] md:h-[88vh]" x-cloak>

    @php
        $slides = [
            ['image' => asset('assets/images-preview/carousel/slide-1.jpg'), 'tag' => 'Formação Profissional',   'title' => 'Invista no seu',   'highlight' => 'Futuro Profissional',      'desc' => 'Formação de qualidade com mais de 10 anos de experiência na preparação de profissionais qualificados para o mercado de trabalho angolano.'],
            ['image' => asset('assets/images-preview/carousel/slide-2.jpg'), 'tag' => 'Instrutores Experientes', 'title' => 'Aprenda com os',  'highlight' => 'Melhores Formadores',     'desc' => 'Salas equipadas com tecnologia de ponta e formadores experientes para garantir a melhor experiência de aprendizagem.'],
            ['image' => asset('assets/images-preview/carousel/slide-3.jpg'), 'tag' => 'Certificação Reconhecida','title' => 'Conquiste o seu', 'highlight' => 'Certificado Profissional', 'desc' => 'Certificações reconhecidas pelo mercado que abrem portas para novas oportunidades de carreira em Angola e no exterior.'],
            ['image' => asset('assets/images-preview/carousel/slide-4.jpg'), 'tag' => 'Workshops & Práticas',   'title' => 'Workshops e',    'highlight' => 'Formações Práticas',      'desc' => 'Sessões práticas e intensivas que preparam você para os desafios reais do mercado de trabalho moderno.'],
        ];
    @endphp

    @foreach($slides as $index => $slide)
    <div x-show="active === {{ $index }}"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-105"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-400"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0"
         :class="{ 'z-10': active === {{ $index }} }">
        <div class="hero-skeleton absolute inset-0 bg-gradient-to-br from-primary/80 via-primary/60 to-secondary/80 animate-shimmer"></div>
        <img src="{{ $slide['image'] }}" alt="{{ $slide['tag'] }}"
             loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
             class="w-full h-full object-cover opacity-0"
             style="transition: opacity 0.7s ease-out, transform 6s ease-out; {{ $index === 0 ? 'transform: scale(1.06)' : '' }}"
             onload="this.style.opacity='1'; var s=this.previousElementSibling; if(s) s.style.opacity='0';"
             onerror="this.style.opacity='1';">
        <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/40 to-transparent">
            <div class="absolute inset-0 flex items-center">
                <div class="container mx-auto px-4">
                    <div class="max-w-2xl">
                        <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-accent mb-4 bg-accent/10 border border-accent/20 px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 bg-accent rounded-full animate-pulse"></span>
                            {{ $slide['tag'] }}
                        </span>
                        <h1 class="text-4xl lg:text-5xl xl:text-6xl font-extrabold text-white leading-tight mb-5">
                            {{ $slide['title'] }}<br>
                            <span class="gradient-text">{{ $slide['highlight'] }}</span>
                        </h1>
                        <p class="text-base lg:text-lg text-white/75 mb-8 leading-relaxed max-w-xl">{{ $slide['desc'] }}</p>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('site.cursos') }}"
                               class="inline-flex items-center gap-2 rounded-xl text-sm font-bold bg-accent text-accent-foreground h-12 px-6 hover:bg-accent/90 hover:scale-105 active:scale-95 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i data-lucide="book-open" class="w-4 h-4"></i>
                                Explorar Cursos
                            </a>
                            <a href="#sobre"
                               class="inline-flex items-center gap-2 rounded-xl text-sm font-semibold border-2 border-white/30 text-white h-12 px-6 hover:bg-white/15 hover:border-white/50 transition-all duration-200">
                                <i data-lucide="play-circle" class="w-4 h-4"></i>
                                Saber Mais
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Nav Arrows --}}
    <button @click="prev()"
            class="absolute left-4 md:left-6 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/15 backdrop-blur-sm text-white flex items-center justify-center hover:bg-white/30 hover:scale-110 transition-all duration-200 z-20 border border-white/20">
        <i data-lucide="chevron-left" class="w-5 h-5"></i>
    </button>
    <button @click="next()"
            class="absolute right-4 md:right-6 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/15 backdrop-blur-sm text-white flex items-center justify-center hover:bg-white/30 hover:scale-110 transition-all duration-200 z-20 border border-white/20">
        <i data-lucide="chevron-right" class="w-5 h-5"></i>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-2 z-20">
        @for($i = 0; $i < count($slides); $i++)
        <button @click="goTo({{ $i }})"
                :class="active === {{ $i }} ? 'w-8 bg-accent' : 'w-2 bg-white/40 hover:bg-white/70'"
                class="h-2 rounded-full transition-all duration-300"></button>
        @endfor
    </div>

    <div class="absolute bottom-8 right-6 z-20 text-white/60 text-xs font-mono tabular-nums">
        <span x-text="active + 1" class="text-white font-bold text-base"></span> / {{ count($slides) }}
    </div>
</section>

{{-- Estatísticas --}}
<section class="py-16 bg-background" id="sobre">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 reveal-stagger">
            @php
                $cursosCount = isset($cursos) ? $cursos->count() : 0;
                $centrosCount = isset($centros) ? $centros->count() : 0;
                $stats = [
                    ['icon' => 'users',      'value' => '500', 'suffix' => '+', 'label' => 'Alunos Formados',      'color' => 'text-accent',    'bg' => 'bg-accent/10'],
                    ['icon' => 'book-open',  'value' => $cursosCount, 'suffix' => '', 'label' => 'Cursos Disponíveis', 'color' => 'text-primary',   'bg' => 'bg-primary/10'],
                    ['icon' => 'building-2', 'value' => $centrosCount, 'suffix' => '', 'label' => 'Centros de Formação', 'color' => 'text-success',   'bg' => 'bg-success/10'],
                    ['icon' => 'award',      'value' => '100', 'suffix' => '%', 'label' => 'Taxa de Sucesso',      'color' => 'text-warning',   'bg' => 'bg-warning/10'],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="feature-card text-center reveal group"
                     x-data="{
                         count: 0,
                         target: {{ is_numeric($stat['value']) ? $stat['value'] : 0 }},
                         started: false,
                         start() {
                             if (this.started) return;
                             this.started = true;
                             const duration = 1500;
                             const step = this.target / (duration / 16);
                             const timer = setInterval(() => {
                                 this.count = Math.min(Math.round(this.count + step), this.target);
                                 if (this.count >= this.target) clearInterval(timer);
                             }, 16);
                         }
                     }"
                     x-intersect.once="start()">
                    <div class="w-14 h-14 rounded-2xl {{ $stat['bg'] }} flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-7 h-7 {{ $stat['color'] }}"></i>
                    </div>
                    <h3 class="text-3xl xl:text-4xl font-extrabold gradient-text mb-1">
                        @if(is_numeric($stat['value']))
                            <span x-text="count"></span>{{ $stat['suffix'] }}
                        @else
                            {{ $stat['value'] }}{{ $stat['suffix'] }}
                        @endif
                    </h3>
                    <p class="text-sm text-muted-foreground font-medium">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Centros Preview --}}
<section class="py-16 bg-muted/40">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 reveal">
            <span class="text-xs font-bold uppercase tracking-widest text-accent mb-3 block">Nossa Rede</span>
            <h2 class="section-title">Centros de Formação</h2>
            <p class="section-subtitle">Espaços modernos e equipados para a sua formação</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($centros->take(3) as $centro)
                <div class="feature-card group reveal hover-shine">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-accent/10 group-hover:bg-accent flex items-center justify-center shrink-0 transition-colors duration-300">
                            <i data-lucide="building-2" class="w-6 h-6 text-accent group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-foreground group-hover:text-accent transition-colors duration-200">{{ $centro->nome ?? 'Centro de Formação' }}</h3>
                            <p class="text-xs text-muted-foreground mt-0.5">Centro de Formação Profissional</p>
                        </div>
                    </div>
                    <div class="space-y-2.5 mb-5">
                        <p class="text-sm text-muted-foreground flex items-start gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4 mt-0.5 shrink-0 text-accent"></i>
                            {{ $centro->localizacao ?? 'Localização a definir' }}
                        </p>
                        @if(!empty($centro->contactos) && count($centro->contactos) > 0)
                            <a href="tel:{{ $centro->contactos[0] }}" class="text-sm flex items-center gap-2 text-accent hover:underline">
                                <i data-lucide="phone" class="w-4 h-4"></i>{{ $centro->contactos[0] }}
                            </a>
                        @endif
                    </div>
                    <p class="text-xs text-muted-foreground mb-4 flex items-center gap-1.5">
                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                        Seg-Sex: 8h-18h | Sáb: 9h-16h
                    </p>
                    <a href="{{ route('site.centros') }}"
                       class="w-full inline-flex items-center justify-center gap-2 rounded-xl text-sm font-semibold border border-input bg-background h-10 px-4 hover:bg-accent hover:text-accent-foreground hover:border-accent transition-all duration-200">
                        Ver Turmas <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-muted-foreground">
                    Nenhum centro disponível no momento.
                </div>
            @endforelse
        </div>
        <div class="text-center mt-10 reveal">
            <a href="{{ route('site.centros') }}"
               class="inline-flex items-center gap-2 rounded-xl text-sm font-semibold border-2 border-primary/30 text-primary h-11 px-8 hover:bg-primary hover:text-primary-foreground hover:border-primary transition-all duration-200">
                Ver Todos os Centros <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</section>

{{-- Serviços --}}
<section class="py-16 bg-background">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 reveal">
            <span class="text-xs font-bold uppercase tracking-widest text-accent mb-3 block">O que Oferecemos</span>
            <h2 class="section-title">Nossos Serviços</h2>
            <p class="section-subtitle">Soluções completas para o seu desenvolvimento profissional</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $grupoServicos = isset($grupos) ? $grupos->firstWhere('nome', 'servicos') : null;
                $iconFallbacks = ['graduation-cap', 'briefcase', 'pen-tool', 'monitor', 'target', 'award'];
                $servicosHome = [];
                if ($grupoServicos && $grupoServicos->categorias->count() > 0) {
                    $idx = 0;
                    foreach ($grupoServicos->categorias as $cat) {
                        foreach ($cat->itens->where('tipo', 'servico')->take(6 - $idx) as $srv) {
                            $servicosHome[] = ['icon' => $iconFallbacks[$idx % count($iconFallbacks)], 'title' => $srv->nome, 'desc' => $srv->descricao ?? ''];
                            $idx++;
                            if ($idx >= 6) break 2;
                        }
                    }
                }
                if (empty($servicosHome)) {
                    $servicosHome = [
                        ['icon' => 'graduation-cap', 'title' => 'Formação Profissional', 'desc' => 'Cursos especializados em diversas áreas com certificação reconhecida'],
                        ['icon' => 'briefcase', 'title' => 'Projectos Académicos', 'desc' => 'Apoio na elaboração de trabalhos e dissertações académicas'],
                        ['icon' => 'pen-tool', 'title' => 'Workshops', 'desc' => 'Sessões práticas intensivas com especialistas da indústria'],
                        ['icon' => 'monitor', 'title' => 'Formação Online', 'desc' => 'Aprenda no seu ritmo com aulas gravadas e ao vivo'],
                        ['icon' => 'target', 'title' => 'Consultoria', 'desc' => 'Consultoria empresarial especializada para organizações'],
                        ['icon' => 'award', 'title' => 'Certificações', 'desc' => 'Certificados reconhecidos internacionalmente pelo mercado'],
                    ];
                }
            @endphp
            @foreach($servicosHome as $servico)
                <div class="feature-card group reveal hover-shine">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 group-hover:bg-accent flex items-center justify-center mb-4 transition-all duration-300 group-hover:scale-110">
                        <i data-lucide="{{ $servico['icon'] }}" class="w-6 h-6 text-accent group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="text-base font-bold text-foreground mb-2 group-hover:text-accent transition-colors">{{ $servico['title'] }}</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">{{ $servico['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Turmas Disponíveis --}}
<section class="py-16 bg-muted/40">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 reveal">
            <span class="text-xs font-bold uppercase tracking-widest text-accent mb-3 block">Próximas Turmas</span>
            <h2 class="section-title">Turmas Disponíveis</h2>
            <p class="section-subtitle">Inscreva-se já nas próximas turmas</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $popularityLabels = ['🔥 Alta procura', '⭐ Turma em destaque', '📈 Muito procurado', '🎯 Tendência de inscrição'];
            @endphp
            @forelse($turmas->take(6) as $turma)
                @php
                    $cursoNome   = $turma->curso->nome ?? 'Curso';
                    $imagemUrl   = $turma->curso->imagem_url ?? asset('assets/images-preview/courses/default.jpg');
                    $area        = $turma->curso->area ?? 'Geral';
                    $modalidade  = $turma->modalidade ?? 'Presencial';
                    $popLabel    = $popularityLabels[($turma->id ?? 0) % count($popularityLabels)];
                    $fakeProgress = min(92, max(58, 60 + (($turma->id ?? 0) * 7) % 32));
                @endphp
                <div class="feature-card overflow-hidden reveal group hover-shine">
                    <div class="relative mb-4 -mx-6 -mt-6 h-44 overflow-hidden">
                        <img src="{{ $imagemUrl }}" alt="{{ $cursoNome }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy"
                             onerror="this.src='{{ asset('assets/images-preview/courses/default.jpg') }}'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-3 left-4 flex gap-2">
                            <span class="badge-area">{{ $area }}</span>
                            <span class="badge-modalidade">{{ ucfirst($modalidade) }}</span>
                        </div>
                    </div>
                    <h3 class="text-base font-bold text-foreground mb-1 group-hover:text-accent transition-colors">{{ $cursoNome }}</h3>
                    <p class="text-xs text-muted-foreground mb-3 flex items-center gap-1.5">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        {{ isset($turma->data_arranque) ? \Carbon\Carbon::parse($turma->data_arranque)->format('d/m/Y') : 'Data a definir' }}
                        @if(isset($turma->centro->nome))
                            &nbsp;·&nbsp;<i data-lucide="map-pin" class="w-3.5 h-3.5"></i>{{ $turma->centro->nome }}
                        @endif
                    </p>

                    {{-- Popularity indicator --}}
                    <div class="mb-4">
                        <div class="flex justify-between text-[11px] mb-1.5">
                            <span class="popularity-label">{{ $popLabel }}</span>
                        </div>
                        <div class="popularity-bar">
                            <div class="popularity-bar-fill" style="width: {{ $fakeProgress }}%"></div>
                        </div>
                    </div>

                    <button onclick="window.dispatchEvent(new CustomEvent('pre-inscricao', { detail: { turmaId: {{ $turma->id }}, turmaNome: '{{ addslashes($cursoNome) }}' } }))"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-xl text-sm font-semibold bg-primary text-primary-foreground h-10 hover:bg-primary/90 active:scale-95 transition-all duration-200">
                        <i data-lucide="pen-line" class="w-4 h-4"></i>
                        Inscrever-se
                    </button>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-muted-foreground">
                    <i data-lucide="calendar-x" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
                    <p>Nenhuma turma disponível no momento.</p>
                </div>
            @endforelse
        </div>
        @if($turmas->count() > 6)
            <div class="text-center mt-10">
                <a href="{{ route('site.cursos') }}"
                   class="inline-flex items-center gap-2 rounded-xl text-sm font-semibold bg-primary text-primary-foreground h-11 px-8 hover:bg-primary/90 transition-all duration-200">
                    Ver Todas as Turmas <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        @endif
    </div>
</section>

{{-- CTA Banner --}}
<section class="page-hero">
    <div class="container mx-auto px-4 text-center text-primary-foreground relative">
        <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center mx-auto mb-6 animate-float">
            <i data-lucide="zap" class="w-8 h-8"></i>
        </div>
        <h2 class="text-3xl lg:text-4xl font-extrabold mb-4">Pronto para começar?</h2>
        <p class="text-lg opacity-80 mb-8 max-w-xl mx-auto">Junte-se a mais de 500 profissionais que já transformaram as suas carreiras com a MC-COMERCIAL.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('site.cursos') }}"
               class="inline-flex items-center gap-2 rounded-xl text-sm font-bold bg-accent text-accent-foreground h-12 px-8 hover:bg-accent/90 hover:scale-105 transition-all duration-200 shadow-lg">
                <i data-lucide="book-open" class="w-4 h-4"></i>
                Ver Cursos Disponíveis
            </a>
            <a href="{{ route('site.contactos') }}"
               class="inline-flex items-center gap-2 rounded-xl text-sm font-bold border-2 border-white/30 text-white h-12 px-8 hover:bg-white/15 transition-all duration-200">
                <i data-lucide="mail" class="w-4 h-4"></i>
                Falar Connosco
            </a>
        </div>
    </div>
</section>

@endsection
