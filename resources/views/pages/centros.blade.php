@extends('layouts.public')

@section('title', 'Centros de Formação — MC-COMERCIAL')

@section('content')

{{-- Header --}}
<section class="relative pt-12 pb-16 bg-gradient-to-br from-brand-700 to-brand-900 text-white -mt-20 pt-32 overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-5"></div>
    <div class="container-wide relative">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Centros</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3">Centros de Formação</h1>
        <p class="text-blue-100/70">Conheça os nossos centros espalhados por Angola.</p>
    </div>
</section>

{{-- Grid + Map --}}
<section class="section-tight">
    <div class="container-wide">
        <div class="grid lg:grid-cols-5 gap-8">
            {{-- Cards --}}
            <div class="lg:col-span-3">
                @if(isset($centros) && $centros->count())
                    <div class="grid sm:grid-cols-2 gap-5 reveal-stagger">
                        @foreach($centros as $centro)
                            <a href="{{ route('site.centro', $centro->id) }}"
                               class="card card-interactive p-0 overflow-hidden reveal group">
                                {{-- Image --}}
                                <div class="h-36 bg-gradient-to-br from-brand-500 to-brand-700 overflow-hidden img-overlay-zoom relative">
                                    @if($centro->imagem)
                                        <img src="{{ asset('storage/' . $centro->imagem) }}" alt="{{ $centro->nome }}"
                                             class="w-full h-full object-cover" loading="lazy">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1560472355-536de3962603?auto=format&fit=crop&w=500&q=60"
                                             alt="{{ $centro->nome }}" class="w-full h-full object-cover opacity-40" loading="lazy">
                                    @endif
                                    <div class="absolute bottom-3 left-3 z-10">
                                        <div class="w-10 h-10 rounded-xl bg-white/90 backdrop-blur-sm flex items-center justify-center shadow-sm">
                                            <i data-lucide="building-2" class="w-5 h-5 text-brand-600"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-5">
                                    <h3 class="text-base font-bold text-slate-900 mb-2 group-hover:text-brand-600 transition-colors">
                                        {{ $centro->nome }}
                                    </h3>
                                    @if($centro->endereco)
                                        <p class="text-sm text-slate-500 flex items-start gap-1.5 mb-2">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 mt-0.5 shrink-0 text-brand-400"></i>
                                            <span class="line-clamp-2">{{ $centro->endereco }}</span>
                                        </p>
                                    @endif
                                    <div class="flex flex-wrap gap-3 mt-3">
                                        @if($centro->telefone)
                                            <span class="text-xs text-slate-400 flex items-center gap-1">
                                                <i data-lucide="phone" class="w-3 h-3"></i> {{ $centro->telefone }}
                                            </span>
                                        @endif
                                        @if($centro->email)
                                            <span class="text-xs text-slate-400 flex items-center gap-1">
                                                <i data-lucide="mail" class="w-3 h-3"></i> {{ $centro->email }}
                                            </span>
                                        @endif
                                    </div>
                                    @if(isset($turmas))
                                        @php $count = $turmas->where('centro_id', $centro->id)->count(); @endphp
                                        @if($count > 0)
                                            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between">
                                                <span class="badge-success text-[10px]">
                                                    <i data-lucide="graduation-cap" class="w-3 h-3"></i>
                                                    {{ $count }} turma{{ $count > 1 ? 's' : '' }}
                                                </span>
                                                <span class="text-xs text-brand-600 font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                                    Ver detalhes <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 card p-10">
                        <div class="w-16 h-16 rounded-2xl bg-brand-100 flex items-center justify-center mx-auto mb-5">
                            <i data-lucide="building-2" class="w-7 h-7 text-brand-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Sem centros disponíveis</h3>
                        <p class="text-sm text-slate-500">Informação em breve.</p>
                    </div>
                @endif
            </div>

            {{-- Map --}}
            <div class="lg:col-span-2 reveal">
                <div class="card p-2 overflow-hidden sticky top-28">
                    <h3 class="text-sm font-bold text-slate-900 px-4 pt-3 pb-2 flex items-center gap-2">
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
