@extends('layouts.public')

@section('title', 'Serviços - MC-COMERCIAL')

@section('content')
<div class="py-12 bg-background min-h-screen">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="section-title">Nossos Serviços</h1>
            <p class="section-subtitle">Soluções completas para o seu desenvolvimento profissional</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $servicos = [
                    [
                        'icon' => 'graduation-cap',
                        'title' => 'Formação Profissional',
                        'desc' => 'Cursos especializados em diversas áreas do saber com certificação reconhecida',
                        'price' => 'Sob consulta'
                    ],
                    [
                        'icon' => 'briefcase',
                        'title' => 'Projectos Académicos',
                        'desc' => 'Apoio na elaboração de trabalhos, dissertações e projectos',
                        'price' => 'A partir de 50.000 Kz'
                    ],
                    [
                        'icon' => 'pen-tool',
                        'title' => 'Workshops',
                        'desc' => 'Sessões práticas intensivas com especialistas da indústria',
                        'price' => 'A partir de 30.000 Kz'
                    ],
                    [
                        'icon' => 'monitor',
                        'title' => 'Formação Online',
                        'desc' => 'Aprenda no seu ritmo com aulas gravadas e ao vivo',
                        'price' => 'A partir de 15.000 Kz'
                    ],
                    [
                        'icon' => 'target',
                        'title' => 'Consultoria Empresarial',
                        'desc' => 'Consultoria especializada para empresas e organizações',
                        'price' => 'Sob consulta'
                    ],
                    [
                        'icon' => 'lightbulb',
                        'title' => 'Certificações',
                        'desc' => 'Programas de certificação profissional internacionalmente reconhecidos',
                        'price' => 'Sob consulta'
                    ],
                ];
            @endphp

            @foreach($servicos as $servico)
                <div class="feature-card group hover:shadow-lg transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-accent/10 group-hover:bg-accent flex items-center justify-center mb-4 transition-colors">
                        <i data-lucide="{{ $servico['icon'] }}" class="w-7 h-7 text-accent group-hover:text-accent-foreground transition-colors"></i>
                    </div>
                    <h3 class="text-lg font-bold text-foreground mb-3">{{ $servico['title'] }}</h3>
                    <p class="text-sm text-muted-foreground mb-4 leading-relaxed">{{ $servico['desc'] }}</p>
                    <div class="flex items-center justify-between pt-4 border-t border-border">
                        <span class="text-sm font-semibold gradient-text">{{ $servico['price'] }}</span>
                        <button onclick="document.querySelector('[data-turma-id]').scrollIntoView({behavior: 'smooth'})"
                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-accent/10 text-accent hover:bg-accent hover:text-accent-foreground transition-colors">
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CTA Section --}}
        <div class="mt-16 bg-gradient-to-r from-primary to-primary/80 rounded-xl p-8 md:p-12 text-center text-primary-foreground">
            <h2 class="text-3xl font-bold mb-4">Interessado em Nossos Serviços?</h2>
            <p class="text-lg mb-6 opacity-90">Entre em contacto conosco para discutir suas necessidades e obter uma proposta personalizada.</p>
            <a href="{{ route('site.contactos') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-accent text-accent-foreground h-11 px-6 hover:bg-accent/90 transition-colors">
                <i data-lucide="mail" class="w-5 h-5 mr-2"></i>
                Contacte-nos Agora
            </a>
        </div>

        {{-- FAQ Section --}}
        <div class="mt-16">
            <div class="text-center mb-12">
                <h2 class="section-title">Perguntas Frequentes</h2>
                <p class="section-subtitle">Dúvidas sobre nossos serviços?</p>
            </div>

            <div class="max-w-3xl mx-auto space-y-4" x-data="{ open: null }">
                @php
                    $faqs = [
                        [
                            'q' => 'Como funciona a inscrição em um serviço?',
                            'a' => 'Você pode se inscrever diretamente através do formulário de contacto ou visitando nossos centros. Nossa equipa confirmará sua inscrição dentro de 24 horas.'
                        ],
                        [
                            'q' => 'Quais são as formas de pagamento?',
                            'a' => 'Aceitamos transferência bancária, pagamento em dinheiro nos nossos centros e parcelamento mediante análise de crédito.'
                        ],
                        [
                            'q' => 'Os certificados são reconhecidos internacionalmente?',
                            'a' => 'Sim! Todos os nossos certificados são reconhecidos pelos órgãos competentes em Angola e válidos internacionalmente.'
                        ],
                        [
                            'q' => 'Há descontos para grupos?',
                            'a' => 'Sim, oferecemos descontos especiais para inscrições em grupo. Entre em contacto para mais informações.'
                        ],
                    ];
                @endphp

                @foreach($faqs as $index => $faq)
                    <div class="feature-card">
                        <button @click="open === {{ $index }} ? open = null : open = {{ $index }}"
                                class="w-full flex items-center justify-between text-left p-4 hover:bg-muted/50 transition-colors rounded-lg">
                            <span class="font-semibold text-foreground">{{ $faq['q'] }}</span>
                            <i data-lucide="chevron-down" class="w-5 h-5 text-accent transition-transform"
                               :class="{ 'rotate-180': open === {{ $index }} }"></i>
                        </button>
                        <div x-show="open === {{ $index }}" x-transition class="px-4 pb-4 border-t border-border pt-4">
                            <p class="text-sm text-muted-foreground leading-relaxed">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
