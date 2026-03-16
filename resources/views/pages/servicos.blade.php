@extends('layouts.public')

@section('title', 'Serviços - MC-COMERCIAL')

@section('content')

{{-- Page Hero --}}
<div class="page-hero text-center">
    <div class="container mx-auto px-4 relative z-10">
        <span class="section-tag text-accent-foreground/80 justify-center before:bg-white/40">
            <i data-lucide="briefcase" class="w-3.5 h-3.5"></i> Soluções
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-5" style="letter-spacing: -0.03em;">Nossos Serviços</h1>
        <p class="text-lg text-white/65 max-w-2xl mx-auto">Soluções completas para o seu desenvolvimento profissional</p>
    </div>
</div>

<div class="py-16 bg-background min-h-screen">
    <div class="container mx-auto px-4">

        {{-- Grid de Serviços --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-24 reveal-stagger">
            @php
                $servicos = [
                    ['icon' => 'graduation-cap', 'title' => 'Formação Profissional',  'desc' => 'Cursos especializados em diversas áreas do saber com certificação reconhecida pelo mercado angolano e internacional.', 'price' => 'Sob consulta',        'highlight' => true],
                    ['icon' => 'briefcase',       'title' => 'Projectos Académicos',  'desc' => 'Apoio na elaboração de trabalhos, dissertações e projectos académicos com orientação especializada.',                  'price' => 'A partir de 50.000 Kz', 'highlight' => false],
                    ['icon' => 'pen-tool',        'title' => 'Workshops',             'desc' => 'Sessões práticas intensivas com especialistas da indústria para desenvolvimento acelerado de competências.',            'price' => 'A partir de 30.000 Kz', 'highlight' => false],
                    ['icon' => 'monitor',         'title' => 'Formação Online',       'desc' => 'Aprenda no seu próprio ritmo com aulas gravadas e sessões ao vivo com formadores certificados.',                       'price' => 'A partir de 15.000 Kz', 'highlight' => false],
                    ['icon' => 'target',          'title' => 'Consultoria Empresarial','desc' => 'Consultoria especializada para empresas e organizações que pretendem desenvolver os seus colaboradores.',            'price' => 'Sob consulta',          'highlight' => false],
                    ['icon' => 'award',           'title' => 'Certificações',         'desc' => 'Programas de certificação profissional reconhecidos internacionalmente que valorizam o seu currículo.',                'price' => 'Sob consulta',          'highlight' => false],
                ];
            @endphp

            @foreach($servicos as $servico)
                <div class="feature-card group reveal relative {{ $servico['highlight'] ? 'ring-2 ring-accent/20' : '' }}">
                    @if($servico['highlight'])
                        <div class="absolute top-4 right-4">
                            <span class="badge bg-accent text-white text-[10px]">
                                <i data-lucide="star" class="w-2.5 h-2.5"></i> Popular
                            </span>
                        </div>
                    @endif
                    <div class="icon-box icon-box-lg bg-accent/10 group-hover:bg-accent mb-6 transition-all duration-400 group-hover:scale-110 group-hover:-rotate-3">
                        <i data-lucide="{{ $servico['icon'] }}" class="w-7 h-7 text-accent group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="text-lg font-extrabold text-foreground mb-3 group-hover:text-accent transition-colors duration-300">{{ $servico['title'] }}</h3>
                    <p class="text-sm text-muted-foreground mb-6 leading-relaxed">{{ $servico['desc'] }}</p>
                    <div class="flex items-center justify-between pt-5 border-t border-border">
                        <div>
                            <p class="text-[10px] text-muted-foreground uppercase font-bold tracking-wider mb-0.5">Investimento</p>
                            <span class="text-sm font-bold gradient-text">{{ $servico['price'] }}</span>
                        </div>
                        <a href="{{ route('site.contactos') }}"
                           class="icon-box icon-box-sm bg-accent/10 text-accent hover:bg-accent hover:text-white transition-all duration-300 group-hover:scale-110">
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CTA Banner --}}
        <div class="mb-24 reveal">
            <div class="relative rounded-2xl p-12 md:p-16 text-center text-white overflow-hidden" style="background: var(--gradient-hero); box-shadow: var(--shadow-xl);">
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full opacity-10" style="background: hsl(var(--accent)); filter: blur(80px);"></div>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center mx-auto mb-6 animate-float">
                        <i data-lucide="message-square" class="w-7 h-7"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold mb-4" style="letter-spacing: -0.02em;">Interessado em Nossos Serviços?</h2>
                    <p class="text-lg mb-10 opacity-70 max-w-xl mx-auto leading-relaxed">
                        Entre em contacto connosco para discutir as suas necessidades e obter uma proposta personalizada.
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ route('site.contactos') }}" class="btn-accent">
                            <i data-lucide="mail" class="w-4 h-4"></i>Contacte-nos Agora
                        </a>
                        <a href="https://wa.me/244929643510" target="_blank" rel="noopener noreferrer" class="btn-outline">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>Via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- FAQ --}}
        <section class="reveal">
            <div class="text-center mb-14">
                <span class="section-tag justify-center">Dúvidas Frequentes</span>
                <h2 class="section-title text-center">Perguntas Frequentes</h2>
                <p class="section-subtitle mx-auto text-center">Tudo o que precisa de saber sobre os nossos serviços</p>
            </div>
            <div class="max-w-3xl mx-auto space-y-3" x-data="{ open: null }">
                @php
                    $faqs = [
                        ['q' => 'Como funciona a inscrição em um serviço?',     'a' => 'Pode inscrever-se diretamente através do formulário de contacto ou visitando um dos nossos centros. A nossa equipa confirmará a sua inscrição em até 24 horas úteis.'],
                        ['q' => 'Quais são as formas de pagamento aceites?',    'a' => 'Aceitamos transferência bancária, pagamento em dinheiro nos nossos centros e parcelamento mediante análise de crédito. Entre em contacto para mais detalhes.'],
                        ['q' => 'Os certificados são reconhecidos internacionalmente?', 'a' => 'Sim! Todos os nossos certificados são reconhecidos pelos órgãos competentes em Angola e válidos internacionalmente.'],
                        ['q' => 'Há descontos para grupos ou empresas?',        'a' => 'Sim, oferecemos condições especiais para inscrições em grupo e pacotes corporativos. Entre em contacto para uma proposta personalizada.'],
                        ['q' => 'Posso frequentar os cursos online?',           'a' => 'Sim, oferecemos modalidade online para a maioria dos nossos cursos, com aulas ao vivo e gravadas, acesso à plataforma e suporte do formador.'],
                    ];
                @endphp
                @foreach($faqs as $index => $faq)
                    <div class="bg-card border border-border rounded-2xl overflow-hidden hover:border-accent/30 transition-all duration-300"
                         style="box-shadow: var(--shadow-xs);">
                        <button @click="open === {{ $index }} ? open = null : open = {{ $index }}"
                                class="w-full flex items-center justify-between text-left px-6 py-5 hover:bg-muted/30 transition-colors gap-4">
                            <span class="font-bold text-foreground">{{ $faq['q'] }}</span>
                            <div class="icon-box icon-box-sm bg-accent/10 text-accent shrink-0 transition-all duration-400"
                                 :class="open === {{ $index }} ? 'bg-accent text-white rotate-180' : ''">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </button>
                        <div x-show="open === {{ $index }}"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="px-6 pb-6 text-sm text-muted-foreground leading-relaxed border-t border-border pt-4">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </div>
</div>
@endsection
