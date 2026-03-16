@extends('layouts.public')

@section('title', 'Centros de Formação - MC-COMERCIAL')

@section('content')

{{-- Page Hero — gradiente azul moderno --}}
<div class="page-hero">
    <div class="container mx-auto px-4 text-center text-primary-foreground">
        <h1 class="text-4xl lg:text-5xl font-extrabold mb-4">Centros de Formação</h1>
        <p class="text-lg opacity-80 max-w-2xl mx-auto">
            Conheça os nossos espaços modernos —
            <span class="font-bold">{{ $centros->count() }} centro{{ $centros->count() !== 1 ? 's' : '' }}</span> disponíve{{ $centros->count() !== 1 ? 'is' : 'l' }}
        </p>
    </div>
</div>

<div class="py-14 bg-background min-h-screen">
    <div class="container mx-auto px-4">

        {{-- Mapa --}}
        <div class="rounded-2xl overflow-hidden shadow-xl mb-14 border border-border reveal-scale">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62587.26!2d13.35!3d-8.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwNTQnMDAuMCJTIDEzwrAyMScwMC4wIkU!5e0!3m2!1spt-PT!2sao!4v1700000000000"
                    width="100%" height="320" style="border:0;" allowfullscreen loading="lazy" title="Mapa dos Centros"></iframe>
        </div>

        {{-- Grid de Centros --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($centros as $centro)
                @php
                    $turmasCentro = $turmas->where('centro_id', $centro->id);
                    $cursoIds     = $turmasCentro->pluck('curso_id')->unique();
                    $cursosCentro = $cursos->whereIn('id', $cursoIds);
                    $vagasTotal   = $turmasCentro->sum('vagas_totais');
                    $vagasLivres  = $vagasTotal - $turmasCentro->sum('vagas_preenchidas');
                @endphp
                <div class="feature-card group reveal hover-shine">
                    <div class="flex items-start gap-4 mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-accent/10 group-hover:bg-accent flex items-center justify-center shrink-0 transition-all duration-300 group-hover:scale-110">
                            <i data-lucide="building-2" class="w-7 h-7 text-accent group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-foreground group-hover:text-accent transition-colors truncate">{{ $centro->nome }}</h3>
                            <p class="text-xs text-muted-foreground mt-0.5">Centro de Formação Profissional</p>
                        </div>
                    </div>

                    <div class="space-y-2.5 mb-5">
                        <div class="flex items-start gap-2.5 text-sm text-muted-foreground">
                            <i data-lucide="map-pin" class="w-4 h-4 mt-0.5 shrink-0 text-accent"></i>
                            <span>{{ $centro->localizacao }}</span>
                        </div>
                        @if(is_array($centro->contactos))
                            @foreach($centro->contactos as $tel)
                                <a href="tel:{{ $tel }}" class="flex items-center gap-2.5 text-sm text-accent hover:underline hover:translate-x-1 transition-all duration-200">
                                    <i data-lucide="phone" class="w-4 h-4 shrink-0"></i>{{ $tel }}
                                </a>
                            @endforeach
                        @endif
                        @if($centro->email)
                            <a href="mailto:{{ $centro->email }}" class="flex items-center gap-2.5 text-sm text-accent hover:underline hover:translate-x-1 transition-all duration-200">
                                <i data-lucide="mail" class="w-4 h-4 shrink-0"></i>{{ $centro->email }}
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 text-xs text-muted-foreground bg-muted/50 rounded-lg px-3 py-2 mb-5">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-accent"></i>
                        <span>Seg-Sex: 8h-18h &nbsp;|&nbsp; Sáb: 9h-16h</span>
                    </div>

                    @if($cursosCentro->count() > 0)
                        <div class="mb-5">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-semibold text-foreground">Cursos neste centro:</p>
                                <span class="text-xs text-accent font-bold">{{ $cursosCentro->count() }}</span>
                            </div>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($cursosCentro->take(4) as $curso)
                                    <span class="badge-area text-xs">{{ $curso->nome }}</span>
                                @endforeach
                                @if($cursosCentro->count() > 4)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-muted text-muted-foreground">
                                        +{{ $cursosCentro->count() - 4 }} mais
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center gap-4 mb-5 py-3 border-t border-border text-sm">
                        <div class="text-center flex-1">
                            <div class="font-bold text-foreground text-lg">{{ $turmasCentro->count() }}</div>
                            <div class="text-xs text-muted-foreground">Turmas</div>
                        </div>
                        <div class="h-8 w-px bg-border"></div>
                        <div class="text-center flex-1">
                            <div class="font-bold text-foreground text-lg">{{ $cursosCentro->count() }}</div>
                            <div class="text-xs text-muted-foreground">Cursos</div>
                        </div>
                        <div class="h-8 w-px bg-border"></div>
                        <div class="text-center flex-1">
                            <div class="font-bold text-success text-lg">{{ $vagasLivres }}</div>
                            <div class="text-xs text-muted-foreground">Vagas livres</div>
                        </div>
                    </div>

                    <a href="{{ route('site.cursos') }}?centro={{ $centro->id }}"
                       class="w-full inline-flex items-center justify-center gap-2 rounded-xl text-sm font-semibold bg-primary text-primary-foreground h-10 px-4 hover:bg-primary/90 active:scale-95 transition-all duration-200">
                        <i data-lucide="calendar-check" class="w-4 h-4"></i>
                        Ver Turmas deste Centro
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
