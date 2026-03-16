@extends('layouts.public')

@section('title', 'Turmas - MC-COMERCIAL')

@section('content')

{{-- Page Hero — gradiente azul moderno --}}
<div class="page-hero">
    <div class="container mx-auto px-4 text-center text-primary-foreground">
        <h1 class="text-4xl lg:text-5xl font-extrabold mb-4">Nossas Turmas</h1>
        <p class="text-lg opacity-80 max-w-2xl mx-auto">Encontre a turma ideal e comece a sua formação</p>
    </div>
</div>

<div class="py-12 bg-background min-h-screen">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-4 gap-8" x-data="turmasFilter()">

            {{-- Sidebar de Filtros --}}
            <aside class="lg:col-span-1">
                <div class="feature-card sticky top-24 space-y-5">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-foreground flex items-center gap-2">
                            <i data-lucide="sliders-horizontal" class="w-4 h-4 text-accent"></i>
                            Filtros
                        </h3>
                        <button @click="resetFilters()"
                                x-show="search || status !== 'todos' || periodo !== 'todos' || centro !== 'todos'"
                                x-transition
                                class="text-xs text-accent hover:underline flex items-center gap-1">
                            <i data-lucide="rotate-ccw" class="w-3 h-3"></i>Limpar
                        </button>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-1.5 block">Buscar Curso</label>
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground"></i>
                            <input type="text" x-model.debounce.300ms="search" placeholder="Nome do curso..."
                                   class="flex h-10 w-full rounded-xl border border-input bg-background pl-9 pr-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-1.5 block">Estado</label>
                        <div class="flex flex-col gap-1.5">
                            @foreach(['todos' => 'Todas', 'inscricoes_abertas' => 'Inscrições Abertas', 'planeada' => 'Planeada', 'em_andamento' => 'Em Andamento', 'concluida' => 'Concluída'] as $val => $label)
                                <label class="flex items-center gap-2.5 px-3 py-2 rounded-lg cursor-pointer hover:bg-muted transition-colors"
                                       :class="status === '{{ $val }}' ? 'bg-accent/10 text-accent' : ''">
                                    <input type="radio" x-model="status" value="{{ $val }}" class="text-accent">
                                    <span class="text-sm font-medium">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-1.5 block">Período</label>
                        <div class="flex flex-col gap-1.5">
                            @php
                                $periodoFilterOpts = [
                                    'todos' => ['label' => 'Todos', 'icon' => 'clock'],
                                    'manha' => ['label' => 'Manhã', 'icon' => 'sunrise'],
                                    'tarde' => ['label' => 'Tarde', 'icon' => 'sun'],
                                    'noite' => ['label' => 'Noite', 'icon' => 'moon'],
                                ];
                            @endphp
                            @foreach($periodoFilterOpts as $val => $opt)
                                <label class="flex items-center gap-2.5 px-3 py-2 rounded-lg cursor-pointer hover:bg-muted transition-colors"
                                       :class="periodo === '{{ $val }}' ? 'bg-accent/10 text-accent' : ''">
                                    <input type="radio" x-model="periodo" value="{{ $val }}" class="text-accent">
                                    <i data-lucide="{{ $opt['icon'] }}" class="w-3.5 h-3.5 shrink-0"></i>
                                    <span class="text-sm font-medium">{{ $opt['label'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-1.5 block">Centro</label>
                        <select x-model="centro"
                                class="flex h-10 w-full rounded-xl border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-all">
                            <option value="todos">Todos os Centros</option>
                            @foreach($centros as $c)
                                <option value="{{ $c->id }}">{{ $c->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-3 border-t border-border text-center">
                        <span class="text-sm text-muted-foreground">
                            <span class="font-bold text-accent" x-text="visibleCount"></span>
                            <span x-text="visibleCount === 1 ? ' turma encontrada' : ' turmas encontradas'"></span>
                        </span>
                    </div>
                </div>
            </aside>

            {{-- Grid de Turmas --}}
            <div class="lg:col-span-3">

                {{-- Nenhum resultado --}}
                <div x-show="visibleCount === 0" x-transition class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-muted flex items-center justify-center mb-4">
                        <i data-lucide="calendar-x" class="w-8 h-8 text-muted-foreground"></i>
                    </div>
                    <h3 class="text-lg font-bold text-foreground mb-2">Nenhuma turma encontrada</h3>
                    <p class="text-sm text-muted-foreground mb-4">Tente ajustar os filtros de pesquisa</p>
                    <button @click="resetFilters()"
                            class="inline-flex items-center gap-2 rounded-xl text-sm font-semibold bg-primary text-primary-foreground h-10 px-5 hover:bg-primary/90 active:scale-95 transition-all duration-200">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>Limpar filtros
                    </button>
                </div>

                @php
                    $popularityLabels = ['🔥 Alta procura', '⭐ Turma em destaque', '📈 Muito procurado', '🎯 Tendência de inscrição'];
                @endphp

                <div class="grid md:grid-cols-2 gap-5">
                    @foreach($turmas as $turma)
                        @php
                            $diasSemana  = is_array($turma->dia_semana) ? $turma->dia_semana : json_decode($turma->dia_semana ?? '[]', true);
                            $statusMap   = [
                                'planeada'           => ['label' => 'Planeada',           'color' => 'bg-warning/10 text-warning'],
                                'inscricoes_abertas' => ['label' => 'Inscrições Abertas', 'color' => 'bg-success/10 text-success'],
                                'em_andamento'       => ['label' => 'Em Andamento',       'color' => 'bg-accent/10 text-accent'],
                                'concluida'          => ['label' => 'Concluída',          'color' => 'bg-muted text-muted-foreground'],
                            ];
                            $periodoMap     = ['manha' => 'Manhã', 'tarde' => 'Tarde', 'noite' => 'Noite'];
                            $periodoIconMap = ['manha' => 'sunrise', 'tarde' => 'sun', 'noite' => 'moon'];
                            $statusInfo     = $statusMap[$turma->status] ?? ['label' => $turma->status, 'color' => 'bg-muted text-muted-foreground'];
                            $popLabel       = $popularityLabels[($turma->id ?? 0) % count($popularityLabels)];
                            $fakeProgress   = min(92, max(58, 60 + (($turma->id ?? 0) * 7) % 32));
                        @endphp

                        <div class="turma-card group relative bg-card border border-border rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                             x-show="filterTurma(
                                 '{{ strtolower($turma->curso->nome ?? '') }}',
                                 '{{ $turma->status }}',
                                 '{{ $turma->periodo }}',
                                 '{{ $turma->centro_id }}'
                             )"
                             x-transition>

                            {{-- Front --}}
                            <div class="card-front transition-all duration-300 group-hover:opacity-0 group-hover:pointer-events-none">
                                <div class="relative h-44 overflow-hidden bg-muted">
                                    <img src="{{ $turma->curso->imagem_url ?? '' }}"
                                         alt="{{ $turma->curso->nome ?? 'Curso' }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                         loading="lazy"
                                         onerror="this.src='{{ asset('assets/images-preview/courses/default.jpg') }}'">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                    <div class="absolute top-3 left-3">
                                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $statusInfo['color'] }}">{{ $statusInfo['label'] }}</span>
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold bg-white/90 text-foreground px-2.5 py-1 rounded-full">
                                            <i data-lucide="{{ $periodoIconMap[$turma->periodo] ?? 'clock' }}" class="w-3 h-3"></i>
                                            {{ $periodoMap[$turma->periodo] ?? $turma->periodo }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <h4 class="font-extrabold text-foreground mb-1 line-clamp-1">{{ $turma->curso->nome ?? 'Curso' }}</h4>
                                    <p class="text-xs text-muted-foreground mb-3">{{ $turma->centro->nome ?? '—' }}</p>

                                    <div class="flex flex-wrap gap-1.5 mb-3 text-xs">
                                        @if($turma->hora_inicio && $turma->hora_fim)
                                            <span class="inline-flex items-center gap-1 bg-muted text-muted-foreground px-2 py-1 rounded-lg">
                                                <i data-lucide="clock" class="w-3 h-3"></i>
                                                {{ \Carbon\Carbon::parse($turma->hora_inicio)->format('H:i') }}–{{ \Carbon\Carbon::parse($turma->hora_fim)->format('H:i') }}
                                            </span>
                                        @endif
                                        @if($turma->duracao_semanas)
                                            <span class="inline-flex items-center gap-1 bg-muted text-muted-foreground px-2 py-1 rounded-lg">
                                                <i data-lucide="calendar" class="w-3 h-3"></i>
                                                {{ $turma->duracao_semanas }} sem.
                                            </span>
                                        @endif
                                        @if($turma->formador)
                                            <span class="inline-flex items-center gap-1 bg-muted text-muted-foreground px-2 py-1 rounded-lg">
                                                <i data-lucide="user" class="w-3 h-3"></i>
                                                <span class="truncate max-w-[80px]">{{ $turma->formador->nome }}</span>
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Popularity indicator --}}
                                    <div class="mb-3">
                                        <div class="flex justify-between text-[11px] mb-1.5">
                                            <span class="popularity-label">{{ $popLabel }}</span>
                                        </div>
                                        <div class="popularity-bar">
                                            <div class="popularity-bar-fill" style="width: {{ $fakeProgress }}%"></div>
                                        </div>
                                    </div>

                                    @if($turma->status === 'inscricoes_abertas')
                                        <button onclick="window.dispatchEvent(new CustomEvent('pre-inscricao', { detail: { turmaId: {{ $turma->id }}, turmaNome: '{{ addslashes($turma->curso->nome ?? '') }} – {{ $periodoMap[$turma->periodo] ?? '' }}' } }))"
                                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl text-sm font-bold bg-primary text-primary-foreground h-10 hover:bg-primary/90 active:scale-95 transition-all duration-200 shadow-sm mt-1">
                                            <i data-lucide="pen-line" class="w-4 h-4"></i>Pré-Inscrição
                                        </button>
                                    @else
                                        <a href="{{ route('site.contactos') }}"
                                           class="w-full inline-flex items-center justify-center gap-2 rounded-xl text-sm font-semibold border border-input bg-background h-10 hover:bg-muted active:scale-95 transition-all duration-200 mt-1">
                                            <i data-lucide="info" class="w-4 h-4"></i>Mais Informações
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Hover overlay — GLASS style --}}
                            <div class="card-back absolute inset-0 glass-overlay text-primary-foreground p-5 flex flex-col justify-between rounded-2xl
                                        opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none group-hover:pointer-events-auto">
                                <div>
                                    <h4 class="font-extrabold text-base mb-3 leading-snug">{{ $turma->curso->nome ?? 'Curso' }}</h4>
                                    <div class="grid grid-cols-2 gap-x-4 gap-y-3 text-xs">
                                        <div class="flex items-start gap-2">
                                            <i data-lucide="building-2" class="w-3.5 h-3.5 shrink-0 opacity-60 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-60 text-[10px] uppercase tracking-wide mb-0.5">Centro</p>
                                                <p class="font-semibold">{{ $turma->centro->nome ?? '—' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <i data-lucide="{{ $periodoIconMap[$turma->periodo] ?? 'clock' }}" class="w-3.5 h-3.5 shrink-0 opacity-60 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-60 text-[10px] uppercase tracking-wide mb-0.5">Período</p>
                                                <p class="font-semibold">{{ $periodoMap[$turma->periodo] ?? $turma->periodo }}</p>
                                            </div>
                                        </div>
                                        @if($turma->hora_inicio && $turma->hora_fim)
                                        <div class="flex items-start gap-2">
                                            <i data-lucide="clock" class="w-3.5 h-3.5 shrink-0 opacity-60 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-60 text-[10px] uppercase tracking-wide mb-0.5">Horário</p>
                                                <p class="font-semibold">{{ \Carbon\Carbon::parse($turma->hora_inicio)->format('H:i') }}–{{ \Carbon\Carbon::parse($turma->hora_fim)->format('H:i') }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($turma->duracao_semanas)
                                        <div class="flex items-start gap-2">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5 shrink-0 opacity-60 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-60 text-[10px] uppercase tracking-wide mb-0.5">Duração</p>
                                                <p class="font-semibold">{{ $turma->duracao_semanas }} semanas</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($turma->formador)
                                        <div class="flex items-start gap-2">
                                            <i data-lucide="user-check" class="w-3.5 h-3.5 shrink-0 opacity-60 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-60 text-[10px] uppercase tracking-wide mb-0.5">Formador</p>
                                                <p class="font-semibold">{{ $turma->formador->nome }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if(is_array($diasSemana) && count($diasSemana))
                                        <div class="flex items-start gap-2 col-span-2">
                                            <i data-lucide="calendar-days" class="w-3.5 h-3.5 shrink-0 opacity-60 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-60 text-[10px] uppercase tracking-wide mb-0.5">Dias</p>
                                                <p class="font-semibold">{{ implode(', ', $diasSemana) }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 flex flex-col gap-2">
                                    @if($turma->status === 'inscricoes_abertas')
                                        <button onclick="window.dispatchEvent(new CustomEvent('pre-inscricao', { detail: { turmaId: {{ $turma->id }}, turmaNome: '{{ addslashes($turma->curso->nome ?? '') }} – {{ $periodoMap[$turma->periodo] ?? '' }}' } }))"
                                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl text-sm font-bold bg-white text-primary h-10 hover:bg-white/90 active:scale-95 transition-all duration-200">
                                            <i data-lucide="pen-line" class="w-4 h-4"></i>Pré-Inscrição
                                        </button>
                                    @else
                                        <a href="{{ route('site.contactos') }}"
                                           class="w-full inline-flex items-center justify-center gap-2 rounded-xl text-sm font-semibold border-2 border-white/30 text-white h-10 hover:bg-white/10 active:scale-95 transition-all duration-200">
                                            <i data-lucide="mail" class="w-4 h-4"></i>Pedir Informações
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function turmasFilter() {
    return {
        search: '',
        status: 'todos',
        periodo: 'todos',
        centro: 'todos',
        visibleCount: {{ $turmas->count() }},

        init() {
            const params = new URLSearchParams(window.location.search);
            const c = params.get('centro');
            if (c) this.centro = c;

            this.$watch('search',  () => this.$nextTick(() => this.recount()));
            this.$watch('status',  () => this.$nextTick(() => this.recount()));
            this.$watch('periodo', () => this.$nextTick(() => this.recount()));
            this.$watch('centro',  () => this.$nextTick(() => this.recount()));
        },

        filterTurma(cursoNome, turmaStatus, turmaPeriodo, centrId) {
            const matchSearch  = !this.search  || cursoNome.includes(this.search.toLowerCase().trim());
            const matchStatus  = this.status   === 'todos' || turmaStatus  === this.status;
            const matchPeriodo = this.periodo  === 'todos' || turmaPeriodo === this.periodo;
            const matchCentro  = this.centro   === 'todos' || String(centrId) === String(this.centro);
            return matchSearch && matchStatus && matchPeriodo && matchCentro;
        },

        recount() {
            const cards = this.$el.querySelectorAll('.turma-card');
            let count = 0;
            cards.forEach(card => {
                if (card.style.display !== 'none') count++;
            });
            this.visibleCount = count;
            lucide.createIcons();
        },

        resetFilters() {
            this.search   = '';
            this.status   = 'todos';
            this.periodo  = 'todos';
            this.centro   = 'todos';
        }
    }
}
</script>
@endpush
