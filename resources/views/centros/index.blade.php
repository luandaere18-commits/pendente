@extends('layouts.app')

@section('title', 'Centros')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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

    .pi-page { width: 100%; padding: 0; overflow-x: hidden; }

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
        font-size: 0.8125rem; border: none; cursor: pointer;
        transition: all 0.15s; white-space: nowrap; flex-shrink: 0;
    }
    .pi-page-header .pi-btn-create:hover { background: #dbeafe; }

    /* ── STATS ── */
    .pi-stats-bar {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 0;
        background: #fff; border-bottom: 1px solid var(--pi-border);
    }
    .pi-stat {
        padding: 0.75rem 1.25rem; border-right: 1px solid var(--pi-border);
        display: flex; align-items: center; gap: 0.75rem; min-width: 0;
    }
    .pi-stat:last-child { border-right: none; }
    .pi-stat-icon {
        width: 2.25rem; height: 2.25rem; border-radius: 0.5rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.875rem; flex-shrink: 0;
    }
    .pi-stat-icon.blue { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-stat-icon.green{ background: var(--pi-success-light); color: var(--pi-success); }
    .pi-stat-icon.cyan { background: var(--pi-info-light);    color: var(--pi-info); }
    .pi-stat-icon.gray { background: rgba(100,116,139,0.08);  color: var(--pi-muted); }
    .pi-stat-label { font-size: 0.6875rem; font-weight: 500; color: var(--pi-text-muted); text-transform: uppercase; letter-spacing: 0.04em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .pi-stat-value { font-size: 1.375rem; font-weight: 700; line-height: 1; }

    /* ── TOOLBAR — filters always side by side ── */
    .pi-toolbar {
        background: #fff; border-bottom: 1px solid var(--pi-border);
        padding: 0.625rem 1.25rem;
        display: flex; flex-wrap: nowrap; align-items: center; gap: 0.5rem;
        overflow-x: auto;
    }
    .pi-toolbar .search-wrap {
        position: relative; flex: 1 1 180px; min-width: 140px;
    }
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
    .pi-btn-clear {
        border: none; background: transparent; color: var(--pi-text-muted);
        font-size: 0.8125rem; padding: 0.375rem 0.5rem; border-radius: var(--pi-radius);
        display: inline-flex; align-items: center; gap: 0.25rem; cursor: pointer;
        white-space: nowrap; flex-shrink: 0;
    }
    .pi-btn-clear:hover { background: var(--pi-danger-light); color: var(--pi-danger); }

    /* ── TABLE ── */
    .pi-table-wrap { background: #fff; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .pi-table { width: 100%; margin: 0; border-collapse: collapse; font-size: 0.8125rem; table-layout: auto; }
    .pi-table thead th {
        background: var(--pi-primary); color: #fff;
        font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;
        padding: 0.625rem 1rem; white-space: nowrap;
        position: sticky; top: 0; z-index: 5; border-bottom: none;
    }
    .pi-table tbody td { padding: 0.5rem 1rem; vertical-align: middle; border-bottom: 1px solid #f0f4ff; white-space: nowrap; }
    .pi-table tbody tr { transition: background 0.1s; }
    .pi-table tbody tr:hover { background: var(--pi-primary-light); }
    .pi-table tbody tr:last-child td { border-bottom: none; }
    .pi-table .mono { font-family: 'SF Mono','Fira Code',monospace; font-size: 0.6875rem; color: var(--pi-muted); }

    /* ── PAGINATION ── */
    .pi-pagination-bar {
        background: var(--pi-primary); color: #fff;
        padding: 0.5rem 1.25rem;
        display: flex; align-items: center; justify-content: space-between;
        font-size: 0.75rem; flex-wrap: wrap; gap: 0.5rem;
    }
    .pi-pagination-bar .info { opacity: 0.85; }
    .pi-pagination-bar .pages { display: flex; gap: 0.25rem; flex-wrap: wrap; }
    .pi-pagination-bar .page-btn {
        padding: 0.25rem 0.625rem; border-radius: 0.25rem;
        border: 1px solid rgba(255,255,255,0.3);
        background: transparent; color: #fff; cursor: pointer;
        font-size: 0.75rem; font-weight: 500; transition: all 0.15s;
    }
    .pi-pagination-bar .page-btn:hover { background: rgba(255,255,255,0.15); }
    .pi-pagination-bar .page-btn.active { background: #fff; color: var(--pi-primary); font-weight: 700; border-color: #fff; }
    .pi-pagination-bar .page-btn:disabled { opacity: 0.4; cursor: not-allowed; }

    /* ── ACTION BUTTONS ── */
    .pi-actions { display: flex; align-items: center; justify-content: flex-end; gap: 0.125rem; transition: opacity 0.15s; }
    @media (hover: hover) and (pointer: fine) {
        .pi-actions { opacity: 0; }
        .pi-table tbody tr:hover .pi-actions { opacity: 1; }
    }
    .pi-action-btn {
        width: 1.75rem; height: 1.75rem; border: none; border-radius: 0.25rem;
        display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.15s; font-size: 0.75rem;
    }
    .pi-action-btn.view   { background: transparent; color: var(--pi-primary); }
    .pi-action-btn.view:hover   { background: var(--pi-primary-light); }
    .pi-action-btn.edit   { background: transparent; color: var(--pi-primary); border: 1px solid var(--pi-primary); }
    .pi-action-btn.edit:hover   { background: var(--pi-primary); color: #fff; }
    .pi-action-btn.delete { background: transparent; color: var(--pi-danger);  border: 1px solid var(--pi-danger); }
    .pi-action-btn.delete:hover { background: var(--pi-danger); color: #fff; }

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
    .pi-mobile-card .card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.375rem; gap: 0.5rem; }
    .pi-mobile-card .card-name { font-weight: 600; font-size: 0.875rem; color: var(--pi-text); word-break: break-word; }
    .pi-mobile-card .card-meta { font-size: 0.6875rem; color: var(--pi-text-muted); margin-bottom: 0.375rem; }
    .pi-mobile-card .card-actions { display: flex; gap: 0.375rem; flex-wrap: wrap; }
    .pi-mobile-card .card-actions .btn { font-size: 0.6875rem; padding: 0.2rem 0.5rem; }

    /* ── MODAL ── */
    .pi-modal .modal-content { border-radius: var(--pi-radius); border: 1px solid var(--pi-border); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); }
    .pi-modal .modal-header { border-bottom: 1px solid var(--pi-border); padding: 1rem 1.25rem; background: var(--pi-primary-light); }
    .pi-modal .modal-header .header-flex { display: flex; align-items: center; gap: 0.625rem; }
    .pi-modal .modal-header .header-icon { width: 2.25rem; height: 2.25rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .pi-modal .modal-header .header-icon.blue  { background: var(--pi-primary); color: #fff; }
    .pi-modal .modal-header .header-icon.green  { background: var(--pi-success); color: #fff; }
    .pi-modal .modal-header .header-icon.orange { background: var(--pi-warning); color: #fff; }
    .pi-modal .modal-title    { font-size: 0.9375rem; font-weight: 600; margin: 0; color: var(--pi-text); }
    .pi-modal .modal-subtitle { font-size: 0.75rem; color: var(--pi-text-muted); margin: 0; }
    .pi-modal .modal-body   { padding: 1rem 1.25rem; }
    .pi-modal .modal-footer { border-top: 1px solid var(--pi-border); padding: 0.75rem 1.25rem; background: var(--pi-bg); }
    .pi-modal .modal-footer .btn { border-radius: var(--pi-radius); font-size: 0.8125rem; font-weight: 500; padding: 0.4375rem 0.875rem; }

    .pi-detail-row { display: flex; align-items: flex-start; gap: 0.625rem; padding: 0.5rem 0; border-bottom: 1px solid #f0f4ff; }
    .pi-detail-row:last-child { border-bottom: none; }
    .pi-detail-icon  { width: 1.75rem; height: 1.75rem; border-radius: 0.375rem; background: var(--pi-primary-light); display: flex; align-items: center; justify-content: center; color: var(--pi-primary); font-size: 0.75rem; flex-shrink: 0; }
    .pi-detail-label { font-size: 0.6875rem; font-weight: 500; color: var(--pi-text-muted); text-transform: uppercase; letter-spacing: 0.03em; }
    .pi-detail-value { font-size: 0.8125rem; font-weight: 500; margin-top: 0.0625rem; word-break: break-word; }

    /* ── FORM ── */
    .pi-form .form-label { font-size: 0.75rem; font-weight: 500; margin-bottom: 0.25rem; color: var(--pi-text); }
    .pi-form .form-label .required { color: var(--pi-danger); }
    .pi-form .form-control, .pi-form .form-select { border-radius: var(--pi-radius); border-color: var(--pi-border); font-size: 0.8125rem; height: 2.25rem; }
    .pi-form textarea.form-control { height: auto; }
    .pi-form .form-control:focus, .pi-form .form-select:focus { border-color: var(--pi-primary); box-shadow: 0 0 0 2px var(--pi-primary-light); }
    .pi-form .form-text { font-size: 0.6875rem; color: var(--pi-text-muted); }
    .pi-form .section-title {
        font-size: 0.75rem; font-weight: 600; color: var(--pi-primary);
        margin-bottom: 0.625rem; padding-bottom: 0.375rem;
        border-bottom: 2px solid var(--pi-primary);
        display: flex; align-items: center; gap: 0.375rem;
        text-transform: uppercase; letter-spacing: 0.03em;
    }

    /* ── BUTTON PRIMARY / SPINNER ── */
    .pi-btn-primary { background: var(--pi-primary); border: none; color: #fff; border-radius: var(--pi-radius); padding: 0.4375rem 0.875rem; font-size: 0.8125rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.375rem; transition: all 0.15s; cursor: pointer; }
    .pi-btn-primary:hover { background: var(--pi-primary-dark); color: #fff; }
    .pi-spinner { display: inline-block; width: 0.875rem; height: 0.875rem; border: 2px solid #fff; border-right-color: transparent; border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 0.25rem; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ── RESPONSIVE ── */
    @media (max-width: 991.98px) {
        .pi-desktop-table { display: none !important; }
        .pi-mobile-cards  { display: block !important; }
    }
    @media (max-width: 767.98px) {
        .pi-stats-bar { grid-template-columns: repeat(2, 1fr); }
        .pi-stat { border-bottom: 1px solid var(--pi-border); }
        .pi-page-header { flex-direction: column; align-items: stretch; }
        .pi-page-header .pi-btn-create { justify-content: center; }
        .pi-pagination-bar { flex-direction: column; gap: 0.5rem; text-align: center; }
    }
    @media (max-width: 575.98px) {
        .pi-page-header { padding: 0.75rem; }
        .pi-page-header h1 { font-size: 1.1rem; }
        .pi-toolbar { padding: 0.5rem 0.75rem; }
        .pi-stat { padding: 0.5rem 0.75rem; }
        .pi-stat-value { font-size: 1.125rem; }
    }
    @media (max-width: 374.98px) {
        .pi-stats-bar { grid-template-columns: 1fr; }
        .pi-stat { border-right: none; }
    }
</style>
@endsection

@section('content')
<div class="pi-page">

    {{-- BLUE HEADER --}}
    <div class="pi-page-header">
        <div>
            <div style="display:flex;align-items:center;gap:0.625rem">
                <i class="fas fa-building fa-lg" style="opacity:0.9"></i>
                <div>
                    <h1>Gestão de Centros</h1>
                    <p>Gerir todos os centros de formação do sistema</p>
                </div>
            </div>
        </div>
        <button class="pi-btn-create" data-bs-toggle="modal" data-bs-target="#modalNovoCentro">
            <i class="fas fa-plus"></i> Novo Centro
        </button>
    </div>

    {{-- STATS BAR --}}
    <div class="pi-stats-bar">
        <div class="pi-stat">
            <div class="pi-stat-icon blue"><i class="fas fa-building"></i></div>
            <div>
                <div class="pi-stat-label">Total</div>
                <div class="pi-stat-value" style="color:var(--pi-primary)" id="statTotal">{{ $centros->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon green"><i class="fas fa-map-marker-alt"></i></div>
            <div>
                <div class="pi-stat-label">Com Localização</div>
                <div class="pi-stat-value" style="color:var(--pi-success)" id="statComLocalizacao">{{ $centros->filter(fn($c) => $c->localizacao)->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon cyan"><i class="fas fa-envelope"></i></div>
            <div>
                <div class="pi-stat-label">Com Email</div>
                <div class="pi-stat-value" style="color:var(--pi-info)" id="statComEmail">{{ $centros->filter(fn($c) => $c->email)->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon gray"><i class="fas fa-phone"></i></div>
            <div>
                <div class="pi-stat-label">Com Contacto</div>
                <div class="pi-stat-value" style="color:var(--pi-muted)" id="statComContacto">{{ $centros->filter(fn($c) => $c->contactos && count($c->contactos) > 0)->count() }}</div>
            </div>
        </div>
    </div>

    {{-- TOOLBAR — filters always side by side --}}
    <div class="pi-toolbar">
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="filtroNome" placeholder="Pesquisar por nome do centro...">
        </div>
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="filtroLocalizacao" placeholder="Pesquisar por localização...">
        </div>
        <button class="pi-btn-clear" id="btnLimparFiltros" onclick="limparFiltros()" disabled>
            <i class="fas fa-times-circle"></i> Limpar
        </button>
    </div>

    {{-- TABLE --}}
    <div class="pi-table-wrap">
        {{-- Desktop Table --}}
        <div class="pi-desktop-table">
            <table class="pi-table">
                <thead>
                    <tr>
                        <th style="width:50px">ID</th>
                        <th>Nome</th>
                        <th>Localização</th>
                        <th>Contacto(s)</th>
                        <th>Email</th>
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
            <h3>Nenhum centro encontrado</h3>
            <p>Tente ajustar os filtros ou criar um novo centro</p>
        </div>
    </div>

    {{-- PAGINATION BAR --}}
    <div class="pi-pagination-bar" id="paginationContainer">
        <span class="info" id="paginationInfo"></span>
        <div class="pages" id="paginationPages"></div>
    </div>
</div>

{{-- MODAL: Visualizar Centro --}}
<div class="modal fade pi-modal" id="modalVisualizarCentro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon green"><i class="fas fa-eye"></i></div>
                    <div>
                        <h5 class="modal-title">Detalhes do Centro</h5>
                        <p class="modal-subtitle">Informações completas</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="conteudoVisualizarCentro">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2" style="font-size:0.8125rem">Carregando...</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Criar Novo Centro --}}
<div class="modal fade pi-modal" id="modalNovoCentro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue"><i class="fas fa-plus-circle"></i></div>
                    <div>
                        <h5 class="modal-title">Criar Novo Centro</h5>
                        <p class="modal-subtitle">Preencha os dados do centro</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNovoCentroAjax" class="pi-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nome <span class="required">*</span></label>
                            <input type="text" class="form-control" name="nome" required placeholder="Ex: Centro de Lisboa">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contacto(s) <span class="required">*</span></label>
                            <input type="text" class="form-control" id="contactosInput" required placeholder="Ex: 923111111, 924222222">
                            <div class="form-text">Separe múltiplos telefones por vírgula</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Localização <span class="required">*</span></label>
                            <input type="text" class="form-control" name="localizacao" required placeholder="Ex: Avenida Principal, 123">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Ex: centro@email.com">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoCentroAjax" class="btn pi-btn-primary"><i class="fas fa-save"></i> Criar Centro</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Editar Centro --}}
<div class="modal fade pi-modal" id="modalEditarCentro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon orange"><i class="fas fa-edit"></i></div>
                    <div>
                        <h5 class="modal-title">Editar Centro</h5>
                        <p class="modal-subtitle">Atualizar dados do centro</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarCentroAjax" class="pi-form">
                    @csrf
                    <input type="hidden" name="centro_id" id="editCentroId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nome <span class="required">*</span></label>
                            <input type="text" class="form-control" id="editNome" name="nome" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contacto(s) <span class="required">*</span></label>
                            <input type="text" class="form-control" id="editContactos" name="contactos" required>
                            <div class="form-text">Separe múltiplos telefones por vírgula</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Localização <span class="required">*</span></label>
                            <input type="text" class="form-control" id="editLocalizacao" name="localizacao" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarCentroAjax" class="btn pi-btn-primary"><i class="fas fa-save"></i> Guardar Alterações</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function() {
    'use strict';

    let allData = @json($centros->values());
    let filteredData = [];
    let currentPage = 1;
    const PER_PAGE = 15;

    $(document).ready(function() {
        bindEventosFiltros();
        configurarEventos();
        aplicarFiltrosLocais();
    });

    /* ── FILTROS ── */
    function bindEventosFiltros() {
        let searchTimer;
        $('#filtroNome, #filtroLocalizacao').on('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(aplicarFiltrosLocais, 250);
        });
    }

    function aplicarFiltrosLocais() {
        const nome = ($('#filtroNome').val() || '').toLowerCase().trim();
        const loc  = ($('#filtroLocalizacao').val() || '').toLowerCase().trim();

        filteredData = allData.filter(function(c) {
            if (nome && !(c.nome || '').toLowerCase().includes(nome)) return false;
            if (loc  && !(c.localizacao || '').toLowerCase().includes(loc))  return false;
            return true;
        });

        const hasFilters = nome || loc;
        $('#btnLimparFiltros').prop('disabled', !hasFilters);
        currentPage = 1;
        renderTabela();
    }

    window.limparFiltros = function() {
        $('#filtroNome').val('');
        $('#filtroLocalizacao').val('');
        aplicarFiltrosLocais();
    };

    /* ── RENDER ── */
    function esc(str) {
        if (!str) return '';
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    function renderTabela() {
        const total = filteredData.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;
        const start = (currentPage - 1) * PER_PAGE;
        const paged = filteredData.slice(start, start + PER_PAGE);

        if (total === 0) {
            $('#tabelaBody').empty();
            $('#mobileCards').empty();
            $('#emptyState').removeClass('d-none');
            $('#paginationInfo').text('Nenhum centro encontrado');
            $('#paginationPages').empty();
            return;
        }
        $('#emptyState').addClass('d-none');

        let html = '';
        paged.forEach(function(c) {
            const contactosHtml = (c.contactos && c.contactos.length > 0)
                ? c.contactos.map(function(ct) { return '<span style="display:block;font-size:0.75rem">' + esc(ct) + '</span>'; }).join('')
                : '<span style="color:var(--pi-text-muted)">—</span>';

            html += '<tr>';
            html += '<td class="mono">#' + c.id + '</td>';
            html += '<td><strong style="font-size:0.8125rem">' + esc(c.nome) + '</strong></td>';
            html += '<td style="font-size:0.75rem">' + esc(c.localizacao || '—') + '</td>';
            html += '<td>' + contactosHtml + '</td>';
            html += '<td style="font-size:0.75rem;color:var(--pi-text-muted)">' + esc(c.email || '—') + '</td>';
            html += '<td><div class="pi-actions">';
            html += '<button class="pi-action-btn view" onclick="visualizarCentro(' + c.id + ')" title="Visualizar"><i class="fas fa-eye"></i></button>';
            html += '<button class="pi-action-btn edit" onclick="abrirEdicaoCentro(' + c.id + ')" title="Editar"><i class="fas fa-edit"></i></button>';
            html += '<button class="pi-action-btn delete" onclick="eliminarCentro(' + c.id + ')" title="Eliminar"><i class="fas fa-trash"></i></button>';
            html += '</div></td></tr>';
        });
        $('#tabelaBody').html(html);

        let mobileHtml = '';
        paged.forEach(function(c) {
            const contactoStr = (c.contactos && c.contactos.length > 0) ? c.contactos.join(', ') : 'Sem contacto';
            mobileHtml += '<div class="pi-mobile-card">';
            mobileHtml += '<div class="card-top"><div>'
                + '<div class="card-name">' + esc(c.nome) + '</div>'
                + '<div class="card-meta">' + esc(c.localizacao || 'Sem localização') + ' · ' + esc(c.email || 'Sem email') + '</div>'
                + '</div></div>';
            mobileHtml += '<div class="card-meta"><i class="fas fa-phone me-1"></i>' + esc(contactoStr) + '</div>';
            mobileHtml += '<div class="card-actions">';
            mobileHtml += '<button class="btn btn-sm btn-outline-primary" onclick="visualizarCentro(' + c.id + ')"><i class="fas fa-eye me-1"></i>Ver</button>';
            mobileHtml += '<button class="btn btn-sm btn-outline-primary" onclick="abrirEdicaoCentro(' + c.id + ')"><i class="fas fa-edit me-1"></i>Editar</button>';
            mobileHtml += '<button class="btn btn-sm btn-outline-danger" onclick="eliminarCentro(' + c.id + ')"><i class="fas fa-trash me-1"></i>Eliminar</button>';
            mobileHtml += '</div></div>';
        });
        $('#mobileCards').html(mobileHtml);

        const from = start + 1;
        const to = Math.min(start + PER_PAGE, total);
        $('#paginationInfo').text('Mostrando ' + from + '–' + to + ' de ' + total + ' centro(s)');

        if (totalPages > 1) {
            let pagesHtml = '<button class="page-btn" onclick="goToPage(' + (currentPage - 1) + ')"' + (currentPage <= 1 ? ' disabled' : '') + '><i class="fas fa-chevron-left" style="font-size:0.6rem"></i></button>';
            const maxBtn = 7;
            let startBtn = Math.max(1, currentPage - Math.floor(maxBtn / 2));
            let endBtn   = Math.min(totalPages, startBtn + maxBtn - 1);
            if (endBtn - startBtn < maxBtn - 1) startBtn = Math.max(1, endBtn - maxBtn + 1);
            for (let p = startBtn; p <= endBtn; p++) {
                pagesHtml += '<button class="page-btn' + (p === currentPage ? ' active' : '') + '" onclick="goToPage(' + p + ')">' + p + '</button>';
            }
            pagesHtml += '<button class="page-btn" onclick="goToPage(' + (currentPage + 1) + ')"' + (currentPage >= totalPages ? ' disabled' : '') + '><i class="fas fa-chevron-right" style="font-size:0.6rem"></i></button>';
            $('#paginationPages').html(pagesHtml);
        } else {
            $('#paginationPages').empty();
        }
    }

    window.goToPage = function(page) {
        const totalPages = Math.max(1, Math.ceil(filteredData.length / PER_PAGE));
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderTabela();
        $('.pi-table-wrap')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    /* ── MODAL EVENTOS ── */
    function configurarEventos() {
        $('#modalNovoCentro').on('show.bs.modal', function() {
            $('#formNovoCentroAjax')[0].reset();
        });
        $('#formNovoCentroAjax').on('submit', function(e) { e.preventDefault(); criarCentro(); });
        $('#formEditarCentroAjax').on('submit', function(e) { e.preventDefault(); atualizarCentro(); });
    }

    /* ── VISUALIZAR (usa dados locais quando disponíveis, API como fallback) ── */
    window.visualizarCentro = function(centroId) {
        const local = allData.find(function(c) { return c.id == centroId; });
        if (local) {
            renderVisualizarModal(local);
            return;
        }
        $('#conteudoVisualizarCentro').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>');
        new bootstrap.Modal(document.getElementById('modalVisualizarCentro')).show();
        $.ajax({
            url: '/centros/' + centroId, method: 'GET',
            success: function(response) { renderVisualizarModal(response.dados || response); },
            error: function(xhr) {
                $('#conteudoVisualizarCentro').html('<div class="text-center py-3 text-danger">Erro ao carregar detalhes</div>');
            }
        });
    };

    function renderVisualizarModal(c) {
        const contactosStr = (c.contactos && c.contactos.length > 0) ? c.contactos.join(', ') : 'N/A';
        const conteudo = dr('fa-building', 'Nome', esc(c.nome))
            + dr('fa-map-marker-alt', 'Localização', esc(c.localizacao || 'N/A'))
            + dr('fa-phone', 'Contacto(s)', esc(contactosStr))
            + dr('fa-envelope', 'Email', esc(c.email || 'N/A'));
        $('#conteudoVisualizarCentro').html(conteudo);
        new bootstrap.Modal(document.getElementById('modalVisualizarCentro')).show();
    }

    function dr(icon, label, value) {
        return '<div class="pi-detail-row"><div class="pi-detail-icon"><i class="fas ' + icon + '"></i></div><div style="min-width:0;flex:1"><div class="pi-detail-label">' + label + '</div><div class="pi-detail-value">' + value + '</div></div></div>';
    }

    /* ── EDITAR ── */
    window.abrirEdicaoCentro = function(centroId) {
        const local = allData.find(function(c) { return c.id == centroId; });
        if (local) {
            preencherFormEditar(local);
            return;
        }
        $.ajax({
            url: '/centros/' + centroId, method: 'GET',
            success: function(response) { preencherFormEditar(response.dados || response); },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao carregar dados do centro', confirmButtonColor: '#1d4ed8' });
            }
        });
    };

    function preencherFormEditar(c) {
        $('#editCentroId').val(c.id);
        $('#editNome').val(c.nome);
        $('#editLocalizacao').val(c.localizacao || '');
        $('#editContactos').val((c.contactos && c.contactos.length > 0) ? c.contactos.join(', ') : '');
        $('#editEmail').val(c.email || '');
        new bootstrap.Modal(document.getElementById('modalEditarCentro')).show();
    }

    /* ── CRIAR ── */
    function criarCentro() {
        const contactosInput = $('#contactosInput').val().trim();
        const contactosArray = contactosInput.split(',').map(function(c) { return c.trim(); }).filter(function(c) { return c.length > 0; });
        if (contactosArray.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'Adicione pelo menos um contacto', confirmButtonColor: '#1d4ed8' });
            return;
        }
        const dados = {
            nome: $('#formNovoCentroAjax [name="nome"]').val(),
            localizacao: $('#formNovoCentroAjax [name="localizacao"]').val(),
            contactos: contactosArray,
            email: $('#formNovoCentroAjax [name="email"]').val() || null
        };
        $.ajax({
            url: '/centros',
            method: 'POST', contentType: 'application/json', data: JSON.stringify(dados),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                const novo = response.dados || response;
                allData.unshift(novo);
                aplicarFiltrosLocais();
                bootstrap.Modal.getInstance(document.getElementById('modalNovoCentro')).hide();
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Centro criado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
            },
            error: function(xhr) {
                let mensagem = 'Erro ao criar centro';
                if (xhr.responseJSON?.errors) mensagem = Object.values(xhr.responseJSON.errors).flat().join(', ');
                else if (xhr.responseJSON?.mensagem) mensagem = xhr.responseJSON.mensagem;
                else if (xhr.responseJSON?.message) mensagem = xhr.responseJSON.message;
                Swal.fire({ icon: 'error', title: 'Erro!', text: mensagem, confirmButtonColor: '#1d4ed8' });
            }
        });
    }

    /* ── ATUALIZAR ── */
    function atualizarCentro() {
        const centroId = $('#editCentroId').val();
        const contactosInput = $('#editContactos').val().trim();
        const contactosArray = contactosInput.split(',').map(function(c) { return c.trim(); }).filter(function(c) { return c.length > 0; });
        if (contactosArray.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'Adicione pelo menos um contacto', confirmButtonColor: '#1d4ed8' });
            return;
        }
        const dados = {
            nome: $('#editNome').val(),
            localizacao: $('#editLocalizacao').val(),
            contactos: contactosArray,
            email: $('#editEmail').val() || null
        };
        $.ajax({
            url: '/centros/' + centroId,
            method: 'PUT', contentType: 'application/json', data: JSON.stringify(dados),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                const atualizado = response.dados || response;
                const idx = allData.findIndex(function(c) { return c.id == centroId; });
                if (idx !== -1) allData[idx] = atualizado;
                aplicarFiltrosLocais();
                bootstrap.Modal.getInstance(document.getElementById('modalEditarCentro')).hide();
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Centro atualizado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
            },
            error: function(xhr) {
                let mensagem = 'Erro ao atualizar centro';
                if (xhr.responseJSON?.errors) mensagem = Object.values(xhr.responseJSON.errors).flat().join(', ');
                else if (xhr.responseJSON?.mensagem) mensagem = xhr.responseJSON.mensagem;
                else if (xhr.responseJSON?.message) mensagem = xhr.responseJSON.message;
                Swal.fire({ icon: 'error', title: 'Erro!', text: mensagem, confirmButtonColor: '#1d4ed8' });
            }
        });
    }

    /* ── ELIMINAR ── */
    window.eliminarCentro = function(centroId) {
        Swal.fire({
            title: 'Eliminar centro?',
            text: 'Esta ação é irreversível!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-trash me-1"></i> Sim, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then(function(result) {
            if (!result.isConfirmed) return;
            $.ajax({
                url: '/centros/' + centroId,
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function() {
                    allData = allData.filter(function(c) { return c.id != centroId; });
                    aplicarFiltrosLocais();
                    Swal.fire({ icon: 'success', title: 'Eliminado!', text: 'Centro eliminado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
                },
                error: function(xhr) {
                    let mensagem = 'Erro ao eliminar centro';
                    if (xhr.responseJSON?.mensagem) mensagem = xhr.responseJSON.mensagem;
                    else if (xhr.responseJSON?.message) mensagem = xhr.responseJSON.message;
                    else if (xhr.status === 409) mensagem = 'Este centro não pode ser eliminado (existem cursos associados)';
                    Swal.fire({ icon: 'error', title: 'Erro!', text: mensagem, confirmButtonColor: '#1d4ed8' });
                }
            });
        });
    };

}());
</script>
@endsection
