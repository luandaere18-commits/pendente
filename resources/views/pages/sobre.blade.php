@extends('layouts.public')

@section('title', 'Sobre Nós — MC-COMERCIAL')

@section('content')

{{-- Header with Image --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1600&q=80" alt="Sobre">
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
                {{-- Floating Badge --}}
                <div class="absolute -bottom-6 -left-6 p-5 rounded-2xl bg-white shadow-2xl border border-slate-100 animate-float-slow">
                    <div class="text-3xl font-black text-brand-700 font-heading">10+</div>
                    <div class="text-xs text-slate-500 font-medium">Anos de<br>Experiência</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Timeline --}}
<section class="section bg-slate-50">
    <div class="container-tight">
        <div class="section-header reveal">
            <span class="badge-gold mb-4">
                <i data-lucide="clock" class="w-3 h-3"></i>
                Nossa Jornada
            </span>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-4 font-heading">Marcos Históricos</h2>
        </div>
        <div class="max-w-2xl mx-auto">
            <div class="timeline">
                @foreach([
                    ['year' => '2012', 'title' => 'Fundação', 'desc' => 'Início das actividades com 2 salas de formação em Luanda.'],
                    ['year' => '2014', 'title' => 'Primeiro Centro', 'desc' => 'Inauguração do primeiro centro equipado com 5 cursos.'],
                    ['year' => '2016', 'title' => 'Expansão', 'desc' => 'Ampliação para 15 cursos em diversas áreas profissionais.'],
                    ['year' => '2018', 'title' => 'Reconhecimento', 'desc' => 'Certificação oficial como centro de formação de referência.'],
                    ['year' => '2020', 'title' => 'Inovação Digital', 'desc' => 'Implementação de formação híbrida e plataformas digitais.'],
                    ['year' => '2022', 'title' => 'Múltiplos Centros', 'desc' => 'Abertura de novos centros em diferentes províncias.'],
                    ['year' => '2024', 'title' => 'Parcerias', 'desc' => 'Parcerias internacionais para certificações globais.'],
                    ['year' => '2026', 'title' => 'Presente', 'desc' => '+500 alunos, +20 cursos, presença em várias províncias.'],
                ] as $i => $event)
                    <div class="timeline-item reveal" style="transition-delay: {{ $i * 80 }}ms;">
                        <div class="timeline-year">{{ $event['year'] }}</div>
                        <div class="timeline-title font-heading">{{ $event['title'] }}</div>
                        <div class="timeline-desc">{{ $event['desc'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Team --}}
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
                <div class="team-card reveal">
                    <div class="team-card-inner" style="min-height: 340px;">
                        {{-- Front --}}
                        <div class="team-card-front card p-0 overflow-hidden flex flex-col">
                            <div class="h-52 bg-gradient-to-br from-brand-500 to-brand-700 overflow-hidden relative">
                                @if($formador->foto_url)
                                    <img src="{{ $formador->foto_url }}" alt="{{ $formador->nome }}" class="w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-3xl font-black text-white">
                                            {{ substr($formador->nome, 0, 1) }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 flex-1 flex flex-col justify-center text-center">
                                <h3 class="text-base font-bold text-slate-900 font-heading">{{ $formador->nome }}</h3>
                                @if($formador->especialidade)
                                    <p class="text-xs text-brand-600 mt-1">{{ $formador->especialidade }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Back --}}
                        <div class="team-card-back card bg-gradient-to-br from-brand-700 to-brand-900 p-6 flex flex-col justify-center text-white">
                            <h3 class="text-base font-bold mb-2 font-heading">{{ $formador->nome }}</h3>
                            @if($formador->especialidade)
                                <p class="text-xs text-brand-200 mb-3">{{ $formador->especialidade }}</p>
                            @endif
                            @if($formador->bio)
                                <p class="text-xs text-blue-100/70 leading-relaxed mb-4 line-clamp-4">{{ $formador->bio }}</p>
                            @endif
                            @if($formador->email)
                                <p class="text-xs text-blue-200/60 flex items-center gap-1.5">
                                    <i data-lucide="mail" class="w-3 h-3"></i> {{ $formador->email }}
                                </p>
                            @endif
                            @if($formador->contactos && count($formador->contactos) > 0)
                                <p class="text-xs text-blue-200/60 flex items-center gap-1.5 mt-1">
                                    <i data-lucide="phone" class="w-3 h-3"></i> {{ $formador->contactos[0] ?? '' }}
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

{{-- CTA --}}
<section class="py-20 bg-gradient-to-br from-brand-700 via-brand-800 to-brand-950 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-5"></div>
    <div class="container-tight text-center relative z-10 reveal">
        <h2 class="text-3xl font-bold tracking-tight mb-4 font-heading">Junte-se à nossa comunidade</h2>
        <p class="text-blue-100/60 mb-8 max-w-lg mx-auto">Faça parte da nossa história de sucesso.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('site.cursos') }}" class="btn bg-white text-brand-700 hover:bg-brand-50 btn-lg shadow-xl group">
                <i data-lucide="graduation-cap" class="w-5 h-5"></i> Ver Cursos
            </a>
            <a href="{{ route('site.contactos') }}" class="btn-outline-white btn-lg">
                <i data-lucide="phone" class="w-5 h-5"></i> Contactar
            </a>
        </div>
    </div>
</section>

@endsection
