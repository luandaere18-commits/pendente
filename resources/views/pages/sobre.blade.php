@extends('layouts.public')

@section('title', 'Sobre Nós - MC-COMERCIAL')

@section('content')

{{-- Page Hero --}}
<div class="page-hero text-center">
    <div class="container mx-auto px-4 relative z-10">
        <span class="section-tag text-accent-foreground/80 justify-center before:bg-white/40">
            <i data-lucide="users" class="w-3.5 h-3.5"></i> Quem Somos
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-5" style="letter-spacing: -0.03em;">Sobre a MC-COMERCIAL</h1>
        <p class="text-lg text-white/65 max-w-2xl mx-auto">Mais de 10 anos formando profissionais de excelência em Angola</p>
    </div>
</div>

<div class="py-20 bg-background">
    <div class="container mx-auto px-4">

        {{-- História --}}
        <section class="mb-24 reveal">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="section-tag">Nossa Jornada</span>
                    <h2 class="section-title">Uma história de excelência e dedicação</h2>
                    <div class="space-y-4 text-muted-foreground leading-relaxed">
                        <p>Fundada há mais de 10 anos em Luanda, Angola, a MC-COMERCIAL nasceu da visão de criar um centro de formação profissional que verdadeiramente preparasse os angolanos para os desafios do mercado de trabalho moderno.</p>
                        <p>Desde a nossa fundação, já formámos mais de 500 profissionais qualificados que hoje atuam em empresas de referência em Angola e no exterior.</p>
                        <p>Ao longo dos anos, expandimos a nossa oferta formativa para incluir cursos em Tecnologia, Administração, Marketing, Finanças e Vendas, sempre com formadores experientes e metodologias atualizadas.</p>
                    </div>
                    <div class="flex flex-wrap gap-8 mt-10">
                        <div class="text-center">
                            <div class="text-3xl font-extrabold gradient-text tabular-nums">500+</div>
                            <div class="text-xs text-muted-foreground mt-1 font-medium">Alunos formados</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-extrabold gradient-text tabular-nums">10+</div>
                            <div class="text-xs text-muted-foreground mt-1 font-medium">Anos de experiência</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-extrabold gradient-text">100%</div>
                            <div class="text-xs text-muted-foreground mt-1 font-medium">Taxa de aprovação</div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="rounded-2xl overflow-hidden" style="box-shadow: var(--shadow-xl);">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=900&q=80"
                             alt="Sobre a MC-COMERCIAL" class="w-full h-80 lg:h-96 object-cover"
                             loading="lazy">
                    </div>
                    {{-- Floating badge --}}
                    <div class="absolute -bottom-6 -left-6 rounded-2xl p-6 text-white animate-float"
                         style="background: var(--gradient-accent); box-shadow: var(--shadow-accent);">
                        <div class="text-3xl font-extrabold tabular-nums">10+</div>
                        <div class="text-xs opacity-80 font-medium">Anos de excelência</div>
                    </div>
                    {{-- Decorative dots --}}
                    <div class="absolute -top-4 -right-4 w-24 h-24 dots-pattern rounded-2xl opacity-40"></div>
                </div>
            </div>
        </section>

        {{-- Missão e Visão --}}
        <section class="mb-24">
            <div class="grid md:grid-cols-2 gap-6 reveal-stagger">
                <div class="feature-card group reveal">
                    <div class="icon-box icon-box-lg bg-primary/10 group-hover:bg-primary mb-6 transition-all duration-400 group-hover:scale-110">
                        <i data-lucide="target" class="w-7 h-7 text-primary group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-foreground mb-3 group-hover:text-primary transition-colors duration-300">Nossa Missão</h3>
                    <p class="text-muted-foreground leading-relaxed">
                        Proporcionar formação profissional de qualidade, acessível e alinhada com as necessidades reais do mercado angolano, contribuindo para o desenvolvimento do capital humano do país.
                    </p>
                </div>
                <div class="feature-card group reveal">
                    <div class="icon-box icon-box-lg bg-accent/10 group-hover:bg-accent mb-6 transition-all duration-400 group-hover:scale-110">
                        <i data-lucide="eye" class="w-7 h-7 text-accent group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-foreground mb-3 group-hover:text-accent transition-colors duration-300">Nossa Visão</h3>
                    <p class="text-muted-foreground leading-relaxed">
                        Ser a referência nacional em formação profissional, reconhecida pela qualidade dos seus cursos, pela competência dos seus formadores e pelo sucesso dos seus formandos.
                    </p>
                </div>
            </div>
        </section>

        {{-- Valores --}}
        <section class="mb-24">
            <div class="text-center mb-14 reveal">
                <span class="section-tag justify-center">O que nos guia</span>
                <h2 class="section-title text-center">Nossos Valores</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 reveal-stagger">
                @php
                    $valores = [
                        ['icon' => 'award',       'title' => 'Excelência',    'desc' => 'Buscamos sempre o mais alto padrão de qualidade em tudo que fazemos.'],
                        ['icon' => 'heart',       'title' => 'Compromisso',   'desc' => 'Comprometidos com o sucesso e crescimento de cada formando.'],
                        ['icon' => 'lightbulb',   'title' => 'Inovação',      'desc' => 'Metodologias modernas alinhadas com as tendências globais.'],
                        ['icon' => 'handshake',   'title' => 'Integridade',   'desc' => 'Transparência e honestidade em todas as nossas relações.'],
                    ];
                @endphp
                @foreach($valores as $valor)
                    <div class="glass-card text-center group reveal">
                        <div class="icon-box icon-box-lg bg-accent/10 group-hover:bg-accent mx-auto mb-5 transition-all duration-400 group-hover:scale-110 group-hover:rotate-6">
                            <i data-lucide="{{ $valor['icon'] }}" class="w-7 h-7 text-accent group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <h4 class="font-extrabold text-foreground mb-2 group-hover:text-accent transition-colors duration-300">{{ $valor['title'] }}</h4>
                        <p class="text-sm text-muted-foreground leading-relaxed">{{ $valor['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Equipa --}}
        <section class="mb-24">
            <div class="text-center mb-14 reveal">
                <span class="section-tag justify-center">Quem nos representa</span>
                <h2 class="section-title text-center">Nossa Equipa</h2>
                <p class="section-subtitle mx-auto text-center">Passe o rato sobre cada membro para conhecê-lo melhor</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 reveal-stagger">
                @foreach($formadores as $formador)
                    <div class="member-card group relative bg-card border border-border rounded-2xl overflow-hidden reveal cursor-default
                                hover:-translate-y-2 transition-all duration-400"
                         style="box-shadow: var(--shadow-sm);"
                         onmouseover="this.style.boxShadow='var(--shadow-xl)'"
                         onmouseout="this.style.boxShadow='var(--shadow-sm)'">

                        <div class="p-7 text-center">
                            <div class="relative inline-block mb-5">
                                <img src="{{ $formador->foto_url }}" alt="{{ $formador->nome }}"
                                     class="w-24 h-24 rounded-2xl object-cover mx-auto ring-4 ring-accent/15 group-hover:ring-accent/40 transition-all duration-400"
                                     loading="lazy"
                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($formador->nome) }}&background=3A4BA5&color=fff&size=96'">
                                <div class="absolute -bottom-2 -right-2 w-7 h-7 bg-success rounded-full border-2 border-card flex items-center justify-center">
                                    <i data-lucide="check" class="w-3 h-3 text-white"></i>
                                </div>
                            </div>
                            <h4 class="font-extrabold text-foreground mb-1 group-hover:text-primary transition-colors duration-300">{{ $formador->nome }}</h4>
                            <p class="text-sm text-accent font-semibold mb-3">{{ $formador->especialidade }}</p>
                            <p class="text-sm text-muted-foreground leading-relaxed line-clamp-2">{{ $formador->biografia }}</p>

                            {{-- Hover actions --}}
                            <div class="flex items-center justify-center gap-2 mt-5 opacity-0 group-hover:opacity-100 translate-y-3 group-hover:translate-y-0 transition-all duration-400">
                                @if($formador->linkedin ?? null)
                                    <a href="{{ $formador->linkedin }}" target="_blank" rel="noopener noreferrer"
                                       class="w-10 h-10 rounded-xl bg-primary/10 hover:bg-primary text-primary hover:text-white flex items-center justify-center transition-all duration-300">
                                        <i data-lucide="linkedin" class="w-4 h-4"></i>
                                    </a>
                                @endif
                                <a href="{{ route('site.contactos') }}"
                                   class="flex-1 btn-primary h-10 text-sm rounded-xl">
                                    <i data-lucide="mail" class="w-3.5 h-3.5"></i>Contactar
                                </a>
                            </div>
                        </div>

                        {{-- Accent line --}}
                        <div class="h-1 accent-line scale-x-0 group-hover:scale-x-100 origin-left" style="background: var(--gradient-accent);"></div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Certificações --}}
        <section class="reveal">
            <div class="glass-card p-12 text-center" style="background: linear-gradient(135deg, hsl(var(--primary) / 0.04), hsl(var(--accent) / 0.06));">
                <div class="icon-box icon-box-lg bg-accent/10 mx-auto mb-6 animate-float">
                    <i data-lucide="award" class="w-8 h-8 text-accent"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-foreground mb-4">Certificação Reconhecida</h2>
                <p class="text-muted-foreground max-w-lg mx-auto mb-8 leading-relaxed">
                    Os nossos cursos são certificados e reconhecidos pelas entidades competentes, garantindo a qualidade e o valor da formação obtida na MC-COMERCIAL em Angola e no exterior.
                </p>
                <a href="{{ route('site.cursos') }}" class="btn-primary">
                    <i data-lucide="book-open" class="w-4 h-4"></i>Ver Turmas com Certificação
                </a>
            </div>
        </section>

    </div>
</div>
@endsection
