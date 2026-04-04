@extends('layouts.public')

@section('title', $curso->nome . ' - MC-COMERCIAL')

@section('content')

{{-- Page Hero --}}
<div class="page-hero text-center">
    <div class="container mx-auto px-4 relative z-10">
        <span class="section-tag text-accent-foreground/80 justify-center before:bg-white/40">
            <i data-lucide="book-open" class="w-3.5 h-3.5"></i> Formação
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-5" style="letter-spacing: -0.03em;">{{ $curso->nome }}</h1>
        @if($curso->descricao)
            <p class="text-lg text-white/65 max-w-2xl mx-auto">{{ $curso->descricao }}</p>
        @endif
    </div>
</div>

<div class="py-14 bg-background min-h-screen">
    <div class="container mx-auto px-4">
        
        {{-- Curso Info --}}
        <div class="grid lg:grid-cols-3 gap-8 mb-14">
            <div class="lg:col-span-2">
                <div class="feature-card">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-foreground mb-4">Sobre o Curso</h2>
                        <div class="space-y-4 text-muted-foreground">
                            @if($curso->area)
                                <div>
                                    <span class="font-semibold text-foreground">Área:</span> {{ $curso->area }}
                                </div>
                            @endif
                            @if($curso->descricao)
                                <div>
                                    <span class="font-semibold text-foreground">Descrição:</span>
                                    <p class="mt-2">{{ $curso->descricao }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <aside class="lg:col-span-1">
                <div class="feature-card sticky top-24 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <div class="icon-box icon-box-sm bg-accent/10">
                            <i data-lucide="info" class="w-4 h-4 text-accent"></i>
                        </div>
                        <h3 class="font-extrabold text-foreground">Informações</h3>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-2 text-muted-foreground">
                            <i data-lucide="graduation-cap" class="w-4 h-4 text-accent"></i>
                            <span>{{ $turmas->count() }} turma(s) disponível(is)</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

        {{-- Turmas --}}
        @if($turmas->count() > 0)
            <div>
                <h2 class="text-2xl font-bold text-foreground mb-6 flex items-center gap-3">
                    <div class="icon-box icon-box-sm bg-accent/10">
                        <i data-lucide="calendar" class="w-4 h-4 text-accent"></i>
                    </div>
                    Turmas Disponíveis
                </h2>
                
                <div class="grid lg:grid-cols-2 gap-6">
                    @forelse($turmas as $turma)
                        <div class="feature-card hover:shadow-lg transition-shadow">
                            <div class="p-6">
                                {{-- Header --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-foreground">{{ $turma->referencia ?? 'Turma ' . $turma->id }}</h3>
                                        @if($turma->centro)
                                            <p class="text-sm text-muted-foreground flex items-center gap-1.5 mt-1">
                                                <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                                {{ $turma->centro->nome }}
                                            </p>
                                        @endif
                                    </div>
                                    @if($turma->status)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100/50 text-green-700 border border-green-200/50">
                                            {{ $turma->status }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Details --}}
                                <div class="space-y-3 mb-5 py-4 border-y border-border">
                                    @if($turma->data_arranque)
                                        <div class="flex items-center gap-3 text-sm">
                                            <i data-lucide="calendar" class="w-4 h-4 text-accent"></i>
                                            <span><span class="font-semibold text-foreground">Início:</span> {{ $turma->data_arranque->format('d/m/Y') }}</span>
                                        </div>
                                    @endif
                                    @if($turma->data_fim)
                                        <div class="flex items-center gap-3 text-sm">
                                            <i data-lucide="calendar" class="w-4 h-4 text-accent"></i>
                                            <span><span class="font-semibold text-foreground">Término:</span> {{ $turma->data_fim->format('d/m/Y') }}</span>
                                        </div>
                                    @endif
                                    @if($turma->formador)
                                        <div class="flex items-center gap-3 text-sm">
                                            <i data-lucide="user" class="w-4 h-4 text-accent"></i>
                                            <span><span class="font-semibold text-foreground">Formador:</span> {{ $turma->formador->nome }}</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Footer --}}
                                <div class="flex items-center justify-between">
                                    <div>
                                        @if($turma->preco)
                                            <span class="text-xl font-black text-brand-700">
                                                {{ number_format($turma->preco, 0, ',', '.') }} <span class="text-sm font-semibold">Kz</span>
                                            </span>
                                        @else
                                            <span class="text-sm text-slate-400 italic">Consultar preço</span>
                                        @endif
                                    </div>
                                    <a href="#contato" class="btn-secondary btn-sm">
                                        <i data-lucide="send" class="w-3 h-3"></i>
                                        Inscrever
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="lg:col-span-2 text-center py-12">
                            <i data-lucide="inbox" class="w-12 h-12 text-muted-foreground mx-auto mb-4 opacity-50"></i>
                            <p class="text-muted-foreground">Nenhuma turma disponível no momento</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <i data-lucide="inbox" class="w-12 h-12 text-muted-foreground mx-auto mb-4 opacity-50"></i>
                <p class="text-muted-foreground">Nenhuma turma disponível para este curso</p>
            </div>
        @endif

    </div>
</div>

@endsection
