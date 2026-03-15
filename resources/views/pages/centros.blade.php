@extends('layouts.public')

@section('title', 'Centros de Formação - MC-COMERCIAL')

@section('content')
<div class="py-12 bg-background min-h-screen">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h1 class="section-title">Centros de Formação</h1>
            <p class="section-subtitle">Conheça os nossos espaços de formação</p>
        </div>

        {{-- Mapa --}}
        <div class="rounded-xl overflow-hidden shadow-lg mb-12">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62587.26!2d13.35!3d-8.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwNTQnMDAuMCJTIDEzwrAyMScwMC4wIkU!5e0!3m2!1spt-PT!2sao!4v1700000000000"
                    width="100%" height="300" style="border:0;" allowfullscreen loading="lazy" title="Mapa dos Centros"></iframe>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($centros as $centro)
                @php
                    $turmasCentro = $turmas->where('centro_id', $centro->id);
                    $cursoIds = $turmasCentro->pluck('curso_id')->unique();
                    $cursosCentro = $cursos->whereIn('id', $cursoIds);
                @endphp
                <div class="feature-card">
                    <div class="w-14 h-14 rounded-xl bg-accent/10 flex items-center justify-center mb-4">
                        <i data-lucide="building-2" class="w-7 h-7 text-accent"></i>
                    </div>
                    <h3 class="text-xl font-bold text-foreground mb-3">{{ $centro->nome }}</h3>
                    <div class="space-y-2 mb-4">
                        <p class="text-sm text-muted-foreground flex items-start gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4 mt-0.5 shrink-0"></i>{{ $centro->localizacao }}
                        </p>
                        @foreach($centro->contactos as $tel)
                            <a href="tel:{{ $tel }}" class="text-sm text-accent flex items-center gap-2 hover:underline">
                                <i data-lucide="phone" class="w-4 h-4"></i>{{ $tel }}
                            </a>
                        @endforeach
                        <a href="mailto:{{ $centro->email }}" class="text-sm text-accent flex items-center gap-2 hover:underline">
                            <i data-lucide="mail" class="w-4 h-4"></i>{{ $centro->email }}
                        </a>
                    </div>
                    @if($cursosCentro->count() > 0)
                        <div class="mb-4">
                            <p class="text-xs font-semibold text-foreground mb-2">Cursos neste centro:</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($cursosCentro as $curso)
                                    <span class="badge-area text-xs">{{ $curso->nome }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <p class="text-xs text-muted-foreground mb-4">🕒 Seg-Sex: 8h-18h | Sáb: 9h-16h</p>
                    <a href="{{ route('site.cursos') }}" class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium border border-input bg-background h-9 px-4 hover:bg-accent hover:text-accent-foreground transition-colors">
                        Ver Turmas <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
