@extends('layouts.public')

@section('title', 'Loja - MC-COMERCIAL')

@section('content')

{{-- Page Hero --}}
<div class="bg-gradient-to-br from-primary via-primary/90 to-primary/80 py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-accent blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 text-center text-primary-foreground relative">
        <h1 class="text-4xl lg:text-5xl font-extrabold mb-4">Loja MC-COMERCIAL</h1>
        <p class="text-lg opacity-80 max-w-2xl mx-auto">Snackbar e Produtos — tudo num só lugar</p>
    </div>
</div>

<div class="py-12 bg-background min-h-screen">
    <div class="container mx-auto px-4">

        @php
            $gruposLoja = $grupos->filter(fn($g) => strtolower($g->nome) !== 'servicos');
        @endphp

        <div x-data="{
            tab: '{{ $gruposLoja->first()->nome ?? '' }}',
            search: '',
            cartCount: 0,
            notify(item) {
                this.cartCount++;
                showToast(`${item} adicionado ao pedido!`, 'success');
            }
        }">
            {{-- Tabs + Busca --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-8">
                <div class="flex-1 flex flex-wrap gap-1 p-1 bg-muted rounded-xl">
                    @php
                        $iconMap = ['snackbar' => 'utensils', 'produtos' => 'package'];
                    @endphp
                    @foreach($gruposLoja as $grupo)
                        <button @click="tab = '{{ $grupo->nome }}'"
                                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200"
                                :class="tab === '{{ $grupo->nome }}'
                                    ? 'bg-primary text-primary-foreground shadow-sm'
                                    : 'text-muted-foreground hover:text-foreground hover:bg-background/50'">
                            <i data-lucide="{{ $iconMap[$grupo->nome] ?? 'package' }}" class="w-4 h-4"></i>
                            {{ $grupo->display_name }}
                        </button>
                    @endforeach
                </div>
                {{-- Busca --}}
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground"></i>
                    <input type="text" x-model="search" placeholder="Buscar produto..."
                           class="h-10 w-52 rounded-xl border border-input bg-background pl-9 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-all">
                </div>
            </div>

            {{-- Banner: serviços na página própria --}}
            <div class="mb-8 p-4 bg-accent/5 border border-accent/20 rounded-xl flex items-center gap-3">
                <i data-lucide="info" class="w-5 h-5 text-accent shrink-0"></i>
                <p class="text-sm text-muted-foreground">
                    Procura os nossos serviços de formação?
                    <a href="{{ route('site.servicos') }}" class="text-accent font-semibold hover:underline">Consulte a página de Serviços</a>
                </p>
            </div>

            {{-- Tab Contents --}}
            @foreach($gruposLoja as $grupo)
                <div x-show="tab === '{{ $grupo->nome }}'"
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    @foreach($grupo->categorias as $categoria)
                        @if($categoria->itens->count() > 0)
                            <div class="mb-12">
                                <h3 class="text-lg font-extrabold text-foreground mb-6 flex items-center gap-2">
                                    <i data-lucide="tag" class="w-5 h-5 text-accent"></i>
                                    {{ $categoria->nome }}
                                </h3>
                                <div class="flex flex-wrap justify-center gap-5">
                                    @foreach($categoria->itens as $item)
                                        <div class="w-44 group relative bg-card border border-border rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                                             x-show="!search || '{{ strtolower($item->nome) }}'.includes(search.toLowerCase())">
                                            {{-- Badge destaque --}}
                                            @if($item->destaque)
                                                <div class="absolute top-2 left-2 z-10">
                                                    <span class="inline-flex items-center gap-1 bg-warning text-warning-foreground text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                        <i data-lucide="star" class="w-2.5 h-2.5"></i>Destaque
                                                    </span>
                                                </div>
                                            @endif
                                            {{-- Imagem --}}
                                            <div class="aspect-square overflow-hidden bg-muted/50">
                                                <img src="{{ $item->imagem_url }}" alt="{{ $item->nome }}"
                                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                     loading="lazy"
                                                     onerror="this.src='https://placehold.co/200x200/f1f5f9/94a3b8?text={{ urlencode($item->nome) }}'">
                                            </div>
                                            {{-- Info --}}
                                            <div class="p-3">
                                                <h4 class="font-bold text-sm text-foreground mb-1 line-clamp-1 group-hover:text-accent transition-colors">{{ $item->nome }}</h4>
                                                @if($item->descricao)
                                                    <p class="text-xs text-muted-foreground mb-2 line-clamp-2 leading-relaxed">{{ $item->descricao }}</p>
                                                @endif
                                                <div class="flex items-center justify-between gap-1 flex-wrap">
                                                    <span class="text-sm font-extrabold gradient-text">
                                                        {{ $item->preco ? number_format($item->preco / 100, 2, ',', '.') . ' Kz' : 'Consultar' }}
                                                    </span>
                                                    <button @click="notify('{{ addslashes($item->nome) }}')"
                                                            class="inline-flex items-center justify-center gap-1 rounded-lg text-[11px] font-bold border border-input bg-background h-7 px-2 hover:bg-accent hover:text-white hover:border-accent active:scale-95 transition-all duration-200">
                                                        <i data-lucide="{{ $item->preco ? 'shopping-cart' : 'phone' }}" class="w-3 h-3"></i>
                                                        {{ $item->preco ? 'Pedir' : 'Info' }}
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
