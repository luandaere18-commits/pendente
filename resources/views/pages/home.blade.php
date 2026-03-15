@extends('layouts.public')

@section('title', 'MC-COMERCIAL - Centro de Formação Profissional')

@push('styles')
{{-- Preload da primeira imagem do carrossel (melhora LCP) --}}
<link rel="preload" as="image"
      href="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1400&q=60"
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
        // w=1400&q=60 — menor tamanho e qualidade reduzida para carregamento mais rápido
        $slides = [
            ['image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1400&q=60', 'tag' => 'Formação Profissional',   'title' => 'Invista no seu',   'highlight' => 'Futuro Profissional',      'desc' => 'Formação de qualidade com mais de 10 anos de experiência na preparação de profissionais qualificados para o mercado de trabalho angolano.'],
            ['image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=1400&q=60', 'tag' => 'Instrutores Experientes', 'title' => 'Aprenda com os',  'highlight' => 'Melhores Formadores',     'desc' => 'Salas equipadas com tecnologia de ponta e formadores experientes para garantir a melhor experiência de aprendizagem.'],
            ['image' => 'https://images.unsplash.com/photo-1606761568499-6d2451b23c66?auto=format&fit=crop&w=1400&q=60', 'tag' => 'Certificação Reconhecida','title' => 'Conquiste o seu', 'highlight' => 'Certificado Profissional', 'desc' => 'Certificações reconhecidas pelo mercado que abrem portas para novas oportunidades de carreira em Angola e no exterior.'],
            ['image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1400&q=60', 'tag' => 'Workshops & Práticas',   'title' => 'Workshops e',    'highlight' => 'Formações Práticas',      'desc' => 'Sessões práticas e intensivas que preparam você para os desafios reais do mercado de trabalho moderno.'],
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
        {{-- Skeleton placeholder enquanto a imagem carrega --}}
        <div class="hero-skeleton absolute inset-0 bg-gradient-to-br from-primary/80 via-primary/60 to-secondary/80 animate-shimmer"></div>
        <img src="{{ $slide['image'] }}" alt="{{ $slide['desc'] }}"
             loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
             class="w-full h-full object-cover scale-100 opacity-0 hero-img"
             style="transition: opacity 0.7s ease-out, transform 6s ease-out; {{ $index === 0 ? 'transform: scale(1.06)' : '' }}"
             onload="this.style.opacity='1'; var s=this.previousElementSibling; if(s) s.style.opacity='0';"
             onerror="this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=2070&q=80'; this.style.opacity='1'; var s=this.previousElementSibling; if(s) s.style.opacity='0';">
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
                               class="inline-flex items-center gap-2 rounded-xl text-sm font-bold bg-accent text-accent-foreground h-12 px-6 hover:bg-accent/90 hover:scale-105 active:scale-95 transition-all duration-200 shadow-lg">
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
    <button @click="prev()" x-show="active > 0"
            class="absolute left-4 md:left-6 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/15 backdrop-blur-sm text-white flex items-center justify-center hover:bg-white/30 hover:scale-110 transition-all duration-200 z-20 border border-white/20"
            aria-label="Slide anterior">
        <i data-lucide="chevron-left" class="w-5 h-5"></i>
    </button>
    <button @click="next()" x-show="active < total - 1"
            class="absolute right-4 md:right-6 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/15 backdrop-blur-sm text-white flex items-center justify-center hover:bg-white/30 hover:scale-110 transition-all duration-200 z-20 border border-white/20"
            aria-label="Próximo slide">
        <i data-lucide="chevron-right" class="w-5 h-5"></i>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-2 z-20">
        @for($i = 0; $i < count($slides); $i++)
        <button @click="goTo({{ $i }})"
                :class="active === {{ $i }} ? 'w-8 bg-accent' : 'w-2 bg-white/40 hover:bg-white/70'"
                class="h-2 rounded-full transition-all duration-300"
                :aria-label="'Slide ' + {{ $i + 1 }}">
        </button>
        @endfor
    </div>

    {{-- Slide counter --}}
    <div class="absolute bottom-8 right-6 z-20 text-white/60 text-xs font-mono tabular-nums">
        <span x-text="active + 1" class="text-white font-bold text-base"></span> / {{ count($slides) }}
    </div>
</section>

{{-- Estatísticas --}}
<section class="py-16 bg-background" id="sobre">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @php
                $cursosCount = isset($cursos) ? $cursos->count() : 0;
                $centrosCount = isset($centros) ? $centros->count() : 0;
                $stats = [
                    ['icon' => 'users', 'value' => '500', 'suffix' => '+', 'label' => 'Alunos Formados', 'color' => 'text-blue-500', 'bg' => 'bg-blue-500/10'],
                    ['icon' => 'book-open', 'value' => $cursosCount, 'suffix' => '', 'label' => 'Cursos Disponíveis', 'color' => 'text-violet-500', 'bg' => 'bg-violet-500/10'],
                    ['icon' => 'building-2', 'value' => $centrosCount, 'suffix' => '', 'label' => 'Centros de Formação', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-500/10'],
                    ['icon' => 'award', 'value' => '100', 'suffix' => '%', 'label' => 'Taxa de Sucesso', 'color' => 'text-amber-500', 'bg' => 'bg-amber-500/10'],
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
                <div class="feature-card group reveal">
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
                $servicos = [
                    ['icon' => 'graduation-cap', 'title' => 'Formação Profissional', 'desc' => 'Cursos especializados em diversas áreas com certificação reconhecida', 'color' => 'blue'],
                    ['icon' => 'briefcase', 'title' => 'Projectos Académicos', 'desc' => 'Apoio na elaboração de trabalhos e dissertações académicas', 'color' => 'violet'],
                    ['icon' => 'pen-tool', 'title' => 'Workshops', 'desc' => 'Sessões práticas intensivas com especialistas da indústria', 'color' => 'emerald'],
                    ['icon' => 'monitor', 'title' => 'Formação Online', 'desc' => 'Aprenda no seu ritmo com aulas gravadas e ao vivo', 'color' => 'cyan'],
                    ['icon' => 'target', 'title' => 'Consultoria', 'desc' => 'Consultoria empresarial especializada para organizações', 'color' => 'amber'],
                    ['icon' => 'award', 'title' => 'Certificações', 'desc' => 'Certificados reconhecidos internacionalmente pelo mercado', 'color' => 'rose'],
                ];
            @endphp
            @foreach($servicos as $servico)
                <div class="feature-card group reveal">
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
            @forelse($turmas->take(6) as $turma)
                @php
                    $vagasDisp = isset($turma->vagas_totais) && isset($turma->vagas_preenchidas)
                        ? $turma->vagas_totais - $turma->vagas_preenchidas : 0;
                    $progress = isset($turma->vagas_totais) && $turma->vagas_totais > 0
                        ? ($turma->vagas_preenchidas / $turma->vagas_totais) * 100 : 0;
                    $cursoNome = $turma->curso->nome ?? 'Curso';
                    $imagemUrl = $turma->curso->imagem_url ?? 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80';
                    $area = $turma->curso->area ?? 'Geral';
                    $modalidade = $turma->curso->modalidade ?? 'Presencial';
                    $isAlmostFull = $vagasDisp < 5;
                @endphp
                <div class="feature-card overflow-hidden reveal group">
                    <div class="relative mb-4 -mx-6 -mt-6 h-44 overflow-hidden">
                        <img src="{{ $imagemUrl }}" alt="{{ $cursoNome }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-3 left-4 flex gap-2">
                            <span class="badge-area">{{ $area }}</span>
                            <span class="badge-modalidade">{{ $modalidade }}</span>
                        </div>
                        @if($isAlmostFull && $vagasDisp > 0)
                            <span class="absolute top-3 right-3 text-[10px] font-bold bg-destructive text-white px-2 py-1 rounded-full animate-pulse">
                                Últimas {{ $vagasDisp }} vagas!
                            </span>
                        @endif
                    </div>
                    <h3 class="text-base font-bold text-foreground mb-1 group-hover:text-accent transition-colors">{{ $cursoNome }}</h3>
                    <p class="text-xs text-muted-foreground mb-3 flex items-center gap-1.5">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        {{ isset($turma->data_arranque) ? \Carbon\Carbon::parse($turma->data_arranque)->format('d/m/Y') : 'Data a definir' }}
                        @if(isset($turma->centro->nome))
                            &nbsp;·&nbsp;<i data-lucide="map-pin" class="w-3.5 h-3.5"></i>{{ $turma->centro->nome }}
                        @endif
                    </p>
                    @if(isset($turma->vagas_totais) && $turma->vagas_totais > 0)
                        <div class="mb-4">
                            <div class="flex justify-between text-xs mb-1.5">
                                <span class="text-muted-foreground flex items-center gap-1">
                                    <i data-lucide="users" class="w-3 h-3"></i>Vagas
                                </span>
                                <span class="{{ $isAlmostFull ? 'text-destructive font-semibold' : 'text-foreground' }}">
                                    {{ $vagasDisp }} disponíveis
                                </span>
                            </div>
                            <div class="w-full h-1.5 bg-muted rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-1000 {{ $progress > 80 ? 'bg-destructive' : 'bg-accent' }}"
                                     style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    @endif
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
<section class="py-16 bg-gradient-to-br from-primary via-primary to-primary/80 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-accent blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full bg-white blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 text-center text-primary-foreground relative">
        <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center mx-auto mb-6">
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
