@extends('layouts.public')

@section('title', 'Loja — MC-COMERCIAL')

@section('content')

{{-- Header com fundo_imagem.jpg + squares pattern --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="{{ asset('images/fundo_imagem.jpg') }}" alt="Loja">
    </div>
    <div class="container-wide">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4 reveal">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Loja</span>
        </nav>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4 font-heading reveal">Loja</h1>
        <p class="text-blue-100/60 max-w-lg reveal">Material didático, fardamento e outros produtos.</p>
    </div>
</section>

{{-- Loja com submenus/tabs por grupo --}}
<section class="section bg-mesh" x-data="{ activeTab: 'todos' }">
    <div class="container-wide">

        {{-- Tabs de filtro --}}
        <div class="flex flex-wrap gap-2 mb-12 reveal">
            <button @click="activeTab = 'todos'"
                    class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300"
                    :class="activeTab === 'todos' ? 'bg-brand-600 text-white shadow-lg' : 'bg-white text-slate-600 border border-slate-200 hover:border-brand-300 hover:text-brand-600'">
                Todos
            </button>
            @if(isset($grupos) && $grupos->count())
                @foreach($grupos as $grupo)
                    <button @click="activeTab = '{{ Str::slug($grupo->nome) }}'"
                            class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300"
                            :class="activeTab === '{{ Str::slug($grupo->nome) }}' ? 'bg-brand-600 text-white shadow-lg' : 'bg-white text-slate-600 border border-slate-200 hover:border-brand-300 hover:text-brand-600'">
                        {{ $grupo->nome }}
                    </button>
                @endforeach
            @endif
        </div>

        @if(isset($grupos) && $grupos->count())
            @foreach($grupos as $grupo)
                <div x-show="activeTab === 'todos' || activeTab === '{{ Str::slug($grupo->nome) }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mb-16 last:mb-0 reveal">

                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center">
                            <i data-lucide="package" class="w-5 h-5 text-brand-600"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 font-heading">{{ $grupo->nome }}</h2>
                    </div>

                    @if($grupo->categorias && $grupo->categorias->count())
                        @foreach($grupo->categorias as $categoria)
                            <div class="mb-10 last:mb-0">
                                <h3 class="text-lg font-bold text-slate-700 mb-5 flex items-center gap-2 font-heading">
                                    <i data-lucide="tag" class="w-4 h-4 text-brand-400"></i>
                                    {{ $categoria->nome }}
                                </h3>

                                @if($categoria->itens && $categoria->itens->count())
                                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 reveal-stagger">
                                        @foreach($categoria->itens as $item)
                                            <div class="course-card reveal group">
                                                {{-- Imagem --}}
                                                <div class="course-card-img">
                                                    @if($item->imagem)
                                                        <img src="{{ asset('storage/' . $item->imagem) }}" alt="{{ $item->nome }}" loading="lazy">
                                                    @else
                                                        <div class="w-full h-full bg-gradient-to-br from-brand-50 to-brand-100 flex items-center justify-center">
                                                            <i data-lucide="package" class="w-12 h-12 text-brand-300"></i>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Body --}}
                                                <div class="course-card-body">
                                                    <h4 class="course-card-title">{{ $item->nome }}</h4>
                                                    @if($item->descricao)
                                                        <p class="text-xs text-slate-500 line-clamp-2 mb-3">{{ $item->descricao }}</p>
                                                    @endif

                                                    <div class="course-card-footer">
                                                        <div class="course-card-rating">
                                                            <div class="stars">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <svg class="star {{ $i <= 4 ? '' : 'empty' }}" viewBox="0 0 20 20" fill="currentColor" style="width:14px;height:14px;">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.176 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.075 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z"/>
                                                                    </svg>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        @if($item->preco)
                                                            <span class="course-card-price">
                                                                {{ number_format($item->preco, 0, ',', '.') }} <span class="currency">Kz</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        @else
            <div class="text-center py-20 card p-10 max-w-md mx-auto reveal">
                <div class="w-16 h-16 rounded-2xl bg-brand-100 flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="shopping-bag" class="w-7 h-7 text-brand-400"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Loja em breve</h3>
                <p class="text-sm text-slate-500">Estamos a preparar os nossos produtos.</p>
            </div>
        @endif
    </div>
</section>

@endsection
