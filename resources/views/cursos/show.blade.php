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
                        <div class="col-6">
                            <div class="bg-success-subtle rounded p-2 text-center">
                                <div class="fw-bold text-success fs-5">{{ $curso->formadores->count() }}</div>
                                <small class="text-muted"><i class="fas fa-chalkboard-teacher me-1"></i>Formadores</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-warning-subtle rounded p-2 text-center">
                                <div class="fw-bold text-warning fs-5">{{ $curso->preInscricoes->count() }}</div>
                                <small class="text-muted"><i class="fas fa-user-plus me-1"></i>Pré-inscrições</small>
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
                <li class="nav-item">
                    <button class="nav-link fw-semibold" id="preinscricoes-tab" data-bs-toggle="tab" data-bs-target="#preinscricoes" type="button" role="tab">
                        <i class="fas fa-user-plus me-1"></i>Pré-inscrições
                        <span class="badge bg-warning text-dark ms-1">{{ $curso->preInscricoes->count() }}</span>
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
                                        <th><i class="fas fa-calendar-week me-1 text-muted"></i>Dias da Semana</th>
                                        <th><i class="fas fa-sun me-1 text-muted"></i>Período</th>
                                        <th><i class="fas fa-hourglass-start me-1 text-muted"></i>Hora Início</th>
                                        <th><i class="fas fa-hourglass-end me-1 text-muted"></i>Hora Fim</th>
                                        <th><i class="fas fa-flag me-1 text-muted"></i>Status</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($curso->turmas as $turma)
                                        <tr>
                                            <td><span class="text-muted">{{ $loop->iteration }}</span></td>
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

                {{-- ======================== --}}
                {{-- ABA: PRÉ-INSCRIÇÕES      --}}
                {{-- ======================== --}}
                <div class="tab-pane fade" id="preinscricoes" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="fw-bold mb-0"><i class="fas fa-user-plus me-2 text-warning"></i>Pré-inscrições</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <select class="form-select form-select-sm" id="filtroStatusInscricoes" style="max-width: 200px;">
                                <option value="">Todos os status</option>
                                <option value="pendente">Pendentes</option>
                                <option value="confirmado">Confirmados</option>
                                <option value="cancelado">Cancelados</option>
                            </select>
                        </div>
                    </div>

                    @if($curso->preInscricoes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-user me-1 text-muted"></i>Nome</th>
                                        <th><i class="fas fa-building me-1 text-muted"></i>Centro</th>
                                        <th><i class="fas fa-envelope me-1 text-muted"></i>Email</th>
                                        <th><i class="fas fa-phone me-1 text-muted"></i>Telefone</th>
                                        <th><i class="fas fa-calendar me-1 text-muted"></i>Data</th>
                                        <th><i class="fas fa-info-circle me-1 text-muted"></i>Status</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($curso->preInscricoes as $inscricao)
                                        <tr class="row-inscricao" data-status="{{ $inscricao->status }}">
                                            <td><strong>{{ $inscricao->nome_completo ?? $inscricao->nome }}</strong></td>
                                            <td><span class="badge bg-light text-dark">{{ $inscricao->centro->nome ?? '—' }}</span></td>
                                            <td><a href="mailto:{{ $inscricao->email }}" class="text-decoration-none">{{ $inscricao->email }}</a></td>
                                            <td>
                                                @if($inscricao->telefone ?? ($inscricao->contactos["telefone"] ?? null))
                                                    <a href="tel:{{ $inscricao->telefone ?? $inscricao->contactos["telefone"] }}" class="text-decoration-none">{{ $inscricao->telefone ?? $inscricao->contactos["telefone"] }}</a>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($inscricao->created_at)->format("d/m/Y H:i") }}</td>
                                            <td>
                                                @if($inscricao->status === "pendente")
                                                    <span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half me-1"></i>Pendente</span>
                                                @elseif($inscricao->status === "confirmado")
                                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Confirmado</span>
                                                @elseif($inscricao->status === "cancelado")
                                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Cancelado</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if($inscricao->status === "pendente")
                                                    <button class="btn btn-sm btn-outline-success me-1 btn-aceitar-inscricao"
                                                            data-inscricao-id="{{ $inscricao->id }}"
                                                            type="button"
                                                            title="Aceitar">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger btn-rejeitar-inscricao"
                                                            data-inscricao-id="{{ $inscricao->id }}"
                                                            type="button"
                                                            title="Rejeitar">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-user-plus fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">Nenhuma pré-inscrição registada.</p>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditarCursoLabel">
                    <i class="fas fa-edit me-2"></i>Editar Curso: {{ $curso->nome }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="formEditarCursoAjax">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Nome <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nome" value="{{ $curso->nome }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Descrição</label>
                            <textarea class="form-control" name="descricao" rows="2">{{ $curso->descricao }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Programa do Curso</label>
                            <textarea class="form-control" name="programa" rows="2">{{ $curso->programa }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Área <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="area" value="{{ $curso->area }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Modalidade <span class="text-danger">*</span></label>
                            <select class="form-select" name="modalidade" required>
                                <option value="presencial" {{ $curso->modalidade === "presencial" ? "selected" : "" }}>Presencial</option>
                                <option value="online" {{ $curso->modalidade === "online" ? "selected" : "" }}>Online</option>
                                <option value="hibrido" {{ $curso->modalidade === "hibrido" ? "selected" : "" }}>Híbrido</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Imagem do Curso</label>
                            <input type="file" class="form-control" name="imagem" accept="image/*">
                            <small class="text-muted">JPEG, PNG, JPG ou GIF (máx 2MB)</small>
                            @if($curso->imagem_url)
                                <div class="mt-2">
                                    <small class="d-block text-muted mb-1">Imagem atual:</small>
                                    <img src="{{ $curso->imagem_url }}" alt="{{ $curso->nome }}" style="max-width: 100px; border-radius: 4px;">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="form-check" style="margin-top: 32px;">
                                <input type="checkbox" class="form-check-input" name="ativo" value="1" id="editCursoAtivo" {{ $curso->ativo ? "checked" : "" }}>
                                <label class="form-check-label" for="editCursoAtivo">Curso Ativo</label>
                            </div>
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
        formador_id: $form.find("select[name=\"formador_id\"]").val() || null,
        periodo: $form.find("select[name=\"periodo\"]").val(),
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
 * Filtro de Status - Pré-inscrições
 */
$("#filtroStatusInscricoes").on("change", function() {
    const statusFiltro = $(this).val();
    
    if (statusFiltro === "") {
        $(".row-inscricao").show();
    } else {
        $(".row-inscricao").hide();
        $(".row-inscricao[data-status='" + statusFiltro + "']").show();
    }
});

/**
 * Aceitar Pré-inscrição - AJAX
 */
$(document).on("click", ".btn-aceitar-inscricao", function() {
    const $btn = $(this);
    const inscricaoId = $btn.data("inscricao-id");
    
    if (!inscricaoId) {
        Swal.fire("Erro!", "ID da inscrição não encontrado", "error");
        return;
    }
    
    Swal.fire({
        title: "Confirmar inscrição?",
        text: "Esta pré-inscrição será confirmada.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: "#64748b",
        confirmButtonText: "Sim, confirmar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/pre-inscricoes/${inscricaoId}`,
                type: "PUT",
                data: JSON.stringify({ status: "confirmado" }),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
                },
                success: function() {
                    Swal.fire("Confirmado!", "Inscrição confirmada com sucesso.", "success").then(() => location.reload());
                },
                error: function(xhr) {
                    console.error("Erro:", xhr);
                    const errors = xhr.responseJSON?.errors || { error: [xhr.responseJSON?.message || "Erro desconhecido"] };
                    const message = Object.values(errors).flat().join("\n");
                    Swal.fire("Erro!", message || "Ocorreu um erro ao confirmar a inscrição.", "error");
                }
            });
        }
    });
});

/**
 * Rejeitar Pré-inscrição - AJAX
 */
$(document).on("click", ".btn-rejeitar-inscricao", function() {
    const $btn = $(this);
    const inscricaoId = $btn.data("inscricao-id");
    
    if (!inscricaoId) {
        Swal.fire("Erro!", "ID da inscrição não encontrado", "error");
        return;
    }
    
    Swal.fire({
        title: "Rejeitar inscrição?",
        text: "Esta pré-inscrição será rejeitada.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc2626",
        cancelButtonColor: "#64748b",
        confirmButtonText: "Sim, rejeitar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/pre-inscricoes/${inscricaoId}`,
                type: "PUT",
                data: JSON.stringify({ status: "cancelado" }),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
                },
                success: function() {
                    Swal.fire("Rejeitado!", "Inscrição rejeitada com sucesso.", "success").then(() => location.reload());
                },
                error: function(xhr) {
                    console.error("Erro:", xhr);
                    const errors = xhr.responseJSON?.errors || { error: [xhr.responseJSON?.message || "Erro desconhecido"] };
                    const message = Object.values(errors).flat().join("\n");
                    Swal.fire("Erro!", message || "Ocorreu um erro ao rejeitar a inscrição.", "error");
                }
            });
        }
    });
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
