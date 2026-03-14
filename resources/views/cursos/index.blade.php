@extends('layouts.app')

@section('title', 'Cursos')

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

    /* ── BLUE HEADER (35% blue rule) ── */
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

    /* ── STATS (with blue accents) ── */
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

    /* ── PAGINATION (blue bar) ── */
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
    .pi-badge-ativo { background: var(--pi-success-light); color: #15803d; }
    .pi-badge-inativo { background: rgba(100,116,139,0.08); color: #475569; }
    .pi-badge-presencial { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-badge-online { background: var(--pi-info-light); color: #0369a1; }
    .pi-badge-hibrido { background: var(--pi-warning-light); color: #92400e; }

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

    /* ── COURSE IMAGE IN TABLE ── */
    .pi-curso-img { width: 32px; height: 32px; border-radius: 0.375rem; object-fit: cover; border: 1px solid var(--pi-border); }
    .pi-curso-img-placeholder { width: 32px; height: 32px; border-radius: 0.375rem; background: var(--pi-primary-light); display: inline-flex; align-items: center; justify-content: center; color: var(--pi-primary); font-size: 0.75rem; }

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

    /* ── COURSE DETAIL IMAGE IN MODAL ── */
    .pi-curso-detail-img { max-width: 120px; max-height: 120px; object-fit: cover; border-radius: var(--pi-radius); border: 2px solid var(--pi-border); }
    .pi-curso-detail-img-placeholder { width: 120px; height: 120px; border-radius: var(--pi-radius); background: var(--pi-primary-light); display: flex; align-items: center; justify-content: center; color: var(--pi-primary); font-size: 1.75rem; }

    /* ── UPLOAD AREA ── */
    .pi-upload-area { border: 2px dashed var(--pi-border); border-radius: var(--pi-radius); padding: 1.25rem; text-align: center; cursor: pointer; transition: all 0.15s; }
    .pi-upload-area:hover { border-color: var(--pi-primary); background: var(--pi-primary-light); }

    /* ── CENTRO CARD IN FORM ── */
    .pi-centro-card { background: var(--pi-bg); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); padding: 0.75rem; margin-bottom: 0.5rem; position: relative; }
    .pi-centro-card .centro-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
    .pi-centro-card .centro-number { font-size: 0.6875rem; font-weight: 600; color: #fff; background: var(--pi-primary); padding: 0.125rem 0.5rem; border-radius: 9999px; }

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
                <i class="fas fa-graduation-cap fa-lg" style="opacity:0.9"></i>
                <div>
                    <h1>Gestão de Cursos</h1>
                    <p>{{ $cursos->count() }} curso(s) registado(s) no sistema</p>
                </div>
            </div>
        </div>
        <button class="pi-btn-create" data-bs-toggle="modal" data-bs-target="#modalNovoCurso">
            <i class="fas fa-plus"></i> Novo Curso
        </button>
    </div>

    {{-- ============================================= --}}
    {{-- STATS BAR                                     --}}
    {{-- ============================================= --}}
    <div class="pi-stats-bar">
        <div class="pi-stat">
            <div class="pi-stat-icon blue"><i class="fas fa-book"></i></div>
            <div>
                <div class="pi-stat-label">Total</div>
                <div class="pi-stat-value" style="color:var(--pi-primary)">{{ $cursos->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="pi-stat-label">Ativos</div>
                <div class="pi-stat-value" style="color:var(--pi-success)">{{ $cursos->where('ativo', true)->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon gray"><i class="fas fa-pause-circle"></i></div>
            <div>
                <div class="pi-stat-label">Inativos</div>
                <div class="pi-stat-value" style="color:var(--pi-muted)">{{ $cursos->where('ativo', false)->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon cyan"><i class="fas fa-layer-group"></i></div>
            <div>
                <div class="pi-stat-label">Modalidades</div>
                <div class="pi-stat-value" style="color:var(--pi-info)">{{ $cursos->pluck('modalidade')->unique()->count() }}</div>
            </div>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- TOOLBAR (filters)                             --}}
    {{-- ============================================= --}}
    <div class="pi-toolbar">
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="filtroNome" placeholder="Buscar por nome do curso..." value="{{ request('nome') }}">
        </div>
        <select class="form-select" id="filtroModalidade" style="border-color:var(--pi-border)">
            <option value="">Todas modalidades</option>
            <option value="presencial" {{ request('modalidade') == 'presencial' ? 'selected' : '' }}>Presencial</option>
            <option value="online" {{ request('modalidade') == 'online' ? 'selected' : '' }}>Online</option>
            <option value="hibrido" {{ request('modalidade') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
        </select>
        <select class="form-select" id="filtroStatus" style="border-color:var(--pi-border)">
            <option value="">Todos status</option>
            <option value="1" {{ request('ativo') === '1' ? 'selected' : '' }}>Ativo</option>
            <option value="0" {{ request('ativo') === '0' ? 'selected' : '' }}>Inativo</option>
        </select>
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
            <table class="pi-table">
                <thead>
                    <tr>
                        <th style="width:50px">ID</th>
                        <th>Nome do Curso</th>
                        <th>Modalidade</th>
                        <th>Centro(s)</th>
                        <th>Preço Médio</th>
                        <th>Status</th>
                        <th style="text-align:right;width:100px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cursos as $curso)
                        <tr>
                            <td class="mono">#{{ $curso->id }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.5rem">
                                    @if($curso->imagem)
                                        <img src="{{ asset('storage/' . $curso->imagem) }}" alt="{{ $curso->nome }}" class="pi-curso-img">
                                    @else
                                        <div class="pi-curso-img-placeholder"><i class="fas fa-graduation-cap"></i></div>
                                    @endif
                                    <strong style="font-size:0.8125rem">{{ $curso->nome }}</strong>
                                </div>
                            </td>
                            <td>
                                @php
                                    $modClass = [
                                        'presencial' => 'pi-badge-presencial',
                                        'online' => 'pi-badge-online',
                                        'hibrido' => 'pi-badge-hibrido',
                                    ];
                                    $modIcons = [
                                        'presencial' => 'fas fa-building',
                                        'online' => 'fas fa-globe',
                                        'hibrido' => 'fas fa-laptop-house',
                                    ];
                                @endphp
                                <span class="pi-badge {{ $modClass[$curso->modalidade] ?? 'pi-badge-presencial' }}">
                                    <i class="{{ $modIcons[$curso->modalidade] ?? 'fas fa-question' }}"></i>
                                    {{ ucfirst($curso->modalidade) }}
                                </span>
                            </td>
                            <td style="font-size:0.75rem">
                                @if($curso->centros->count() > 0)
                                    <i class="fas fa-building" style="color:var(--pi-primary);margin-right:0.25rem"></i>{{ $curso->centros->count() }}
                                @else
                                    <span style="color:var(--pi-text-muted)">—</span>
                                @endif
                            </td>
                            <td style="font-size:0.75rem;font-weight:600">
                                @if($curso->centros->count() > 0)
                                    {{ number_format($curso->centros->avg('pivot.preco'), 2, ',', '.') }} Kz
                                @else
                                    <span style="color:var(--pi-text-muted)">—</span>
                                @endif
                            </td>
                            <td>
                                @if($curso->ativo)
                                    <span class="pi-badge pi-badge-ativo"><i class="fas fa-check-circle"></i> Ativo</span>
                                @else
                                    <span class="pi-badge pi-badge-inativo"><i class="fas fa-times-circle"></i> Inativo</span>
                                @endif
                            </td>
                            <td>
                                <div class="pi-actions">
                                    <button class="pi-action-btn view btn-visualizar-curso" data-curso-id="{{ $curso->id }}" title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a class="pi-action-btn edit" href="{{ route('cursos.show', $curso) }}" title="Gerir">
                                        <i class="fas fa-cogs"></i>
                                    </a>
                                    <button class="pi-action-btn delete btn-eliminar-curso" data-curso-id="{{ $curso->id }}" title="Eliminar">
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
                                    <h3>Nenhum curso cadastrado</h3>
                                    <p>Crie um novo curso para começar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="pi-mobile-cards">
            @forelse($cursos as $curso)
                <div class="pi-mobile-card">
                    <div class="card-top">
                        <div style="display:flex;align-items:center;gap:0.5rem">
                            @if($curso->imagem)
                                <img src="{{ asset('storage/' . $curso->imagem) }}" alt="{{ $curso->nome }}" class="pi-curso-img">
                            @else
                                <div class="pi-curso-img-placeholder"><i class="fas fa-graduation-cap"></i></div>
                            @endif
                            <div>
                                <div class="card-name">{{ $curso->nome }}</div>
                                <div class="card-meta">{{ ucfirst($curso->modalidade) }} · {{ $curso->centros->count() }} centro(s)</div>
                            </div>
                        </div>
                        @if($curso->ativo)
                            <span class="pi-badge pi-badge-ativo">Ativo</span>
                        @else
                            <span class="pi-badge pi-badge-inativo">Inativo</span>
                        @endif
                    </div>
                    <div class="card-details">
                        @if($curso->centros->count() > 0)
                            <span><i class="fas fa-money-bill-wave me-1"></i>{{ number_format($curso->centros->avg('pivot.preco'), 2, ',', '.') }} Kz</span>
                        @endif
                    </div>
                    <div class="card-actions">
                        <button class="btn btn-sm btn-outline-secondary btn-visualizar-curso" data-curso-id="{{ $curso->id }}"><i class="fas fa-eye me-1"></i>Ver</button>
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('cursos.show', $curso) }}"><i class="fas fa-cogs me-1"></i>Gerir</a>
                        <button class="btn btn-sm btn-outline-danger btn-eliminar-curso" data-curso-id="{{ $curso->id }}"><i class="fas fa-trash me-1"></i>Eliminar</button>
                    </div>
                </div>
            @empty
                <div class="pi-empty">
                    <div class="pi-empty-icon"><i class="fas fa-inbox"></i></div>
                    <h3>Nenhum curso cadastrado</h3>
                    <p>Crie um novo curso para começar</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- PAGINATION BAR --}}
    <div class="pi-pagination-bar">
        <span class="info">Mostrando {{ $cursos->count() }} curso(s)</span>
        <div class="pages">
            {{-- If using Laravel pagination ($cursos = Curso::paginate(10)) --}}
            {{-- {{ $cursos->links() }} --}}
            <button class="page-btn active">1</button>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Visualizar Detalhes do Curso           --}}
{{-- ============================================= --}}
<div class="modal fade pi-modal" id="modalVisualizarCurso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:580px">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon green"><i class="fas fa-eye"></i></div>
                    <div>
                        <h5 class="modal-title">Detalhes do Curso</h5>
                        <p class="modal-subtitle">Informações completas</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="conteudoVisualizarCurso">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2" style="font-size:0.8125rem">Carregando...</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Criar Novo Curso                       --}}
{{-- ============================================= --}}
<div class="modal fade pi-modal" id="modalNovoCurso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue"><i class="fas fa-plus-circle"></i></div>
                    <div>
                        <h5 class="modal-title">Criar Novo Curso</h5>
                        <p class="modal-subtitle">Preencha os dados do curso</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNovoCursoAjax" class="pi-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-info-circle"></i> Informações do Curso</div>
                            <div class="mb-2">
                                <label class="form-label">Nome <span class="required">*</span></label>
                                <input type="text" class="form-control" name="nome" required placeholder="Nome do curso">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Área <span class="required">*</span></label>
                                <input type="text" class="form-control" name="area" required placeholder="Área do curso">
                            </div>
                            <div class="row mb-2">
                                <div class="col-7">
                                    <label class="form-label">Modalidade <span class="required">*</span></label>
                                    <select class="form-select" name="modalidade" required>
                                        <option value="">Selecione</option>
                                        <option value="presencial">Presencial</option>
                                        <option value="online">Online</option>
                                        <option value="hibrido">Híbrido</option>
                                    </select>
                                </div>
                                <div class="col-5 d-flex align-items-end">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="ativo" id="novoCursoAtivo" checked>
                                        <label class="form-check-label" for="novoCursoAtivo" style="font-size:0.8125rem">Ativo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Imagem</label>
                                <input type="file" class="form-control" name="imagem" accept="image/jpeg,image/png,image/jpg,image/gif">
                                <div class="form-text">JPEG, PNG, JPG, GIF (máx 2 MB)</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-file-alt"></i> Conteúdo</div>
                            <div class="mb-2">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control" name="descricao" rows="3" placeholder="Descrição do curso"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Programa do Curso</label>
                                <textarea class="form-control" name="programa" rows="3" placeholder="Programa detalhado"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="section-title mb-0 pb-0 border-0" style="border:none !important"><i class="fas fa-building"></i> Centros de Formação</div>
                            <button type="button" class="btn btn-sm pi-btn-primary" id="adicionarCentroModalBtn"><i class="fas fa-plus"></i> Adicionar</button>
                        </div>
                        <div id="centrosContainerModal"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoCursoAjax" class="btn pi-btn-primary"><i class="fas fa-check"></i> Criar Curso</button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- Template para Centro no Modal                 --}}
{{-- ============================================= --}}
<template id="centroCursoTemplate">
    <div class="col-12">
        <div class="pi-centro-card centro-card">
            <div class="centro-header">
                <span class="centro-number numero-centro-modal">Centro 1</span>
                <button type="button" class="btn btn-sm btn-outline-danger remover-centro-modal" title="Remover"><i class="fas fa-times"></i></button>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="form-label">Centro <span class="required">*</span></label>
                    <select class="form-select centro-id-modal" required><option value="">Selecione o centro</option></select>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Preço (Kz) <span class="required">*</span></label>
                    <input type="number" class="form-control preco-modal" step="0.01" min="0" placeholder="0.00" required>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@section('scripts')
<script>
let centrosContainerModalCount = 0;
let centrosDisponiveisList = [];

$(document).ready(function() {
    carregarCentros();
    configurarEventosModal();

    // Filtros automáticos (sem botão)
    let filtroTimeout;
    $('#filtroNome').on('input', function() {
        clearTimeout(filtroTimeout);
        filtroTimeout = setTimeout(aplicarFiltros, 300);
    });
    $('#filtroModalidade, #filtroStatus').on('change', aplicarFiltros);
});

/**
 * Carregar lista de centros disponíveis
 */
function carregarCentros() {
    $.ajax({
        url: '/centros',
        method: 'GET',
        success: function(data) {
            centrosDisponiveisList = data || [];
            if (centrosDisponiveisList.length === 0) {
                console.warn('Nenhum centro disponível para associação');
            }
        },
        error: function(err) {
            console.error('Erro ao carregar centros:', err);
            centrosDisponiveisList = [];
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Não foi possível carregar a lista de centros. Verifique sua conexão de internet.',
                timer: 4000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                background: '#1d4ed8',
                color: '#fff'
            });
        }
    });
}

/**
 * Carregar detalhes do curso para visualização
 */
function carregarDetalhesCurso(cursoId) {
    $.ajax({
        url: `/cursos/${cursoId}`,
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        },
        success: function(response) {
            const curso = response.dados || response;
            
            const statusBadge = curso.ativo 
                ? '<span class="pi-badge pi-badge-ativo"><i class="fas fa-check-circle"></i> Ativo</span>'
                : '<span class="pi-badge pi-badge-inativo"><i class="fas fa-times-circle"></i> Inativo</span>';
            
            const modClasses = { 'online': 'pi-badge-online', 'presencial': 'pi-badge-presencial', 'hibrido': 'pi-badge-hibrido' };
            const modIcons = { 'online': 'fas fa-globe', 'presencial': 'fas fa-building', 'hibrido': 'fas fa-laptop-house' };
            const modalidadeBadge = `<span class="pi-badge ${modClasses[curso.modalidade] || 'pi-badge-presencial'}"><i class="${modIcons[curso.modalidade] || 'fas fa-question'}"></i> ${curso.modalidade ? curso.modalidade.charAt(0).toUpperCase() + curso.modalidade.slice(1) : 'N/A'}</span>`;
            
            const imagemHtml = curso.imagem_url 
                ? `<img src="${curso.imagem_url}" alt="${curso.nome}" class="pi-curso-detail-img">`
                : '<div class="pi-curso-detail-img-placeholder"><i class="fas fa-image"></i></div>';
            
            // Seção de Centros
            let centrosHtml = '';
            if (curso.centros && curso.centros.length > 0) {
                centrosHtml = `
                    <div class="mt-3">
                        <div class="section-title" style="font-size:0.75rem;font-weight:600;color:var(--pi-primary);padding-bottom:0.375rem;border-bottom:2px solid var(--pi-primary);display:flex;align-items:center;gap:0.375rem;text-transform:uppercase;letter-spacing:0.03em">
                            <i class="fas fa-building"></i> Centros Associados
                        </div>
                        <table class="pi-table" style="font-size:0.75rem">
                            <thead><tr><th>Centro</th><th>Preço (Kz)</th></tr></thead>
                            <tbody>`;
                curso.centros.forEach(centro => {
                    const preco = centro.pivot?.preco ? parseFloat(centro.pivot.preco).toLocaleString('pt-PT') : 'N/A';
                    centrosHtml += `<tr><td><strong>${centro.nome}</strong></td><td style="color:var(--pi-success);font-weight:600">${preco}</td></tr>`;
                });
                centrosHtml += '</tbody></table></div>';
            }
            
            // Seção de Turmas
            let turmasHtml = '';
            if (curso.turmas && curso.turmas.length > 0) {
                turmasHtml = `
                    <div class="mt-3">
                        <div class="section-title" style="font-size:0.75rem;font-weight:600;color:var(--pi-info);padding-bottom:0.375rem;border-bottom:2px solid var(--pi-info);display:flex;align-items:center;gap:0.375rem;text-transform:uppercase;letter-spacing:0.03em">
                            <i class="fas fa-calendar"></i> Turmas
                        </div>
                        <table class="pi-table" style="font-size:0.75rem">
                            <thead><tr><th>Dias</th><th>Período</th><th>Data Arranque</th><th>Semanas</th></tr></thead>
                            <tbody>`;
                curso.turmas.forEach(turma => {
                    const dias = Array.isArray(turma.dia_semana) 
                        ? turma.dia_semana.map(d => {
                            const diasNomes = { 0: 'Dom', 1: 'Seg', 2: 'Ter', 3: 'Qua', 4: 'Qui', 5: 'Sex', 6: 'Sab' };
                            return diasNomes[d] || d;
                        }).join(', ')
                        : (turma.dia_semana || 'N/A');
                    
                    const periodo = turma.periodo === 'manha' ? 'Manhã' : 
                                   turma.periodo === 'tarde' ? 'Tarde' : 
                                   turma.periodo === 'noite' ? 'Noite' : (turma.periodo || 'N/A');
                    
                    let dataArranque = 'N/A';
                    if (turma.data_arranque) {
                        const data = new Date(turma.data_arranque);
                        if (!isNaN(data.getTime())) {
                            dataArranque = data.toLocaleDateString('pt-PT');
                        }
                    }
                    
                    turmasHtml += `
                        <tr>
                            <td><strong>${dias}</strong></td>
                            <td><span class="pi-badge pi-badge-presencial">${periodo}</span></td>
                            <td><strong>${dataArranque}</strong></td>
                            <td>${turma.duracao_semanas || 'N/A'}</td>
                        </tr>`;
                });
                turmasHtml += '</tbody></table></div>';
            }
            
            const conteudo = `
                <div class="row g-3 mb-2">
                    <div class="col-md-3 text-center">
                        ${imagemHtml}
                    </div>
                    <div class="col-md-9 ps-md-3" style="min-width:0;">
                        <h5 style="font-weight:700;margin-bottom:0.375rem;font-size:1rem;color:var(--pi-text)">${curso.nome}</h5>
                        <div class="d-flex gap-2 flex-wrap mb-2">
                            ${statusBadge}
                            ${modalidadeBadge}
                        </div>
                        <div class="pi-detail-row">
                            <div class="pi-detail-icon"><i class="fas fa-tag"></i></div>
                            <div>
                                <div class="pi-detail-label">Área</div>
                                <div class="pi-detail-value">${curso.area || 'N/A'}</div>
                            </div>
                        </div>
                        ${curso.descricao ? `
                        <div class="pi-detail-row">
                            <div class="pi-detail-icon"><i class="fas fa-align-left"></i></div>
                            <div>
                                <div class="pi-detail-label">Descrição</div>
                                <div class="pi-detail-value" style="font-weight:400;font-size:0.75rem">${curso.descricao}</div>
                            </div>
                        </div>` : ''}
                        ${curso.programa ? `
                        <div class="pi-detail-row">
                            <div class="pi-detail-icon"><i class="fas fa-book"></i></div>
                            <div>
                                <div class="pi-detail-label">Programa</div>
                                <div class="pi-detail-value" style="font-weight:400;font-size:0.75rem">${curso.programa}</div>
                            </div>
                        </div>` : ''}
                    </div>
                </div>
                ${centrosHtml}
                ${turmasHtml}
            `;
            
            $('#conteudoVisualizarCurso').html(conteudo);
            $('#modalVisualizarCurso').modal('show');
        },
        error: function(err) {
            console.error('Erro ao carregar detalhes do curso:', err);
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Não foi possível carregar os detalhes do curso.',
                confirmButtonColor: '#1d4ed8'
            });
        }
    });
}

/**
 * Configurar eventos do modal
 */
function configurarEventosModal() {
    $('#modalNovoCurso').on('show.bs.modal', function() {
        $('#formNovoCursoAjax')[0].reset();
        $('#centrosContainerModal').empty();
        centrosContainerModalCount = 0;
        adicionarCentroModal();
        $('#novoCursoAtivo').prop('checked', true);
    });

    $(document).on('click', '#adicionarCentroModalBtn', function(e) {
        e.preventDefault();
        adicionarCentroModal();
    });

    $(document).on('click', '.remover-centro-modal', function(e) {
        e.preventDefault();
        $(this).closest('.col-12').remove();
        atualizarNumeroCentrosModal();
    });

    $(document).on('click', '.btn-visualizar-curso', function(e) {
        e.preventDefault();
        const cursoId = $(this).data('curso-id');
        carregarDetalhesCurso(cursoId);
    });

    $(document).on('click', '.btn-eliminar-curso', function(e) {
        e.preventDefault();
        const cursoId = $(this).data('curso-id');
        eliminarCurso(cursoId);
    });
}

function adicionarCentroModal() {
    const template = document.getElementById('centroCursoTemplate');
    if (!template) return;
    const clone = template.content.cloneNode(true);
    const wrapper = document.createElement('div');
    wrapper.appendChild(clone);
    const html = wrapper.innerHTML;
    $('#centrosContainerModal').append(html);
    const selects = $('#centrosContainerModal').find('.centro-id-modal');
    const lastSelect = selects.last();
    centrosDisponiveisList.forEach(centro => {
        lastSelect.append(`<option value="${centro.id}">${centro.nome}</option>`);
    });
    atualizarNumeroCentrosModal();
}

function atualizarNumeroCentrosModal() {
    const badges = $('#centrosContainerModal').find('.numero-centro-modal');
    badges.each((index, badge) => { $(badge).text('Centro ' + (index + 1)); });
    const btnsRemover = $('#centrosContainerModal').find('.remover-centro-modal');
    btnsRemover.prop('disabled', btnsRemover.length <= 1);
}

$("#formNovoCursoAjax").on("submit", function(e) {
    e.preventDefault();
    const $form = $(this);
    const nome = $form.find("[name=\"nome\"]").val().trim();
    const area = $form.find("[name=\"area\"]").val().trim();
    const modalidade = $form.find("[name=\"modalidade\"]").val().trim();

    if (!nome || !area || !modalidade) {
        Swal.fire({ icon: "error", title: "Campos obrigatórios!", text: "Preencha Nome, Área e Modalidade", confirmButtonColor: '#1d4ed8' });
        return;
    }

    const centrosCount = $('#centrosContainerModal').find('.centro-id-modal').length;
    if (centrosCount === 0) {
        Swal.fire({ icon: "error", title: "Erro!", text: "Adicione pelo menos um centro", confirmButtonColor: '#1d4ed8' });
        return;
    }

    let centroValido = true;
    $('#centrosContainerModal').find('.centro-card').each(function() {
        const centroId = $(this).find('.centro-id-modal').val();
        const preco = parseFloat($(this).find('.preco-modal').val());
        if (!centroId || isNaN(preco) || preco <= 0) { centroValido = false; return false; }
    });

    if (!centroValido) {
        Swal.fire({ icon: "error", title: "Erro!", text: "Preencha todos os dados dos centros (Centro, Preço)", confirmButtonColor: '#1d4ed8' });
        return;
    }

    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('descricao', $form.find("[name=\"descricao\"]").val().trim());
    formData.append('programa', $form.find("[name=\"programa\"]").val().trim());
    formData.append('area', area);
    formData.append('modalidade', modalidade);
    formData.append('ativo', $form.find("[name=\"ativo\"]").is(":checked") ? 1 : 0);

    const imagemFile = $form.find("[name=\"imagem\"]")[0].files[0];
    if (imagemFile) formData.append('imagem', imagemFile);

    let index = 0;
    $('#centrosContainerModal').find('.centro-card').each(function() {
        const centroId = $(this).find('.centro-id-modal').val();
        const preco = parseFloat($(this).find('.preco-modal').val());
        formData.append(`centro_curso[${index}][centro_id]`, centroId);
        formData.append(`centro_curso[${index}][preco]`, preco);
        index++;
    });

    $.ajax({
        url: `/cursos`,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content"),
            "Accept": "application/json"
        },
        success: function(response) {
            $("#modalNovoCurso").modal("hide");
            $form[0].reset();
            Swal.fire({
                icon: "success", title: "Sucesso!", text: "Curso criado com sucesso!",
                timer: 2000, showConfirmButton: false,
                toast: true, position: 'top-end',
                background: '#16a34a', color: '#fff'
            }).then(() => carregarCursos());
        },
        error: function(xhr) {
            let message = "Erro desconhecido";
            if (xhr.responseJSON?.errors) message = Object.values(xhr.responseJSON.errors).flat().join("\n");
            else if (xhr.responseJSON?.message) message = xhr.responseJSON.message;
            Swal.fire({ icon: "error", title: "Erro!", text: message || "Erro ao criar curso.", confirmButtonColor: '#1d4ed8' });
        }
    });
});

function aplicarFiltros() {
    const nome = $('#filtroNome').val() || '';
    const modalidade = $('#filtroModalidade').val() || '';
    const ativo = $('#filtroStatus').val() || '';
    let url = '/cursos?';
    if (nome) url += `nome=${encodeURIComponent(nome)}&`;
    if (modalidade) url += `modalidade=${encodeURIComponent(modalidade)}&`;
    if (ativo !== '') url += `ativo=${ativo}`;
    window.location.href = url;
}

function limparFiltros() {
    $('#filtroNome').val('');
    $('#filtroModalidade').val('');
    $('#filtroStatus').val('');
    window.location.href = '/cursos';
}

function carregarCursos() { location.reload(); }

function eliminarCurso(id) {
    Swal.fire({
        title: 'Eliminar curso?',
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
                url: `/cursos/${id}`,
                method: 'DELETE',
                headers: {
                    "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content"),
                    "Accept": "application/json"
                },
                success: function() {
                    Swal.fire({
                        icon: 'success', title: 'Eliminado!', text: 'Curso eliminado com sucesso.',
                        timer: 2000, showConfirmButton: false,
                        toast: true, position: 'top-end',
                        background: '#16a34a', color: '#fff'
                    });
                    carregarCursos();
                },
                error: function(xhr) {
                    let message = 'Ocorreu um erro ao eliminar o curso.';
                    if (xhr.responseJSON?.message) message = xhr.responseJSON.message;
                    Swal.fire({ icon: 'error', title: 'Erro!', text: message, confirmButtonColor: '#1d4ed8' });
                }
            });
        }
    });
}
</script>
@endsection
