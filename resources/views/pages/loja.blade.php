@extends('layouts.public')

@section('title', 'Loja — MC-COMERCIAL')

@section('content')

{{-- Header --}}
<section class="relative pt-12 pb-16 bg-gradient-to-br from-brand-700 to-brand-900 text-white -mt-20 pt-32 overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-5"></div>
    <div class="container-wide relative">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Loja</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3">Loja</h1>
        <p class="text-blue-100/70">Material didático, fardamento e outros produtos.</p>
    </div>
</section>

<section class="section-tight">
    <div class="container-wide">
        @if(isset($grupos) && $grupos->count())
            @foreach($grupos as $grupo)
                <div class="mb-16 reveal">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center">
                            <i data-lucide="package" class="w-5 h-5 text-brand-600"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900">{{ $grupo->nome }}</h2>
                    </div>

                    @foreach($grupo->categorias as $categoria)
                        @if($categoria->itens->count())
                            <div class="mb-10">
                                <h3 class="text-lg font-semibold text-slate-700 mb-5 flex items-center gap-2">
                                    <i data-lucide="tag" class="w-4 h-4 text-brand-500"></i>
                                    {{ $categoria->nome }}
                                </h3>

                                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 reveal-stagger">
                                    @foreach($categoria->itens as $item)
                                        <div class="card card-interactive p-0 overflow-hidden group reveal"
                                             x-data="{ showDetail: false }">
                                            {{-- Image --}}
                                            <div class="aspect-square bg-slate-100 overflow-hidden img-overlay-zoom relative">
                                                @if($item->imagem)
                                                    <img src="{{ asset('storage/' . $item->imagem) }}" alt="{{ $item->nome }}"
                                                         class="w-full h-full object-cover"
                                                         loading="lazy">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-brand-50 to-brand-100">
                                                        <i data-lucide="package" class="w-12 h-12 text-brand-300"></i>
                                                    </div>
                                                @endif
                                                @if($item->destaque ?? false)
                                                    <div class="absolute top-3 left-3 z-10">
                                                        <span class="badge bg-red-500 text-white text-[10px]">
                                                            <i data-lucide="flame" class="w-3 h-3"></i> Destaque
                                                        </span>
                                                    </div>
                                                @endif

                                                {{-- Quick View Button --}}
                                                <div class="absolute inset-0 flex items-center justify-center bg-brand-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                                                    <button @click="showDetail = true" class="btn bg-white text-brand-700 btn-sm shadow-lg hover:scale-105 transition-transform">
                                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> Ver Detalhes
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- Info --}}
                                            <div class="p-4">
                                                <h4 class="text-sm font-bold text-slate-900 mb-1 group-hover:text-brand-600 transition-colors line-clamp-1">
                                                    {{ $item->nome }}
                                                </h4>
                                                @if($item->descricao)
                                                    <p class="text-xs text-slate-500 line-clamp-2 mb-3">{{ $item->descricao }}</p>
                                                @endif
                                                <div class="flex items-center justify-between">
                                                    @if($item->preco)
                                                        <span class="text-lg font-black text-brand-700">
                                                            {{ number_format($item->preco, 0, ',', '.') }} <span class="text-xs font-semibold">Kz</span>
                                                        </span>
                                                    @else
                                                        <span class="text-sm text-slate-400 italic">Consultar</span>
                                                    @endif
                                                    @if($item->disponivel ?? true)
                                                        <span class="badge-success text-[10px]">Disponível</span>
                                                    @else
                                                        <span class="badge-warning text-[10px]">Esgotado</span>
                                                    @endif
                                                </div>
                                                @if($item->tamanhos ?? false)
                                                    <div class="mt-2 flex gap-1">
                                                        @foreach(explode(',', $item->tamanhos) as $tam)
                                                            <span class="text-[10px] px-2 py-0.5 rounded bg-slate-100 text-slate-500 font-medium">{{ trim($tam) }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Detail Modal --}}
                                            <div x-show="showDetail" x-transition class="fixed inset-0 z-[200] flex items-center justify-center p-4" x-cloak>
                                                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showDetail = false"></div>
                                                <div class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden" @click.stop>
                                                    <div class="aspect-video bg-slate-100 overflow-hidden">
                                                        @if($item->imagem)
                                                            <img src="{{ asset('storage/' . $item->imagem) }}" alt="{{ $item->nome }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-brand-50 to-brand-100">
                                                                <i data-lucide="package" class="w-16 h-16 text-brand-300"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="p-6">
                                                        <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $item->nome }}</h3>
                                                        @if($item->descricao)
                                                            <p class="text-sm text-slate-500 leading-relaxed mb-4">{{ $item->descricao }}</p>
                                                        @endif
                                                        @if($item->preco)
                                                            <span class="text-2xl font-black text-brand-700">{{ number_format($item->preco, 0, ',', '.') }} Kz</span>
                                                        @endif
                                                        <div class="mt-4 flex gap-3">
                                                            <a href="https://wa.me/244929643510?text=Olá, quero encomendar: {{ urlencode($item->nome) }}" target="_blank" class="btn-primary flex-1 justify-center">
                                                                <i data-lucide="shopping-cart" class="w-4 h-4"></i> Encomendar
                                                            </a>
                                                            <button @click="showDetail = false" class="btn-secondary">Fechar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="text-center py-20">
                <div class="w-16 h-16 rounded-2xl bg-brand-100 flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="shopping-bag" class="w-7 h-7 text-brand-400"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Loja em breve</h3>
                <p class="text-sm text-slate-500">Estamos a preparar os nossos produtos.</p>
            </div>
        @endif
    </div>
</section>

@endsection
