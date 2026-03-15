@extends('layouts.public')

@section('title', 'MC-COMERCIAL - Centro de Formação Profissional')

@section('content')

{{-- Hero Carousel --}}
<section x-data="{ 
    active: 0, 
    total: 4,
    autoplay: null,
    init() {
        this.autoplay = setInterval(() => this.next(), 5000);
    },
    next() { 
        this.active = (this.active + 1) % this.total;
        this.resetAutoplay();
    },
    prev() { 
        this.active = (this.active - 1 + this.total) % this.total;
        this.resetAutoplay();
    },
    goTo(i) { 
        this.active = i; 
        this.resetAutoplay();
    },
    resetAutoplay() {
        clearInterval(this.autoplay);
        this.autoplay = setInterval(() => this.next(), 5000);
    }
}" class="relative overflow-hidden h-[75vh] md:h-[85vh]" x-cloak>

    @php
        // Usar imagens placeholder caso as originais não existam
        $slides = [
            ['image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'title' => 'Invista no seu', 'highlight' => 'Futuro Profissional', 'desc' => 'Formação de qualidade com mais de 10 anos de experiência na preparação de profissionais qualificados para o mercado de trabalho.'],
            ['image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'title' => 'Aprenda com os', 'highlight' => 'Melhores Formadores', 'desc' => 'Salas equipadas com tecnologia de ponta e formadores experientes para garantir a melhor experiência de aprendizagem.'],
            ['image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'title' => 'Conquiste o seu', 'highlight' => 'Certificado Profissional', 'desc' => 'Certificações reconhecidas pelo mercado que abrem portas para novas oportunidades de carreira.'],
            ['image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'title' => 'Workshops e', 'highlight' => 'Formações Práticas', 'desc' => 'Sessões práticas e intensivas que preparam você para os desafios reais do mercado de trabalho.'],
        ];
    @endphp

    @foreach($slides as $index => $slide)
    <div x-show="active === {{ $index }}"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-105"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute inset-0"
         :class="{ 'z-10': active === {{ $index }} }">
        <img src="{{ $slide['image'] }}" alt="{{ $slide['desc'] }}" 
             loading="{{ $index === 0 ? 'eager' : 'lazy' }}" 
             class="w-full h-full object-cover"
             onerror="this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'">
        <div class="absolute inset-0 bg-gradient-to-r from-foreground/80 via-foreground/40 to-transparent flex items-center">
            <div class="container mx-auto px-4">
                <div class="max-w-2xl">
                    <h1 class="text-4xl lg:text-5xl xl:text-6xl font-extrabold text-white leading-tight mb-6">
                        {{ $slide['title'] }} <span class="gradient-text">{{ $slide['highlight'] }}</span>
                    </h1>
                    <p class="text-lg text-white/80 mb-8 leading-relaxed">{{ $slide['desc'] }}</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('site.cursos') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-accent text-accent-foreground h-11 px-6 shadow-lg hover:bg-accent/90 transition-colors">
                            <i data-lucide="book-open" class="w-5 h-5 mr-2"></i>Explorar Cursos
                        </a>
                        <a href="#sobre" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-white/30 text-white h-11 px-6 hover:bg-white/10 transition-colors">
                            Saber Mais
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Nav Arrows --}}
    <button @click="prev()" 
            class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm text-white flex items-center justify-center hover:bg-white/30 transition-all z-20" 
            aria-label="Slide anterior"
            :class="{ 'hidden': active === 0 }">
        <i data-lucide="chevron-left" class="w-5 h-5"></i>
    </button>
    <button @click="next()" 
            class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm text-white flex items-center justify-center hover:bg-white/30 transition-all z-20"
            aria-label="Próximo slide"
            :class="{ 'hidden': active === total - 1 }">
        <i data-lucide="chevron-right" class="w-5 h-5"></i>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2 z-20">
        @for($i = 0; $i < count($slides); $i++)
        <button @click="goTo({{ $i }})"
                :class="active === {{ $i }} ? 'w-8 bg-white' : 'w-2 bg-white/40 hover:bg-white/60'"
                class="h-3 rounded-full transition-all"
                :aria-label="'Ir para slide ' + ({{ $i }} + 1)">
        </button>
        @endfor
    </div>
</section>

{{-- Estatísticas --}}
<section class="py-16 bg-background">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $cursosCount = isset($cursos) ? $cursos->count() : 0;
                $centrosCount = isset($centros) ? $centros->count() : 0;
                $stats = [
                    ['icon' => 'users', 'value' => '500+', 'label' => 'Alunos Formados'],
                    ['icon' => 'book-open', 'value' => $cursosCount, 'label' => 'Cursos Disponíveis'],
                    ['icon' => 'building-2', 'value' => $centrosCount, 'label' => 'Centros de Formação'],
                    ['icon' => 'award', 'value' => '100%', 'label' => 'Taxa de Sucesso'],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="feature-card text-center">
                    <i data-lucide="{{ $stat['icon'] }}" class="w-10 h-10 text-accent mx-auto mb-3"></i>
                    <h3 class="text-3xl font-extrabold gradient-text mb-1">{{ $stat['value'] }}</h3>
                    <p class="text-sm text-muted-foreground">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Centros Preview --}}
<section class="py-16 bg-muted/50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="section-title">Nossos Centros de Formação</h2>
            <p class="section-subtitle">Espaços modernos e equipados para a sua formação</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($centros->take(3) as $centro)
                <div class="feature-card">
                    <div class="w-14 h-14 rounded-xl bg-accent/10 flex items-center justify-center mb-4">
                        <i data-lucide="building-2" class="w-7 h-7 text-accent"></i>
                    </div>
                    <h3 class="text-lg font-bold text-foreground mb-2">{{ $centro->nome ?? 'Centro de Formação' }}</h3>
                    <p class="text-sm text-muted-foreground flex items-start gap-1 mb-2">
                        <i data-lucide="map-pin" class="w-4 h-4 mt-0.5 shrink-0"></i>{{ $centro->localizacao ?? 'Localização a definir' }}
                    </p>
                    @if(!empty($centro->contactos) && count($centro->contactos) > 0)
                        <a href="tel:{{ $centro->contactos[0] }}" class="text-sm text-accent flex items-center gap-1 mb-4">
                            <i data-lucide="phone" class="w-4 h-4"></i>{{ $centro->contactos[0] }}
                        </a>
                    @endif
                    <a href="{{ route('site.centros', $centro->id) }}" class="inline-flex items-center justify-center w-full rounded-md text-sm font-medium border border-input bg-background h-9 px-4 hover:bg-accent hover:text-accent-foreground transition-colors">
                        Explorar <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                    </a>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-muted-foreground">
                    Nenhum centro disponível no momento.
                </div>
            @endforelse
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('site.centros') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-input bg-background h-10 px-6 hover:bg-accent hover:text-accent-foreground transition-colors">
                Ver Todos os Centros <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- Serviços --}}
<section class="py-16 bg-background">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="section-title">Nossos Serviços</h2>
            <p class="section-subtitle">Soluções completas para o seu desenvolvimento profissional</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $servicos = [
                    ['icon' => 'graduation-cap', 'title' => 'Formação Profissional', 'desc' => 'Cursos especializados em diversas áreas do saber'],
                    ['icon' => 'briefcase', 'title' => 'Projectos Académicos', 'desc' => 'Apoio na elaboração de trabalhos e dissertações'],
                    ['icon' => 'pen-tool', 'title' => 'Workshops', 'desc' => 'Sessões práticas intensivas com especialistas'],
                    ['icon' => 'monitor', 'title' => 'Formação Online', 'desc' => 'Aprenda no seu ritmo com aulas à distância'],
                    ['icon' => 'target', 'title' => 'Consultoria', 'desc' => 'Consultoria empresarial especializada'],
                    ['icon' => 'lightbulb', 'title' => 'Certificações', 'desc' => 'Certificados reconhecidos pelo mercado'],
                ];
            @endphp
            @foreach($servicos as $servico)
                <div class="feature-card group">
                    <div class="w-12 h-12 rounded-lg bg-accent/10 group-hover:bg-accent flex items-center justify-center mb-4 transition-colors">
                        <i data-lucide="{{ $servico['icon'] }}" class="w-6 h-6 text-accent group-hover:text-accent-foreground transition-colors"></i>
                    </div>
                    <h3 class="text-lg font-bold text-foreground mb-2">{{ $servico['title'] }}</h3>
                    <p class="text-sm text-muted-foreground">{{ $servico['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Turmas Disponíveis --}}
<section class="py-16 bg-muted/50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="section-title">Turmas Disponíveis</h2>
            <p class="section-subtitle">Inscreva-se já nas próximas turmas</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($turmas->take(6) as $turma)
                @php
                    $vagasDisp = isset($turma->vagas_totais) && isset($turma->vagas_preenchidas) 
                        ? $turma->vagas_totais - $turma->vagas_preenchidas 
                        : 0;
                    $progress = isset($turma->vagas_totais) && $turma->vagas_totais > 0
                        ? ($turma->vagas_preenchidas / $turma->vagas_totais) * 100
                        : 0;
                    $cursoNome = $turma->curso->nome ?? 'Curso';
                    $imagemUrl = $turma->curso->imagem_url ?? 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80';
                    $area = $turma->curso->area ?? 'Geral';
                    $modalidade = $turma->curso->modalidade ?? 'Presencial';
                @endphp
                <div class="feature-card overflow-hidden">
                    <img src="{{ $imagemUrl }}" alt="{{ $cursoNome }}" 
                         class="w-full h-44 object-cover rounded-lg mb-4" 
                         loading="lazy"
                         onerror="this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'">
                    <h3 class="font-bold text-foreground mb-1">{{ $cursoNome }}</h3>
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="badge-area">{{ $area }}</span>
                        <span class="badge-modalidade">{{ $modalidade }}</span>
                    </div>
                    <div class="space-y-1 text-sm text-muted-foreground mb-3">
                        <p class="flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                            {{ $turma->periodo ?? 'Manhã' }} &bull; {{ $turma->hora_inicio ?? '08:00' }} - {{ $turma->hora_fim ?? '10:00' }}
                        </p>
                        <p class="flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                            {{ isset($turma->data_arranque) ? \Carbon\Carbon::parse($turma->data_arranque)->translatedFormat('d \\d\\e F \\d\\e Y') : 'Data a definir' }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-muted-foreground">Vagas</span>
                            <span class="font-semibold {{ $vagasDisp < 5 ? 'text-destructive' : 'text-success' }}">{{ $vagasDisp }} disponíveis</span>
                        </div>
                        <div class="w-full h-2 bg-muted rounded-full overflow-hidden">
                            <div class="h-full bg-accent rounded-full transition-all" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                    <button @click="$dispatch('pre-inscricao', { turmaId: {{ $turma->id ?? 0 }}, turmaNome: '{{ $cursoNome }} - {{ $turma->periodo ?? 'Manhã' }}' })"
                            class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground h-10 hover:bg-primary/90 transition-colors">
                        Pré-inscrever-se
                    </button>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-muted-foreground">
                    Nenhuma turma disponível no momento.
                </div>
            @endforelse
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('site.cursos') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-input bg-background h-10 px-6 hover:bg-accent hover:text-accent-foreground transition-colors">
                Ver Todas as Turmas <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- Newsletter --}}
<section class="py-16" style="background: linear-gradient(135deg, hsl(217, 91%, 60%), hsl(224, 76%, 48%))">
    <div class="container mx-auto px-4 text-center" x-data="{ email: '', loading: false }">
        <i data-lucide="mail" class="w-12 h-12 text-white/80 mx-auto mb-4"></i>
        <h2 class="text-3xl font-bold text-white mb-2">Fique Atualizado</h2>
        <p class="text-white/70 mb-8 max-w-md mx-auto">Subscreva a nossa newsletter para receber novidades sobre cursos e promoções</p>
        <form @submit.prevent="
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { 
                showToast('Email inválido', 'error'); 
                return; 
            }
            loading = true;
            fetch('/api/newsletter', { 
                method: 'POST', 
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                }, 
                body: JSON.stringify({ email }) 
            })
            .then(response => response.json())
            .then(() => { 
                showToast('Subscrito com sucesso!'); 
                email = ''; 
            })
            .catch(() => showToast('Erro ao subscrever', 'error'))
            .finally(() => { loading = false; })
        " class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
            <input type="email" x-model="email" placeholder="Seu email"
                   class="flex-1 h-10 rounded-md border bg-white/10 border-white/20 text-white placeholder:text-white/50 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-white/30">
            <button type="submit" :disabled="loading"
                    class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-white text-primary h-10 px-6 hover:bg-white/90 shrink-0 disabled:opacity-50">
                <span x-show="!loading">Subscrever</span>
                <span x-show="loading" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Enviando...
                </span>
            </button>
        </form>
    </div>
</section>

{{-- Por que Escolher --}}
<section id="sobre" class="py-16 bg-background">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="section-title mb-6">Por que Escolher MC-COMERCIAL?</h2>
                <ul class="space-y-4 mb-8">
                    @foreach([
                        'Experiência Comprovada (10+ anos)',
                        'Cursos Especializados e Atualizados',
                        'Formadores Experientes e Qualificados',
                        'Certificações Reconhecidas pelo Mercado',
                        'Flexibilidade de Horários e Modalidades',
                    ] as $item)
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                                <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                            </div>
                            <span class="text-foreground">{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('site.sobre') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground h-10 px-6 hover:bg-primary/90 transition-colors">
                    Saber Mais Sobre Nós <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>
            <div class="rounded-xl overflow-hidden shadow-lg">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62587.26!2d13.35!3d-8.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwNTQnMDAuMCJTIDEzwrAyMycwMC4wIkU!5e0!3m2!1spt-PT!2sao!4v1700000000000"
                        width="100%" height="350" style="border:0;" 
                        allowfullscreen loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade" 
                        title="Localização MC-COMERCIAL"></iframe>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Função global para mostrar toast
window.showToast = function(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-sm animate-fade-in ${
        type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
    }`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}

// Inicializar Lucide icons
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Forçar criação dos ícones após 500ms (fallback)
    setTimeout(() => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }, 500);
});
</script>
@endpush
