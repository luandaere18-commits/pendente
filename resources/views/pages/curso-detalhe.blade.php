@extends('layouts.public')

@section('title', $curso->nome . ' — MC-COMERCIAL')

@section('content')

{{-- Header with Image --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        @if($curso->imagem_url)
            <img src="{{ $curso->imagem_url }}" alt="{{ $curso->nome }}">
        @else
            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1600&q=80" alt="{{ $curso->nome }}">
        @endif
    </div>
    <div class="container-wide">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4 reveal">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <a href="{{ route('site.cursos') }}" class="hover:text-white transition-colors">Turmas</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">{{ $curso->nome }}</span>
        </nav>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4 font-heading reveal">{{ $curso->nome }}</h1>
        @if($curso->descricao)
            <p class="text-blue-100/60 max-w-lg reveal">{{ $curso->descricao }}</p>
        @endif
    </div>
</section>

{{-- Content --}}
<section class="section bg-white">
    <div class="container-wide">
        <div class="grid lg:grid-cols-3 gap-12">
            {{-- Main --}}
            <div class="lg:col-span-2">
                {{-- About --}}
                <div class="card p-8 mb-8 reveal">
                    <h2 class="text-2xl font-bold text-slate-900 mb-4 font-heading">Sobre o Curso</h2>
                    <div class="space-y-4 text-slate-500 leading-relaxed">
                        @if($curso->area)
                            <div class="flex items-center gap-2">
                                <span class="badge-brand">{{ $curso->area }}</span>
                            </div>
                        @endif
                        @if($curso->descricao)
                            <p>{{ $curso->descricao }}</p>
                        @endif
                        @if($curso->programa)
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Programa</h3>
                                <div class="prose prose-sm max-w-none">{!! nl2br(e($curso->programa)) !!}</div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Turmas --}}
                @if($turmas->count() > 0)
                    <div class="reveal">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3 font-heading">
                            <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center">
                                <i data-lucide="calendar" class="w-5 h-5 text-brand-600"></i>
                            </div>
                            Turmas Disponíveis
                        </h2>

                        <div class="grid gap-6 reveal-stagger">
                            @foreach($turmas as $turma)
                                <div class="card p-6 hover-lift reveal group">
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-3">
                                                <h3 class="text-lg font-bold text-slate-900 font-heading">{{ $turma->referencia ?? 'Turma #' . $turma->id }}</h3>
                                                @if($turma->status)
                                                    <span class="badge-success text-[10px]">{{ $turma->status }}</span>
                                                @endif
                                            </div>
                                            <div class="grid sm:grid-cols-2 gap-2 text-sm text-slate-500">
                                                @if($turma->centro)
                                                    <div class="flex items-center gap-2">
                                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-brand-400"></i>
                                                        {{ $turma->centro->nome }}
                                                    </div>
                                                @endif
                                                @if($turma->data_arranque)
                                                    <div class="flex items-center gap-2">
                                                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-brand-400"></i>
                                                        Início: {{ $turma->data_arranque->format('d/m/Y') }}
                                                    </div>
                                                @endif
                                                @if($turma->hora_inicio && $turma->hora_fim)
                                                    <div class="flex items-center gap-2">
                                                        <i data-lucide="clock" class="w-3.5 h-3.5 text-brand-400"></i>
                                                        {{ $turma->hora_inicio }} — {{ $turma->hora_fim }}
                                                    </div>
                                                @endif
                                                @if($turma->formador)
                                                    <div class="flex items-center gap-2">
                                                        <i data-lucide="user" class="w-3.5 h-3.5 text-brand-400"></i>
                                                        {{ $turma->formador->nome }}
                                                    </div>
                                                @endif
                                                @if($turma->periodo)
                                                    <div class="flex items-center gap-2">
                                                        <i data-lucide="sun" class="w-3.5 h-3.5 text-brand-400"></i>
                                                        {{ ucfirst($turma->periodo) }}
                                                    </div>
                                                @endif
                                                @if($turma->duracao_semanas)
                                                    <div class="flex items-center gap-2">
                                                        <i data-lucide="timer" class="w-3.5 h-3.5 text-brand-400"></i>
                                                        {{ $turma->duracao_semanas }} semanas
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            @if($turma->centro_preco)
                                                <div class="text-2xl font-black text-brand-700 font-heading">
                                                    {{ number_format($turma->centro_preco, 0, ',', '.') }} <span class="text-sm font-semibold">Kz</span>
                                                </div>
                                            @endif
                                            @if($turma->vagas_disponiveis !== null)
                                                <p class="text-xs text-green-600 mt-1">{{ $turma->vagas_disponiveis }} vagas</p>
                                            @endif
                                            <button @click="$dispatch('open-pre-inscricao', { turmaId: {{ $turma->id }}, turmaNome: '{{ addslashes($curso->nome) }} — {{ addslashes($turma->centro->nome ?? '') }}' })"
                                                    class="btn-primary btn-sm mt-3 group">
                                                <i data-lucide="send" class="w-3 h-3"></i> Inscrever
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-12 card p-10 reveal">
                        <i data-lucide="inbox" class="w-12 h-12 text-slate-300 mx-auto mb-4"></i>
                        <p class="text-slate-500">Nenhuma turma disponível para este curso no momento.</p>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-28 reveal">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2 font-heading">
                        <i data-lucide="info" class="w-5 h-5 text-brand-600"></i>
                        Informações
                    </h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex items-center gap-3 text-slate-600">
                            <i data-lucide="graduation-cap" class="w-4 h-4 text-brand-400"></i>
                            <span>{{ $turmas->count() }} turma(s) disponível(is)</span>
                        </div>
                        @if($curso->area)
                            <div class="flex items-center gap-3 text-slate-600">
                                <i data-lucide="folder" class="w-4 h-4 text-brand-400"></i>
                                <span>Área: {{ $curso->area }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <p class="text-sm text-slate-500 mb-4">Tem dúvidas sobre este curso?</p>
                        <a href="{{ route('site.contactos') }}" class="btn-secondary w-full justify-center">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            Contactar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
