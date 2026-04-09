@extends('layouts.public')

@section('title', 'Serviços — MC-COMERCIAL')

@section('content')

{{-- Header with Image --}}
<section class="section-hero text-white">
    <div class="section-hero-bg">
        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1600&q=80" alt="Serviços">
    </div>
    <div class="container-wide">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4 reveal">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Serviços</span>
        </nav>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4 font-heading reveal">Nossos Serviços</h1>
        <p class="text-blue-100/60 max-w-lg reveal">Soluções completas de formação profissional para indivíduos e empresas.</p>
    </div>
</section>

{{-- Services Grid --}}
<section class="section bg-mesh">
    <div class="container-wide">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 reveal-stagger">
            @php
                $services = [
                    ['icon' => 'graduation-cap', 'title' => 'Formação Profissional',  'desc' => 'Cursos certificados em diversas áreas profissionais, com formação teórica e prática de qualidade comprovada.', 'img' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=60', 'features' => ['Certificação oficial', 'Material incluído', 'Avaliação contínua']],
                    ['icon' => 'building-2',     'title' => 'Formação Empresarial',    'desc' => 'Programas personalizados para empresas, focados nas necessidades específicas de cada organização.', 'img' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=600&q=60', 'features' => ['In-company', 'Personalizado', 'Flexível']],
                    ['icon' => 'monitor',        'title' => 'Workshops & Seminários',  'desc' => 'Sessões práticas e intensivas sobre temas actuais e relevantes para o mercado.', 'img' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=600&q=60', 'features' => ['Hands-on', 'Networking', 'Actualizado']],
                    ['icon' => 'file-check',     'title' => 'Consultoria',             'desc' => 'Apoio especializado em gestão, planeamento e desenvolvimento organizacional.', 'img' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=600&q=60', 'features' => ['Diagnóstico', 'Estratégia', 'Acompanhamento']],
                    ['icon' => 'book-open',      'title' => 'Formação à Medida',       'desc' => 'Cursos desenhados especificamente para atender às suas necessidades particulares.', 'img' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=60', 'features' => ['Sob medida', 'Objectivos claros', 'Resultados']],
                    ['icon' => 'award',          'title' => 'Certificações',           'desc' => 'Emissão de certificados reconhecidos pelo mercado de trabalho angolano.', 'img' => 'https://images.unsplash.com/photo-1573164574511-73c773193279?auto=format&fit=crop&w=600&q=60', 'features' => ['Reconhecido', 'Oficial', 'Válido']],
                ];
            @endphp

            @foreach($services as $s)
                <div class="card p-0 overflow-hidden reveal group hover-lift">
                    <div class="h-48 overflow-hidden img-overlay-zoom relative">
                        <img src="{{ $s['img'] }}" alt="{{ $s['title'] }}" class="w-full h-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <div class="w-14 h-14 rounded-2xl bg-brand-100 flex items-center justify-center -mt-12 relative z-10 shadow-lg border-4 border-white group-hover:bg-brand-600 group-hover:scale-110 transition-all duration-300">
                            <i data-lucide="{{ $s['icon'] }}" class="w-6 h-6 text-brand-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mt-4 mb-3 group-hover:text-brand-600 transition-colors font-heading">{{ $s['title'] }}</h3>
                        <p class="text-sm text-slate-500 leading-relaxed mb-4">{{ $s['desc'] }}</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($s['features'] as $feat)
                                <span class="badge-brand text-[10px]">{{ $feat }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Process --}}
<section class="section bg-white">
    <div class="container-tight">
        <div class="section-header reveal">
            <span class="badge-brand mb-4">
                <i data-lucide="settings" class="w-3 h-3"></i>
                Como Funciona
            </span>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-4 font-heading">Processo Simples</h2>
        </div>
        <div class="grid sm:grid-cols-4 gap-8 reveal-stagger">
            @foreach([
                ['step' => '01', 'title' => 'Escolha', 'desc' => 'Seleccione o curso ou serviço ideal para si', 'icon' => 'search'],
                ['step' => '02', 'title' => 'Inscrição', 'desc' => 'Faça a sua pré-inscrição online ou presencial', 'icon' => 'edit-3'],
                ['step' => '03', 'title' => 'Formação', 'desc' => 'Participe das aulas com formadores qualificados', 'icon' => 'book-open'],
                ['step' => '04', 'title' => 'Certificação', 'desc' => 'Receba o seu certificado reconhecido', 'icon' => 'award'],
            ] as $proc)
                <div class="text-center reveal group">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-100 to-brand-200 flex items-center justify-center mx-auto mb-4 group-hover:from-brand-600 group-hover:to-brand-700 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <i data-lucide="{{ $proc['icon'] }}" class="w-7 h-7 text-brand-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <span class="text-xs font-bold text-brand-400 mb-1 block">{{ $proc['step'] }}</span>
                    <h4 class="text-base font-bold text-slate-900 mb-2 font-heading">{{ $proc['title'] }}</h4>
                    <p class="text-xs text-slate-500">{{ $proc['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-gradient-to-br from-brand-700 via-brand-800 to-brand-950 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-5"></div>
    <div class="container-tight text-center relative z-10 reveal">
        <h2 class="text-3xl font-bold tracking-tight mb-4 font-heading">Precisa de um serviço personalizado?</h2>
        <p class="text-blue-100/60 mb-8 max-w-lg mx-auto">Entre em contacto connosco para discutir como podemos ajudar.</p>
        <a href="{{ route('site.contactos') }}" class="btn bg-white text-brand-700 hover:bg-brand-50 btn-lg shadow-xl group">
            <i data-lucide="mail" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
            Contacte-nos
        </a>
    </div>
</section>

@endsection
