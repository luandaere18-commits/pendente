@extends('layouts.public')

@section('title', 'Cursos - MC-COMERCIAL')

@section('content')
<div class="py-12 bg-background min-h-screen">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h1 class="section-title">Nossos Cursos</h1>
            <p class="section-subtitle">Encontre o curso ideal para a sua carreira</p>
        </div>

        <div class="grid lg:grid-cols-4 gap-8" x-data="cursosFilter()">
            {{-- Filtros --}}
            <aside class="lg:col-span-1">
                <div class="feature-card sticky top-24 space-y-4">
                    <h3 class="font-bold text-foreground">Filtros</h3>

                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground"></i>
                        <input type="text" x-model="search" placeholder="Buscar curso..."
                               class="flex h-10 w-full rounded-md border border-input bg-background pl-9 pr-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-foreground mb-1 block">Modalidade</label>
                        <select x-model="modalidade" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                            <option value="todas">Todas</option>
                            <option value="presencial">Presencial</option>
                            <option value="online">Online</option>
                            <option value="hibrida">Híbrida</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-foreground mb-1 block">Área</label>
                        <select x-model="area" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                            <option value="todas">Todas</option>
                            @foreach($areas as $a)
                                <option value="{{ $a }}">{{ $a }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-foreground mb-1 block">Centro</label>
                        <select x-model="centro" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                            <option value="todas">Todos</option>
                            @foreach($centros as $c)
                                <option value="{{ $c->id }}">{{ $c->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button @click="search=''; modalidade='todas'; area='todas'; centro='todas'"
                            class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium border border-input bg-background h-9 px-4 hover:bg-accent hover:text-accent-foreground transition-colors">
                        <i data-lucide="x" class="w-4 h-4 mr-1"></i>Limpar Filtros
                    </button>
                </div>
            </aside>

            {{-- Grid de Cursos --}}
            <div class="lg:col-span-3">
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($cursos as $curso)
                        @php
                            $turmasCurso = $turmas->where('curso_id', $curso->id);
                            $totalVagas = $turmasCurso->sum('vagas_totais');
                            $totalPreenchidas = $turmasCurso->sum('vagas_preenchidas');
                            $progress = $totalVagas > 0 ? ($totalPreenchidas / $totalVagas) * 100 : 0;
                        @endphp
                        <div class="feature-card overflow-hidden"
                             x-show="filterCurso('{{ strtolower($curso->nome) }}', '{{ $curso->modalidade }}', '{{ $curso->area }}', '{{ $turmasCurso->pluck('centro_id')->implode(',') }}')"
                             x-transition>
                            <img src="{{ $curso->imagem_url }}" alt="{{ $curso->nome }}" class="w-full h-52 object-cover rounded-lg mb-4" loading="lazy">
                            <p class="text-xs text-accent font-semibold mb-1">⭐ {{ $turmasCurso->count() }} Turma{{ $turmasCurso->count() !== 1 ? 's' : '' }}</p>
                            <h3 class="text-lg font-bold text-foreground mb-2">{{ $curso->nome }}</h3>
                            <p class="text-sm text-muted-foreground mb-3 line-clamp-2">{{ $curso->descricao }}</p>
                            <div class="flex gap-2 mb-3">
                                <span class="badge-area">{{ $curso->area }}</span>
                                <span class="badge-modalidade">{{ $curso->modalidade }}</span>
                            </div>
                            @if($totalVagas > 0)
                                <div class="mb-4">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-muted-foreground flex items-center gap-1"><i data-lucide="users" class="w-3 h-3"></i>Vagas</span>
                                        <span>{{ $totalPreenchidas }} de {{ $totalVagas }}</span>
                                    </div>
                                    <div class="w-full h-2 bg-muted rounded-full overflow-hidden">
                                        <div class="h-full bg-accent rounded-full" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            @endif
                            <button @click="openTurmas({{ $curso->id }}, '{{ addslashes($curso->nome) }}')"
                                    class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground h-10 hover:bg-primary/90 transition-colors">
                                Ver Turmas Disponíveis
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Turmas Modal --}}
<div x-data="turmasModal()" x-show="open" x-cloak @open-turmas.window="showTurmas($event.detail)"
     class="fixed inset-0 z-50 flex items-center justify-center">
    <div class="fixed inset-0 bg-black/80" @click="open = false"></div>
    <div class="relative z-10 w-full max-w-lg bg-background border rounded-lg p-6 shadow-lg mx-4 max-h-[80vh] overflow-y-auto" x-transition>
        <button @click="open = false" class="absolute right-4 top-4 opacity-70 hover:opacity-100">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h2 class="text-lg font-semibold mb-4">Turmas - <span x-text="cursoNome"></span></h2>
        <div class="space-y-3" id="turmas-list"></div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function cursosFilter() {
    return {
        search: '', modalidade: 'todas', area: 'todas', centro: 'todas',
        filterCurso(nome, mod, ar, centroIds) {
            if (this.search && !nome.includes(this.search.toLowerCase())) return false;
            if (this.modalidade !== 'todas' && mod !== this.modalidade) return false;
            if (this.area !== 'todas' && ar !== this.area) return false;
            if (this.centro !== 'todas' && !centroIds.split(',').includes(this.centro)) return false;
            return true;
        },
        openTurmas(cursoId, cursoNome) {
            window.dispatchEvent(new CustomEvent('open-turmas', { detail: { cursoId, cursoNome } }));
        }
    }
}

function turmasModal() {
    return {
        open: false, cursoNome: '',
        async showTurmas(detail) {
            this.cursoNome = detail.cursoNome;
            const response = await fetch(`/api/cursos/${detail.cursoId}/turmas`);
            const turmas = await response.json();
            const list = document.getElementById('turmas-list');
            list.innerHTML = turmas.map(t => {
                const vagasDisp = t.vagas_totais - t.vagas_preenchidas;
                const vagasClass = vagasDisp < 5 ? 'bg-destructive/10 text-destructive' : 'bg-success/10 text-success';
                return `<div class="border rounded-lg p-4 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-sm capitalize">${t.periodo}</span>
                        <span class="badge-vagas ${vagasClass}">${vagasDisp} vagas</span>
                    </div>
                    <p class="text-sm text-muted-foreground flex items-center gap-1">📅 ${t.data_arranque_formatada}</p>
                    <p class="text-sm text-muted-foreground flex items-center gap-1">🕒 ${t.hora_inicio} - ${t.hora_fim} (${t.dias_semana.join(', ')})</p>
                    <p class="text-sm text-muted-foreground flex items-center gap-1">📍 ${t.centro?.nome}</p>
                    <button onclick="window.dispatchEvent(new CustomEvent('pre-inscricao', { detail: { turmaId: ${t.id}, turmaNome: '${detail.cursoNome} - ${t.periodo}' } }))"
                            class="w-full mt-2 inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground h-9 hover:bg-primary/90">
                        Inscrever-se
                    </button>
                </div>`;
            }).join('');
            this.open = true;
            setTimeout(() => lucide.createIcons(), 100);
        }
    }
}
</script>
@endpush
