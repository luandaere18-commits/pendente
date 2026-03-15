@extends('layouts.public')

@section('title', 'Sobre Nós - MC-COMERCIAL')

@section('content')
<div class="py-12 bg-background min-h-screen">
    <div class="container mx-auto px-4">

        {{-- História --}}
        <section class="mb-16">
            <div class="text-center mb-10">
                <h1 class="section-title">Sobre a MC-COMERCIAL</h1>
                <p class="section-subtitle">Mais de 10 anos formando profissionais de excelência</p>
            </div>
            <div class="max-w-3xl mx-auto feature-card">
                <h2 class="text-2xl font-bold text-foreground mb-4">Nossa História</h2>
                <div class="space-y-4 text-muted-foreground leading-relaxed">
                    <p>Fundada há mais de 10 anos em Luanda, Angola, a MC-COMERCIAL nasceu da visão de criar um centro de formação profissional que verdadeiramente preparasse os angolanos para os desafios do mercado de trabalho moderno.</p>
                    <p>Desde a nossa fundação, já formámos mais de 500 profissionais qualificados que hoje atuam em empresas de referência em Angola e no exterior. O nosso compromisso com a qualidade e a inovação fez-nos crescer de um pequeno centro em Viana para uma rede com múltiplos centros de formação.</p>
                    <p>Ao longo dos anos, expandimos a nossa oferta formativa para incluir cursos em Tecnologia, Administração, Marketing, Finanças e Vendas, sempre com formadores experientes e metodologias atualizadas.</p>
                </div>
            </div>
        </section>

        {{-- Missão e Visão --}}
        <section class="mb-16">
            <div class="grid md:grid-cols-2 gap-6">
                <div class="feature-card">
                    <div class="w-12 h-12 rounded-lg bg-accent/10 flex items-center justify-center mb-4">
                        <i data-lucide="target" class="w-6 h-6 text-accent"></i>
                    </div>
                    <h3 class="text-xl font-bold text-foreground mb-3">Missão</h3>
                    <p class="text-muted-foreground leading-relaxed">
                        Proporcionar formação profissional de excelência, preparando indivíduos com competências técnicas e humanas para se destacarem no mercado de trabalho angolano e internacional.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="w-12 h-12 rounded-lg bg-accent/10 flex items-center justify-center mb-4">
                        <i data-lucide="eye" class="w-6 h-6 text-accent"></i>
                    </div>
                    <h3 class="text-xl font-bold text-foreground mb-3">Visão</h3>
                    <p class="text-muted-foreground leading-relaxed">
                        Ser a referência nacional em formação profissional, reconhecida pela qualidade dos seus cursos, pela competência dos seus formadores e pelo sucesso dos seus formandos.
                    </p>
                </div>
            </div>
        </section>

        {{-- Valores --}}
        <section class="mb-16">
            <div class="text-center mb-10">
                <h2 class="section-title">Nossos Valores</h2>
                <p class="section-subtitle">Os princípios que guiam a nossa atuação</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $valores = [
                        ['icon' => 'star', 'title' => 'Excelência', 'desc' => 'Busca constante pela qualidade em tudo que fazemos'],
                        ['icon' => 'users', 'title' => 'Compromisso', 'desc' => 'Dedicação total ao sucesso dos nossos formandos'],
                        ['icon' => 'heart', 'title' => 'Integridade', 'desc' => 'Ética e transparência em todas as relações'],
                        ['icon' => 'book-open', 'title' => 'Inovação', 'desc' => 'Atualização permanente de conteúdos e metodologias'],
                    ];
                @endphp
                @foreach($valores as $valor)
                    <div class="feature-card text-center">
                        <div class="w-14 h-14 rounded-xl bg-accent/10 flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="{{ $valor['icon'] }}" class="w-7 h-7 text-accent"></i>
                        </div>
                        <h4 class="font-bold text-foreground mb-2">{{ $valor['title'] }}</h4>
                        <p class="text-sm text-muted-foreground">{{ $valor['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Equipa --}}
        <section class="mb-16">
            <div class="text-center mb-10">
                <h2 class="section-title">Nossa Equipa</h2>
                <p class="section-subtitle">Formadores experientes e dedicados</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($formadores as $formador)
                    <div class="feature-card text-center">
                        <img src="{{ $formador->foto_url }}" alt="{{ $formador->nome }}" class="w-24 h-24 rounded-full object-cover mx-auto mb-4 ring-4 ring-accent/20" loading="lazy">
                        <h4 class="font-bold text-foreground">{{ $formador->nome }}</h4>
                        <p class="text-sm text-accent font-medium mb-2">{{ $formador->especialidade }}</p>
                        <p class="text-sm text-muted-foreground leading-relaxed">{{ $formador->biografia }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Certificações --}}
        <section>
            <div class="text-center mb-10">
                <h2 class="section-title">Certificações</h2>
                <p class="section-subtitle">Reconhecidos pelo mercado</p>
            </div>
            <div class="feature-card text-center">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <i data-lucide="award" class="w-10 h-10 text-accent"></i>
                </div>
                <p class="text-muted-foreground">Os nossos cursos são certificados e reconhecidos pelas entidades competentes, garantindo a qualidade e o valor da formação obtida na MC-COMERCIAL.</p>
            </div>
        </section>
    </div>
</div>
@endsection
