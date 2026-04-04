@extends('layouts.public')

@section('title', 'Sobre Nós — MC-COMERCIAL')

@section('content')

{{-- Header --}}
<section class="relative pt-12 pb-16 bg-gradient-to-br from-brand-700 to-brand-900 text-white -mt-20 pt-32 overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-5"></div>
    <div class="container-wide relative">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Sobre Nós</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3">Sobre a MC-COMERCIAL</h1>
        <p class="text-blue-100/70">Conheça a nossa história, missão e equipa.</p>
    </div>
</section>

{{-- Mission --}}
<section class="section">
    <div class="container-wide">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="reveal">
                <span class="badge-brand mb-5">A Nossa Missão</span>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-6">Formar profissionais de excelência para o mercado angolano</h2>
                <div class="space-y-4 text-slate-500 leading-relaxed">
                    <p>A MC-COMERCIAL é um centro de formação profissional com mais de 10 anos de experiência, dedicado a preparar profissionais qualificados e competentes para os desafios do mercado de trabalho em Angola.</p>
                    <p>A nossa abordagem combina formação teórica sólida com experiência prática, garantindo que os nossos formandos estejam prontos para contribuir imediatamente nas suas áreas de atuação.</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-8">
                    @foreach([
                        ['icon' => 'target',   'title' => 'Missão',  'desc' => 'Formar profissionais qualificados'],
                        ['icon' => 'eye',      'title' => 'Visão',   'desc' => 'Referência em formação profissional'],
                        ['icon' => 'heart',    'title' => 'Valores',  'desc' => 'Excelência, ética e inovação'],
                        ['icon' => 'shield',   'title' => 'Compromisso', 'desc' => 'Qualidade e resultados'],
                    ] as $item)
                        <div class="p-4 rounded-xl bg-brand-50 border border-brand-100 hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                            <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 text-brand-600 mb-2"></i>
                            <h4 class="text-sm font-bold text-slate-900 mb-1">{{ $item['title'] }}</h4>
                            <p class="text-xs text-slate-500">{{ $item['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="reveal relative">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=600&q=70"
                         alt="Equipa MC-COMERCIAL" class="rounded-2xl shadow-lg w-full aspect-[3/4] object-cover" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=70"
                         alt="Formação" class="rounded-2xl shadow-lg w-full aspect-[3/4] object-cover mt-8" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Team — Hover Flip Cards --}}
@if(isset($formadores) && $formadores->count())
<section class="section bg-slate-50/50">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge-brand mb-4">
                <i data-lucide="users" class="w-3 h-3"></i>
                A Nossa Equipa
            </span>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-4">Formadores Qualificados</h2>
            <p class="text-slate-500">Passe o mouse sobre os perfis para ver mais detalhes.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 reveal-stagger">
            @foreach($formadores->take(8) as $formador)
                <div class="team-card reveal" x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false">
                    <div class="team-card-inner" :class="hovered ? 'rotate-y-180' : ''" style="min-height: 320px;">
                        {{-- Front --}}
                        <div class="team-card-front card p-0 overflow-hidden flex flex-col" style="backface-visibility: hidden;">
                            <div class="h-48 bg-gradient-to-br from-brand-500 to-brand-700 overflow-hidden relative">
                                @if($formador->foto)
                                    <img src="{{ asset('storage/' . $formador->foto) }}" alt="{{ $formador->nome }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i data-lucide="user" class="w-16 h-16 text-white/30"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 text-center flex-1 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-slate-900 mb-1">{{ $formador->nome }}</h3>
                                @if($formador->especialidade)
                                    <p class="text-xs text-brand-600 font-medium">{{ $formador->especialidade }}</p>
                                @endif
                                <p class="text-[10px] text-slate-400 mt-2">
                                    <i data-lucide="rotate-3d" class="w-3 h-3 inline"></i> Passe o mouse
                                </p>
                            </div>
                        </div>

                        {{-- Back --}}
                        <div class="team-card-back card p-6 flex flex-col justify-center items-center text-center bg-gradient-to-br from-brand-600 to-brand-800 text-white"
                             style="backface-visibility: hidden; transform: rotateY(180deg);">
                            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center mb-4">
                                @if($formador->foto)
                                    <img src="{{ asset('storage/' . $formador->foto) }}" alt="{{ $formador->nome }}"
                                         class="w-full h-full object-cover rounded-2xl">
                                @else
                                    <i data-lucide="user" class="w-8 h-8 text-white/60"></i>
                                @endif
                            </div>
                            <h3 class="text-base font-bold mb-1">{{ $formador->nome }}</h3>
                            @if($formador->especialidade)
                                <p class="text-sm text-blue-200 mb-3">{{ $formador->especialidade }}</p>
                            @endif
                            @if($formador->bio)
                                <p class="text-xs text-blue-100/70 leading-relaxed mb-3">{{ Str::limit($formador->bio, 120) }}</p>
                            @endif
                            @if($formador->email)
                                <a href="mailto:{{ $formador->email }}" class="text-xs text-white/80 hover:text-white flex items-center gap-1">
                                    <i data-lucide="mail" class="w-3 h-3"></i> {{ $formador->email }}
                                </a>
                            @endif
                            @if($formador->telefone)
                                <span class="text-xs text-white/70 flex items-center gap-1 mt-1">
                                    <i data-lucide="phone" class="w-3 h-3"></i> {{ $formador->telefone }}
                                </span>
                            @endif
                            @if($formador->experiencia)
                                <span class="badge bg-white/20 text-white mt-3 text-[10px]">
                                    {{ $formador->experiencia }} de experiência
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Timeline / History --}}
<section class="section bg-white">
    <div class="container-tight">
        <div class="section-header reveal">
            <span class="badge-brand mb-4">A Nossa História</span>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-4">Uma jornada de excelência</h2>
        </div>

        <div class="relative">
            <div class="absolute left-1/2 -translate-x-1/2 top-0 bottom-0 w-0.5 bg-brand-200 hidden lg:block"></div>
            @foreach([
                ['year' => '2013', 'title' => 'Fundação', 'desc' => 'Início das atividades com foco em formação profissional de qualidade em Luanda.'],
                ['year' => '2016', 'title' => 'Expansão', 'desc' => 'Abertura de novos centros e ampliação da oferta de cursos.'],
                ['year' => '2019', 'title' => 'Reconhecimento', 'desc' => 'Certificação oficial e parcerias com empresas líderes do mercado.'],
                ['year' => '2024', 'title' => 'Inovação', 'desc' => 'Introdução de plataformas digitais e formação híbrida.'],
            ] as $i => $event)
                <div class="relative lg:grid lg:grid-cols-2 gap-8 mb-12 reveal {{ $i % 2 === 0 ? '' : 'lg:direction-rtl' }}">
                    <div class="{{ $i % 2 === 0 ? 'lg:text-right lg:pr-12' : 'lg:col-start-2 lg:pl-12' }}">
                        <span class="badge-brand mb-3">{{ $event['year'] }}</span>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $event['title'] }}</h3>
                        <p class="text-sm text-slate-500">{{ $event['desc'] }}</p>
                    </div>
                    <div class="hidden lg:flex absolute left-1/2 -translate-x-1/2 top-2 w-4 h-4 rounded-full bg-brand-600 border-4 border-white shadow-md"></div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
