@extends('layouts.public')

@section('title', 'Loja - MC-COMERCIAL')

@section('content')
<div class="py-12 bg-background min-h-screen">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h1 class="section-title">Loja MC-COMERCIAL</h1>
            <p class="section-subtitle">Snackbar, Produtos e Serviços — tudo num só lugar</p>
        </div>

        <div x-data="{ tab: '{{ $grupos->first()->nome ?? 'snackbar' }}' }">
            {{-- Tabs --}}
            <div class="w-full flex flex-wrap gap-1 p-1 bg-muted rounded-lg mb-8">
                @php
                    $iconMap = ['snackbar' => 'utensils', 'produtos' => 'package', 'servicos' => 'wrench'];
                @endphp
                @foreach($grupos as $grupo)
                    <button @click="tab = '{{ $grupo->nome }}'"
                            class="flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium transition-colors"
                            :class="tab === '{{ $grupo->nome }}' ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground'">
                        <i data-lucide="{{ $iconMap[$grupo->nome] ?? 'package' }}" class="w-4 h-4"></i>
                        {{ $grupo->display_name }}
                    </button>
                @endforeach
            </div>

            {{-- Tab Contents --}}
            @foreach($grupos as $grupo)
                <div x-show="tab === '{{ $grupo->nome }}'" x-transition>
                    @foreach($grupo->categorias as $categoria)
                        @if($categoria->itens->count() > 0)
                            <div class="mb-10">
                                <h3 class="text-xl font-bold text-foreground mb-2">{{ $categoria->nome }}</h3>
                                <p class="text-sm text-muted-foreground mb-6">{{ $categoria->descricao }}</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                    @foreach($categoria->itens as $item)
                                        <div class="group relative bg-card border border-border rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                                            @if($item->destaque)
                                                <div class="absolute top-2 right-2 z-10">
                                                    <span class="inline-flex items-center gap-1 bg-warning text-warning-foreground text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                                        <i data-lucide="star" class="w-3 h-3"></i>Destaque
                                                    </span>
                                                </div>
                                            @endif
                                            <div class="aspect-square overflow-hidden">
                                                <img src="{{ $item->imagem_url }}" alt="{{ $item->nome }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                            </div>
                                            <div class="p-3">
                                                <h4 class="font-semibold text-sm text-foreground mb-1 line-clamp-1">{{ $item->nome }}</h4>
                                                <p class="text-xs text-muted-foreground mb-2 line-clamp-2">{{ $item->descricao }}</p>
                                                <div class="flex items-center justify-between gap-1">
                                                    <span class="text-sm font-bold gradient-text">
                                                        {{ $item->preco ? number_format($item->preco / 100, 2, ',', '.') . ' Kz' : 'Sob Consulta' }}
                                                    </span>
                                                    <button onclick="showToast('Contacte-nos para mais informações!', 'info')"
                                                            class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-input bg-background h-7 px-2 hover:bg-accent hover:text-accent-foreground transition-colors">
                                                        <i data-lucide="shopping-cart" class="w-3 h-3 mr-1"></i>
                                                        {{ $item->preco ? 'Pedir' : 'Contactar' }}
                                                    </button>
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
        </div>
    </div>
</div>
@endsection
