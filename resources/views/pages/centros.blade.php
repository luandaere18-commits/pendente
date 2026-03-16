@extends('layouts.public')

@section('title', 'Centros de Formação - MC-COMERCIAL')

@section('content')

{{-- Page Hero --}}
<div class="page-hero text-center">
    <div class="container mx-auto px-4 relative z-10">
        <span class="section-tag text-accent-foreground/80 justify-center before:bg-white/40">
            <i data-lucide="building-2" class="w-3.5 h-3.5"></i> Nossa Rede
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-5" style="letter-spacing: -0.03em;">Centros de Formação</h1>
        <p class="text-lg text-white/65 max-w-2xl mx-auto">
            Conheça os nossos espaços modernos —
            <span class="font-bold text-white">{{ $centros->count() }} centro{{ $centros->count() !== 1 ? 's' : '' }}</span> disponíve{{ $centros->count() !== 1 ? 'is' : 'l' }}
        </p>
    </div>
</div>

<div class="py-16 bg-background min-h-screen">
    <div class="container mx-auto px-4">

        {{-- Mapa --}}
        <div class="rounded-2xl overflow-hidden mb-16 reveal" style="box-shadow: var(--shadow-lg);">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62587.26!2d13.35!3d-8.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwNTQnMDAuMCJTIDEzwrAyMScwMC4wIkU!5e0!3m2!1spt-PT!2sao!4v1700000000000"
                    width="100%" height="350" style="border:0;" allowfullscreen loading="lazy" title="Mapa dos Centros"></iframe>
        </div>

        {{-- Grid de Centros --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
            @foreach($centros as $centro)
                @php
                    $turmasCentro = $turmas->where('centro_id', $centro->id);
                    $cursoIds     = $turmasCentro->pluck('curso_id')->unique();
                    $cursosCentro = $cursos->whereIn('id', $cursoIds);
                    $vagasTotal   = $turmasCentro->sum('vagas_totais');
                    $vagasLivres  = $vagasTotal - $turmasCentro->sum('vagas_preenchidas');
                @endphp
                <div class="feature-card group reveal">
                    {{-- Header --}}
                    <div class="flex items-start gap-4 mb-5">
                        <div class="icon-box icon-box-lg bg-accent/10 group-hover:bg-accent transition-all duration-400 group-hover:scale-110 group-hover:rotate-3">
                            <i data-lucide="building-2" class="w-7 h-7 text-accent group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-extrabold text-foreground group-hover:text-accent transition-colors duration-300 truncate">{{ $centro->nome }}</h3>
                            <p class="text-xs text-muted-foreground mt-0.5">Centro de Formação Profissional</p>
                        </div>
                    </div>

                    {{-- Contacto --}}
                    <div class="space-y-3 mb-5">
                        <div class="flex items-start gap-2.5 text-sm text-muted-foreground">
                            <i data-lucide="map-pin" class="w-4 h-4 mt-0.5 shrink-0 text-accent"></i>
                            <span>{{ $centro->localizacao }}</span>
                        </div>
                        @foreach($centro->contactos as $tel)
                            <a href="tel:{{ $tel }}" class="flex items-center gap-2.5 text-sm text-accent hover:underline hover:translate-x-1 transition-all duration-300">
                                <i data-lucide="phone" class="w-4 h-4 shrink-0"></i>{{ $tel }}
                            </a>
                        @endforeach
                        <a href="mailto:{{ $centro->email }}" class="flex items-center gap-2.5 text-sm text-accent hover:underline hover:translate-x-1 transition-all duration-300">
                            <i data-lucide="mail" class="w-4 h-4 shrink-0"></i>{{ $centro->email }}
                        </a>
                    </div>

                    {{-- Horário --}}
                    <div class="flex items-center gap-2 text-xs text-muted-foreground bg-muted/50 rounded-xl px-3 py-2.5 mb-5">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-accent"></i>
                        <span>Seg-Sex: 8h-18h &nbsp;|&nbsp; Sáb: 9h-16h</span>
                    </div>

                    {{-- Cursos --}}
                    @if($cursosCentro->count() > 0)
                        <div class="mb-5">
                            <div class="flex items-center justify-between mb-2.5">
                                <p class="text-xs font-bold text-foreground">Cursos neste centro:</p>
                                <span class="text-xs text-accent font-bold tabular-nums">{{ $cursosCentro->count() }}</span>
                            </div>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($cursosCentro->take(4) as $curso)
                                    <span class="badge-area text-xs">{{ $curso->nome }}</span>
                                @endforeach
                                @if($cursosCentro->count() > 4)
                                    <span class="badge text-xs bg-muted text-muted-foreground">
                                        +{{ $cursosCentro->count() - 4 }} mais
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Stats --}}
                    <div class="flex items-center gap-4 mb-5 py-3 border-t border-border text-sm">
                        <div class="text-center flex-1">
                            <div class="font-extrabold text-foreground text-lg tabular-nums">{{ $turmasCentro->count() }}</div>
                            <div class="text-xs text-muted-foreground">Turmas</div>
                        </div>
                        <div class="h-8 w-px bg-border"></div>
                        <div class="text-center flex-1">
                            <div class="font-extrabold text-foreground text-lg tabular-nums">{{ $cursosCentro->count() }}</div>
                            <div class="text-xs text-muted-foreground">Cursos</div>
                        </div>
                        <div class="h-8 w-px bg-border"></div>
                        <div class="text-center flex-1">
                            <div class="font-extrabold text-success text-lg tabular-nums">{{ $vagasLivres }}</div>
                            <div class="text-xs text-muted-foreground">Vagas livres</div>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <a href="{{ route('site.cursos') }}?centro={{ $centro->id }}"
                       class="btn-primary w-full h-11 text-sm rounded-xl">
                        <i data-lucide="calendar-check" class="w-4 h-4"></i>
                        Ver Turmas deste Centro
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
