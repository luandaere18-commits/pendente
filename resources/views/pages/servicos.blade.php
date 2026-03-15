@extends('layouts.public')

@section('title', 'Serviços - MC-COMERCIAL')

@section('content')

{{-- Page Hero (azul centralizado) --}}
<div class="bg-gradient-to-br from-primary via-primary/90 to-primary/80 py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-accent blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 text-center text-primary-foreground relative">
        <h1 class="text-4xl lg:text-5xl font-extrabold mb-4">Nossos Serviços</h1>
        <p class="text-lg opacity-80 max-w-2xl mx-auto">Soluções completas para o seu desenvolvimento profissional</p>
    </div>
</div>

<div class="py-14 bg-background min-h-screen">
    <div class="container mx-auto px-4">

        {{-- Grid de Serviços --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-20">
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
                <div class="feature-card group reveal relative overflow-hidden {{ $servico['highlight'] ? 'ring-2 ring-accent/30' : '' }}">
                    @if($servico['highlight'])
                        <div class="absolute top-4 right-4">
                            <span class="text-[10px] font-bold bg-accent text-white px-2 py-1 rounded-full">Popular</span>
                        </div>
                    @endif
                    <div class="w-14 h-14 rounded-2xl bg-accent/10 group-hover:bg-accent flex items-center justify-center mb-5 transition-all duration-300 group-hover:scale-110">
                        <i data-lucide="{{ $servico['icon'] }}" class="w-7 h-7 text-accent group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="text-lg font-extrabold text-foreground mb-3 group-hover:text-accent transition-colors">{{ $servico['title'] }}</h3>
                    <p class="text-sm text-muted-foreground mb-6 leading-relaxed">{{ $servico['desc'] }}</p>
                    <div class="flex items-center justify-between pt-4 border-t border-border">
                        <div>
                            <p class="text-[10px] text-muted-foreground uppercase font-semibold mb-0.5">Investimento</p>
                            <span class="text-sm font-bold gradient-text">{{ $servico['price'] }}</span>
                        </div>
                        <a href="{{ route('site.contactos') }}"
                           class="w-10 h-10 rounded-xl bg-accent/10 text-accent hover:bg-accent hover:text-white flex items-center justify-center transition-all duration-200 group-hover:scale-110">
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CTA Banner --}}
        <div class="mb-20 reveal">
            <div class="bg-gradient-to-r from-primary to-primary/80 rounded-2xl p-10 md:p-14 text-center text-primary-foreground relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 pointer-events-none">
                    <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-accent blur-3xl"></div>
                </div>
                <div class="relative">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center mx-auto mb-5">
                        <i data-lucide="message-square" class="w-7 h-7"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold mb-4">Interessado em Nossos Serviços?</h2>
                    <p class="text-lg mb-8 opacity-85 max-w-xl mx-auto leading-relaxed">
                        Entre em contacto connosco para discutir as suas necessidades e obter uma proposta personalizada.
                    </p>
                    <div class="flex flex-wrap gap-3 justify-center">
                        <a href="{{ route('site.contactos') }}"
                           class="inline-flex items-center gap-2 rounded-xl text-sm font-bold bg-accent text-white h-12 px-8 hover:bg-accent/90 hover:scale-105 active:scale-95 transition-all duration-200 shadow-lg">
                            <i data-lucide="mail" class="w-4 h-4"></i>Contacte-nos Agora
                        </a>
                        <a href="https://wa.me/244929643510" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 rounded-xl text-sm font-bold border-2 border-white/30 text-white h-12 px-8 hover:bg-white/15 transition-all duration-200">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>Via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- FAQ --}}
        <section class="reveal">
            <div class="text-center mb-12">
                <span class="text-xs font-bold uppercase tracking-widest text-accent mb-3 block">Dúvidas Frequentes</span>
                <h2 class="section-title">Perguntas Frequentes</h2>
                <p class="section-subtitle">Tudo o que precisa de saber sobre os nossos serviços</p>
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
                    <div class="bg-card border border-border rounded-2xl overflow-hidden hover:border-accent/50 transition-colors">
                        <button @click="open === {{ $index }} ? open = null : open = {{ $index }}"
                                class="w-full flex items-center justify-between text-left px-6 py-4 hover:bg-muted/30 transition-colors gap-4">
                            <span class="font-semibold text-foreground">{{ $faq['q'] }}</span>
                            <div class="w-8 h-8 rounded-lg bg-accent/10 text-accent flex items-center justify-center shrink-0 transition-all duration-300"
                                 :class="open === {{ $index }} ? 'bg-accent text-white rotate-180' : ''">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </button>
                        <div x-show="open === {{ $index }}"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="px-6 pb-5 text-sm text-muted-foreground leading-relaxed border-t border-border pt-4">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </div>
</div>
@endsection
