@extends("layouts.app")

@section("title", "Visualizar Curso - " . $curso->nome)

@section("content")
<div class="container-fluid py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route("cursos.index") }}"><i class="fas fa-graduation-cap me-1"></i>Cursos</a></li>
            <li class="breadcrumb-item active">{{ $curso->nome }}</li>
        </ol>
    </nav>

    {{-- ============================================= --}}
    {{-- CARD PRINCIPAL - Informações do Curso         --}}
    {{-- ============================================= --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-start">

                {{-- Imagem --}}
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    @if($curso->imagem_url)
                        <img src="{{ $curso->imagem_url }}" alt="{{ $curso->nome }}"
                             class="img-fluid rounded shadow-sm" style="max-height: 140px; object-fit: cover; width: 100%;">
                    @else
                        <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center" style="height: 140px;">
                            <i class="fas fa-image fa-2x text-muted mb-1"></i>
                            <small class="text-muted">Sem imagem</small>
                        </div>
                    @endif
                </div>

                {{-- Info principal --}}
                <div class="col-md-7">
                    <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                        <h3 class="fw-bold mb-0">{{ $curso->nome }}</h3>
                        @if($curso->ativo)
                            <span class="badge bg-success-subtle text-success"><i class="fas fa-check-circle me-1"></i>Ativo</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary"><i class="fas fa-times-circle me-1"></i>Inativo</span>
                        @endif
                        @if($curso->modalidade === "online")
                            <span class="badge bg-info-subtle text-info"><i class="fas fa-globe me-1"></i>Online</span>
                        @elseif($curso->modalidade === "presencial")
                            <span class="badge bg-warning-subtle text-warning"><i class="fas fa-building me-1"></i>Presencial</span>
                        @else
                            <span class="badge bg-primary-subtle text-primary"><i class="fas fa-laptop-house me-1"></i>Híbrido</span>
                        @endif
                    </div>

                    <p class="text-muted mb-2">
                        <i class="fas fa-layer-group me-1"></i>
                        <strong>Área:</strong> {{ $curso->area }}
                    </p>

                    <p class="text-muted mb-0" style="max-width: 600px;">
                        <i class="fas fa-align-left me-1"></i>
                        {{ $curso->descricao ?? "Sem descrição disponível." }}
                    </p>
                </div>

                {{-- Ações + Contadores --}}
                <div class="col-md-3">
                    {{-- Botões de ação --}}
                    <div class="d-flex gap-2 mb-3 justify-content-md-end flex-wrap">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditarCurso">
                            <i class="fas fa-edit me-1"></i>Editar
                        </button>
                        <button class="btn btn-sm btn-outline-danger btn-eliminar-curso" data-curso-id="{{ $curso->id }}">
                            <i class="fas fa-trash me-1"></i>Eliminar
                        </button>
                        <a href="{{ route("cursos.index") }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Voltar
                        </a>
                    </div>

                    {{-- Mini contadores --}}
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="bg-primary-subtle rounded p-2 text-center">
                                <div class="fw-bold text-primary fs-5">{{ $curso->centros->count() }}</div>
                                <small class="text-muted"><i class="fas fa-building me-1"></i>Centros</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-info-subtle rounded p-2 text-center">
                                <div class="fw-bold text-info fs-5">{{ $curso->turmas->count() }}</div>
                                <small class="text-muted"><i class="fas fa-calendar me-1"></i>turmas</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- TABS - Centros / turmas / Pré-inscrições  --}}
    {{-- ============================================= --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 pt-3 px-4">
            <ul class="nav nav-tabs card-header-tabs" id="cursoTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-semibold" id="centros-tab" data-bs-toggle="tab" data-bs-target="#centros" type="button" role="tab">
                        <i class="fas fa-building me-1"></i>Centros
                        <span class="badge bg-primary ms-1">{{ $curso->centros->count() }}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-semibold" id="turmas-tab" data-bs-toggle="tab" data-bs-target="#turmas" type="button" role="tab">
                        <i class="fas fa-calendar-alt me-1"></i>turmas
                        <span class="badge bg-info ms-1">{{ $curso->turmas->count() }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="cursoTabsContent">

                {{-- ======================== --}}
                {{-- ABA: CENTROS             --}}
                {{-- ======================== --}}
                <div class="tab-pane fade show active" id="centros" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="fw-bold mb-0"><i class="fas fa-building me-2 text-primary"></i>Centros de Formação</h5>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarCentro">
                            <i class="fas fa-plus me-1"></i>Associar Centro
                        </button>
                    </div>

                    @if($curso->centros->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-building me-1 text-muted"></i>Nome do Centro</th>
                                        <th><i class="fas fa-coins me-1 text-muted"></i>Preço (Kz)</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($curso->centros as $centro)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $centro->nome }}</div>
                                            </td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success px-2 py-1">
                                                    {{ number_format($centro->pivot->preco, 2, ",", ".") }} Kz
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary me-1 btn-editar-centro"
                                                        data-centro-id="{{ $centro->id }}"
                                                        data-centro-nome="{{ $centro->nome }}"
                                                        data-preco="{{ $centro->pivot->preco }}"
                                                        type="button"
                                                        title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger btn-remover-centro"
                                                        data-centro-id="{{ $centro->id }}"
                                                        type="button"
                                                        title="Desassociar Centro">
                                                    <i class="fas fa-unlink"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-building fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">Nenhum centro associado a este curso.</p>
                        </div>
                    @endif
                </div>

                {{-- ======================== --}}
                {{-- ABA: turmas         --}}
                {{-- ======================== --}}
                <div class="tab-pane fade" id="turmas" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="fw-bold mb-0"><i class="fas fa-calendar-alt me-2 text-info"></i>turmas</h5>
                        <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalAdicionarturma">
                            <i class="fas fa-plus me-1"></i>Novo turma
                        </button>
                    </div>

                    @if($curso->turmas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Centro</th>
                                        <th>Preço</th>
                                        <th><i class="fas fa-calendar-week me-1 text-muted"></i>Dias da Semana</th>
                                        <th><i class="fas fa-sun me-1 text-muted"></i>Período</th>
                                        <th><i class="fas fa-chalkboard-teacher me-1 text-muted"></i>Formador</th>
                                        <th><i class="fas fa-hourglass-start me-1 text-muted"></i>Hora Início</th>
                                        <th><i class="fas fa-hourglass-end me-1 text-muted"></i>Hora Fim</th>
                                        <th><i class="fas fa-flag me-1 text-muted"></i>Status</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $turmasList = [];
                                        foreach($curso->turmas as $t) {
                                            if (!empty($t->centro_id)) {
                                                // já possui centro associado
                                                $t->centro = $t->centro ?? null;
                                                $turmasList[] = $t;
                                            } else {
                                                // replica para cada centro do curso
                                                foreach($curso->centros as $centro) {
                                                    $clone = clone $t;
                                                    $clone->centro = $centro;
                                                    $clone->centro_preco = $centro->pivot->preco ?? null;
                                                    $turmasList[] = $clone;
                                                }
                                            }
                                        }
                                    @endphp
                                    @foreach($turmasList as $turma)
                                        <tr>
                                            <td><span class="text-muted">{{ $loop->iteration }}</span></td>
                                            <td>
                                                @if($turma->centro)
                                                    <span class="fw-semibold">{{ $turma->centro->nome }}</span>
                                                @else
                                                    <span class="text-muted small">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($turma->centro_preco))
                                                    {{ number_format($turma->centro_preco,2,',','.') }} Kz
                                                @else
                                                    <span class="text-muted small">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(is_array($turma->dia_semana))
                                                    @foreach($turma->dia_semana as $dia)
                                                        <span class="badge bg-info-subtle text-info me-1">{{ substr($dia, 0, 3) }}</span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary">{{ ucfirst($turma->periodo) }}</span>
                                            </td>
                                            <td>
                                                @if($turma->formador_id)
                                                    <span class="text-success fw-semibold">{{ $turma->formador->nome ?? 'N/A' }}</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>Sem formador
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($turma->hora_inicio)
                                                    <strong>{{ substr($turma->hora_inicio, 0, 5) }}</strong>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($turma->hora_fim)
                                                    <strong>{{ substr($turma->hora_fim, 0, 5) }}</strong>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'planeada' => 'secondary',
                                                        'inscricoes_abertas' => 'success',
                                                        'em_andamento' => 'info',
                                                        'concluida' => 'dark'
                                                    ];
                                                    $statusLabels = [
                                                        'planeada' => 'Planeada',
                                                        'inscricoes_abertas' => 'Inscrições Abertas',
                                                        'em_andamento' => 'Em Andamento',
                                                        'concluida' => 'Concluída'
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $statusColors[$turma->status] ?? 'secondary' }}-subtle text-{{ $statusColors[$turma->status] ?? 'secondary' }}">
                                                    {{ $statusLabels[$turma->status] ?? $turma->status }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary btn-editar-turma"
                                                        data-turma-id="{{ $turma->id }}"
                                                        data-dias="{{ json_encode($turma->dia_semana) }}"
                                                        data-data-arranque="{{ $turma->data_arranque }}"
                                                        data-duracao-semanas="{{ $turma->duracao_semanas }}"
                                                        data-formador-id="{{ $turma->formador_id }}"
                                                        data-periodo="{{ $turma->periodo }}"
                                                        data-hora-inicio="{{ $turma->hora_inicio }}"
                                                        data-hora-fim="{{ $turma->hora_fim }}"
                                                        data-status="{{ $turma->status }}"
                                                        type="button"
                                                        title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-calendar-alt fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">Nenhum turma cadastrado.</p>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>

</div>

{{-- ============================================= --}}
{{-- MODAL: Editar Curso                           --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalEditarCurso" tabindex="-1" aria-labelledby="modalEditarCursoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-3">

            {{-- Header --}}
            <div class="modal-header bg-primary bg-opacity-10 border-0 py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-edit text-white small"></i>
                    </div>
                    <h5 class="modal-title fw-bold mb-0" id="modalEditarCursoLabel">Editar Curso: {{ $curso->nome }}</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formEditarCursoAjax" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                    
                    <div class="row g-4">

                        {{-- ====== COLUNA ESQUERDA ====== --}}
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100">
                                <div class="card-header bg-light border-bottom py-2 px-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-info-circle text-primary me-2"></i>Informações do Curso
                                    </h6>
                                </div>
                                <div class="card-body d-flex flex-column gap-3 p-3">

                                    {{-- Nome --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Nome <span class="text-danger">*</span></label>
                                        <input type="text" name="nome" class="form-control form-control-sm" value="{{ $curso->nome }}" required maxlength="100">
                                    </div>

                                    {{-- Área --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Área <span class="text-danger">*</span></label>
                                        <input type="text" name="area" class="form-control form-control-sm" value="{{ $curso->area }}" required maxlength="100">
                                    </div>

                                    {{-- Modalidade + Status --}}
                                    <div class="row g-3">
                                        <div class="col-7">
                                            <label class="form-label fw-medium small mb-1">Modalidade <span class="text-danger">*</span></label>
                                            <select name="modalidade" class="form-select form-select-sm" required>
                                                <option value="presencial" {{ $curso->modalidade === 'presencial' ? 'selected' : '' }}>Presencial</option>
                                                <option value="online" {{ $curso->modalidade === 'online' ? 'selected' : '' }}>Online</option>
                                                <option value="hibrido" {{ $curso->modalidade === 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                            </select>
                                        </div>
                                        <div class="col-5 d-flex align-items-end">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="ativo" id="editCursoAtivo" value="1" {{ $curso->ativo ? 'checked' : '' }}>
                                                <label class="form-check-label small" for="editCursoAtivo">Ativo</label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Imagem --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">
                                            <i class="fas fa-image text-muted me-1"></i>Imagem
                                        </label>
                                        <input type="file" name="imagem" class="form-control form-control-sm" accept="image/jpeg,image/png,image/jpg,image/gif">
                                        <div class="form-text small">JPEG, PNG, JPG, GIF (máx 2 MB)</div>
                                        @if($curso->imagem_url)
                                            <div class="mt-2">
                                                <small class="text-muted d-block mb-1">Imagem atual:</small>
                                                <img src="{{ $curso->imagem_url }}" alt="{{ $curso->nome }}" style="max-width: 100px; border-radius: 4px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ====== COLUNA DIREITA ====== --}}
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100">
                                <div class="card-header bg-light border-bottom py-2 px-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-file-alt text-primary me-2"></i>Conteúdo
                                    </h6>
                                </div>
                                <div class="card-body d-flex flex-column gap-3 p-3">

                                    {{-- Descrição --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Descrição</label>
                                        <textarea name="descricao" class="form-control form-control-sm" rows="4" placeholder="Breve descrição do curso..." maxlength="1000">{{ $curso->descricao }}</textarea>
                                    </div>

                                    {{-- Programa --}}
                                    <div class="flex-grow-1 d-flex flex-column">
                                        <label class="form-label fw-medium small mb-1">Programa do Curso</label>
                                        <textarea name="programa" class="form-control form-control-sm flex-grow-1" rows="6" placeholder="Conteúdo programático..." maxlength="5000">{{ $curso->programa }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ====== SEÇÃO DE CENTROS ====== --}}
                    <div class="mt-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-semibold mb-0">
                                <i class="fas fa-building text-primary me-2"></i>Centros de Formação
                            </h6>
                            <button type="button" id="adicionarCentroEditBtn" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Adicionar Centro
                            </button>
                        </div>
                        <div id="centrosContainerEdit" class="row g-3">
                            {{-- centros dinâmicos aqui --}}
                        </div>
                    </div>

                    {{-- Footer buttons (dentro do form) --}}
                    <div class="mt-4 d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary px-4" id="submitEditBtn">
                            <i class="fas fa-save me-1"></i>Atualizar Curso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- Template para Centro no Modal de Edição      --}}
{{-- ============================================= --}}
<template id="centroCursoEditTemplate">
    <div class="col-12 col-md-6">
        <div class="centro-card card border rounded-3 shadow-sm">
            <div class="card-header bg-light d-flex align-items-center justify-content-between py-2 px-3">
                <span class="badge bg-primary numero-centro-edit">Centro 1</span>
                <button type="button" class="btn btn-outline-danger btn-sm remover-centro-edit py-0 px-2" title="Remover">
                    <i class="fas fa-trash-alt small"></i>
                </button>
            </div>
            <div class="card-body p-3">
                <div class="d-flex flex-column gap-2">
                    <div>
                        <label class="form-label small mb-1 fw-medium">Centro <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm centro-id-edit" required>
                            <option value="">Selecione</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label small mb-1 fw-medium">Preço (Kz) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control form-control-sm preco-edit" placeholder="0,00" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

{{-- ============================================= --}}
{{-- MODAL: Associar Centro                        --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalAdicionarCentro" tabindex="-1" aria-labelledby="modalAdicionarCentroLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalAdicionarCentroLabel">
                    <i class="fas fa-plus-circle me-2"></i>Associar Novo Centro
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="formAdicionarCentroAjax">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Centro <span class="text-danger">*</span></label>
                            <select class="form-select" name="centro_id" required>
                                <option value="" disabled selected>Selecione um centro</option>
                                @foreach ($centros ?? [] as $centro)
                                    <option value="{{ $centro->id }}" {{ $curso->centros->contains($centro->id) ? "disabled" : "" }}>
                                        {{ $centro->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Preço (Kz) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="preco" required placeholder="0.00">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Editar Centro                          --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalEditarCentro" tabindex="-1" aria-labelledby="modalEditarCentroLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditarCentroLabel">
                    <i class="fas fa-edit me-2"></i>Editar Centro: <span id="editCentroNome"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="formEditarCentroAjax">
                @csrf
                <input type="hidden" name="centro_id" id="editCentroId">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Preço (Kz) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="preco" id="editCentroPreco" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Adicionar turma                   --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalAdicionarturma" tabindex="-1" aria-labelledby="modalAdicionarturmaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalAdicionarturmaLabel">
                    <i class="fas fa-calendar-plus me-2"></i>Adicionar turma
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="formAdicionarturmaAjax">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dias da Semana <span class="text-danger">*</span></label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach (["Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"] as $dia)
                                <div>
                                    <input type="checkbox" class="btn-check" name="dia_semana[]" value="{{ $dia }}" id="dia_{{ $loop->index }}" autocomplete="off">
                                    <label class="btn btn-outline-info btn-sm" for="dia_{{ $loop->index }}">{{ substr($dia, 0, 3) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Data de Arranque <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="data_arranque" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Duração (semanas)</label>
                            <input type="number" class="form-control" name="duracao_semanas" min="1" placeholder="Ex: 4">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Formador</label>
                            <select class="form-select" name="formador_id">
                                <option value="">Sem formador atribuído</option>
                                @foreach ($formadores ?? [] as $formador)
                                    <option value="{{ $formador->id }}">{{ $formador->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Período <span class="text-danger">*</span></label>
                            <select class="form-select" name="periodo" required>
                                <option value="" disabled selected>Selecione</option>
                                <option value="manhã">Manhã</option>
                                <option value="tarde">Tarde</option>
                                <option value="noite">Noite</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Hora Início</label>
                            <input type="time" class="form-control" name="hora_inicio">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Hora Fim</label>
                            <input type="time" class="form-control" name="hora_fim">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="status">
                                <option value="planeada">Planeada</option>
                                <option value="inscricoes_abertas">Inscrições Abertas</option>
                                <option value="em_andamento">Em Andamento</option>
                                <option value="concluida">Concluída</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-info text-white">
                        <i class="fas fa-save me-1"></i>Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Editar turma                      --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalEditarturma" tabindex="-1" aria-labelledby="modalEditarturmaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalEditarturmaLabel">
                    <i class="fas fa-edit me-2"></i>Editar turma
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="formEditarturmaAjax">
                @csrf
                <input type="hidden" name="turma_id" id="editturmaId">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dias da Semana <span class="text-danger">*</span></label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach (["Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"] as $dia)
                                <div>
                                    <input type="checkbox" class="btn-check" name="edit_dia_semana[]" value="{{ $dia }}" id="edit_dia_{{ $loop->index }}" autocomplete="off">
                                    <label class="btn btn-outline-info btn-sm" for="edit_dia_{{ $loop->index }}">{{ substr($dia, 0, 3) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Data de Arranque <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="edit_data_arranque" id="editturmaDataArranque" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Duração (semanas)</label>
                            <input type="number" class="form-control" name="edit_duracao_semanas" id="editturmaDuracao" min="1" placeholder="Ex: 4">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Formador</label>
                            <select class="form-select" name="edit_formador_id" id="editturmaFormador">
                                <option value="">Sem formador atribuído</option>
                                @foreach ($formadores ?? [] as $formador)
                                    <option value="{{ $formador->id }}">{{ $formador->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Período <span class="text-danger">*</span></label>
                            <select class="form-select" name="edit_periodo" id="editturmaPeriodo" required>
                                <option value="">Selecione</option>
                                <option value="manha">Manhã</option>
                                <option value="tarde">Tarde</option>
                                <option value="noite">Noite</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Hora Início</label>
                            <input type="time" class="form-control" name="edit_hora_inicio" id="editturmaHoraInicio">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Hora Fim</label>
                            <input type="time" class="form-control" name="edit_hora_fim" id="editturmaHoraFim">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="edit_status" id="editturmaStatus">
                                <option value="planeada">Planeada</option>
                                <option value="inscricoes_abertas">Inscrições Abertas</option>
                                <option value="em_andamento">Em Andamento</option>
                                <option value="concluida">Concluída</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-info text-white">
                        <i class="fas fa-save me-1"></i>Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section("scripts")
<script>
const cursoId = {{ $curso->id }};

/**
 * Editar Curso - AJAX
 */
$("#formEditarCursoAjax").on("submit", function(e) {
    e.preventDefault();
    
    const $form = $(this);
    const imagemFile = $form.find("[name=\"imagem\"]")[0].files[0];
    
    // Validação básica
    const nome = $form.find("[name=\"nome\"]").val().trim();
    const area = $form.find("[name=\"area\"]").val().trim();
    if (!nome || !area) {
        Swal.fire("Erro!", "Preencha os campos obrigatórios", "error");
        return;
    }
    
    // Se houver arquivo, usar FormData, senão usar JSON
    if (imagemFile) {
        const formData = new FormData();
        formData.append('nome', nome);
        formData.append('descricao', $form.find("[name=\"descricao\"]").val().trim());
        formData.append('programa', $form.find("[name=\"programa\"]").val().trim());
        formData.append('area', area);
        formData.append('modalidade', $form.find("[name=\"modalidade\"]").val().trim());
        formData.append('ativo', $form.find("[name=\"ativo\"]").is(":checked") ? 1 : 0);
        formData.append('imagem', imagemFile);
        
        $.ajax({
            url: `/api/cursos/${cursoId}`,
            type: "PUT",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content"),
                "Accept": "application/json"
            },
            success: function(response) {
                console.log("Sucesso:", response);
                $("#modalEditarCurso").modal("hide");
                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Curso atualizado com sucesso!",
                    timer: 2000
                }).then(() => location.reload());
            },
            error: function(xhr, status, error) {
                console.error("Status:", xhr.status);
                console.error("Response:", xhr.responseText);
                
                let message = "Erro desconhecido";
                if (xhr.responseJSON?.errors) {
                    message = Object.values(xhr.responseJSON.errors).flat().join("\n");
                } else if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: "error",
                    title: "Erro!",
                    text: message || "Erro ao atualizar curso."
                });
            }
        });
    } else {
        // Sem arquivo - usar JSON como antes
        const formData = {
            nome: nome,
            descricao: $form.find("[name=\"descricao\"]").val().trim(),
            programa: $form.find("[name=\"programa\"]").val().trim(),
            area: area,
            modalidade: $form.find("[name=\"modalidade\"]").val().trim(),
            ativo: $form.find("[name=\"ativo\"]").is(":checked") ? 1 : 0
        };
        
        $.ajax({
            url: `/api/cursos/${cursoId}`,
            type: "PUT",
            data: JSON.stringify(formData),
            contentType: "application/json",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content"),
                "Accept": "application/json"
            },
            success: function(response) {
                console.log("Sucesso:", response);
                $("#modalEditarCurso").modal("hide");
                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Curso atualizado com sucesso!",
                    timer: 2000
                }).then(() => location.reload());
            },
            error: function(xhr, status, error) {
                console.error("Status:", xhr.status);
                console.error("Status Text:", xhr.statusText);
                console.error("Response:", xhr.responseText);
                console.error("Response JSON:", xhr.responseJSON);
                
                let message = "Erro desconhecido";
                
                if (xhr.responseJSON?.errors) {
                    message = Object.values(xhr.responseJSON.errors).flat().join("\n");
                } else if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.responseJSON?.error) {
                    message = xhr.responseJSON.error;
                }
                
                Swal.fire({
                    icon: "error",
                    title: "Erro!",
                    text: message || "Erro ao atualizar curso."
                });
            }
        });
    }
});

/**
 * Adicionar Centro - AJAX
 */
$("#formAdicionarCentroAjax").on("submit", function(e) {
    e.preventDefault();
    
    const $form = $(this);
    const formData = {
        centro_id: parseInt($form.find("[name=\"centro_id\"]").val()),
        preco: parseFloat($form.find("[name=\"preco\"]").val().toString().replace(",", "."))
    };
    
    if (!formData.centro_id) {
        Swal.fire("Erro!", "Selecione um centro", "error");
        return;
    }
    
    $.ajax({
        url: `/api/cursos/${cursoId}/centros`,
        type: "POST",
        data: JSON.stringify(formData),
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
        },
        success: function(response) {
            $("#modalAdicionarCentro").modal("hide");
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Centro associado com sucesso!",
                timer: 2000
            }).then(() => location.reload());
        },
        error: function(xhr) {
            console.error("Erro:", xhr);
            const errors = xhr.responseJSON?.errors || { error: [xhr.responseJSON?.message || "Erro desconhecido"] };
            const message = Object.values(errors).flat().join("\n");
            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: message || "Erro ao associar centro."
            });
        }
    });
});

/**
 * Editar Centro - Abre Modal
 */
$(document).on("click", ".btn-editar-centro", function() {
    const id = $(this).data("centro-id");
    const nome = $(this).data("centro-nome");
    const preco = $(this).data("preco");
    
    $("#editCentroId").val(id);
    $("#editCentroNome").text(nome);
    $("#editCentroPreco").val(preco);
    $("#modalEditarCentro").modal("show");
});

/**
 * Atualizar Centro - AJAX
 */
$("#formEditarCentroAjax").on("submit", function(e) {
    e.preventDefault();
    const $form = $(this);
    const centroId = $form.find("[name=\"centro_id\"]").val();
    
    if (!centroId) {
        Swal.fire("Erro!", "Centro ID não encontrado", "error");
        return;
    }
    
    const formData = {
        preco: parseFloat($form.find("[name=\"preco\"]").val().toString().replace(",", "."))
    };
    
    if (!formData.preco) {
        Swal.fire("Erro!", "Preencha o preço", "error");
        return;
    }
    
    $.ajax({
        url: `/api/cursos/${cursoId}/centros/${centroId}`,
        type: "PUT",
        data: JSON.stringify(formData),
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
        },
        success: function(response) {
            $("#modalEditarCentro").modal("hide");
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Centro atualizado com sucesso!",
                timer: 2000
            }).then(() => location.reload());
        },
        error: function(xhr) {
            console.error("Erro completo:", xhr);
            console.error("Status:", xhr.status);
            console.error("Response:", xhr.responseJSON);
            const errors = xhr.responseJSON?.errors || { error: [xhr.responseJSON?.message || xhr.statusText || "Erro desconhecido"] };
            const message = Object.values(errors).flat().join("\n");
            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: message || "Erro ao atualizar centro."
            });
        }
    });
});

/**
 * Remover Centro - AJAX
 */
$(document).on("click", ".btn-remover-centro", function() {
    const $btn = $(this);
    const centroId = $btn.data("centro-id");
    
    if (!centroId) {
        Swal.fire("Erro!", "ID do centro não encontrado", "error");
        return;
    }
    
    Swal.fire({
        title: "Desassociar centro?",
        text: "O centro será desassociado deste curso. Os dados do centro permanecerão no sistema.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc2626",
        cancelButtonColor: "#64748b",
        confirmButtonText: "Sim, desassociar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/cursos/${cursoId}/centros/${centroId}`,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
                },
                success: function() {
                    Swal.fire("Desassociado!", "Centro desassociado com sucesso.", "success").then(() => location.reload());
                },
                error: function(xhr) {
                    console.error("Erro:", xhr);
                    const errors = xhr.responseJSON?.errors || { error: [xhr.responseJSON?.message || "Erro desconhecido"] };
                    const message = Object.values(errors).flat().join("\n");
                    Swal.fire("Erro!", message || "Ocorreu um erro ao remover o centro.", "error");
                }
            });
        }
    });
});

/**
 * Adicionar turma - AJAX
 */
$("#formAdicionarturmaAjax").on("submit", function(e) {
    e.preventDefault();
    
    const $form = $(this);
    const dias = $form.find("input[name=\"dia_semana[]\"]:checked").map(function() {
        return $(this).val();
    }).get();
    
    if (dias.length === 0) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Selecione pelo menos um dia da semana."
        });
        return;
    }
    
    const formData = {
        curso_id: cursoId,
        dia_semana: dias,
        data_arranque: $form.find("input[name=\"data_arranque\"]").val(),
        duracao_semanas: $form.find("input[name=\"duracao_semanas\"]").val() || null,
        periodo: $form.find("select[name=\"periodo\"]").val(),
        formador_id: $form.find("select[name=\"formador_id\"]").val() || null,
        hora_inicio: $form.find("input[name=\"hora_inicio\"]").val() || null,
        hora_fim: $form.find("input[name=\"hora_fim\"]").val() || null,
        status: $form.find("select[name=\"status\"]").val()
    };
    
    $.ajax({
        url: `/api/turmas`,
        type: "POST",
        data: JSON.stringify(formData),
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
        },
        success: function(response) {
            $("#modalAdicionarturma").modal("hide");
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "turma adicionado com sucesso!",
                timer: 2000
            }).then(() => location.reload());
        },
        error: function(xhr) {
            console.error("Erro:", xhr);
            const errors = xhr.responseJSON?.errors || { error: [xhr.responseJSON?.message || "Erro desconhecido"] };
            const message = Object.values(errors).flat().join("\n");
            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: message || "Erro ao adicionar turma."
            });
        }
    });
});

/**
 * Editar turma - Abre Modal
 */
$(document).on("click", ".btn-editar-turma", function() {
    const id = $(this).data("turma-id");
    let dias = $(this).data("dias");
    const dataArranque = $(this).data("data-arranque");
    const duracaoSemanas = $(this).data("duracao-semanas");
    let periodo = $(this).data("periodo");
    const horaInicio = $(this).data("hora-inicio");
    const horaFim = $(this).data("hora-fim");
    const formadorId = $(this).data("formador-id");
    const status = $(this).data("status");
    
    if (typeof dias === "string") {
        dias = JSON.parse(dias);
    }
    
    // Normalizar período: "manhã" -> "manha"
    if (periodo === "manhã") {
        periodo = "manha";
    }
    
    $("#editturmaId").val(id);
    $("#editturmaDataArranque").val(dataArranque);
    $("#editturmaDuracao").val(duracaoSemanas || "");
    $("#editturmaFormador").val(formadorId || "");
    $("#editturmaPeriodo").val(periodo);
    $("#editturmaHoraInicio").val(horaInicio ? horaInicio.substring(0, 5) : "");
    $("#editturmaHoraFim").val(horaFim ? horaFim.substring(0, 5) : "");
    $("#editturmaStatus").val(status);
    
    $("input[name=\"edit_dia_semana[]\"]").prop("checked", false).each(function() {
        if (dias && dias.includes($(this).val())) {
            $(this).prop("checked", true);
        }
    });
    
    $("#modalEditarturma").modal("show");
});

/**
 * Atualizar turma - AJAX
 */
$("#formEditarturmaAjax").on("submit", function(e) {
    e.preventDefault();
    const $form = $(this);
    const turmaId = $form.find("[name=\"turma_id\"]").val();
    
    const dias = $form.find("input[name=\"edit_dia_semana[]\"]:checked").map(function() {
        return $(this).val();
    }).get();
    
    if (dias.length === 0) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Selecione pelo menos um dia da semana."
        });
        return;
    }
    
    const formData = {
        data_arranque: $form.find("input[name=\"edit_data_arranque\"]").val(),
        duracao_semanas: $form.find("input[name=\"edit_duracao_semanas\"]").val() || null,
        dia_semana: dias,
        periodo: $form.find("select[name=\"edit_periodo\"]").val(),
        formador_id: $form.find("select[name=\"edit_formador_id\"]").val() || null,
        hora_inicio: $form.find("input[name=\"edit_hora_inicio\"]").val() || null,
        hora_fim: $form.find("input[name=\"edit_hora_fim\"]").val() || null,
        status: $form.find("select[name=\"edit_status\"]").val()
    };
    
    $.ajax({
        url: `/api/turmas/${turmaId}`,
        type: "PUT",
        data: JSON.stringify(formData),
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
        },
        success: function() {
            $("#modalEditarturma").modal("hide");
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "turma atualizado com sucesso!",
                timer: 2000
            }).then(() => location.reload());
        },
        error: function(xhr) {
            console.error("Erro:", xhr);
            const errors = xhr.responseJSON?.errors || { error: [xhr.responseJSON?.message || "Erro desconhecido"] };
            const message = Object.values(errors).flat().join("\n");
            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: message || "Erro ao atualizar turma."
            });
        }
    });
});

/**
 * Modal Editar Curso - Lógica
 */
let centrosEditCount = 0;
let centrosDisponiveisEditList = [];

// Dados do curso para edição
const cursoDataEdit = {!! json_encode([
    'id' => $curso->id,
    'centros' => $curso->centros
]) !!};

// Carregar centros disponíveis para edição
function carregarCentrosEdit() {
    $.ajax({
        url: '/api/centros',
        method: 'GET',
        success: function(data) {
            centrosDisponiveisEditList = data;
        },
        error: function(err) {
            console.error('Erro ao carregar centros:', err);
        }
    });
}

// Abrir modal de edição
$('#modalEditarCurso').on('show.bs.modal', function() {
    $('#formEditarCursoAjax')[0].reset();
    $('#centrosContainerEdit').empty();
    centrosEditCount = 0;
    
    // Carregar dados existentes
    carregarCentrosExistentesEdit();
    
    // Se não há centros, adicionar um vazio
    if ($('#centrosContainerEdit').find('.col-12').length === 0) {
        adicionarCentroEdit();
    }
});

// Carregar centros existentes para edição
function carregarCentrosExistentesEdit() {
    if (!cursoDataEdit || !cursoDataEdit.centros || cursoDataEdit.centros.length === 0) {
        return;
    }
    
    cursoDataEdit.centros.forEach((centro, index) => {
        try {
            const template = document.getElementById('centroCursoEditTemplate');
            if (!template) return;
            
            const clone = template.content.cloneNode(true);
            const wrapper = document.createElement('div');
            wrapper.appendChild(clone);
            
            let html = wrapper.innerHTML
                .replace(/numero-centro-edit">Centro 1</, `numero-centro-edit">Centro ${index + 1}<`);
            
            const colDiv = document.createElement('div');
            colDiv.innerHTML = html;
            $('#centrosContainerEdit').append(colDiv.firstElementChild);
            
            // Preencher com dados existentes
            const selects = $('#centrosContainerEdit').find('.centro-id-edit');
            const lastSelect = selects.last();
            
            centrosDisponiveisEditList.forEach(c => {
                lastSelect.append(`<option value="${c.id}">${c.nome}</option>`);
            });
            
            lastSelect.val(centro.id);
            const preco = centro.pivot && centro.pivot.preco ? centro.pivot.preco : '';
            $('#centrosContainerEdit').find('.preco-edit').last().val(preco);
            
            centrosEditCount++;
        } catch(e) {
            console.error('Erro ao carregar centro:', e, centro);
        }
    });
}

// Adicionar centro no modal de edição
function adicionarCentroEdit() {
    try {
        const template = document.getElementById('centroCursoEditTemplate');
        if (!template) return;
        
        const clone = template.content.cloneNode(true);
        const wrapper = document.createElement('div');
        wrapper.appendChild(clone);
        
        let html = wrapper.innerHTML
            .replace(/numero-centro-edit">Centro 1</g, `numero-centro-edit">Centro ${centrosEditCount + 1}<`);
        
        const colDiv = document.createElement('div');
        colDiv.innerHTML = html;
        $('#centrosContainerEdit').append(colDiv.firstElementChild);
        
        const selects = $('#centrosContainerEdit').find('.centro-id-edit');
        const lastSelect = selects.last();
        
        centrosDisponiveisEditList.forEach(centro => {
            lastSelect.append(`<option value="${centro.id}">${centro.nome}</option>`);
        });
        
        centrosEditCount++;
        atualizarNumeroCentrosEdit();
    } catch(e) {
        console.error('Erro ao adicionar centro:', e);
    }
}

// Atualizar numeração dos centros
function atualizarNumeroCentrosEdit() {
    const badges = $('#centrosContainerEdit').find('.numero-centro-edit');
    badges.each((index, badge) => {
        $(badge).text('Centro ' + (index + 1));
    });

    const btnsRemover = $('#centrosContainerEdit').find('.remover-centro-edit');
    btnsRemover.prop('disabled', btnsRemover.length <= 1);
}

// Eventos do modal de edição
$(document).on('click', '#adicionarCentroEditBtn', function(e) {
    e.preventDefault();
    adicionarCentroEdit();
});

$(document).on('click', '.remover-centro-edit', function(e) {
    e.preventDefault();
    $(this).closest('.col-12').remove();
    atualizarNumeroCentrosEdit();
});

// Handler do formulário de edição
$("#formEditarCursoAjax").on("submit", function(e) {
    e.preventDefault();
    
    const $form = $(this);
    const cursoId = $form.find("[name=\"curso_id\"]").val();
    
    const nome = $form.find("[name=\"nome\"]").val().trim();
    const area = $form.find("[name=\"area\"]").val().trim();
    const modalidade = $form.find("[name=\"modalidade\"]").val().trim();
    
    if (!nome || !area || !modalidade) {
        Swal.fire("Erro!", "Preencha os campos obrigatórios (Nome, Área, Modalidade)", "error");
        return;
    }
    
    const centrosCount = $('#centrosContainerEdit').find('.centro-id-edit').length;
    if (centrosCount === 0) {
        Swal.fire("Erro!", "Adicione pelo menos um centro", "error");
        return;
    }
    
    let centroValido = true;
    $('#centrosContainerEdit').find('.centro-card').each(function() {
        const centroId = $(this).find('.centro-id-edit').val();
        const preco = $(this).find('.preco-edit').val();
        
        if (!centroId || !preco) {
            centroValido = false;
            return false;
        }
    });
    
    if (!centroValido) {
        Swal.fire("Erro!", "Preencha todos os dados dos centros (Centro, Preço)", "error");
        return;
    }
    
    const imagemFile = $form.find("[name=\"imagem\"]")[0].files[0];
    
    if (imagemFile) {
        // Com arquivo de imagem
        const formData = new FormData();
        formData.append('nome', nome);
        formData.append('descricao', $form.find("[name=\"descricao\"]").val().trim());
        formData.append('programa', $form.find("[name=\"programa\"]").val().trim());
        formData.append('area', area);
        formData.append('modalidade', modalidade);
        formData.append('ativo', $form.find("[name=\"ativo\"]").is(":checked") ? 1 : 0);
        formData.append('imagem', imagemFile);
        
        let index = 0;
        $('#centrosContainerEdit').find('.centro-card').each(function() {
            const centroId = $(this).find('.centro-id-edit').val();
            const preco = $(this).find('.preco-edit').val();
            
            formData.append(`centros[${index}][centro_id]`, centroId);
            formData.append(`centros[${index}][preco]`, preco);
            index++;
        });
        
        $.ajax({
            url: `/api/cursos/${cursoId}`,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content"),
                "Accept": "application/json",
                "X-HTTP-Method-Override": "PUT"
            },
            success: function(response) {
                console.log("Sucesso:", response);
                $("#modalEditarCurso").modal("hide");
                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Curso atualizado com sucesso!",
                    timer: 2000
                }).then(() => location.reload());
            },
            error: function(xhr, status, error) {
                console.error("Status:", xhr.status);
                console.error("Response:", xhr.responseText);
                
                let message = "Erro desconhecido";
                
                if (xhr.responseJSON?.errors) {
                    message = Object.values(xhr.responseJSON.errors).flat().join("\n");
                } else if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: "error",
                    title: "Erro!",
                    text: message || "Erro ao atualizar curso."
                });
            }
        });
    } else {
        // Sem arquivo - usar JSON
        const formData = {
            nome: nome,
            descricao: $form.find("[name=\"descricao\"]").val().trim(),
            programa: $form.find("[name=\"programa\"]").val().trim(),
            area: area,
            modalidade: modalidade,
            ativo: $form.find("[name=\"ativo\"]").is(":checked") ? 1 : 0,
            centros: []
        };
        
        $('#centrosContainerEdit').find('.centro-card').each(function() {
            const centroId = $(this).find('.centro-id-edit').val();
            const preco = $(this).find('.preco-edit').val();
            
            formData.centros.push({
                centro_id: centroId,
                preco: preco
            });
        });
        
        $.ajax({
            url: `/api/cursos/${cursoId}`,
            type: "PUT",
            data: JSON.stringify(formData),
            contentType: "application/json",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content"),
                "Accept": "application/json"
            },
            success: function(response) {
                console.log("Sucesso:", response);
                $("#modalEditarCurso").modal("hide");
                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Curso atualizado com sucesso!",
                    timer: 2000
                }).then(() => location.reload());
            },
            error: function(xhr, status, error) {
                console.error("Status:", xhr.status);
                console.error("Response:", xhr.responseText);
                
                let message = "Erro desconhecido";
                
                if (xhr.responseJSON?.errors) {
                    message = Object.values(xhr.responseJSON.errors).flat().join("\n");
                } else if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: "error",
                    title: "Erro!",
                    text: message || "Erro ao atualizar curso."
                });
            }
        });
    }
});

// Inicializar
$(document).ready(function() {
    carregarCentrosEdit();
});

/**
 * Eliminar Curso
 */
$(document).on("click", ".btn-eliminar-curso", function() {
    const $btn = $(this);
    const id = $btn.data("curso-id");
    
    if (!id) {
        Swal.fire("Erro!", "ID do curso não encontrado", "error");
        return;
    }
    
    Swal.fire({
        title: "Tem certeza?",
        text: "Esta ação irá eliminar o curso permanentemente!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc2626",
        cancelButtonColor: "#64748b",
        confirmButtonText: "Sim, eliminar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/cursos/${id}`,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
                },
                success: function() {
                    Swal.fire("Eliminado!", "O curso foi eliminado com sucesso.", "success").then(() => {
                        window.location.href = "{{ route('cursos.index') }}";
                    });
                },
                error: function(xhr) {
                    console.error("Erro:", xhr);
                    const errors = xhr.responseJSON?.errors || { error: [xhr.responseJSON?.message || "Erro desconhecido"] };
                    const message = Object.values(errors).flat().join("\n");
                    Swal.fire("Erro!", message || "Ocorreu um erro ao eliminar o curso.", "error");
                }
            });
        }
    });
});
</script>
@endsection
