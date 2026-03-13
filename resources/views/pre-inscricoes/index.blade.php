@extends('layouts.app')

@section('title', 'Pré-Inscrições')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
<style>
    :root {
        --pi-primary: #3366cc;
        --pi-primary-light: rgba(51, 102, 204, 0.1);
        --pi-success: #2e9e6b;
        --pi-success-light: rgba(46, 158, 107, 0.1);
        --pi-warning: #e89a0c;
        --pi-warning-light: rgba(232, 154, 12, 0.1);
        --pi-danger: #dc3545;
        --pi-danger-light: rgba(220, 53, 69, 0.1);
        --pi-muted: #6b7a8d;
        --pi-border: #e2e6ec;
        --pi-bg: #f4f6f9;
        --pi-card: #ffffff;
        --pi-text: #1a2332;
        --pi-text-muted: #6b7a8d;
        --pi-radius: 0.75rem;
        --pi-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    }

    body { background-color: var(--pi-bg); font-family: 'Inter', system-ui, -apple-system, sans-serif; color: var(--pi-text); }

    .pi-page { max-width: 100%; width: 100%; margin: 0 auto; padding: 1.5rem 2rem; }

    /* Header */
    .pi-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
    .pi-header-left { display: flex; align-items: center; gap: 0.75rem; }
    .pi-header-icon { width: 3rem; height: 3rem; border-radius: var(--pi-radius); background: var(--pi-primary-light); display: flex; align-items: center; justify-content: center; color: var(--pi-primary); }
    .pi-header h1 { font-size: 1.5rem; font-weight: 700; margin: 0; letter-spacing: -0.01em; }
    .pi-header p { font-size: 0.875rem; color: var(--pi-text-muted); margin: 0; }
    .pi-btn-primary { background: var(--pi-primary); border: none; color: #fff; border-radius: 0.5rem; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.15s; }
    .pi-btn-primary:hover { background: #2a57b3; color: #fff; }

    /* Stats */
    .pi-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem; margin-bottom: 1.5rem; }
    .pi-stat-card { background: var(--pi-card); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); padding: 1rem; box-shadow: var(--pi-shadow); }
    .pi-stat-card .stat-label { font-size: 0.75rem; font-weight: 500; color: var(--pi-text-muted); margin-bottom: 0.25rem; }
    .pi-stat-card .stat-value { font-size: 1.5rem; font-weight: 700; }
    .pi-stat-card .stat-value.text-primary { color: var(--pi-primary) !important; }
    .pi-stat-card .stat-value.text-warning { color: var(--pi-warning) !important; }
    .pi-stat-card .stat-value.text-success { color: var(--pi-success) !important; }
    .pi-stat-card .stat-value.text-danger { color: var(--pi-danger) !important; }

    /* Filters */
    .pi-filters { background: var(--pi-card); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); padding: 1.25rem; box-shadow: var(--pi-shadow); margin-bottom: 1.25rem; width: 100%; }
    .pi-filters-header { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem; font-size: 0.875rem; font-weight: 500; color: var(--pi-text-muted); }
    .pi-filters-header .badge { font-size: 0.7rem; }
    .pi-filters-grid { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 0.75rem; align-items: end; }
    .pi-search-wrap { position: relative; }
    .pi-search-wrap .fa-search { position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: var(--pi-text-muted); font-size: 0.875rem; }
    .pi-search-wrap input { padding-left: 2.25rem; }
    .pi-filters .form-control, .pi-filters .form-select { border-radius: 0.5rem; border-color: var(--pi-border); font-size: 0.875rem; height: 2.5rem; }
    .pi-filters .form-control:focus, .pi-filters .form-select:focus { border-color: var(--pi-primary); box-shadow: 0 0 0 3px var(--pi-primary-light); }
    .pi-btn-clear { border: none; background: transparent; color: var(--pi-text-muted); font-size: 0.875rem; padding: 0.5rem 0.75rem; border-radius: 0.5rem; display: inline-flex; align-items: center; gap: 0.375rem; cursor: pointer; white-space: nowrap; }
    .pi-btn-clear:hover { background: #f0f0f0; color: var(--pi-text); }

    /* Table card */
    .pi-table-card { background: var(--pi-card); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); box-shadow: var(--pi-shadow); overflow: hidden; }
    .pi-table-header { border-bottom: 1px solid var(--pi-border); padding: 0.75rem 1.25rem; }
    .pi-table-header h2 { font-size: 0.875rem; font-weight: 600; margin: 0; }
    .pi-table-header small { font-size: 0.75rem; color: var(--pi-text-muted); }

    /* Table */
    .pi-table { width: 100%; margin: 0; font-size: 0.92rem; }
    .pi-table thead th { background: rgba(51, 102, 204, 0.08); border-bottom: 1px solid var(--pi-border); font-size: 0.82rem; font-weight: 600; color: var(--pi-primary); text-transform: uppercase; letter-spacing: 0.03em; padding: 0.75rem 1rem; white-space: nowrap; cursor: pointer; user-select: none; }
    .pi-table thead th:hover { color: var(--pi-text); }
    .pi-table thead th .sort-icon { opacity: 0.4; margin-left: 0.25rem; font-size: 0.7rem; }
    .pi-table thead th.sorted .sort-icon { opacity: 1; color: var(--pi-primary); }
    .pi-table tbody td { padding: 0.75rem 1rem; vertical-align: middle; border-bottom: 1px solid #f0f2f5; }
    .pi-table tbody tr:hover { background: #f8f9fb; }
    .pi-table tbody tr:last-child td { border-bottom: none; }
    .pi-table .mono { font-family: 'SF Mono', 'Fira Code', monospace; font-size: 0.75rem; color: var(--pi-text-muted); }
    .pi-table .name-cell { font-weight: 600; }
    .pi-table .email-cell { color: var(--pi-text-muted); font-size: 0.8125rem; }

    /* Turma cell */
    .turma-info { display: flex; align-items: center; gap: 0.5rem; }
    .turma-info .periodo-icon { width: 1.25rem; text-align: center; color: var(--pi-text-muted); }
    .turma-info .turma-name { font-size: 0.8125rem; font-weight: 500; line-height: 1.2; }
    .turma-info .turma-periodo { font-size: 0.6875rem; color: var(--pi-text-muted); }

    /* Status badges */
    .pi-badge { display: inline-flex; align-items: center; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.01em; }
    .pi-badge-pendente { background: var(--pi-warning-light); color: #92610a; }
    .pi-badge-confirmado { background: var(--pi-success-light); color: #1e6e49; }
    .pi-badge-cancelado { background: var(--pi-danger-light); color: #a71d2a; }

    /* Action buttons */
    .pi-actions { display: flex; align-items: center; justify-content: flex-end; gap: 0.25rem; }
    .pi-action-btn { width: 2rem; height: 2rem; border: none; border-radius: 0.375rem; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s; font-size: 0.8125rem; }
    .pi-action-btn.view { background: transparent; color: var(--pi-text-muted); }
    .pi-action-btn.view:hover { background: #f0f0f0; color: var(--pi-text); }
    .pi-action-btn.confirm { background: transparent; color: var(--pi-success); border: 1px solid var(--pi-success); }
    .pi-action-btn.confirm:hover { background: var(--pi-success); color: #fff; }
    .pi-action-btn.cancel { background: transparent; color: var(--pi-danger); border: 1px solid var(--pi-danger); }
    .pi-action-btn.cancel:hover { background: var(--pi-danger); color: #fff; }

    /* Pagination */
    .pi-pagination { display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; border-top: 1px solid var(--pi-border); }
    .pi-pagination .info { font-size: 0.8125rem; color: var(--pi-text-muted); }
    .pi-pagination .pages { display: flex; gap: 0.25rem; }
    .pi-page-btn { width: 2rem; height: 2rem; border: 1px solid var(--pi-border); border-radius: 0.375rem; background: #fff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.8125rem; transition: all 0.15s; color: var(--pi-text); }
    .pi-page-btn:hover { background: #f0f2f5; }
    .pi-page-btn.active { background: var(--pi-primary); color: #fff; border-color: var(--pi-primary); }
    .pi-page-btn:disabled { opacity: 0.4; cursor: not-allowed; }

    /* Empty state */
    .pi-empty { text-align: center; padding: 4rem 1rem; color: var(--pi-text-muted); }
    .pi-empty-icon { width: 4rem; height: 4rem; border-radius: 1rem; background: #f0f2f5; display: inline-flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem; }
    .pi-empty h3 { font-size: 1.125rem; font-weight: 500; margin-bottom: 0.25rem; color: var(--pi-text); }
    .pi-empty p { font-size: 0.875rem; }

    /* Mobile cards */
    .pi-mobile-cards { display: none; }
    .pi-mobile-card { background: var(--pi-card); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); padding: 1rem; box-shadow: var(--pi-shadow); margin-bottom: 0.75rem; }
    .pi-mobile-card .card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem; }
    .pi-mobile-card .card-name { font-weight: 600; font-size: 0.9375rem; }
    .pi-mobile-card .card-email { font-size: 0.75rem; color: var(--pi-text-muted); }
    .pi-mobile-card .card-turma { display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; color: var(--pi-text-muted); margin-bottom: 0.75rem; }
    .pi-mobile-card .card-actions { display: flex; gap: 0.5rem; }
    .pi-mobile-card .card-actions .btn { font-size: 0.75rem; padding: 0.25rem 0.5rem; }

    /* Modal improvements */
    .pi-modal .modal-content { border-radius: var(--pi-radius); border: 1px solid var(--pi-border); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); }
    .pi-modal .modal-header { border-bottom: 1px solid var(--pi-border); padding: 1.25rem 1.5rem; }
    .pi-modal .modal-header .header-flex { display: flex; align-items: center; gap: 0.75rem; }
    .pi-modal .modal-header .header-icon { width: 2.5rem; height: 2.5rem; border-radius: 0.625rem; display: flex; align-items: center; justify-content: center; }
    .pi-modal .modal-header .header-icon.blue { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-modal .modal-header .header-icon.green { background: var(--pi-success-light); color: var(--pi-success); }
    .pi-modal .modal-title { font-size: 1rem; font-weight: 600; margin: 0; }
    .pi-modal .modal-subtitle { font-size: 0.8125rem; color: var(--pi-text-muted); margin: 0; }
    .pi-modal .modal-body { padding: 1.25rem 1.5rem; }
    .pi-modal .modal-footer { border-top: 1px solid var(--pi-border); padding: 1rem 1.5rem; }
    .pi-modal .modal-footer .btn { border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; padding: 0.5rem 1rem; }

    /* View modal detail rows */
    .pi-detail-row { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #f0f2f5; }
    .pi-detail-row:last-child { border-bottom: none; }
    .pi-detail-icon { width: 2rem; height: 2rem; border-radius: 0.5rem; background: #f0f2f5; display: flex; align-items: center; justify-content: center; color: var(--pi-text-muted); font-size: 0.8125rem; flex-shrink: 0; }
    .pi-detail-label { font-size: 0.75rem; font-weight: 500; color: var(--pi-text-muted); }
    .pi-detail-value { font-size: 0.875rem; font-weight: 500; margin-top: 0.125rem; }

    /* Form improvements */
    .pi-form .form-label { font-size: 0.8125rem; font-weight: 500; margin-bottom: 0.375rem; }
    .pi-form .form-label .required { color: var(--pi-danger); }
    .pi-form .form-control, .pi-form .form-select { border-radius: 0.5rem; border-color: var(--pi-border); font-size: 0.875rem; }
    .pi-form .form-control:focus, .pi-form .form-select:focus { border-color: var(--pi-primary); box-shadow: 0 0 0 3px var(--pi-primary-light); }
    .pi-form .form-control.is-invalid { border-color: var(--pi-danger); }
    .pi-form .form-control.is-invalid:focus { box-shadow: 0 0 0 3px var(--pi-danger-light); }
    .pi-form .invalid-feedback { font-size: 0.75rem; }
    .pi-form .form-text { font-size: 0.75rem; color: var(--pi-text-muted); }

    /* Responsive */
    @media (max-width: 991.98px) {
        .pi-desktop-table { display: none !important; }
        .pi-mobile-cards { display: block !important; }
    }
    @media (max-width: 767.98px) {
        .pi-stats { grid-template-columns: repeat(2, 1fr); }
        .pi-filters-grid { grid-template-columns: 1fr; }
        .pi-header { flex-direction: column; align-items: stretch; }
        .pi-header .pi-btn-primary { justify-content: center; }
        .pi-pagination { flex-direction: column; gap: 0.75rem; text-align: center; }
    }
    @media (max-width: 575.98px) {
        .pi-page { padding: 1rem 0.75rem; }
    }

    /* Select2 overrides */
    .select2-container--bootstrap-5 .select2-selection { border-radius: 0.5rem !important; border-color: var(--pi-border) !important; height: 2.5rem !important; font-size: 0.875rem !important; }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered { line-height: 2.5rem !important; }

    /* Loading spinner */
    .pi-spinner { display: inline-block; width: 1rem; height: 1rem; border: 2px solid #fff; border-right-color: transparent; border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 0.375rem; }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection

@section('content')
<div class="pi-page">
    {{-- HEADER --}}
    <div class="pi-header">
        <div class="pi-header-left">
            <div class="pi-header-icon">
                <i class="fas fa-clipboard-list fa-lg"></i>
            </div>
            <div>
                <h1>Pré-Inscrições</h1>
                <p>Gerir todas as pré-inscrições dos candidatos</p>
            </div>
        </div>
        <button class="btn pi-btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovaPreInscricao">
            <i class="fas fa-plus"></i> Nova Pré-Inscrição
        </button>
    </div>

    {{-- STATS --}}
    <div class="pi-stats" id="statsContainer">
        <div class="pi-stat-card">
            <div class="stat-label">Total</div>
            <div class="stat-value text-primary" id="statTotal">0</div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-label">Pendentes</div>
            <div class="stat-value text-warning" id="statPendente">0</div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-label">Confirmados</div>
            <div class="stat-value text-success" id="statConfirmado">0</div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-label">Cancelados</div>
            <div class="stat-value text-danger" id="statCancelado">0</div>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="pi-filters">
        <div class="pi-filters-header">
            <i class="fas fa-filter"></i> Filtros
            <span class="badge bg-primary rounded-pill d-none" id="filterCount">0</span>
        </div>
        <div class="pi-filters-grid">
            <div class="pi-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control" id="filtroSearch" placeholder="Pesquisar por nome ou email...">
            </div>
            <select class="form-select" id="filtroStatus">
                <option value="">Todos os status</option>
                <option value="pendente">Pendente</option>
                <option value="confirmado">Confirmado</option>
                <option value="cancelado">Cancelado</option>
            </select>
            <select class="form-select" id="filtroCurso">
                <option value="">Todos os cursos</option>
            </select>
            <select class="form-select" id="filtroCentro">
                <option value="">Todos os centros</option>
            </select>
            <button class="pi-btn-clear" id="btnLimparFiltros" onclick="limparFiltros()">
                <i class="fas fa-times"></i> Limpar
            </button>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="pi-table-card">
        <div class="pi-table-header">
            <h2>Lista de Pré-Inscrições</h2>
            <small id="tableCount">0 de 0 registos</small>
        </div>

        {{-- Desktop Table --}}
        <div class="pi-desktop-table">
            <table class="pi-table" id="tabelaPreInscricoes">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="id" style="width:60px">ID <i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-sort="nome_completo">Nome <i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-sort="email">Email <i class="fas fa-sort sort-icon"></i></th>
                        <th>Turma</th>
                        <th>Centro</th>
                        <th>Dias</th>
                        <th>Arranque</th>
                        <th class="sortable" data-sort="status">Status <i class="fas fa-sort sort-icon"></i></th>
                        <th style="text-align:right">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaBody">
                </tbody>
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

        {{-- Pagination --}}
        <div class="pi-pagination d-none" id="paginationContainer">
            <div class="info" id="paginationInfo"></div>
            <div class="pages" id="paginationPages"></div>
        </div>
    </div>
</div>

{{-- VIEW MODAL --}}
<div class="modal fade pi-modal" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px">
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
                    <p class="text-muted mt-2">Carregando...</p>
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
                    <div class="mb-3">
                        <label class="form-label">Turma <span class="required">*</span></label>
                        <select class="form-select" name="turma_id" id="criarTurmaId" required>
                            <option value="">Selecione uma turma...</option>
                        </select>
                        <div class="invalid-feedback">Selecione uma turma</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nome Completo <span class="required">*</span></label>
                        <input type="text" class="form-control" name="nome_completo" id="criarNome" placeholder="Nome do candidato" required>
                        <div class="invalid-feedback">Nome é obrigatório</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-3 mb-sm-0">
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
                    <div class="mb-3">
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
                <button type="button" class="btn pi-btn-primary" id="btnSalvar" onclick="salvarPreInscricao()">Guardar</button>
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

    // ── State ────────────────────────────────
    let allData = [];
    let filteredData = [];
    let sortField = 'id';
    let sortDir = 'asc';
    let currentPage = 1;
    const ITEMS_PER_PAGE = 8;

    // ── Init ─────────────────────────────────
    $(document).ready(function() {
        carregarDados();
        carregarFiltros();
        carregarTurmas();
        bindEvents();
    });

    // ── Bind Events ──────────────────────────
    function bindEvents() {
        // Filters with debounce for search
        let searchTimer;
        $('#filtroSearch').on('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(aplicarFiltrosLocais, 250);
        });
        $('#filtroStatus, #filtroCurso, #filtroCentro').on('change', aplicarFiltrosLocais);

        // Sortable headers
        $(document).on('click', '.sortable', function() {
            const field = $(this).data('sort');
            if (sortField === field) {
                sortDir = sortDir === 'asc' ? 'desc' : 'asc';
            } else {
                sortField = field;
                sortDir = 'asc';
            }
            renderTable();
        });
    }

    // ── Data Loading ─────────────────────────
    function carregarDados() {
        $.ajax({
            url: '/api/pre-inscricoes?per_page=1000',
            method: 'GET',
            success: function(response) {
                allData = response.data || response;
                aplicarFiltrosLocais();
            },
            error: function() {
                Swal.fire('Erro', 'Não foi possível carregar as pré-inscrições.', 'error');
            }
        });
    }

    function carregarFiltros() {
        $.get('/api/cursos', function(data) {
            let opts = '<option value="">Todos os cursos</option>';
            (data || []).forEach(function(c) {
                if (c.ativo) opts += '<option value="' + c.id + '">' + c.nome + '</option>';
            });
            $('#filtroCurso').html(opts);
        });
        $.get('/api/centros', function(data) {
            let opts = '<option value="">Todos os centros</option>';
            (data || []).forEach(function(c) {
                if (c.ativo) opts += '<option value="' + c.id + '">' + c.nome + '</option>';
            });
            $('#filtroCentro').html(opts);
        });
    }

    function carregarTurmas() {
        $.get('/api/turmas?per_page=1000', function(data) {
            let opts = '<option value="">Selecione uma turma...</option>';
            var items = data.data || data;
            (items || []).forEach(function(t) {
                var nome = (t.curso ? t.curso.nome : 'Curso') + ' — ' + (t.periodo || '') + ' (' + (t.centro ? t.centro.nome : '') + ')';
                opts += '<option value="' + t.id + '">' + nome + '</option>';
            });
            $('#criarTurmaId').html(opts);
        });
    }

    // ── Filtering ────────────────────────────
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

        // Count active filters
        let count = 0;
        if (search) count++;
        if (status) count++;
        if (curso) count++;
        if (centro) count++;
        if (count > 0) {
            $('#filterCount').text(count).removeClass('d-none');
        } else {
            $('#filterCount').addClass('d-none');
        }
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

    // ── Stats ────────────────────────────────
    function updateStats() {
        var total = allData.length;
        var pendente = allData.filter(function(d) { return d.status === 'pendente'; }).length;
        var confirmado = allData.filter(function(d) { return d.status === 'confirmado'; }).length;
        var cancelado = allData.filter(function(d) { return d.status === 'cancelado'; }).length;
        $('#statTotal').text(total);
        $('#statPendente').text(pendente);
        $('#statConfirmado').text(confirmado);
        $('#statCancelado').text(cancelado);
    }

    // ── Table Rendering ──────────────────────
    function renderTable() {
        // Sort
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

        // Update sort icons
        $('.sortable').removeClass('sorted').find('.sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
        $('.sortable[data-sort="' + sortField + '"]').addClass('sorted')
            .find('.sort-icon').removeClass('fa-sort').addClass(sortDir === 'asc' ? 'fa-sort-up' : 'fa-sort-down');

        // Pagination
        var totalPages = Math.max(1, Math.ceil(sorted.length / ITEMS_PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;
        var start = (currentPage - 1) * ITEMS_PER_PAGE;
        var paged = sorted.slice(start, start + ITEMS_PER_PAGE);

        // Table count
        $('#tableCount').text(filteredData.length + ' de ' + allData.length + ' registos');

        // Empty state
        if (sorted.length === 0) {
            $('#tabelaBody').empty();
            $('#mobileCards').empty();
            $('#emptyState').removeClass('d-none');
            $('#paginationContainer').addClass('d-none');
            return;
        }
        $('#emptyState').addClass('d-none');

        // Render desktop rows
        var html = '';
        paged.forEach(function(item) {
            html += '<tr>';
            html += '<td class="mono">#' + item.id + '</td>';
            html += '<td class="name-cell">' + esc(item.nome_completo) + '</td>';
            html += '<td class="email-cell">' + esc(item.email || '—') + '</td>';
            html += '<td>' + renderTurmaCell(item) + '</td>';
            html += '<td style="font-size:0.8125rem">' + esc(item.turma && item.turma.centro ? item.turma.centro.nome : '—') + '</td>';
            html += '<td style="font-size:0.8125rem">' + (item.turma && item.turma.dia_semana ? item.turma.dia_semana.join(', ') : '—') + '</td>';
            html += '<td style="font-size:0.8125rem">' + formatDate(item.turma ? item.turma.data_arranque : null) + '</td>';
            html += '<td>' + statusBadge(item.status) + '</td>';
            html += '<td>' + renderActions(item) + '</td>';
            html += '</tr>';
        });
        $('#tabelaBody').html(html);

        // Render mobile cards
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
            }
            mobileHtml += '<div class="card-actions">';
            mobileHtml += '<button class="btn btn-sm btn-outline-secondary" onclick="visualizarPreInscricao(' + item.id + ')"><i class="fas fa-eye me-1"></i>Ver</button>';
            if (item.status !== 'confirmado') {
                mobileHtml += ' <button class="btn btn-sm btn-outline-success" onclick="confirmarPreInscricao(' + item.id + ')"><i class="fas fa-check me-1"></i>Confirmar</button>';
            }
            if (item.status !== 'cancelado') {
                mobileHtml += ' <button class="btn btn-sm btn-outline-danger" onclick="cancelarPreInscricao(' + item.id + ')"><i class="fas fa-times me-1"></i>Cancelar</button>';
            }
            mobileHtml += '</div></div>';
        });
        $('#mobileCards').html(mobileHtml);

        // Pagination
        if (totalPages > 1) {
            $('#paginationContainer').removeClass('d-none');
            $('#paginationInfo').text(sorted.length + ' resultado' + (sorted.length !== 1 ? 's' : '') + ' — Página ' + currentPage + ' de ' + totalPages);
            var pagesHtml = '<button class="pi-page-btn" onclick="goToPage(' + (currentPage - 1) + ')"' + (currentPage <= 1 ? ' disabled' : '') + '><i class="fas fa-chevron-left" style="font-size:0.7rem"></i></button>';
            for (var p = 1; p <= totalPages; p++) {
                pagesHtml += '<button class="pi-page-btn' + (p === currentPage ? ' active' : '') + '" onclick="goToPage(' + p + ')">' + p + '</button>';
            }
            pagesHtml += '<button class="pi-page-btn" onclick="goToPage(' + (currentPage + 1) + ')"' + (currentPage >= totalPages ? ' disabled' : '') + '><i class="fas fa-chevron-right" style="font-size:0.7rem"></i></button>';
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
        // Scroll to table top
        $('.pi-table-card')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    // ── Helpers ──────────────────────────────
    function esc(str) {
        if (!str) return '';
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function periodoIcon(periodo) {
        switch (periodo) {
            case 'manha': return '<i class="fas fa-sun"></i>';
            case 'tarde': return '<i class="fas fa-cloud-sun"></i>';
            case 'noite': return '<i class="fas fa-moon"></i>';
            default: return '<i class="fas fa-clock"></i>';
        }
    }

    function periodoLabel(periodo) {
        switch (periodo) {
            case 'manha': return 'Manhã';
            case 'tarde': return 'Tarde';
            case 'noite': return 'Noite';
            default: return periodo || '—';
        }
    }

    function renderTurmaCell(item) {
        if (!item.turma) return '<span style="color:var(--pi-text-muted);font-size:0.8125rem">Sem turma</span>';
        return '<div class="turma-info">' +
            '<span class="periodo-icon">' + periodoIcon(item.turma.periodo) + '</span>' +
            '<div><div class="turma-name">' + esc(item.turma.curso ? item.turma.curso.nome : '') + '</div>' +
            '<div class="turma-periodo">' + periodoLabel(item.turma.periodo) + '</div></div></div>';
    }

    function statusBadge(status) {
        switch (status) {
            case 'pendente': return '<span class="pi-badge pi-badge-pendente">Pendente</span>';
            case 'confirmado': return '<span class="pi-badge pi-badge-confirmado">Confirmado</span>';
            case 'cancelado': return '<span class="pi-badge pi-badge-cancelado">Cancelado</span>';
            default: return '<span class="pi-badge" style="background:#eee;color:#666">' + esc(status) + '</span>';
        }
    }

    function renderActions(item) {
        var html = '<div class="pi-actions">';
        html += '<button class="pi-action-btn view" onclick="visualizarPreInscricao(' + item.id + ')" title="Ver detalhes"><i class="fas fa-eye"></i></button>';
        if (item.status !== 'confirmado') {
            html += '<button class="pi-action-btn confirm" onclick="confirmarPreInscricao(' + item.id + ')" title="Confirmar"><i class="fas fa-check"></i></button>';
        }
        if (item.status !== 'cancelado') {
            html += '<button class="pi-action-btn cancel" onclick="cancelarPreInscricao(' + item.id + ')" title="Cancelar"><i class="fas fa-times"></i></button>';
        }
        html += '</div>';
        return html;
    }

    function formatDate(dateStr) {
        if (!dateStr) return '—';
        try {
            var d = new Date(dateStr);
            return d.toLocaleDateString('pt-PT');
        } catch(e) { return '—'; }
    }

    // ── View Detail ──────────────────────────
    window.visualizarPreInscricao = function(id) {
        var modal = new bootstrap.Modal(document.getElementById('viewModal'));
        $('#viewModalId').text('#' + id);
        $('#viewModalContent').html('<div class="text-center py-4"><div class="spinner-border text-primary"></div><p class="text-muted mt-2">Carregando...</p></div>');
        modal.show();

        $.ajax({
            url: '/api/pre-inscricoes/' + id,
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
                $('#viewModalContent').html('<div class="text-center text-danger py-4"><i class="fas fa-exclamation-circle fa-2x mb-2"></i><p>Erro ao carregar os detalhes.</p></div>');
            }
        });
    };

    function detailRow(icon, label, value) {
        return '<div class="pi-detail-row"><div class="pi-detail-icon"><i class="fas ' + icon + '"></i></div><div style="min-width:0;flex:1"><div class="pi-detail-label">' + label + '</div><div class="pi-detail-value">' + value + '</div></div></div>';
    }

    // ── Status Actions ───────────────────────
    window.confirmarPreInscricao = function(id) {
        Swal.fire({
            title: 'Confirmar Pré-Inscrição',
            text: 'Tem certeza que deseja confirmar esta pré-inscrição?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2e9e6b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, confirmar',
            cancelButtonText: 'Cancelar'
        }).then(function(result) {
            if (result.isConfirmed) atualizarStatus(id, 'confirmado');
        });
    };

    window.cancelarPreInscricao = function(id) {
        Swal.fire({
            title: 'Cancelar Pré-Inscrição',
            text: 'Tem certeza que deseja cancelar esta pré-inscrição?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, cancelar',
            cancelButtonText: 'Não, voltar'
        }).then(function(result) {
            if (result.isConfirmed) atualizarStatus(id, 'cancelado');
        });
    };

    function atualizarStatus(id, status) {
        $.ajax({
            url: '/api/pre-inscricoes/' + id,
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({ status: status }),
            success: function() {
                // Update local data without reload
                allData = allData.map(function(item) {
                    if (item.id === id) item.status = status;
                    return item;
                });
                var txt = status === 'confirmado' ? 'confirmada' : 'cancelada';
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Pré-inscrição ' + txt + ' com sucesso', timer: 2000, showConfirmButton: false });
                aplicarFiltrosLocais();
            },
            error: function(xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Erro ao atualizar o status.';
                Swal.fire('Erro', msg, 'error');
            }
        });
    }

    // ── Create ───────────────────────────────
    window.salvarPreInscricao = function() {
        var form = $('#formCriarPreInscricao');
        var turmaId = $('#criarTurmaId').val();
        var nome = $('#criarNome').val().trim();
        var email = $('#criarEmail').val().trim();
        var contactos = $('#criarContactos').val().trim();
        var status = $('#criarStatus').val();
        var observacoes = $('#criarObservacoes').val().trim();

        // Reset validation
        form.find('.form-control, .form-select').removeClass('is-invalid');
        var valid = true;

        if (!turmaId) { $('#criarTurmaId').addClass('is-invalid'); valid = false; }
        if (!nome) { $('#criarNome').addClass('is-invalid'); valid = false; }
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { $('#criarEmail').addClass('is-invalid'); valid = false; }
        if (!valid) return;

        var data = {
            turma_id: turmaId,
            nome_completo: nome,
            email: email || null,
            status: status,
            observacoes: observacoes || null,
            contactos: contactos ? [contactos] : []
        };

        var btn = $('#btnSalvar');
        btn.prop('disabled', true).html('<span class="pi-spinner"></span> Guardando...');

        $.ajax({
            url: '/api/pre-inscricoes',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                // Add to local data (API returns {status, mensagem, dados})
                const dados = response.dados || response;
                // Garanto que turma está carregada (pode vir como null se não existir)
                if (dados.turma && !dados.turma.curso) {
                    // tenta recuperar pelo id caso venha parcial
                    dados.turma.curso = dados.turma.curso || null;
                }
                allData.unshift(dados);
                aplicarFiltrosLocais();

                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Pré-inscrição criada com sucesso', timer: 2000, showConfirmButton: false });
                form[0].reset();
                bootstrap.Modal.getInstance(document.getElementById('modalNovaPreInscricao')).hide();
            },
            error: function(xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Erro ao criar a pré-inscrição.';
                Swal.fire('Erro', msg, 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html('Guardar');
            }
        });
    };

})();
</script>
@endsection
