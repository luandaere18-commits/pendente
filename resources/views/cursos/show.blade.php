@extends('layouts.app')

@section('title', 'Visualizar Curso - ' . $curso->nome)

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
    .pi-page-header { background: var(--pi-primary-gradient); color: #fff; padding: 1rem 1.5rem; }
    .pi-breadcrumb-bar { display: flex; align-items: center; gap: 0.375rem; font-size: 0.6875rem; margin-bottom: 0.5rem; opacity: 0.8; flex-wrap: wrap; }
    .pi-breadcrumb-bar a { color: #fff; text-decoration: none; font-weight: 500; }
    .pi-breadcrumb-bar a:hover { text-decoration: underline; }
    .pi-breadcrumb-bar .sep { opacity: 0.5; }
    .pi-header-row { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; }
    .pi-header-row h1 { font-size: 1.25rem; font-weight: 700; margin: 0; color: #fff; word-break: break-word; }
    .pi-header-actions { display: flex; gap: 0.375rem; flex-wrap: wrap; }
    .pi-btn { border: none; border-radius: var(--pi-radius); padding: 0.4375rem 0.875rem; font-size: 0.8125rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.375rem; transition: all 0.15s; cursor: pointer; text-decoration: none; white-space: nowrap; }
    .pi-btn-white { background: #fff; color: var(--pi-primary); }
    .pi-btn-white:hover { background: #dbeafe; color: var(--pi-primary); }
    .pi-btn-danger-outline { background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.4); }
    .pi-btn-danger-outline:hover { background: var(--pi-danger); border-color: var(--pi-danger); color: #fff; }
    .pi-btn-ghost { background: rgba(255,255,255,0.1); color: #fff; }
    .pi-btn-ghost:hover { background: rgba(255,255,255,0.2); }
    .pi-btn-primary { background: var(--pi-primary); border: none; color: #fff; border-radius: var(--pi-radius); padding: 0.4375rem 0.875rem; font-size: 0.8125rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.375rem; transition: all 0.15s; cursor: pointer; }
    .pi-btn-primary:hover { background: var(--pi-primary-dark); color: #fff; }
    .pi-btn-sm { padding: 0.3125rem 0.625rem; font-size: 0.75rem; }
    .pi-btn-danger { background: var(--pi-danger); color: #fff; }
    .pi-btn-danger:hover { background: #b91c1c; color: #fff; }
    .pi-btn-outline { background: transparent; color: var(--pi-text-muted); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); }
    .pi-btn-outline:hover { background: var(--pi-bg); color: var(--pi-text); }
    .pi-btn-success { background: var(--pi-success); color: #fff; }
    .pi-btn-warning { background: var(--pi-warning); color: #fff; }

    /* ── STATS BAR ── */
    .pi-stats-bar { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0; background: #fff; border-bottom: 1px solid var(--pi-border); }
    .pi-stat { padding: 0.625rem 1rem; border-right: 1px solid var(--pi-border); display: flex; align-items: center; gap: 0.625rem; min-width: 0; }
    .pi-stat:last-child { border-right: none; }
    .pi-stat-icon { width: 2rem; height: 2rem; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; font-size: 0.8125rem; flex-shrink: 0; }
    .pi-stat-icon.blue { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-stat-icon.green { background: var(--pi-success-light); color: var(--pi-success); }
    .pi-stat-icon.orange { background: var(--pi-warning-light); color: var(--pi-warning); }
    .pi-stat-icon.cyan { background: var(--pi-info-light); color: var(--pi-info); }
    .pi-stat-label { font-size: 0.625rem; font-weight: 500; color: var(--pi-text-muted); text-transform: uppercase; letter-spacing: 0.04em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .pi-stat-value { font-size: 1.25rem; font-weight: 700; line-height: 1; }

    /* ── CARD ── */
    .pi-card { background: #fff; border: 1px solid var(--pi-border); border-radius: var(--pi-radius); box-shadow: var(--pi-shadow); overflow: hidden; margin: 0.75rem; }
    .pi-card-header { border-bottom: 1px solid var(--pi-border); padding: 0.625rem 1rem; display: flex; align-items: center; justify-content: space-between; background: var(--pi-primary-light); flex-wrap: wrap; gap: 0.5rem; }
    .pi-card-header h2 { font-size: 0.8125rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.375rem; color: var(--pi-text); }
    .pi-card-header .count-badge { background: var(--pi-primary); color: #fff; font-size: 0.625rem; font-weight: 700; padding: 0.125rem 0.4375rem; border-radius: 9999px; }
    .pi-card-body { padding: 1rem; }

    /* ── INFO GRID ── */
    .pi-info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; }
    .pi-info-item { display: flex; flex-direction: column; gap: 0.125rem; min-width: 0; }
    .pi-info-label { font-size: 0.625rem; font-weight: 600; color: var(--pi-primary); text-transform: uppercase; letter-spacing: 0.04em; }
    .pi-info-value { font-size: 0.875rem; font-weight: 500; word-break: break-word; }

    /* ── BADGES ── */
    .pi-badge { display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.125rem 0.5rem; border-radius: 9999px; font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.01em; white-space: nowrap; }
    .pi-badge-success { background: var(--pi-success-light); color: #15803d; }
    .pi-badge-secondary { background: rgba(100,116,139,0.08); color: #475569; }
    .pi-badge-info { background: var(--pi-info-light); color: #0369a1; }
    .pi-badge-warning { background: var(--pi-warning-light); color: #92400e; }
    .pi-badge-primary { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-badge-danger { background: var(--pi-danger-light); color: #b91c1c; }
    .pi-badge-dark { background: rgba(30,41,59,0.08); color: #1e293b; }
    .pi-badge-dia { background: var(--pi-info-light); color: #0369a1; font-size: 0.625rem; padding: 0.0625rem 0.375rem; }
    .pi-badge-periodo { background: var(--pi-primary-light); color: var(--pi-primary); }

    /* ── COURSE IMAGE ── */
    .pi-curso-img-container { width: 100%; max-height: 140px; border-radius: var(--pi-radius); overflow: hidden; background: var(--pi-primary-light); cursor: pointer; }
    .pi-curso-img { width: 100%; height: 100%; max-height: 140px; object-fit: cover; display: block; transition: opacity 0.15s; }
    .pi-curso-img:hover { opacity: 0.85; }
    .pi-curso-img-placeholder { width: 100%; height: 100px; border-radius: var(--pi-radius); background: var(--pi-primary-light); display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--pi-primary); gap: 0.25rem; }

    /* ── TABLE ── */
    .pi-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .pi-table { width: 100%; margin: 0; border-collapse: collapse; font-size: 0.8125rem; }
    .pi-table thead th { background: var(--pi-primary); color: #fff; font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; padding: 0.5rem 0.75rem; white-space: nowrap; position: sticky; top: 0; z-index: 5; }
    .pi-table tbody td { padding: 0.5rem 0.75rem; vertical-align: middle; border-bottom: 1px solid #f0f4ff; white-space: nowrap; }
    .pi-table tbody tr { transition: background 0.1s; }
    .pi-table tbody tr:hover { background: var(--pi-primary-light); }
    .pi-table tbody tr:last-child td { border-bottom: none; }

    /* ── ACTION BUTTONS ── */
    .pi-actions { display: flex; align-items: center; justify-content: flex-end; gap: 0.125rem; transition: opacity 0.15s; }
    @media (hover: hover) and (pointer: fine) {
        .pi-actions { opacity: 0; }
        .pi-table tbody tr:hover .pi-actions { opacity: 1; }
    }
    .pi-action-btn { width: 1.75rem; height: 1.75rem; border: none; border-radius: 0.25rem; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s; font-size: 0.75rem; }
    .pi-action-btn.edit { background: transparent; color: var(--pi-primary); border: 1px solid var(--pi-primary); }
    .pi-action-btn.edit:hover { background: var(--pi-primary); color: #fff; }
    .pi-action-btn.delete { background: transparent; color: var(--pi-danger); border: 1px solid var(--pi-danger); }
    .pi-action-btn.delete:hover { background: var(--pi-danger); color: #fff; }

    /* ── TABS ── */
    .pi-tabs { display: flex; border-bottom: 2px solid var(--pi-border); background: var(--pi-primary-light); padding: 0 0.75rem; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .pi-tab { padding: 0.625rem 1rem; font-size: 0.8125rem; font-weight: 500; color: var(--pi-text-muted); cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: all 0.15s; display: inline-flex; align-items: center; gap: 0.375rem; background: none; border-top: none; border-left: none; border-right: none; white-space: nowrap; flex-shrink: 0; }
    .pi-tab:hover { color: var(--pi-primary); }
    .pi-tab.active { color: var(--pi-primary); border-bottom-color: var(--pi-primary); font-weight: 600; background: #fff; border-radius: var(--pi-radius) var(--pi-radius) 0 0; }
    .pi-tab .tab-count { background: var(--pi-primary); color: #fff; font-size: 0.5625rem; font-weight: 700; padding: 0.0625rem 0.375rem; border-radius: 9999px; }
    .pi-tab-content { display: none; }
    .pi-tab-content.active { display: block; }

    /* ── EMPTY STATE ── */
    .pi-empty { text-align: center; padding: 2.5rem 1rem; color: var(--pi-text-muted); }
    .pi-empty-icon { width: 3rem; height: 3rem; border-radius: 0.75rem; background: var(--pi-primary-light); display: inline-flex; align-items: center; justify-content: center; font-size: 1.125rem; margin-bottom: 0.5rem; color: var(--pi-primary); }
    .pi-empty h3 { font-size: 0.9375rem; font-weight: 600; margin-bottom: 0.125rem; color: var(--pi-text); }
    .pi-empty p { font-size: 0.75rem; }

    /* ── MOBILE CARDS ── */
    .pi-mobile-cards { display: none; padding: 0.75rem; }
    .pi-mobile-card { background: #fff; border: 1px solid var(--pi-border); border-radius: var(--pi-radius); padding: 0.625rem; box-shadow: var(--pi-shadow); margin-bottom: 0.5rem; }
    .pi-mobile-card .card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.25rem; gap: 0.5rem; }
    .pi-mobile-card .card-name { font-weight: 600; font-size: 0.875rem; color: var(--pi-text); word-break: break-word; }
    .pi-mobile-card .card-details { display: flex; flex-wrap: wrap; gap: 0.375rem; margin-bottom: 0.5rem; font-size: 0.75rem; color: var(--pi-text-muted); }
    .pi-mobile-card .card-actions { display: flex; gap: 0.375rem; flex-wrap: wrap; }

    /* ── MODAL ── */
    .pi-modal .modal-content { border-radius: var(--pi-radius); border: 1px solid var(--pi-border); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); }
    .pi-modal .modal-header { border-bottom: 1px solid var(--pi-border); padding: 1rem 1.25rem; background: var(--pi-primary-light); }
    .pi-modal .modal-header .header-flex { display: flex; align-items: center; gap: 0.625rem; }
    .pi-modal .modal-header .header-icon { width: 2.25rem; height: 2.25rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .pi-modal .modal-header .header-icon.blue { background: var(--pi-primary); color: #fff; }
    .pi-modal .modal-header .header-icon.green { background: var(--pi-success); color: #fff; }
    .pi-modal .modal-header .header-icon.orange { background: var(--pi-warning); color: #fff; }
    .pi-modal .modal-title { font-size: 0.9375rem; font-weight: 600; margin: 0; color: var(--pi-text); }
    .pi-modal .modal-subtitle { font-size: 0.75rem; color: var(--pi-text-muted); margin: 0; }
    .pi-modal .modal-body { padding: 1rem 1.25rem; }
    .pi-modal .modal-footer { border-top: 1px solid var(--pi-border); padding: 0.75rem 1.25rem; background: var(--pi-bg); }
    .pi-modal .modal-footer .btn { border-radius: var(--pi-radius); font-size: 0.8125rem; font-weight: 500; padding: 0.4375rem 0.875rem; }

    /* ── FORM ── */
    .pi-form .form-label { font-size: 0.75rem; font-weight: 500; margin-bottom: 0.25rem; color: var(--pi-text); }
    .pi-form .form-label .required { color: var(--pi-danger); }
    .pi-form .form-control, .pi-form .form-select { border-radius: var(--pi-radius); border-color: var(--pi-border); font-size: 0.8125rem; height: 2.25rem; }
    .pi-form textarea.form-control { height: auto; }
    .pi-form .form-control:focus, .pi-form .form-select:focus { border-color: var(--pi-primary); box-shadow: 0 0 0 2px var(--pi-primary-light); }
    .pi-form .form-text { font-size: 0.6875rem; color: var(--pi-text-muted); }
    .pi-form .section-title { font-size: 0.75rem; font-weight: 600; color: var(--pi-primary); margin-bottom: 0.625rem; padding-bottom: 0.375rem; border-bottom: 2px solid var(--pi-primary); display: flex; align-items: center; gap: 0.375rem; text-transform: uppercase; letter-spacing: 0.03em; }

    /* ── DAYS GRID ── */
    .pi-days-grid { display: flex; flex-wrap: wrap; gap: 0.375rem; }
    .pi-day-check { display: flex; align-items: center; gap: 0.25rem; font-size: 0.75rem; font-weight: 500; }
    .pi-day-check input[type="checkbox"] { width: 0.875rem; height: 0.875rem; accent-color: var(--pi-primary); }

    /* ── CENTRO CARD ── */
    .pi-centro-card { background: var(--pi-bg); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); padding: 0.75rem; position: relative; }
    .pi-centro-card .centro-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; }
    .pi-centro-card .centro-numero { font-size: 0.625rem; font-weight: 700; color: #fff; background: var(--pi-primary); padding: 0.0625rem 0.4375rem; border-radius: 9999px; }

    /* ── IMAGE PREVIEW ── */
    .pi-img-preview { margin-top: 0.375rem; }
    .pi-img-preview img { max-width: 100px; max-height: 64px; object-fit: cover; border-radius: 0.25rem; border: 2px solid var(--pi-border); cursor: pointer; transition: opacity 0.15s; }
    .pi-img-preview img:hover { opacity: 0.85; }

    /* ── IMAGE LIGHTBOX ── */
    .pi-lightbox-overlay {
        display: none; position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,0,0,0.88); align-items: center; justify-content: center;
        cursor: zoom-out;
    }
    .pi-lightbox-overlay.active { display: flex; }
    .pi-lightbox-overlay img { max-width: 90vw; max-height: 88vh; border-radius: var(--pi-radius); box-shadow: 0 25px 60px rgba(0,0,0,0.5); object-fit: contain; }
    .pi-lightbox-close { position: absolute; top: 1rem; right: 1.25rem; background: rgba(255,255,255,0.15); border: none; color: #fff; width: 2.25rem; height: 2.25rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 1rem; transition: background 0.15s; }
    .pi-lightbox-close:hover { background: rgba(255,255,255,0.3); }

    /* ── PAGINATION ── */
    .pi-pagination-bar { background: var(--pi-primary); color: #fff; padding: 0.375rem 1rem; display: flex; align-items: center; justify-content: center; font-size: 0.6875rem; font-weight: 500; opacity: 0.9; flex-wrap: wrap; gap: 0.5rem; }

    /* ── RESPONSIVE ── */
    @media (max-width: 991.98px) {
        .pi-desktop-table { display: none !important; }
        .pi-mobile-cards { display: block !important; }
        .pi-info-grid { grid-template-columns: repeat(2, 1fr); }
        .pi-stats-bar { grid-template-columns: repeat(2, 1fr); }
        .pi-stat { border-bottom: 1px solid var(--pi-border); }
    }
    @media (max-width: 767.98px) {
        .pi-stats-bar { grid-template-columns: repeat(2, 1fr); }
        .pi-header-row { flex-direction: column; align-items: stretch; }
        .pi-header-actions { justify-content: stretch; }
        .pi-header-actions .pi-btn { flex: 1; justify-content: center; font-size: 0.75rem; }
        .pi-info-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 575.98px) {
        .pi-page-header { padding: 0.75rem; }
        .pi-page-header h1 { font-size: 1.1rem; }
        .pi-card { margin: 0.5rem; }
        .pi-stat { padding: 0.5rem 0.625rem; }
    }
    @media (max-width: 374.98px) {
        .pi-stats-bar { grid-template-columns: 1fr; }
        .pi-stat { border-right: none; }
    }
</style>
@endsection

@section('content')
@php
    $statusColors = [
        'planeada' => 'secondary',
        'inscricoes_abertas' => 'success',
        'em_andamento' => 'info',
        'concluida' => 'dark',
    ];
    $statusLabels = [
        'planeada' => 'Planeada',
        'inscricoes_abertas' => 'Inscrições Abertas',
        'em_andamento' => 'Em Andamento',
        'concluida' => 'Concluída',
    ];
@endphp

<div class="pi-page">

    {{-- BLUE HEADER --}}
    <div class="pi-page-header">
        <div class="pi-breadcrumb-bar">
            <a href="{{ route('cursos.index') }}"><i class="fas fa-graduation-cap me-1"></i>Cursos</a>
            <span class="sep"><i class="fas fa-chevron-right" style="font-size:0.5rem"></i></span>
            <span>{{ $curso->nome }}</span>
        </div>
        <div class="pi-header-row">
            <div style="display:flex;align-items:center;gap:0.625rem;min-width:0">
                <i class="fas fa-graduation-cap fa-lg" style="opacity:0.9;flex-shrink:0"></i>
                <div style="min-width:0">
                    <h1>{{ $curso->nome }}</h1>
                    <div style="display:flex;gap:0.375rem;margin-top:0.25rem">
                        @if($curso->ativo)
                            <span class="pi-badge" style="background:rgba(255,255,255,0.2);color:#fff"><i class="fas fa-check-circle"></i> Ativo</span>
                        @else
                            <span class="pi-badge" style="background:rgba(255,255,255,0.15);color:rgba(255,255,255,0.7)"><i class="fas fa-times-circle"></i> Inativo</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="pi-header-actions">
                <button class="pi-btn pi-btn-white" data-bs-toggle="modal" data-bs-target="#modalEditarCurso">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button class="pi-btn pi-btn-danger-outline btn-eliminar-curso" data-curso-id="{{ $curso->id }}">
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
                <a href="{{ route('cursos.index') }}" class="pi-btn pi-btn-ghost">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    {{-- STATS BAR --}}
    <div class="pi-stats-bar">
        <div class="pi-stat">
            <div class="pi-stat-icon blue"><i class="fas fa-building"></i></div>
            <div><div class="pi-stat-label">Centros</div><div class="pi-stat-value" style="color:var(--pi-primary)">{{ $curso->centros->count() }}</div></div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon green"><i class="fas fa-chalkboard-teacher"></i></div>
            <div><div class="pi-stat-label">Turmas</div><div class="pi-stat-value" style="color:var(--pi-success)">{{ $curso->turmas->count() }}</div></div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon orange"><i class="fas fa-tag"></i></div>
            <div><div class="pi-stat-label">Área</div><div class="pi-stat-value" style="font-size:0.875rem;color:var(--pi-warning)">{{ $curso->area }}</div></div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon cyan"><i class="fas fa-money-bill-wave"></i></div>
            <div>
                <div class="pi-stat-label">Preço Médio</div>
                <div class="pi-stat-value" style="font-size:0.875rem;color:var(--pi-info)">
                    @if($curso->centros->count() > 0)
                        {{ number_format($curso->centros->avg('pivot.preco'), 2, ',', '.') }} Kz
                    @else — @endif
                </div>
            </div>
        </div>
    </div>

    {{-- INFORMAÇÕES DO CURSO --}}
    <div class="pi-card">
        <div class="pi-card-header">
            <h2><i class="fas fa-info-circle" style="color:var(--pi-primary)"></i> Informações do Curso</h2>
        </div>
        <div class="pi-card-body">
            <div class="row g-3">
                <div class="col-md-2 col-sm-3 col-4">
                    @if($curso->imagem_url)
                        <div class="pi-curso-img-container" onclick="abrirLightbox('{{ $curso->imagem_url }}')" title="Clique para ampliar">
                            <img src="{{ $curso->imagem_url }}" alt="{{ $curso->nome }}" class="pi-curso-img">
                        </div>
                    @else
                        <div class="pi-curso-img-placeholder">
                            <i class="fas fa-image fa-lg"></i>
                            <span style="font-size:0.6875rem">Sem imagem</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-10 col-sm-9 col-8">
                    <div class="pi-info-grid">
                        <div class="pi-info-item">
                            <span class="pi-info-label"><i class="fas fa-tag me-1"></i>Área</span>
                            <span class="pi-info-value">{{ $curso->area }}</span>
                        </div>
                        <div class="pi-info-item">
                            <span class="pi-info-label"><i class="fas fa-toggle-on me-1"></i>Status</span>
                            <span class="pi-info-value">
                                @if($curso->ativo)
                                    <span class="pi-badge pi-badge-success"><i class="fas fa-check-circle"></i> Ativo</span>
                                @else
                                    <span class="pi-badge pi-badge-secondary"><i class="fas fa-times-circle"></i> Inativo</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    @if($curso->descricao)
                        <div class="mt-2">
                            <span class="pi-info-label"><i class="fas fa-align-left me-1"></i>Descrição</span>
                            <p style="font-size:0.8125rem;margin-top:0.125rem;color:var(--pi-text);word-break:break-word">{{ $curso->descricao }}</p>
                        </div>
                    @endif
                    @if($curso->programa)
                        <div class="mt-1">
                            <span class="pi-info-label"><i class="fas fa-book me-1"></i>Programa</span>
                            <p style="font-size:0.8125rem;margin-top:0.125rem;color:var(--pi-text);white-space:pre-line;word-break:break-word">{{ $curso->programa }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- TABS: CENTROS / TURMAS --}}
    <div class="pi-card">
        <div class="pi-tabs">
            <button class="pi-tab active" data-tab="centros">
                <i class="fas fa-building"></i> Centros
                <span class="tab-count">{{ $curso->centros->count() }}</span>
            </button>
            <button class="pi-tab" data-tab="turmas">
                <i class="fas fa-chalkboard-teacher"></i> Turmas
                <span class="tab-count">{{ $curso->turmas->count() }}</span>
            </button>
        </div>

        {{-- ABA: CENTROS --}}
        <div class="pi-tab-content active" id="tab-centros">
            <div class="pi-card-header" style="border-top:none">
                <h2><i class="fas fa-building" style="color:var(--pi-primary)"></i> Centros de Formação</h2>
                <button class="pi-btn pi-btn-primary pi-btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionarCentro">
                    <i class="fas fa-plus"></i> Associar
                </button>
            </div>

            @if($curso->centros->count() > 0)
                <div class="pi-desktop-table pi-table-wrap">
                    <table class="pi-table">
                        <thead><tr><th>Nome do Centro</th><th>Preço (Kz)</th><th class="text-end">Ações</th></tr></thead>
                        <tbody>
                            @foreach($curso->centros as $centro)
                                <tr>
                                    <td><strong>{{ $centro->nome }}</strong></td>
                                    <td><span style="color:var(--pi-success);font-weight:600">{{ number_format($centro->pivot->preco, 2, ',', '.') }} Kz</span></td>
                                    <td>
                                        <div class="pi-actions">
                                            <button class="pi-action-btn edit btn-editar-centro" data-centro-id="{{ $centro->id }}" data-centro-nome="{{ $centro->nome }}" data-preco="{{ $centro->pivot->preco }}" title="Editar"><i class="fas fa-edit"></i></button>
                                            <button class="pi-action-btn delete btn-remover-centro" data-centro-id="{{ $centro->id }}" title="Remover"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pi-mobile-cards">
                    @foreach($curso->centros as $centro)
                        <div class="pi-mobile-card">
                            <div class="card-top">
                                <span class="card-name">{{ $centro->nome }}</span>
                                <span class="pi-badge pi-badge-success">{{ number_format($centro->pivot->preco, 2, ',', '.') }} Kz</span>
                            </div>
                            <div class="card-actions">
                                <button class="pi-btn pi-btn-primary btn-editar-centro" style="font-size:0.6875rem;padding:0.2rem 0.5rem" data-centro-id="{{ $centro->id }}" data-centro-nome="{{ $centro->nome }}" data-preco="{{ $centro->pivot->preco }}"><i class="fas fa-edit"></i> Editar</button>
                                <button class="pi-btn pi-btn-danger btn-remover-centro" style="font-size:0.6875rem;padding:0.2rem 0.5rem" data-centro-id="{{ $centro->id }}"><i class="fas fa-trash-alt"></i> Remover</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="pi-empty">
                    <div class="pi-empty-icon"><i class="fas fa-building"></i></div>
                    <h3>Nenhum centro associado</h3>
                    <p>Nenhum centro associado a este curso.</p>
                </div>
            @endif
        </div>

        {{-- ABA: TURMAS --}}
        <div class="pi-tab-content" id="tab-turmas">
            <div class="pi-card-header" style="border-top:none">
                <h2><i class="fas fa-chalkboard-teacher" style="color:var(--pi-primary)"></i> Turmas</h2>
                <button class="pi-btn pi-btn-primary pi-btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionarturma">
                    <i class="fas fa-plus"></i> Nova Turma
                </button>
            </div>

            @if($curso->turmas->count() > 0)
                @php
                    $turmasList = [];
                    foreach($curso->turmas as $t) {
                        if (!empty($t->centro_id)) {
                            $t->centro = $t->centro ?? null;
                            $turmasList[] = $t;
                        } else {
                            foreach($curso->centros as $centro) {
                                $clone = clone $t;
                                $clone->centro = $centro;
                                $clone->centro_preco = $centro->pivot->preco ?? null;
                                $turmasList[] = $clone;
                            }
                        }
                    }
                @endphp

                <div class="pi-desktop-table pi-table-wrap">
                    <table class="pi-table">
                        <thead>
                            <tr>
                                <th>#</th><th>Centro</th><th>Preço</th><th>Dias</th><th>Período</th><th>Arranque</th><th>Formador</th><th>Horário</th><th>Vagas</th><th class="text-center">Status</th><th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($turmasList as $index => $turma)
                                <tr>
                                    <td><span style="color:var(--pi-muted);font-size:0.6875rem">{{ $index + 1 }}</span></td>
                                    <td>@if($turma->centro)<strong style="font-size:0.75rem">{{ $turma->centro->nome }}</strong>@else<span style="color:var(--pi-text-muted);font-size:0.75rem">N/A</span>@endif</td>
                                    <td>@if(isset($turma->centro_preco))<span style="color:var(--pi-success);font-weight:600;font-size:0.75rem">{{ number_format($turma->centro_preco, 2, ',', '.') }} Kz</span>@else<span style="color:var(--pi-text-muted)">—</span>@endif</td>
                                    <td>@if(is_array($turma->dia_semana))@foreach($turma->dia_semana as $dia)<span class="pi-badge pi-badge-dia">{{ substr($dia, 0, 3) }}</span>@endforeach @endif</td>
                                    <td><span class="pi-badge pi-badge-periodo">{{ ucfirst($turma->periodo) }}</span></td>
                                    <td style="font-size:0.75rem">@if($turma->data_arranque)<strong>{{ \Carbon\Carbon::parse($turma->data_arranque)->format('d/m/Y') }}</strong>@else<span style="color:var(--pi-text-muted)">—</span>@endif</td>
                                    <td style="font-size:0.75rem">@if($turma->formador_id)<span style="color:var(--pi-success);font-weight:500"><i class="fas fa-user-tie me-1" style="font-size:0.625rem"></i>{{ $turma->formador->nome ?? 'N/A' }}</span>@else<span class="pi-badge pi-badge-warning"><i class="fas fa-exclamation-triangle"></i> Sem</span>@endif</td>
                                    <td style="font-size:0.6875rem">{{ $turma->hora_inicio ?? '—' }} - {{ $turma->hora_fim ?? '—' }}</td>
                                    <td>@if($turma->vagas_totais)<span style="color:var(--pi-info);font-weight:600;font-size:0.75rem"><i class="fas fa-chair" style="font-size:0.625rem"></i> {{ $turma->vagas_totais }}</span>@else<span style="color:var(--pi-text-muted)">—</span>@endif</td>
                                    <td class="text-center"><span class="pi-badge pi-badge-{{ $statusColors[$turma->status] ?? 'secondary' }}">{{ $statusLabels[$turma->status] ?? $turma->status }}</span></td>
                                    <td>
                                        <div class="pi-actions">
                                            <button class="pi-action-btn edit btn-editar-turma" data-turma-id="{{ $turma->id }}" data-dias="{{ json_encode($turma->dia_semana) }}" data-data-arranque="{{ \Carbon\Carbon::parse($turma->data_arranque)->format('Y-m-d') }}" data-duracao-semanas="{{ $turma->duracao_semanas }}" data-formador-id="{{ $turma->formador_id }}" data-periodo="{{ $turma->periodo }}" data-modalidade="{{ $turma->modalidade }}" data-hora-inicio="{{ $turma->hora_inicio }}" data-hora-fim="{{ $turma->hora_fim }}" data-centro-id="{{ $turma->centro_id }}" data-status="{{ $turma->status }}" data-vagas-totais="{{ $turma->vagas_totais }}" data-publicado="{{ $turma->publicado }}" title="Editar"><i class="fas fa-edit"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pi-mobile-cards">
                    @foreach($turmasList as $index => $turma)
                        <div class="pi-mobile-card">
                            <div class="card-top">
                                <span class="card-name">{{ $turma->centro->nome ?? 'N/A' }}</span>
                                <span class="pi-badge pi-badge-{{ $statusColors[$turma->status] ?? 'secondary' }}">{{ $statusLabels[$turma->status] ?? $turma->status }}</span>
                            </div>
                            <div class="card-details">
                                @if(is_array($turma->dia_semana))
                                    <span><i class="fas fa-calendar-day me-1"></i>{{ implode(', ', array_map(fn($d) => substr($d, 0, 3), $turma->dia_semana)) }}</span>
                                @endif
                                <span><i class="fas fa-clock me-1"></i>{{ $turma->hora_inicio ?? '—' }} - {{ $turma->hora_fim ?? '—' }}</span>
                                <span><i class="fas fa-sun me-1"></i>{{ ucfirst($turma->periodo) }}</span>
                                @if($turma->data_arranque)<span><i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($turma->data_arranque)->format('d/m/Y') }}</span>@endif
                                @if($turma->vagas_totais)<span><i class="fas fa-chair me-1"></i>{{ $turma->vagas_totais }} vagas</span>@endif
                                @if($turma->formador_id)<span><i class="fas fa-user-tie me-1"></i>{{ $turma->formador->nome ?? 'N/A' }}</span>@endif
                            </div>
                            <div class="card-actions">
                                <button class="pi-btn pi-btn-primary btn-editar-turma" style="font-size:0.6875rem;padding:0.2rem 0.5rem" data-turma-id="{{ $turma->id }}" data-dias="{{ json_encode($turma->dia_semana) }}" data-data-arranque="{{ \Carbon\Carbon::parse($turma->data_arranque)->format('Y-m-d') }}" data-duracao-semanas="{{ $turma->duracao_semanas }}" data-formador-id="{{ $turma->formador_id }}" data-periodo="{{ $turma->periodo }}" data-modalidade="{{ $turma->modalidade }}" data-hora-inicio="{{ $turma->hora_inicio }}" data-hora-fim="{{ $turma->hora_fim }}" data-centro-id="{{ $turma->centro_id }}" data-status="{{ $turma->status }}" data-vagas-totais="{{ $turma->vagas_totais }}" data-publicado="{{ $turma->publicado }}"><i class="fas fa-edit"></i> Editar</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="pi-empty">
                    <div class="pi-empty-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h3>Nenhuma turma</h3>
                    <p>Nenhuma turma cadastrada para este curso.</p>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- LIGHTBOX --}}
<div class="pi-lightbox-overlay" id="lightboxOverlay" onclick="fecharLightbox()">
    <button class="pi-lightbox-close" onclick="fecharLightbox()"><i class="fas fa-times"></i></button>
    <img id="lightboxImg" src="" alt="Imagem ampliada" onclick="event.stopPropagation()">
</div>

{{-- MODAL: Editar Curso — tamanho compacto (modal-lg), alinhado com modal de criar --}}
<div class="modal fade pi-modal" id="modalEditarCurso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue"><i class="fas fa-edit"></i></div>
                    <div>
                        <h5 class="modal-title">Editar Curso</h5>
                        <p class="modal-subtitle">{{ $curso->nome }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarCursoAjax" class="pi-form">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-info-circle"></i> Informações</div>
                            <div class="mb-2">
                                <label class="form-label">Nome <span class="required">*</span></label>
                                <input type="text" name="nome" class="form-control" value="{{ $curso->nome }}" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Área <span class="required">*</span></label>
                                <input type="text" name="area" class="form-control" value="{{ $curso->area }}" required>
                            </div>
                            <div class="mb-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="ativo" id="editCursoAtivo" {{ $curso->ativo ? 'checked' : '' }}>
                                    <label class="form-check-label" for="editCursoAtivo" style="font-size:0.8125rem">Ativo</label>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Imagem</label>
                                <input type="file" name="imagem" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif">
                                <div class="form-text">JPEG, PNG, JPG, GIF (máx 2 MB)</div>
                                @if($curso->imagem_url)
                                    <div class="pi-img-preview">
                                        <span style="font-size:0.6875rem;color:var(--pi-text-muted)">Atual:</span>
                                        <img src="{{ $curso->imagem_url }}" alt="{{ $curso->nome }}" onclick="abrirLightbox('{{ $curso->imagem_url }}')" title="Clique para ampliar">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-file-alt"></i> Conteúdo</div>
                            <div class="mb-2">
                                <label class="form-label">Descrição</label>
                                <textarea name="descricao" class="form-control" rows="3">{{ $curso->descricao }}</textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Programa do Curso</label>
                                <textarea name="programa" class="form-control" rows="4">{{ $curso->programa }}</textarea>
                                <div class="form-text">Use quebras de linha para tópicos</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                            <div class="section-title mb-0" style="border:none;padding:0"><i class="fas fa-building"></i> Centros</div>
                            <button type="button" class="pi-btn pi-btn-primary pi-btn-sm" id="adicionarCentroEditBtn"><i class="fas fa-plus"></i> Adicionar</button>
                        </div>
                        <div class="row g-2" id="centrosContainerEdit"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarCursoAjax" class="btn pi-btn-primary"><i class="fas fa-save me-1"></i> Atualizar</button>
            </div>
        </div>
    </div>
</div>

<template id="centroCursoEditTemplate">
    <div class="col-12">
        <div class="pi-centro-card centro-card">
            <div class="centro-header">
                <span class="centro-numero numero-centro-edit">Centro 1</span>
                <button type="button" class="pi-action-btn delete remover-centro-edit" title="Remover"><i class="fas fa-times"></i></button>
            </div>
            <div class="row g-2">
                <div class="col-md-7 col-12">
                    <label class="form-label" style="font-size:0.75rem">Centro <span style="color:var(--pi-danger)">*</span></label>
                    <select class="form-select centro-id-edit" style="border-radius:var(--pi-radius);font-size:0.8125rem" required><option value="">Selecione</option></select>
                </div>
                <div class="col-md-5 col-12">
                    <label class="form-label" style="font-size:0.75rem">Preço (Kz) <span style="color:var(--pi-danger)">*</span></label>
                    <input type="number" class="form-control preco-edit" step="0.01" min="0" placeholder="0,00" style="border-radius:var(--pi-radius);font-size:0.8125rem" required>
                </div>
            </div>
        </div>
    </div>
</template>

{{-- MODAL: Associar Centro --}}
<div class="modal fade pi-modal" id="modalAdicionarCentro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex"><div class="header-icon green"><i class="fas fa-plus"></i></div><h5 class="modal-title">Associar Novo Centro</h5></div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formAdicionarCentroAjax" class="pi-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-7 col-12">
                            <label class="form-label">Centro <span class="required">*</span></label>
                            <select name="centro_id" class="form-select" required>
                                <option value="" disabled selected>Selecione um centro</option>
                                @foreach ($centros ?? [] as $centro)
                                    <option value="{{ $centro->id }}" {{ $curso->centros->contains($centro->id) ? 'disabled' : '' }}>{{ $centro->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5 col-12">
                            <label class="form-label">Preço (Kz) <span class="required">*</span></label>
                            <input type="number" name="preco" class="form-control" step="0.01" min="0" placeholder="0,00" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formAdicionarCentroAjax" class="btn pi-btn-primary"><i class="fas fa-save me-1"></i> Salvar</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Editar Centro --}}
<div class="modal fade pi-modal" id="modalEditarCentro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex"><div class="header-icon blue"><i class="fas fa-edit"></i></div><h5 class="modal-title">Editar Centro: <span id="editCentroNome"></span></h5></div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarCentroAjax" class="pi-form">
                    @csrf
                    <input type="hidden" name="centro_id" id="editCentroId">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Preço (Kz) <span class="required">*</span></label>
                            <input type="number" name="preco" id="editCentroPreco" class="form-control" step="0.01" min="0" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarCentroAjax" class="btn pi-btn-primary"><i class="fas fa-save me-1"></i> Atualizar</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Adicionar Turma --}}
<div class="modal fade pi-modal" id="modalAdicionarturma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex"><div class="header-icon green"><i class="fas fa-plus"></i></div><h5 class="modal-title">Adicionar Turma</h5></div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formAdicionarturmaAjax" class="pi-form">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Dias da Semana <span class="required">*</span></label>
                        <div class="pi-days-grid">
                            @foreach (['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'] as $dia)
                                <label class="pi-day-check"><input type="checkbox" name="dia_semana[]" value="{{ $dia }}"> {{ substr($dia, 0, 3) }}</label>
                            @endforeach
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-4 col-6"><label class="form-label">Data de Arranque <span class="required">*</span></label><input type="date" name="data_arranque" class="form-control" required></div>
                        <div class="col-md-4 col-6"><label class="form-label">Duração (semanas)</label><input type="number" name="duracao_semanas" class="form-control" min="1" placeholder="Ex: 12"></div>
                        <div class="col-md-4 col-6"><label class="form-label">Formador</label><select name="formador_id" class="form-select"><option value="">Sem formador</option>@foreach ($formadores ?? [] as $formador)<option value="{{ $formador->id }}">{{ $formador->nome }}</option>@endforeach</select></div>
                        <div class="col-md-4 col-6"><label class="form-label">Centro <span class="required">*</span></label><select name="centro_id" id="adicionarturmaCentro" class="form-select" required><option value="" disabled selected>Selecione</option></select></div>
                        <div class="col-md-4 col-6"><label class="form-label">Período <span class="required">*</span></label><select name="periodo" class="form-select" required><option value="" disabled selected>Selecione</option><option value="manha">Manha</option><option value="tarde">Tarde</option><option value="noite">Noite</option></select></div>
                        <div class="col-md-4 col-6"><label class="form-label">Modalidade <span class="required">*</span></label><select name="modalidade" class="form-select" required><option value="" disabled selected>Selecione</option><option value="presencial">Presencial</option><option value="online">Online</option><option value="hibrido">Híbrido</option></select></div>
                        <div class="col-md-4 col-6"><label class="form-label">Hora Início</label><input type="time" name="hora_inicio" class="form-control"></div>
                        <div class="col-md-4 col-6"><label class="form-label">Hora Fim</label><input type="time" name="hora_fim" class="form-control"></div>
                        <div class="col-md-4 col-6"><label class="form-label">Status</label><select name="status" class="form-select"><option value="planeada">Planeada</option><option value="inscricoes_abertas">Inscrições Abertas</option><option value="em_andamento">Em Andamento</option><option value="concluida">Concluída</option></select></div>
                        <div class="col-md-4 col-6"><label class="form-label">Vagas Totais <span class="required">*</span></label><input type="number" name="vagas_totais" class="form-control" min="1" required></div>
                        <div class="col-md-12"><div class="form-check"><input type="checkbox" name="publicado" class="form-check-input" id="publicarTurma"><label class="form-check-label" for="publicarTurma" style="font-size:0.8125rem">Publicar Turma</label></div></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formAdicionarturmaAjax" class="btn pi-btn-primary"><i class="fas fa-save me-1"></i> Salvar</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Editar Turma --}}
<div class="modal fade pi-modal" id="modalEditarturma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex"><div class="header-icon orange"><i class="fas fa-edit"></i></div><h5 class="modal-title">Editar Turma</h5></div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarturmaAjax" class="pi-form">
                    @csrf
                    <input type="hidden" name="turma_id" id="editturmaId">
                    <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                    <div class="mb-2">
                        <label class="form-label">Dias da Semana <span class="required">*</span></label>
                        <div class="pi-days-grid">
                            @foreach (['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'] as $dia)
                                <label class="pi-day-check"><input type="checkbox" name="edit_dia_semana[]" value="{{ $dia }}"> {{ substr($dia, 0, 3) }}</label>
                            @endforeach
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-4 col-6"><label class="form-label">Data de Arranque <span class="required">*</span></label><input type="date" name="edit_data_arranque" id="editturmaDataArranque" class="form-control" required></div>
                        <div class="col-md-4 col-6"><label class="form-label">Duração (semanas)</label><input type="number" name="edit_duracao_semanas" id="editturmaDuracao" class="form-control" min="1"></div>
                        <div class="col-md-4 col-6"><label class="form-label">Formador</label><select name="edit_formador_id" id="editturmaFormador" class="form-select"><option value="">Sem formador</option>@foreach ($formadores ?? [] as $formador)<option value="{{ $formador->id }}">{{ $formador->nome }}</option>@endforeach</select></div>
                        <div class="col-md-4 col-6"><label class="form-label">Centro <span class="required">*</span></label><select name="edit_centro_id" id="editturmaCentro" class="form-select" required disabled><option value="" disabled selected>Carregando...</option></select><small class="text-muted d-block mt-1" style="font-size:0.625rem">Centro não pode ser editado</small></div>
                        <div class="col-md-4 col-6"><label class="form-label">Período <span class="required">*</span></label><select name="edit_periodo" id="edittumaPeriodo" class="form-select" required><option value="" disabled>Selecione</option><option value="manha">Manha</option><option value="tarde">Tarde</option><option value="noite">Noite</option></select></div>
                        <div class="col-md-4 col-6"><label class="form-label">Modalidade <span class="required">*</span></label><select name="edit_modalidade" id="editturmaModalidade" class="form-select" required><option value="" disabled>Selecione</option><option value="presencial">Presencial</option><option value="online">Online</option><option value="hibrido">Híbrido</option></select></div>
                        <div class="col-md-4 col-6"><label class="form-label">Hora Início</label><input type="time" name="edit_hora_inicio" id="editturmaHoraInicio" class="form-control"></div>
                        <div class="col-md-4 col-6"><label class="form-label">Hora Fim</label><input type="time" name="edit_hora_fim" id="editturmaHoraFim" class="form-control"></div>
                        <div class="col-md-4 col-6"><label class="form-label">Status</label><select name="edit_status" id="editturmaStatus" class="form-select"><option value="planeada">Planeada</option><option value="inscricoes_abertas">Inscrições Abertas</option><option value="em_andamento">Em Andamento</option><option value="concluida">Concluída</option></select></div>
                        <div class="col-md-4 col-6"><label class="form-label">Vagas Totais <span class="required">*</span></label><input type="number" name="edit_vagas_totais" id="editturmaVagasTotais" class="form-control" min="1" required></div>
                        <div class="col-md-12"><div class="form-check"><input type="checkbox" name="edit_publicado" class="form-check-input" id="editturmaPublicado"><label class="form-check-label" for="editturmaPublicado" style="font-size:0.8125rem">Publicar Turma</label></div></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarturmaAjax" class="btn pi-btn-primary"><i class="fas fa-save me-1"></i> Atualizar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const cursoId = {{ $curso->id }};

// LIGHTBOX
function abrirLightbox(src) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function fecharLightbox() {
    document.getElementById('lightboxOverlay').classList.remove('active');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') fecharLightbox(); });

// TABS
$(document).on('click', '.pi-tab', function() {
    const tab = $(this).data('tab');
    $('.pi-tab').removeClass('active');
    $(this).addClass('active');
    $('.pi-tab-content').removeClass('active');
    $('#tab-' + tab).addClass('active');
});

// Adicionar Centro
$("#formAdicionarCentroAjax").on("submit", function(e) {
    e.preventDefault();
    const $form = $(this);
    const formData = { centro_id: parseInt($form.find("[name='centro_id']").val()), preco: parseFloat($form.find("[name='preco']").val().toString().replace(",", ".")) };
    if (!formData.centro_id) { Swal.fire({ icon: "error", title: "Erro!", text: "Selecione um centro", confirmButtonColor: '#1d4ed8' }); return; }
    $.ajax({
        url: `/cursos/${cursoId}/centros`, type: "POST", data: JSON.stringify(formData), contentType: "application/json",
        headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
        success: function() { $("#modalAdicionarCentro").modal("hide"); Swal.fire({ icon: "success", title: "Sucesso!", text: "Centro associado!", timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' }).then(() => location.reload()); },
        error: function(xhr) { const errors = xhr.responseJSON?.errors || { error: [xhr.responseJSON?.message || "Erro desconhecido"] }; Swal.fire({ icon: "error", title: "Erro!", text: Object.values(errors).flat().join("\n"), confirmButtonColor: '#1d4ed8' }); }
    });
});

// Editar Centro
$(document).on("click", ".btn-editar-centro", function() {
    $("#editCentroId").val($(this).data("centro-id"));
    $("#editCentroNome").text($(this).data("centro-nome"));
    $("#editCentroPreco").val($(this).data("preco"));
    $("#modalEditarCentro").modal("show");
});

$("#formEditarCentroAjax").on("submit", function(e) {
    e.preventDefault();
    const centroId = $(this).find("[name='centro_id']").val();
    const formData = { preco: parseFloat($(this).find("[name='preco']").val().toString().replace(",", ".")) };
    if (!formData.preco) { Swal.fire({ icon: "error", title: "Erro!", text: "Preencha o preço", confirmButtonColor: '#1d4ed8' }); return; }
    $.ajax({
        url: `/cursos/${cursoId}/centros/${centroId}`, type: "PUT", data: JSON.stringify(formData), contentType: "application/json",
        headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
        success: function() { $("#modalEditarCentro").modal("hide"); Swal.fire({ icon: "success", title: "Atualizado!", timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' }).then(() => location.reload()); },
        error: function(xhr) { Swal.fire({ icon: "error", title: "Erro!", text: Object.values(xhr.responseJSON?.errors || { e: [xhr.responseJSON?.message || "Erro"] }).flat().join("\n"), confirmButtonColor: '#1d4ed8' }); }
    });
});

// Remover Centro
$(document).on("click", ".btn-remover-centro", function() {
    const centroId = $(this).data("centro-id");
    Swal.fire({ title: "Desassociar centro?", text: "O centro será desassociado.", icon: "warning", showCancelButton: true, confirmButtonColor: "#dc2626", cancelButtonColor: "#64748b", confirmButtonText: "<i class='fas fa-unlink me-1'></i> Sim!", cancelButtonText: "Cancelar" }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({ url: `/cursos/${cursoId}/centros/${centroId}`, type: "DELETE", headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
                success: function() { Swal.fire({ icon: "success", title: "Desassociado!", timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' }).then(() => location.reload()); },
                error: function(xhr) { Swal.fire({ icon: "error", title: "Erro!", text: Object.values(xhr.responseJSON?.errors || { e: [xhr.responseJSON?.message || "Erro"] }).flat().join("\n"), confirmButtonColor: '#1d4ed8' }); }
            });
        }
    });
});

// Eliminar Curso
$(document).on("click", ".btn-eliminar-curso", function() {
    const id = $(this).data("curso-id");
    Swal.fire({ title: 'Eliminar curso?', text: 'Esta ação é irreversível!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b', confirmButtonText: '<i class="fas fa-trash me-1"></i> Sim, eliminar!', cancelButtonText: 'Cancelar' }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({ url: `/cursos/${id}`, method: 'DELETE', headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"), "Accept": "application/json" },
                success: function() { window.location.href = "{{ route('cursos.index') }}"; },
                error: function(xhr) { Swal.fire({ icon: 'error', title: 'Erro!', text: xhr.responseJSON?.message || 'Erro ao eliminar.', confirmButtonColor: '#1d4ed8' }); }
            });
        }
    });
});

// Adicionar Turma - Popula centros
$("#modalAdicionarturma").on("show.bs.modal", function() {
    $.ajax({ url: `/cursos/${cursoId}`, method: "GET",
        success: function(response) {
            const curso = response.dados || response;
            let options = '<option value="" disabled selected>Selecione</option>';
            if (curso.centros && curso.centros.length > 0) { curso.centros.forEach(function(centro) { options += `<option value="${centro.id}">${centro.nome}</option>`; }); }
            else { options = '<option value="" disabled>Nenhum centro</option>'; }
            $("#adicionarturmaCentro").html(options);
        },
        error: function() { $("#adicionarturmaCentro").html('<option value="" disabled>Erro ao carregar</option>'); }
    });
});

// Adicionar Turma - Submit
$("#formAdicionarturmaAjax").on("submit", function(e) {
    e.preventDefault();
    const $form = $(this);
    const dias = $form.find("input[name='dia_semana[]']:checked").map(function() { return $(this).val(); }).get();
    if (dias.length === 0) { Swal.fire({ icon: "warning", title: "Atenção!", text: "Selecione pelo menos um dia.", confirmButtonColor: '#1d4ed8' }); return; }
    const formData = { curso_id: cursoId, centro_id: $form.find("select[name='centro_id']").val(), dia_semana: dias, data_arranque: $form.find("input[name='data_arranque']").val(), duracao_semanas: $form.find("input[name='duracao_semanas']").val() || null, periodo: $form.find("select[name='periodo']").val(), modalidade: $form.find("select[name='modalidade']").val(), formador_id: $form.find("select[name='formador_id']").val() || null, hora_inicio: $form.find("input[name='hora_inicio']").val() || "", hora_fim: $form.find("input[name='hora_fim']").val() || "", status: $form.find("select[name='status']").val(), vagas_totais: $form.find("input[name='vagas_totais']").val() || null, publicado: $form.find("input[name='publicado']").is(":checked") ? 1 : 0 };
    $.ajax({ url: `/turmas`, type: "POST", data: JSON.stringify(formData), contentType: "application/json", headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
        success: function() { $("#modalAdicionarturma").modal("hide"); Swal.fire({ icon: "success", title: "Sucesso!", text: "Turma adicionada!", timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' }).then(() => location.reload()); },
        error: function(xhr) { Swal.fire({ icon: "error", title: "Erro!", text: Object.values(xhr.responseJSON?.errors || { e: [xhr.responseJSON?.message || "Erro"] }).flat().join("\n"), confirmButtonColor: '#1d4ed8' }); }
    });
});

// Editar Turma
$(document).on("click", ".btn-editar-turma", function() {
    const id = $(this).data("turma-id");
    let dias = $(this).data("dias");
    const dataArranque = $(this).data("data-arranque");
    const centroId = $(this).data("centro-id");
    if (typeof dias === "string") { try { dias = JSON.parse(dias); } catch(e) { dias = []; } }
    $("#editturmaId").val(id);
    if (dataArranque) {
        let df = dataArranque;
        if (typeof dataArranque === 'string' && dataArranque.includes('/')) { const p = dataArranque.split('/'); if (p.length === 3) df = `${p[2]}-${p[1]}-${p[0]}`; }
        $("#editturmaDataArranque").val(df);
    } else { $("#editturmaDataArranque").val(''); }
    $("#editturmaDuracao").val($(this).data("duracao-semanas") || "");
    $("#editturmaFormador").val($(this).data("formador-id") || "");
    $("#edittumaPeriodo").val($(this).data("periodo"));
    $("#editturmaModalidade").val($(this).data("modalidade") || "");
    $("#editturmaHoraInicio").val($(this).data("hora-inicio") || "");
    $("#editturmaHoraFim").val($(this).data("hora-fim") || "");
    $("#editturmaStatus").val($(this).data("status"));
    $("#editturmaVagasTotais").val($(this).data("vagas-totais") || "");
    $("#editturmaPublicado").prop('checked', [1, true, 'true'].includes($(this).data("publicado")));
    $.ajax({ url: `/cursos/${cursoId}`, method: "GET",
        success: function(response) {
            const curso = response.dados || response;
            let options = '<option value="" disabled>Selecione</option>';
            if (curso.centros && curso.centros.length > 0) { curso.centros.forEach(function(centro) { options += `<option value="${centro.id}" ${centro.id == centroId ? 'selected' : ''}>${centro.nome}</option>`; }); }
            else { options = '<option value="" disabled>Nenhum centro</option>'; }
            $("#editturmaCentro").html(options).prop('disabled', true);
        },
        error: function() { $("#editturmaCentro").html('<option value="" disabled>Erro</option>'); }
    });
    $("input[name='edit_dia_semana[]']").prop("checked", false).each(function() { if (dias && dias.includes($(this).val())) $(this).prop("checked", true); });
    $("#modalEditarturma").modal("show");
});

// Atualizar Turma
$("#formEditarturmaAjax").on("submit", function(e) {
    e.preventDefault();
    const $form = $(this);
    const turmaId = $form.find("[name='turma_id']").val();
    const dias = $form.find("input[name='edit_dia_semana[]']:checked").map(function() { return $(this).val(); }).get();
    if (dias.length === 0) { Swal.fire({ icon: "warning", title: "Atenção!", text: "Selecione pelo menos um dia.", confirmButtonColor: '#1d4ed8' }); return; }
    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('curso_id', $form.find("input[name='curso_id']").val());
    formData.append('centro_id', $form.find("select[name='edit_centro_id']").val());
    formData.append('data_arranque', $form.find("input[name='edit_data_arranque']").val());
    formData.append('periodo', $form.find("select[name='edit_periodo']").val());
    formData.append('modalidade', $form.find("select[name='edit_modalidade']").val());
    formData.append('vagas_totais', $form.find("input[name='edit_vagas_totais']").val() || 0);
    const ds = $form.find("input[name='edit_duracao_semanas']").val(); if (ds) formData.append('duracao_semanas', ds);
    const fi = $form.find("select[name='edit_formador_id']").val(); if (fi) formData.append('formador_id', fi);
    const hi = $form.find("input[name='edit_hora_inicio']").val(); if (hi) formData.append('hora_inicio', hi);
    const hf = $form.find("input[name='edit_hora_fim']").val(); if (hf) formData.append('hora_fim', hf);
    const st = $form.find("select[name='edit_status']").val(); if (st) formData.append('status', st);
    formData.append('publicado', $form.find("input[name='edit_publicado']").is(":checked") ? 1 : 0);
    dias.forEach(function(dia, idx) { formData.append(`dia_semana[${idx}]`, dia); });
    $.ajax({ url: `/turmas/${turmaId}`, type: "POST", data: formData, contentType: false, processData: false, headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
        success: function() { $("#modalEditarturma").modal("hide"); Swal.fire({ icon: "success", title: "Atualizado!", timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' }).then(() => location.reload()); },
        error: function(xhr) { Swal.fire({ icon: "error", title: "Erro!", text: Object.values(xhr.responseJSON?.errors || { e: [xhr.responseJSON?.message || "Erro"] }).flat().join("\n"), confirmButtonColor: '#1d4ed8' }); }
    });
});

// Editar Curso - Centros
let centrosEditCount = 0;
let centrosDisponiveisEditList = [];
const cursoDataEdit = {!! json_encode(['id' => $curso->id, 'nome' => $curso->nome, 'ativo' => $curso->ativo, 'centros' => $curso->centros->map(function($centro) { return ['id' => $centro->id, 'nome' => $centro->nome, 'pivot' => ['preco' => $centro->pivot ? $centro->pivot->preco : null]]; })->toArray()]) !!};

function carregarCentrosEdit() {
    $.ajax({ url: '/centros', method: 'GET', success: function(data) { centrosDisponiveisEditList = data || []; }, error: function() { centrosDisponiveisEditList = []; } });
}

$('#modalEditarCurso').on('show.bs.modal', function() {
    const cursoIdValue = $('#formEditarCursoAjax').find("[name='curso_id']").val();
    $('#formEditarCursoAjax')[0].reset();
    $('#formEditarCursoAjax').find("[name='curso_id']").val(cursoIdValue);
    // Restaura valores dos campos após reset
    $('#formEditarCursoAjax').find("[name='nome']").val(cursoDataEdit.nome);
    $('#formEditarCursoAjax').find("[name='area']").val("{{ $curso->area }}");
    if (cursoDataEdit.ativo) $('#editCursoAtivo').prop('checked', true);
    $('#centrosContainerEdit').empty();
    centrosEditCount = 0;
    carregarCentrosEdit();
    setTimeout(function() { carregarCentrosExistentesEdit(); }, 300);
    $(document).on('change', '.centro-id-edit', function() { atualizarOpcoesDisponiveisEdit(); });
    $(document).on('click', '.remover-centro-edit', function(e) { e.preventDefault(); $(this).closest('.col-12').remove(); atualizarNumeroCentrosEdit(); atualizarOpcoesDisponiveisEdit(); });
});

function carregarCentrosExistentesEdit() {
    if (!cursoDataEdit) return;
    const centros = cursoDataEdit.centros || [];
    if (!Array.isArray(centros) || centros.length === 0) { adicionarCentroEdit(); return; }
    centros.forEach((centro, index) => {
        try {
            if (!centro || typeof centro !== 'object') return;
            const template = document.getElementById('centroCursoEditTemplate');
            if (!template) return;
            const clone = template.content.cloneNode(true);
            const wrapper = document.createElement('div');
            wrapper.appendChild(clone);
            let html = wrapper.innerHTML.replace(/numero-centro-edit">Centro 1</, `numero-centro-edit">Centro ${index + 1}<`);
            const colDiv = document.createElement('div');
            colDiv.innerHTML = html;
            $('#centrosContainerEdit').append(colDiv.firstElementChild);
            const lastSelect = $('#centrosContainerEdit').find('.centro-id-edit').last();
            if (centrosDisponiveisEditList && Array.isArray(centrosDisponiveisEditList)) { centrosDisponiveisEditList.forEach(c => { lastSelect.append(`<option value="${c.id}">${c.nome}</option>`); }); }
            lastSelect.val(centro.id);
            let preco = ''; if (centro.pivot && centro.pivot.preco !== undefined) preco = parseFloat(centro.pivot.preco).toFixed(2);
            $('#centrosContainerEdit').find('.preco-edit').last().val(preco);
            lastSelect.prop('disabled', true);
            $('#centrosContainerEdit').find('.preco-edit').last().prop('disabled', true);
            centrosEditCount++;
        } catch(e) { console.error('Erro ao carregar centro:', e); }
    });
    atualizarOpcoesDisponiveisEdit();
}

function adicionarCentroEdit() {
    try {
        const template = document.getElementById('centroCursoEditTemplate');
        if (!template) return;
        const clone = template.content.cloneNode(true);
        const wrapper = document.createElement('div');
        wrapper.appendChild(clone);
        let html = wrapper.innerHTML.replace(/numero-centro-edit">Centro 1</g, `numero-centro-edit">Centro ${centrosEditCount + 1}<`);
        const colDiv = document.createElement('div');
        colDiv.innerHTML = html;
        $('#centrosContainerEdit').append(colDiv.firstElementChild);
        const lastSelect = $('#centrosContainerEdit').find('.centro-id-edit').last();
        centrosDisponiveisEditList.forEach(centro => { lastSelect.append(`<option value="${centro.id}">${centro.nome}</option>`); });
        centrosEditCount++;
        atualizarNumeroCentrosEdit();
        atualizarOpcoesDisponiveisEdit();
    } catch(e) { console.error('Erro:', e); }
}

function atualizarOpcoesDisponiveisEdit() {
    const selecionados = [];
    $('#centrosContainerEdit').find('.centro-id-edit').each(function() { const v = $(this).val(); if (v) selecionados.push(parseInt(v)); });
    $('#centrosContainerEdit').find('.centro-id-edit').each(function() {
        const sel = $(this), atual = parseInt(sel.val());
        sel.find('option').each(function() { const id = parseInt($(this).val()); if (!id) return; $(this).prop('disabled', selecionados.includes(id) && id !== atual); });
    });
}

function atualizarNumeroCentrosEdit() {
    $('#centrosContainerEdit').find('.numero-centro-edit').each((i, b) => { $(b).text('Centro ' + (i + 1)); });
    const btns = $('#centrosContainerEdit').find('.remover-centro-edit');
    btns.prop('disabled', btns.length <= 1);
}

$(document).on('click', '#adicionarCentroEditBtn', function(e) { e.preventDefault(); adicionarCentroEdit(); });

// Formulário Editar Curso
$("#formEditarCursoAjax").on("submit", function(e) {
    e.preventDefault();
    const $form = $(this);
    const cursoId = $form.find("[name='curso_id']").val();
    const nome = $form.find("[name='nome']").val().trim();
    const area = $form.find("[name='area']").val().trim();
    if (!nome || !area) { Swal.fire({ icon: "error", title: "Erro!", text: "Preencha Nome e Área", confirmButtonColor: '#1d4ed8' }); return; }
    const centrosCount = $('#centrosContainerEdit').find('.centro-id-edit').length;
    if (centrosCount === 0) { Swal.fire({ icon: "error", title: "Erro!", text: "Adicione pelo menos um centro", confirmButtonColor: '#1d4ed8' }); return; }
    let valido = true;
    $('#centrosContainerEdit').find('.centro-card').each(function() { if (!$(this).find('.centro-id-edit').val() || !$(this).find('.preco-edit').val()) { valido = false; return false; } });
    if (!valido) { Swal.fire({ icon: "error", title: "Erro!", text: "Preencha todos os dados dos centros", confirmButtonColor: '#1d4ed8' }); return; }
    const imagemFile = $form.find("[name='imagem']")[0].files[0];
    if (imagemFile) {
        const formData = new FormData();
        formData.append('nome', nome); formData.append('descricao', $form.find("[name='descricao']").val() || ""); formData.append('programa', $form.find("[name='programa']").val() || "");
        formData.append('area', area); formData.append('ativo', $form.find("[name='ativo']").is(":checked") ? 1 : 0); formData.append('imagem', imagemFile);
        let idx = 0; $('#centrosContainerEdit').find('.centro-card').each(function() { formData.append(`centro_curso[${idx}][centro_id]`, $(this).find('.centro-id-edit').val()); formData.append(`centro_curso[${idx}][preco]`, $(this).find('.preco-edit').val()); idx++; });
        $.ajax({ url: `/cursos/${cursoId}`, type: "POST", data: formData, contentType: false, processData: false, headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"), "Accept": "application/json", "X-HTTP-Method-Override": "PUT" },
            success: function() { $("#modalEditarCurso").modal("hide"); Swal.fire({ icon: "success", title: "Atualizado!", timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' }).then(() => location.reload()); },
            error: function(xhr) { Swal.fire({ icon: "error", title: "Erro!", text: Object.values(xhr.responseJSON?.errors || { e: [xhr.responseJSON?.message || "Erro"] }).flat().join("\n"), confirmButtonColor: '#1d4ed8' }); }
        });
    } else {
        const fd = { nome, descricao: $form.find("[name='descricao']").val() || "", programa: $form.find("[name='programa']").val() || "", area, ativo: $form.find("[name='ativo']").is(":checked") ? 1 : 0, centro_curso: [] };
        $('#centrosContainerEdit').find('.centro-card').each(function() { fd.centro_curso.push({ centro_id: $(this).find('.centro-id-edit').val(), preco: $(this).find('.preco-edit').val() }); });
        $.ajax({ url: `/cursos/${cursoId}`, type: "PUT", data: JSON.stringify(fd), contentType: "application/json", headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"), "Accept": "application/json" },
            success: function() { $("#modalEditarCurso").modal("hide"); Swal.fire({ icon: "success", title: "Atualizado!", timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' }).then(() => location.reload()); },
            error: function(xhr) { Swal.fire({ icon: "error", title: "Erro!", text: Object.values(xhr.responseJSON?.errors || { e: [xhr.responseJSON?.message || "Erro"] }).flat().join("\n"), confirmButtonColor: '#1d4ed8' }); }
        });
    }
});
</script>
@endsection
