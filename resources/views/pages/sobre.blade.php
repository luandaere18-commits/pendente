@extends('layouts.public')

@section('title', 'Sobre Nós — MC-COMERCIAL')

@section('content')

{{-- Header com fundo_imagem.jpg --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="{{ asset('images/fundo_imagem.jpg') }}" alt="Sobre">
    </div>
    <div class="container-wide">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4 reveal">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Sobre Nós</span>
        </nav>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4 font-heading reveal">Sobre a MC-COMERCIAL</h1>
        <p class="text-blue-100/60 max-w-lg reveal">Conheça a nossa história, missão, valores e equipa.</p>
    </div>
</section>

{{-- Mission --}}
<section class="section bg-white">
    <div class="container-wide">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="reveal-left">
                <span class="badge-brand mb-5">A Nossa Missão</span>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-6 font-heading">Formar profissionais de excelência para o mercado angolano</h2>
                <div class="space-y-4 text-slate-500 leading-relaxed">
                    <p>A MC-COMERCIAL é um centro de formação profissional com mais de 10 anos de experiência, dedicado a preparar profissionais qualificados e competentes para os desafios do mercado de trabalho em Angola.</p>
                    <p>A nossa abordagem combina formação teórica sólida com experiência prática, garantindo que os nossos formandos estejam prontos para contribuir imediatamente nas suas áreas de atuação.</p>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-8">
                    @foreach([
                        ['icon' => 'target',   'title' => 'Missão',  'desc' => 'Formar profissionais qualificados para o mercado'],
                        ['icon' => 'eye',      'title' => 'Visão',   'desc' => 'Ser referência nacional em formação profissional'],
                        ['icon' => 'heart',    'title' => 'Valores',  'desc' => 'Excelência, ética, inovação e compromisso'],
                        ['icon' => 'shield',   'title' => 'Compromisso', 'desc' => 'Qualidade, resultados e satisfação total'],
                    ] as $item)
                        <div class="p-5 rounded-2xl bg-gradient-to-br from-brand-50 to-white border border-brand-100 hover:shadow-lg hover:-translate-y-2 transition-all duration-300 group">
                            <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center mb-3 group-hover:bg-brand-600 group-hover:scale-110 transition-all duration-300">
                                <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 text-brand-600 group-hover:text-white transition-colors"></i>
                            </div>
                            <h4 class="text-sm font-bold text-slate-900 mb-1 font-heading">{{ $item['title'] }}</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $item['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="reveal-right relative">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=600&q=70"
                         alt="Equipa MC-COMERCIAL" class="rounded-2xl shadow-2xl w-full aspect-[3/4] object-cover animate-float" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=70"
                         alt="Formação" class="rounded-2xl shadow-2xl w-full aspect-[3/4] object-cover mt-8 animate-float-reverse" loading="lazy">
                </div>
                <div class="absolute -bottom-6 -left-6 p-5 rounded-2xl bg-white shadow-2xl border border-slate-100 animate-float-slow">
                    <div class="text-3xl font-black text-brand-700 font-heading">10+</div>
                    <div class="text-xs text-slate-500 font-medium">Anos de<br>Experiência</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Timeline — Nossa Jornada (estilo alternado esquerda/direita com linha central) --}}
<section class="section bg-slate-50">
    <div class="container-tight">
        <div class="section-header reveal">
            <span class="badge-gold mb-4">A NOSSA HISTÓRIA</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4 font-heading">Uma jornada de excelência</h2>
            <p class="text-slate-500 max-w-lg mx-auto">Conheça os marcos importantes da nossa trajetória.</p>
        </div>

        <div class="relative max-w-4xl mx-auto">
            {{-- Linha central --}}
            <div class="absolute left-1/2 transform -translate-x-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-brand-200 via-brand-400 to-brand-200"></div>

            @foreach([
                ['year' => '2013', 'title' => 'Fundação', 'desc' => 'A MC-COMERCIAL foi fundada em Luanda com a missão de formar profissionais qualificados para o mercado angolano.'],
                ['year' => '2015', 'title' => 'Primeiro Certificado', 'desc' => 'Obtenção do primeiro certificado de reconhecimento oficial como centro de formação profissional.'],
                ['year' => '2017', 'title' => 'Expansão para Viana', 'desc' => 'Abertura do segundo centro de formação no município de Viana, expandindo o alcance para mais comunidades.'],
                ['year' => '2019', 'title' => 'Inovação Digital', 'desc' => 'Implementação de plataformas digitais de ensino e formação híbrida para maior acessibilidade.'],
                ['year' => '2021', 'title' => 'Parcerias Estratégicas', 'desc' => 'Estabelecimento de parcerias com empresas e instituições para certificações reconhecidas.'],
                ['year' => '2023', 'title' => 'Múltiplos Centros', 'desc' => 'Presença consolidada em várias províncias de Angola com centros de formação modernos.'],
                ['year' => '2025', 'title' => 'Referência Nacional', 'desc' => 'Mais de 500 alunos formados e reconhecimento como centro de formação de referência em Angola.'],
            ] as $i => $event)
                <div class="relative flex items-start mb-12 last:mb-0 reveal" style="transition-delay: {{ $i * 100 }}ms;">
                    {{-- Dot central --}}
                    <div class="absolute left-1/2 transform -translate-x-1/2 top-2 z-10">
                        <div class="w-4 h-4 rounded-full bg-brand-500 border-4 border-white shadow-md"></div>
                    </div>

                    @if($i % 2 === 0)
                        {{-- Lado esquerdo --}}
                        <div class="w-1/2 pr-12 text-right">
                            <span class="inline-block px-3 py-1 rounded-full bg-brand-50 text-brand-600 text-xs font-bold mb-2 border border-brand-200">{{ $event['year'] }}</span>
                            <h3 class="text-lg font-bold text-slate-900 mb-1 font-heading">{{ $event['title'] }}</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $event['desc'] }}</p>
                        </div>
                        <div class="w-1/2"></div>
                    @else
                        {{-- Lado direito --}}
                        <div class="w-1/2"></div>
                        <div class="w-1/2 pl-12">
                            <span class="inline-block px-3 py-1 rounded-full bg-brand-50 text-brand-600 text-xs font-bold mb-2 border border-brand-200">{{ $event['year'] }}</span>
                            <h3 class="text-lg font-bold text-slate-900 mb-1 font-heading">{{ $event['title'] }}</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $event['desc'] }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Team — Formadores com flip card circular --}}
@if(isset($formadores) && $formadores->count())
<section class="section bg-white">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="badge-brand mb-4">
                <i data-lucide="users" class="w-3 h-3"></i>
                A Nossa Equipa
            </span>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-4 font-heading">Formadores Qualificados</h2>
            <p class="text-slate-500">Passe o mouse para ver mais detalhes de cada formador.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 reveal-stagger">
            @foreach($formadores->take(8) as $formador)
                <div class="team-card reveal" style="min-height: 380px;">
                    <div class="team-card-inner" style="min-height: 380px;">
                        {{-- Frente: fundo azul gradiente superior, branco inferior, foto circular --}}
                        <div class="team-card-front flex flex-col" style="background: white;">
                            <div class="h-40 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center relative">
                                {{-- Foto circular posicionada na intersecção --}}
                                <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
                                    @if($formador->foto_url)
                                        <img src="{{ $formador->foto_url }}" alt="{{ $formador->nome }}"
                                             class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg">
                                    @else
                                        <div class="w-20 h-20 rounded-full bg-slate-100 border-4 border-white shadow-lg flex items-center justify-center">
                                            <i data-lucide="user" class="w-8 h-8 text-slate-400"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 flex flex-col items-center justify-center text-center pt-14 pb-6 px-4">
                                <h3 class="text-base font-bold text-slate-900 font-heading">{{ $formador->nome }}</h3>
                                @if($formador->especialidade)
                                    <p class="text-xs text-brand-600 mt-1">{{ $formador->especialidade }}</p>
                                @endif
                                <p class="text-[11px] text-slate-400 mt-3 flex items-center gap-1">
                                    <i data-lucide="rotate-cw" class="w-3 h-3"></i>
                                    Passe o mouse
                                </p>
                            </div>
                        </div>

                        {{-- Verso: fundo azul escuro com detalhes --}}
                        <div class="team-card-back flex flex-col justify-center items-center text-center text-white p-6"
                             style="background: linear-gradient(135deg, hsl(221 83% 53%), hsl(226 57% 21%));">
                            @if($formador->foto_url)
                                <img src="{{ $formador->foto_url }}" alt="{{ $formador->nome }}"
                                     class="w-16 h-16 rounded-full object-cover border-3 border-white/30 shadow-lg mb-3">
                            @else
                                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mb-3 border-2 border-white/30">
                                    <i data-lucide="user" class="w-7 h-7 text-white/70"></i>
                                </div>
                            @endif
                            <h3 class="text-base font-bold mb-1 font-heading">{{ $formador->nome }}</h3>
                            @if($formador->especialidade)
                                <p class="text-xs text-blue-200 mb-3">{{ $formador->especialidade }}</p>
                            @endif
                            @if($formador->bio)
                                <p class="text-xs text-blue-100/70 leading-relaxed mb-4 line-clamp-3">{{ $formador->bio }}</p>
                            @endif
                            @if($formador->email)
                                <p class="text-xs text-blue-200/80 flex items-center gap-1.5 mb-1">
                                    <i data-lucide="mail" class="w-3 h-3"></i> {{ $formador->email }}
                                </p>
                            @endif
                            @if($formador->telefone)
                                <p class="text-xs text-blue-200/80 flex items-center gap-1.5">
                                    <i data-lucide="phone" class="w-3 h-3"></i> {{ $formador->telefone }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
