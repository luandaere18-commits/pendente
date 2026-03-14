@extends('layouts.app')

@section('title', 'Pré-Inscrições')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
<style>
    :root {
        --pi-primary: #1d4ed8;
        --pi-primary-dark: #1e40af;
        --pi-primary-light: rgba(29, 78, 216, 0.08);
        --pi-primary-gradient: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        --pi-success: #16a34a;
        --pi-success-light: rgba(22, 163, 74, 0.08);
        --pi-warning: #d97706;
        --pi-warning-light: rgba(217, 119, 6, 0.08);
        --pi-danger: #dc2626;
        --pi-danger-light: rgba(220, 38, 38, 0.08);
        --pi-info: #0284c7;
        --pi-info-light: rgba(2, 132, 199, 0.08);
        --pi-muted: #64748b;
        --pi-border: #dbeafe;
        --pi-bg: #eff6ff;
        --pi-card: #ffffff;
        --pi-text: #1e3a8a;
        --pi-text-muted: #64748b;
        --pi-radius: 0.5rem;
        --pi-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }

    body { background-color: var(--pi-bg); font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif; color: var(--pi-text); }

    .pi-page { width: 100%; padding: 0; }

    /* ── BLUE HEADER ── */
    .pi-page-header {
        background: var(--pi-primary-gradient);
        color: #fff; padding: 1rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 0.75rem;
    }
    .pi-page-header h1 { font-size: 1.25rem; font-weight: 700; margin: 0; letter-spacing: -0.02em; color: #fff; }
    .pi-page-header p { font-size: 0.75rem; color: rgba(255,255,255,0.75); margin: 0; }
    .pi-page-header .pi-btn-create {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.5rem 1rem; border-radius: var(--pi-radius);
        background: #fff; color: var(--pi-primary); font-weight: 600;
        font-size: 0.8125rem; border: none; cursor: pointer; transition: all 0.15s;
    }
    .pi-page-header .pi-btn-create:hover { background: #dbeafe; }

    /* ── STATS ── */
    .pi-stats-bar {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 0;
        background: #fff; border-bottom: 1px solid var(--pi-border);
    }
    .pi-stat {
        padding: 0.75rem 1.25rem; border-right: 1px solid var(--pi-border);
        display: flex; align-items: center; gap: 0.75rem;
    }
    .pi-stat:last-child { border-right: none; }
    .pi-stat-icon {
        width: 2.25rem; height: 2.25rem; border-radius: 0.5rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.875rem; flex-shrink: 0;
    }
    .pi-stat-icon.blue { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-stat-icon.yellow { background: var(--pi-warning-light); color: var(--pi-warning); }
    .pi-stat-icon.green { background: var(--pi-success-light); color: var(--pi-success); }
    .pi-stat-icon.red { background: var(--pi-danger-light); color: var(--pi-danger); }
    .pi-stat-label { font-size: 0.6875rem; font-weight: 500; color: var(--pi-text-muted); text-transform: uppercase; letter-spacing: 0.04em; }
    .pi-stat-value { font-size: 1.375rem; font-weight: 700; line-height: 1; }

    /* ── TOOLBAR ── */
    .pi-toolbar {
        background: #fff; border-bottom: 1px solid var(--pi-border);
        padding: 0.625rem 1.25rem;
        display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem;
    }
    .pi-toolbar .search-wrap { position: relative; flex: 1; min-width: 200px; }
    .pi-toolbar .search-wrap i {
        position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);
        color: var(--pi-primary); font-size: 0.8125rem; pointer-events: none;
    }
    .pi-toolbar .search-wrap input {
        width: 100%; padding: 0.375rem 0.75rem 0.375rem 2.25rem;
        border: 1px solid var(--pi-border); border-radius: var(--pi-radius);
        font-size: 0.8125rem; background: var(--pi-bg); height: 2.125rem; transition: all 0.15s;
    }
    .pi-toolbar .search-wrap input:focus { outline: none; border-color: var(--pi-primary); box-shadow: 0 0 0 2px var(--pi-primary-light); background: #fff; }
    .pi-toolbar select {
        height: 2.125rem; border: 1px solid var(--pi-border);
        border-radius: var(--pi-radius); font-size: 0.8125rem;
        padding: 0 2rem 0 0.625rem; background: var(--pi-bg);
        min-width: 140px; cursor: pointer;
    }
    .pi-toolbar select:focus { outline: none; border-color: var(--pi-primary); box-shadow: 0 0 0 2px var(--pi-primary-light); }
    .pi-btn-clear {
        border: none; background: transparent; color: var(--pi-text-muted);
        font-size: 0.8125rem; padding: 0.375rem 0.5rem; border-radius: var(--pi-radius);
        display: inline-flex; align-items: center; gap: 0.25rem; cursor: pointer; white-space: nowrap;
    }
    .pi-btn-clear:hover { background: var(--pi-danger-light); color: var(--pi-danger); }

    /* ── TABLE ── */
    .pi-table-wrap { background: #fff; overflow: auto; }
    .pi-table { width: 100%; margin: 0; border-collapse: collapse; font-size: 0.8125rem; }
    .pi-table thead th {
        background: var(--pi-primary); color: #fff;
        font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;
        padding: 0.625rem 1rem; white-space: nowrap;
        position: sticky; top: 0; z-index: 5; border-bottom: none;
        cursor: pointer; user-select: none;
    }
    .pi-table thead th .sort-icon { opacity: 0.4; margin-left: 0.25rem; font-size: 0.6rem; }
    .pi-table thead th.sorted .sort-icon { opacity: 1; }
    .pi-table tbody td { padding: 0.5rem 1rem; vertical-align: middle; border-bottom: 1px solid #f0f4ff; }
    .pi-table tbody tr { transition: background 0.1s; }
    .pi-table tbody tr:hover { background: var(--pi-primary-light); }
    .pi-table tbody tr:last-child td { border-bottom: none; }
    .pi-table .mono { font-family: 'SF Mono','Fira Code',monospace; font-size: 0.6875rem; color: var(--pi-muted); }

    /* ── PAGINATION ── */
    .pi-pagination-bar {
        background: var(--pi-primary); color: #fff;
        padding: 0.5rem 1.25rem;
        display: flex; align-items: center; justify-content: space-between; font-size: 0.75rem;
    }
    .pi-pagination-bar .info { opacity: 0.85; }
    .pi-pagination-bar .pages { display: flex; gap: 0.25rem; }
    .pi-pagination-bar .page-btn {
        padding: 0.25rem 0.625rem; border-radius: 0.25rem;
        border: 1px solid rgba(255,255,255,0.3);
        background: transparent; color: #fff; cursor: pointer;
        font-size: 0.75rem; font-weight: 500; transition: all 0.15s;
    }
    .pi-pagination-bar .page-btn:hover { background: rgba(255,255,255,0.15); }
    .pi-pagination-bar .page-btn.active { background: #fff; color: var(--pi-primary); font-weight: 700; border-color: #fff; }
    .pi-pagination-bar .page-btn:disabled { opacity: 0.4; cursor: not-allowed; }

    /* ── BADGES ── */
    .pi-badge {
        display: inline-flex; align-items: center; gap: 0.25rem;
        padding: 0.15rem 0.5rem; border-radius: 9999px;
        font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.01em;
    }
    .pi-badge-dia { background: var(--pi-info-light); color: #0369a1; margin-right: 0.125rem; }
    .pi-badge-pendente { background: var(--pi-warning-light); color: #92610a; }
    .pi-badge-confirmado { background: var(--pi-success-light); color: #1e6e49; }
    .pi-badge-cancelado { background: var(--pi-danger-light); color: #a71d2a; }

    /* ── ACTION BUTTONS ── */
    .pi-actions { display: flex; align-items: center; justify-content: flex-end; gap: 0.125rem; opacity: 0; transition: opacity 0.15s; }
    .pi-table tbody tr:hover .pi-actions { opacity: 1; }
    .pi-action-btn {
        width: 1.75rem; height: 1.75rem; border: none; border-radius: 0.25rem;
        display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.15s; font-size: 0.75rem;
    }
    .pi-action-btn.view { background: transparent; color: var(--pi-primary); }
    .pi-action-btn.view:hover { background: var(--pi-primary-light); }
    .pi-action-btn.confirm { background: transparent; color: var(--pi-success); border: 1px solid var(--pi-success); }
    .pi-action-btn.confirm:hover { background: var(--pi-success); color: #fff; }
    .pi-action-btn.cancel { background: transparent; color: var(--pi-danger); border: 1px solid var(--pi-danger); }
    .pi-action-btn.cancel:hover { background: var(--pi-danger); color: #fff; }

    /* ── TURMA CELL ── */
    .turma-info { display: flex; align-items: center; gap: 0.5rem; }
    .turma-info .periodo-icon { width: 1.25rem; text-align: center; color: var(--pi-text-muted); }
    .turma-info .turma-name { font-size: 0.8125rem; font-weight: 500; line-height: 1.2; }
    .turma-info .turma-periodo { font-size: 0.6875rem; color: var(--pi-text-muted); }

    /* ── EMPTY STATE ── */
    .pi-empty { text-align: center; padding: 3rem 1rem; color: var(--pi-text-muted); }
    .pi-empty-icon { width: 3.5rem; height: 3.5rem; border-radius: 0.75rem; background: var(--pi-primary-light); display: inline-flex; align-items: center; justify-content: center; font-size: 1.25rem; margin-bottom: 0.75rem; color: var(--pi-primary); }
    .pi-empty h3 { font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem; color: var(--pi-text); }
    .pi-empty p { font-size: 0.8125rem; }

    /* ── MOBILE CARDS ── */
    .pi-mobile-cards { display: none; padding: 0.75rem; }
    .pi-mobile-card {
        background: #fff; border: 1px solid var(--pi-border); border-radius: var(--pi-radius);
        padding: 0.75rem; box-shadow: var(--pi-shadow); margin-bottom: 0.5rem;
    }
    .pi-mobile-card .card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.375rem; }
    .pi-mobile-card .card-name { font-weight: 600; font-size: 0.875rem; color: var(--pi-text); }
    .pi-mobile-card .card-email { font-size: 0.6875rem; color: var(--pi-text-muted); }
    .pi-mobile-card .card-turma { display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; color: var(--pi-text-muted); margin-bottom: 0.5rem; }
    .pi-mobile-card .card-actions { display: flex; gap: 0.375rem; }
    .pi-mobile-card .card-actions .btn { font-size: 0.6875rem; padding: 0.2rem 0.5rem; }

    /* ── MODAL ── */
    .pi-modal .modal-content { border-radius: var(--pi-radius); border: 1px solid var(--pi-border); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); }
    .pi-modal .modal-header { border-bottom: 1px solid var(--pi-border); padding: 1rem 1.25rem; background: var(--pi-primary-light); }
    .pi-modal .modal-header .header-flex { display: flex; align-items: center; gap: 0.625rem; }
    .pi-modal .modal-header .header-icon { width: 2.25rem; height: 2.25rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; }
    .pi-modal .modal-header .header-icon.blue { background: var(--pi-primary); color: #fff; }
    .pi-modal .modal-header .header-icon.green { background: var(--pi-success); color: #fff; }
    .pi-modal .modal-title { font-size: 0.9375rem; font-weight: 600; margin: 0; color: var(--pi-text); }
    .pi-modal .modal-subtitle { font-size: 0.75rem; color: var(--pi-text-muted); margin: 0; }
    .pi-modal .modal-body { padding: 1rem 1.25rem; }
    .pi-modal .modal-footer { border-top: 1px solid var(--pi-border); padding: 0.75rem 1.25rem; background: var(--pi-bg); }
    .pi-modal .modal-footer .btn { border-radius: var(--pi-radius); font-size: 0.8125rem; font-weight: 500; padding: 0.4375rem 0.875rem; }

    .pi-detail-row { display: flex; align-items: flex-start; gap: 0.625rem; padding: 0.5rem 0; border-bottom: 1px solid #f0f4ff; }
    .pi-detail-row:last-child { border-bottom: none; }
    .pi-detail-icon { width: 1.75rem; height: 1.75rem; border-radius: 0.375rem; background: var(--pi-primary-light); display: flex; align-items: center; justify-content: center; color: var(--pi-primary); font-size: 0.75rem; flex-shrink: 0; }
    .pi-detail-label { font-size: 0.6875rem; font-weight: 500; color: var(--pi-text-muted); text-transform: uppercase; letter-spacing: 0.03em; }
    .pi-detail-value { font-size: 0.8125rem; font-weight: 500; margin-top: 0.0625rem; }

    .pi-form .form-label { font-size: 0.75rem; font-weight: 500; margin-bottom: 0.25rem; color: var(--pi-text); }
    .pi-form .form-label .required { color: var(--pi-danger); }
    .pi-form .form-control, .pi-form .form-select { border-radius: var(--pi-radius); border-color: var(--pi-border); font-size: 0.8125rem; height: 2.25rem; }
    .pi-form textarea.form-control { height: auto; }
    .pi-form .form-control:focus, .pi-form .form-select:focus { border-color: var(--pi-primary); box-shadow: 0 0 0 2px var(--pi-primary-light); }
    .pi-form .form-control.is-invalid { border-color: var(--pi-danger); }
    .pi-form .form-control.is-invalid:focus { box-shadow: 0 0 0 2px var(--pi-danger-light); }
    .pi-form .invalid-feedback { font-size: 0.6875rem; }
    .pi-form .form-text { font-size: 0.6875rem; color: var(--pi-text-muted); }

    .pi-btn-primary { background: var(--pi-primary); border: none; color: #fff; border-radius: var(--pi-radius); padding: 0.4375rem 0.875rem; font-size: 0.8125rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.375rem; transition: all 0.15s; cursor: pointer; }
    .pi-btn-primary:hover { background: var(--pi-primary-dark); color: #fff; }

    .pi-spinner { display: inline-block; width: 0.875rem; height: 0.875rem; border: 2px solid #fff; border-right-color: transparent; border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 0.25rem; }
    @keyframes spin { to { transform: rotate(360deg); } }

    .select2-container--bootstrap-5 .select2-selection { border-radius: var(--pi-radius) !important; border-color: var(--pi-border) !important; height: 2.25rem !important; font-size: 0.8125rem !important; }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered { line-height: 2.25rem !important; }

    @media (max-width: 991.98px) {
        .pi-desktop-table { display: none !important; }
        .pi-mobile-cards { display: block !important; }
    }
    @media (max-width: 767.98px) {
        .pi-stats-bar { grid-template-columns: repeat(2, 1fr); }
        .pi-stat { border-bottom: 1px solid var(--pi-border); }
        .pi-toolbar { flex-direction: column; }
        .pi-page-header { flex-direction: column; align-items: stretch; }
        .pi-page-header .pi-btn-create { justify-content: center; }
        .pi-pagination-bar { flex-direction: column; gap: 0.5rem; text-align: center; }
    }
    @media (max-width: 575.98px) {
        .pi-page-header { padding: 0.75rem; }
        .pi-toolbar { padding: 0.5rem 0.75rem; }
        .pi-stat { padding: 0.5rem 0.75rem; }
    }
</style>
@endsection

@section('content')
<div class="pi-page">

    {{-- BLUE HEADER --}}
    <div class="pi-page-header">
        <div>
            <div style="display:flex;align-items:center;gap:0.625rem">
                <i class="fas fa-clipboard-list fa-lg" style="opacity:0.9"></i>
                <div>
                    <h1>Pré-Inscrições</h1>
                    <p>Gerir todas as pré-inscrições dos candidatos</p>
                </div>
            </div>
        </div>
        <button class="pi-btn-create" data-bs-toggle="modal" data-bs-target="#modalNovaPreInscricao">
            <i class="fas fa-plus"></i> Nova Pré-Inscrição
        </button>
    </div>

    {{-- STATS BAR --}}
    <div class="pi-stats-bar">
        <div class="pi-stat">
            <div class="pi-stat-icon blue"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <div class="pi-stat-label">Total</div>
                <div class="pi-stat-value" style="color:var(--pi-primary)" id="statTotal">0</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon yellow"><i class="fas fa-clock"></i></div>
            <div>
                <div class="pi-stat-label">Pendentes</div>
                <div class="pi-stat-value" style="color:var(--pi-warning)" id="statPendente">0</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="pi-stat-label">Confirmados</div>
                <div class="pi-stat-value" style="color:var(--pi-success)" id="statConfirmado">0</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon red"><i class="fas fa-times-circle"></i></div>
            <div>
                <div class="pi-stat-label">Cancelados</div>
                <div class="pi-stat-value" style="color:var(--pi-danger)" id="statCancelado">0</div>
            </div>
        </div>
    </div>

    {{-- TOOLBAR --}}
    <div class="pi-toolbar">
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="filtroSearch" placeholder="Pesquisar por nome ou email...">
        </div>
        <select id="filtroStatus" style="border-color:var(--pi-border)">
            <option value="">Todos os status</option>
            <option value="pendente">Pendente</option>
            <option value="confirmado">Confirmado</option>
            <option value="cancelado">Cancelado</option>
        </select>
        <select id="filtroCurso" style="border-color:var(--pi-border)">
            <option value="">Todos os cursos</option>
        </select>
        <select id="filtroCentro" style="border-color:var(--pi-border)">
            <option value="">Todos os centros</option>
        </select>
        <button class="pi-btn-clear" id="btnLimparFiltros" onclick="limparFiltros()">
            <i class="fas fa-times-circle"></i> Limpar
        </button>
    </div>

    {{-- TABLE --}}
    <div class="pi-table-wrap">
        {{-- Desktop Table --}}
        <div class="pi-desktop-table">
            <table class="pi-table" id="tabelaPreInscricoes">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="id" style="width:50px">ID <i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-sort="nome_completo">Nome <i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-sort="email">Email <i class="fas fa-sort sort-icon"></i></th>
                        <th>Turma</th>
                        <th>Centro</th>
                        <th>Dias</th>
                        <th>Arranque</th>
                        <th class="sortable" data-sort="status">Status <i class="fas fa-sort sort-icon"></i></th>
                        <th style="text-align:right;width:100px">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaBody"></tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="pi-mobile-cards" id="mobileCards"></div>

        {{-- Empty State --}}
        <div class="pi-empty d-none" id="emptyState">
            <div class="pi-empty-icon"><i class="fas fa-inbox"></i></div>
            <h3>Nenhuma pré-inscrição encontrada</h3>
            <p>Tente ajustar os filtros ou criar uma nova pré-inscrição</p>
        </div>
    </div>

    {{-- PAGINATION BAR --}}
    <div class="pi-pagination-bar d-none" id="paginationContainer">
        <span class="info" id="paginationInfo"></span>
        <div class="pages" id="paginationPages"></div>
    </div>
</div>

{{-- VIEW MODAL --}}
<div class="modal fade pi-modal" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon green"><i class="fas fa-eye"></i></div>
                    <div>
                        <h5 class="modal-title">Detalhes da Pré-Inscrição</h5>
                        <p class="modal-subtitle" id="viewModalId"></p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewModalContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2" style="font-size:0.8125rem">Carregando...</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CREATE MODAL --}}
<div class="modal fade pi-modal" id="modalNovaPreInscricao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue"><i class="fas fa-user-plus"></i></div>
                    <div>
                        <h5 class="modal-title">Nova Pré-Inscrição</h5>
                        <p class="modal-subtitle">Preencha os dados do candidato</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCriarPreInscricao" class="pi-form">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Turma <span class="required">*</span></label>
                        <select class="form-select" name="turma_id" id="criarTurmaId" required>
                            <option value="">Selecione uma turma...</option>
                        </select>
                        <div class="invalid-feedback">Selecione uma turma</div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Nome Completo <span class="required">*</span></label>
                        <input type="text" class="form-control" name="nome_completo" id="criarNome" placeholder="Nome do candidato" required>
                        <div class="invalid-feedback">Nome é obrigatório</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 mb-2 mb-sm-0">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="criarEmail" placeholder="email@exemplo.com">
                            <div class="invalid-feedback">Email inválido</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Contactos</label>
                            <input type="text" class="form-control" name="contactos[]" id="criarContactos" placeholder="912 345 678">
                            <div class="form-text">Pode adicionar vários contactos</div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Status <span class="required">*</span></label>
                        <select class="form-select" name="status" id="criarStatus">
                            <option value="pendente">Pendente</option>
                            <option value="confirmado">Confirmado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Observações</label>
                        <textarea class="form-control" name="observacoes" id="criarObservacoes" rows="3" placeholder="Notas adicionais..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn pi-btn-primary" id="btnSalvar" onclick="salvarPreInscricao()"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
(function() {
    'use strict';

    let allData = [];
    let filteredData = [];
    let sortField = 'id';
    let sortDir = 'asc';
    let currentPage = 1;
    const ITEMS_PER_PAGE = 8;

    $(document).ready(function() {
        carregarDados();
        carregarFiltros();
        carregarTurmas();
        bindEvents();
    });

    function bindEvents() {
        let searchTimer;
        $('#filtroSearch').on('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(aplicarFiltrosLocais, 250);
        });
        $('#filtroStatus, #filtroCurso, #filtroCentro').on('change', aplicarFiltrosLocais);

        $(document).on('click', '.sortable', function() {
            const field = $(this).data('sort');
            if (sortField === field) { sortDir = sortDir === 'asc' ? 'desc' : 'asc'; }
            else { sortField = field; sortDir = 'asc'; }
            renderTable();
        });
    }

    function carregarDados() {
        $.ajax({
            url: '/pre-inscricoes?per_page=1000',
            method: 'GET',
            success: function(response) {
                allData = response.data || response;
                aplicarFiltrosLocais();
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Erro!', text: 'Não foi possível carregar as pré-inscrições.', confirmButtonColor: '#1d4ed8' });
            }
        });
    }

    function carregarFiltros() {
        $.get('/cursos', function(data) {
            let opts = '<option value="">Todos os cursos</option>';
            (data || []).forEach(function(c) { if (c.ativo) opts += '<option value="' + c.id + '">' + c.nome + '</option>'; });
            $('#filtroCurso').html(opts);
        });
        $.get('/centros', function(data) {
            let opts = '<option value="">Todos os centros</option>';
            (data || []).forEach(function(c) { if (c.ativo) opts += '<option value="' + c.id + '">' + c.nome + '</option>'; });
            $('#filtroCentro').html(opts);
        });
    }

    function carregarTurmas() {
        $('#criarTurmaId').html('<option value="">Carregando turmas...</option>');
        $.ajax({
            url: '/turmas',
            method: 'GET',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            success: function(data) {
                let opts = '<option value="">Selecione uma turma...</option>';
                let items = [];
                if (Array.isArray(data)) items = data;
                else if (data.data && Array.isArray(data.data)) items = data.data;
                else if (data.dados && Array.isArray(data.dados)) items = data.dados;
                else { for (let key in data) { if (Array.isArray(data[key])) { items = data[key]; break; } } }
                if (items && items.length > 0) {
                    items.forEach(function(t) {
                        const cursoNome = t.curso ? t.curso.nome : (t.curso_nome || 'Curso');
                        const centroNome = t.centro ? t.centro.nome : (t.centro_nome || '');
                        let periodo = t.periodo || '';
                        if (periodo === 'manha') periodo = 'Manhã';
                        else if (periodo === 'tarde') periodo = 'Tarde';
                        else if (periodo === 'noite') periodo = 'Noite';
                        let nome = cursoNome;
                        if (periodo) nome += ' — ' + periodo;
                        if (centroNome) nome += ' (' + centroNome + ')';
                        opts += `<option value="${t.id}">${nome}</option>`;
                    });
                } else { opts = '<option value="">Nenhuma turma disponível</option>'; }
                $('#criarTurmaId').html(opts);
            },
            error: function(xhr) {
                $('#criarTurmaId').html('<option value="">Erro ao carregar turmas</option>');
                let mensagem = 'Não foi possível carregar a lista de turmas';
                if (xhr.status === 404) mensagem = 'Rota de turmas não encontrada';
                else if (xhr.status === 500) mensagem = 'Erro interno no servidor';
                Swal.fire({ icon: 'error', title: 'Erro!', text: mensagem, confirmButtonColor: '#1d4ed8' });
            }
        });
    }

    function aplicarFiltrosLocais() {
        const search = ($('#filtroSearch').val() || '').toLowerCase();
        const status = $('#filtroStatus').val();
        const curso = $('#filtroCurso').val();
        const centro = $('#filtroCentro').val();
        filteredData = allData.filter(function(item) {
            if (search) {
                const nome = (item.nome_completo || '').toLowerCase();
                const email = (item.email || '').toLowerCase();
                if (!nome.includes(search) && !email.includes(search)) return false;
            }
            if (status && item.status !== status) return false;
            if (curso && (!item.turma || !item.turma.curso || item.turma.curso.id != curso)) return false;
            if (centro && (!item.turma || !item.turma.centro || item.turma.centro.id != centro)) return false;
            return true;
        });
        let count = 0;
        if (search) count++;
        if (status) count++;
        if (curso) count++;
        if (centro) count++;
        $('#btnLimparFiltros').prop('disabled', count === 0);
        currentPage = 1;
        updateStats();
        renderTable();
    }

    window.limparFiltros = function() {
        $('#filtroSearch').val('');
        $('#filtroStatus').val('');
        $('#filtroCurso').val('');
        $('#filtroCentro').val('');
        aplicarFiltrosLocais();
    };

    function updateStats() {
        $('#statTotal').text(allData.length);
        $('#statPendente').text(allData.filter(function(d) { return d.status === 'pendente'; }).length);
        $('#statConfirmado').text(allData.filter(function(d) { return d.status === 'confirmado'; }).length);
        $('#statCancelado').text(allData.filter(function(d) { return d.status === 'cancelado'; }).length);
    }

    function renderTable() {
        var sorted = filteredData.slice().sort(function(a, b) {
            var cmp = 0;
            switch (sortField) {
                case 'id': cmp = (a.id || 0) - (b.id || 0); break;
                case 'nome_completo': cmp = (a.nome_completo || '').localeCompare(b.nome_completo || ''); break;
                case 'email': cmp = (a.email || '').localeCompare(b.email || ''); break;
                case 'status': cmp = (a.status || '').localeCompare(b.status || ''); break;
            }
            return sortDir === 'asc' ? cmp : -cmp;
        });

        $('.sortable').removeClass('sorted').find('.sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
        $('.sortable[data-sort="' + sortField + '"]').addClass('sorted')
            .find('.sort-icon').removeClass('fa-sort').addClass(sortDir === 'asc' ? 'fa-sort-up' : 'fa-sort-down');

        var totalPages = Math.max(1, Math.ceil(sorted.length / ITEMS_PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;
        var start = (currentPage - 1) * ITEMS_PER_PAGE;
        var paged = sorted.slice(start, start + ITEMS_PER_PAGE);

        if (sorted.length === 0) {
            $('#tabelaBody').empty();
            $('#mobileCards').empty();
            $('#emptyState').removeClass('d-none');
            $('#paginationContainer').addClass('d-none');
            return;
        }
        $('#emptyState').addClass('d-none');

        var html = '';
        paged.forEach(function(item) {
            html += '<tr>';
            html += '<td class="mono">#' + item.id + '</td>';
            html += '<td style="font-weight:600">' + esc(item.nome_completo) + '</td>';
            html += '<td style="font-size:0.75rem;color:var(--pi-text-muted)">' + esc(item.email || '—') + '</td>';
            html += '<td>' + renderTurmaCell(item) + '</td>';
            html += '<td style="font-size:0.75rem">' + esc(item.turma && item.turma.centro ? item.turma.centro.nome : '—') + '</td>';
            html += '<td>' + renderDiaBadges(item.turma ? item.turma.dia_semana : null) + '</td>';
            html += '<td style="font-size:0.75rem">' + formatDate(item.turma ? item.turma.data_arranque : null) + '</td>';
            html += '<td>' + statusBadge(item.status) + '</td>';
            html += '<td>' + renderActions(item) + '</td>';
            html += '</tr>';
        });
        $('#tabelaBody').html(html);

        var mobileHtml = '';
        paged.forEach(function(item) {
            mobileHtml += '<div class="pi-mobile-card">';
            mobileHtml += '<div class="card-top"><div><div class="card-name">' + esc(item.nome_completo) + '</div>';
            mobileHtml += '<div class="card-email">' + esc(item.email || 'Sem email') + '</div></div>';
            mobileHtml += statusBadge(item.status) + '</div>';
            if (item.turma) {
                mobileHtml += '<div class="card-turma">' + periodoIcon(item.turma.periodo) + ' ';
                mobileHtml += esc(item.turma.curso ? item.turma.curso.nome : '') + ' &bull; ';
                mobileHtml += esc(item.turma.centro ? item.turma.centro.nome : '') + '</div>';
                mobileHtml += '<div class="card-turma">' + renderDiaBadges(item.turma.dia_semana) + '</div>';
            }
            mobileHtml += '<div class="card-actions">';
            mobileHtml += '<button class="btn btn-sm btn-outline-primary" onclick="visualizarPreInscricao(' + item.id + ')"><i class="fas fa-eye me-1"></i>Ver</button>';
            if (item.status !== 'confirmado') mobileHtml += ' <button class="btn btn-sm btn-outline-success" onclick="confirmarPreInscricao(' + item.id + ')"><i class="fas fa-check me-1"></i>Confirmar</button>';
            if (item.status !== 'cancelado') mobileHtml += ' <button class="btn btn-sm btn-outline-danger" onclick="cancelarPreInscricao(' + item.id + ')"><i class="fas fa-times me-1"></i>Cancelar</button>';
            mobileHtml += '</div></div>';
        });
        $('#mobileCards').html(mobileHtml);

        if (totalPages > 1) {
            $('#paginationContainer').removeClass('d-none');
            $('#paginationInfo').text(sorted.length + ' resultado' + (sorted.length !== 1 ? 's' : '') + ' — Página ' + currentPage + ' de ' + totalPages);
            var pagesHtml = '<button class="page-btn" onclick="goToPage(' + (currentPage - 1) + ')"' + (currentPage <= 1 ? ' disabled' : '') + '><i class="fas fa-chevron-left" style="font-size:0.6rem"></i></button>';
            for (var p = 1; p <= totalPages; p++) {
                pagesHtml += '<button class="page-btn' + (p === currentPage ? ' active' : '') + '" onclick="goToPage(' + p + ')">' + p + '</button>';
            }
            pagesHtml += '<button class="page-btn" onclick="goToPage(' + (currentPage + 1) + ')"' + (currentPage >= totalPages ? ' disabled' : '') + '><i class="fas fa-chevron-right" style="font-size:0.6rem"></i></button>';
            $('#paginationPages').html(pagesHtml);
        } else {
            $('#paginationContainer').addClass('d-none');
        }
    }

    window.goToPage = function(page) {
        var totalPages = Math.max(1, Math.ceil(filteredData.length / ITEMS_PER_PAGE));
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderTable();
        $('.pi-table-wrap')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    function esc(str) { if (!str) return ''; var div = document.createElement('div'); div.textContent = str; return div.innerHTML; }
    function periodoIcon(periodo) {
        switch (periodo) { case 'manha': return '<i class="fas fa-sun"></i>'; case 'tarde': return '<i class="fas fa-cloud-sun"></i>'; case 'noite': return '<i class="fas fa-moon"></i>'; default: return '<i class="fas fa-clock"></i>'; }
    }
    function periodoLabel(periodo) {
        switch (periodo) { case 'manha': return 'Manhã'; case 'tarde': return 'Tarde'; case 'noite': return 'Noite'; default: return periodo || '—'; }
    }
    function renderDiaBadges(dias) {
        if (!dias || !Array.isArray(dias) || dias.length === 0) return '—';
        return dias.map(function(d) { return '<span class="pi-badge pi-badge-dia">' + esc(d.substring(0, 3)) + '</span>'; }).join('');
    }
    function renderTurmaCell(item) {
        if (!item.turma) return '<span style="color:var(--pi-text-muted);font-size:0.75rem">Sem turma</span>';
        return '<div class="turma-info"><span class="periodo-icon">' + periodoIcon(item.turma.periodo) + '</span><div><div class="turma-name">' + esc(item.turma.curso ? item.turma.curso.nome : '') + '</div><div class="turma-periodo">' + periodoLabel(item.turma.periodo) + '</div></div></div>';
    }
    function statusBadge(status) {
        switch (status) { case 'pendente': return '<span class="pi-badge pi-badge-pendente">Pendente</span>'; case 'confirmado': return '<span class="pi-badge pi-badge-confirmado">Confirmado</span>'; case 'cancelado': return '<span class="pi-badge pi-badge-cancelado">Cancelado</span>'; default: return '<span class="pi-badge" style="background:#eee;color:#666">' + esc(status) + '</span>'; }
    }
    function renderActions(item) {
        var html = '<div class="pi-actions">';
        html += '<button class="pi-action-btn view" onclick="visualizarPreInscricao(' + item.id + ')" title="Ver detalhes"><i class="fas fa-eye"></i></button>';
        if (item.status !== 'confirmado') html += '<button class="pi-action-btn confirm" onclick="confirmarPreInscricao(' + item.id + ')" title="Confirmar"><i class="fas fa-check"></i></button>';
        if (item.status !== 'cancelado') html += '<button class="pi-action-btn cancel" onclick="cancelarPreInscricao(' + item.id + ')" title="Cancelar"><i class="fas fa-times"></i></button>';
        html += '</div>';
        return html;
    }
    function formatDate(dateStr) { if (!dateStr) return '—'; try { var d = new Date(dateStr); return d.toLocaleDateString('pt-PT'); } catch(e) { return '—'; } }

    window.visualizarPreInscricao = function(id) {
        var modal = new bootstrap.Modal(document.getElementById('viewModal'));
        $('#viewModalId').text('#' + id);
        $('#viewModalContent').html('<div class="text-center py-4"><div class="spinner-border text-primary"></div><p class="text-muted mt-2" style="font-size:0.8125rem">Carregando...</p></div>');
        modal.show();
        $.ajax({
            url: '/pre-inscricoes/' + id,
            method: 'GET',
            success: function(r) {
                const dados = r.dados || r;
                var html = '';
                html += detailRow('fa-user', 'Nome Completo', esc(dados.nome_completo));
                html += detailRow('fa-envelope', 'Email', esc(dados.email || '—'));
                html += detailRow('fa-phone', 'Contactos', dados.contactos && dados.contactos.length ? esc(dados.contactos.join(', ')) : '—');
                html += detailRow('fa-book', 'Curso', esc(dados.turma && dados.turma.curso ? dados.turma.curso.nome : 'Sem turma'));
                html += detailRow('fa-map-marker-alt', 'Centro', esc(dados.turma && dados.turma.centro ? dados.turma.centro.nome : '—'));
                html += detailRow('fa-clock', 'Período', dados.turma ? periodoIcon(dados.turma.periodo) + ' ' + periodoLabel(dados.turma.periodo) : '—');
                html += detailRow('fa-calendar', 'Data de Arranque', formatDate(dados.turma ? dados.turma.data_arranque : null));
                html += detailRow('fa-comment', 'Observações', esc(dados.observacoes || 'Sem observações'));
                html += '<div class="pi-detail-row"><div class="pi-detail-icon"><i class="fas fa-info-circle"></i></div><div><div class="pi-detail-label">Status</div><div class="mt-1">' + statusBadge(dados.status) + '</div></div></div>';
                $('#viewModalContent').html(html);
            },
            error: function() {
                $('#viewModalContent').html('<div class="text-center py-4" style="color:var(--pi-danger)"><i class="fas fa-exclamation-circle fa-2x mb-2"></i><p>Erro ao carregar os detalhes.</p></div>');
            }
        });
    };

    function detailRow(icon, label, value) {
        return '<div class="pi-detail-row"><div class="pi-detail-icon"><i class="fas ' + icon + '"></i></div><div style="min-width:0;flex:1"><div class="pi-detail-label">' + label + '</div><div class="pi-detail-value">' + value + '</div></div></div>';
    }

    window.confirmarPreInscricao = function(id) {
        Swal.fire({
            title: 'Confirmar Pré-Inscrição',
            text: 'Tem certeza que deseja confirmar esta pré-inscrição?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sim, confirmar',
            cancelButtonText: 'Cancelar'
        }).then(function(result) { if (result.isConfirmed) atualizarStatus(id, 'confirmado'); });
    };

    window.cancelarPreInscricao = function(id) {
        Swal.fire({
            title: 'Cancelar Pré-Inscrição',
            text: 'Tem certeza que deseja cancelar esta pré-inscrição?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sim, cancelar',
            cancelButtonText: 'Não, voltar'
        }).then(function(result) { if (result.isConfirmed) atualizarStatus(id, 'cancelado'); });
    };

    function atualizarStatus(id, status) {
        $.ajax({
            url: '/pre-inscricoes/' + id,
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({ status: status }),
            success: function() {
                allData = allData.map(function(item) { if (item.id === id) item.status = status; return item; });
                var txt = status === 'confirmado' ? 'confirmada' : 'cancelada';
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Pré-inscrição ' + txt + ' com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
                aplicarFiltrosLocais();
            },
            error: function(xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Erro ao atualizar o status.';
                Swal.fire({ icon: 'error', title: 'Erro!', text: msg, confirmButtonColor: '#1d4ed8' });
            }
        });
    }

    window.salvarPreInscricao = function() {
        var form = $('#formCriarPreInscricao');
        var turmaId = $('#criarTurmaId').val();
        var nome = $('#criarNome').val().trim();
        var email = $('#criarEmail').val().trim();
        var contactos = $('#criarContactos').val().trim();
        var status = $('#criarStatus').val();
        var observacoes = $('#criarObservacoes').val().trim();
        form.find('.form-control, .form-select').removeClass('is-invalid');
        var valid = true;
        if (!turmaId) { $('#criarTurmaId').addClass('is-invalid'); valid = false; }
        if (!nome) { $('#criarNome').addClass('is-invalid'); valid = false; }
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { $('#criarEmail').addClass('is-invalid'); valid = false; }
        if (!valid) return;
        var data = { turma_id: turmaId, nome_completo: nome, email: email || null, status: status, observacoes: observacoes || null, contactos: contactos ? [contactos] : [] };
        var btn = $('#btnSalvar');
        btn.prop('disabled', true).html('<span class="pi-spinner"></span> Guardando...');
        $.ajax({
            url: '/pre-inscricoes',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                const dados = response.dados || response;
                if (dados.turma && !dados.turma.curso) dados.turma.curso = dados.turma.curso || null;
                allData.unshift(dados);
                aplicarFiltrosLocais();
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Pré-inscrição criada com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
                form[0].reset();
                bootstrap.Modal.getInstance(document.getElementById('modalNovaPreInscricao')).hide();
            },
            error: function(xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Erro ao criar a pré-inscrição.';
                Swal.fire({ icon: 'error', title: 'Erro!', text: msg, confirmButtonColor: '#1d4ed8' });
            },
            complete: function() { btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar'); }
        });
    };
})();
</script>
@endsection
