@extends('layouts.app')

@section('title', 'Turmas')

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

    /* ── PAGE LAYOUT ── */
    .pi-page { width: 100%; padding: 0; }

    /* ── BLUE HEADER ── */
    .pi-page-header {
        background: var(--pi-primary-gradient);
        color: #fff;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    .pi-page-header h1 { font-size: 1.25rem; font-weight: 700; margin: 0; letter-spacing: -0.02em; color: #fff; }
    .pi-page-header p { font-size: 0.75rem; color: rgba(255,255,255,0.75); margin: 0; }
    .pi-page-header .pi-btn-create {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.5rem 1rem; border-radius: var(--pi-radius);
        background: #fff; color: var(--pi-primary); font-weight: 600;
        font-size: 0.8125rem; border: none; cursor: pointer;
        transition: all 0.15s;
    }
    .pi-page-header .pi-btn-create:hover { background: #dbeafe; }

    /* ── STATS BAR ── */
    .pi-stats-bar {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 0;
        background: #fff; border-bottom: 1px solid var(--pi-border);
    }
    .pi-stat {
        padding: 0.75rem 1.25rem;
        border-right: 1px solid var(--pi-border);
        display: flex; align-items: center; gap: 0.75rem;
    }
    .pi-stat:last-child { border-right: none; }
    .pi-stat-icon {
        width: 2.25rem; height: 2.25rem; border-radius: 0.5rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.875rem; flex-shrink: 0;
    }
    .pi-stat-icon.blue { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-stat-icon.green { background: var(--pi-success-light); color: var(--pi-success); }
    .pi-stat-icon.gray { background: rgba(100,116,139,0.08); color: var(--pi-muted); }
    .pi-stat-icon.cyan { background: var(--pi-info-light); color: var(--pi-info); }
    .pi-stat-label { font-size: 0.6875rem; font-weight: 500; color: var(--pi-text-muted); text-transform: uppercase; letter-spacing: 0.04em; }
    .pi-stat-value { font-size: 1.375rem; font-weight: 700; line-height: 1; }

    /* ── TOOLBAR (filters + search) ── */
    .pi-toolbar {
        background: #fff; border-bottom: 1px solid var(--pi-border);
        padding: 0.625rem 1.25rem;
        display: flex; flex-wrap: nowrap; align-items: center; gap: 0.5rem; overflow-x: auto;
    }
    .pi-toolbar .search-wrap { position: relative; flex: 0 1 250px; min-width: 250px; }
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
    .pi-toolbar select:focus {
        outline: none; border-color: var(--pi-primary); box-shadow: 0 0 0 2px var(--pi-primary-light);
    }
    .pi-btn-clear {
        border: none; background: transparent; color: var(--pi-text-muted);
        font-size: 0.8125rem; padding: 0.375rem 0.5rem; border-radius: var(--pi-radius);
        display: inline-flex; align-items: center; gap: 0.25rem; cursor: pointer;
        white-space: nowrap;
    }
    .pi-btn-clear:hover { background: var(--pi-danger-light); color: var(--pi-danger); }

    /* ── TABLE ── */
    .pi-table-wrap { background: #fff; overflow: auto; }
    .pi-table { width: 100%; margin: 0; border-collapse: collapse; font-size: 0.8125rem; }
    .pi-table thead th {
        background: var(--pi-primary);
        color: #fff;
        font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;
        padding: 0.625rem 1rem; white-space: nowrap;
        position: sticky; top: 0; z-index: 5;
        border-bottom: none;
    }
    .pi-table tbody td {
        padding: 0.5rem 1rem; vertical-align: middle;
        border-bottom: 1px solid #f0f4ff;
    }
    .pi-table tbody tr { transition: background 0.1s; }
    .pi-table tbody tr:hover { background: var(--pi-primary-light); }
    .pi-table tbody tr:last-child td { border-bottom: none; }
    .pi-table .mono { font-family: 'SF Mono','Fira Code',monospace; font-size: 0.6875rem; color: var(--pi-muted); }

    /* ── PAGINATION BAR ── */
    .pi-pagination-bar {
        background: var(--pi-primary);
        color: #fff;
        padding: 0.5rem 1.25rem;
        display: flex; align-items: center; justify-content: space-between;
        font-size: 0.75rem;
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

    /* ── BADGES ── */
    .pi-badge {
        display: inline-flex; align-items: center; gap: 0.25rem;
        padding: 0.15rem 0.5rem; border-radius: 9999px;
        font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.01em;
    }
    .pi-badge-planeada { background: rgba(100,116,139,0.08); color: #475569; }
    .pi-badge-inscricoes { background: var(--pi-success-light); color: #15803d; }
    .pi-badge-andamento { background: var(--pi-info-light); color: #0369a1; }
    .pi-badge-concluida { background: rgba(30,41,59,0.08); color: #1e293b; }
    .pi-badge-periodo { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-badge-dia { background: var(--pi-info-light); color: #0369a1; font-size: 0.6875rem; }
    .pi-badge-pub-sim { background: var(--pi-success-light); color: #15803d; }
    .pi-badge-pub-nao { background: rgba(100,116,139,0.08); color: #475569; }

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
    .pi-action-btn.edit { background: transparent; color: var(--pi-primary); border: 1px solid var(--pi-primary); }
    .pi-action-btn.edit:hover { background: var(--pi-primary); color: #fff; }
    .pi-action-btn.delete { background: transparent; color: var(--pi-danger); border: 1px solid var(--pi-danger); }
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
    .pi-mobile-card .card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.375rem; }
    .pi-mobile-card .card-name { font-weight: 600; font-size: 0.875rem; color: var(--pi-text); }
    .pi-mobile-card .card-meta { font-size: 0.6875rem; color: var(--pi-text-muted); margin-bottom: 0.375rem; }
    .pi-mobile-card .card-details { display: flex; flex-wrap: wrap; gap: 0.375rem; margin-bottom: 0.5rem; font-size: 0.75rem; color: var(--pi-text-muted); }
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

    /* ── VIEW MODAL DETAIL ROWS ── */
    .pi-detail-row { display: flex; align-items: flex-start; gap: 0.625rem; padding: 0.5rem 0; border-bottom: 1px solid #f0f4ff; }
    .pi-detail-row:last-child { border-bottom: none; }
    .pi-detail-icon { width: 1.75rem; height: 1.75rem; border-radius: 0.375rem; background: var(--pi-primary-light); display: flex; align-items: center; justify-content: center; color: var(--pi-primary); font-size: 0.75rem; flex-shrink: 0; }
    .pi-detail-label { font-size: 0.6875rem; font-weight: 500; color: var(--pi-text-muted); text-transform: uppercase; letter-spacing: 0.03em; }
    .pi-detail-value { font-size: 0.8125rem; font-weight: 500; margin-top: 0.0625rem; }

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

    /* ── DAYS GRID ── */
    .pi-days-grid { display: flex; flex-wrap: wrap; gap: 0.375rem; }
    .pi-day-check { display: flex; align-items: center; gap: 0.25rem; font-size: 0.75rem; font-weight: 500; }
    .pi-day-check input[type="checkbox"] { width: 0.875rem; height: 0.875rem; accent-color: var(--pi-primary); }

    /* ── LOADING SPINNER ── */
    .pi-spinner { display: inline-block; width: 0.875rem; height: 0.875rem; border: 2px solid #fff; border-right-color: transparent; border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 0.25rem; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ── BUTTON PRIMARY ── */
    .pi-btn-primary { background: var(--pi-primary); border: none; color: #fff; border-radius: var(--pi-radius); padding: 0.4375rem 0.875rem; font-size: 0.8125rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.375rem; transition: all 0.15s; cursor: pointer; }
    .pi-btn-primary:hover { background: var(--pi-primary-dark); color: #fff; }

    /* ── SELECT2 ── */
    .select2-container--bootstrap-5 .select2-selection { border-radius: var(--pi-radius) !important; border-color: var(--pi-border) !important; height: 2.25rem !important; font-size: 0.8125rem !important; }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered { line-height: 2.25rem !important; }

    /* ── RESPONSIVE ── */
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

    {{-- ============================================= --}}
    {{-- BLUE HEADER                                   --}}
    {{-- ============================================= --}}
    <div class="pi-page-header">
        <div>
            <div style="display:flex;align-items:center;gap:0.625rem">
                <i class="fas fa-chalkboard-teacher fa-lg" style="opacity:0.9"></i>
                <div>
                    <h1>Gestão de Turmas</h1>
                    <p>{{ $turmas->count() }} turma(s) registada(s) no sistema</p>
                </div>
            </div>
        </div>
        <button class="pi-btn-create" data-bs-toggle="modal" data-bs-target="#modalNovasTurma">
            <i class="fas fa-plus"></i> Nova Turma
        </button>
    </div>

    {{-- ============================================= --}}
    {{-- STATS BAR                                     --}}
    {{-- ============================================= --}}
    <div class="pi-stats-bar">
        <div class="pi-stat">
            <div class="pi-stat-icon blue"><i class="fas fa-chalkboard"></i></div>
            <div>
                <div class="pi-stat-label">Total</div>
                <div class="pi-stat-value" style="color:var(--pi-primary)">{{ $turmas->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon green"><i class="fas fa-door-open"></i></div>
            <div>
                <div class="pi-stat-label">Inscrições Abertas</div>
                <div class="pi-stat-value" style="color:var(--pi-success)">{{ $turmas->where('status', 'inscricoes_abertas')->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon cyan"><i class="fas fa-play-circle"></i></div>
            <div>
                <div class="pi-stat-label">Em Andamento</div>
                <div class="pi-stat-value" style="color:var(--pi-info)">{{ $turmas->where('status', 'em_andamento')->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon gray"><i class="fas fa-check-double"></i></div>
            <div>
                <div class="pi-stat-label">Concluídas</div>
                <div class="pi-stat-value" style="color:var(--pi-muted)">{{ $turmas->where('status', 'concluida')->count() }}</div>
            </div>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- TOOLBAR (filters side by side)                --}}
    {{-- ============================================= --}}
    <div class="pi-toolbar">
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="filtroSearch" placeholder="Pesquisar por curso ou formador...">
        </div>
        <select class="form-select" id="filtroCurso" style="border-color:var(--pi-border);min-width:160px">
            <option value="">Todos os cursos</option>
        </select>
        <select class="form-select" id="filtroStatus" style="border-color:var(--pi-border)">
            <option value="">Todos os status</option>
            <option value="planeada">Planeada</option>
            <option value="inscricoes_abertas">Inscrições Abertas</option>
            <option value="em_andamento">Em Andamento</option>
            <option value="concluida">Concluída</option>
        </select>
        <select class="form-select" id="filtroPeriodo" style="border-color:var(--pi-border)">
            <option value="">Todos os períodos</option>
            <option value="manha">Manhã</option>
            <option value="tarde">Tarde</option>
            <option value="noite">Noite</option>
        </select>
        <button class="pi-btn-clear" id="btnLimparFiltros" onclick="limparFiltros()">
            <i class="fas fa-times-circle"></i> Limpar
        </button>
    </div>

    {{-- ============================================= --}}
    {{-- TABLE                                         --}}
    {{-- ============================================= --}}
    <div class="pi-table-wrap">
        {{-- Desktop Table --}}
        <div class="pi-desktop-table">
            <table class="pi-table">
                <thead>
                    <tr>
                        <th style="width:50px">ID</th>
                        <th>Curso</th>
                        <th>Centro</th>
                        <th>Formador</th>
                        <th>Dias</th>
                        <th>Status</th>
                        <th>Período</th>
                        <th>Modalidade</th>
                        <th>Horário</th>
                        <th>Vagas</th>
                        <th>Público</th>
                        <th style="text-align:right;width:100px">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaBody">
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="pi-mobile-cards" id="mobileCards">
        </div>

        {{-- Empty State --}}
        <div class="pi-empty d-none" id="emptyState">
            <div class="pi-empty-icon"><i class="fas fa-inbox"></i></div>
            <h3>Nenhuma turma encontrada</h3>
            <p>Tente ajustar os filtros ou criar uma nova turma</p>
        </div>
    </div>

    {{-- PAGINATION BAR --}}
    <div class="pi-pagination-bar">
        <span class="info">Mostrando {{ $turmas->count() }} turma(s)</span>
        <div class="pages">
            <button class="page-btn active">1</button>
        </div>
    </div>
</div>

{{-- MODAL: Visualizar Turma --}}
<div class="modal fade pi-modal" id="modalVisualizarTurma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon green"><i class="fas fa-eye"></i></div>
                    <div>
                        <h5 class="modal-title">Detalhes da Turma</h5>
                        <p class="modal-subtitle">Informações completas</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="conteudoVisualizarTurma">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2" style="font-size:0.8125rem">Carregando...</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Criar Nova Turma --}}
<div class="modal fade pi-modal" id="modalNovasTurma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue"><i class="fas fa-plus-circle"></i></div>
                    <div>
                        <h5 class="modal-title">Criar Nova Turma</h5>
                        <p class="modal-subtitle">Preencha os dados da turma</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNovaTurmaAjax" class="pi-form">
                    @csrf
                    <div class="row">
                        {{-- COLUNA ESQUERDA --}}
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-info-circle"></i> Informações da Turma</div>

                            <div class="mb-2">
                                <label class="form-label">Curso <span class="required">*</span></label>
                                <select class="form-select" name="curso_id" required>
                                    <option value="">Selecione o curso</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Centro <span class="required">*</span></label>
                                <select class="form-select" name="centro_id" disabled>
                                    <option value="">Selecione um curso primeiro</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Formador</label>
                                <select class="form-select" name="formador_id">
                                    <option value="">Selecione (opcional)</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Período <span class="required">*</span></label>
                                <select class="form-select" name="periodo" id="periodoNovo" required>
                                    <option value="">Selecione ou detecte pela hora</option>
                                    <option value="manha">Manhã</option>
                                    <option value="tarde">Tarde</option>
                                    <option value="noite">Noite</option>
                                </select>
                                <div class="form-text">Detecta automaticamente baseado na hora de início</div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Modalidade <span class="required">*</span></label>
                                <select class="form-select" name="modalidade" required>
                                    <option value="">Selecione a modalidade</option>
                                    <option value="presencial">Presencial</option>
                                    <option value="online">Online</option>
                                    <option value="hibrido">Híbrido</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="planeada">Planeada</option>
                                    <option value="inscricoes_abertas">Inscrições Abertas</option>
                                    <option value="em_andamento">Em Andamento</option>
                                    <option value="concluida">Concluída</option>
                                </select>
                                <div class="form-text">Para "Inscrições Abertas" obrigatório ter formador</div>
                            </div>
                        </div>

                        {{-- COLUNA DIREITA --}}
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-clock"></i> Horário</div>

                            <div class="mb-2">
                                <label class="form-label">Hora Início <span class="required">*</span></label>
                                <input type="time" class="form-control" name="hora_inicio" id="horaInicioNovo" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Hora Fim</label>
                                <input type="time" class="form-control" name="hora_fim">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Duração (Semanas)</label>
                                <input type="number" class="form-control" name="duracao_semanas" min="1">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Vagas Disponíveis</label>
                                <input type="number" class="form-control" name="vagas_totais" min="1">
                            </div>

                            <div class="mb-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="publicado" id="publicadoNovo">
                                    <label class="form-check-label" for="publicadoNovo" style="font-size:0.8125rem">Publicar no site</label>
                                </div>
                                <div class="form-text">Marque para mostrar esta turma no site público</div>
                            </div>
                        </div>
                    </div>

                    {{-- DIAS DA SEMANA --}}
                    <div class="mb-2">
                        <div class="section-title"><i class="fas fa-calendar-week"></i> Dias da Semana</div>
                        <div class="pi-days-grid">
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana" value="Segunda"> Segunda</div>
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana" value="Terça"> Terça</div>
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana" value="Quarta"> Quarta</div>
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana" value="Quinta"> Quinta</div>
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana" value="Sexta"> Sexta</div>
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana" value="Sábado"> Sábado</div>
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana" value="Domingo"> Domingo</div>
                        </div>
                        <div class="text-danger mt-1" id="diasError" style="display:none;font-size:0.75rem">Selecione pelo menos um dia</div>
                    </div>

                    {{-- DATA ARRANQUE --}}
                    <div class="mb-0">
                        <label class="form-label">Data de Arranque <span class="required">*</span></label>
                        <input type="date" class="form-control" name="data_arranque" id="dataArranqueNovo" required>
                        <div class="form-text">Selecione apenas datas futuras</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn pi-btn-primary" id="btnCriarTurma" onclick="$('#formNovaTurmaAjax').submit()">
                    <i class="fas fa-check"></i> Criar Turma
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Editar Turma --}}
<div class="modal fade pi-modal" id="modalEditarTurma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue"><i class="fas fa-edit"></i></div>
                    <div>
                        <h5 class="modal-title">Editar Turma</h5>
                        <p class="modal-subtitle">Atualize os dados da turma</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarTurmaAjax" class="pi-form">
                    @csrf
                    <input type="hidden" id="editTurmaId">
                    <div class="row">
                        {{-- COLUNA ESQUERDA --}}
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-info-circle"></i> Informações da Turma</div>

                            <div class="mb-2">
                                <label class="form-label">Curso <span class="required">*</span></label>
                                <select class="form-select" id="editCursoId" name="curso_id" required>
                                    <option value="">Selecione o curso</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Formador</label>
                                <select class="form-select" id="editFormadorId" name="formador_id">
                                    <option value="">Selecione (opcional)</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Período <span class="required">*</span></label>
                                <select class="form-select" id="editPeriodo" name="periodo" required>
                                    <option value="">Selecione ou detecte pela hora</option>
                                    <option value="manha">Manhã</option>
                                    <option value="tarde">Tarde</option>
                                    <option value="noite">Noite</option>
                                </select>
                                <div class="form-text">Detecta automaticamente baseado na hora de início</div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Modalidade <span class="required">*</span></label>
                                <select class="form-select" id="editModalidade" name="modalidade" required>
                                    <option value="">Selecione</option>
                                    <option value="presencial">Presencial</option>
                                    <option value="online">Online</option>
                                    <option value="hibrido">Híbrido</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="editStatus" name="status">
                                    <option value="planeada">Planeada</option>
                                    <option value="inscricoes_abertas">Inscrições Abertas</option>
                                    <option value="em_andamento">Em Andamento</option>
                                    <option value="concluida">Concluída</option>
                                </select>
                            </div>
                        </div>

                        {{-- COLUNA DIREITA --}}
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-clock"></i> Horário</div>

                            <div class="mb-2">
                                <label class="form-label">Hora Início <span class="required">*</span></label>
                                <input type="time" class="form-control" id="editHoraInicio" name="hora_inicio" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Hora Fim</label>
                                <input type="time" class="form-control" id="editHoraFim" name="hora_fim">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Duração (Semanas)</label>
                                <input type="number" class="form-control" id="editDuracaoSemanas" name="duracao_semanas" min="1">
                            </div>
                        </div>
                    </div>

                    {{-- DIAS DA SEMANA --}}
                    <div class="mb-2">
                        <div class="section-title"><i class="fas fa-calendar-week"></i> Dias da Semana</div>
                        <div class="pi-days-grid">
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana-edit" value="Segunda"> Segunda</div>
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana-edit" value="Terça"> Terça</div>
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana-edit" value="Quarta"> Quarta</div>
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana-edit" value="Quinta"> Quinta</div>
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana-edit" value="Sexta"> Sexta</div>
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana-edit" value="Sábado"> Sábado</div>
                            <div class="pi-day-check"><input type="checkbox" class="dia-semana-edit" value="Domingo"> Domingo</div>
                        </div>
                    </div>

                    {{-- DATA ARRANQUE --}}
                    <div class="mb-2">
                        <label class="form-label">Data de Arranque <span class="required">*</span></label>
                        <input type="date" class="form-control" id="editDataArranque" name="data_arranque" required>
                        <div class="form-text">Selecione apenas datas futuras</div>
                    </div>

                    {{-- VAGAS E PUBLICAÇÃO --}}
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Vagas Disponíveis</label>
                            <input type="number" class="form-control" id="editVagasTotais" name="vagas_totais" min="1">
                        </div>
                        <div class="col-md-6 mb-2 d-flex align-items-end">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="editPublicado" name="publicado">
                                <label class="form-check-label" for="editPublicado" style="font-size:0.8125rem">Publicar no site</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn pi-btn-primary" onclick="$('#formEditarTurmaAjax').submit()">
                    <i class="fas fa-save"></i> Atualizar Turma
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
// Variáveis globais para filtros
var allData = [];
var filteredData = [];

$(document).ready(function() {
    console.log('JavaScript das turmas carregado');
    carregarDadosFiltros();
    carregarDadosTurmas();
    bindEventosFiltros();
    carregarFormadores();
    configurarEventosModal();
    configurarValidacoes();
    configurarAutoPreenchimento();
});

// Carregar dados de filtros (cursos)
function carregarDadosFiltros() {
    $.get('/cursos', function(data) {
        let opts = '<option value="">Todos os cursos</option>';
        (data || []).forEach(function(c) { if (c.ativo) opts += '<option value="' + c.id + '">' + c.nome + '</option>'; });
        $('#filtroCurso').html(opts);
    });
}

// Carregar dados das turmas
function carregarDadosTurmas() {
    $.ajax({
        url: '/turmas',
        method: 'GET',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        success: function(response) {
            // A rota web retorna a view, precisa dos dados JSON
            allData = Array.isArray(response) ? response : (response.data || []);
            if (!Array.isArray(allData)) {
                allData = [];
            }
            console.log('Turmas carregadas:', allData.length);
            aplicarFiltrosLocais();
        },
        error: function(xhr) {
            console.error('Erro ao carregar turmas:', xhr);
            allData = [];
            aplicarFiltrosLocais();
        }
    });
}

// Ligar eventos dos filtros
function bindEventosFiltros() {
    let searchTimer;
    $('#filtroSearch').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(aplicarFiltrosLocais, 250);
    });
    $('#filtroCurso, #filtroStatus, #filtroPeriodo').on('change', aplicarFiltrosLocais);
}

// Aplicar filtros
function aplicarFiltrosLocais() {
    const search = ($('#filtroSearch').val() || '').toLowerCase();
    const curso = $('#filtroCurso').val();
    const status = $('#filtroStatus').val();
    const periodo = $('#filtroPeriodo').val();
    
    filteredData = allData.filter(function(item) {
        if (search) {
            const nomeCurso = (item.curso && item.curso.nome || '').toLowerCase();
            const nomeFormador = (item.formador && item.formador.nome || '').toLowerCase();
            const nomeCentro = (item.centro && item.centro.nome || '').toLowerCase();
            if (!nomeCurso.includes(search) && !nomeFormador.includes(search) && !nomeCentro.includes(search)) return false;
        }
        if (curso && (!item.curso || item.curso.id != curso)) return false;
        if (status && item.status !== status) return false;
        if (periodo && item.periodo !== periodo) return false;
        return true;
    });
    
    let count = 0;
    if (search) count++;
    if (curso) count++;
    if (status) count++;
    if (periodo) count++;
    $('#btnLimparFiltros').prop('disabled', count === 0);
    
    renderTabela();
}

// Renderizar tabela com dados filtrados
function renderTabela() {
    const tbody = $('#tabelaBody');
    tbody.empty();
    
    if (filteredData.length === 0) {
        $('#emptyState').removeClass('d-none');
        $('.pi-desktop-table').hide();
        return;
    }
    
    $('.pi-desktop-table').show();
    $('#emptyState').addClass('d-none');
    
    filteredData.forEach(function(turma) {
        const statusClass = {
            'planeada': 'pi-badge-planeada',
            'inscricoes_abertas': 'pi-badge-inscricoes',
            'em_andamento': 'pi-badge-andamento',
            'concluida': 'pi-badge-concluida'
        };
        const statusLabels = {
            'planeada': 'Planeada',
            'inscricoes_abertas': 'Inscrições',
            'em_andamento': 'Em Andamento',
            'concluida': 'Concluída'
        };
        const icones = {
            'manha': 'fas fa-sun',
            'tarde': 'fas fa-cloud-sun',
            'noite': 'fas fa-moon'
        };
        
        let diasHtml = '—';
        if (turma.dia_semana && Array.isArray(turma.dia_semana)) {
            diasHtml = turma.dia_semana.map(d => '<span class="pi-badge pi-badge-dia">' + d.substring(0, 3) + '</span>').join('');
        }
        
        let formadorHtml = '—';
        if (turma.formador && turma.formador.nome) {
            formadorHtml = '<span style="color:var(--pi-success);font-weight:500"><i class="fas fa-user-tie me-1" style="font-size:0.625rem"></i>' + turma.formador.nome + '</span>';
        } else {
            formadorHtml = '<span class="pi-badge" style="background:var(--pi-warning-light);color:#92400e"><i class="fas fa-exclamation-triangle"></i> Sem</span>';
        }
        
        const icone = icones[turma.periodo] || 'fas fa-clock';
        
        const modalidades = {
            'presencial': { label: 'Presencial', badge: 'presencial' },
            'online': { label: 'Online', badge: 'online' },
            'hibrido': { label: 'Híbrido', badge: 'hibrido' }
        };
        const modalidadeInfo = modalidades[turma.modalidade] || { label: 'N/A', badge: 'N/A' };
        let modalidadeHtml = '<span class="pi-badge pi-badge-' + modalidadeInfo.badge + '" style="background:var(--pi-info-light);color:#0369a1">' + modalidadeInfo.label + '</span>';
        
        let vagasHtml = '-/-';
        if (turma.vagas_totais) {
            vagasHtml = (turma.vagas_preenchidas || 0) + '/' + turma.vagas_totais;
        }
        
        let publicado = turma.publicado ? '<span class="pi-badge pi-badge-pub-sim"><i class="fas fa-eye"></i> Sim</span>' : '<span class="pi-badge pi-badge-pub-nao"><i class="fas fa-eye-slash"></i> Não</span>';
        
        let row = '<tr>';
        row += '<td class="mono">#' + turma.id + '</td>';
        row += '<td><strong style="font-size:0.8125rem">' + (turma.curso && turma.curso.nome || 'N/A') + '</strong></td>';
        row += '<td style="font-size:0.75rem">' + (turma.centro && turma.centro.nome || '—') + '</td>';
        row += '<td style="font-size:0.75rem">' + formadorHtml + '</td>';
        row += '<td>' + diasHtml + '</td>';
        row += '<td><span class="pi-badge ' + (statusClass[turma.status] || 'pi-badge-planeada') + '">' + (statusLabels[turma.status] || turma.status) + '</span></td>';
        row += '<td><span class="pi-badge pi-badge-periodo"><i class="fas ' + icone + '"></i> ' + (turma.periodo ? turma.periodo.charAt(0).toUpperCase() + turma.periodo.slice(1) : 'N/A') + '</span></td>';
        row += '<td>' + modalidadeHtml + '</td>';
        row += '<td style="font-size:0.75rem;white-space:nowrap">' + (turma.hora_inicio && turma.hora_fim ? turma.hora_inicio + ' - ' + turma.hora_fim : '—') + '</td>';
        row += '<td style="font-size:0.75rem;text-align:center">' + vagasHtml + '</td>';
        row += '<td>' + publicado + '</td>';
        row += '<td><div class="pi-actions"><button class="pi-action-btn view" onclick="visualizarTurma(' + turma.id + ')" title="Ver detalhes"><i class="fas fa-eye"></i></button><button class="pi-action-btn edit" onclick="window.location.href=\'/turmas/' + turma.id + '\'" title="Gerir"><i class="fas fa-cogs"></i></button><button class="pi-action-btn delete" onclick="eliminarTurma(' + turma.id + ')" title="Eliminar"><i class="fas fa-trash"></i></button></div></td>';
        row += '</tr>';
        
        tbody.append(row);
    });
}

/**
 * Carregar lista de cursos disponíveis
 */
function carregarCursos() {
    console.log('Iniciando carregamento de cursos...');
    
    const $selectCurso = $('select[name="curso_id"]');
    console.log('Select curso encontrado:', $selectCurso.length);
    
    if ($selectCurso.length === 0) {
        console.error('Select de curso não encontrado!');
        return;
    }
    
    fetch('/cursos', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            console.log('Resposta HTTP:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
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

    if (!cursoId) {
        $select.html('<option value="">Selecione um curso primeiro</option>').prop('disabled', true);
        return;
    }

    $select.html('<option value="">Carregando centros...</option>').prop('disabled', true);

    $.ajax({
        url: `/cursos/${cursoId}`,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function(response) {
            console.log('Resposta completa da API:', response);

            let options = '<option value="">Selecione um centro</option>';
            if (response.centros && response.centros.length > 0) {
                response.centros.forEach(function(centro) {
                    const preco = centro.pivot && centro.pivot.preco ? parseFloat(centro.pivot.preco).toLocaleString('pt-PT', {minimumFractionDigits:2, maximumFractionDigits:2}) + ' Kz' : '';
                    options += `<option value="${centro.id}" data-preco="${centro.pivot ? centro.pivot.preco : ''}">${centro.nome}${preco ? ' ('+preco+')' : ''}</option>`;
                });
                $select.html(options);
                setTimeout(function() {
                    $select.prop('disabled', false).removeAttr('disabled');
                }, 100);
            } else if (response.dados && response.dados.centros && response.dados.centros.length > 0) {
                response.dados.centros.forEach(function(centro) {
                    const preco = centro.pivot && centro.pivot.preco ? parseFloat(centro.pivot.preco).toLocaleString('pt-PT', {minimumFractionDigits:2, maximumFractionDigits:2}) + ' Kz' : '';
                    options += `<option value="${centro.id}" data-preco="${centro.pivot ? centro.pivot.preco : ''}">${centro.nome}${preco ? ' ('+preco+')' : ''}</option>`;
                });
                $select.html(options);
                setTimeout(function() {
                    $select.prop('disabled', false).removeAttr('disabled');
                }, 100);
            } else {
                options = '<option value="">Nenhum centro disponível para este curso</option>';
                $select.html(options).prop('disabled', true);
            }
        },
        error: function(xhr) {
            console.error('Erro ao carregar centros:', xhr);
            $select.html('<option value="">Erro ao carregar centros</option>').prop('disabled', true);
            Swal.fire({ icon: 'error', title: 'Erro!', text: 'Não foi possível carregar os centros para este curso.', confirmButtonColor: '#1d4ed8' });
        }
    });
}

/**
 * Carregar lista de formadores disponíveis
 */
function carregarFormadores() {
    $.ajax({
        url: '/formadores',
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function(response) {
            const data = Array.isArray(response) ? response : (response.data || response.formadores || []);
            let options = '<option value="">Selecione (opcional)</option>';
            data.forEach(function(formador) {
                options += `<option value="${formador.id}">${formador.nome}</option>`;
            });
            $('select[name="formador_id"]').html(options);
            $('#editFormadorId').html(options);
        },
        error: function(xhr) {
            console.error('Erro ao carregar formadores:', xhr);
        }
    });
}

/**
 * Configurar eventos do modal
 */
function configurarEventosModal() {
    $('#modalNovasTurma').on('show.bs.modal', function() {
        carregarCursos();
        $('#formNovaTurmaAjax')[0].reset();
        $('#diasError').hide();
        $('#modalNovasTurma select[name="centro_id"]').html('<option value="">Selecione um curso primeiro</option>').prop('disabled', true);
    });

    $(document).on('change', '#modalNovasTurma select[name="curso_id"]', function() {
        const cursoId = $(this).val();
        carregarCentrosPorCurso(cursoId);
    });

    $('#formNovaTurmaAjax').on('submit', function(e) {
        e.preventDefault();
        criarTurma();
    });

    $('#formEditarTurmaAjax').on('submit', function(e) {
        e.preventDefault();
        atualizarTurma();
    });
}

/**
 * Configurar validações
 */
function configurarValidacoes() {
    $(document).on('change', 'select[name="status"]', function() {
        const status = $(this).val();
        const formadorSelect = $(this).closest('form').find('select[name="formador_id"]');
        if (status === 'inscricoes_abertas' && !formadorSelect.val()) {
            formadorSelect.addClass('is-invalid');
        } else {
            formadorSelect.removeClass('is-invalid');
        }
    });
}

/**
 * Configurar auto preenchimento de período
 */
function configurarAutoPreenchimento() {
    $(document).on('change', '#horaInicioNovo', function() {
        const hora = parseInt($(this).val().split(':')[0]);
        let periodo = '';
        if (hora >= 6 && hora < 12) periodo = 'manha';
        else if (hora >= 12 && hora < 18) periodo = 'tarde';
        else periodo = 'noite';
        $('#periodoNovo').val(periodo);
    });

    $(document).on('change', '#editHoraInicio', function() {
        const hora = parseInt($(this).val().split(':')[0]);
        let periodo = '';
        if (hora >= 6 && hora < 12) periodo = 'manha';
        else if (hora >= 12 && hora < 18) periodo = 'tarde';
        else periodo = 'noite';
        $('#editPeriodo').val(periodo);
    });
}

/**
 * Carregar turmas (reload)
 */
function carregarTurmas() {
    $.ajax({
        url: '/turmas?per_page=1000',
        method: 'GET',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        success: function(response) {
            allData = response.data || response;
            if (!Array.isArray(allData)) {
                allData = [];
            }
            aplicarFiltrosLocais();
        },
        error: function() {
            console.error('Erro ao recarregar turmas');
        }
    });
}

/**
 * Visualizar detalhes da turma
 */
window.visualizarTurma = function(id) {
    $.ajax({
        url: `/turmas/${id}`,
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            const turma = response.dados || response.data || response;
            
            const cursoNome = turma.curso?.nome || 'N/A';
            const centroNome = turma.centro?.nome || '—';
            const formadorNome = turma.formador?.nome || '<span style="color:var(--pi-warning)"><i class="fas fa-exclamation-triangle"></i> Não atribuído</span>';
            
            let diaSemana = '—';
            if (turma.dia_semana && Array.isArray(turma.dia_semana)) {
                diaSemana = turma.dia_semana.map(d => '<span class="pi-badge pi-badge-dia" style="margin-right:2px">' + d.substring(0,3) + '</span>').join(' ');
            }
            
            const horaInicio = turma.hora_inicio || '—';
            const horaFim = turma.hora_fim || '—';
            const duracao = turma.duracao_semanas || 'N/A';
            const dataArranque = turma.data_arranque ? new Date(turma.data_arranque).toLocaleDateString('pt-PT') : '—';
            
            let conteudo = '';
            conteudo += detailRow('fa-graduation-cap', 'Curso', cursoNome);
            conteudo += detailRow('fa-building', 'Centro', centroNome);
            conteudo += detailRow('fa-user-tie', 'Formador', formadorNome);
            conteudo += detailRow('fa-calendar-week', 'Dias', diaSemana);
            conteudo += detailRow('fa-sun', 'Período', getPeriodoBadge(turma.periodo));
            conteudo += detailRow('fa-chalkboard', 'Modalidade', getModalidadeBadge(turma.modalidade));
            conteudo += detailRow('fa-info-circle', 'Status', getStatusBadge(turma.status));
            conteudo += detailRow('fa-clock', 'Horário', horaInicio + ' - ' + horaFim);
            conteudo += detailRow('fa-hourglass-half', 'Duração', duracao + ' semana(s)');
            conteudo += detailRow('fa-calendar-alt', 'Data de Arranque', dataArranque);
            
            // Vagas
            const vagasPreenchidas = turma.vagas_preenchidas || 0;
            const vagasTotais = turma.vagas_totais || 0;
            const vagasDisponiveis = vagasTotais - vagasPreenchidas;
            const vagasStatus = vagasTotais > 0 ? vagasPreenchidas + '/' + vagasTotais : 'Ilimitado';
            const percentualPreenchimento = vagasTotais > 0 ? Math.round((vagasPreenchidas / vagasTotais) * 100) : 0;
            
            let preenchimentoFormatado = '';
            if (vagasTotais > 0) {
                preenchimentoFormatado = `
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span>${vagasStatus}</span>
                        <div style="flex: 1; background: #e9ecef; height: 6px; border-radius: 3px; overflow: hidden;">
                            <div style="background: ${percentualPreenchimento >= 80 ? '#dc2626' : percentualPreenchimento >= 50 ? '#d97706' : '#16a34a'}; height: 100%; width: ${percentualPreenchimento}%"></div>
                        </div>
                        <span style="font-size: 0.75rem; color: var(--pi-text-muted);">${percentualPreenchimento}%</span>
                    </div>
                `;
            } else {
                preenchimentoFormatado = vagasStatus;
            }
            conteudo += detailRow('fa-chair', 'Vagas', preenchimentoFormatado);
            
            // Status de publicação
            let statusPublicacao = '';
            if (turma.publicado) {
                statusPublicacao = '<span class="pi-badge pi-badge-pub-sim"><i class="fas fa-globe me-1"></i>Publicada</span>';
            } else {
                statusPublicacao = '<span class="pi-badge pi-badge-pub-nao"><i class="fas fa-lock me-1"></i>Privada</span>';
            }
            conteudo += detailRow('fa-eye', 'Publicação', statusPublicacao);
            
            $('#conteudoVisualizarTurma').html(conteudo);
            new bootstrap.Modal(document.getElementById('modalVisualizarTurma')).show();
        },
        error: function() {
            Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao carregar detalhes da turma', confirmButtonColor: '#1d4ed8' });
        }
    });
};

function detailRow(icon, label, value) {
    return '<div class="pi-detail-row"><div class="pi-detail-icon"><i class="fas ' + icon + '"></i></div><div style="min-width:0;flex:1"><div class="pi-detail-label">' + label + '</div><div class="pi-detail-value">' + value + '</div></div></div>';
}

/**
 * Abrir modal de edição
 */
window.abrirEdicaoTurma = function(id) {
    $.ajax({
        url: `/turmas/${id}`,
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            const turma = response.dados || response.data;
            
            $('#editTurmaId').val(turma.id);
            $('#editCursoId').val(turma.curso_id);
            $('#editFormadorId').val(turma.formador_id || '');
            $('#editPeriodo').val(turma.periodo);
            $('#editModalidade').val(turma.modalidade || 'presencial');
            $('#editStatus').val(turma.status || 'planeada');
            $('#editHoraInicio').val(turma.hora_inicio || '');
            $('#editHoraFim').val(turma.hora_fim || '');
            $('#editDuracaoSemanas').val(turma.duracao_semanas || '');
            $('#editDataArranque').val(turma.data_arranque);
            $('#editVagasTotais').val(turma.vagas_totais || '');
            $('#editPublicado').prop('checked', turma.publicado || false);
            
            $('.dia-semana-edit').prop('checked', false);
            if (turma.dia_semana && Array.isArray(turma.dia_semana)) {
                turma.dia_semana.forEach(function(dia) {
                    $(`.dia-semana-edit[value="${dia}"]`).prop('checked', true);
                });
            }
            
            new bootstrap.Modal(document.getElementById('modalEditarTurma')).show();
        },
        error: function() {
            Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao carregar dados da turma', confirmButtonColor: '#1d4ed8' });
        }
    });
};

/**
 * Criar turma
 */
function criarTurma() {
    $('#formNovaTurmaAjax .is-invalid').removeClass('is-invalid');
    $('#diasError').hide();

    const dia_semana = [];
    $('.dia-semana:checked').each(function() {
        dia_semana.push($(this).val());
    });

    if (dia_semana.length === 0) {
        $('#diasError').show();
        Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'Selecione pelo menos um dia da semana', confirmButtonColor: '#1d4ed8' });
        return;
    }

    const formador_id = $('select[name="formador_id"]').val();
    const status = $('select[name="status"]').val();

    if (status === 'inscricoes_abertas' && !formador_id) {
        $('select[name="formador_id"]').addClass('is-invalid');
        Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'Para "Inscrições Abertas" é obrigatório selecionar um formador', confirmButtonColor: '#1d4ed8' });
        return;
    }

    const dados = {
        curso_id: $('select[name="curso_id"]').val(),
        centro_id: $('#modalNovasTurma select[name="centro_id"]').val(),
        formador_id: formador_id || null,
        periodo: $('select[name="periodo"]').val(),
        modalidade: $('select[name="modalidade"]').val(),
        status: status || 'planeada',
        hora_inicio: $('input[name="hora_inicio"]').val(),
        hora_fim: $('input[name="hora_fim"]').val(),
        duracao_semanas: $('input[name="duracao_semanas"]').val(),
        data_arranque: $('input[name="data_arranque"]').val(),
        vagas_totais: $('input[name="vagas_totais"]').val() || null,
        publicado: $('input[name="publicado"]').is(':checked'),
        dia_semana: dia_semana
    };

    const erros = [];
    if (!dados.curso_id) { $('select[name="curso_id"]').addClass('is-invalid'); erros.push('Curso é obrigatório'); }
    if (!dados.centro_id) { $('#modalNovasTurma select[name="centro_id"]').addClass('is-invalid'); erros.push('Centro é obrigatório'); }
    if (!dados.periodo) { $('select[name="periodo"]').addClass('is-invalid'); erros.push('Período é obrigatório'); }
    if (!dados.modalidade) { $('select[name="modalidade"]').addClass('is-invalid'); erros.push('Modalidade é obrigatória'); }
    if (!dados.hora_inicio) { $('input[name="hora_inicio"]').addClass('is-invalid'); erros.push('Hora de início é obrigatória'); }
    if (!dados.data_arranque) { $('input[name="data_arranque"]').addClass('is-invalid'); erros.push('Data de arranque é obrigatória'); }

    if (erros.length > 0) {
        Swal.fire({ icon: 'error', title: 'Erro!', html: erros.join('<br>'), confirmButtonColor: '#1d4ed8' });
        return;
    }

    const $btn = $('#btnCriarTurma');
    const textoOriginal = $btn.html();
    $btn.prop('disabled', true).html('<span class="pi-spinner"></span> Criando...');

    $.ajax({
        url: '/turmas',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(dados),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function(response) {
            Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Turma criada com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
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

            Object.keys(errors).forEach(field => {
                const $field = $(`[name="${field}"]`);
                if ($field.length) $field.addClass('is-invalid');
            });

            if (Object.keys(errors).length > 0) {
                mensagem += '<br>' + Object.values(errors).flat().join('<br>');
            }

            Swal.fire({ icon: 'error', title: 'Erro!', html: mensagem, confirmButtonColor: '#1d4ed8' });
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
        Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'Selecione pelo menos um dia da semana', confirmButtonColor: '#1d4ed8' });
        return;
    }
    
    const formador_id = $('#editFormadorId').val();
    const status = $('#editStatus').val();
    
    if (status === 'inscricoes_abertas' && !formador_id) {
        Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'Para "Inscrições Abertas" é obrigatório selecionar um formador', confirmButtonColor: '#1d4ed8' });
        return;
    }
    
    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('curso_id', $('#editCursoId').val());
    formData.append('formador_id', formador_id || null);
    formData.append('periodo', $('#editPeriodo').val());
    formData.append('modalidade', $('#editModalidade').val());
    formData.append('status', status || 'planeada');
    formData.append('hora_inicio', $('#editHoraInicio').val());
    formData.append('hora_fim', $('#editHoraFim').val());
    formData.append('duracao_semanas', $('#editDuracaoSemanas').val());
    formData.append('data_arranque', $('#editDataArranque').val());
    formData.append('vagas_totais', $('#editVagasTotais').val() || null);
    formData.append('publicado', $('#editPublicado').is(':checked') ? 1 : 0);
    dia_semana.forEach(dia => formData.append('dia_semana[]', dia));
    
    $.ajax({
        url: `/turmas/${turmaId}`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() {
            Swal.fire({ icon: 'success', title: 'Atualizado!', text: 'Turma atualizada com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
            bootstrap.Modal.getInstance(document.getElementById('modalEditarTurma')).hide();
            carregarTurmas();
        },
        error: function(xhr) {
            const errors = xhr.responseJSON?.errors || {};
            let mensagem = 'Erro ao atualizar turma';
            if (Object.keys(errors).length > 0) {
                mensagem = Object.values(errors).flat().join(', ');
            }
            Swal.fire({ icon: 'error', title: 'Erro!', text: mensagem, confirmButtonColor: '#1d4ed8' });
        }
    });
}

/**
 * Eliminar turma
 */
window.eliminarTurma = function(id) {
    if (!id || id === '') {
        Swal.fire({ icon: 'error', title: 'Erro!', text: 'ID da turma inválido', confirmButtonColor: '#1d4ed8' });
        return;
    }
    
    Swal.fire({
        title: 'Eliminar turma?',
        text: 'Esta ação é irreversível!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="fas fa-trash me-1"></i> Sim, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            
            $.ajax({
                url: `/turmas/${id}`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function() {
                    Swal.fire({ icon: 'success', title: 'Eliminada!', text: 'Turma eliminada com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
                    carregarTurmas();
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao eliminar turma', confirmButtonColor: '#1d4ed8' });
                }
            });
        }
    });
};

/**
 * Limpar filtros
 */
function limparFiltros() {
    $('#filtroSearch').val('');
    $('#filtroCurso').val('');
    $('#filtroStatus').val('');
    $('#filtroPeriodo').val('');
    aplicarFiltrosLocais();
}

/**
 * Auxiliar: Gerar badge de período
 */
function getPeriodoBadge(periodo) {
    const icones = { 'manha': 'fa-sun', 'tarde': 'fa-cloud-sun', 'noite': 'fa-moon' };
    const labels = { 'manha': 'Manhã', 'tarde': 'Tarde', 'noite': 'Noite' };
    const icon = icones[periodo] || 'fa-clock';
    const label = labels[periodo] || 'N/A';
    return '<span class="pi-badge pi-badge-periodo"><i class="fas ' + icon + '"></i> ' + label + '</span>';
}

/**
 * Auxiliar: Gerar badge de modalidade
 */
function getModalidadeBadge(modalidade) {
    const icones = { 'presencial': 'fa-building', 'online': 'fa-laptop', 'hibrido': 'fa-handshake' };
    const labels = { 'presencial': 'Presencial', 'online': 'Online', 'hibrido': 'Híbrido' };
    const icon = icones[modalidade] || 'fa-chalkboard';
    const label = labels[modalidade] || 'N/A';
    return '<span class="pi-badge" style="background:var(--pi-info-light);color:#0369a1"><i class="fas ' + icon + '"></i> ' + label + '</span>';
}

/**
 * Auxiliar: Gerar badge de status
 */
function getStatusBadge(status) {
    const classes = {
        'planeada': 'pi-badge-planeada',
        'inscricoes_abertas': 'pi-badge-inscricoes',
        'em_andamento': 'pi-badge-andamento',
        'concluida': 'pi-badge-concluida'
    };
    const labels = {
        'planeada': 'Planeada',
        'inscricoes_abertas': 'Inscrições Abertas',
        'em_andamento': 'Em Andamento',
        'concluida': 'Concluída'
    };
    return '<span class="pi-badge ' + (classes[status] || 'pi-badge-planeada') + '">' + (labels[status] || status) + '</span>';
}
</script>
@endsection
