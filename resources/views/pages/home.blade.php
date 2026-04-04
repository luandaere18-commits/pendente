@extends('layouts.public')

@section('title', 'MC-COMERCIAL — Centro de Formação Profissional')

@section('content')

{{-- ═══════════════════════════════════════
     HERO — Full-Width Carousel with Overlay
     ═══════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-brand-950 text-white -mt-20 pt-20"
         x-data="{
             current: 0,
             slides: [
                 { img: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1600&q=80', title: 'Construa o seu futuro profissional', sub: 'Mais de 10 anos de experiência na preparação de profissionais qualificados.' },
                 { img: 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80', title: 'Formação de Excelência', sub: 'Cursos certificados com formadores experientes e material de qualidade.' },
                 { img: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1600&q=80', title: 'Certificados Reconhecidos', sub: 'Certificações válidas e reconhecidas pelo mercado de trabalho angolano.' },
                 { img: 'https://images.unsplash.com/photo-1560472355-536de3962603?auto=format&fit=crop&w=1600&q=80', title: 'Infraestrutura Moderna', sub: 'Centros de formação equipados com tecnologia de ponta.' }
             ],
             autoplay: null,
             init() {
                 this.autoplay = setInterval(() => { this.current = (this.current + 1) % this.slides.length; }, 5000);
             },
             goto(i) { this.current = i; clearInterval(this.autoplay); this.autoplay = setInterval(() => { this.current = (this.current + 1) % this.slides.length; }, 5000); },
             next() { this.goto((this.current + 1) % this.slides.length); },
             prev() { this.goto((this.current - 1 + this.slides.length) % this.slides.length); }
         }">

    {{-- Slides --}}
    <div class="relative min-h-[85vh]">
        <template x-for="(slide, i) in slides" :key="i">
            <div class="absolute inset-0 transition-opacity duration-700"
                 :class="current === i ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <img :src="slide.img" :alt="slide.title" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-brand-950/90 via-brand-950/60 to-brand-950/30"></div>
            </div>
        </template>

        {{-- Content --}}
        <div class="container-wide relative z-20 flex items-center min-h-[85vh]">
            <div class="max-w-2xl py-20">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/15 backdrop-blur-sm mb-8 animate-fade-up">
                    <span class="w-2 h-2 bg-brand-400 rounded-full animate-pulse"></span>
                    <span class="text-xs font-semibold text-brand-200 uppercase tracking-wider">Formação Profissional em Angola</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-[1.05] tracking-tight mb-6"
                    x-text="slides[current].title"
                    style="animation: fade-up 0.6s ease forwards;">
                </h1>

                <p class="text-lg text-blue-100/80 leading-relaxed mb-10 max-w-lg"
                   x-text="slides[current].sub"
                   style="animation: fade-up 0.6s ease forwards; animation-delay: 100ms;">
                </p>

                <div class="flex flex-wrap gap-4" style="animation: fade-up 0.6s ease forwards; animation-delay: 200ms;">
                    <a href="{{ route('site.cursos') }}" class="btn-primary btn-lg">
                        <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                        Explorar Cursos
                    </a>
                    <a href="{{ route('site.sobre') }}" class="btn-outline-white btn-lg">
                        <i data-lucide="play-circle" class="w-5 h-5"></i>
                        Saber Mais
                    </a>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-6 mt-14 pt-8 border-t border-white/15" style="animation: fade-up 0.6s ease forwards; animation-delay: 300ms;">
                    @foreach([
                        ['500+', 'Alunos Formados'],
                        [isset($cursos) ? $cursos->count() : '20+', 'Cursos Disponíveis'],
                        [isset($centros) ? $centros->count() : '5+', 'Centros de Formação']
                    ] as [$val, $label])
                        <div>
                            <span class="text-2xl sm:text-3xl font-black text-white">{{ $val }}</span>
                            <span class="block text-xs text-blue-200/60 mt-1">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Carousel Controls --}}
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm flex items-center justify-center text-white transition-all duration-200 hover:scale-110 border border-white/10">
            <i data-lucide="chevron-left" class="w-5 h-5"></i>
        </button>
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm flex items-center justify-center text-white transition-all duration-200 hover:scale-110 border border-white/10">
            <i data-lucide="chevron-right" class="w-5 h-5"></i>
        </button>

        {{-- Dots --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-30 flex gap-2">
            <template x-for="(_, i) in slides" :key="'dot-'+i">
                <button @click="goto(i)" class="h-2.5 rounded-full transition-all duration-300"
                        :class="current === i ? 'w-8 bg-brand-400' : 'w-2.5 bg-white/30 hover:bg-white/50'"></button>
            </template>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     FEATURES STRIP
     ═══════════════════════════════════════ --}}
<section class="py-6 bg-white border-b border-slate-100 relative -mt-1">
    <div class="container-wide">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                ['icon' => 'award',          'title' => 'Certificação Oficial', 'desc' => 'Certificados reconhecidos'],
                ['icon' => 'users',          'title' => 'Formadores Experientes', 'desc' => 'Profissionais qualificados'],
                ['icon' => 'book-open',      'title' => 'Material Incluído',    'desc' => 'Apostilas e recursos'],
                ['icon' => 'briefcase',      'title' => 'Empregabilidade',      'desc' => 'Apoio na colocação'],
            ] as $feat)
                <div class="flex items-center gap-3 p-4 rounded-xl hover:bg-brand-50/50 transition-colors duration-200 reveal">
                    <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center shrink-0">
                        <i data-lucide="{{ $feat['icon'] }}" class="w-5 h-5 text-brand-600"></i>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-slate-900 block">{{ $feat['title'] }}</span>
                        <span class="text-xs text-slate-500">{{ $feat['desc'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     FEATURED COURSES — Rich Cards with Carousel
     ═══════════════════════════════════════ --}}
@if(isset($turmas) && $turmas->count())
<section class="section bg-slate-50/50">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge-brand mb-4">
                <i data-lucide="sparkles" class="w-3 h-3"></i>
                Turmas Disponíveis
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4">Próximas Turmas</h2>
            <p class="text-slate-500 max-w-lg mx-auto">Encontre a turma ideal e comece a sua jornada de formação profissional.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
            @foreach($turmas->take(6) as $turma)
                <div class="card card-interactive p-0 overflow-hidden reveal group">
                    {{-- Card Image --}}
                    <div class="relative h-48 bg-gradient-to-br from-brand-600 to-brand-800 overflow-hidden img-overlay-zoom">
                        @if($turma->curso->imagem ?? false)
                            <img src="{{ asset('storage/' . $turma->curso->imagem) }}" alt="{{ $turma->curso->nome ?? '' }}"
                                 class="w-full h-full object-cover" loading="lazy">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i data-lucide="graduation-cap" class="w-16 h-16 text-white/20"></i>
                            </div>
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=60"
                                 alt="{{ $turma->curso->nome ?? 'Curso' }}" class="w-full h-full object-cover opacity-60" loading="lazy">
                        @endif
                        {{-- Status Badge --}}
                        <div class="absolute top-3 left-3 z-10">
                            <span class="badge-brand backdrop-blur-sm bg-white/90 text-brand-700">
                                {{ $turma->curso->area ?? 'Formação' }}
                            </span>
                        </div>
                        @if($turma->data_arranque)
                            <div class="absolute top-3 right-3 z-10">
                                <span class="badge bg-brand-600 text-white text-[10px]">
                                    <i data-lucide="calendar" class="w-3 h-3"></i>
                                    {{ \Carbon\Carbon::parse($turma->data_arranque)->format('d M Y') }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Card Body --}}
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-brand-600 transition-colors line-clamp-1">
                            {{ $turma->curso->nome ?? 'Curso' }}
                        </h3>

                        <p class="text-sm text-slate-500 line-clamp-2 mb-4">
                            {{ $turma->curso->descricao ?? 'Formação profissional de qualidade.' }}
                        </p>

                        {{-- Details Grid --}}
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            @if($turma->centro)
                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-brand-500"></i>
                                    <span class="truncate">{{ $turma->centro->nome }}</span>
                                </div>
                            @endif
                            @if($turma->horario)
                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <i data-lucide="clock" class="w-3.5 h-3.5 text-brand-500"></i>
                                    {{ $turma->horario }}
                                </div>
                            @endif
                            @if($turma->duracao)
                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <i data-lucide="timer" class="w-3.5 h-3.5 text-brand-500"></i>
                                    {{ $turma->duracao }}
                                </div>
                            @endif
                            @if($turma->formador)
                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <i data-lucide="user" class="w-3.5 h-3.5 text-brand-500"></i>
                                    <span class="truncate">{{ $turma->formador->nome }}</span>
                                </div>
                            @endif
                            @if($turma->periodo)
                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <i data-lucide="sun" class="w-3.5 h-3.5 text-brand-500"></i>
                                    {{ $turma->periodo }}
                                </div>
                            @endif
                            @if($turma->vagas)
                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <i data-lucide="users" class="w-3.5 h-3.5 text-brand-500"></i>
                                    {{ $turma->vagas }} vagas
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div class="px-5 py-4 bg-brand-50/30 border-t border-brand-100/50 flex items-center justify-between">
                        <div>
                            @if($turma->preco)
                                <span class="text-xl font-black text-brand-700">
                                    {{ number_format($turma->preco, 0, ',', '.') }} <span class="text-sm font-semibold">Kz</span>
                                </span>
                            @else
                                <span class="text-sm text-slate-400 italic">Consultar preço</span>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('site.curso', $turma->curso->id ?? $turma->id) }}"
                               class="btn-secondary btn-sm">
                                <i data-lucide="eye" class="w-3 h-3"></i>
                                Ver Detalhes
                            </a>
                            <button @click="$dispatch('open-pre-inscricao', { turmaId: {{ $turma->id }}, turmaNome: '{{ addslashes($turma->curso->nome ?? '') }}' })"
                                    class="btn-primary btn-sm">
                                Inscrever-se
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($turmas->count() > 6)
            <div class="text-center mt-12 reveal">
                <a href="{{ route('site.cursos') }}" class="btn-primary btn-lg">
                    Ver Todas as Turmas
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        @endif
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════
     WHY CHOOSE US — With Images
     ═══════════════════════════════════════ --}}
<section class="section bg-white">
    <div class="container-wide">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="reveal">
                <span class="badge-brand mb-5">
                    <i data-lucide="star" class="w-3 h-3"></i>
                    Porquê Escolher-nos
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-6">Formação que transforma carreiras</h2>
                <p class="text-slate-500 leading-relaxed mb-8">A MC-COMERCIAL distingue-se pela qualidade da formação, infraestruturas modernas e resultados comprovados no mercado de trabalho angolano.</p>

                <div class="space-y-4">
                    @foreach([
                        ['icon' => 'check-circle-2', 'title' => 'Formadores certificados e experientes', 'color' => 'text-emerald-500'],
                        ['icon' => 'check-circle-2', 'title' => 'Material didático incluído em todos os cursos', 'color' => 'text-emerald-500'],
                        ['icon' => 'check-circle-2', 'title' => 'Aulas práticas em laboratórios equipados', 'color' => 'text-emerald-500'],
                        ['icon' => 'check-circle-2', 'title' => 'Certificados reconhecidos pelo mercado', 'color' => 'text-emerald-500'],
                        ['icon' => 'check-circle-2', 'title' => 'Horários flexíveis: manhã, tarde e noite', 'color' => 'text-emerald-500'],
                    ] as $item)
                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-brand-50/50 transition-colors">
                            <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 {{ $item['color'] }} shrink-0"></i>
                            <span class="text-sm font-medium text-slate-700">{{ $item['title'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="reveal relative">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=70"
                         alt="Alunos em formação" class="rounded-2xl shadow-lg w-full aspect-[3/4] object-cover" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=600&q=70"
                         alt="Formação prática" class="rounded-2xl shadow-lg w-full aspect-[3/4] object-cover mt-8" loading="lazy">
                </div>
                <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-5 shadow-xl animate-float border border-brand-100">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-brand-100 flex items-center justify-center">
                            <i data-lucide="trending-up" class="w-5 h-5 text-brand-600"></i>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-slate-900 block">95%</span>
                            <span class="text-xs text-slate-500">Taxa de Sucesso</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     CENTRES — Cards + Map
     ═══════════════════════════════════════ --}}
@if(isset($centros) && $centros->count())
<section class="section bg-brand-50/30">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge-brand mb-4">
                <i data-lucide="map-pin" class="w-3 h-3"></i>
                Nossos Centros
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4">Centros de Formação</h2>
            <p class="text-slate-500">Conheça os nossos centros espalhados por Angola.</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-8 items-start">
            {{-- Centre Cards --}}
            <div class="space-y-4 reveal-stagger">
                @foreach($centros->take(4) as $centro)
                    <a href="{{ route('site.centro', $centro->id) }}" class="card card-interactive p-5 flex items-start gap-4 reveal group">
                        <div class="w-14 h-14 rounded-2xl bg-brand-100 flex items-center justify-center shrink-0
                                    group-hover:bg-brand-600 group-hover:scale-110 transition-all duration-300">
                            <i data-lucide="building-2" class="w-6 h-6 text-brand-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-bold text-slate-900 mb-1 group-hover:text-brand-600 transition-colors">
                                {{ $centro->nome }}
                            </h3>
                            @if($centro->endereco)
                                <p class="text-sm text-slate-500 flex items-start gap-1.5 mb-1">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 mt-0.5 shrink-0"></i>
                                    <span class="line-clamp-1">{{ $centro->endereco }}</span>
                                </p>
                            @endif
                            <div class="flex items-center gap-4 mt-2">
                                @if($centro->telefone)
                                    <span class="text-xs text-slate-400 flex items-center gap-1">
                                        <i data-lucide="phone" class="w-3 h-3"></i> {{ $centro->telefone }}
                                    </span>
                                @endif
                                @if(isset($turmas))
                                    @php $count = $turmas->where('centro_id', $centro->id)->count(); @endphp
                                    @if($count > 0)
                                        <span class="badge-success text-[10px]">{{ $count }} turma{{ $count > 1 ? 's' : '' }}</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <i data-lucide="chevron-right" class="w-5 h-5 text-slate-300 group-hover:text-brand-500 group-hover:translate-x-1 transition-all shrink-0 mt-1"></i>
                    </a>
                @endforeach

                @if($centros->count() > 4)
                    <div class="text-center pt-2">
                        <a href="{{ route('site.centros') }}" class="btn-secondary btn-sm">Ver todos os centros</a>
                    </div>
                @endif
            </div>

            {{-- Map --}}
            <div class="reveal">
                <div class="card p-2 overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125529.1950542!2d13.2!3d-8.84!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a51f15c36000001%3A0x3e34e0f5c6f7e7a8!2sLuanda%2C%20Angola!5e0!3m2!1spt-BR!2sao!4v1"
                        width="100%" height="420" style="border:0; border-radius: var(--radius-lg);"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        class="w-full"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════
     TESTIMONIALS / CTA
     ═══════════════════════════════════════ --}}
<section class="section bg-gradient-to-br from-brand-700 via-brand-800 to-brand-950 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-5"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-400/10 rounded-full blur-[140px]"></div>

    <div class="container-tight relative text-center">
        <div class="reveal">
            <span class="badge bg-white/10 text-white border border-white/10 mb-6">
                <i data-lucide="heart" class="w-3 h-3"></i>
                Junte-se a Nós
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold tracking-tight mb-6">Pronto para transformar a sua carreira?</h2>
            <p class="text-blue-100/70 text-lg mb-10 max-w-xl mx-auto">
                Inscreva-se numa das nossas turmas e dê o primeiro passo rumo ao sucesso profissional.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('site.cursos') }}" class="btn bg-white text-brand-700 hover:bg-brand-50 btn-lg shadow-lg hover:shadow-xl transition-all">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                    Ver Cursos
                </a>
                <a href="{{ route('site.contactos') }}" class="btn-outline-white btn-lg">
                    <i data-lucide="phone" class="w-5 h-5"></i>
                    Falar Connosco
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════
     GALLERY
     ═══════════════════════════════════════ --}}
<section class="section bg-white">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge-brand mb-4">
                <i data-lucide="camera" class="w-3 h-3"></i>
                Galeria
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4">Momentos na MC-COMERCIAL</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 reveal-stagger">
            @php
                $galleryImages = [
                    'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=500&q=60',
                    'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=500&q=60',
                    'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=500&q=60',
                    'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=500&q=60',
                    'https://images.unsplash.com/photo-1560472355-536de3962603?auto=format&fit=crop&w=500&q=60',
                    'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=500&q=60',
                    'https://images.unsplash.com/photo-1573164574511-73c773193279?auto=format&fit=crop&w=500&q=60',
                    'https://images.unsplash.com/photo-1606761568499-6d2451b23c66?auto=format&fit=crop&w=500&q=60',
                ];
            @endphp
            @foreach($galleryImages as $i => $img)
                <div class="reveal img-overlay-zoom rounded-xl {{ $i === 0 || $i === 5 ? 'md:col-span-2 md:row-span-2' : '' }}">
                    <img src="{{ $img }}" alt="MC-COMERCIAL Galeria"
                         class="w-full h-full object-cover rounded-xl {{ $i === 0 || $i === 5 ? 'aspect-square' : 'aspect-video' }}"
                         loading="lazy">
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
