@extends('layouts.public')

@section('title', 'Centros de Formação — MC-COMERCIAL')

@section('content')

{{-- Header com fundo_imagem.jpg + squares pattern --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="{{ asset('images/fundo_imagem.jpg') }}" alt="Centros">
    </div>
    <div class="container-wide">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4 reveal">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Centros</span>
        </nav>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4 font-heading reveal">Centros de Formação</h1>
        <p class="text-blue-100/60 max-w-lg reveal">Conheça os nossos centros espalhados por Angola.</p>
    </div>
</section>

{{-- Grid + Map --}}
<section class="section">
    <div class="container-wide">
        <div class="grid lg:grid-cols-5 gap-8">
            <div class="lg:col-span-3">
                @if(isset($centros) && $centros->count())
                    <div class="grid sm:grid-cols-2 gap-6 reveal-stagger">
                        @foreach($centros as $centro)
                            <div id="centro-{{ $centro->id }}" class="course-card reveal group">
                                {{-- Imagem --}}
                                <div class="course-card-img">
                                    @if($centro->imagem)
                                        <img src="{{ asset('storage/' . $centro->imagem) }}" alt="{{ $centro->nome }}" loading="lazy">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1560472355-536de3962603?auto=format&fit=crop&w=500&q=60"
                                             alt="{{ $centro->nome }}" loading="lazy">
                                    @endif
                                    @if(isset($turmas))
                                        @php $count = $turmas->where('centro_id', $centro->id)->count(); @endphp
                                        @if($count > 0)
                                            <span class="course-card-badge active">
                                                <i data-lucide="bar-chart-3" class="w-3 h-3"></i>
                                                {{ $count }} turma{{ $count > 1 ? 's' : '' }}
                                            </span>
                                        @endif
                                    @endif
                                </div>

                                {{-- Body --}}
                                <div class="course-card-body">
                                    <h3 class="course-card-title">{{ $centro->nome }}</h3>

                                    <div class="course-card-meta">
                                        @if($centro->localizacao)
                                            <span class="course-card-meta-item">
                                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-brand-500"></i>
                                                {{ $centro->localizacao }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($centro->email)
                                        <p class="text-xs text-slate-400 flex items-center gap-1 mb-1">
                                            <i data-lucide="mail" class="w-3 h-3"></i> {{ $centro->email }}
                                        </p>
                                    @endif
                                    @if($centro->contactos && is_array($centro->contactos))
                                        @foreach(array_slice($centro->contactos, 0, 1) as $contacto)
                                            <p class="text-xs text-slate-400 flex items-center gap-1 mb-2">
                                                <i data-lucide="phone" class="w-3 h-3"></i> {{ $contacto }}
                                            </p>
                                        @endforeach
                                    @endif

                                    <div class="course-card-footer">
                                        <a href="{{ route('site.cursos') }}?centro={{ $centro->id }}"
                                           class="text-xs text-brand-600 font-semibold hover:text-brand-800 flex items-center gap-1 transition-colors">
                                            Ver Turmas <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                        </a>
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

            <div class="lg:col-span-2 reveal">
                <div class="card p-2 overflow-hidden sticky top-28">
                    <h3 class="text-sm font-bold text-slate-900 px-4 pt-3 pb-2 flex items-center gap-2 font-heading">
                        <i data-lucide="map" class="w-4 h-4 text-brand-600"></i>
                        Localização dos Centros
                    </h3>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125529.1950542!2d13.2!3d-8.84!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a51f15c36000001%3A0x3e34e0f5c6f7e7a8!2sLuanda%2C%20Angola!5e0!3m2!1spt-BR!2sao!4v1"
                            width="100%" height="500" style="border:0; border-radius: var(--radius-lg);"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            class="w-full"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
