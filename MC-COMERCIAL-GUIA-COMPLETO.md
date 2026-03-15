# 🔧 MC-COMERCIAL — Guia Completo de Melhorias

> **IMPORTANTE**: Este documento contém TODAS as mudanças que precisa fazer no seu projecto Laravel.
> Siga passo-a-passo. Não mexa no admin — apenas no site público.

---

## 📊 RESUMO DA ANÁLISE

Após análise completa do repositório `luandaere18-commits/pendente`, identifiquei:

### ✅ O que já está bem:
- Rotas `/site/servicos` já existem
- `SiteController::servicos()` já existe
- `servicos.blade.php` já existe
- Design system CSS bem estruturado (variáveis HSL, tokens, componentes)
- Tailwind config com Plus Jakarta Sans
- Layout público (`layouts/public.blade.php`) funcional
- Componentes reutilizáveis (topbar, whatsapp, modal)

### ❌ Problemas encontrados:

| # | Problema | Gravidade |
|---|---------|-----------|
| 1 | `cursos.blade.php` usa `$cursos` mas controller só passa `$turmas` e `$areas` | 🔴 CRÍTICO |
| 2 | `servicos()` não passa dados dinâmicos — tudo hardcoded na view | 🟡 MÉDIO |
| 3 | Home carousel sem Alpine.js funcional (markup perdido na conversão) | 🟡 MÉDIO |
| 4 | Formulários sem validação client-side | 🟡 MÉDIO |
| 5 | Imagens sem `loading="lazy"` | 🟢 MENOR |
| 6 | Falta `alt` text dinâmico em algumas imagens | 🟢 MENOR |
| 7 | Navbar não inclui link "Serviços" (provavelmente) | 🟡 MÉDIO |

---

## 🚀 PASSO 1: Corrigir SiteController.php

**Ficheiro:** `app/Http/Controllers/SiteController.php`

### Problema CRÍTICO: Método `cursos()` não passa `$cursos`

O template `cursos.blade.php` faz `@foreach($cursos as $curso)` mas o controller só passa `$turmas` e `$areas`.

**Substitua o método `cursos()` por:**

```php
/**
 * Página de cursos
 */
public function cursos()
{
    $turmas = Turma::with(['curso', 'centro', 'formador'])
        ->where('publicado', true)
        ->orderBy('data_arranque', 'asc')
        ->get();

    // Obter cursos únicos das turmas publicadas
    $cursos = $turmas->pluck('curso')->unique('id')->values();

    // Obter áreas únicas dos cursos
    $areas = $cursos->pluck('area')
        ->unique()
        ->sort()
        ->values();

    return view('pages.cursos', compact('turmas', 'cursos', 'areas'));
}
```

### Melhoria: Método `servicos()` com dados (opcional, para futuro)

Se quiser tornar os serviços dinâmicos no futuro:

```php
/**
 * Página de serviços
 */
public function servicos()
{
    // Por agora os serviços são estáticos na view
    // Futuramente pode criar um model Servico e carregar do BD
    return view('pages.servicos');
}
```

---

## 🚀 PASSO 2: Corrigir cursos.blade.php

**Ficheiro:** `resources/views/pages/cursos.blade.php`

Substitua **todo o conteúdo** por:

```blade
@extends('layouts.public')

@section('title', 'Cursos - MC-COMERCIAL')

@section('content')

{{-- Hero --}}
<section class="py-16 bg-background">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-accent font-semibold tracking-wider uppercase text-sm">Catálogo</span>
            <h1 class="section-title mt-4">Nossos Cursos</h1>
            <p class="section-subtitle">Encontre o curso ideal para a sua carreira</p>
        </div>

        {{-- Filtros --}}
        <div x-data="{ areaAtiva: 'todas', modalidadeAtiva: 'todas' }" class="space-y-8">
            
            {{-- Filtro por Área --}}
            <div class="flex flex-wrap gap-2 justify-center">
                <button @click="areaAtiva = 'todas'"
                    :class="areaAtiva === 'todas' ? 'bg-primary text-primary-foreground' : 'bg-card text-foreground border border-border'"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                    Todas as Áreas
                </button>
                @foreach($areas as $area)
                <button @click="areaAtiva = '{{ $area }}'"
                    :class="areaAtiva === '{{ $area }}' ? 'bg-primary text-primary-foreground' : 'bg-card text-foreground border border-border'"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                    {{ $area }}
                </button>
                @endforeach
            </div>

            {{-- Grid de Cursos --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($cursos as $curso)
                @php
                    $turmasCurso = $turmas->where('curso_id', $curso->id);
                    $totalVagas = $turmasCurso->sum('vagas_totais');
                    $totalPreenchidas = $turmasCurso->sum('vagas_preenchidas');
                    $vagasDisp = $totalVagas - $totalPreenchidas;
                    $progress = $totalVagas > 0 ? ($totalPreenchidas / $totalVagas) * 100 : 0;
                @endphp

                <div x-show="areaAtiva === 'todas' || areaAtiva === '{{ $curso->area }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="feature-card group">
                    
                    {{-- Imagem --}}
                    <div class="relative overflow-hidden rounded-xl mb-4 aspect-video">
                        <img src="{{ $curso->imagem_url }}" 
                             alt="Curso de {{ $curso->nome }}" 
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 flex gap-2">
                            <span class="badge-area">
                                <i data-lucide="star" class="w-3 h-3 mr-1"></i>
                                {{ $turmasCurso->count() }} Turma{{ $turmasCurso->count() !== 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>

                    {{-- Conteúdo --}}
                    <h3 class="text-lg font-bold text-foreground mb-2 line-clamp-1">{{ $curso->nome }}</h3>
                    <p class="text-muted-foreground text-sm mb-4 line-clamp-2">{{ $curso->descricao }}</p>

                    {{-- Tags --}}
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="badge-area">{{ $curso->area }}</span>
                        <span class="badge-modalidade">{{ $curso->modalidade }}</span>
                    </div>

                    {{-- Barra de vagas --}}
                    @if($totalVagas > 0)
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-muted-foreground mb-1">
                            <span>Vagas</span>
                            <span>{{ $totalPreenchidas }} de {{ $totalVagas }}</span>
                        </div>
                        <div class="w-full bg-muted rounded-full h-2">
                            <div class="h-2 rounded-full transition-all duration-500
                                {{ $progress >= 90 ? 'bg-destructive' : ($progress >= 60 ? 'bg-warning' : 'bg-accent') }}"
                                style="width: {{ min($progress, 100) }}%">
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Botão --}}
                    <button onclick="openTurmasModal({{ $curso->id }}, '{{ addslashes($curso->nome) }}')"
                        class="w-full py-2.5 rounded-lg text-sm font-semibold transition-all duration-200
                        bg-primary text-primary-foreground hover:opacity-90"
                        style="box-shadow: var(--shadow-button);">
                        Ver Turmas Disponíveis
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Turmas Modal --}}
<div x-data="{ open: false, cursoNome: '', cursoId: null }"
     x-show="open"
     x-cloak
     @open-turmas.window="open = true; cursoNome = $event.detail.nome; cursoId = $event.detail.id"
     class="fixed inset-0 z-50 flex items-center justify-center p-4">
    
    <div @click="open = false" class="absolute inset-0 bg-foreground/50 backdrop-blur-sm"></div>
    
    <div class="relative bg-card rounded-2xl p-6 md:p-8 max-w-2xl w-full max-h-[80vh] overflow-y-auto"
         style="box-shadow: var(--shadow-card-hover);">
        <button @click="open = false" class="absolute top-4 right-4 text-muted-foreground hover:text-foreground">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
        <h2 class="text-xl font-bold mb-6">Turmas - <span x-text="cursoNome"></span></h2>
        
        <div class="space-y-4">
            @foreach($turmas as $turma)
            <div x-show="cursoId === {{ $turma->curso_id }}" class="p-4 rounded-xl border border-border">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="font-semibold text-foreground">{{ $turma->periodo }}</p>
                        <p class="text-sm text-muted-foreground">{{ $turma->hora_inicio }} - {{ $turma->hora_fim }}</p>
                    </div>
                    <span class="badge-area">
                        {{ $turma->vagas_totais - $turma->vagas_preenchidas }} vagas
                    </span>
                </div>
                <p class="text-sm text-muted-foreground mb-3">
                    <i data-lucide="calendar" class="w-4 h-4 inline mr-1"></i>
                    Início: {{ \Carbon\Carbon::parse($turma->data_arranque)->translatedFormat('d \d\e F \d\e Y') }}
                </p>
                <p class="text-sm text-muted-foreground mb-3">
                    <i data-lucide="map-pin" class="w-4 h-4 inline mr-1"></i>
                    {{ $turma->centro->nome ?? 'A definir' }}
                </p>
                <button @click="$dispatch('open-modal', 'pre-inscricao')" 
                    class="w-full py-2 rounded-lg text-sm font-semibold bg-accent text-accent-foreground hover:opacity-90 transition-all">
                    Pré-inscrever-se
                </button>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openTurmasModal(cursoId, cursoNome) {
    window.dispatchEvent(new CustomEvent('open-turmas', {
        detail: { id: cursoId, nome: cursoNome }
    }));
}
</script>
@endpush
```

---

## 🚀 PASSO 3: Melhorar home.blade.php (Carousel funcional)

**Ficheiro:** `resources/views/pages/home.blade.php`

Substitua **todo o conteúdo** por:

```blade
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
    next() { this.active = (this.active + 1) % this.total; },
    prev() { this.active = (this.active - 1 + this.total) % this.total; },
    goTo(i) { this.active = i; clearInterval(this.autoplay); this.autoplay = setInterval(() => this.next(), 5000); }
}" class="relative overflow-hidden h-[75vh] md:h-[85vh]">

    @php
    $slides = [
        ['image' => asset('images/hero-banner.jpg'), 'title' => 'Invista no seu', 'highlight' => 'Futuro Profissional', 'desc' => 'Formação de qualidade com mais de 10 anos de experiência na preparação de profissionais qualificados.'],
        ['image' => asset('images/carousel-2.jpg'), 'title' => 'Aprenda com os', 'highlight' => 'Melhores Formadores', 'desc' => 'Formadores experientes para garantir a melhor experiência de aprendizagem.'],
        ['image' => asset('images/carousel-3.jpg'), 'title' => 'Conquiste o seu', 'highlight' => 'Certificado Profissional', 'desc' => 'Certificações reconhecidas que abrem portas para novas oportunidades.'],
        ['image' => asset('images/carousel-4.jpg'), 'title' => 'Workshops e', 'highlight' => 'Formações Práticas', 'desc' => 'Sessões intensivas que preparam para os desafios do mercado.'],
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
         class="absolute inset-0">
        <img src="{{ $slide['image'] }}" alt="{{ $slide['desc'] }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-foreground/80 via-foreground/40 to-transparent flex items-center">
            <div class="container mx-auto px-4">
                <div class="max-w-xl">
                    <h1 class="text-white text-4xl md:text-6xl font-bold leading-tight mb-4">
                        {{ $slide['title'] }} <span class="gradient-text">{{ $slide['highlight'] }}</span>
                    </h1>
                    <p class="text-white/80 text-lg mb-8">{{ $slide['desc'] }}</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('site.cursos') }}" class="inline-flex items-center px-6 py-3 rounded-full bg-accent text-accent-foreground font-bold text-sm hover:opacity-90 transition-all" style="box-shadow: var(--shadow-button);">
                            <i data-lucide="book-open" class="w-4 h-4 mr-2"></i>
                            Explorar Cursos
                        </a>
                        <a href="#sobre" class="inline-flex items-center px-6 py-3 rounded-full border-2 border-white/30 text-white font-bold text-sm hover:bg-white/10 transition-all">
                            Saber Mais
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Nav Arrows --}}
    <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm text-white flex items-center justify-center hover:bg-white/30 transition-all z-10" aria-label="Slide anterior">
        <i data-lucide="chevron-left" class="w-5 h-5"></i>
    </button>
    <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm text-white flex items-center justify-center hover:bg-white/30 transition-all z-10" aria-label="Próximo slide">
        <i data-lucide="chevron-right" class="w-5 h-5"></i>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2 z-10">
        @for($i = 0; $i < count($slides); $i++)
        <button @click="goTo({{ $i }})"
            :class="active === {{ $i }} ? 'w-8 bg-white' : 'w-2 bg-white/40'"
            class="h-2 rounded-full transition-all duration-300"
            aria-label="Ir para slide {{ $i + 1 }}">
        </button>
        @endfor
    </div>
</section>

{{-- Estatísticas --}}
<section class="py-16 bg-card">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @php
            $stats = [
                ['icon' => 'users', 'value' => '500+', 'label' => 'Alunos Formados'],
                ['icon' => 'book-open', 'value' => $cursos->count(), 'label' => 'Cursos Disponíveis'],
                ['icon' => 'building-2', 'value' => $centros->count(), 'label' => 'Centros de Formação'],
                ['icon' => 'award', 'value' => '100%', 'label' => 'Taxa de Sucesso'],
            ];
            @endphp
            @foreach($stats as $stat)
            <div class="text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-accent/10 flex items-center justify-center">
                    <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6 text-accent"></i>
                </div>
                <h3 class="text-3xl font-bold text-foreground mb-1">{{ $stat['value'] }}</h3>
                <p class="text-sm text-muted-foreground">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Centros Preview --}}
<section class="py-20 bg-background">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-accent font-semibold tracking-wider uppercase text-sm">Infraestrutura</span>
            <h2 class="section-title mt-4">Nossos Centros de Formação</h2>
            <p class="section-subtitle">Espaços modernos e equipados para a sua formação</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($centros->take(3) as $centro)
            <div class="feature-card group">
                <div class="w-12 h-12 rounded-lg bg-accent/10 flex items-center justify-center mb-4 group-hover:bg-primary transition-colors">
                    <i data-lucide="building-2" class="w-6 h-6 text-accent group-hover:text-primary-foreground"></i>
                </div>
                <h3 class="text-lg font-bold text-foreground mb-2">{{ $centro->nome }}</h3>
                <p class="text-sm text-muted-foreground mb-4">
                    <i data-lucide="map-pin" class="w-4 h-4 inline mr-1"></i>
                    {{ $centro->localizacao }}
                </p>
                <div class="flex flex-col gap-2 mb-4 text-sm text-muted-foreground">
                    @foreach($centro->contactos as $tel)
                    <a href="tel:{{ $tel }}" class="hover:text-accent transition-colors">
                        <i data-lucide="phone" class="w-4 h-4 inline mr-1"></i>{{ $tel }}
                    </a>
                    @endforeach
                </div>
                <a href="{{ route('site.centros') }}" class="inline-flex items-center font-semibold text-sm text-primary hover:gap-2 transition-all">
                    Explorar Centro <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('site.centros') }}" class="inline-flex items-center px-6 py-3 rounded-lg border border-border text-foreground font-semibold text-sm hover:bg-muted transition-all">
                Ver Todos os Centros
            </a>
        </div>
    </div>
</section>

{{-- Serviços --}}
<section class="py-20 bg-card">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-accent font-semibold tracking-wider uppercase text-sm">Soluções</span>
            <h2 class="section-title mt-4">Nossos Serviços</h2>
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
            <div class="feature-card group text-center">
                <div class="w-14 h-14 mx-auto rounded-xl bg-accent/10 flex items-center justify-center mb-4 group-hover:bg-primary transition-colors">
                    <i data-lucide="{{ $servico['icon'] }}" class="w-6 h-6 text-accent group-hover:text-primary-foreground"></i>
                </div>
                <h3 class="text-lg font-bold text-foreground mb-2">{{ $servico['title'] }}</h3>
                <p class="text-sm text-muted-foreground">{{ $servico['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Turmas Disponíveis --}}
<section class="py-20 bg-background">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-accent font-semibold tracking-wider uppercase text-sm">Inscrições Abertas</span>
            <h2 class="section-title mt-4">Turmas Disponíveis</h2>
            <p class="section-subtitle">Inscreva-se já nas próximas turmas</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($turmas->take(6) as $turma)
            @php
                $vagasDisp = $turma->vagas_totais - $turma->vagas_preenchidas;
                $progress = $turma->vagas_totais > 0 ? ($turma->vagas_preenchidas / $turma->vagas_totais) * 100 : 0;
            @endphp
            <div class="feature-card">
                <div class="relative overflow-hidden rounded-xl mb-4 aspect-video">
                    <img src="{{ $turma->curso->imagem_url }}" 
                         alt="Turma de {{ $turma->curso->nome }}" 
                         loading="lazy"
                         class="w-full h-full object-cover">
                </div>
                <h3 class="text-lg font-bold text-foreground mb-2 line-clamp-1">{{ $turma->curso->nome }}</h3>
                <div class="flex flex-wrap gap-2 mb-3">
                    <span class="badge-area">{{ $turma->curso->area }}</span>
                    <span class="badge-modalidade">{{ $turma->curso->modalidade }}</span>
                </div>
                <div class="space-y-2 text-sm text-muted-foreground mb-4">
                    <p><i data-lucide="clock" class="w-4 h-4 inline mr-1"></i>{{ $turma->periodo }} • {{ $turma->hora_inicio }} - {{ $turma->hora_fim }}</p>
                    <p><i data-lucide="calendar" class="w-4 h-4 inline mr-1"></i>{{ \Carbon\Carbon::parse($turma->data_arranque)->translatedFormat('d \d\e F \d\e Y') }}</p>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between text-xs text-muted-foreground mb-1">
                        <span>Vagas</span>
                        <span class="font-semibold {{ $vagasDisp <= 3 ? 'text-destructive' : 'text-accent' }}">{{ $vagasDisp }} disponíveis</span>
                    </div>
                    <div class="w-full bg-muted rounded-full h-2">
                        <div class="h-2 rounded-full {{ $progress >= 90 ? 'bg-destructive' : 'bg-accent' }} transition-all"
                            style="width: {{ min($progress, 100) }}%"></div>
                    </div>
                </div>
                <button @click="$dispatch('open-modal', 'pre-inscricao')"
                    class="w-full py-2.5 rounded-lg text-sm font-semibold bg-primary text-primary-foreground hover:opacity-90 transition-all"
                    style="box-shadow: var(--shadow-button);">
                    Pré-inscrever-se
                </button>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('site.cursos') }}" class="inline-flex items-center px-6 py-3 rounded-lg border border-border text-foreground font-semibold text-sm hover:bg-muted transition-all">
                Ver Todas as Turmas
            </a>
        </div>
    </div>
</section>

{{-- Newsletter --}}
<section class="py-16" style="background: var(--gradient-hero);">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Fique Atualizado</h2>
        <p class="text-white/70 mb-8 max-w-lg mx-auto">Subscreva a nossa newsletter para receber novidades sobre cursos e promoções</p>
        <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto" x-data="{ email: '' }">
            @csrf
            <input type="email" x-model="email" placeholder="O seu email" required
                class="flex-1 px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-accent">
            <button type="submit" class="px-6 py-3 rounded-lg bg-accent text-accent-foreground font-bold text-sm hover:opacity-90 transition-all">
                Subscrever
            </button>
        </form>
    </div>
</section>

{{-- Por que Escolher --}}
<section id="sobre" class="py-20 bg-background">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-accent font-semibold tracking-wider uppercase text-sm">Diferencial</span>
                <h2 class="section-title mt-4">Por que Escolher MC-COMERCIAL?</h2>
                <ul class="space-y-4 mt-6">
                    @foreach([
                        'Experiência Comprovada (10+ anos)',
                        'Cursos Especializados e Atualizados',
                        'Formadores Experientes e Qualificados',
                        'Certificações Reconhecidas pelo Mercado',
                        'Flexibilidade de Horários e Modalidades',
                    ] as $item)
                    <li class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-accent/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-3 h-3 text-accent"></i>
                        </span>
                        <span class="text-foreground">{{ $item }}</span>
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('site.sobre') }}" class="inline-flex items-center mt-8 px-6 py-3 rounded-lg bg-primary text-primary-foreground font-semibold text-sm hover:opacity-90 transition-all">
                    Saber Mais Sobre Nós
                </a>
            </div>
            <div class="relative">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62587.26!2d13.35!3d-8.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwNTQnMDAuMCJTIDEzwrAyMScwMC4wIkU!5e0!3m2!1spt-PT!2sao!4v1700000000000"
                    class="w-full h-80 rounded-2xl border-0" allowfullscreen loading="lazy"
                    title="Localização MC-COMERCIAL em Luanda"></iframe>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endpush
```

---

## 🚀 PASSO 4: Melhorar navbar.blade.php

**Ficheiro:** `resources/views/partials/navbar.blade.php`

Substitua **todo o conteúdo** por:

```blade
{{-- Navegação principal --}}
<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-border">
    <div class="container mx-auto px-4 h-20 flex items-center justify-between">
        {{-- Logo --}}
        <a href="{{ route('site.home') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto" alt="MC-COMERCIAL Logo">
            <span class="font-bold text-xl tracking-tight text-foreground">MC-COMERCIAL</span>
        </a>

        {{-- Desktop Nav --}}
        <div class="hidden lg:flex items-center gap-8">
            <a href="{{ route('site.home') }}" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors {{ request()->routeIs('site.home*') ? 'text-primary font-semibold' : '' }}">
                Início
            </a>
            <a href="{{ route('site.cursos') }}" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors {{ request()->routeIs('site.cursos') ? 'text-primary font-semibold' : '' }}">
                Cursos
            </a>
            <a href="{{ route('site.centros') }}" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors {{ request()->routeIs('site.centros') ? 'text-primary font-semibold' : '' }}">
                Centros
            </a>
            <a href="{{ route('site.servicos') }}" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors {{ request()->routeIs('site.servicos') ? 'text-primary font-semibold' : '' }}">
                Serviços
            </a>
            <a href="{{ route('site.loja') }}" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors {{ request()->routeIs('site.loja') ? 'text-primary font-semibold' : '' }}">
                Loja
            </a>
            <a href="{{ route('site.sobre') }}" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors {{ request()->routeIs('site.sobre') ? 'text-primary font-semibold' : '' }}">
                Sobre Nós
            </a>
            <a href="{{ route('site.contactos') }}" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors {{ request()->routeIs('site.contactos') ? 'text-primary font-semibold' : '' }}">
                Contactos
            </a>
            <button @click="$dispatch('open-modal', 'pre-inscricao')"
                class="px-6 py-2.5 rounded-full text-sm font-bold bg-primary text-primary-foreground hover:opacity-90 transition-all"
                style="box-shadow: var(--shadow-button);">
                Pré-Inscrição
            </button>
        </div>

        {{-- Mobile Hamburger --}}
        <button @click="open = !open" class="lg:hidden p-2 rounded-lg hover:bg-muted transition-colors" aria-label="Menu">
            <i x-show="!open" data-lucide="menu" class="w-6 h-6 text-foreground"></i>
            <i x-show="open" x-cloak data-lucide="x" class="w-6 h-6 text-foreground"></i>
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden border-t border-border bg-white">
        <div class="container mx-auto px-4 py-4 flex flex-col gap-2">
            <a href="{{ route('site.home') }}" class="py-3 px-4 rounded-lg text-sm font-medium hover:bg-muted transition-colors {{ request()->routeIs('site.home*') ? 'bg-muted text-primary' : 'text-foreground' }}">Início</a>
            <a href="{{ route('site.cursos') }}" class="py-3 px-4 rounded-lg text-sm font-medium hover:bg-muted transition-colors {{ request()->routeIs('site.cursos') ? 'bg-muted text-primary' : 'text-foreground' }}">Cursos</a>
            <a href="{{ route('site.centros') }}" class="py-3 px-4 rounded-lg text-sm font-medium hover:bg-muted transition-colors {{ request()->routeIs('site.centros') ? 'bg-muted text-primary' : 'text-foreground' }}">Centros</a>
            <a href="{{ route('site.servicos') }}" class="py-3 px-4 rounded-lg text-sm font-medium hover:bg-muted transition-colors {{ request()->routeIs('site.servicos') ? 'bg-muted text-primary' : 'text-foreground' }}">Serviços</a>
            <a href="{{ route('site.loja') }}" class="py-3 px-4 rounded-lg text-sm font-medium hover:bg-muted transition-colors {{ request()->routeIs('site.loja') ? 'bg-muted text-primary' : 'text-foreground' }}">Loja</a>
            <a href="{{ route('site.sobre') }}" class="py-3 px-4 rounded-lg text-sm font-medium hover:bg-muted transition-colors {{ request()->routeIs('site.sobre') ? 'bg-muted text-primary' : 'text-foreground' }}">Sobre Nós</a>
            <a href="{{ route('site.contactos') }}" class="py-3 px-4 rounded-lg text-sm font-medium hover:bg-muted transition-colors {{ request()->routeIs('site.contactos') ? 'bg-muted text-primary' : 'text-foreground' }}">Contactos</a>
            <button @click="$dispatch('open-modal', 'pre-inscricao')"
                class="mt-2 py-3 rounded-lg text-sm font-bold bg-primary text-primary-foreground hover:opacity-90 transition-all">
                Pré-Inscrição
            </button>
        </div>
    </div>
</nav>
```

---

## 🚀 PASSO 5: Melhorar footer.blade.php

**Ficheiro:** `resources/views/partials/footer.blade.php`

Substitua **todo o conteúdo** por:

```blade
{{-- Rodapé --}}
<footer class="bg-footer text-footer-foreground">
    <div class="container mx-auto px-4 py-16">
        <div class="grid md:grid-cols-4 gap-10">
            {{-- Marca --}}
            <div class="md:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto" alt="MC-COMERCIAL">
                    <span class="font-bold text-lg text-white">MC-COMERCIAL</span>
                </div>
                <p class="text-sm leading-relaxed opacity-70">
                    Centro de Formação Profissional em Luanda, Angola. Mais de 10 anos formando profissionais de excelência.
                </p>
            </div>

            {{-- Links Rápidos --}}
            <div>
                <h4 class="font-bold text-white mb-4">Links Rápidos</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('site.cursos') }}" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Cursos</a></li>
                    <li><a href="{{ route('site.centros') }}" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Centros</a></li>
                    <li><a href="{{ route('site.servicos') }}" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Serviços</a></li>
                    <li><a href="{{ route('site.loja') }}" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Loja</a></li>
                    <li><a href="{{ route('site.sobre') }}" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Sobre Nós</a></li>
                </ul>
            </div>

            {{-- Contactos --}}
            <div>
                <h4 class="font-bold text-white mb-4">Contactos</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 mt-0.5 opacity-70"></i>
                        <span class="opacity-70">Rua A, Bairro 1º de Maio Nº 05, 1º Andar, Luanda-Viana</span>
                    </li>
                    <li>
                        <a href="tel:+244929643510" class="flex items-center gap-2 opacity-70 hover:opacity-100 transition-all">
                            <i data-lucide="phone" class="w-4 h-4"></i>+244 929-643-510
                        </a>
                    </li>
                    <li>
                        <a href="tel:+244928966002" class="flex items-center gap-2 opacity-70 hover:opacity-100 transition-all">
                            <i data-lucide="phone" class="w-4 h-4"></i>+244 928-966-002
                        </a>
                    </li>
                    <li>
                        <a href="mailto:mucuanha.chineva@gmail.com" class="flex items-center gap-2 opacity-70 hover:opacity-100 transition-all">
                            <i data-lucide="mail" class="w-4 h-4"></i>mucuanha.chineva@gmail.com
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Horário --}}
            <div>
                <h4 class="font-bold text-white mb-4">Horário</h4>
                <ul class="space-y-2 text-sm opacity-70">
                    <li class="flex justify-between">
                        <span>Seg - Sex</span><span>8h00 - 18h00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Sábado</span><span>9h00 - 16h00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Domingo</span><span>Encerrado</span>
                    </li>
                </ul>
                <div class="flex gap-3 mt-6">
                    <a href="https://wa.me/244929643510" target="_blank" rel="noopener" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center hover:bg-accent transition-colors" aria-label="WhatsApp">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center hover:bg-accent transition-colors" aria-label="Facebook">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Bottom bar --}}
    <div class="border-t border-white/10">
        <div class="container mx-auto px-4 py-4 flex flex-col md:flex-row justify-between items-center gap-2 text-xs opacity-50">
            <p>&copy; {{ date('Y') }} MC-COMERCIAL. Todos os direitos reservados.</p>
            <p>Centro de Formação Profissional — Luanda, Angola</p>
        </div>
    </div>
</footer>
```

---

## 🚀 PASSO 6: Melhorar servicos.blade.php

**Ficheiro:** `resources/views/pages/servicos.blade.php`

Substitua **todo o conteúdo** por:

```blade
@extends('layouts.public')

@section('title', 'Serviços - MC-COMERCIAL')

@section('content')

{{-- Hero --}}
<section class="py-20 bg-background">
    <div class="container mx-auto px-4">
        <header class="max-w-2xl mb-16">
            <span class="text-accent font-semibold tracking-wider uppercase text-sm">Soluções Corporativas</span>
            <h1 class="section-title mt-4">Serviços de Consultoria e Formação</h1>
            <p class="section-subtitle">Soluções completas para o seu desenvolvimento profissional e empresarial</p>
        </header>

        @php
        $servicos = [
            ['icon' => 'graduation-cap', 'title' => 'Formação Profissional', 'desc' => 'Cursos especializados em diversas áreas do saber com certificação reconhecida', 'price' => 'Sob consulta'],
            ['icon' => 'briefcase', 'title' => 'Projectos Académicos', 'desc' => 'Apoio na elaboração de trabalhos, dissertações e projectos', 'price' => 'A partir de 50.000 Kz'],
            ['icon' => 'pen-tool', 'title' => 'Workshops', 'desc' => 'Sessões práticas intensivas com especialistas da indústria', 'price' => 'A partir de 30.000 Kz'],
            ['icon' => 'monitor', 'title' => 'Formação Online', 'desc' => 'Aprenda no seu ritmo com aulas gravadas e ao vivo', 'price' => 'A partir de 15.000 Kz'],
            ['icon' => 'target', 'title' => 'Consultoria Empresarial', 'desc' => 'Consultoria especializada para empresas e organizações', 'price' => 'Sob consulta'],
            ['icon' => 'lightbulb', 'title' => 'Certificações', 'desc' => 'Programas de certificação profissional reconhecidos', 'price' => 'Sob consulta'],
        ];
        @endphp

        <div class="grid md:grid-cols-3 gap-8">
            @foreach($servicos as $servico)
            <div class="group bg-card p-8 rounded-2xl border border-border hover:border-transparent transition-all duration-300"
                 style="box-shadow: var(--shadow-card);"
                 onmouseenter="this.style.boxShadow='var(--shadow-card-hover)'"
                 onmouseleave="this.style.boxShadow='var(--shadow-card)'">
                <div class="w-12 h-12 bg-accent/10 rounded-lg flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                    <i data-lucide="{{ $servico['icon'] }}" class="w-6 h-6 text-accent group-hover:text-primary-foreground"></i>
                </div>
                <h3 class="text-xl font-bold text-foreground mb-3">{{ $servico['title'] }}</h3>
                <p class="text-muted-foreground mb-4 leading-relaxed text-sm">{{ $servico['desc'] }}</p>
                <p class="text-sm font-semibold text-accent mb-4">{{ $servico['price'] }}</p>
                <a href="{{ route('site.contactos') }}" class="inline-flex items-center font-semibold text-sm text-primary hover:gap-2 transition-all">
                    Solicitar Proposta <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16" style="background: var(--gradient-hero);">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Interessado em Nossos Serviços?</h2>
        <p class="text-white/70 mb-8 max-w-lg mx-auto">Entre em contacto para discutir suas necessidades e obter uma proposta personalizada.</p>
        <a href="{{ route('site.contactos') }}" class="inline-flex items-center px-8 py-3.5 rounded-full bg-accent text-accent-foreground font-bold text-sm hover:opacity-90 transition-all" style="box-shadow: var(--shadow-button);">
            <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
            Contacte-nos Agora
        </a>
    </div>
</section>

{{-- FAQ --}}
<section class="py-20 bg-background">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-accent font-semibold tracking-wider uppercase text-sm">Dúvidas</span>
            <h2 class="section-title mt-4">Perguntas Frequentes</h2>
        </div>
        
        <div class="max-w-2xl mx-auto space-y-3" x-data="{ open: null }">
            @php
            $faqs = [
                ['q' => 'Como funciona a inscrição em um serviço?', 'a' => 'Pode inscrever-se através do formulário de contacto ou visitando nossos centros. A nossa equipa confirmará dentro de 24 horas.'],
                ['q' => 'Quais são as formas de pagamento?', 'a' => 'Aceitamos transferência bancária, pagamento em dinheiro nos nossos centros e parcelamento mediante análise.'],
                ['q' => 'Os certificados são reconhecidos?', 'a' => 'Sim! Todos os nossos certificados são reconhecidos pelos órgãos competentes em Angola.'],
                ['q' => 'Há descontos para grupos?', 'a' => 'Sim, oferecemos descontos especiais para inscrições em grupo. Entre em contacto para mais informações.'],
            ];
            @endphp

            @foreach($faqs as $index => $faq)
            <div class="bg-card rounded-xl border border-border overflow-hidden">
                <button @click="open = open === {{ $index }} ? null : {{ $index }}"
                    class="w-full text-left px-6 py-4 flex items-center justify-between">
                    <span class="font-semibold text-foreground">{{ $faq['q'] }}</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 text-muted-foreground transition-transform duration-200"
                       :class="open === {{ $index }} ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open === {{ $index }}" x-collapse x-cloak>
                    <p class="px-6 pb-4 text-sm text-muted-foreground leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
```

> **Nota:** O FAQ usa `x-collapse` do Alpine.js. Se não tiver o plugin, adicione-o ou use `x-show` com `x-transition`.

---

## 🚀 PASSO 7: Melhorar contactos.blade.php (validação)

**Ficheiro:** `resources/views/pages/contactos.blade.php`

Adicione validação Alpine.js ao formulário. Substitua o `<form>` existente por:

```blade
<form action="{{ route('site.contactos') }}" method="POST"
      x-data="{ 
          nome: '', email: '', telefone: '', assunto: '', mensagem: '',
          submitted: false,
          validEmail() { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email); },
          canSubmit() { return this.nome && this.validEmail() && this.assunto && this.mensagem.length >= 10; }
      }"
      @submit="submitted = true">
    @csrf

    <div class="space-y-4">
        {{-- Nome --}}
        <div>
            <label for="nome" class="block text-sm font-medium text-foreground mb-1">Nome Completo *</label>
            <input type="text" id="nome" name="nome" x-model="nome" required
                :class="submitted && !nome ? 'border-destructive ring-1 ring-destructive' : 'border-input'"
                class="w-full rounded-lg px-4 py-3 bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-accent transition-all"
                placeholder="O seu nome completo">
            <p x-show="submitted && !nome" x-cloak class="text-destructive text-xs mt-1">Nome é obrigatório</p>
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-foreground mb-1">Email *</label>
            <input type="email" id="email" name="email" x-model="email" required
                :class="submitted && !validEmail() ? 'border-destructive ring-1 ring-destructive' : 'border-input'"
                class="w-full rounded-lg px-4 py-3 bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-accent transition-all"
                placeholder="exemplo@email.com">
            <p x-show="submitted && !validEmail()" x-cloak class="text-destructive text-xs mt-1">Email inválido</p>
        </div>

        {{-- Telefone --}}
        <div>
            <label for="telefone" class="block text-sm font-medium text-foreground mb-1">Telefone</label>
            <input type="tel" id="telefone" name="telefone" x-model="telefone"
                class="w-full rounded-lg px-4 py-3 bg-background text-foreground border border-input focus:outline-none focus:ring-2 focus:ring-accent transition-all"
                placeholder="+244 9XX XXX XXX">
        </div>

        {{-- Assunto --}}
        <div>
            <label for="assunto" class="block text-sm font-medium text-foreground mb-1">Assunto *</label>
            <select id="assunto" name="assunto" x-model="assunto" required
                :class="submitted && !assunto ? 'border-destructive ring-1 ring-destructive' : 'border-input'"
                class="w-full rounded-lg px-4 py-3 bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-accent transition-all">
                <option value="">Selecione</option>
                <option value="geral">Geral</option>
                <option value="cursos">Cursos</option>
                <option value="produtos">Produtos</option>
                <option value="servicos">Serviços</option>
            </select>
        </div>

        {{-- Mensagem --}}
        <div>
            <label for="mensagem" class="block text-sm font-medium text-foreground mb-1">Mensagem *</label>
            <textarea id="mensagem" name="mensagem" x-model="mensagem" rows="5" required
                :class="submitted && mensagem.length < 10 ? 'border-destructive ring-1 ring-destructive' : 'border-input'"
                class="w-full rounded-lg px-4 py-3 bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-accent transition-all resize-none"
                placeholder="Escreva a sua mensagem (mínimo 10 caracteres)"></textarea>
            <p x-show="submitted && mensagem.length < 10" x-cloak class="text-destructive text-xs mt-1">Mensagem deve ter pelo menos 10 caracteres</p>
        </div>

        {{-- Submit --}}
        <button type="submit" :disabled="!canSubmit()"
            :class="canSubmit() ? 'bg-primary hover:opacity-90' : 'bg-muted cursor-not-allowed'"
            class="w-full py-3 rounded-lg text-sm font-bold text-primary-foreground transition-all"
            style="box-shadow: var(--shadow-button);">
            Enviar Mensagem
        </button>
    </div>
</form>
```

---

## 🚀 PASSO 8: Melhorar loja.blade.php

**Ficheiro:** `resources/views/pages/loja.blade.php`

As melhorias principais:
- Adicionar `loading="lazy"` a todas as imagens
- Melhorar acessibilidade dos tabs
- Remover menção a "Serviços" (agora tem página própria)

Substitua **todo o conteúdo** por:

```blade
@extends('layouts.public')

@section('title', 'Loja - MC-COMERCIAL')

@section('content')

<section class="py-20 bg-background">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-accent font-semibold tracking-wider uppercase text-sm">Loja Online</span>
            <h1 class="section-title mt-4">Loja MC-COMERCIAL</h1>
            <p class="section-subtitle">Snackbar e Produtos — tudo num só lugar</p>
        </div>

        {{-- Tabs --}}
        <div x-data="{ tab: '{{ $grupos->first()?->slug ?? 'snackbar' }}' }">
            <div class="flex flex-wrap justify-center gap-2 mb-10">
                @php $iconMap = ['snackbar' => 'utensils', 'produtos' => 'package']; @endphp
                @foreach($grupos as $grupo)
                @if(strtolower($grupo->slug ?? $grupo->nome) !== 'servicos')
                <button @click="tab = '{{ $grupo->slug ?? Str::slug($grupo->nome) }}'"
                    :class="tab === '{{ $grupo->slug ?? Str::slug($grupo->nome) }}' ? 'bg-primary text-primary-foreground' : 'bg-card text-foreground border border-border'"
                    class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200">
                    <i data-lucide="{{ $iconMap[strtolower($grupo->slug ?? $grupo->nome)] ?? 'box' }}" class="w-4 h-4 inline mr-1"></i>
                    {{ $grupo->display_name ?? $grupo->nome }}
                </button>
                @endif
                @endforeach
            </div>

            {{-- Tab Contents --}}
            @foreach($grupos as $grupo)
            @if(strtolower($grupo->slug ?? $grupo->nome) !== 'servicos')
            <div x-show="tab === '{{ $grupo->slug ?? Str::slug($grupo->nome) }}'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">
                
                @foreach($grupo->categorias as $categoria)
                @if($categoria->itens->count() > 0)
                <div class="mb-12">
                    <h3 class="text-xl font-bold text-foreground mb-2">{{ $categoria->nome }}</h3>
                    <p class="text-sm text-muted-foreground mb-6">{{ $categoria->descricao }}</p>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($categoria->itens as $item)
                        <div class="feature-card relative">
                            @if($item->destaque)
                            <span class="absolute top-3 right-3 px-2 py-1 rounded-md text-xs font-bold bg-accent text-accent-foreground z-10">Destaque</span>
                            @endif
                            <div class="aspect-square overflow-hidden rounded-xl mb-4">
                                <img src="{{ $item->imagem_url }}" alt="{{ $item->nome }}" loading="lazy"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            </div>
                            <h4 class="font-bold text-foreground mb-1 line-clamp-1">{{ $item->nome }}</h4>
                            <p class="text-xs text-muted-foreground mb-3 line-clamp-2">{{ $item->descricao }}</p>
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-accent">
                                    {{ $item->preco ? number_format($item->preco / 100, 2, ',', '.') . ' Kz' : 'Sob Consulta' }}
                                </span>
                                <a href="https://wa.me/244929643510?text={{ urlencode('Olá, tenho interesse no produto: ' . $item->nome) }}"
                                   target="_blank" rel="noopener"
                                   class="px-4 py-2 rounded-lg text-xs font-semibold bg-primary text-primary-foreground hover:opacity-90 transition-all">
                                    {{ $item->preco ? 'Pedir' : 'Contactar' }}
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>

@endsection
```

---

## 🚀 PASSO 9: Melhorar pre-inscricao-modal.blade.php (validação)

**Ficheiro:** `resources/views/partials/pre-inscricao-modal.blade.php`

Substitua **todo o conteúdo** por:

```blade
{{-- Modal de Pré-Inscrição --}}
<div x-data="{ 
    show: false, 
    nome: '', email: '', telefone: '', aceite: false,
    loading: false, submitted: false,
    validEmail() { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email); },
    canSubmit() { return this.nome && this.validEmail() && this.aceite; },
    async submit() {
        this.submitted = true;
        if (!this.canSubmit()) return;
        this.loading = true;
        try {
            const response = await fetch('{{ route('pre-inscricoes.store') }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nome: this.nome, email: this.email, telefone: this.telefone })
            });
            if (response.ok) {
                this.show = false;
                this.nome = ''; this.email = ''; this.telefone = ''; this.aceite = false; this.submitted = false;
                window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Pré-inscrição enviada com sucesso!', type: 'success' } }));
            } else {
                window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Erro ao enviar. Tente novamente.', type: 'error' } }));
            }
        } catch(e) {
            window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Erro de conexão. Tente novamente.', type: 'error' } }));
        }
        this.loading = false;
    }
}"
@open-modal.window="if ($event.detail === 'pre-inscricao') show = true"
x-show="show" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4">

    {{-- Overlay --}}
    <div @click="show = false" class="absolute inset-0 bg-foreground/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"></div>

    {{-- Content --}}
    <div class="relative bg-card rounded-2xl p-6 md:p-8 max-w-md w-full"
         style="box-shadow: var(--shadow-card-hover);"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">

        <button @click="show = false" class="absolute top-4 right-4 text-muted-foreground hover:text-foreground" aria-label="Fechar">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <h2 class="text-xl font-bold text-foreground mb-6">Pré-Inscrição</h2>

        <form @submit.prevent="submit()" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-foreground mb-1">Nome Completo *</label>
                <input type="text" x-model="nome" required
                    :class="submitted && !nome ? 'border-destructive' : 'border-input'"
                    class="w-full rounded-lg px-4 py-3 bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-accent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-foreground mb-1">Email *</label>
                <input type="email" x-model="email" required
                    :class="submitted && !validEmail() ? 'border-destructive' : 'border-input'"
                    class="w-full rounded-lg px-4 py-3 bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-accent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-foreground mb-1">Telefone</label>
                <input type="tel" x-model="telefone"
                    class="w-full rounded-lg px-4 py-3 bg-background text-foreground border border-input focus:outline-none focus:ring-2 focus:ring-accent transition-all">
            </div>
            <label class="flex items-start gap-2 cursor-pointer">
                <input type="checkbox" x-model="aceite" class="mt-1 rounded border-input text-primary focus:ring-accent">
                <span class="text-xs text-muted-foreground">Concordo com os termos e condições *</span>
            </label>

            <div class="flex gap-3 pt-2">
                <button type="button" @click="show = false" class="flex-1 py-3 rounded-lg border border-border text-sm font-medium text-foreground hover:bg-muted transition-all">
                    Cancelar
                </button>
                <button type="submit" :disabled="loading || !canSubmit()"
                    :class="canSubmit() ? 'bg-primary hover:opacity-90' : 'bg-muted cursor-not-allowed'"
                    class="flex-1 py-3 rounded-lg text-sm font-bold text-primary-foreground transition-all">
                    <span x-show="!loading">Inscrever-se</span>
                    <span x-show="loading" x-cloak>Enviando...</span>
                </button>
            </div>
        </form>
    </div>
</div>
```

---

## 📝 PASSO 10: Checklist Final

### Comandos para executar:

```bash
# 1. Instalar Alpine.js collapse plugin (opcional, para FAQ accordion)
npm install @alpinejs/collapse

# 2. No resources/js/app.js, adicionar:
# import collapse from '@alpinejs/collapse'
# Alpine.plugin(collapse)

# 3. Limpar cache Laravel
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 4. Recompilar assets
npm run build

# 5. Testar localmente
php artisan serve
```

### Ficheiros a modificar (resumo):

| # | Ficheiro | Acção |
|---|---------|-------|
| 1 | `app/Http/Controllers/SiteController.php` | Corrigir método `cursos()` — adicionar `$cursos` |
| 2 | `resources/views/pages/cursos.blade.php` | Substituir tudo (filtros Alpine, lazy loading) |
| 3 | `resources/views/pages/home.blade.php` | Substituir tudo (carousel Alpine funcional) |
| 4 | `resources/views/partials/navbar.blade.php` | Substituir tudo (mobile menu, link Serviços) |
| 5 | `resources/views/partials/footer.blade.php` | Substituir tudo (4 colunas, links completos) |
| 6 | `resources/views/pages/servicos.blade.php` | Substituir tudo (cards melhorados, FAQ) |
| 7 | `resources/views/pages/contactos.blade.php` | Actualizar formulário (validação Alpine) |
| 8 | `resources/views/pages/loja.blade.php` | Substituir tudo (filtrar servicos, lazy loading) |
| 9 | `resources/views/partials/pre-inscricao-modal.blade.php` | Substituir tudo (validação + fetch API) |

### Ficheiros que NÃO precisam mudar:
- ✅ `routes/web.php` — já tem `/site/servicos`
- ✅ `tailwind.config.js` — já está bem configurado
- ✅ `resources/css/app.css` — design tokens correctos
- ✅ `resources/views/layouts/public.blade.php` — funcional
- ✅ `resources/views/partials/topbar.blade.php` — funcional
- ✅ `resources/views/partials/whatsapp.blade.php` — funcional
- ✅ `resources/views/pages/sobre.blade.php` — funcional
- ✅ `resources/views/pages/centros.blade.php` — funcional

---

## ⚠️ NOTAS IMPORTANTES

1. **Imagens**: Certifique-se que tem os ficheiros `carousel-2.jpg`, `carousel-3.jpg`, `carousel-4.jpg` em `public/images/`. Se não existirem, o carousel mostrará imagens quebradas.

2. **Rota POST para pré-inscrição**: O modal faz `fetch` para `pre-inscricoes.store`. Verifique se esta rota existe no admin e aceita POST sem autenticação, ou crie uma rota pública:
```php
// Em routes/web.php, ANTES das rotas de admin:
Route::post('/pre-inscricao', [PreInscricaoController::class, 'store'])->name('pre-inscricoes.store.public');
```

3. **Rota POST para contacto**: Precisa de um método `store` no `SiteController` ou criar um `ContactoController`:
```php
// routes/web.php
Route::post('/site/contactos', [SiteController::class, 'enviarContacto'])->name('site.contactos.store');
```

4. **Alpine.js x-collapse**: Se não instalar o plugin, substitua `x-collapse` por:
```html
x-show="open === {{ $index }}"
x-transition:enter="transition ease-out duration-200"
x-transition:enter-start="opacity-0 max-h-0"
x-transition:enter-end="opacity-100 max-h-40"
```

5. **Lucide Icons**: O layout usa `<script src="https://unpkg.com/lucide@latest"></script>`. Certifique-se que chama `lucide.createIcons()` após Alpine inicializar.
