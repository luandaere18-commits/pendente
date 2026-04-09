@extends('layouts.public')

@section('title', 'Turmas e Cursos — MC-COMERCIAL')

@section('content')

{{-- Header with Image --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1600&q=80" alt="Turmas">
    </div>
    <div class="container-wide">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4 reveal">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Turmas</span>
        </nav>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4 font-heading reveal">Turmas Disponíveis</h1>
        <p class="text-blue-100/60 max-w-lg reveal">Passe o mouse nos cards para ver detalhes completos.</p>
    </div>
</section>

{{-- Filters --}}
<section class="py-5 bg-white border-b border-slate-100 sticky top-20 z-30 shadow-sm"
         x-data="{
             search: new URLSearchParams(window.location.search).get('search') || '',
             centroFilter: new URLSearchParams(window.location.search).get('centro') || '',
             areaFilter: ''
         }">
    <div class="container-wide">
        <div class="flex flex-wrap gap-3">
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
        </div>
    </div>
</section>

{{-- Turmas Grid --}}
<section class="section bg-mesh">
    <div class="container-wide">
        @if(isset($turmas) && $turmas->count())
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
                @foreach($turmas as $turma)
                    <div class="card card-hover-detail overflow-hidden reveal group" style="height: 400px;">
                        {{-- Image --}}
                        <div class="absolute inset-0 img-overlay-zoom">
                            @if($turma->curso && $turma->curso->imagem_url)
                                <img src="{{ $turma->curso->imagem_url }}" alt="{{ $turma->curso->nome ?? '' }}"
                                     class="w-full h-full object-cover" loading="lazy">
                            @else
                                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=60"
                                     alt="{{ $turma->curso->nome ?? 'Curso' }}" class="w-full h-full object-cover" loading="lazy">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                        </div>

                        {{-- Basic --}}
                        <div class="absolute bottom-0 left-0 right-0 p-5 z-10 transition-opacity duration-300 group-hover:opacity-0">
                            @if($turma->status)
                                <span class="badge-success text-[10px] mb-2">{{ $turma->status }}</span>
                            @endif
                            <h3 class="text-lg font-bold text-white font-heading">{{ $turma->curso->nome ?? 'Curso' }}</h3>
                            @if($turma->centro)
                                <p class="text-sm text-white/60 flex items-center gap-1 mt-1">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i> {{ $turma->centro->nome }}
                                </p>
                            @endif
                            @if($turma->centro_preco)
                                <p class="text-lg font-black text-white mt-2">{{ number_format($turma->centro_preco, 0, ',', '.') }} <span class="text-xs">Kz</span></p>
                            @endif
                        </div>

                        {{-- Hover Detail --}}
                        <div class="card-detail-overlay z-20">
                            <div>
                                <h3 class="text-lg font-bold text-white mb-3 font-heading">{{ $turma->curso->nome ?? 'Curso' }}</h3>
                                <div class="space-y-2 text-sm">
                                    @if($turma->centro)
                                        <div class="flex items-center gap-2 text-blue-200">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 shrink-0"></i>
                                            <span>{{ $turma->centro->nome }}</span>
                                        </div>
                                    @endif
                                    @if($turma->data_arranque)
                                        <div class="flex items-center gap-2 text-blue-200">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5 shrink-0"></i>
                                            <span>Início: {{ $turma->data_arranque->format('d/m/Y') }}</span>
                                        </div>
                                    @endif
                                    @if($turma->hora_inicio && $turma->hora_fim)
                                        <div class="flex items-center gap-2 text-blue-200">
                                            <i data-lucide="clock" class="w-3.5 h-3.5 shrink-0"></i>
                                            <span>{{ $turma->hora_inicio }} — {{ $turma->hora_fim }}</span>
                                        </div>
                                    @endif
                                    @if($turma->periodo)
                                        <div class="flex items-center gap-2 text-blue-200">
                                            <i data-lucide="sun" class="w-3.5 h-3.5 shrink-0"></i>
                                            <span>{{ ucfirst($turma->periodo) }}</span>
                                        </div>
                                    @endif
                                    @if($turma->modalidade)
                                        <div class="flex items-center gap-2 text-blue-200">
                                            <i data-lucide="monitor" class="w-3.5 h-3.5 shrink-0"></i>
                                            <span>{{ ucfirst($turma->modalidade) }}</span>
                                        </div>
                                    @endif
                                    @if($turma->formador)
                                        <div class="flex items-center gap-2 text-blue-200">
                                            <i data-lucide="user" class="w-3.5 h-3.5 shrink-0"></i>
                                            <span>{{ $turma->formador->nome }}</span>
                                        </div>
                                    @endif
                                    @if($turma->duracao_semanas)
                                        <div class="flex items-center gap-2 text-blue-200">
                                            <i data-lucide="timer" class="w-3.5 h-3.5 shrink-0"></i>
                                            <span>{{ $turma->duracao_semanas }} semanas</span>
                                        </div>
                                    @endif
                                    @if($turma->vagas_disponiveis !== null)
                                        <div class="flex items-center gap-2 text-green-300">
                                            <i data-lucide="users" class="w-3.5 h-3.5 shrink-0"></i>
                                            <span>{{ $turma->vagas_disponiveis }} vagas</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between mt-4 pt-3 border-t border-white/15">
                                    @if($turma->centro_preco)
                                        <span class="text-xl font-black text-white">{{ number_format($turma->centro_preco, 0, ',', '.') }} <span class="text-xs">Kz</span></span>
                                    @else
                                        <span class="text-sm text-white/50 italic">Consultar</span>
                                    @endif
                                    <button @click="$dispatch('open-pre-inscricao', { turmaId: {{ $turma->id }}, turmaNome: '{{ addslashes($turma->curso->nome ?? '') }} — {{ addslashes($turma->centro->nome ?? '') }}' })"
                                            class="btn-primary btn-sm">
                                        <i data-lucide="send" class="w-3 h-3"></i> Inscrever
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($turmas->hasPages())
                <div class="mt-12 flex justify-center reveal">
                    {{ $turmas->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-20 card p-10 max-w-md mx-auto reveal">
                <div class="w-16 h-16 rounded-2xl bg-brand-100 flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="inbox" class="w-7 h-7 text-brand-400"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Sem turmas disponíveis</h3>
                <p class="text-sm text-slate-500">Novas turmas em breve.</p>
            </div>
        @endif
    </div>
</section>

@endsection
