@extends('layouts.public')

@section('title', 'Turmas e Cursos — MC-COMERCIAL')

@section('content')

{{-- Page Header with Background --}}
<section class="relative pt-12 pb-16 bg-gradient-to-br from-brand-700 to-brand-900 text-white -mt-20 pt-32 overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-5"></div>
    <div class="container-wide relative">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Turmas</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3">Turmas Disponíveis</h1>
        <p class="text-blue-100/70 max-w-lg">Explore as nossas turmas e encontre a formação ideal para si.</p>
    </div>
</section>

{{-- Filters --}}
<section class="py-5 bg-white border-b border-slate-100 sticky top-20 z-30 shadow-sm"
         x-data="{ search: '', centroFilter: '', areaFilter: '' }">
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
<section class="section-tight bg-slate-50/50">
    <div class="container-wide">
        @if(isset($turmas) && $turmas->count())
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
                @foreach($turmas as $turma)
                    <div class="card card-interactive p-0 overflow-hidden reveal group">
                        {{-- Image --}}
                        <div class="relative h-44 bg-gradient-to-br from-brand-600 to-brand-800 overflow-hidden img-overlay-zoom">
                            @if($turma->curso->imagem ?? false)
                                <img src="{{ asset('storage/' . $turma->curso->imagem) }}" alt="{{ $turma->curso->nome ?? '' }}"
                                     class="w-full h-full object-cover" loading="lazy">
                            @else
                                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=60"
                                     alt="{{ $turma->curso->nome ?? 'Curso' }}" class="w-full h-full object-cover opacity-50" loading="lazy">
                            @endif
                            <div class="absolute top-3 left-3 z-10">
                                <span class="badge bg-white/90 text-brand-700 backdrop-blur-sm text-[10px] font-bold">
                                    {{ $turma->curso->area ?? 'Formação' }}
                                </span>
                            </div>
                            @if($turma->data_arranque)
                                <div class="absolute top-3 right-3 z-10">
                                    <span class="badge bg-brand-600 text-white text-[10px]">
                                        <i data-lucide="calendar" class="w-3 h-3"></i>
                                        {{ \Carbon\Carbon::parse($turma->data_arranque)->format('d M Y') }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="p-5">
                            <h3 class="text-base font-bold text-slate-900 mb-2 group-hover:text-brand-600 transition-colors line-clamp-1">
                                {{ $turma->curso->nome ?? 'Curso' }}
                            </h3>
                            <p class="text-sm text-slate-500 line-clamp-2 mb-4">{{ $turma->curso->descricao ?? '' }}</p>

                            <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                @if($turma->centro)
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-brand-500"></i>
                                        <span class="truncate">{{ $turma->centro->nome }}</span>
                                    </div>
                                @endif
                                @if($turma->horario)
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="clock" class="w-3.5 h-3.5 text-brand-500"></i>
                                        {{ $turma->horario }}
                                    </div>
                                @endif
                                @if($turma->duracao)
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="timer" class="w-3.5 h-3.5 text-brand-500"></i>
                                        {{ $turma->duracao }}
                                    </div>
                                @endif
                                @if($turma->periodo)
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="sun" class="w-3.5 h-3.5 text-brand-500"></i>
                                        {{ $turma->periodo }}
                                    </div>
                                @endif
                                @if($turma->formador)
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="user" class="w-3.5 h-3.5 text-brand-500"></i>
                                        <span class="truncate">{{ $turma->formador->nome }}</span>
                                    </div>
                                @endif
                                @if($turma->vagas)
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="users" class="w-3.5 h-3.5 text-brand-500"></i>
                                        {{ $turma->vagas }} vagas
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="px-5 py-4 bg-brand-50/30 border-t border-brand-100/50 flex items-center justify-between">
                            <div>
                                @if($turma->preco)
                                    <span class="text-lg font-black text-brand-700">{{ number_format($turma->preco, 0, ',', '.') }} <span class="text-xs font-semibold">Kz</span></span>
                                @else
                                    <span class="text-sm text-slate-400 italic">Consultar</span>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('site.curso', $turma->curso->id ?? $turma->id) }}" class="btn-secondary btn-sm">
                                    <i data-lucide="eye" class="w-3 h-3"></i> Detalhes
                                </a>
                                <button @click="$dispatch('open-pre-inscricao', { turmaId: {{ $turma->id }}, turmaNome: '{{ addslashes($turma->curso->nome ?? '') }}' })"
                                        class="btn-primary btn-sm">
                                    Inscrever-se
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($turmas->hasPages())
                <div class="mt-10 flex justify-center">
                    {{ $turmas->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-20">
                <div class="w-16 h-16 rounded-2xl bg-brand-100 flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="search-x" class="w-7 h-7 text-brand-400"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Nenhuma turma disponível</h3>
                <p class="text-sm text-slate-500">De momento não existem turmas abertas. Volte em breve.</p>
            </div>
        @endif
    </div>
</section>

@endsection
