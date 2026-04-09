@extends('layouts.public')

@section('title', 'Turmas e Cursos — MC-COMERCIAL')

@section('content')

{{-- Header com fundo_imagem.jpg + squares pattern --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="{{ asset('images/fundo_imagem.jpg') }}" alt="Turmas">
    </div>
    <div class="container-wide">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4 reveal">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Cursos</span>
        </nav>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4 font-heading reveal">Cursos Disponíveis</h1>
        <p class="text-blue-100/60 max-w-lg reveal">Explore a nossa oferta formativa e inscreva-se.</p>
    </div>
</section>

{{-- Filters + Grid wrapped in a single Alpine component --}}
<div x-data="{
    search: new URLSearchParams(window.location.search).get('search') || '',
    centroFilter: new URLSearchParams(window.location.search).get('centro') || '',
    areaFilter: '',
    sortBy: 'default',
    matchesFilter(el) {
        const nome = (el.dataset.nome || '').toLowerCase();
        const centro = el.dataset.centro || '';
        const area = (el.dataset.area || '').toLowerCase();

        if (this.search && !nome.includes(this.search.toLowerCase())) return false;
        if (this.centroFilter && centro !== this.centroFilter) return false;
        if (this.areaFilter && area !== this.areaFilter.toLowerCase()) return false;
        return true;
    }
}">

    {{-- Filters bar --}}
    <section class="py-5 bg-white border-b border-slate-100 sticky top-20 z-30 shadow-sm">
        <div class="container-wide">
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 text-slate-600 font-semibold text-sm mr-4">
                    <i data-lucide="sliders-horizontal" class="w-4 h-4"></i>
                    Filtros
                </div>
                <div class="relative flex-1 min-w-[200px] max-w-sm">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    <input x-model="search" type="text" placeholder="Pesquisar cursos..." class="form-input pl-10">
                </div>
                @if(isset($centros) && $centros->count())
                <select x-model="centroFilter" class="form-input w-auto min-w-[160px]">
                    <option value="">Todos os Centros</option>
                    @foreach($centros as $centro)
                        <option value="{{ $centro->id }}">{{ $centro->nome }}</option>
                    @endforeach
                </select>
                @endif
                @if(isset($areas) && $areas->count())
                <select x-model="areaFilter" class="form-input w-auto min-w-[160px]">
                    <option value="">Todas as Áreas</option>
                    @foreach($areas as $area)
                        <option value="{{ $area }}">{{ $area }}</option>
                    @endforeach
                </select>
                @endif
                <div class="ml-auto">
                    <select x-model="sortBy" class="form-input w-auto min-w-[140px]">
                        <option value="default">Ordenar: Padrão</option>
                        <option value="price_asc">Preço: Menor</option>
                        <option value="price_desc">Preço: Maior</option>
                        <option value="name_asc">Nome: A-Z</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    {{-- Results count --}}
    <section class="pt-6 pb-2 bg-mesh">
        <div class="container-wide">
            <p class="text-sm text-slate-500 reveal">
                @if(isset($turmas))
                    Encontrámos <span class="font-semibold text-slate-700">{{ $turmas->count() }}</span> cursos disponíveis para si
                @endif
            </p>
        </div>
    </section>

    {{-- Turmas Grid — novo estilo de card tipo marketplace --}}
    <section class="section bg-mesh" style="padding-top: 1rem;">
        <div class="container-wide">
            @if(isset($turmas) && $turmas->count())
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
                    @foreach($turmas as $turma)
                        <div class="course-card reveal"
                             data-nome="{{ strtolower($turma->curso->nome ?? '') }}"
                             data-centro="{{ $turma->centro_id ?? '' }}"
                             data-area="{{ strtolower($turma->curso->area ?? '') }}"
                             x-show="matchesFilter($el)"
                             x-transition>

                            {{-- Imagem --}}
                            <div class="course-card-img">
                                @if($turma->curso && $turma->curso->imagem_url)
                                    <img src="{{ $turma->curso->imagem_url }}" alt="{{ $turma->curso->nome ?? '' }}" loading="lazy">
                                @else
                                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=60"
                                         alt="{{ $turma->curso->nome ?? 'Curso' }}" loading="lazy">
                                @endif

                                {{-- Badge nível --}}
                                @if($turma->status)
                                    <span class="course-card-badge active">
                                        <i data-lucide="bar-chart-3" class="w-3 h-3"></i>
                                        {{ $turma->status }}
                                    </span>
                                @endif
                            </div>

                            {{-- Body --}}
                            <div class="course-card-body">
                                <h3 class="course-card-title">{{ $turma->curso->nome ?? 'Curso' }}</h3>

                                @if($turma->curso && $turma->curso->area)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full mb-2" style="background: hsl(var(--brand-100)); color: hsl(var(--brand-700)); width: fit-content;">
                                        {{ $turma->curso->area }}
                                    </span>
                                @endif

                                @if($turma->curso && $turma->curso->descricao)
                                    <p class="text-xs text-slate-500 line-clamp-2 mb-2">{{ $turma->curso->descricao }}</p>
                                @endif

                                {{-- Meta info completa --}}
                                <div class="course-card-meta flex-wrap">
                                    @if($turma->hora_inicio && $turma->hora_fim)
                                        <span class="course-card-meta-item">
                                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                            {{ $turma->hora_inicio }} — {{ $turma->hora_fim }}
                                        </span>
                                    @endif
                                    @if($turma->centro)
                                        <span class="course-card-meta-item">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                            {{ $turma->centro->nome }}
                                        </span>
                                    @endif
                                    @if($turma->formador)
                                        <span class="course-card-meta-item">
                                            <i data-lucide="user" class="w-3.5 h-3.5"></i>
                                            {{ $turma->formador->nome }}
                                        </span>
                                    @endif
                                    @if($turma->duracao_semanas)
                                        <span class="course-card-meta-item">
                                            <i data-lucide="timer" class="w-3.5 h-3.5"></i>
                                            {{ $turma->duracao_semanas }} semanas
                                        </span>
                                    @endif
                                    @if($turma->periodo)
                                        <span class="course-card-meta-item">
                                            <i data-lucide="sun" class="w-3.5 h-3.5"></i>
                                            {{ ucfirst($turma->periodo) }}
                                        </span>
                                    @endif
                                    @if($turma->modalidade)
                                        <span class="course-card-meta-item">
                                            <i data-lucide="monitor" class="w-3.5 h-3.5"></i>
                                            {{ ucfirst($turma->modalidade) }}
                                        </span>
                                    @endif
                                    @if($turma->data_arranque)
                                        <span class="course-card-meta-item">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                            Início: {{ $turma->data_arranque->format('d/m/Y') }}
                                        </span>
                                    @endif
                                    @if($turma->dia_semana && is_array($turma->dia_semana))
                                        <span class="course-card-meta-item">
                                            <i data-lucide="calendar-days" class="w-3.5 h-3.5"></i>
                                            {{ implode(', ', $turma->dia_semana) }}
                                        </span>
                                    @endif
                                    @if($turma->vagas_disponiveis !== null)
                                        <span class="course-card-meta-item text-green-600">
                                            <i data-lucide="users" class="w-3.5 h-3.5"></i>
                                            {{ $turma->vagas_disponiveis }} vagas
                                        </span>
                                    @endif
                                </div>

                                {{-- Footer: rating + price --}}
                                <div class="course-card-footer">
                                    <div class="course-card-rating">
                                        <div class="stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="star {{ $i <= 4 ? '' : 'empty' }}" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.176 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.075 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    @if($turma->centro_preco)
                                        <span class="course-card-price">
                                            {{ number_format($turma->centro_preco, 0, ',', '.') }} <span class="currency">Kz</span>
                                        </span>
                                    @else
                                        <span class="text-sm text-slate-400 italic">Consultar</span>
                                    @endif
                                </div>

                                {{-- Botão inscrever --}}
                                <button @click="$dispatch('open-pre-inscricao', { turmaId: {{ $turma->id }}, turmaNome: '{{ addslashes($turma->curso->nome ?? '') }} — {{ addslashes($turma->centro->nome ?? '') }}' })"
                                        class="btn-primary w-full mt-4 btn-sm group">
                                    <i data-lucide="send" class="w-3 h-3 group-hover:translate-x-0.5 transition-transform"></i>
                                    Pré-inscrição
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 card p-10 max-w-md mx-auto reveal">
                    <div class="w-16 h-16 rounded-2xl bg-brand-100 flex items-center justify-center mx-auto mb-5">
                        <i data-lucide="graduation-cap" class="w-7 h-7 text-brand-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Sem turmas disponíveis</h3>
                    <p class="text-sm text-slate-500">Novas turmas serão publicadas em breve.</p>
                </div>
            @endif
        </div>
    </section>
</div>

@endsection
