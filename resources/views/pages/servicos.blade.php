@extends('layouts.public')

@section('title', 'Serviços — MC-COMERCIAL')

@section('content')

{{-- Header --}}
<section class="relative pt-12 pb-16 bg-gradient-to-br from-brand-700 to-brand-900 text-white -mt-20 pt-32 overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-5"></div>
    <div class="container-wide relative">
        <nav class="flex items-center gap-2 text-xs text-blue-200/60 mb-4">
            <a href="{{ route('site.home') }}" class="hover:text-white transition-colors">Início</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white font-medium">Serviços</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3">Nossos Serviços</h1>
        <p class="text-blue-100/70">Soluções completas de formação profissional para indivíduos e empresas.</p>
    </div>
</section>

{{-- Services --}}
<section class="section">
    <div class="container-wide">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
            @php
                $services = [
                    ['icon' => 'graduation-cap', 'title' => 'Formação Profissional',  'desc' => 'Cursos certificados em diversas áreas profissionais, com formação teórica e prática de qualidade.', 'img' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=400&q=60'],
                    ['icon' => 'building-2',     'title' => 'Formação Empresarial',    'desc' => 'Programas personalizados para empresas, focados nas necessidades específicas de cada organização.', 'img' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=400&q=60'],
                    ['icon' => 'monitor',        'title' => 'Workshops & Seminários',  'desc' => 'Sessões práticas e intensivas sobre temas atuais e relevantes para o mercado.', 'img' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=400&q=60'],
                    ['icon' => 'file-check',     'title' => 'Consultoria',             'desc' => 'Apoio especializado em gestão, planeamento e desenvolvimento organizacional.', 'img' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=400&q=60'],
                    ['icon' => 'book-open',      'title' => 'Formação à Medida',       'desc' => 'Cursos desenhados especificamente para atender às suas necessidades particulares.', 'img' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=400&q=60'],
                    ['icon' => 'award',          'title' => 'Certificações',           'desc' => 'Emissão de certificados reconhecidos pelo mercado de trabalho angolano.', 'img' => 'https://images.unsplash.com/photo-1573164574511-73c773193279?auto=format&fit=crop&w=400&q=60'],
                ];
            @endphp

            @foreach($services as $s)
                <div class="card card-interactive p-0 overflow-hidden reveal group">
                    <div class="h-40 overflow-hidden img-overlay-zoom">
                        <img src="{{ $s['img'] }}" alt="{{ $s['title'] }}" class="w-full h-full object-cover" loading="lazy">
                    </div>
                    <div class="p-6">
                        <div class="w-12 h-12 rounded-xl bg-brand-100 flex items-center justify-center mb-4 -mt-10 relative z-10 shadow-md border-2 border-white group-hover:bg-brand-600 group-hover:scale-110 transition-all duration-300">
                            <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5 text-brand-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors">{{ $s['title'] }}</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">{{ $s['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="section bg-gradient-to-br from-brand-600 to-brand-800 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-5"></div>
    <div class="container-tight text-center relative">
        <div class="reveal">
            <h2 class="text-3xl font-bold tracking-tight mb-4">Precisa de um serviço personalizado?</h2>
            <p class="text-blue-100/70 mb-8 max-w-lg mx-auto">Entre em contacto connosco para discutir como podemos ajudar a sua empresa ou projecto.</p>
            <a href="{{ route('site.contactos') }}" class="btn bg-white text-brand-700 hover:bg-brand-50 btn-lg shadow-lg">
                <i data-lucide="mail" class="w-5 h-5"></i>
                Contacte-nos
            </a>
        </div>
    </div>
</section>

@endsection
