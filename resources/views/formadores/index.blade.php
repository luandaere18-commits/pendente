@extends('layouts.app')

@section('title', 'Formadores')

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

    /* ── STATS ── */
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

    /* ── TOOLBAR ── */
    .pi-toolbar {
        background: #fff; border-bottom: 1px solid var(--pi-border);
        padding: 0.625rem 1.25rem;
        display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem;
    }
    .pi-toolbar .search-wrap {
        position: relative; flex: 1; min-width: 200px;
    }
    .pi-toolbar .search-wrap i {
        position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);
        color: var(--pi-primary); font-size: 0.8125rem; pointer-events: none;
    }
    .pi-toolbar .search-wrap input {
        width: 100%; padding: 0.375rem 0.75rem 0.375rem 2.25rem;
        border: 1px solid var(--pi-border); border-radius: var(--pi-radius);
        font-size: 0.8125rem; background: var(--pi-bg); height: 2.125rem;
        transition: all 0.15s;
    }
    .pi-toolbar .search-wrap input:focus {
        outline: none; border-color: var(--pi-primary); box-shadow: 0 0 0 2px var(--pi-primary-light); background: #fff;
    }
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

    /* ── PAGINATION ── */
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
    .pi-badge-info { background: var(--pi-info-light); color: #0369a1; }
    .pi-badge-success { background: var(--pi-success-light); color: #15803d; }

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
    .pi-modal .modal-header .header-icon.orange { background: var(--pi-warning); color: #fff; }
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

    /* ── CENTRO CARD IN FORM ── */
    .pi-centro-card { background: var(--pi-bg); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); padding: 0.75rem; margin-bottom: 0.5rem; position: relative; }
    .pi-centro-card .centro-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
    .pi-centro-card .centro-number { font-size: 0.6875rem; font-weight: 600; color: #fff; background: var(--pi-primary); padding: 0.125rem 0.5rem; border-radius: 9999px; }

    /* ── BUTTON PRIMARY ── */
    .pi-btn-primary { background: var(--pi-primary); border: none; color: #fff; border-radius: var(--pi-radius); padding: 0.4375rem 0.875rem; font-size: 0.8125rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.375rem; transition: all 0.15s; cursor: pointer; }
    .pi-btn-primary:hover { background: var(--pi-primary-dark); color: #fff; }

    /* ── LOADING SPINNER ── */
    .pi-spinner { display: inline-block; width: 0.875rem; height: 0.875rem; border: 2px solid #fff; border-right-color: transparent; border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 0.25rem; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ── IMAGE STYLES (TABLE & MODAL) ── */
    .pi-formador-img { width: 32px; height: 32px; border-radius: 0.375rem; object-fit: cover; border: 1px solid var(--pi-border); }
    .pi-formador-img-placeholder { width: 32px; height: 32px; border-radius: 0.375rem; background: var(--pi-primary-light); display: inline-flex; align-items: center; justify-content: center; color: var(--pi-primary); font-size: 0.75rem; }
    .pi-formador-detail-img { max-width: 120px; max-height: 120px; object-fit: cover; border-radius: var(--pi-radius); border: 2px solid var(--pi-border); }
    .pi-formador-detail-img-placeholder { width: 120px; height: 120px; border-radius: var(--pi-radius); background: var(--pi-primary-light); display: flex; align-items: center; justify-content: center; color: var(--pi-primary); font-size: 1.75rem; }

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
                    <h1>Gestão de Formadores</h1>
                    <p>Gerir todos os formadores disponíveis no sistema</p>
                </div>
            </div>
        </div>
        <button class="pi-btn-create" data-bs-toggle="modal" data-bs-target="#modalNovoFormador">
            <i class="fas fa-plus"></i> Novo Formador
        </button>
    </div>

    {{-- ============================================= --}}
    {{-- STATS BAR                                     --}}
    {{-- ============================================= --}}
    <div class="pi-stats-bar">
        <div class="pi-stat">
            <div class="pi-stat-icon blue"><i class="fas fa-users"></i></div>
            <div>
                <div class="pi-stat-label">Total</div>
                <div class="pi-stat-value" style="color:var(--pi-primary)">{{ $formadores->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon green"><i class="fas fa-user-check"></i></div>
            <div>
                <div class="pi-stat-label">Com Cursos</div>
                <div class="pi-stat-value" style="color:var(--pi-success)">{{ $formadores->filter(fn($f) => $f->cursos_count > 0)->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon gray"><i class="fas fa-user-times"></i></div>
            <div>
                <div class="pi-stat-label">Sem Cursos</div>
                <div class="pi-stat-value" style="color:var(--pi-muted)">{{ $formadores->filter(fn($f) => $f->cursos_count == 0)->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon cyan"><i class="fas fa-phone"></i></div>
            <div>
                <div class="pi-stat-label">Com Contactos</div>
                <div class="pi-stat-value" style="color:var(--pi-info)">{{ $formadores->filter(fn($f) => $f->contactos_count > 0)->count() }}</div>
            </div>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- TOOLBAR (filters)                             --}}
    {{-- ============================================= --}}
    <div class="pi-toolbar">
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="filtroNome" placeholder="Buscar por nome do formador..." value="{{ request('nome') }}">
        </div>
        <div class="search-wrap" style="max-width:250px">
            <i class="fas fa-search"></i>
            <input type="text" id="filtroEspecialidade" placeholder="Buscar por especialidade..." value="{{ request('especialidade') }}">
        </div>
        <button class="pi-btn-clear" onclick="limparFiltros()">
            <i class="fas fa-times-circle"></i> Limpar
        </button>
    </div>

    {{-- ============================================= --}}
    {{-- TABLE                                         --}}
    {{-- ============================================= --}}
    <div class="pi-table-wrap">
        {{-- Desktop Table --}}
        <div class="pi-desktop-table">
            <table class="pi-table" id="formadoresTable">
                <thead>
                    <tr>
                        <th style="width:50px">ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Especialidade</th>
                        <th style="text-align:center">Cursos</th>
                        <th style="text-align:center">Contactos</th>
                        <th style="text-align:right;width:100px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($formadores as $formador)
                        <tr>
                            <td class="mono">#{{ $formador->id }}</td>
                            <td><strong style="font-size:0.8125rem">{{ $formador->nome }}</strong></td>
                            <td style="font-size:0.75rem;color:var(--pi-text-muted)">{{ $formador->email ?? '—' }}</td>
                            <td style="font-size:0.75rem">{{ $formador->especialidade ?? '—' }}</td>
                            <td style="text-align:center">
                                @if($formador->primeiro_nome_curso)
                                    <span class="pi-badge pi-badge-info">{{ $formador->primeiro_nome_curso }}</span>
                                    @if($formador->cursos_count > 1)
                                        <i class="fas fa-info-circle" style="color:var(--pi-muted);margin-left:0.25rem;cursor:help;font-size:0.6875rem"
                                           data-bs-toggle="tooltip"
                                           title="{{ $formador->cursos_lista }}"></i>
                                    @endif
                                @else
                                    <span style="color:var(--pi-text-muted)">—</span>
                                @endif
                            </td>
                            <td style="text-align:center">
                                @if($formador->primeiro_contacto)
                                    <span class="pi-badge pi-badge-success">{{ $formador->primeiro_contacto }}</span>
                                    @if($formador->contactos_count > 1)
                                        <i class="fas fa-info-circle" style="color:var(--pi-muted);margin-left:0.25rem;cursor:help;font-size:0.6875rem"
                                           data-bs-toggle="tooltip"
                                           title="{{ $formador->contactos_lista }}"></i>
                                    @endif
                                @else
                                    <span style="color:var(--pi-text-muted)">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="pi-actions">
                                    <button class="pi-action-btn view btn-visualizar-formador" data-formador-id="{{ $formador->id }}" title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="pi-action-btn edit btn-editar-formador" data-formador-id="{{ $formador->id }}" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="pi-action-btn delete btn-eliminar-formador" data-formador-id="{{ $formador->id }}" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="pi-empty">
                                    <div class="pi-empty-icon"><i class="fas fa-inbox"></i></div>
                                    <h3>Nenhum formador cadastrado</h3>
                                    <p>Crie um novo formador para começar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="pi-mobile-cards">
            @forelse($formadores as $formador)
                <div class="pi-mobile-card">
                    <div class="card-top">
                        <div>
                            <div class="card-name">{{ $formador->nome }}</div>
                            <div class="card-meta">{{ $formador->especialidade ?? 'Sem especialidade' }} · {{ $formador->email ?? 'Sem email' }}</div>
                        </div>
                    </div>
                    <div class="card-details">
                        @if($formador->primeiro_nome_curso)
                            <span><i class="fas fa-book me-1"></i>{{ $formador->primeiro_nome_curso }}</span>
                        @endif
                        @if($formador->primeiro_contacto)
                            <span><i class="fas fa-phone me-1"></i>{{ $formador->primeiro_contacto }}</span>
                        @endif
                    </div>
                    <div class="card-actions">
                        <button class="btn btn-sm btn-outline-primary btn-visualizar-formador" data-formador-id="{{ $formador->id }}"><i class="fas fa-eye me-1"></i>Ver</button>
                        <button class="btn btn-sm btn-outline-primary btn-editar-formador" data-formador-id="{{ $formador->id }}"><i class="fas fa-edit me-1"></i>Editar</button>
                        <button class="btn btn-sm btn-outline-danger btn-eliminar-formador" data-formador-id="{{ $formador->id }}"><i class="fas fa-trash me-1"></i>Eliminar</button>
                    </div>
                </div>
            @empty
                <div class="pi-empty">
                    <div class="pi-empty-icon"><i class="fas fa-inbox"></i></div>
                    <h3>Nenhum formador cadastrado</h3>
                    <p>Crie um novo formador para começar</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- PAGINATION BAR --}}
    <div class="pi-pagination-bar">
        <span class="info">Mostrando {{ $formadores->count() }} formador(es)</span>
        <div class="pages">
            <button class="page-btn active">1</button>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Visualizar Detalhes do Formador       --}}
{{-- ============================================= --}}
<div class="modal fade pi-modal" id="modalVisualizarFormador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:580px">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon green"><i class="fas fa-eye"></i></div>
                    <div>
                        <h5 class="modal-title">Detalhes do Formador</h5>
                        <p class="modal-subtitle">Informações completas</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="conteudoVisualizarFormador">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2" style="font-size:0.8125rem">Carregando...</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Criar Novo Formador                   --}}
{{-- ============================================= --}}
<div class="modal fade pi-modal" id="modalNovoFormador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue"><i class="fas fa-user-plus"></i></div>
                    <div>
                        <h5 class="modal-title">Criar Novo Formador</h5>
                        <p class="modal-subtitle">Preencha os dados do formador</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNovoFormadorAjax" class="pi-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-id-card"></i> Informações do Formador</div>
                            <div class="mb-2">
                                <label class="form-label">Nome <span class="required">*</span></label>
                                <input type="text" class="form-control" name="nome" required placeholder="Nome completo">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="email@centro.ao">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Especialidade</label>
                                <input type="text" class="form-control" name="especialidade" placeholder="Ex: Informática, Design...">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Foto</label>
                                <input type="file" class="form-control" name="foto" accept="image/*">
                                <div class="form-text">JPEG, PNG, JPG, GIF (máx 2 MB)</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-address-book"></i> Contactos</div>
                            <div class="mb-2">
                                <label class="form-label">Contacto</label>
                                <input type="text" class="form-control" name="contacto_telefone" placeholder="+244 900 000 000">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Biografia</label>
                                <textarea class="form-control" name="bio" rows="5" placeholder="Breve descrição profissional..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="section-title mb-0 pb-0 border-0" style="border:none !important"><i class="fas fa-building"></i> Centros de Formação</div>
                            <button type="button" class="btn btn-sm pi-btn-primary" id="adicionarCentroNovoFormadorBtn"><i class="fas fa-plus"></i> Adicionar</button>
                        </div>
                        <div id="centrosContainerNovoFormador"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoFormadorAjax" class="btn pi-btn-primary"><i class="fas fa-save"></i> Salvar Formador</button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Editar Formador                       --}}
{{-- ============================================= --}}
<div class="modal fade pi-modal" id="modalEditarFormador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon orange"><i class="fas fa-user-edit"></i></div>
                    <div>
                        <h5 class="modal-title">Editar Formador</h5>
                        <p class="modal-subtitle">Atualizar dados do formador</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarFormadorAjax" class="pi-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editFormadorId">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-id-card"></i> Informações do Formador</div>
                            <div class="mb-2">
                                <label class="form-label">Nome <span class="required">*</span></label>
                                <input type="text" class="form-control" id="editNome" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Especialidade</label>
                                <input type="text" class="form-control" id="editEspecialidade">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Foto (Nova)</label>
                                <input type="file" class="form-control" id="editFoto" name="foto" accept="image/*">
                                <div class="form-text">Deixe em branco para manter a foto atual</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-address-book"></i> Contactos</div>
                            <div class="mb-2">
                                <label class="form-label">Contacto</label>
                                <input type="text" class="form-control" id="editContactoTelefone" placeholder="+244 900 000 000">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Biografia</label>
                                <textarea class="form-control" id="editBio" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="section-title mb-0 pb-0 border-0" style="border:none !important"><i class="fas fa-building"></i> Centros de Formação</div>
                            <button type="button" class="btn btn-sm pi-btn-primary" id="adicionarCentroEditarFormadorBtn"><i class="fas fa-plus"></i> Adicionar</button>
                        </div>
                        <div id="centrosContainerEditarFormador"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarFormadorAjax" class="btn pi-btn-primary"><i class="fas fa-save"></i> Guardar Alterações</button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- Template para Centro no Modal                 --}}
{{-- ============================================= --}}
<template id="centroFormadorTemplate">
    <div class="col-12">
        <div class="pi-centro-card centro-card">
            <div class="centro-header">
                <span class="centro-number numero-centro-modal">Centro 1</span>
                <button type="button" class="btn btn-sm btn-outline-danger remover-centro-modal" title="Remover"><i class="fas fa-times"></i></button>
            </div>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <label class="form-label">Centro <span class="required">*</span></label>
                    <select class="form-select centro-id-modal" required><option value="">Selecione o centro</option></select>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@section('scripts')
<script>
let centrosDisponiveisList = [];
let centrosContainerNovoFormadorCount = 0;
let centrosContainerEditarFormadorCount = 0;

$(document).ready(function() {
    carregarCentros();
    configurarEventosModal();

    // Filtros automáticos
    let filtroTimeout;
    $('#filtroNome, #filtroEspecialidade').on('input', function() {
        clearTimeout(filtroTimeout);
        filtroTimeout = setTimeout(aplicarFiltros, 300);
    });
});

/**
 * Carregar lista de centros disponíveis
 */
function carregarCentros() {
    $.ajax({
        url: '/centros',
        method: 'GET',
        success: function(data) {
            centrosDisponiveisList = data;
        },
        error: function(err) {
            console.error('Erro ao carregar centros:', err);
        }
    });
}

/**
 * Configurar eventos do modal
 */
function configurarEventosModal() {
    $('#modalNovoFormador').on('show.bs.modal', function() {
        $('#formNovoFormadorAjax')[0].reset();
        $('#centrosContainerNovoFormador').empty();
        centrosContainerNovoFormadorCount = 0;
        adicionarCentroNovoFormador();
    });

    $('#modalEditarFormador').on('show.bs.modal', function() {
        $('#centrosContainerEditarFormador').empty();
        centrosContainerEditarFormadorCount = 0;
    });

    // Image preview for create modal
    $('input[name="foto"]').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                // Store the preview data (can be used to display in UI if needed)
                console.log('Image selected for upload');
            };
            reader.readAsDataURL(file);
        }
    });

    // Image preview for edit modal
    $('#editFoto').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                console.log('New image selected for update');
            };
            reader.readAsDataURL(file);
        }
    });

    $(document).on('click', '#adicionarCentroNovoFormadorBtn', function(e) {
        e.preventDefault();
        adicionarCentroNovoFormador();
    });

    $(document).on('click', '#adicionarCentroEditarFormadorBtn', function(e) {
        e.preventDefault();
        adicionarCentroEditarFormador();
    });

    $(document).on('click', '.remover-centro-modal', function(e) {
        e.preventDefault();
        $(this).closest('.col-12').remove();
        atualizarNumeroCentros();
    });

    $(document).on('click', '.btn-visualizar-formador', function() {
        const id = $(this).data('formador-id');
        if (id) visualizarFormador(id);
    });

    $(document).on('click', '.btn-editar-formador', function() {
        const id = $(this).data('formador-id');
        if (id) abrirEdicaoFormador(id);
    });

    $(document).on('click', '.btn-eliminar-formador', function() {
        const id = $(this).data('formador-id');
        if (id) eliminarFormador(id);
    });

    // Ativar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el) });
}

function adicionarCentroNovoFormador() {
    const template = document.getElementById('centroFormadorTemplate');
    if (!template) return;
    const clone = template.content.cloneNode(true);
    const wrapper = document.createElement('div');
    wrapper.appendChild(clone);
    $('#centrosContainerNovoFormador').append(wrapper.innerHTML);
    const selects = $('#centrosContainerNovoFormador').find('.centro-id-modal');
    const lastSelect = selects.last();
    centrosDisponiveisList.forEach(centro => {
        lastSelect.append(`<option value="${centro.id}">${centro.nome}</option>`);
    });
    lastSelect.on('change', function() { atualizarSelectsDeCentros(); });
    atualizarSelectsDeCentros();
    atualizarNumeroCentros();
}

function adicionarCentroEditarFormador(centrosAssociados = []) {
    const template = document.getElementById('centroFormadorTemplate');
    if (!template) return;
    const clone = template.content.cloneNode(true);
    const wrapper = document.createElement('div');
    wrapper.appendChild(clone);
    $('#centrosContainerEditarFormador').append(wrapper.innerHTML);
    const selects = $('#centrosContainerEditarFormador').find('.centro-id-modal');
    const lastSelect = selects.last();
    centrosDisponiveisList.forEach(centro => {
        lastSelect.append(`<option value="${centro.id}">${centro.nome}</option>`);
    });
    lastSelect.on('change', function() { atualizarSelectsDeCentrosEditar(); });
    atualizarSelectsDeCentrosEditar();
    atualizarNumeroCentros();
}

function atualizarNumeroCentros() {
    const badges = $('.numero-centro-modal');
    badges.each((index, badge) => { $(badge).text('Centro ' + (index + 1)); });
    const btnsRemover = $('.remover-centro-modal');
    btnsRemover.prop('disabled', btnsRemover.length <= 1);
}

function atualizarSelectsDeCentros() {
    const selects = $('select.centro-id-modal:not(#centrosContainerEditarFormador select)');
    const allSelectedIds = [];
    selects.each(function() { const val = $(this).val(); if (val) allSelectedIds.push(val); });
    selects.each(function() {
        const select = $(this);
        const selectedInThis = select.val();
        select.find('option').each(function() {
            const optionId = $(this).val();
            if (optionId === '' || optionId === selectedInThis) { $(this).prop('hidden', false); }
            else if (allSelectedIds.includes(optionId)) { $(this).prop('hidden', true); }
            else { $(this).prop('hidden', false); }
        });
    });
}

function atualizarSelectsDeCentrosEditar() {
    const selectsEditar = $('#centrosContainerEditarFormador').find('.centro-id-modal');
    const allSelectedIds = [];
    selectsEditar.each(function() { const val = $(this).val(); if (val) allSelectedIds.push(val); });
    selectsEditar.each(function() {
        const select = $(this);
        const selectedInThis = select.val();
        select.find('option').each(function() {
            const optionId = $(this).val();
            if (optionId === '' || optionId === selectedInThis) { $(this).prop('hidden', false); }
            else if (allSelectedIds.includes(optionId)) { $(this).prop('hidden', true); }
            else { $(this).prop('hidden', false); }
        });
    });
}

window.visualizarFormador = function(id) {
    $.ajax({
        url: `/formadores/${id}`,
        method: 'GET',
        success: function(response) {
            const formador = response.data || response;
            let contactosHtml = '<span style="color:var(--pi-text-muted)">Sem contactos</span>';
            if (formador.contactos && Array.isArray(formador.contactos) && formador.contactos.length > 0) {
                contactosHtml = formador.contactos.map(function(c) {
                    let telefone = typeof c === 'string' ? c : (c.valor || c);
                    return `<span class="pi-badge pi-badge-success"><i class="fas fa-phone" style="margin-right:0.25rem"></i>${telefone}</span>`;
                }).join(' ');
            }
            let centrosHtml = '<span style="color:var(--pi-text-muted)">Nenhum centro associado</span>';
            if (formador.centros && Array.isArray(formador.centros) && formador.centros.length > 0) {
                centrosHtml = formador.centros.map(function(c) {
                    return `<span class="pi-badge pi-badge-info"><i class="fas fa-building" style="margin-right:0.25rem"></i>${c.nome}</span>`;
                }).join(' ');
            }
            const fotoHtml = formador.foto_url
                ? `<img src="${formador.foto_url}" alt="${formador.nome}" class="pi-formador-detail-img">`
                : '<div class="pi-formador-detail-img-placeholder"><i class="fas fa-user"></i></div>';

            const conteudo = `
                <div class="row g-3">
                    <div class="col-md-4 text-center">${fotoHtml}</div>
                    <div class="col-md-8">
                        <h5 style="font-weight:700;margin-bottom:0.5rem;font-size:1rem;color:var(--pi-text)">${formador.nome}</h5>
                        <div class="pi-detail-row">
                            <div class="pi-detail-icon"><i class="fas fa-envelope"></i></div>
                            <div><div class="pi-detail-label">Email</div><div class="pi-detail-value">${formador.email || '—'}</div></div>
                        </div>
                        <div class="pi-detail-row">
                            <div class="pi-detail-icon"><i class="fas fa-star"></i></div>
                            <div><div class="pi-detail-label">Especialidade</div><div class="pi-detail-value">${formador.especialidade || '—'}</div></div>
                        </div>
                        <div class="pi-detail-row">
                            <div class="pi-detail-icon"><i class="fas fa-phone"></i></div>
                            <div><div class="pi-detail-label">Contactos</div><div class="pi-detail-value">${contactosHtml}</div></div>
                        </div>
                        <div class="pi-detail-row">
                            <div class="pi-detail-icon"><i class="fas fa-building"></i></div>
                            <div><div class="pi-detail-label">Centros</div><div class="pi-detail-value">${centrosHtml}</div></div>
                        </div>
                        <div class="pi-detail-row">
                            <div class="pi-detail-icon"><i class="fas fa-align-left"></i></div>
                            <div><div class="pi-detail-label">Biografia</div><div class="pi-detail-value" style="font-weight:400;font-size:0.75rem">${formador.bio || '—'}</div></div>
                        </div>
                    </div>
                </div>
            `;
            $('#conteudoVisualizarFormador').html(conteudo);
            $('#modalVisualizarFormador').modal('show');
        },
        error: function() {
            Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao carregar detalhes', confirmButtonColor: '#1d4ed8' });
        }
    });
};

window.abrirEdicaoFormador = function(id) {
    $.ajax({
        url: `/formadores/${id}`,
        method: 'GET',
        success: function(response) {
            const formador = response.data || response;
            $('#editFormadorId').val(formador.id);
            $('#editNome').val(formador.nome);
            $('#editEmail').val(formador.email || '');
            $('#editEspecialidade').val(formador.especialidade || '');
            $('#editBio').val(formador.bio || '');
            let primeroContacto = '';
            if (formador.contactos && Array.isArray(formador.contactos) && formador.contactos.length > 0) {
                primeroContacto = typeof formador.contactos[0] === 'string' ? formador.contactos[0] : (formador.contactos[0].valor || '');
            }
            $('#editContactoTelefone').val(primeroContacto);
            const centrosAssociados = [];
            if (formador.centros && formador.centros.length > 0) {
                formador.centros.forEach(function(centro) { centrosAssociados.push(centro.id); });
            }
            $('#centrosContainerEditarFormador').empty();
            centrosContainerEditarFormadorCount = 0;
            setTimeout(function() {
                if (centrosAssociados.length > 0) {
                    centrosAssociados.forEach(function() { adicionarCentroEditarFormador(); });
                    setTimeout(function() {
                        const selects = $('#centrosContainerEditarFormador').find('.centro-id-modal');
                        selects.each(function(idx) { if (idx < centrosAssociados.length) $(this).val(centrosAssociados[idx]); });
                        atualizarSelectsDeCentrosEditar();
                        atualizarNumeroCentros();
                    }, 100);
                } else {
                    adicionarCentroEditarFormador();
                }
            }, 100);
            new bootstrap.Modal(document.getElementById('modalEditarFormador')).show();
        },
        error: function() {
            Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao carregar dados', confirmButtonColor: '#1d4ed8' });
        }
    });
};

$('#formNovoFormadorAjax').on('submit', function(e) {
    e.preventDefault();
    const form = $(this)[0];
    const formData = new FormData(form);
    const telefone = $('input[name="contacto_telefone"]').val();
    if (telefone && telefone.trim() !== '') formData.append('contactos[0]', telefone.trim());
    const centrosArray = [];
    $('#centrosContainerNovoFormador').find('.centro-card').each(function() {
        const centroId = $(this).find('.centro-id-modal').val();
        if (centroId) centrosArray.push(parseInt(centroId));
    });
    const keys = Array.from(formData.keys());
    keys.forEach(key => { if (key.startsWith('centros')) formData.delete(key); });
    centrosArray.forEach((centroId, index) => { formData.append(`centros[${index}]`, centroId); });
    $.ajax({
        url: "{{ route('formadores.store') }}",
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() {
            Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Formador criado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
            bootstrap.Modal.getInstance(document.getElementById('modalNovoFormador')).hide();
            $('#formNovoFormadorAjax')[0].reset();
            location.reload();
        },
        error: function(xhr) {
            let mensagem = 'Erro ao criar formador';
            if (xhr.responseJSON?.errors) mensagem = Object.values(xhr.responseJSON.errors).flat().join(', ');
            else if (xhr.responseJSON?.message) mensagem = xhr.responseJSON.message;
            Swal.fire({ icon: 'error', title: 'Erro!', text: mensagem, confirmButtonColor: '#1d4ed8' });
        }
    });
});

$('#formEditarFormadorAjax').on('submit', function(e) {
    e.preventDefault();
    const formadorId = $('#editFormadorId').val();
    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('nome', $('#editNome').val());
    formData.append('email', $('#editEmail').val());
    formData.append('especialidade', $('#editEspecialidade').val());
    formData.append('bio', $('#editBio').val());
    
    // Adicionar arquivo de foto se selecionado
    const fotoFile = $('#editFoto')[0].files[0];
    if (fotoFile) {
        formData.append('foto', fotoFile);
    }
    
    const telefone = $('#editContactoTelefone').val();
    if (telefone && telefone.trim() !== '') formData.append('contactos[0]', telefone.trim());
    const centrosArray = [];
    $('#centrosContainerEditarFormador').find('.centro-card').each(function() {
        const centroId = $(this).find('.centro-id-modal').val();
        if (centroId) centrosArray.push(parseInt(centroId));
    });
    centrosArray.forEach((centroId, index) => { formData.append(`centros[${index}]`, centroId); });
    $.ajax({
        url: `/formadores/${formadorId}`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() {
            Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Formador atualizado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
            bootstrap.Modal.getInstance(document.getElementById('modalEditarFormador')).hide();
            location.reload();
        },
        error: function(xhr) {
            let mensagem = 'Erro ao atualizar formador';
            if (xhr.responseJSON?.errors) mensagem = Object.values(xhr.responseJSON.errors).flat().join(', ');
            else if (xhr.responseJSON?.message) mensagem = xhr.responseJSON.message;
            Swal.fire({ icon: 'error', title: 'Erro!', text: mensagem, confirmButtonColor: '#1d4ed8' });
        }
    });
});

window.eliminarFormador = function(id) {
    Swal.fire({
        title: 'Eliminar formador?',
        text: 'Esta ação é irreversível!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="fas fa-trash me-1"></i> Sim, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/formadores/${id}`,
                method: 'POST',
                data: {_method: 'DELETE'},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function() {
                    Swal.fire({ icon: 'success', title: 'Eliminado!', text: 'Formador eliminado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
                    location.reload();
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao eliminar formador', confirmButtonColor: '#1d4ed8' });
                }
            });
        }
    });
};

function aplicarFiltros() {
    let nome = $('#filtroNome').val();
    let especialidade = $('#filtroEspecialidade').val();
    let url = '/formadores?';
    if (nome) url += 'nome=' + encodeURIComponent(nome) + '&';
    if (especialidade) url += 'especialidade=' + encodeURIComponent(especialidade) + '&';
    url = url.replace(/&$/, '');
    window.location.href = url;
}

function limparFiltros() {
    window.location.href = '/formadores';
}
</script>
@endsection
