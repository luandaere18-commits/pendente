@extends('layouts.public')

@section('title', 'Centros de Formação — MC-COMERCIAL')

@section('content')

{{-- Header with Image --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="https://images.unsplash.com/photo-1560472355-536de3962603?auto=format&fit=crop&w=1600&q=80" alt="Centros">
    </div>
    <div class="container-wide">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4 reveal">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Centros</span>
        </nav>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4 font-heading reveal">Centros de Formação</h1>
        <p class="text-blue-100/60 max-w-lg reveal">Conheça os nossos centros, localizações e turmas disponíveis em cada um.</p>
    </div>
</section>

{{-- Grid + Map --}}
<section class="section">
    <div class="container-wide">
        <div class="grid lg:grid-cols-5 gap-8">
            {{-- Cards --}}
            <div class="lg:col-span-3">
                @if(isset($centros) && $centros->count())
                    <div class="grid sm:grid-cols-2 gap-6 reveal-stagger">
                        @foreach($centros as $centro)
                            <div id="centro-{{ $centro->id }}" class="card card-hover-detail overflow-hidden reveal group" style="height: 320px;">
                                {{-- Image --}}
                                <div class="absolute inset-0 img-overlay-zoom">
                                    @if($centro->imagem)
                                        <img src="{{ asset('storage/' . $centro->imagem) }}" alt="{{ $centro->nome }}"
                                             class="w-full h-full object-cover" loading="lazy">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1560472355-536de3962603?auto=format&fit=crop&w=500&q=60"
                                             alt="{{ $centro->nome }}" class="w-full h-full object-cover" loading="lazy">
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                                </div>

                                {{-- Basic (visible) --}}
                                <div class="absolute bottom-0 left-0 right-0 p-5 z-10 transition-opacity duration-300 group-hover:opacity-0">
                                    <h3 class="text-lg font-bold text-white font-heading">{{ $centro->nome }}</h3>
                                    @if($centro->localizacao)
                                        <p class="text-sm text-white/60 flex items-center gap-1 mt-1">
                                            <i data-lucide="map-pin" class="w-3 h-3"></i> {{ $centro->localizacao }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Hover Detail --}}
                                <div class="card-detail-overlay z-20">
                                    <div>
                                        <h3 class="text-lg font-bold text-white mb-3 font-heading">{{ $centro->nome }}</h3>
                                        <div class="space-y-2 text-sm">
                                            @if($centro->localizacao)
                                                <div class="flex items-center gap-2 text-blue-200">
                                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 shrink-0"></i>
                                                    <span>{{ $centro->localizacao }}</span>
                                                </div>
                                            @endif
                                            @if($centro->email)
                                                <div class="flex items-center gap-2 text-blue-200">
                                                    <i data-lucide="mail" class="w-3.5 h-3.5 shrink-0"></i>
                                                    <span>{{ $centro->email }}</span>
                                                </div>
                                            @endif
                                            @if($centro->contactos && is_array($centro->contactos))
                                                @foreach(array_slice($centro->contactos, 0, 2) as $contacto)
                                                    <div class="flex items-center gap-2 text-blue-200">
                                                        <i data-lucide="phone" class="w-3.5 h-3.5 shrink-0"></i>
                                                        <span>{{ $contacto }}</span>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if(isset($turmas))
                                                @php $count = $turmas->where('centro_id', $centro->id)->count(); @endphp
                                                @if($count > 0)
                                                    <div class="flex items-center gap-2 text-green-300">
                                                        <i data-lucide="graduation-cap" class="w-3.5 h-3.5 shrink-0"></i>
                                                        <span>{{ $count }} turma{{ $count > 1 ? 's' : '' }} activa{{ $count > 1 ? 's' : '' }}</span>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="flex gap-3 mt-4 pt-3 border-t border-white/15">
                                            <a href="{{ route('site.cursos') }}?centro={{ $centro->id }}"
                                               class="btn-primary btn-sm">
                                                <i data-lucide="filter" class="w-3 h-3"></i> Turmas
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 card p-10">
                        <div class="w-16 h-16 rounded-2xl bg-brand-100 flex items-center justify-center mx-auto mb-5">
                            <i data-lucide="building-2" class="w-7 h-7 text-brand-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Sem centros disponíveis</h3>
                        <p class="text-sm text-slate-500">Informação em breve.</p>
                    </div>
                @endif
            </div>

            {{-- Map --}}
            <div class="lg:col-span-2 reveal">
                <div class="card p-2 overflow-hidden sticky top-28">
                    <h3 class="text-sm font-bold text-slate-900 px-4 pt-3 pb-2 flex items-center gap-2 font-heading">
                        <i data-lucide="map" class="w-4 h-4 text-brand-600"></i>
                        Localização dos Centros
                    </h3>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125529.1950542!2d13.2!3d-8.84!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a51f15c36000001%3A0x3e34e0f5c6f7e7a8!2sLuanda%2C%20Angola!5e0!3m2!1spt-BR!2sao!4v1"
                        width="100%" height="500" style="border:0; border-radius: var(--radius-lg);"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        class="w-full"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
