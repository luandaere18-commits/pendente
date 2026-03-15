@extends('layouts.public')

@section('title', 'Sobre Nós - MC-COMERCIAL')

@section('content')

{{-- Page Hero --}}
<div class="bg-gradient-to-br from-primary via-primary/90 to-primary/80 py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-accent blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 text-center text-primary-foreground relative">
        <h1 class="text-4xl lg:text-5xl font-extrabold mb-4">Sobre a MC-COMERCIAL</h1>
        <p class="text-lg opacity-80 max-w-2xl mx-auto">Mais de 10 anos formando profissionais de excelência em Angola</p>
    </div>
</div>

<div class="py-16 bg-background">
    <div class="container mx-auto px-4">

        {{-- História --}}
        <section class="mb-20 reveal">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-accent mb-3 block">Nossa Jornada</span>
                    <h2 class="text-3xl font-extrabold text-foreground mb-6">Uma história de excelência e dedicação</h2>
                    <div class="space-y-4 text-muted-foreground leading-relaxed">
                        <p>Fundada há mais de 10 anos em Luanda, Angola, a MC-COMERCIAL nasceu da visão de criar um centro de formação profissional que verdadeiramente preparasse os angolanos para os desafios do mercado de trabalho moderno.</p>
                        <p>Desde a nossa fundação, já formámos mais de 500 profissionais qualificados que hoje atuam em empresas de referência em Angola e no exterior.</p>
                        <p>Ao longo dos anos, expandimos a nossa oferta formativa para incluir cursos em Tecnologia, Administração, Marketing, Finanças e Vendas, sempre com formadores experientes e metodologias atualizadas.</p>
                    </div>
                    <div class="flex flex-wrap gap-6 mt-8">
                        <div class="text-center">
                            <div class="text-3xl font-extrabold gradient-text">500+</div>
                            <div class="text-xs text-muted-foreground mt-1">Alunos formados</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-extrabold gradient-text">10+</div>
                            <div class="text-xs text-muted-foreground mt-1">Anos de experiência</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-extrabold gradient-text">100%</div>
                            <div class="text-xs text-muted-foreground mt-1">Taxa de aprovação</div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="rounded-2xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=900&q=80"
                             alt="Sobre a MC-COMERCIAL" class="w-full h-80 object-cover"
                             loading="lazy">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-accent text-white rounded-2xl p-5 shadow-xl">
                        <div class="text-2xl font-extrabold">10+</div>
                        <div class="text-xs opacity-80">Anos de excelência</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Missão e Visão --}}
        <section class="mb-20">
            <div class="grid md:grid-cols-2 gap-6">
                <div class="feature-card group reveal">
                    <div class="w-14 h-14 rounded-2xl bg-primary/10 group-hover:bg-primary flex items-center justify-center mb-5 transition-all duration-300">
                        <i data-lucide="target" class="w-7 h-7 text-primary group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-foreground mb-3 group-hover:text-primary transition-colors">Nossa Missão</h3>
                    <p class="text-muted-foreground leading-relaxed">
                        Proporcionar formação profissional de qualidade, acessível e alinhada com as necessidades reais do mercado angolano, contribuindo para o desenvolvimento do capital humano do país.
                    </p>
                </div>
                <div class="feature-card group reveal">
                    <div class="w-14 h-14 rounded-2xl bg-accent/10 group-hover:bg-accent flex items-center justify-center mb-5 transition-all duration-300">
                        <i data-lucide="eye" class="w-7 h-7 text-accent group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-foreground mb-3 group-hover:text-accent transition-colors">Nossa Visão</h3>
                    <p class="text-muted-foreground leading-relaxed">
                        Ser a referência nacional em formação profissional, reconhecida pela qualidade dos seus cursos, pela competência dos seus formadores e pelo sucesso dos seus formandos.
                    </p>
                </div>
            </div>
        </section>

        {{-- Valores --}}
        <section class="mb-20">
            <div class="text-center mb-12 reveal">
                <span class="text-xs font-bold uppercase tracking-widest text-accent mb-3 block">O que nos guia</span>
                <h2 class="section-title">Nossos Valores</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @php
                    $valores = [
                        ['icon' => 'award',       'title' => 'Excelência',    'desc' => 'Buscamos sempre o mais alto padrão de qualidade em tudo que fazemos.'],
                        ['icon' => 'heart',       'title' => 'Compromisso',   'desc' => 'Comprometidos com o sucesso e crescimento de cada formando.'],
                        ['icon' => 'lightbulb',   'title' => 'Inovação',      'desc' => 'Metodologias modernas alinhadas com as tendências globais.'],
                        ['icon' => 'handshake',   'title' => 'Integridade',   'desc' => 'Transparência e honestidade em todas as nossas relações.'],
                    ];
                @endphp
                @foreach($valores as $valor)
                    <div class="feature-card text-center group reveal">
                        <div class="w-14 h-14 rounded-2xl bg-accent/10 group-hover:bg-accent flex items-center justify-center mx-auto mb-4 transition-all duration-300 group-hover:scale-110">
                            <i data-lucide="{{ $valor['icon'] }}" class="w-7 h-7 text-accent group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <h4 class="font-extrabold text-foreground mb-2 group-hover:text-accent transition-colors">{{ $valor['title'] }}</h4>
                        <p class="text-sm text-muted-foreground leading-relaxed">{{ $valor['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Equipa — hover elegante com tooltip/card lateral --}}
        <section class="mb-20">
            <div class="text-center mb-12 reveal">
                <span class="text-xs font-bold uppercase tracking-widest text-accent mb-3 block">Quem nos representa</span>
                <h2 class="section-title">Nossa Equipa</h2>
                <p class="section-subtitle">Passe o rato sobre cada membro para conhecê-lo melhor</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($formadores as $formador)
                    <div class="member-card group relative bg-card border border-border rounded-2xl overflow-hidden reveal cursor-default
                                shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">

                        {{-- Conteúdo normal --}}
                        <div class="p-6 text-center">
                            <div class="relative inline-block mb-4">
                                <img src="{{ $formador->foto_url }}" alt="{{ $formador->nome }}"
                                     class="w-24 h-24 rounded-2xl object-cover mx-auto ring-4 ring-accent/20 group-hover:ring-accent/50 transition-all duration-300"
                                     loading="lazy"
                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($formador->nome) }}&background=3A4BA5&color=fff&size=96'">
                                <div class="absolute -bottom-2 -right-2 w-7 h-7 bg-success rounded-full border-2 border-card flex items-center justify-center">
                                    <i data-lucide="check" class="w-3 h-3 text-white"></i>
                                </div>
                            </div>
                            <h4 class="font-extrabold text-foreground mb-1 group-hover:text-primary transition-colors">{{ $formador->nome }}</h4>
                            <p class="text-sm text-accent font-semibold mb-3">{{ $formador->especialidade }}</p>
                            <p class="text-sm text-muted-foreground leading-relaxed line-clamp-2">{{ $formador->biografia }}</p>

                            {{-- Ações visíveis no hover --}}
                            <div class="flex items-center justify-center gap-2 mt-4 opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                @if($formador->linkedin ?? null)
                                    <a href="{{ $formador->linkedin }}" target="_blank" rel="noopener noreferrer"
                                       class="w-9 h-9 rounded-xl bg-primary/10 hover:bg-primary text-primary hover:text-white flex items-center justify-center transition-all duration-200">
                                        <i data-lucide="linkedin" class="w-4 h-4"></i>
                                    </a>
                                @endif
                                <a href="{{ route('site.contactos') }}"
                                   class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl text-sm font-semibold bg-primary text-primary-foreground h-9 hover:bg-primary/90 transition-all duration-200">
                                    <i data-lucide="mail" class="w-3.5 h-3.5"></i>Contactar
                                </a>
                            </div>
                        </div>

                        {{-- Linha de destaque no rodapé no hover --}}
                        <div class="h-1 bg-gradient-to-r from-accent to-primary scale-x-0 group-hover:scale-x-100 transition-transform duration-400 origin-left"></div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Certificações --}}
        <section class="reveal">
            <div class="bg-gradient-to-br from-primary/5 to-accent/5 rounded-2xl p-10 text-center border border-border">
                <div class="w-16 h-16 rounded-2xl bg-accent/10 flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="award" class="w-8 h-8 text-accent"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-foreground mb-3">Certificação Reconhecida</h2>
                <p class="text-muted-foreground max-w-lg mx-auto mb-6 leading-relaxed">
                    Os nossos cursos são certificados e reconhecidos pelas entidades competentes, garantindo a qualidade e o valor da formação obtida na MC-COMERCIAL em Angola e no exterior.
                </p>
                <a href="{{ route('site.cursos') }}"
                   class="inline-flex items-center gap-2 rounded-xl text-sm font-bold bg-primary text-primary-foreground h-11 px-8 hover:bg-primary/90 active:scale-95 transition-all duration-200">
                    <i data-lucide="book-open" class="w-4 h-4"></i>Ver Turmas com Certificação
                </a>
            </div>
        </section>

    </div>
</div>
@endsection
