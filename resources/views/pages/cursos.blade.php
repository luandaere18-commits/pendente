@extends('layouts.public')

@section('title', 'Turmas - MC-COMERCIAL')

@section('content')

{{-- Page Hero --}}
<div class="page-hero text-center">
    <div class="container mx-auto px-4 relative z-10">
        <span class="section-tag text-accent-foreground/80 justify-center before:bg-white/40">
            <i data-lucide="book-open" class="w-3.5 h-3.5"></i> Formação
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-5" style="letter-spacing: -0.03em;">Nossas Turmas</h1>
        <p class="text-lg text-white/65 max-w-2xl mx-auto">Encontre a turma ideal e comece a sua formação</p>
    </div>
</div>

<div class="py-14 bg-background min-h-screen">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-4 gap-8" x-data="turmasFilter()">

            {{-- Sidebar de Filtros --}}
            <aside class="lg:col-span-1">
                <div class="feature-card sticky top-24 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-extrabold text-foreground flex items-center gap-2.5">
                            <div class="icon-box icon-box-sm bg-accent/10">
                                <i data-lucide="sliders-horizontal" class="w-4 h-4 text-accent"></i>
                            </div>
                            Filtros
                        </h3>
                        <button @click="resetFilters()"
                                x-show="search || status !== 'todos' || periodo !== 'todos' || centro !== 'todos'"
                                x-transition
                                class="text-xs text-accent font-bold hover:underline flex items-center gap-1">
                            <i data-lucide="rotate-ccw" class="w-3 h-3"></i>Limpar
                        </button>
                    </div>

                    {{-- Busca --}}
                    <div>
                        <label class="text-xs font-bold text-muted-foreground uppercase tracking-wider mb-2 block">Buscar Curso</label>
                        <div class="relative">
                            <i data-lucide="search" class="input-icon"></i>
                            <input type="text" x-model.debounce.300ms="search" placeholder="Nome do curso..."
                                   class="input-field pl-11 h-10 text-sm">
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="text-xs font-bold text-muted-foreground uppercase tracking-wider mb-2 block">Estado</label>
                        <div class="flex flex-col gap-1">
                            @foreach(['todos' => 'Todas', 'inscricoes_abertas' => 'Inscrições Abertas', 'planeada' => 'Planeada', 'em_andamento' => 'Em Andamento', 'concluida' => 'Concluída'] as $val => $label)
                                <label class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl cursor-pointer hover:bg-muted transition-all duration-200"
                                       :class="status === '{{ $val }}' ? 'bg-accent/8 text-accent' : ''">
                                    <input type="radio" x-model="status" value="{{ $val }}" class="text-accent">
                                    <span class="text-sm font-medium">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Período --}}
                    <div>
                        <label class="text-xs font-bold text-muted-foreground uppercase tracking-wider mb-2 block">Período</label>
                        <div class="flex flex-col gap-1">
                            @php
                                $periodoFilterOpts = [
                                    'todos' => ['label' => 'Todos', 'icon' => 'clock'],
                                    'manha' => ['label' => 'Manhã', 'icon' => 'sunrise'],
                                    'tarde' => ['label' => 'Tarde', 'icon' => 'sun'],
                                    'noite' => ['label' => 'Noite', 'icon' => 'moon'],
                                ];
                            @endphp
                            @foreach($periodoFilterOpts as $val => $opt)
                                <label class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl cursor-pointer hover:bg-muted transition-all duration-200"
                                       :class="periodo === '{{ $val }}' ? 'bg-accent/8 text-accent' : ''">
                                    <input type="radio" x-model="periodo" value="{{ $val }}" class="text-accent">
                                    <i data-lucide="{{ $opt['icon'] }}" class="w-3.5 h-3.5 shrink-0"></i>
                                    <span class="text-sm font-medium">{{ $opt['label'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Centro --}}
                    <div>
                        <label class="text-xs font-bold text-muted-foreground uppercase tracking-wider mb-2 block">Centro</label>
                        <select x-model="centro" class="input-field h-10 text-sm">
                            <option value="todos">Todos os Centros</option>
                            @foreach($centros as $c)
                                <option value="{{ $c->id }}">{{ $c->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Contador --}}
                    <div class="pt-4 border-t border-border text-center">
                        <span class="text-sm text-muted-foreground">
                            <span class="font-extrabold text-accent tabular-nums" x-text="visibleCount"></span>
                            <span x-text="visibleCount === 1 ? ' turma encontrada' : ' turmas encontradas'"></span>
                        </span>
                    </div>
                </div>
            </aside>

            {{-- Grid de Turmas --}}
            <div class="lg:col-span-3">

                {{-- Nenhum resultado --}}
                <div x-show="visibleCount === 0" x-transition class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="w-20 h-20 rounded-2xl bg-muted flex items-center justify-center mb-5">
                        <i data-lucide="calendar-x" class="w-10 h-10 text-muted-foreground"></i>
                    </div>
                    <h3 class="text-lg font-extrabold text-foreground mb-2">Nenhuma turma encontrada</h3>
                    <p class="text-sm text-muted-foreground mb-5">Tente ajustar os filtros de pesquisa</p>
                    <button @click="resetFilters()" class="btn-primary h-10 px-6 text-sm">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>Limpar filtros
                    </button>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($turmas as $turma)
                        @php
                            $vagasDisp  = $turma->vagas_totais - $turma->vagas_preenchidas;
                            $progress   = $turma->vagas_totais > 0 ? ($turma->vagas_preenchidas / $turma->vagas_totais) * 100 : 0;
                            $isLow      = $vagasDisp <= 5;
                            $diasSemana = is_array($turma->dia_semana) ? $turma->dia_semana : json_decode($turma->dia_semana ?? '[]', true);
                            $statusMap  = [
                                'planeada'           => ['label' => 'Planeada',           'color' => 'bg-amber-100 text-amber-700'],
                                'inscricoes_abertas' => ['label' => 'Inscrições Abertas', 'color' => 'bg-green-100 text-green-700'],
                                'em_andamento'       => ['label' => 'Em Andamento',       'color' => 'bg-blue-100 text-blue-700'],
                                'concluida'          => ['label' => 'Concluída',          'color' => 'bg-gray-100 text-gray-600'],
                            ];
                            $periodoMap     = ['manha' => 'Manhã',   'tarde' => 'Tarde',  'noite' => 'Noite'];
                            $periodoIconMap = ['manha' => 'sunrise', 'tarde' => 'sun',    'noite' => 'moon'];
                            $statusInfo     = $statusMap[$turma->status] ?? ['label' => $turma->status, 'color' => 'bg-muted text-muted-foreground'];
                        @endphp

                        <div class="turma-card group relative bg-card border border-border rounded-2xl overflow-hidden hover:-translate-y-1 transition-all duration-400"
                             style="box-shadow: var(--shadow-sm);"
                             onmouseover="this.style.boxShadow='var(--shadow-xl)'"
                             onmouseout="this.style.boxShadow='var(--shadow-sm)'"
                             x-show="filterTurma(
                                 '{{ strtolower($turma->curso->nome ?? '') }}',
                                 '{{ $turma->status }}',
                                 '{{ $turma->periodo }}',
                                 '{{ $turma->centro_id }}'
                             )"
                             x-transition>

                            {{-- Front --}}
                            <div class="card-front transition-all duration-400 group-hover:opacity-0 group-hover:pointer-events-none">
                                <div class="relative h-48 overflow-hidden bg-muted img-overlay">
                                    <img src="{{ $turma->curso->imagem_url ?? '' }}"
                                         alt="{{ $turma->curso->nome ?? 'Curso' }}"
                                         class="w-full h-full object-cover"
                                         loading="lazy"
                                         onerror="this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=60'">

                                    <div class="absolute top-3 left-3 z-10">
                                        <span class="badge text-[11px] {{ $statusInfo['color'] }}">{{ $statusInfo['label'] }}</span>
                                    </div>
                                    <div class="absolute top-3 right-3 z-10">
                                        <span class="badge text-xs bg-white/90 text-foreground backdrop-blur-sm">
                                            <i data-lucide="{{ $periodoIconMap[$turma->periodo] ?? 'clock' }}" class="w-3 h-3"></i>
                                            {{ $periodoMap[$turma->periodo] ?? $turma->periodo }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-5">
                                    <h4 class="font-extrabold text-foreground mb-1.5 line-clamp-1">{{ $turma->curso->nome ?? 'Curso' }}</h4>
                                    <p class="text-xs text-muted-foreground mb-3">{{ $turma->centro->nome ?? '—' }}</p>

                                    <div class="flex flex-wrap gap-1.5 mb-4 text-xs">
                                        @if($turma->hora_inicio && $turma->hora_fim)
                                            <span class="badge bg-muted text-muted-foreground">
                                                <i data-lucide="clock" class="w-3 h-3"></i>
                                                {{ \Carbon\Carbon::parse($turma->hora_inicio)->format('H:i') }}–{{ \Carbon\Carbon::parse($turma->hora_fim)->format('H:i') }}
                                            </span>
                                        @endif
                                        @if($turma->duracao_semanas)
                                            <span class="badge bg-muted text-muted-foreground">
                                                <i data-lucide="calendar" class="w-3 h-3"></i>
                                                {{ $turma->duracao_semanas }} sem.
                                            </span>
                                        @endif
                                        @if($turma->formador)
                                            <span class="badge bg-muted text-muted-foreground">
                                                <i data-lucide="user" class="w-3 h-3"></i>
                                                <span class="truncate max-w-[80px]">{{ $turma->formador->nome }}</span>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mb-4">
                                        <div class="flex justify-between text-[11px] mb-2">
                                            <span class="text-muted-foreground">Vagas preenchidas</span>
                                            <span class="font-bold {{ $isLow ? 'text-destructive' : 'text-foreground' }} tabular-nums">
                                                {{ $vagasDisp }} disponíve{{ $vagasDisp !== 1 ? 'is' : 'l' }}
                                            </span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill {{ $progress > 80 ? 'bg-destructive' : 'bg-accent' }}"
                                                 style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>

                                    @if($turma->status === 'inscricoes_abertas')
                                        <button onclick="window.dispatchEvent(new CustomEvent('pre-inscricao', { detail: { turmaId: {{ $turma->id }}, turmaNome: '{{ addslashes($turma->curso->nome ?? '') }} – {{ $periodoMap[$turma->periodo] ?? '' }}' } }))"
                                                class="btn-primary w-full h-10 text-sm rounded-xl">
                                            <i data-lucide="pen-line" class="w-4 h-4"></i>Pré-Inscrição
                                        </button>
                                    @else
                                        <a href="{{ route('site.contactos') }}"
                                           class="btn-ghost w-full h-10 text-sm rounded-xl">
                                            <i data-lucide="info" class="w-4 h-4"></i>Mais Informações
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Hover overlay --}}
                            <div class="card-back absolute inset-0 p-6 flex flex-col justify-between text-white
                                        opacity-0 group-hover:opacity-100 transition-opacity duration-400 pointer-events-none group-hover:pointer-events-auto"
                                 style="background: var(--gradient-hero);">
                                <div>
                                    <h4 class="font-extrabold text-base mb-4 leading-snug">{{ $turma->curso->nome ?? 'Curso' }}</h4>
                                    <div class="grid grid-cols-2 gap-x-4 gap-y-3 text-xs">
                                        <div class="flex items-start gap-2">
                                            <i data-lucide="building-2" class="w-3.5 h-3.5 shrink-0 opacity-50 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-50 text-[10px] uppercase tracking-wide mb-0.5">Centro</p>
                                                <p class="font-semibold">{{ $turma->centro->nome ?? '—' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <i data-lucide="{{ $periodoIconMap[$turma->periodo] ?? 'clock' }}" class="w-3.5 h-3.5 shrink-0 opacity-50 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-50 text-[10px] uppercase tracking-wide mb-0.5">Período</p>
                                                <p class="font-semibold">{{ $periodoMap[$turma->periodo] ?? $turma->periodo }}</p>
                                            </div>
                                        </div>
                                        @if($turma->hora_inicio && $turma->hora_fim)
                                        <div class="flex items-start gap-2">
                                            <i data-lucide="clock" class="w-3.5 h-3.5 shrink-0 opacity-50 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-50 text-[10px] uppercase tracking-wide mb-0.5">Horário</p>
                                                <p class="font-semibold tabular-nums">{{ \Carbon\Carbon::parse($turma->hora_inicio)->format('H:i') }}–{{ \Carbon\Carbon::parse($turma->hora_fim)->format('H:i') }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($turma->duracao_semanas)
                                        <div class="flex items-start gap-2">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5 shrink-0 opacity-50 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-50 text-[10px] uppercase tracking-wide mb-0.5">Duração</p>
                                                <p class="font-semibold">{{ $turma->duracao_semanas }} semanas</p>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="flex items-start gap-2">
                                            <i data-lucide="users" class="w-3.5 h-3.5 shrink-0 opacity-50 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-50 text-[10px] uppercase tracking-wide mb-0.5">Vagas</p>
                                                <p class="font-semibold {{ $isLow ? 'text-red-300' : 'text-green-300' }} tabular-nums">{{ $vagasDisp }} / {{ $turma->vagas_totais }}</p>
                                            </div>
                                        </div>
                                        @if($turma->formador)
                                        <div class="flex items-start gap-2">
                                            <i data-lucide="user-check" class="w-3.5 h-3.5 shrink-0 opacity-50 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-50 text-[10px] uppercase tracking-wide mb-0.5">Formador</p>
                                                <p class="font-semibold">{{ $turma->formador->nome }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if(count($diasSemana))
                                        <div class="flex items-start gap-2 col-span-2">
                                            <i data-lucide="calendar-days" class="w-3.5 h-3.5 shrink-0 opacity-50 mt-0.5"></i>
                                            <div>
                                                <p class="opacity-50 text-[10px] uppercase tracking-wide mb-0.5">Dias</p>
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
                                           class="btn-outline w-full h-10 text-sm rounded-xl">
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
