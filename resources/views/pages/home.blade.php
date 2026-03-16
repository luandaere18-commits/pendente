@extends('layouts.public')

@section('title', 'MC-COMERCIAL - Centro de Formação Profissional')

@push('styles')
<link rel="preload" as="image"
      href="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1400&q=60"
      fetchpriority="high">
@endpush

@section('content')

{{-- ═══════════════════════════════════════
     HERO CAROUSEL
     ═══════════════════════════════════════ --}}
<section x-data="{
    active: 0,
    total: 4,
    autoplay: null,
    init() { this.autoplay = setInterval(() => this.next(), 6000); },
    next() { this.active = (this.active + 1) % this.total; this.resetAutoplay(); },
    prev() { this.active = (this.active - 1 + this.total) % this.total; this.resetAutoplay(); },
    goTo(i) { this.active = i; this.resetAutoplay(); },
    resetAutoplay() { clearInterval(this.autoplay); this.autoplay = setInterval(() => this.next(), 6000); }
}" class="relative overflow-hidden h-[85vh] md:h-[90vh]" x-cloak>

    @php
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

        {{-- Skeleton --}}
        <div class="hero-skeleton absolute inset-0 animate-shimmer"></div>

        <img src="{{ $slide['image'] }}" alt="{{ $slide['desc'] }}"
             loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
             class="w-full h-full object-cover opacity-0"
             style="transition: opacity 0.7s ease-out, transform 8s ease-out; {{ $index === 0 ? 'transform: scale(1.06)' : '' }}"
             onload="this.style.opacity='1'; var s=this.previousElementSibling; if(s) s.style.opacity='0';"
             onerror="this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=2070&q=80'; this.style.opacity='1';">

        {{-- Overlay with depth --}}
        <div class="absolute inset-0" style="background: linear-gradient(100deg, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.4) 50%, transparent 80%);">
            <div class="absolute inset-0 flex items-center">
                <div class="container mx-auto px-4">
                    <div class="max-w-2xl">
                        {{-- Tag --}}
                        <span class="inline-flex items-center gap-2.5 text-xs font-bold uppercase tracking-[0.15em] text-accent mb-6 bg-accent/10 border border-accent/20 px-4 py-2 rounded-full backdrop-blur-sm">
                            <span class="w-2 h-2 bg-accent rounded-full animate-pulse"></span>
                            {{ $slide['tag'] }}
                        </span>

                        {{-- Title --}}
                        <h1 class="text-4xl lg:text-5xl xl:text-6xl font-extrabold text-white leading-[1.08] mb-6" style="letter-spacing: -0.03em;">
                            {{ $slide['title'] }}<br>
                            <span class="gradient-text">{{ $slide['highlight'] }}</span>
                        </h1>

                        {{-- Desc --}}
                        <p class="text-base lg:text-lg text-white/70 mb-10 leading-relaxed max-w-xl">{{ $slide['desc'] }}</p>

                        {{-- CTAs --}}
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('site.cursos') }}" class="btn-accent">
                                <i data-lucide="book-open" class="w-4 h-4"></i>
                                Explorar Cursos
                            </a>
                            <a href="#sobre" class="btn-outline">
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
            class="absolute left-5 md:left-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md text-white flex items-center justify-center hover:bg-white/25 hover:scale-110 transition-all duration-300 z-20 border border-white/15"
            aria-label="Slide anterior">
        <i data-lucide="chevron-left" class="w-5 h-5"></i>
    </button>
    <button @click="next()" x-show="active < total - 1"
            class="absolute right-5 md:right-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md text-white flex items-center justify-center hover:bg-white/25 hover:scale-110 transition-all duration-300 z-20 border border-white/15"
            aria-label="Próximo slide">
        <i data-lucide="chevron-right" class="w-5 h-5"></i>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex items-center gap-2.5 z-20">
        @for($i = 0; $i < count($slides); $i++)
        <button @click="goTo({{ $i }})"
                :class="active === {{ $i }} ? 'w-10 bg-accent' : 'w-2.5 bg-white/40 hover:bg-white/70'"
                class="h-2.5 rounded-full transition-all duration-400"
                :aria-label="'Slide ' + {{ $i + 1 }}">
        </button>
        @endfor
    </div>

    {{-- Counter --}}
    <div class="absolute bottom-10 right-8 z-20 text-white/50 text-xs font-mono tabular-nums">
        <span x-text="active + 1" class="text-white font-bold text-lg"></span> / {{ count($slides) }}
    </div>
</section>

{{-- ═══════════════════════════════════════
     STATISTICS
     ═══════════════════════════════════════ --}}
<section class="py-20 bg-background relative" id="sobre">
    {{-- Decorative grid --}}
    <div class="absolute inset-0 dots-pattern opacity-30 pointer-events-none"></div>

    <div class="container mx-auto px-4 relative">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 reveal-stagger">
            @php
                $cursosCount = isset($cursos) ? $cursos->count() : 0;
                $centrosCount = isset($centros) ? $centros->count() : 0;
                $stats = [
                    ['icon' => 'users',      'value' => '500', 'suffix' => '+', 'label' => 'Alunos Formados',    'gradient' => 'from-blue-500/15 to-blue-500/5',   'iconColor' => 'text-blue-500'],
                    ['icon' => 'book-open',  'value' => $cursosCount, 'suffix' => '',  'label' => 'Cursos Disponíveis', 'gradient' => 'from-violet-500/15 to-violet-500/5', 'iconColor' => 'text-violet-500'],
                    ['icon' => 'building-2', 'value' => $centrosCount, 'suffix' => '',  'label' => 'Centros de Formação','gradient' => 'from-emerald-500/15 to-emerald-500/5','iconColor' => 'text-emerald-500'],
                    ['icon' => 'award',      'value' => '100', 'suffix' => '%', 'label' => 'Taxa de Sucesso',     'gradient' => 'from-amber-500/15 to-amber-500/5',  'iconColor' => 'text-amber-500'],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="glass-card text-center reveal group"
                     x-data="{
                         count: 0,
                         target: {{ is_numeric($stat['value']) ? $stat['value'] : 0 }},
                         started: false,
                         start() {
                             if (this.started) return;
                             this.started = true;
                             const duration = 1800;
                             const step = this.target / (duration / 16);
                             const timer = setInterval(() => {
                                 this.count = Math.min(Math.round(this.count + step), this.target);
                                 if (this.count >= this.target) clearInterval(timer);
                             }, 16);
                         }
                     }"
                     x-intersect.once="start()">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $stat['gradient'] }} flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform duration-500">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-7 h-7 {{ $stat['iconColor'] }}"></i>
                    </div>
                    <h3 class="text-4xl xl:text-5xl font-extrabold gradient-text mb-2 tabular-nums">
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

{{-- ═══════════════════════════════════════
     CENTROS PREVIEW
     ═══════════════════════════════════════ --}}
<section class="py-20 bg-muted/30">
    <div class="container mx-auto px-4">
        <div class="mb-14 reveal">
            <span class="section-tag">Nossa Rede</span>
            <h2 class="section-title">Centros de Formação</h2>
            <p class="section-subtitle">Espaços modernos e equipados para a sua formação profissional</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
            @forelse($centros->take(3) as $centro)
                <div class="feature-card group reveal">
                    <div class="flex items-start gap-4 mb-5">
                        <div class="icon-box icon-box-md bg-accent/10 group-hover:bg-accent transition-all duration-400 group-hover:scale-110 group-hover:rotate-3">
                            <i data-lucide="building-2" class="w-6 h-6 text-accent group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-foreground group-hover:text-accent transition-colors duration-300">{{ $centro->nome ?? 'Centro de Formação' }}</h3>
                            <p class="text-xs text-muted-foreground mt-0.5">Centro de Formação Profissional</p>
                        </div>
                    </div>
                    <div class="space-y-3 mb-6">
                        <p class="text-sm text-muted-foreground flex items-start gap-2.5">
                            <i data-lucide="map-pin" class="w-4 h-4 mt-0.5 shrink-0 text-accent"></i>
                            {{ $centro->localizacao ?? 'Localização a definir' }}
                        </p>
                        @if(!empty($centro->contactos) && count($centro->contactos) > 0)
                            <a href="tel:{{ $centro->contactos[0] }}" class="text-sm flex items-center gap-2.5 text-accent hover:underline group/link">
                                <i data-lucide="phone" class="w-4 h-4 group-hover/link:scale-110 transition-transform"></i>{{ $centro->contactos[0] }}
                            </a>
                        @endif
                    </div>
                    <p class="text-xs text-muted-foreground mb-5 flex items-center gap-2 bg-muted/50 rounded-xl px-3 py-2.5">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-accent"></i>
                        Seg-Sex: 8h-18h | Sáb: 9h-16h
                    </p>
                    <a href="{{ route('site.centros') }}"
                       class="btn-ghost w-full group/btn">
                        Ver Turmas <i data-lucide="arrow-right" class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 text-muted-foreground">
                    <div class="w-16 h-16 rounded-2xl bg-muted flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="building" class="w-8 h-8 opacity-40"></i>
                    </div>
                    Nenhum centro disponível no momento.
                </div>
            @endforelse
        </div>
        <div class="text-center mt-12 reveal">
            <a href="{{ route('site.centros') }}"
               class="inline-flex items-center gap-2 rounded-xl text-sm font-bold border-2 border-primary/20 text-primary h-12 px-10 hover:bg-primary hover:text-primary-foreground hover:border-primary transition-all duration-300">
                Ver Todos os Centros <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     SERVIÇOS
     ═══════════════════════════════════════ --}}
<section class="py-20 bg-background">
    <div class="container mx-auto px-4">
        <div class="mb-14 reveal">
            <span class="section-tag">O que Oferecemos</span>
            <h2 class="section-title">Nossos Serviços</h2>
            <p class="section-subtitle">Soluções completas para o seu desenvolvimento profissional</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
            @php
                $servicos = [
                    ['icon' => 'graduation-cap', 'title' => 'Formação Profissional', 'desc' => 'Cursos especializados em diversas áreas com certificação reconhecida'],
                    ['icon' => 'briefcase',      'title' => 'Projectos Académicos',  'desc' => 'Apoio na elaboração de trabalhos e dissertações académicas'],
                    ['icon' => 'pen-tool',       'title' => 'Workshops',             'desc' => 'Sessões práticas intensivas com especialistas da indústria'],
                    ['icon' => 'monitor',        'title' => 'Formação Online',       'desc' => 'Aprenda no seu ritmo com aulas gravadas e ao vivo'],
                    ['icon' => 'target',         'title' => 'Consultoria',           'desc' => 'Consultoria empresarial especializada para organizações'],
                    ['icon' => 'award',          'title' => 'Certificações',         'desc' => 'Certificados reconhecidos internacionalmente pelo mercado'],
                ];
            @endphp
            @foreach($servicos as $servico)
                <div class="feature-card group reveal">
                    <div class="icon-box icon-box-md bg-accent/10 group-hover:bg-accent mb-5 transition-all duration-400 group-hover:scale-110 group-hover:-rotate-3">
                        <i data-lucide="{{ $servico['icon'] }}" class="w-6 h-6 text-accent group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-foreground mb-2.5 group-hover:text-accent transition-colors duration-300">{{ $servico['title'] }}</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">{{ $servico['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     TURMAS DISPONÍVEIS
     ═══════════════════════════════════════ --}}
<section class="py-20 bg-muted/30">
    <div class="container mx-auto px-4">
        <div class="mb-14 reveal">
            <span class="section-tag">Próximas Turmas</span>
            <h2 class="section-title">Turmas Disponíveis</h2>
            <p class="section-subtitle">Inscreva-se já nas próximas turmas</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
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
                <div class="feature-card overflow-hidden reveal group p-0">
                    {{-- Image --}}
                    <div class="relative h-48 overflow-hidden img-overlay">
                        <img src="{{ $imagemUrl }}" alt="{{ $cursoNome }}"
                             class="w-full h-full object-cover"
                             loading="lazy">
                        <div class="absolute bottom-3 left-4 flex gap-2 z-10">
                            <span class="badge-area">{{ $area }}</span>
                            <span class="badge-modalidade">{{ $modalidade }}</span>
                        </div>
                        @if($isAlmostFull && $vagasDisp > 0)
                            <span class="absolute top-3 right-3 z-10 text-[10px] font-bold bg-destructive text-white px-3 py-1.5 rounded-full animate-pulse">
                                Últimas {{ $vagasDisp }} vagas!
                            </span>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-5">
                        <h3 class="text-base font-extrabold text-foreground mb-1.5 group-hover:text-accent transition-colors duration-300">{{ $cursoNome }}</h3>
                        <p class="text-xs text-muted-foreground mb-4 flex items-center gap-2">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                            {{ isset($turma->data_arranque) ? \Carbon\Carbon::parse($turma->data_arranque)->format('d/m/Y') : 'Data a definir' }}
                            @if(isset($turma->centro->nome))
                                <span class="opacity-40">·</span>
                                <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>{{ $turma->centro->nome }}
                            @endif
                        </p>

                        @if(isset($turma->vagas_totais) && $turma->vagas_totais > 0)
                            <div class="mb-5">
                                <div class="flex justify-between text-xs mb-2">
                                    <span class="text-muted-foreground flex items-center gap-1.5">
                                        <i data-lucide="users" class="w-3 h-3"></i>Vagas
                                    </span>
                                    <span class="{{ $isAlmostFull ? 'text-destructive font-bold' : 'text-foreground font-semibold' }} tabular-nums">
                                        {{ $vagasDisp }} disponíveis
                                    </span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill {{ $progress > 80 ? 'bg-destructive' : 'bg-accent' }}"
                                         style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        @endif

                        <button onclick="window.dispatchEvent(new CustomEvent('pre-inscricao', { detail: { turmaId: {{ $turma->id }}, turmaNome: '{{ addslashes($cursoNome) }}' } }))"
                                class="btn-primary w-full h-11 text-sm rounded-xl">
                            <i data-lucide="pen-line" class="w-4 h-4"></i>
                            Inscrever-se
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 text-muted-foreground">
                    <div class="w-16 h-16 rounded-2xl bg-muted flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="calendar-x" class="w-8 h-8 opacity-30"></i>
                    </div>
                    <p>Nenhuma turma disponível no momento.</p>
                </div>
            @endforelse
        </div>
        @if($turmas->count() > 6)
            <div class="text-center mt-12">
                <a href="{{ route('site.cursos') }}" class="btn-primary">
                    Ver Todas as Turmas <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        @endif
    </div>
</section>

{{-- ═══════════════════════════════════════
     CTA BANNER
     ═══════════════════════════════════════ --}}
<section class="py-24 relative overflow-hidden" style="background: var(--gradient-hero);">
    {{-- Decorative orbs --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full opacity-10" style="background: hsl(var(--accent)); filter: blur(120px);"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full opacity-5" style="background: white; filter: blur(100px);"></div>
    </div>

    <div class="container mx-auto px-4 text-center text-white relative reveal">
        <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center mx-auto mb-8 animate-float">
            <i data-lucide="zap" class="w-8 h-8"></i>
        </div>
        <h2 class="text-3xl lg:text-5xl font-extrabold mb-5" style="letter-spacing: -0.03em;">Pronto para começar?</h2>
        <p class="text-lg opacity-70 mb-10 max-w-xl mx-auto leading-relaxed">
            Junte-se a mais de 500 profissionais que já transformaram as suas carreiras com a MC-COMERCIAL.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('site.cursos') }}" class="btn-accent">
                <i data-lucide="book-open" class="w-4 h-4"></i>
                Ver Cursos Disponíveis
            </a>
            <a href="{{ route('site.contactos') }}" class="btn-outline">
                <i data-lucide="mail" class="w-4 h-4"></i>
                Falar Connosco
            </a>
        </div>
    </div>
</section>

@endsection
