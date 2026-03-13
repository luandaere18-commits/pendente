@extends('layouts.app')

@section('title', 'Turmas')

@section('content')
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col-12 col-md-8 mb-3 mb-md-0">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                    <i class="fas fa-clock text-primary fa-lg"></i>
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-0">Gestão de Turmas</h1>
                    <p class="text-muted mb-0 small">Gerir todas as turmas dos cursos no sistema</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovasTurma">
                <i class="fas fa-plus me-2"></i>Nova Turma
            </button>
        </div>
    </div>

    {{-- TABELA DE TURMAS --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-list text-primary"></i>
                <h5 class="mb-0 fw-semibold">Lista de Turmas</h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="turmasTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-2" style="width:50px">ID</th>
                            <th style="width:200px">Curso</th>
                            <th style="width:150px">Centro</th>
                            <th style="width:160px">Formador</th>
                            <th class="d-none d-lg-table-cell" style="width:150px">Dias</th>
                            <th class="text-center" style="width:110px">Status</th>
                            <th class="text-center" style="width:80px">Período</th>
                            <th class="text-center" style="width:100px">Horário</th>
                            <th class="text-center" style="width:100px">Vagas</th>
                            <th class="text-center" style="width:90px">Público</th>
                            <th class="text-end pe-2" style="width:150px">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($turmas as $turma)
                            <tr>
                                <td class="ps-2"><small class="text-muted">#{{ $turma->id }}</small></td>
                                <td><strong>{{ $turma->curso->nome ?? 'N/A' }}</strong></td>
                                <td>{{ $turma->centro->nome ?? '—' }}</td>
                                <td>
                                    @if($turma->formador)
                                        <strong>{{ $turma->formador->nome }}</strong>
                                    @else
                                        <span class="text-muted"><i class="fas fa-exclamation-triangle text-warning me-1"></i>Não atribuído</span>
                                    @endif
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    @if($turma->dia_semana && is_array($turma->dia_semana))
                                        @foreach($turma->dia_semana as $dia)
                                            <span class="badge bg-info-subtle text-info">{{ substr($dia, 0, 3) }}</span>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusColors = [
                                            'planeada' => 'secondary',
                                            'inscricoes_abertas' => 'success',
                                            'em_andamento' => 'info',
                                            'concluida' => 'dark'
                                        ];
                                        $statusLabels = [
                                            'planeada' => 'Planeada',
                                            'inscricoes_abertas' => 'Inscrições',
                                            'em_andamento' => 'Em Andamento',
                                            'concluida' => 'Concluída'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$turma->status] ?? 'secondary' }}-subtle text-{{ $statusColors[$turma->status] ?? 'secondary' }}">
                                        {{ $statusLabels[$turma->status] ?? $turma->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $icones = [
                                            'manhã' => 'fas fa-sun',
                                            'tarde' => 'fas fa-cloud-sun',
                                            'noite' => 'fas fa-moon'
                                        ];
                                        $icone = $icones[$turma->periodo] ?? 'fas fa-clock';
                                    @endphp
                                    <span class="badge bg-primary-subtle text-primary">
                                        <i class="{{ $icone }} me-1"></i>{{ ucfirst($turma->periodo) }}
                                    </span>
                                </td>
                                <td class="text-center text-nowrap">
                                    @if($turma->hora_inicio && $turma->hora_fim)
                                        {{ substr($turma->hora_inicio, 0, 5) }} - {{ substr($turma->hora_fim, 0, 5) }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="text-center">{{ $turma->vagas_preenchidas ?? 0 }}/{{ $turma->vagas_totais ?? 0 }}</td>
                                <td class="text-center">
                                    @if($turma->publicado)
                                        <span class="badge bg-success">Sim</span>
                                    @else
                                        <span class="badge bg-secondary">Não</span>
                                    @endif
                                </td>
                                <td class="text-end pe-2">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-info btn-visualizar-turma" onclick="visualizarTurma({{ $turma->id }})" title="Ver detalhes">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('turmas.show', $turma->id) }}" class="btn btn-outline-primary" title="Gerenciar">
                                            <i class="fas fa-cog"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" onclick="eliminarTurma({{ $turma->id }})" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5 text-muted">
                                    <div class="mb-2"><i class="fas fa-inbox fa-2x text-muted"></i></div>
                                    Nenhuma turma cadastrada
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Visualizar Turma --}}
<div class="modal fade" id="modalVisualizarTurma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-eye text-primary"></i>
                    <h5 class="modal-title fw-semibold mb-0">Detalhes da Turma</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="conteudoVisualizarTurma">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="text-muted mt-3 mb-0">Carregando detalhes...</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Criar Nova Turma --}}
<div class="modal fade" id="modalNovasTurma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            {{-- Header --}}
            <div class="modal-header bg-light border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-plus text-primary"></i>
                    </div>
                    <h5 class="modal-title fw-semibold mb-0">Criar Nova Turma</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formNovaTurmaAjax">
                    @csrf
                    <div class="row g-4">
                        {{-- COLUNA ESQUERDA --}}
                        <div class="col-12 col-md-6">
                            <div class="card border bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-book me-2"></i>Informações da Turma
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Curso <span class="text-danger">*</span></label>
                                        <select name="curso_id" class="form-select form-select-sm" required>
                                            <option value="">Selecione o curso</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Centro <span class="text-danger">*</span></label>
                                        <select name="centro_id" class="form-select form-select-sm" required>
                                            <option value="">Selecione o centro</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Formador</label>
                                        <select name="formador_id" class="form-select form-select-sm">
                                            <option value="">Selecione (opcional)</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Período <span class="text-danger">*</span></label>
                                        <select name="periodo" id="periodoNovo" class="form-select form-select-sm" required>
                                            <option value="">Selecione ou detecte pela hora</option>
                                            <option value="manhã">Manha</option>
                                            <option value="tarde">Tarde</option>
                                            <option value="noite">Noite</option>
                                        </select>
                                        <small class="text-muted d-block mt-1">Detecta automaticamente baseado na hora de início</small>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">Status</label>
                                        <select name="status" class="form-select form-select-sm" required>
                                            <option value="planeada" selected>Planeada</option>
                                            <option value="inscricoes_abertas">Inscrições Abertas</option>
                                            <option value="em_andamento">Em Andamento</option>
                                            <option value="concluida">Concluída</option>
                                        </select>
                                        <small class="text-muted d-block mt-1">Para "Inscrições Abertas" obrigatório ter formador</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- COLUNA DIREITA --}}
                        <div class="col-12 col-md-6">
                            <div class="card border bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-clock me-2"></i>Horário
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Hora Início <span class="text-danger">*</span></label>
                                        <input type="time" name="hora_inicio" id="horaInicioNovo" class="form-control form-control-sm" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Hora Fim</label>
                                        <input type="time" name="hora_fim" class="form-control form-control-sm">
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">Duração (Semanas)</label>
                                        <input type="number" name="duracao_semanas" min="1" max="52" class="form-control form-control-sm" placeholder="Número de semanas">
                                    </div>

                                    <div class="mt-3 mb-3">
                                        <label class="form-label fw-medium small">Vagas Disponíveis</label>
                                        <input type="number" name="vagas_totais" min="1" class="form-control form-control-sm" placeholder="Total de vagas">
                                    </div>

                                    <div class="form-check form-switch mt-3">
                                        <input class="form-check-input" type="checkbox" name="publicado" id="publicadoNovo" value="1">
                                        <label class="form-check-label small fw-medium" for="publicadoNovo">
                                            <i class="fas fa-globe me-1 text-info"></i>Publicar no site
                                        </label>
                                        <small class="text-muted d-block mt-1">Marque para mostrar esta turma no site público</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DIAS DA SEMANA --}}
                    <div class="mt-4">
                        <h6 class="fw-semibold mb-3">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>Dias da Semana
                        </h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana" type="checkbox" name="dia_semana[]" value="Segunda" id="dia_segunda_novo">
                                    <label class="form-check-label small" for="dia_segunda_novo">Segunda</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana" type="checkbox" name="dia_semana[]" value="Terça" id="dia_terca_novo">
                                    <label class="form-check-label small" for="dia_terca_novo">Terça</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana" type="checkbox" name="dia_semana[]" value="Quarta" id="dia_quarta_novo">
                                    <label class="form-check-label small" for="dia_quarta_novo">Quarta</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana" type="checkbox" name="dia_semana[]" value="Quinta" id="dia_quinta_novo">
                                    <label class="form-check-label small" for="dia_quinta_novo">Quinta</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana" type="checkbox" name="dia_semana[]" value="Sexta" id="dia_sexta_novo">
                                    <label class="form-check-label small" for="dia_sexta_novo">Sexta</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana" type="checkbox" name="dia_semana[]" value="Sábado" id="dia_sabado_novo">
                                    <label class="form-check-label small" for="dia_sabado_novo">Sábado</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana" type="checkbox" name="dia_semana[]" value="Domingo" id="dia_domingo_novo">
                                    <label class="form-check-label small" for="dia_domingo_novo">Domingo</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DATA ARRANQUE --}}
                    <div class="mt-4">
                        <label class="form-label fw-medium">Data de Arranque <span class="text-danger">*</span></label>
                        <input type="date" name="data_arranque" id="dataArranqueNovo" class="form-control" required>
                        <small class="text-muted d-block mt-1">Selecione apenas datas futuras</small>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="submit" form="formNovaTurmaAjax" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Criar Turma
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Editar Turma --}}
<div class="modal fade" id="modalEditarTurma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            {{-- Header --}}
            <div class="modal-header bg-light border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-2 bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-edit text-warning"></i>
                    </div>
                    <h5 class="modal-title fw-semibold mb-0">Editar Turma</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formEditarTurmaAjax">
                    @csrf
                    <input type="hidden" id="editTurmaId">
                    <div class="row g-4">
                        {{-- COLUNA ESQUERDA --}}
                        <div class="col-12 col-md-6">
                            <div class="card border bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-book me-2"></i>Informações da Turma
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Curso <span class="text-danger">*</span></label>
                                        <select id="editCursoId" class="form-select form-select-sm" required>
                                            <option value="">Selecione o curso</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Formador</label>
                                        <select id="editFormadorId" class="form-select form-select-sm">
                                            <option value="">Selecione (opcional)</option>
                                        </select>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">Período <span class="text-danger">*</span></label>
                                        <select id="editPeriodo" class="form-select form-select-sm" required>
                                            <option value="">Selecione ou detecte pela hora</option>
                                            <option value="manhã">Manha</option>
                                            <option value="tarde">Tarde</option>
                                            <option value="noite">Noite</option>
                                        </select>
                                        <small class="text-muted d-block mt-1">Detecta automaticamente baseado na hora de início</small>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">Status</label>
                                        <select id="editStatus" class="form-select form-select-sm">
                                            <option value="planeada">Planeada</option>
                                            <option value="inscricoes_abertas">Inscrições Abertas</option>
                                            <option value="em_andamento">Em Andamento</option>
                                            <option value="concluida">Concluída</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- COLUNA DIREITA --}}
                        <div class="col-12 col-md-6">
                            <div class="card border bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-clock me-2"></i>Horário
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Hora Início <span class="text-danger">*</span></label>
                                        <input type="time" id="editHoraInicio" class="form-control form-control-sm" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Hora Fim</label>
                                        <input type="time" id="editHoraFim" class="form-control form-control-sm">
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">Duração (Semanas)</label>
                                        <input type="number" id="editDuracaoSemanas" min="1" max="52" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DIAS DA SEMANA --}}
                    <div class="mt-4">
                        <h6 class="fw-semibold mb-3">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>Dias da Semana
                        </h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana-edit" type="checkbox" value="Segunda" id="dia_segunda_edit">
                                    <label class="form-check-label small" for="dia_segunda_edit">Segunda</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana-edit" type="checkbox" value="Terça" id="dia_terca_edit">
                                    <label class="form-check-label small" for="dia_terca_edit">Terça</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana-edit" type="checkbox" value="Quarta" id="dia_quarta_edit">
                                    <label class="form-check-label small" for="dia_quarta_edit">Quarta</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana-edit" type="checkbox" value="Quinta" id="dia_quinta_edit">
                                    <label class="form-check-label small" for="dia_quinta_edit">Quinta</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana-edit" type="checkbox" value="Sexta" id="dia_sexta_edit">
                                    <label class="form-check-label small" for="dia_sexta_edit">Sexta</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana-edit" type="checkbox" value="Sábado" id="dia_sabado_edit">
                                    <label class="form-check-label small" for="dia_sabado_edit">Sábado</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input dia-semana-edit" type="checkbox" value="Domingo" id="dia_domingo_edit">
                                    <label class="form-check-label small" for="dia_domingo_edit">Domingo</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DATA ARRANQUE --}}
                    <div class="mt-4">
                        <label class="form-label fw-medium">Data de Arranque <span class="text-danger">*</span></label>
                        <input type="date" id="editDataArranque" class="form-control" required>
                        <small class="text-muted d-block mt-1">Selecione apenas datas futuras</small>
                    </div>

                    {{-- VAGAS E PUBLICAÇÃO --}}
                    <div class="row g-3 mt-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Vagas Disponíveis</label>
                            <input type="number" id="editVagasTotais" min="1" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="editPublicado">
                                <label class="form-check-label fw-medium" for="editPublicado">
                                    <i class="fas fa-globe me-1 text-info"></i>Publicar no site
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="submit" form="formEditarTurmaAjax" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Atualizar Turma
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    console.log('JavaScript das turmas carregado');
    carregarFormadores();
    configurarEventosModal();
    configurarValidacoes();
    configurarAutoPreenchimento();
});

/**
 * Carregar lista de cursos disponíveis
 */
function carregarCursos() {
    console.log('Iniciando carregamento de cursos...');
    
    // Teste simples primeiro
    const $selectCurso = $('select[name="curso_id"]');
    console.log('Select curso encontrado:', $selectCurso.length);
    
    if ($selectCurso.length === 0) {
        console.error('Select de curso não encontrado!');
        return;
    }
    
    // Fazer requisição
    fetch('/api/cursos')
        .then(response => {
            console.log('Resposta HTTP:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Dados recebidos:', data);
            
            let options = '<option value="">Selecione o curso</option>';
            if (Array.isArray(data)) {
                data.forEach(function(curso) {
                    if (curso.ativo) {
                        options += `<option value="${curso.id}">${curso.nome}</option>`;
                    }
                });
                console.log('Options criadas:', options);
                $selectCurso.html(options);
                console.log('Options aplicadas ao select');
            } else {
                console.error('Dados não são array:', data);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
}

/**
 * Carregar centros associados a um curso
 */
function carregarCentrosPorCurso(cursoId) {
    const $select = $('#modalNovasTurma select[name="centro_id"]');
    console.log('Iniciando carregarCentrosPorCurso com cursoId:', cursoId);
    console.log('Select encontrado:', $select.length);
    console.log('Select element:', $select);

    if (!cursoId) {
        console.log('CursoId vazio, desabilitando select');
        $select.html('<option value="">Selecione um curso primeiro</option>').prop('disabled', true);
        return;
    }

    console.log('Desabilitando select e mostrando loading');
    $select.html('<option value="">Carregando centros...</option>').prop('disabled', true);

    $.ajax({
        url: `/api/cursos/${cursoId}`,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Resposta completa da API:', response);
            console.log('Status:', response.status);
            console.log('Dados:', response.dados);
            console.log('Centros:', response.dados ? response.dados.centros : 'undefined');

            let options = '<option value="">Selecione um centro</option>';
            if (response.dados && response.dados.centros && response.dados.centros.length > 0) {
                console.log('Encontrados', response.dados.centros.length, 'centros');
                response.dados.centros.forEach(function(centro) {
                    const preco = centro.pivot && centro.pivot.preco ? parseFloat(centro.pivot.preco).toLocaleString('pt-PT', {minimumFractionDigits:2, maximumFractionDigits:2}) + ' Kz' : '';
                    options += `<option value="${centro.id}" data-preco="${centro.pivot ? centro.pivot.preco : ''}">${centro.nome}${preco ? ' ('+preco+')' : ''}</option>`;
                });
                console.log('Habilitando select');
                $select.html(options);
                setTimeout(function() {
                    $select.prop('disabled', false).removeAttr('disabled');
                    console.log('Select habilitado após timeout?', !$select.prop('disabled'));
                }, 100);
            } else {
                console.log('Nenhum centro encontrado');
                options = '<option value="">Nenhum centro disponível para este curso</option>';
                $select.html(options).prop('disabled', true);
            }
        },
        error: function(xhr) {
            console.error('Erro ao carregar centros:', xhr);
            $select.html('<option value="">Erro ao carregar centros</option>').prop('disabled', true);
            Swal.fire('Erro', 'Não foi possível carregar os centros para este curso.', 'error');
        }
    });
}

/**
 * Carregar lista de formadores disponíveis
 */
function carregarFormadores() {
    $.ajax({
        url: '/api/formadores',
        method: 'GET',
        success: function(response) {
            const data = Array.isArray(response) ? response : (response.data || []);
            let options = '<option value="">Selecione (opcional)</option>';
            data.forEach(function(formador) {
                options += `<option value="${formador.id}">${formador.nome}</option>`;
            });
            $('select[name="formador_id"]').html(options);
            $('#editFormadorId').html(options);
        }
    });
}

/**
 * Recarregar página para atualizar lista de turmas
 */
function aplicarFiltros() {
    const curso = $('#filtroCurso').val() || '';
    const status = $('#filtroStatus').val() || '';
    const periodo = $('#filtroPeriodo').val() || '';
    
    let url = '/turmas?';
    if (curso) url += `curso_id=${curso}&`;
    if (status) url += `status=${encodeURIComponent(status)}&`;
    if (periodo) url += `periodo=${encodeURIComponent(periodo)}`;
    
    window.location.href = url;
}

function limparFiltros() {
    $('#filtroCurso').val('');
    $('#filtroStatus').val('');
    $('#filtroPeriodo').val('');
    window.location.href = '/turmas';
}

function carregarTurmas() {
    location.reload();
}

/**
 * Configurar eventos do modal
 */
function configurarEventosModal() {
    // Carregar cursos na inicialização
    carregarCursos();
    
    // Limpar form ao abrir modal CREATE
    $('#modalNovasTurma').on('show.bs.modal', function() {
        console.log('Modal de nova turma aberto');
        // Resetar formulário
        $('#formNovaTurmaAjax')[0].reset();
        $('#diasError').hide();
        $('#formNovaTurmaAjax .is-invalid').removeClass('is-invalid');
        $('.dia-semana').prop('checked', false);

        // Inicializar selects
        $('#modalNovasTurma select[name="centro_id"]').html('<option value="">Selecione um curso primeiro</option>').prop('disabled', true);

        // Carregar dados
        carregarCursos();
        carregarFormadores();
    });

    // Carregar centros quando curso for selecionado
    $(document).on('change', 'select[name="curso_id"]', function() {
        const cursoId = $(this).val();
        console.log('Evento change no select de curso disparado. Valor selecionado:', cursoId);
        if (cursoId) {
            carregarCentrosPorCurso(cursoId);
        } else {
            console.log('Nenhum curso selecionado, desabilitando select de centro');
            $('#modalNovasTurma select[name="centro_id"]').html('<option value="">Selecione o centro</option>').prop('disabled', true);
        }
    });

    // Submit CREATE
    $('#formNovaTurmaAjax').on('submit', function(e) {
        e.preventDefault();
        criarTurma();
    });

    // Submit EDIT
    $('#formEditarTurmaAjax').on('submit', function(e) {
        e.preventDefault();
        atualizarTurma();
    });
}

/**
 * Configurar validações de data (não permitir datas no passado)
 */
function configurarValidacoes() {
    // Obter data de hoje em formato YYYY-MM-DD
    const hoje = new Date().toISOString().split('T')[0];
    
    // Aplicar atributo min aos inputs de data
    $('#dataArranqueNovo').attr('min', hoje);
    $('#editDataArranque').attr('min', hoje);
    
    // Validação adicional no submit do formulário
    $('input[name="data_arranque"], #editDataArranque').on('change', function() {
        const dataEscolhida = new Date($(this).val());
        const dataHoje = new Date(hoje);
        if (dataEscolhida < dataHoje) {
            $(this).val('');
            Swal.fire('Aviso', 'Selecione uma data futura', 'warning');
        }
    });
}

/**
 * Auto-preencher período baseado na hora de início
 */
function configurarAutoPreenchimento() {
    // Função para detectar período baseado na hora
    function detectarPeriodo(hora) {
        if (!hora) return '';
        const horas = parseInt(hora.split(':')[0]);
        
        // Manha: 6h até 12h
        if (horas >= 6 && horas < 12) return 'manhã';
        // Tarde: 12h até 18h
        if (horas >= 12 && horas < 18) return 'tarde';
        // Noite: 18h até 6h
        if (horas >= 18 || horas < 6) return 'noite';
        
        return '';
    }
    
    // Modal CREATE - detectar período ao mudar hora_inicio
    $('#horaInicioNovo').on('change', function() {
        const periodo = detectarPeriodo($(this).val());
        if (periodo) {
            $('#periodoNovo').val(periodo);
        }
    });
    
    // Modal EDIT - detectar período ao mudar hora_inicio
    $('#editHoraInicio').on('change', function() {
        const periodo = detectarPeriodo($(this).val());
        if (periodo) {
            $('#editPeriodo').val(periodo);
        }
    });
}

/**
 * Visualizar detalhes da turma
 */
window.visualizarTurma = function(id) {
    $.ajax({
        url: `/api/turmas/${id}`,
        method: 'GET',
        success: function(response) {
            const turma = response.dados || response.data;
            
            const cursoNome = turma.curso ? turma.curso.nome : 'N/A';
            const formadorNome = turma.formador ? turma.formador.nome : '<span class="text-muted">Sem atribuição</span>';
            const diaSemana = turma.dia_semana ? turma.dia_semana.join(', ') : '—';
            const periodoBadge = getPeriodoBadge(turma.periodo);
            const horaInicio = turma.hora_inicio ? turma.hora_inicio.substring(0, 5) : '—';
            const horaFim = turma.hora_fim ? turma.hora_fim.substring(0, 5) : '—';
            const duracao = turma.duracao_semanas || '—';
            const dataArranque = turma.data_arranque ? new Date(turma.data_arranque).toLocaleDateString('pt-PT') : '—';
            
            const conteudo = `
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block fw-medium"><i class="fas fa-book me-1"></i>Curso</small>
                        <small><strong>${cursoNome}</strong></small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block fw-medium"><i class="fas fa-user me-1"></i>Formador</small>
                        <small>${formadorNome}</small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block fw-medium"><i class="fas fa-calendar-alt me-1"></i>Dias</small>
                        <small>${diaSemana}</small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block fw-medium"><i class="fas fa-sun me-1"></i>Período</small>
                        <small>${periodoBadge}</small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block fw-medium"><i class="fas fa-info-circle me-1"></i>Status</small>
                        <small>${getStatusBadge(turma.status)}</small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block fw-medium"><i class="fas fa-clock me-1"></i>Horário</small>
                        <small>${horaInicio} - ${horaFim}</small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block fw-medium"><i class="fas fa-hourglass-half me-1"></i>Duração</small>
                        <small>${duracao} semana(s)</small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block fw-medium"><i class="fas fa-calendar me-1"></i>Data de Arranque</small>
                        <small>${dataArranque}</small>
                    </div>
                </div>
            `;
            
            $('#conteudoVisualizarTurma').html(conteudo);
            new bootstrap.Modal(document.getElementById('modalVisualizarTurma')).show();
        },
        error: function() {
            Swal.fire('Erro', 'Erro ao carregar detalhes da turma', 'error');
        }
    });
};

/**
 * Abrir modal de edição
 */
window.abrirEdicaoTurma = function(id) {
    $.ajax({
        url: `/api/turmas/${id}`,
        method: 'GET',
        success: function(response) {
            const turma = response.dados || response.data;
            
            $('#editTurmaId').val(turma.id);
            $('#editCursoId').val(turma.curso_id);
            $('#editFormadorId').val(turma.formador_id || '');
            $('#editPeriodo').val(turma.periodo);
            $('#editStatus').val(turma.status || 'planeada');
            $('#editHoraInicio').val(turma.hora_inicio ? turma.hora_inicio.substring(0, 5) : '');
            $('#editHoraFim').val(turma.hora_fim ? turma.hora_fim.substring(0, 5) : '');
            $('#editDuracaoSemanas').val(turma.duracao_semanas || '');
            $('#editDataArranque').val(turma.data_arranque);
            $('#editVagasTotais').val(turma.vagas_totais || '');
            $('#editPublicado').prop('checked', turma.publicado || false);
            
            // Desselecionar todas
            $('.dia-semana-edit').prop('checked', false);
            
            // Selecionar dias da turma
            if (turma.dia_semana && Array.isArray(turma.dia_semana)) {
                turma.dia_semana.forEach(function(dia) {
                    $(`.dia-semana-edit[value="${dia}"]`).prop('checked', true);
                });
            }
            
            new bootstrap.Modal(document.getElementById('modalEditarTurma')).show();
        },
        error: function() {
            Swal.fire('Erro', 'Erro ao carregar dados da turma', 'error');
        }
    });
};

/**
 * Criar turma
 */
function criarTurma() {
    // Resetar validações anteriores
    $('#formNovaTurmaAjax .is-invalid').removeClass('is-invalid');
    $('#diasError').hide();

    const dia_semana = [];
    $('.dia-semana:checked').each(function() {
        dia_semana.push($(this).val());
    });

    if (dia_semana.length === 0) {
        $('#diasError').show();
        Swal.fire('Aviso', 'Selecione pelo menos um dia da semana', 'warning');
        return;
    }

    const formador_id = $('select[name="formador_id"]').val();
    const status = $('select[name="status"]').val();

    // Validação: formador obrigatório se status = inscrições_abertas
    if (status === 'inscricoes_abertas' && !formador_id) {
        $('select[name="formador_id"]').addClass('is-invalid');
        Swal.fire('Aviso', 'Para "Inscrições Abertas" é obrigatório selecionar um formador', 'warning');
        return;
    }

    // Coletar dados do formulário
    const dados = {
        curso_id: $('select[name="curso_id"]').val(),
        centro_id: $('#modalNovasTurma select[name="centro_id"]').val(),
        formador_id: formador_id || null,
        periodo: $('select[name="periodo"]').val() === 'manha' ? 'manhã' : $('select[name="periodo"]').val(),
        status: status || 'planeada',
        hora_inicio: $('input[name="hora_inicio"]').val(),
        hora_fim: $('input[name="hora_fim"]').val(),
        duracao_semanas: $('input[name="duracao_semanas"]').val(),
        data_arranque: $('input[name="data_arranque"]').val(),
        vagas_totais: $('input[name="vagas_totais"]').val() || null,
        publicado: $('input[name="publicado"]').is(':checked'),
        dia_semana: dia_semana
    };

    // Validações básicas
    const erros = [];
    if (!dados.curso_id) {
        $('select[name="curso_id"]').addClass('is-invalid');
        erros.push('Curso é obrigatório');
    }
    if (!dados.centro_id) {
        $('#modalNovasTurma select[name="centro_id"]').addClass('is-invalid');
        erros.push('Centro é obrigatório');
    }
    if (!dados.periodo) {
        $('select[name="periodo"]').addClass('is-invalid');
        erros.push('Período é obrigatório');
    }
    if (!dados.hora_inicio) {
        $('input[name="hora_inicio"]').addClass('is-invalid');
        erros.push('Hora de início é obrigatória');
    }
    if (!dados.data_arranque) {
        $('input[name="data_arranque"]').addClass('is-invalid');
        erros.push('Data de arranque é obrigatória');
    }

    if (erros.length > 0) {
        Swal.fire('Erro', erros.join('<br>'), 'error');
        return;
    }

    // Desabilitar botão durante o envio
    const $btn = $('#btnCriarTurma');
    const textoOriginal = $btn.html();
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Criando...');

    $.ajax({
        url: '/api/turmas',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(dados),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function(response) {
            Swal.fire('Sucesso!', 'Turma criada com sucesso', 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalNovasTurma')).hide();
            $('#formNovaTurmaAjax')[0].reset();
            $('#diasError').hide();
            carregarTurmas();
        },
        error: function(xhr) {
            console.error('Erro na criação:', xhr);
            const response = xhr.responseJSON || {};
            const errors = response.errors || {};
            let mensagem = response.mensagem || 'Erro ao criar turma';

            // Mostrar erros específicos nos campos
            Object.keys(errors).forEach(field => {
                const $field = $(`[name="${field}"]`);
                if ($field.length) {
                    $field.addClass('is-invalid');
                }
            });

            if (Object.keys(errors).length > 0) {
                mensagem += '<br><small>' + Object.values(errors).flat().join('<br>') + '</small>';
            }

            Swal.fire('Erro', mensagem, 'error');
        },
        complete: function() {
            $btn.prop('disabled', false).html(textoOriginal);
        }
    });
}

/**
 * Atualizar turma
 */
function atualizarTurma() {
    const turmaId = $('#editTurmaId').val();
    const dia_semana = [];
    $('.dia-semana-edit:checked').each(function() {
        dia_semana.push($(this).val());
    });
    
    if (dia_semana.length === 0) {
        Swal.fire('Aviso', 'Selecione pelo menos um dia da semana', 'warning');
        return;
    }
    
    const formador_id = $('#editFormadorId').val();
    const status = $('#editStatus').val();
    
    // Validação: formador obrigatório se status = inscrições_abertas
    if (status === 'inscricoes_abertas' && !formador_id) {
        Swal.fire('Aviso', 'Para "Inscrições Abertas" é obrigatório selecionar um formador', 'warning');
        return;
    }
    
    const dados = {
        curso_id: $('#editCursoId').val(),
        formador_id: formador_id || null,
        periodo: $('#editPeriodo').val() === 'manha' ? 'manhã' : $('#editPeriodo').val(),
        status: status || 'planeada',
        hora_inicio: $('#editHoraInicio').val(),
        hora_fim: $('#editHoraFim').val(),
        duracao_semanas: $('#editDuracaoSemanas').val(),
        data_arranque: $('#editDataArranque').val(),
        vagas_totais: $('#editVagasTotais').val() || null,
        publicado: $('#editPublicado').is(':checked'),
        dia_semana: dia_semana
    };
    
    $.ajax({
        url: `/api/turmas/${turmaId}`,
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(dados),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() {
            Swal.fire('Sucesso!', 'Turma atualizada com sucesso', 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalEditarTurma')).hide();
            carregarTurmas();
        },
        error: function(xhr) {
            const errors = xhr.responseJSON?.errors || {};
            let mensagem = 'Erro ao atualizar turma';
            if (Object.keys(errors).length > 0) {
                mensagem = Object.values(errors).flat().join(', ');
            }
            Swal.fire('Erro', mensagem, 'error');
        }
    });
}

/**
 * Eliminar turma
 */
window.eliminarTurma = function(id) {
    Swal.fire({
        title: 'Confirmar Eliminação',
        text: 'Tem a certeza que deseja eliminar esta turma?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/turmas/${id}`,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function() {
                    Swal.fire('Eliminada!', 'Turma eliminada com sucesso', 'success');
                    carregarTurmas();
                },
                error: function() {
                    Swal.fire('Erro', 'Erro ao eliminar turma', 'error');
                }
            });
        }
    });
};

/**
 * Auxiliar: Gerar badge de período
 */
function getPeriodoBadge(periodo) {
    const badges = {
        'manhã': '<span class="badge bg-warning text-dark"><i class="fas fa-sun me-1"></i>Manha</span>',
        'tarde': '<span class="badge bg-primary"><i class="fas fa-cloud-sun me-1"></i>Tarde</span>',
        'noite': '<span class="badge bg-dark"><i class="fas fa-moon me-1"></i>Noite</span>'
    };
    return badges[periodo] || '<span class="badge bg-secondary">N/A</span>';
}

/**
 * Auxiliar: Gerar badge de status
 */
function getStatusBadge(status) {
    const badges = {
        'planeada': '<span class="badge bg-secondary"><i class="fas fa-clock me-1"></i>Planeada</span>',
        'inscricoes_abertas': '<span class="badge bg-success"><i class="fas fa-unlock me-1"></i>Inscrições Abertas</span>',
        'em_andamento': '<span class="badge bg-info"><i class="fas fa-play-circle me-1"></i>Em Andamento</span>',
        'concluida': '<span class="badge bg-secondary"><i class="fas fa-check-circle me-1"></i>Concluída</span>'
    };
    return badges[status] || '<span class="badge bg-secondary">N/A</span>';
}
</script>
@endsection
