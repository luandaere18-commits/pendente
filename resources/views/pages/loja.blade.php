@extends('layouts.public')

@section('title', 'Loja - MC-COMERCIAL')

@section('content')

{{-- Page Hero --}}
<div class="page-hero text-center">
    <div class="container mx-auto px-4 relative z-10">
        <span class="section-tag text-accent-foreground/80 justify-center before:bg-white/40">
            <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i> Loja
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-5" style="letter-spacing: -0.03em;">Loja MC-COMERCIAL</h1>
        <p class="text-lg text-white/65 max-w-2xl mx-auto">Snackbar e Produtos — tudo num só lugar</p>
    </div>
</div>

<div class="py-14 bg-background min-h-screen">
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
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-10">
                <div class="flex-1 flex flex-wrap gap-1 p-1.5 bg-muted rounded-2xl">
                    @php
                        $iconMap = ['snackbar' => 'utensils', 'produtos' => 'package'];
                    @endphp
                    @foreach($gruposLoja as $grupo)
                        <button @click="tab = '{{ $grupo->nome }}'"
                                class="flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-bold transition-all duration-300"
                                :class="tab === '{{ $grupo->nome }}'
                                    ? 'bg-primary text-primary-foreground shadow-md'
                                    : 'text-muted-foreground hover:text-foreground hover:bg-background/60'">
                            <i data-lucide="{{ $iconMap[$grupo->nome] ?? 'package' }}" class="w-4 h-4"></i>
                            {{ $grupo->display_name }}
                        </button>
                    @endforeach
                </div>
                <div class="relative">
                    <i data-lucide="search" class="input-icon"></i>
                    <input type="text" x-model="search" placeholder="Buscar produto..."
                           class="input-field pl-11 w-56 h-10 text-sm">
                </div>
            </div>

            {{-- Banner --}}
            <div class="mb-10 p-5 bg-accent/5 border border-accent/15 rounded-2xl flex items-center gap-3.5 reveal" style="box-shadow: var(--shadow-xs);">
                <div class="icon-box icon-box-sm bg-accent/10">
                    <i data-lucide="info" class="w-4 h-4 text-accent"></i>
                </div>
                <p class="text-sm text-muted-foreground">
                    Procura os nossos serviços de formação?
                    <a href="{{ route('site.servicos') }}" class="text-accent font-bold hover:underline">Consulte a página de Serviços</a>
                </p>
            </div>

            {{-- Tab Contents --}}
            @foreach($gruposLoja as $grupo)
                <div x-show="tab === '{{ $grupo->nome }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-3"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    @foreach($grupo->categorias as $categoria)
                        @if($categoria->itens->count() > 0)
                            <div class="mb-14">
                                <h3 class="text-lg font-extrabold text-foreground mb-7 flex items-center gap-2.5">
                                    <div class="icon-box icon-box-sm bg-accent/10">
                                        <i data-lucide="tag" class="w-4 h-4 text-accent"></i>
                                    </div>
                                    {{ $categoria->nome }}
                                </h3>
                                <div class="flex flex-wrap justify-center gap-5 reveal-stagger">
                                    @foreach($categoria->itens as $item)
                                        <div class="w-48 group relative bg-card border border-border rounded-2xl overflow-hidden hover:-translate-y-2 transition-all duration-400 reveal"
                                             style="box-shadow: var(--shadow-sm);"
                                             onmouseover="this.style.boxShadow='var(--shadow-lg)'"
                                             onmouseout="this.style.boxShadow='var(--shadow-sm)'"
                                             x-show="!search || '{{ strtolower($item->nome) }}'.includes(search.toLowerCase())">
                                            @if($item->destaque)
                                                <div class="absolute top-2.5 left-2.5 z-10">
                                                    <span class="badge bg-warning text-warning-foreground text-[10px]">
                                                        <i data-lucide="star" class="w-2.5 h-2.5"></i>Destaque
                                                    </span>
                                                </div>
                                            @endif
                                            <div class="aspect-square overflow-hidden bg-muted/30 img-overlay">
                                                <img src="{{ $item->imagem_url }}" alt="{{ $item->nome }}"
                                                     class="w-full h-full object-cover"
                                                     loading="lazy"
                                                     onerror="this.src='https://placehold.co/200x200/f1f5f9/94a3b8?text={{ urlencode($item->nome) }}'">
                                            </div>
                                            <div class="p-3.5">
                                                <h4 class="font-bold text-sm text-foreground mb-1 line-clamp-1 group-hover:text-accent transition-colors duration-300">{{ $item->nome }}</h4>
                                                @if($item->descricao)
                                                    <p class="text-xs text-muted-foreground mb-2.5 line-clamp-2 leading-relaxed">{{ $item->descricao }}</p>
                                                @endif
                                                <div class="flex items-center justify-between gap-1 flex-wrap">
                                                    <span class="text-sm font-extrabold gradient-text tabular-nums">
                                                        {{ $item->preco ? number_format($item->preco / 100, 2, ',', '.') . ' Kz' : 'Consultar' }}
                                                    </span>
                                                    <button @click="notify('{{ addslashes($item->nome) }}')"
                                                            class="inline-flex items-center justify-center gap-1 rounded-lg text-[11px] font-bold border border-input bg-background h-7 px-2.5 hover:bg-accent hover:text-white hover:border-accent active:scale-95 transition-all duration-200">
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
