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
    <div class="particles">
        <div class="particle w-2 h-2" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
        <div class="particle w-3 h-3" style="top: 60%; left: 80%; animation-delay: 2s;"></div>
        <div class="particle w-1.5 h-1.5" style="top: 40%; left: 50%; animation-delay: 4s;"></div>
        <div class="particle w-2.5 h-2.5" style="top: 80%; left: 30%; animation-delay: 1s;"></div>
    </div>

    <div class="relative min-h-[90vh]">
        <template x-for="(slide, i) in slides" :key="i">
            <div class="absolute inset-0 transition-all duration-1000"
                 :class="current === i ? 'opacity-100 z-10 scale-100' : 'opacity-0 z-0 scale-105'">
                <img :src="slide.img" :alt="slide.title" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-brand-950/95 via-brand-950/70 to-brand-950/40"></div>
            </div>
        </template>

        <div class="container-wide relative z-20 flex items-center min-h-[90vh]">
            <div class="max-w-2xl py-20">
                <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md mb-8 animate-fade-up">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-xs font-semibold text-brand-200 uppercase tracking-[0.15em]">Inscrições Abertas 2026</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black leading-[1.05] tracking-tight mb-6 font-heading"
                    x-text="slides[current].title"></h1>

                <p class="text-lg text-blue-100/70 leading-relaxed mb-10 max-w-lg"
                   x-text="slides[current].sub"></p>

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

        <button @click="prev()" class="absolute left-6 top-1/2 -translate-y-1/2 z-30 w-14 h-14 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md flex items-center justify-center text-white transition-all duration-300 hover:scale-110 border border-white/10">
            <i data-lucide="chevron-left" class="w-6 h-6"></i>
        </button>
        <button @click="next()" class="absolute right-6 top-1/2 -translate-y-1/2 z-30 w-14 h-14 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md flex items-center justify-center text-white transition-all duration-300 hover:scale-110 border border-white/10">
            <i data-lucide="chevron-right" class="w-6 h-6"></i>
        </button>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-30 flex gap-3">
            <template x-for="(_, i) in slides" :key="'dot-'+i">
                <button @click="goto(i)" class="h-3 rounded-full transition-all duration-500"
                        :class="current === i ? 'w-10 bg-brand-400 shadow-lg shadow-brand-400/30' : 'w-3 bg-white/30 hover:bg-white/60'"></button>
            </template>
        </div>
    </div>
</section>

{{-- FEATURES MARQUEE --}}
<section class="py-5 bg-white border-b border-slate-100 overflow-hidden">
    <div class="marquee-container">
        <div class="marquee-content gap-12 py-2">
            @foreach([
                ['icon' => 'award', 'title' => 'Certificação Oficial'],
                ['icon' => 'users', 'title' => 'Formadores Experientes'],
                ['icon' => 'book-open', 'title' => 'Material Incluído'],
                ['icon' => 'briefcase', 'title' => 'Empregabilidade'],
                ['icon' => 'monitor', 'title' => 'Salas Equipadas'],
                ['icon' => 'clock', 'title' => 'Horários Flexíveis'],
                ['icon' => 'shield-check', 'title' => 'Qualidade Garantida'],
                ['icon' => 'trending-up', 'title' => 'Carreira em Crescimento'],
                ['icon' => 'award', 'title' => 'Certificação Oficial'],
                ['icon' => 'users', 'title' => 'Formadores Experientes'],
                ['icon' => 'book-open', 'title' => 'Material Incluído'],
                ['icon' => 'briefcase', 'title' => 'Empregabilidade'],
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

{{-- TURMAS --}}
@if(isset($turmas) && $turmas->count())
<section class="section bg-mesh">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge-brand mb-4">
                <i data-lucide="sparkles" class="w-3 h-3"></i>
                Turmas Disponíveis
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4 font-heading">Próximas Turmas</h2>
            <p class="text-slate-500 max-w-lg mx-auto">Passe o mouse nos cards para ver mais detalhes.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
            @foreach($turmas->take(6) as $turma)
                <div class="card card-hover-detail overflow-hidden reveal group" style="height: 380px;">
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

                    <div class="absolute bottom-0 left-0 right-0 p-5 z-10 transition-opacity duration-300 group-hover:opacity-0">
                        @if($turma->status)
                            <span class="badge-success text-[10px] mb-2">{{ $turma->status }}</span>
                        @endif
                        <h3 class="text-lg font-bold text-white font-heading">{{ $turma->curso->nome ?? 'Curso' }}</h3>
                        @if($turma->centro)
                            <p class="text-sm text-white/60 flex items-center gap-1 mt-1">
                                <i data-lucide="map-pin" class="w-3 h-3"></i> {{ $turma->centro->nome }}
                            </p>
                        @endif
                        @if($turma->centro_preco)
                            <p class="text-lg font-black text-white mt-2">{{ number_format($turma->centro_preco, 0, ',', '.') }} <span class="text-xs">Kz</span></p>
                        @endif
                    </div>

                    <div class="card-detail-overlay z-20">
                        <div>
                            <h3 class="text-lg font-bold text-white mb-3 font-heading">{{ $turma->curso->nome ?? 'Curso' }}</h3>
                            <div class="space-y-2 text-sm">
                                @if($turma->centro)
                                    <div class="flex items-center gap-2 text-blue-200"><i data-lucide="map-pin" class="w-3.5 h-3.5 shrink-0"></i><span>{{ $turma->centro->nome }}</span></div>
                                @endif
                                @if($turma->data_arranque)
                                    <div class="flex items-center gap-2 text-blue-200"><i data-lucide="calendar" class="w-3.5 h-3.5 shrink-0"></i><span>Início: {{ $turma->data_arranque->format('d/m/Y') }}</span></div>
                                @endif
                                @if($turma->hora_inicio && $turma->hora_fim)
                                    <div class="flex items-center gap-2 text-blue-200"><i data-lucide="clock" class="w-3.5 h-3.5 shrink-0"></i><span>{{ $turma->hora_inicio }} — {{ $turma->hora_fim }}</span></div>
                                @endif
                                @if($turma->formador)
                                    <div class="flex items-center gap-2 text-blue-200"><i data-lucide="user" class="w-3.5 h-3.5 shrink-0"></i><span>{{ $turma->formador->nome }}</span></div>
                                @endif
                                @if($turma->vagas_disponiveis !== null)
                                    <div class="flex items-center gap-2 text-green-300"><i data-lucide="users" class="w-3.5 h-3.5 shrink-0"></i><span>{{ $turma->vagas_disponiveis }} vagas</span></div>
                                @endif
                            </div>
                            <div class="flex items-center justify-between mt-4 pt-3 border-t border-white/15">
                                @if($turma->centro_preco)
                                    <span class="text-xl font-black text-white">{{ number_format($turma->centro_preco, 0, ',', '.') }} <span class="text-xs">Kz</span></span>
                                @else
                                    <span class="text-sm text-white/50 italic">Consultar preço</span>
                                @endif
                                <button @click="$dispatch('open-pre-inscricao', { turmaId: {{ $turma->id }}, turmaNome: '{{ addslashes($turma->curso->nome ?? '') }} — {{ addslashes($turma->centro->nome ?? '') }}' })"
                                        class="btn-primary btn-sm">
                                    <i data-lucide="send" class="w-3 h-3"></i> Inscrever
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-12 reveal">
            <a href="{{ route('site.cursos') }}" class="btn-primary btn-lg group">
                Ver Todos os Cursos
                <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- CENTROS — Cards com imagem e info visível --}}
@if(isset($centros) && $centros->count())
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="{{ asset('images/fundo_imagem.jpg') }}" alt="Centros">
    </div>
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge bg-white/20 text-white backdrop-blur-sm mb-4">
                <i data-lucide="building-2" class="w-3 h-3"></i>
                Nossos Centros
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold tracking-tight mb-4 font-heading">Centros de Formação</h2>
            <p class="text-blue-100/60">Presentes em várias localizações de Angola.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
            @foreach($centros->take(6) as $centro)
                <div class="rounded-2xl overflow-hidden reveal group hover:scale-[1.02] transition-all duration-300 bg-white/10 backdrop-blur-sm border border-white/20">
                    {{-- Imagem real --}}
                    <div class="h-44 overflow-hidden">
                        @if($centro->imagem)
                            <img src="{{ asset('storage/' . $centro->imagem) }}" alt="{{ $centro->nome }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        @else
                            <img src="https://images.unsplash.com/photo-1560472355-536de3962603?auto=format&fit=crop&w=500&q=60"
                                 alt="{{ $centro->nome }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="text-base font-bold text-white mb-1">{{ $centro->nome }}</h3>
                        @if($centro->localizacao)
                            <p class="text-sm text-blue-200/70 flex items-center gap-1 mb-2">
                                <i data-lucide="map-pin" class="w-3 h-3"></i> {{ $centro->localizacao }}
                            </p>
                        @endif
                        @if($centro->email)
                            <p class="text-xs text-blue-200/50 flex items-center gap-1 mb-1">
                                <i data-lucide="mail" class="w-3 h-3"></i> {{ $centro->email }}
                            </p>
                        @endif
                        @if($centro->contactos && is_array($centro->contactos))
                            @foreach(array_slice($centro->contactos, 0, 1) as $contacto)
                                <p class="text-xs text-blue-200/50 flex items-center gap-1">
                                    <i data-lucide="phone" class="w-3 h-3"></i> {{ $contacto }}
                                </p>
                            @endforeach
                        @endif
                        <div class="mt-3">
                            <a href="{{ route('site.cursos') }}?centro={{ $centro->id }}"
                               class="text-xs text-brand-300 font-semibold hover:text-white flex items-center gap-1 transition-colors">
                                Ver Turmas <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        </div>
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

{{-- CURSOS CAROUSEL --}}
@if(isset($cursos) && $cursos->count())
<section class="section bg-white">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge-brand mb-4"><i data-lucide="book-open" class="w-3 h-3"></i> Oferta Formativa</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4 font-heading">Nossos Cursos</h2>
            <p class="text-slate-500 max-w-lg mx-auto">Formação certificada em diversas áreas profissionais.</p>
        </div>

        <div class="reveal" x-data="{ currentSlide: 0, totalSlides: {{ ceil($cursos->count() / 3) }}, autoplay: null, init() { this.autoplay = setInterval(() => { this.currentSlide = (this.currentSlide + 1) % this.totalSlides; }, 4000); }, goto(i) { this.currentSlide = i; clearInterval(this.autoplay); this.autoplay = setInterval(() => { this.currentSlide = (this.currentSlide + 1) % this.totalSlides; }, 4000); } }">
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

{{-- SERVIÇOS — Cards com imagem real --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="{{ asset('images/fundo_imagem.jpg') }}" alt="Serviços">
    </div>
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge bg-white/20 text-white backdrop-blur-sm mb-4"><i data-lucide="briefcase" class="w-3 h-3"></i> O que Oferecemos</span>
            <h2 class="text-3xl sm:text-4xl font-bold tracking-tight mb-4 font-heading">Nossos Serviços</h2>
            <p class="text-blue-100/60">Soluções completas de formação para indivíduos e empresas.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
            @foreach([
                ['icon' => 'graduation-cap', 'title' => 'Formação Profissional',  'desc' => 'Cursos certificados em diversas áreas com formação teórica e prática.', 'img' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=60'],
                ['icon' => 'building-2',     'title' => 'Formação Empresarial',    'desc' => 'Programas personalizados focados nas necessidades de cada empresa.', 'img' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=600&q=60'],
                ['icon' => 'monitor',        'title' => 'Workshops & Seminários',  'desc' => 'Sessões práticas e intensivas sobre temas actuais do mercado.', 'img' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=600&q=60'],
                ['icon' => 'file-check',     'title' => 'Consultoria',             'desc' => 'Apoio em gestão, planeamento e desenvolvimento organizacional.', 'img' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=600&q=60'],
                ['icon' => 'book-open',      'title' => 'Formação à Medida',       'desc' => 'Cursos desenhados para atender às suas necessidades específicas.', 'img' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=60'],
                ['icon' => 'award',          'title' => 'Certificações',           'desc' => 'Certificados reconhecidos pelo mercado de trabalho angolano.', 'img' => 'https://images.unsplash.com/photo-1573164574511-73c773193279?auto=format&fit=crop&w=600&q=60'],
            ] as $service)
                <div class="rounded-2xl overflow-hidden reveal group hover:scale-[1.02] transition-all duration-300 bg-white/10 backdrop-blur-sm border border-white/20">
                    <div class="h-40 overflow-hidden">
                        <img src="{{ $service['img'] }}" alt="{{ $service['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                    </div>
                    <div class="p-5">
                        <div class="w-12 h-12 rounded-xl bg-brand-600/30 flex items-center justify-center mb-3 -mt-9 relative z-10 border-2 border-white/20 backdrop-blur-sm group-hover:bg-brand-600 transition-all duration-300">
                            <i data-lucide="{{ $service['icon'] }}" class="w-5 h-5 text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 font-heading">{{ $service['title'] }}</h3>
                        <p class="text-sm text-blue-100/60 leading-relaxed">{{ $service['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- HISTÓRIA — Timeline alternada (igual nossa_jornada.png) --}}
<section class="section bg-white">
    <div class="container-tight">
        <div class="section-header reveal">
            <span class="badge-gold mb-4">A NOSSA HISTÓRIA</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4 font-heading">Uma jornada de excelência</h2>
            <p class="text-slate-500 max-w-lg mx-auto">Conheça os marcos importantes da nossa trajetória.</p>
        </div>

        <div class="relative max-w-4xl mx-auto">
            <div class="absolute left-1/2 transform -translate-x-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-brand-200 via-brand-400 to-brand-200"></div>

            @foreach([
                ['year' => '2013', 'title' => 'Fundação', 'desc' => 'A MC-COMERCIAL foi fundada em Luanda com a missão de formar profissionais qualificados para o mercado angolano.'],
                ['year' => '2015', 'title' => 'Primeiro Certificado', 'desc' => 'Obtenção do primeiro certificado de reconhecimento oficial como centro de formação profissional.'],
                ['year' => '2017', 'title' => 'Expansão para Viana', 'desc' => 'Abertura do segundo centro de formação no município de Viana, expandindo o alcance para mais comunidades.'],
                ['year' => '2019', 'title' => 'Inovação Digital', 'desc' => 'Implementação de plataformas digitais de ensino e formação híbrida.'],
                ['year' => '2021', 'title' => 'Parcerias Estratégicas', 'desc' => 'Estabelecimento de parcerias com empresas e instituições para certificações reconhecidas.'],
                ['year' => '2023', 'title' => 'Múltiplos Centros', 'desc' => 'Presença consolidada em várias províncias de Angola com centros modernos.'],
                ['year' => '2025', 'title' => 'Referência Nacional', 'desc' => 'Mais de 500 alunos formados e reconhecimento como centro de referência em Angola.'],
            ] as $i => $event)
                <div class="relative flex items-start mb-6 last:mb-0 reveal" style="transition-delay: {{ $i * 100 }}ms;">
                    <div class="absolute left-1/2 transform -translate-x-1/2 top-2 z-10">
                        <div class="w-4 h-4 rounded-full bg-brand-500 border-4 border-white shadow-md"></div>
                    </div>
                    @if($i % 2 === 0)
                        <div class="w-1/2 pr-12 text-right">
                            <span class="inline-block px-3 py-1 rounded-full bg-brand-50 text-brand-600 text-xs font-bold mb-2 border border-brand-200">{{ $event['year'] }}</span>
                            <h3 class="text-lg font-bold text-slate-900 mb-1 font-heading">{{ $event['title'] }}</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $event['desc'] }}</p>
                        </div>
                        <div class="w-1/2"></div>
                    @else
                        <div class="w-1/2"></div>
                        <div class="w-1/2 pl-12">
                            <span class="inline-block px-3 py-1 rounded-full bg-brand-50 text-brand-600 text-xs font-bold mb-2 border border-brand-200">{{ $event['year'] }}</span>
                            <h3 class="text-lg font-bold text-slate-900 mb-1 font-heading">{{ $event['title'] }}</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $event['desc'] }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- GALERIA — Nossos Momentos --}}
<section class="section bg-slate-50">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge-brand mb-4"><i data-lucide="camera" class="w-3 h-3"></i> Galeria</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4 font-heading">Nossos Momentos</h2>
            <p class="text-slate-500 max-w-lg mx-auto">Momentos especiais da nossa jornada de formação.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 reveal-stagger" style="grid-auto-rows: 180px;">
            @php
                $gallery = [
                    ['img' => asset('images/carousel-1.jpg'), 'title' => 'Formação em sala', 'span' => 'md:col-span-2 md:row-span-2'],
                    ['img' => asset('images/carousel-2.jpg'), 'title' => 'Atividades práticas', 'span' => ''],
                    ['img' => asset('images/carousel-4.jpg'), 'title' => 'Certificação', 'span' => ''],
                    ['img' => asset('images/about1.jpg'), 'title' => 'Nossa equipa', 'span' => 'md:row-span-2'],
                    ['img' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=400&q=60', 'title' => 'Aula de formação', 'span' => ''],
                    ['img' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=400&q=60', 'title' => 'Trabalho em equipa', 'span' => 'md:col-span-2'],
                    ['img' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=400&q=60', 'title' => 'Workshop', 'span' => ''],
                    ['img' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=400&q=60', 'title' => 'Colaboração', 'span' => ''],
                ];
            @endphp
            @foreach($gallery as $photo)
                <div class="relative rounded-2xl overflow-hidden group reveal cursor-pointer {{ $photo['span'] }}">
                    <img src="{{ $photo['img'] }}" alt="{{ $photo['title'] }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                        <span class="text-white text-sm font-semibold">{{ $photo['title'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PORQUE NÓS --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="{{ asset('images/fundo_imagem.jpg') }}" alt="Porquê">
    </div>
    <div class="container-wide">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="reveal-left">
                <span class="badge bg-white/20 text-white backdrop-blur-sm mb-5">Porquê a MC-COMERCIAL?</span>
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight mb-6 font-heading">Invista no seu futuro com confiança</h2>
                <p class="text-blue-100/60 leading-relaxed mb-8">Somos mais do que um centro de formação — somos um parceiro no seu crescimento profissional.</p>
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        ['icon' => 'award', 'value' => '500+', 'label' => 'Certificações emitidas'],
                        ['icon' => 'map-pin', 'value' => '5+', 'label' => 'Centros em Angola'],
                        ['icon' => 'users', 'value' => '20+', 'label' => 'Formadores qualificados'],
                        ['icon' => 'trending-up', 'value' => '95%', 'label' => 'Taxa de empregabilidade'],
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

{{-- TESTEMUNHOS --}}
<section class="section bg-slate-50">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge-brand mb-4"><i data-lucide="message-circle" class="w-3 h-3"></i> Testemunhos</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4 font-heading">O que Dizem os Nossos Alunos</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6 reveal-stagger">
            @foreach([
                ['name' => 'Maria João', 'role' => 'Formanda em Gestão', 'text' => 'A MC-COMERCIAL mudou a minha vida profissional. Os formadores são excepcionais e o ambiente de aprendizagem é motivador.', 'rating' => 5],
                ['name' => 'António Silva', 'role' => 'Formando em Informática', 'text' => 'Excelente formação prática. Depois do curso consegui imediatamente uma colocação no mercado de trabalho.', 'rating' => 5],
                ['name' => 'Rosa Mendes', 'role' => 'Formanda em Electricidade', 'text' => 'O material de apoio é completo e os formadores estão sempre disponíveis. Uma experiência formativa excelente.', 'rating' => 5],
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

{{-- CTA FINAL --}}
<section class="py-24 bg-gradient-to-br from-brand-700 via-brand-800 to-brand-950 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-5"></div>
    <div class="particles">
        <div class="particle w-3 h-3" style="top: 30%; left: 20%; animation-delay: 0s;"></div>
        <div class="particle w-2 h-2" style="top: 70%; left: 70%; animation-delay: 3s;"></div>
        <div class="particle w-4 h-4" style="top: 50%; left: 40%; animation-delay: 1.5s;"></div>
    </div>
    <div class="container-tight text-center relative z-10">
        <div class="reveal">
            <span class="badge bg-white/20 text-white backdrop-blur-sm mb-6"><i data-lucide="rocket" class="w-3 h-3"></i> Comece Agora</span>
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
