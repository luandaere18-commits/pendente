@extends('layouts.public')

@section('title', 'MC-COMERCIAL — Centro de Formação Profissional em Angola')

@section('content')

{{-- ═══════════════════════════════════════
     HERO — Full-Width Carousel
     ═══════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-brand-950 text-white -mt-20 pt-20"
         x-data="{
             current: 0,
             slides: [
                 { img: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1600&q=80', title: 'Construa o seu futuro profissional', sub: 'Mais de 10 anos de experiência na preparação de profissionais qualificados para o mercado angolano.' },
                 { img: 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80', title: 'Formação de Excelência', sub: 'Cursos certificados com formadores experientes e material de qualidade para impulsionar a sua carreira.' },
                 { img: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1600&q=80', title: 'Certificados Reconhecidos', sub: 'Certificações válidas e reconhecidas pelo mercado de trabalho angolano e internacional.' },
                 { img: 'https://images.unsplash.com/photo-1560472355-536de3962603?auto=format&fit=crop&w=1600&q=80', title: 'Infraestrutura Moderna', sub: 'Centros de formação equipados com tecnologia de ponta em diversas províncias de Angola.' }
             ],
             autoplay: null,
             init() { this.autoplay = setInterval(() => { this.current = (this.current + 1) % this.slides.length; }, 5000); },
             goto(i) { this.current = i; clearInterval(this.autoplay); this.autoplay = setInterval(() => { this.current = (this.current + 1) % this.slides.length; }, 5000); },
             next() { this.goto((this.current + 1) % this.slides.length); },
             prev() { this.goto((this.current - 1 + this.slides.length) % this.slides.length); }
         }">

    {{-- Particles --}}
    <div class="particles">
        <div class="particle w-2 h-2" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
        <div class="particle w-3 h-3" style="top: 60%; left: 80%; animation-delay: 2s;"></div>
        <div class="particle w-1.5 h-1.5" style="top: 40%; left: 50%; animation-delay: 4s;"></div>
        <div class="particle w-2.5 h-2.5" style="top: 80%; left: 30%; animation-delay: 1s;"></div>
    </div>

    {{-- Slides --}}
    <div class="relative min-h-[90vh]">
        <template x-for="(slide, i) in slides" :key="i">
            <div class="absolute inset-0 transition-all duration-1000"
                 :class="current === i ? 'opacity-100 z-10 scale-100' : 'opacity-0 z-0 scale-105'">
                <img :src="slide.img" :alt="slide.title" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-brand-950/95 via-brand-950/70 to-brand-950/40"></div>
            </div>
        </template>

        {{-- Content --}}
        <div class="container-wide relative z-20 flex items-center min-h-[90vh]">
            <div class="max-w-2xl py-20">
                <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md mb-8 animate-fade-up">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-xs font-semibold text-brand-200 uppercase tracking-[0.15em]">Inscrições Abertas 2026</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black leading-[1.05] tracking-tight mb-6 font-heading"
                    x-text="slides[current].title"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">
                </h1>

                <p class="text-lg text-blue-100/70 leading-relaxed mb-10 max-w-lg"
                   x-text="slides[current].sub">
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('site.cursos') }}" class="btn-primary btn-lg group">
                        <i data-lucide="graduation-cap" class="w-5 h-5 group-hover:rotate-12 transition-transform"></i>
                        Explorar Cursos
                    </a>
                    <a href="{{ route('site.sobre') }}" class="btn-outline-white btn-lg group">
                        <i data-lucide="play-circle" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                        Saber Mais
                    </a>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-6 mt-16 pt-8 border-t border-white/15">
                    @foreach([
                        ['value' => 500, 'suffix' => '+', 'label' => 'Alunos Formados'],
                        ['value' => isset($cursos) ? $cursos->count() : 20, 'suffix' => '+', 'label' => 'Cursos Disponíveis'],
                        ['value' => isset($centros) ? $centros->count() : 5, 'suffix' => '', 'label' => 'Centros de Formação']
                    ] as $stat)
                        <div class="group">
                            <span class="text-3xl sm:text-4xl font-black text-white stat-number">
                                <span data-counter="{{ $stat['value'] }}">0</span>{{ $stat['suffix'] }}
                            </span>
                            <span class="block text-xs text-blue-200/50 mt-1 group-hover:text-blue-200 transition-colors">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Carousel Controls --}}
        <button @click="prev()" class="absolute left-6 top-1/2 -translate-y-1/2 z-30 w-14 h-14 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md flex items-center justify-center text-white transition-all duration-300 hover:scale-110 border border-white/10">
            <i data-lucide="chevron-left" class="w-6 h-6"></i>
        </button>
        <button @click="next()" class="absolute right-6 top-1/2 -translate-y-1/2 z-30 w-14 h-14 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md flex items-center justify-center text-white transition-all duration-300 hover:scale-110 border border-white/10">
            <i data-lucide="chevron-right" class="w-6 h-6"></i>
        </button>

        {{-- Dots --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-30 flex gap-3">
            <template x-for="(_, i) in slides" :key="'dot-'+i">
                <button @click="goto(i)" class="h-3 rounded-full transition-all duration-500"
                        :class="current === i ? 'w-10 bg-brand-400 shadow-lg shadow-brand-400/30' : 'w-3 bg-white/30 hover:bg-white/60'"></button>
            </template>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     FEATURES MARQUEE
     ═══════════════════════════════════════ --}}
<section class="py-5 bg-white border-b border-slate-100 overflow-hidden">
    <div class="marquee-container">
        <div class="marquee-content gap-12 py-2">
            @foreach([
                ['icon' => 'award',          'title' => 'Certificação Oficial'],
                ['icon' => 'users',          'title' => 'Formadores Experientes'],
                ['icon' => 'book-open',      'title' => 'Material Incluído'],
                ['icon' => 'briefcase',      'title' => 'Empregabilidade'],
                ['icon' => 'monitor',        'title' => 'Salas Equipadas'],
                ['icon' => 'clock',          'title' => 'Horários Flexíveis'],
                ['icon' => 'shield-check',   'title' => 'Qualidade Garantida'],
                ['icon' => 'trending-up',    'title' => 'Carreira em Crescimento'],
                ['icon' => 'award',          'title' => 'Certificação Oficial'],
                ['icon' => 'users',          'title' => 'Formadores Experientes'],
                ['icon' => 'book-open',      'title' => 'Material Incluído'],
                ['icon' => 'briefcase',      'title' => 'Empregabilidade'],
            ] as $feat)
                <div class="flex items-center gap-3 px-6 whitespace-nowrap">
                    <div class="w-8 h-8 rounded-lg bg-brand-100 flex items-center justify-center shrink-0">
                        <i data-lucide="{{ $feat['icon'] }}" class="w-4 h-4 text-brand-600"></i>
                    </div>
                    <span class="text-sm font-bold text-slate-700">{{ $feat['title'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     TURMAS — Cards with Hover Detail Overlay
     ═══════════════════════════════════════ --}}
@if(isset($turmas) && $turmas->count())
<section class="section bg-mesh">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge-brand mb-4">
                <i data-lucide="sparkles" class="w-3 h-3"></i>
                Turmas Disponíveis
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4 font-heading">Próximas Turmas</h2>
            <p class="text-slate-500 max-w-lg mx-auto">Passe o mouse nos cards para ver mais detalhes. Encontre a turma ideal para si.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
            @foreach($turmas->take(6) as $turma)
                <div class="card card-hover-detail overflow-hidden reveal group" style="height: 420px;">
                    {{-- Card Image --}}
                    <div class="absolute inset-0 img-overlay-zoom">
                        @if($turma->curso && $turma->curso->imagem_url)
                            <img src="{{ $turma->curso->imagem_url }}" alt="{{ $turma->curso->nome ?? '' }}"
                                 class="w-full h-full object-cover" loading="lazy">
                        @else
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=60"
                                 alt="{{ $turma->curso->nome ?? 'Curso' }}" class="w-full h-full object-cover" loading="lazy">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                    </div>

                    {{-- Basic Info (always visible) --}}
                    <div class="absolute bottom-0 left-0 right-0 p-6 z-10 transition-opacity duration-300 group-hover:opacity-0">
                        @if($turma->status)
                            <span class="badge-success text-[10px] mb-3">
                                <i data-lucide="check-circle" class="w-3 h-3"></i>
                                {{ $turma->status }}
                            </span>
                        @endif
                        <h3 class="text-lg font-bold text-white mb-1">{{ $turma->curso->nome ?? 'Curso' }}</h3>
                        @if($turma->centro)
                            <p class="text-sm text-white/60 flex items-center gap-1.5">
                                <i data-lucide="map-pin" class="w-3 h-3"></i>
                                {{ $turma->centro->nome }}
                            </p>
                        @endif
                    </div>

                    {{-- Detail Overlay (on hover) — NO SCROLLBAR --}}
                    <div class="card-detail-overlay z-20">
                        <div>
                            <h3 class="text-lg font-bold text-white mb-3 font-heading">{{ $turma->curso->nome ?? 'Curso' }}</h3>

                            <div class="space-y-2 text-sm">
                                @if($turma->centro)
                                    <div class="flex items-center gap-2 text-blue-200">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ $turma->centro->nome }}</span>
                                    </div>
                                @endif
                                @if($turma->data_arranque)
                                    <div class="flex items-center gap-2 text-blue-200">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>Início: {{ $turma->data_arranque->format('d/m/Y') }}</span>
                                    </div>
                                @endif
                                @if($turma->hora_inicio && $turma->hora_fim)
                                    <div class="flex items-center gap-2 text-blue-200">
                                        <i data-lucide="clock" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ $turma->hora_inicio }} — {{ $turma->hora_fim }}</span>
                                    </div>
                                @endif
                                @if($turma->periodo)
                                    <div class="flex items-center gap-2 text-blue-200">
                                        <i data-lucide="sun" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ ucfirst($turma->periodo) }}</span>
                                    </div>
                                @endif
                                @if($turma->modalidade)
                                    <div class="flex items-center gap-2 text-blue-200">
                                        <i data-lucide="monitor" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ ucfirst($turma->modalidade) }}</span>
                                    </div>
                                @endif
                                @if($turma->formador)
                                    <div class="flex items-center gap-2 text-blue-200">
                                        <i data-lucide="user" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ $turma->formador->nome }}</span>
                                    </div>
                                @endif
                                @if($turma->duracao_semanas)
                                    <div class="flex items-center gap-2 text-blue-200">
                                        <i data-lucide="timer" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ $turma->duracao_semanas }} semanas</span>
                                    </div>
                                @endif
                                @if($turma->vagas_disponiveis !== null)
                                    <div class="flex items-center gap-2 text-green-300">
                                        <i data-lucide="users" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ $turma->vagas_disponiveis }} vagas disponíveis</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-between mt-4 pt-3 border-t border-white/15">
                                @if($turma->centro_preco)
                                    <span class="text-xl font-black text-white">
                                        {{ number_format($turma->centro_preco, 0, ',', '.') }} <span class="text-xs">Kz</span>
                                    </span>
                                @else
                                    <span class="text-sm text-white/50 italic">Consultar preço</span>
                                @endif
                                <button @click="$dispatch('open-pre-inscricao', { turmaId: {{ $turma->id }}, turmaNome: '{{ $turma->curso->nome ?? '' }} — {{ $turma->centro->nome ?? '' }}' })"
                                        class="btn-primary btn-sm">
                                    <i data-lucide="send" class="w-3 h-3"></i>
                                    Inscrever
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-12 reveal">
            <a href="{{ route('site.cursos') }}" class="btn-primary btn-lg group">
                Ver Todas as Turmas
                <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════
     CENTROS — With "Ver Mais" links
     ═══════════════════════════════════════ --}}
@if(isset($centros) && $centros->count())
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="https://images.unsplash.com/photo-1560472355-536de3962603?auto=format&fit=crop&w=1600&q=80" alt="Centros">
    </div>
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge bg-white/20 text-white backdrop-blur-sm mb-4">
                <i data-lucide="building-2" class="w-3 h-3"></i>
                Nossos Centros
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold tracking-tight mb-4 font-heading">Centros de Formação</h2>
            <p class="text-blue-100/60">Presentes em várias localizações de Angola para estar mais perto de si.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
            @foreach($centros->take(6) as $centro)
                <div class="card-glass p-6 reveal group hover:scale-105 transition-all duration-300">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-brand-600/20 flex items-center justify-center group-hover:bg-brand-600 transition-all duration-300">
                            <i data-lucide="building-2" class="w-6 h-6 text-brand-300 group-hover:text-white transition-colors"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white">{{ $centro->nome }}</h3>
                            @if($centro->localizacao)
                                <p class="text-xs text-blue-200/60">{{ $centro->localizacao }}</p>
                            @endif
                        </div>
                    </div>

                    @if($centro->contactos && is_array($centro->contactos))
                        <div class="space-y-1.5 mb-4 text-xs text-blue-200/50">
                            @foreach(array_slice($centro->contactos, 0, 2) as $contacto)
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="phone" class="w-3 h-3"></i>
                                    <span>{{ $contacto }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($centro->email)
                        <p class="text-xs text-blue-200/50 flex items-center gap-1.5 mb-4">
                            <i data-lucide="mail" class="w-3 h-3"></i>
                            {{ $centro->email }}
                        </p>
                    @endif

                    {{-- Turmas count --}}
                    @if(isset($turmas))
                        @php $count = $turmas->where('centro_id', $centro->id)->count(); @endphp
                        @if($count > 0)
                            <span class="badge bg-green-500/20 text-green-300 text-[10px] mb-3">
                                {{ $count }} turma{{ $count > 1 ? 's' : '' }} activa{{ $count > 1 ? 's' : '' }}
                            </span>
                        @endif
                    @endif

                    <div class="flex gap-2 mt-2">
                        <a href="{{ route('site.centros') }}#centro-{{ $centro->id }}"
                           class="text-xs text-brand-300 font-semibold hover:text-white flex items-center gap-1 transition-colors group/link">
                            <i data-lucide="map" class="w-3 h-3"></i>
                            Ver Detalhes & Mapa
                            <i data-lucide="arrow-right" class="w-3 h-3 group-hover/link:translate-x-0.5 transition-transform"></i>
                        </a>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('site.cursos') }}?centro={{ $centro->id }}"
                           class="text-xs text-gold-400 font-semibold hover:text-white flex items-center gap-1 transition-colors group/link">
                            <i data-lucide="filter" class="w-3 h-3"></i>
                            Filtrar Turmas deste Centro
                            <i data-lucide="arrow-right" class="w-3 h-3 group-hover/link:translate-x-0.5 transition-transform"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-12 reveal">
            <a href="{{ route('site.centros') }}" class="btn bg-white text-brand-700 hover:bg-brand-50 btn-lg shadow-xl hover:shadow-2xl transition-all duration-300 group">
                Ver Todos os Centros
                <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════
     CURSOS CAROUSEL
     ═══════════════════════════════════════ --}}
@if(isset($cursos) && $cursos->count())
<section class="section bg-white">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge-brand mb-4">
                <i data-lucide="book-open" class="w-3 h-3"></i>
                Oferta Formativa
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4 font-heading">Nossos Cursos</h2>
            <p class="text-slate-500 max-w-lg mx-auto">Formação certificada em diversas áreas profissionais.</p>
        </div>

        <div class="reveal" x-data="{
            currentSlide: 0,
            totalSlides: {{ ceil($cursos->count() / 3) }},
            autoplay: null,
            init() { this.autoplay = setInterval(() => { this.currentSlide = (this.currentSlide + 1) % this.totalSlides; }, 4000); },
            goto(i) { this.currentSlide = i; clearInterval(this.autoplay); this.autoplay = setInterval(() => { this.currentSlide = (this.currentSlide + 1) % this.totalSlides; }, 4000); }
        }">
            <div class="carousel-container rounded-2xl">
                <div class="carousel-track" :style="'transform: translateX(-' + (currentSlide * 100) + '%)'">
                    @foreach($cursos->chunk(3) as $chunk)
                        <div class="carousel-slide">
                            <div class="grid sm:grid-cols-3 gap-6 px-2 py-4">
                                @foreach($chunk as $curso)
                                    <a href="{{ route('site.curso', $curso->id) }}" class="card card-interactive p-6 text-center group">
                                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-100 to-brand-200 flex items-center justify-center mx-auto mb-4 group-hover:from-brand-600 group-hover:to-brand-700 group-hover:scale-110 transition-all duration-300">
                                            <i data-lucide="graduation-cap" class="w-7 h-7 text-brand-600 group-hover:text-white transition-colors"></i>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-900 mb-2 group-hover:text-brand-600 transition-colors font-heading">{{ $curso->nome }}</h3>
                                        @if($curso->area)
                                            <span class="text-xs text-slate-400">{{ $curso->area }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="carousel-dots">
                <template x-for="i in totalSlides" :key="i">
                    <button @click="goto(i-1)" class="carousel-dot" :class="currentSlide === i-1 && 'active'"></button>
                </template>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════
     SERVIÇOS — Icon Cards with Images
     ═══════════════════════════════════════ --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1600&q=80" alt="Serviços">
    </div>
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge bg-white/20 text-white backdrop-blur-sm mb-4">
                <i data-lucide="briefcase" class="w-3 h-3"></i>
                O que Oferecemos
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold tracking-tight mb-4 font-heading">Nossos Serviços</h2>
            <p class="text-blue-100/60">Soluções completas de formação para indivíduos e empresas.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
            @foreach([
                ['icon' => 'graduation-cap', 'title' => 'Formação Profissional',  'desc' => 'Cursos certificados em diversas áreas com formação teórica e prática.'],
                ['icon' => 'building-2',     'title' => 'Formação Empresarial',    'desc' => 'Programas personalizados focados nas necessidades de cada empresa.'],
                ['icon' => 'monitor',        'title' => 'Workshops & Seminários',  'desc' => 'Sessões práticas e intensivas sobre temas actuais do mercado.'],
                ['icon' => 'file-check',     'title' => 'Consultoria',             'desc' => 'Apoio em gestão, planeamento e desenvolvimento organizacional.'],
                ['icon' => 'book-open',      'title' => 'Formação à Medida',       'desc' => 'Cursos desenhados para atender às suas necessidades específicas.'],
                ['icon' => 'award',          'title' => 'Certificações',           'desc' => 'Certificados reconhecidos pelo mercado de trabalho angolano.'],
            ] as $service)
                <div class="card-glass p-6 reveal group hover:scale-105 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-brand-600/20 flex items-center justify-center mb-5 group-hover:bg-brand-600 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <i data-lucide="{{ $service['icon'] }}" class="w-6 h-6 text-brand-300 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 font-heading">{{ $service['title'] }}</h3>
                    <p class="text-sm text-blue-100/50 leading-relaxed">{{ $service['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     HISTÓRIA — Timeline
     ═══════════════════════════════════════ --}}
<section class="section bg-white">
    <div class="container-tight">
        <div class="section-header reveal">
            <span class="badge-gold mb-4">
                <i data-lucide="clock" class="w-3 h-3"></i>
                Nossa Jornada
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4 font-heading">A Nossa História</h2>
            <p class="text-slate-500 max-w-lg mx-auto">Uma trajetória de excelência e dedicação à formação profissional em Angola.</p>
        </div>

        <div class="max-w-2xl mx-auto">
            <div class="timeline">
                @foreach([
                    ['year' => '2012', 'title' => 'Fundação da MC-COMERCIAL', 'desc' => 'Nascemos com a missão de formar profissionais qualificados para o mercado angolano. Começámos com apenas 2 salas de formação em Luanda.'],
                    ['year' => '2014', 'title' => 'Primeiro Centro de Formação', 'desc' => 'Inauguração do nosso primeiro centro com equipamentos modernos e 5 cursos disponíveis. Já contávamos com 50 alunos formados.'],
                    ['year' => '2016', 'title' => 'Expansão para Novas Áreas', 'desc' => 'Ampliámos a nossa oferta formativa para 15 cursos em áreas como informática, gestão, electricidade e mecânica.'],
                    ['year' => '2018', 'title' => 'Reconhecimento Nacional', 'desc' => 'Recebemos certificação oficial e reconhecimento como centro de formação de referência. Mais de 200 alunos formados.'],
                    ['year' => '2020', 'title' => 'Inovação Digital', 'desc' => 'Adaptação às novas realidades com formação híbrida (presencial + online). Implementação de plataformas digitais de ensino.'],
                    ['year' => '2022', 'title' => 'Múltiplos Centros', 'desc' => 'Abertura de novos centros de formação em diferentes províncias de Angola, levando educação de qualidade a mais pessoas.'],
                    ['year' => '2024', 'title' => 'Parcerias Internacionais', 'desc' => 'Estabelecimento de parcerias com instituições internacionais para certificações reconhecidas globalmente.'],
                    ['year' => '2026', 'title' => 'O Futuro é Agora', 'desc' => 'Mais de 500 alunos formados, +20 cursos e presença em várias províncias. Continuamos a crescer e a inovar na formação profissional.'],
                ] as $i => $event)
                    <div class="timeline-item reveal" style="transition-delay: {{ $i * 100 }}ms;">
                        <div class="timeline-year">{{ $event['year'] }}</div>
                        <div class="timeline-title">{{ $event['title'] }}</div>
                        <div class="timeline-desc">{{ $event['desc'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     PORQUE NÓS — Stats + Benefits
     ═══════════════════════════════════════ --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1600&q=80" alt="Porquê">
    </div>
    <div class="container-wide">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="reveal-left">
                <span class="badge bg-white/20 text-white backdrop-blur-sm mb-5">
                    <i data-lucide="star" class="w-3 h-3"></i>
                    Porquê a MC-COMERCIAL?
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight mb-6 font-heading">Razões para nos escolher</h2>
                <p class="text-blue-100/60 leading-relaxed mb-8">
                    Combinamos experiência, qualidade e inovação para oferecer a melhor formação profissional em Angola.
                </p>

                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        ['icon' => 'trophy', 'value' => '10+', 'label' => 'Anos de Experiência'],
                        ['icon' => 'users', 'value' => '500+', 'label' => 'Alunos Formados'],
                        ['icon' => 'book-open', 'value' => '20+', 'label' => 'Cursos Activos'],
                        ['icon' => 'percent', 'value' => '95%', 'label' => 'Taxa de Satisfação'],
                    ] as $stat)
                        <div class="p-5 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/10 hover:bg-white/20 transition-all duration-300 group hover:scale-105">
                            <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6 text-brand-300 mb-3 group-hover:scale-110 transition-transform"></i>
                            <div class="text-2xl font-black text-white font-heading">{{ $stat['value'] }}</div>
                            <div class="text-xs text-blue-200/50 mt-1">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="reveal-right">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=600&q=70"
                         alt="Formação" class="rounded-2xl shadow-2xl w-full aspect-[3/4] object-cover animate-float" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=70"
                         alt="Alunos" class="rounded-2xl shadow-2xl w-full aspect-[3/4] object-cover mt-8 animate-float-reverse" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     TESTIMONIALS / PARTNERS
     ═══════════════════════════════════════ --}}
<section class="section bg-slate-50">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge-brand mb-4">
                <i data-lucide="message-circle" class="w-3 h-3"></i>
                Testemunhos
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4 font-heading">O que Dizem os Nossos Alunos</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6 reveal-stagger">
            @foreach([
                ['name' => 'Maria João', 'role' => 'Formanda em Gestão', 'text' => 'A MC-COMERCIAL mudou a minha vida profissional. Os formadores são excepcionais e o ambiente de aprendizagem é motivador. Recomendo a todos!', 'rating' => 5],
                ['name' => 'António Silva', 'role' => 'Formando em Informática', 'text' => 'Excelente formação prática. Depois do curso consegui imediatamente uma colocação no mercado de trabalho. Gratidão total!', 'rating' => 5],
                ['name' => 'Rosa Mendes', 'role' => 'Formanda em Electricidade', 'text' => 'O material de apoio é completo e os formadores estão sempre disponíveis. Uma experiência formativa que vale cada kwanza investido.', 'rating' => 5],
            ] as $test)
                <div class="card p-6 reveal hover-lift">
                    <div class="flex gap-1 mb-4">
                        @for($i = 0; $i < $test['rating']; $i++)
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        @endfor
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed mb-6 italic">"{{ $test['text'] }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($test['name'], 0, 1) }}
                        </div>
                        <div>
                            <span class="text-sm font-bold text-slate-900 block">{{ $test['name'] }}</span>
                            <span class="text-xs text-slate-400">{{ $test['role'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     CTA FINAL
     ═══════════════════════════════════════ --}}
<section class="py-24 bg-gradient-to-br from-brand-700 via-brand-800 to-brand-950 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-5"></div>
    <div class="particles">
        <div class="particle w-3 h-3" style="top: 30%; left: 20%; animation-delay: 0s;"></div>
        <div class="particle w-2 h-2" style="top: 70%; left: 70%; animation-delay: 3s;"></div>
        <div class="particle w-4 h-4" style="top: 50%; left: 40%; animation-delay: 1.5s;"></div>
    </div>
    <div class="container-tight text-center relative z-10">
        <div class="reveal">
            <span class="badge bg-white/20 text-white backdrop-blur-sm mb-6">
                <i data-lucide="rocket" class="w-3 h-3"></i>
                Comece Agora
            </span>
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight mb-5 font-heading">Pronto para transformar o seu futuro?</h2>
            <p class="text-blue-100/60 mb-10 max-w-lg mx-auto text-lg">Inscreva-se hoje e dê o primeiro passo rumo a uma carreira de sucesso.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('site.cursos') }}" class="btn bg-white text-brand-700 hover:bg-brand-50 btn-lg shadow-xl hover:shadow-2xl transition-all duration-300 group">
                    <i data-lucide="graduation-cap" class="w-5 h-5 group-hover:rotate-12 transition-transform"></i>
                    Explorar Cursos
                </a>
                <a href="{{ route('site.contactos') }}" class="btn-outline-white btn-lg">
                    <i data-lucide="phone" class="w-5 h-5"></i>
                    Fale Connosco
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
