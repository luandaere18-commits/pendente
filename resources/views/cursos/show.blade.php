@extends('layouts.app')

@section('title', 'Visualizar Curso - ' . $curso->nome)

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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
        --pi-info: #0ea5e9;
        --pi-info-light: rgba(14, 165, 233, 0.1);
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

    /* Breadcrumb */
    .pi-breadcrumb { display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; color: var(--pi-text-muted); margin-bottom: 1.25rem; }
    .pi-breadcrumb a { color: var(--pi-primary); text-decoration: none; font-weight: 500; }
    .pi-breadcrumb a:hover { text-decoration: underline; }
    .pi-breadcrumb .separator { color: var(--pi-border); }
    .pi-breadcrumb .current { color: var(--pi-text); font-weight: 500; }

    /* Header */
    .pi-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
    .pi-header-left { display: flex; align-items: center; gap: 0.75rem; }
    .pi-header-icon { width: 3rem; height: 3rem; border-radius: var(--pi-radius); background: var(--pi-primary-light); display: flex; align-items: center; justify-content: center; color: var(--pi-primary); }
    .pi-header h1 { font-size: 1.5rem; font-weight: 700; margin: 0; letter-spacing: -0.01em; }
    .pi-header p { font-size: 0.875rem; color: var(--pi-text-muted); margin: 0; }
    .pi-header-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }

    /* Buttons */
    .pi-btn { border: none; border-radius: 0.5rem; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.15s; cursor: pointer; text-decoration: none; }
    .pi-btn-primary { background: var(--pi-primary); color: #fff; }
    .pi-btn-primary:hover { background: #2a57b3; color: #fff; }
    .pi-btn-danger { background: var(--pi-danger); color: #fff; }
    .pi-btn-danger:hover { background: #c82333; color: #fff; }
    .pi-btn-outline { background: transparent; color: var(--pi-text-muted); border: 1px solid var(--pi-border); }
    .pi-btn-outline:hover { background: #f0f2f5; color: var(--pi-text); }
    .pi-btn-success { background: var(--pi-success); color: #fff; }
    .pi-btn-success:hover { background: #257a55; color: #fff; }
    .pi-btn-warning { background: var(--pi-warning); color: #fff; }
    .pi-btn-warning:hover { background: #c98508; color: #fff; }
    .pi-btn-sm { padding: 0.375rem 0.75rem; font-size: 0.8125rem; }

    /* Stats */
    .pi-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem; margin-bottom: 1.5rem; }
    .pi-stat-card { display: flex; align-items: center; gap: 0.75rem; background: var(--pi-card); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); padding: 0.75rem 1rem; box-shadow: var(--pi-shadow); }
    .pi-stat-card .stat-icon { width: 2.25rem; height: 2.25rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; flex-shrink: 0; }
    .pi-stat-card .stat-icon.blue { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-stat-card .stat-icon.green { background: var(--pi-success-light); color: var(--pi-success); }
    .pi-stat-card .stat-icon.orange { background: var(--pi-warning-light); color: var(--pi-warning); }
    .pi-stat-card .stat-icon.cyan { background: var(--pi-info-light); color: var(--pi-info); }
    .pi-stat-card .stat-content { display: flex; flex-direction: column; }
    .pi-stat-card .stat-label { font-size: 0.75rem; font-weight: 500; color: var(--pi-text-muted); margin-bottom: 0.25rem; }
    .pi-stat-card .stat-value { font-size: 1.5rem; font-weight: 700; }

    /* Card */
    .pi-card { background: var(--pi-card); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); box-shadow: var(--pi-shadow); overflow: hidden; margin-bottom: 1.25rem; }
    .pi-card-header { border-bottom: 1px solid var(--pi-border); padding: 0.75rem 1.25rem; display: flex; align-items: center; justify-content: space-between; }
    .pi-card-header h2 { font-size: 0.875rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.5rem; }
    .pi-card-header .count-badge { background: var(--pi-primary-light); color: var(--pi-primary); font-size: 0.75rem; font-weight: 600; padding: 0.125rem 0.5rem; border-radius: 9999px; }
    .pi-card-body { padding: 1.25rem; }

    /* Info grid */
    .pi-info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    .pi-info-item { display: flex; flex-direction: column; gap: 0.25rem; }
    .pi-info-label { font-size: 0.75rem; font-weight: 500; color: var(--pi-text-muted); text-transform: uppercase; letter-spacing: 0.03em; }
    .pi-info-value { font-size: 0.9375rem; font-weight: 500; }

    /* Badges */
    .pi-badge { display: inline-flex; align-items: center; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.01em; gap: 0.25rem; }
    .pi-badge-success { background: var(--pi-success-light); color: #1e6e49; }
    .pi-badge-secondary { background: rgba(100, 116, 139, 0.1); color: #475569; }
    .pi-badge-info { background: var(--pi-info-light); color: #0369a1; }
    .pi-badge-warning { background: var(--pi-warning-light); color: #92610a; }
    .pi-badge-primary { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-badge-danger { background: var(--pi-danger-light); color: #b91c1c; }
    .pi-badge-dark { background: rgba(30, 41, 59, 0.1); color: #1e293b; }
    .pi-badge-dia { background: var(--pi-info-light); color: #0369a1; font-size: 0.6875rem; }
    .pi-badge-periodo { background: var(--pi-primary-light); color: var(--pi-primary); }

    /* Curso image */
    .pi-curso-img { width: 100%; max-height: 160px; object-fit: cover; border-radius: var(--pi-radius); }
    .pi-curso-img-placeholder { width: 100%; height: 140px; border-radius: var(--pi-radius); background: #f0f2f5; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--pi-text-muted); gap: 0.5rem; }

    /* Table */
    .pi-table { width: 100%; margin: 0; font-size: 0.92rem; }
    .pi-table thead th { background: rgba(51, 102, 204, 0.08); border-bottom: 1px solid var(--pi-border); font-size: 0.82rem; font-weight: 600; color: var(--pi-primary); text-transform: uppercase; letter-spacing: 0.03em; padding: 0.75rem 1rem; white-space: nowrap; }
    .pi-table tbody td { padding: 0.75rem 1rem; vertical-align: middle; border-bottom: 1px solid #f0f2f5; }
    .pi-table tbody tr:hover { background: #f8f9fb; }
    .pi-table tbody tr:last-child td { border-bottom: none; }

    /* Action buttons */
    .pi-actions { display: flex; align-items: center; justify-content: flex-end; gap: 0.25rem; }
    .pi-action-btn { width: 2rem; height: 2rem; border: none; border-radius: 0.375rem; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s; font-size: 0.8125rem; }
    .pi-action-btn.edit { background: transparent; color: var(--pi-primary); border: 1px solid var(--pi-primary); }
    .pi-action-btn.edit:hover { background: var(--pi-primary); color: #fff; }
    .pi-action-btn.delete { background: transparent; color: var(--pi-danger); border: 1px solid var(--pi-danger); }
    .pi-action-btn.delete:hover { background: var(--pi-danger); color: #fff; }

    /* Tabs */
    .pi-tabs { display: flex; border-bottom: 2px solid var(--pi-border); margin-bottom: 0; }
    .pi-tab { padding: 0.75rem 1.25rem; font-size: 0.875rem; font-weight: 500; color: var(--pi-text-muted); cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: all 0.15s; display: inline-flex; align-items: center; gap: 0.5rem; background: none; border-top: none; border-left: none; border-right: none; }
    .pi-tab:hover { color: var(--pi-primary); }
    .pi-tab.active { color: var(--pi-primary); border-bottom-color: var(--pi-primary); font-weight: 600; }
    .pi-tab .tab-count { background: var(--pi-primary-light); color: var(--pi-primary); font-size: 0.6875rem; font-weight: 600; padding: 0.125rem 0.5rem; border-radius: 9999px; }
    .pi-tab-content { display: none; }
    .pi-tab-content.active { display: block; }

    /* Empty state */
    .pi-empty { text-align: center; padding: 3rem 1rem; color: var(--pi-text-muted); }
    .pi-empty-icon { width: 4rem; height: 4rem; border-radius: 1rem; background: #f0f2f5; display: inline-flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem; }
    .pi-empty h3 { font-size: 1rem; font-weight: 500; margin-bottom: 0.25rem; color: var(--pi-text); }
    .pi-empty p { font-size: 0.875rem; }

    /* Mobile cards */
    .pi-mobile-cards { display: none; }
    .pi-mobile-card { background: var(--pi-card); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); padding: 1rem; box-shadow: var(--pi-shadow); margin-bottom: 0.75rem; }
    .pi-mobile-card .card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem; }
    .pi-mobile-card .card-name { font-weight: 600; font-size: 0.9375rem; }
    .pi-mobile-card .card-details { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.75rem; font-size: 0.8125rem; color: var(--pi-text-muted); }
    .pi-mobile-card .card-actions { display: flex; gap: 0.5rem; }

    /* Modal */
    .pi-modal .modal-content { border-radius: var(--pi-radius); border: 1px solid var(--pi-border); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); }
    .pi-modal .modal-header { border-bottom: 1px solid var(--pi-border); padding: 1.25rem 1.5rem; }
    .pi-modal .modal-header .header-flex { display: flex; align-items: center; gap: 0.75rem; }
    .pi-modal .modal-header .header-icon { width: 2.5rem; height: 2.5rem; border-radius: 0.625rem; display: flex; align-items: center; justify-content: center; }
    .pi-modal .modal-header .header-icon.blue { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-modal .modal-header .header-icon.green { background: var(--pi-success-light); color: var(--pi-success); }
    .pi-modal .modal-header .header-icon.orange { background: var(--pi-warning-light); color: var(--pi-warning); }
    .pi-modal .modal-title { font-size: 1rem; font-weight: 600; margin: 0; }
    .pi-modal .modal-body { padding: 1.25rem 1.5rem; }
    .pi-modal .modal-footer { border-top: 1px solid var(--pi-border); padding: 1rem 1.5rem; }
    .pi-modal .modal-footer .btn { border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; padding: 0.5rem 1rem; }

    /* Form */
    .pi-form .form-label { font-size: 0.8125rem; font-weight: 500; margin-bottom: 0.375rem; }
    .pi-form .form-label .required { color: var(--pi-danger); }
    .pi-form .form-control, .pi-form .form-select { border-radius: 0.5rem; border-color: var(--pi-border); font-size: 0.875rem; }
    .pi-form .form-control:focus, .pi-form .form-select:focus { border-color: var(--pi-primary); box-shadow: 0 0 0 3px var(--pi-primary-light); }
    .pi-form .section-title { font-size: 0.8125rem; font-weight: 600; color: var(--pi-primary); margin-bottom: 0.75rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--pi-border); display: flex; align-items: center; gap: 0.5rem; }

    /* Days grid */
    .pi-days-grid { display: flex; flex-wrap: wrap; gap: 0.5rem; }
    .pi-day-check { display: flex; align-items: center; gap: 0.375rem; font-size: 0.8125rem; }
    .pi-day-check input[type="checkbox"] { width: 1rem; height: 1rem; accent-color: var(--pi-primary); }

    /* Centro card in modal */
    .pi-centro-card { background: #f8f9fb; border: 1px solid var(--pi-border); border-radius: 0.5rem; padding: 1rem; position: relative; }
    .pi-centro-card .centro-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem; }
    .pi-centro-card .centro-numero { font-size: 0.75rem; font-weight: 600; color: var(--pi-primary); background: var(--pi-primary-light); padding: 0.125rem 0.5rem; border-radius: 9999px; }

    /* Imagem atual preview */
    .pi-img-preview { margin-top: 0.5rem; }
    .pi-img-preview img { max-width: 120px; max-height: 80px; object-fit: cover; border-radius: 0.375rem; border: 1px solid var(--pi-border); }

    /* Responsive */
    @media (max-width: 991.98px) {
        .pi-desktop-table { display: none !important; }
        .pi-mobile-cards { display: block !important; }
        .pi-info-grid { grid-template-columns: repeat(2, 1fr); }
        .pi-stats { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 767.98px) {
        .pi-stats { grid-template-columns: repeat(2, 1fr); }
        .pi-header { flex-direction: column; align-items: stretch; }
        .pi-header-actions { justify-content: stretch; }
        .pi-header-actions .pi-btn { flex: 1; justify-content: center; }
        .pi-info-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 575.98px) {
        .pi-page { padding: 1rem 0.75rem; }
    }
</style>
@endsection

@section('content')
@php
    $modalidadeClasses = [
        'online' => 'pi-badge-info',
        'presencial' => 'pi-badge-warning',
        'hibrido' => 'pi-badge-primary',
    ];
    $modalidadeIcones = [
        'online' => 'fas fa-globe',
        'presencial' => 'fas fa-building',
        'hibrido' => 'fas fa-laptop-house',
    ];
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

    {{-- BREADCRUMB --}}
    <div class="pi-breadcrumb">
        <a href="{{ route('cursos.index') }}"><i class="fas fa-graduation-cap me-1"></i>Cursos</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">{{ $curso->nome }}</span>
    </div>

    {{-- HEADER --}}
    <div class="pi-header">
        <div class="pi-header-left">
            <div class="pi-header-icon">
                <i class="fas fa-graduation-cap fa-lg"></i>
            </div>
            <div>
                <h1>{{ $curso->nome }}</h1>
                <p>
                    @if($curso->ativo)
                        <span class="pi-badge pi-badge-success"><i class="fas fa-check-circle"></i> Ativo</span>
                    @else
                        <span class="pi-badge pi-badge-secondary"><i class="fas fa-times-circle"></i> Inativo</span>
                    @endif
                    <span class="pi-badge {{ $modalidadeClasses[$curso->modalidade] ?? 'pi-badge-primary' }}">
                        <i class="{{ $modalidadeIcones[$curso->modalidade] ?? 'fas fa-laptop-house' }}"></i>
                        {{ ucfirst($curso->modalidade) }}
                    </span>
                </p>
            </div>
        </div>
        <div class="pi-header-actions">
            <button class="pi-btn pi-btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditarCurso">
                <i class="fas fa-edit"></i> Editar
            </button>
            <button class="pi-btn pi-btn-danger btn-eliminar-curso" data-curso-id="{{ $curso->id }}">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
            <a href="{{ route('cursos.index') }}" class="pi-btn pi-btn-outline">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    {{-- STATS --}}
    <div class="pi-stats">
        <div class="pi-stat-card">
            <div class="stat-icon blue"><i class="fas fa-building"></i></div>
            <div class="stat-content">
                <div class="stat-label">Centros</div>
                <div class="stat-value" style="color: var(--pi-primary);">{{ $curso->centros->count() }}</div>
            </div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-icon green"><i class="fas fa-chalkboard-teacher"></i></div>
            <div class="stat-content">
                <div class="stat-label">Turmas</div>
                <div class="stat-value" style="color: var(--pi-success);">{{ $curso->turmas->count() }}</div>
            </div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-icon orange"><i class="fas fa-tag"></i></div>
            <div class="stat-content">
                <div class="stat-label">Área</div>
                <div class="stat-value" style="font-size: 1rem; color: var(--pi-warning);">{{ $curso->area }}</div>
            </div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-icon cyan"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-content">
                <div class="stat-label">Preço Médio</div>
                <div class="stat-value" style="font-size: 1rem; color: var(--pi-info);">
                    @if($curso->centros->count() > 0)
                        {{ number_format($curso->centros->avg('pivot.preco'), 2, ',', '.') }} Kz
                    @else
                        —
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- INFORMAÇÕES DO CURSO --}}
    <div class="pi-card">
        <div class="pi-card-header">
            <h2><i class="fas fa-info-circle" style="color: var(--pi-primary);"></i> Informações do Curso</h2>
        </div>
        <div class="pi-card-body">
            <div class="row g-3">
                {{-- Imagem --}}
                <div class="col-md-3">
                    @if($curso->imagem_url)
                        <img src="{{ $curso->imagem_url }}" alt="{{ $curso->nome }}" class="pi-curso-img">
                    @else
                        <div class="pi-curso-img-placeholder">
                            <i class="fas fa-image fa-2x"></i>
                            <span style="font-size: 0.8125rem;">Sem imagem</span>
                        </div>
                    @endif
                </div>
                {{-- Detalhes --}}
                <div class="col-md-9">
                    <div class="pi-info-grid">
                        <div class="pi-info-item">
                            <span class="pi-info-label"><i class="fas fa-tag me-1"></i>Área</span>
                            <span class="pi-info-value">{{ $curso->area }}</span>
                        </div>
                        <div class="pi-info-item">
                            <span class="pi-info-label"><i class="fas fa-signal me-1"></i>Modalidade</span>
                            <span class="pi-info-value">
                                <span class="pi-badge {{ $modalidadeClasses[$curso->modalidade] ?? 'pi-badge-primary' }}">
                                    <i class="{{ $modalidadeIcones[$curso->modalidade] ?? 'fas fa-laptop-house' }}"></i>
                                    {{ ucfirst($curso->modalidade) }}
                                </span>
                            </span>
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
                        <div class="mt-3">
                            <span class="pi-info-label"><i class="fas fa-align-left me-1"></i>Descrição</span>
                            <p style="font-size: 0.875rem; margin-top: 0.25rem; color: var(--pi-text);">{{ $curso->descricao }}</p>
                        </div>
                    @endif
                    @if($curso->programa)
                        <div class="mt-2">
                            <span class="pi-info-label"><i class="fas fa-book me-1"></i>Programa</span>
                            <p style="font-size: 0.875rem; margin-top: 0.25rem; color: var(--pi-text); white-space: pre-line;">{{ $curso->programa }}</p>
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
            <div class="pi-card-header" style="border-top: none;">
                <h2><i class="fas fa-building" style="color: var(--pi-primary);"></i> Centros de Formação</h2>
                <button class="pi-btn pi-btn-primary pi-btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionarCentro">
                    <i class="fas fa-plus"></i> Associar Centro
                </button>
            </div>

            @if($curso->centros->count() > 0)
                {{-- Desktop --}}
                <div class="pi-desktop-table">
                    <table class="pi-table">
                        <thead>
                            <tr>
                                <th>Nome do Centro</th>
                                <th>Preço (Kz)</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($curso->centros as $centro)
                                <tr>
                                    <td><strong>{{ $centro->nome }}</strong></td>
                                    <td>
                                        <span style="color: var(--pi-success); font-weight: 600;">
                                            {{ number_format($centro->pivot->preco, 2, ',', '.') }} Kz
                                        </span>
                                    </td>
                                    <td>
                                        <div class="pi-actions">
                                            <button class="pi-action-btn edit btn-editar-centro"
                                                    data-centro-id="{{ $centro->id }}"
                                                    data-centro-nome="{{ $centro->nome }}"
                                                    data-preco="{{ $centro->pivot->preco }}"
                                                    title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="pi-action-btn delete btn-remover-centro"
                                                    data-centro-id="{{ $centro->id }}"
                                                    title="Remover">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile --}}
                <div class="pi-mobile-cards" style="padding: 1rem;">
                    @foreach($curso->centros as $centro)
                        <div class="pi-mobile-card">
                            <div class="card-top">
                                <span class="card-name">{{ $centro->nome }}</span>
                                <span class="pi-badge pi-badge-success">{{ number_format($centro->pivot->preco, 2, ',', '.') }} Kz</span>
                            </div>
                            <div class="card-actions">
                                <button class="pi-btn pi-btn-primary btn-editar-centro" style="font-size: 0.75rem; padding: 0.25rem 0.625rem;"
                                        data-centro-id="{{ $centro->id }}"
                                        data-centro-nome="{{ $centro->nome }}"
                                        data-preco="{{ $centro->pivot->preco }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button class="pi-btn pi-btn-danger btn-remover-centro" style="font-size: 0.75rem; padding: 0.25rem 0.625rem;"
                                        data-centro-id="{{ $centro->id }}">
                                    <i class="fas fa-trash-alt"></i> Remover
                                </button>
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
            <div class="pi-card-header" style="border-top: none;">
                <h2><i class="fas fa-chalkboard-teacher" style="color: var(--pi-primary);"></i> Turmas</h2>
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

                {{-- Desktop --}}
                <div class="pi-desktop-table">
                    <table class="pi-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Centro</th>
                                <th>Preço</th>
                                <th>Dias</th>
                                <th>Período</th>
                                <th>Formador</th>
                                <th>Hora Início</th>
                                <th>Hora Fim</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($turmasList as $index => $turma)
                                <tr>
                                    <td><span style="color: var(--pi-text-muted);">{{ $index + 1 }}</span></td>
                                    <td>
                                        @if($turma->centro)
                                            <strong>{{ $turma->centro->nome }}</strong>
                                        @else
                                            <span style="color: var(--pi-text-muted); font-size: 0.8125rem;">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($turma->centro_preco))
                                            <span style="color: var(--pi-success); font-weight: 600;">{{ number_format($turma->centro_preco, 2, ',', '.') }} Kz</span>
                                        @else
                                            <span style="color: var(--pi-text-muted);">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(is_array($turma->dia_semana))
                                            @foreach($turma->dia_semana as $dia)
                                                <span class="pi-badge pi-badge-dia">{{ substr($dia, 0, 3) }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <span class="pi-badge pi-badge-periodo">{{ ucfirst($turma->periodo) }}</span>
                                    </td>
                                    <td>
                                        @if($turma->formador_id)
                                            <span style="color: var(--pi-success); font-weight: 600;">{{ $turma->formador->nome ?? 'N/A' }}</span>
                                        @else
                                            <span class="pi-badge pi-badge-warning">
                                                <i class="fas fa-exclamation-triangle"></i> Sem formador
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($turma->hora_inicio)
                                            <strong>{{ $turma->hora_inicio }}</strong>
                                        @else
                                            <span style="color: var(--pi-text-muted);">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($turma->hora_fim)
                                            <strong>{{ $turma->hora_fim }}</strong>
                                        @else
                                            <span style="color: var(--pi-text-muted);">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="pi-badge pi-badge-{{ $statusColors[$turma->status] ?? 'secondary' }}">
                                            {{ $statusLabels[$turma->status] ?? $turma->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="pi-actions">
                                            <button class="pi-action-btn edit btn-editar-turma"
                                                    data-turma-id="{{ $turma->id }}"
                                                    data-dias="{{ json_encode($turma->dia_semana) }}"
                                                    data-data-arranque="{{ $turma->data_arranque }}"
                                                    data-duracao-semanas="{{ $turma->duracao_semanas }}"
                                                    data-formador-id="{{ $turma->formador_id }}"
                                                    data-periodo="{{ $turma->periodo }}"
                                                    data-hora-inicio="{{ $turma->hora_inicio }}"
                                                    data-hora-fim="{{ $turma->hora_fim }}"
                                                    data-centro-id="{{ $turma->centro_id }}"
                                                    data-status="{{ $turma->status }}"
                                                    title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile --}}
                <div class="pi-mobile-cards" style="padding: 1rem;">
                    @foreach($turmasList as $index => $turma)
                        <div class="pi-mobile-card">
                            <div class="card-top">
                                <span class="card-name">{{ $turma->centro->nome ?? 'N/A' }}</span>
                                <span class="pi-badge pi-badge-{{ $statusColors[$turma->status] ?? 'secondary' }}">
                                    {{ $statusLabels[$turma->status] ?? $turma->status }}
                                </span>
                            </div>
                            <div class="card-details">
                                @if(is_array($turma->dia_semana))
                                    <span><i class="fas fa-calendar-day me-1"></i>{{ implode(', ', array_map(fn($d) => substr($d, 0, 3), $turma->dia_semana)) }}</span>
                                @endif
                                <span><i class="fas fa-clock me-1"></i>{{ $turma->hora_inicio ?? '—' }} - {{ $turma->hora_fim ?? '—' }}</span>
                                <span><i class="fas fa-sun me-1"></i>{{ ucfirst($turma->periodo) }}</span>
                                @if($turma->formador_id)
                                    <span><i class="fas fa-user-tie me-1"></i>{{ $turma->formador->nome ?? 'N/A' }}</span>
                                @endif
                            </div>
                            <div class="card-actions">
                                <button class="pi-btn pi-btn-primary btn-editar-turma" style="font-size: 0.75rem; padding: 0.25rem 0.625rem;"
                                        data-turma-id="{{ $turma->id }}"
                                        data-dias="{{ json_encode($turma->dia_semana) }}"
                                        data-data-arranque="{{ $turma->data_arranque }}"
                                        data-duracao-semanas="{{ $turma->duracao_semanas }}"
                                        data-formador-id="{{ $turma->formador_id }}"
                                        data-periodo="{{ $turma->periodo }}"
                                        data-hora-inicio="{{ $turma->hora_inicio }}"
                                        data-hora-fim="{{ $turma->hora_fim }}"
                                        data-centro-id="{{ $turma->centro_id }}"
                                        data-status="{{ $turma->status }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
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


{{-- ============================================= --}}
{{-- MODAL: Editar Curso                           --}}
{{-- ============================================= --}}
<div class="modal fade pi-modal" id="modalEditarCurso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div>
                        <h5 class="modal-title">Editar Curso</h5>
                        <p class="mb-0" style="font-size: 0.8125rem; color: var(--pi-text-muted);">{{ $curso->nome }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body">
                <form id="formEditarCursoAjax" class="pi-form">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="curso_id" value="{{ $curso->id }}">

                    <div class="row g-3">
                        {{-- COLUNA ESQUERDA --}}
                        <div class="col-md-6">
                            <div class="section-title">
                                <i class="fas fa-info-circle"></i> Informações do Curso
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nome <span class="required">*</span></label>
                                <input type="text" name="nome" class="form-control" value="{{ $curso->nome }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Área <span class="required">*</span></label>
                                <input type="text" name="area" class="form-control" value="{{ $curso->area }}" required>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-7">
                                    <label class="form-label">Modalidade <span class="required">*</span></label>
                                    <select name="modalidade" class="form-select" required>
                                        <option value="presencial" {{ $curso->modalidade === 'presencial' ? 'selected' : '' }}>Presencial</option>
                                        <option value="online" {{ $curso->modalidade === 'online' ? 'selected' : '' }}>Online</option>
                                        <option value="hibrido" {{ $curso->modalidade === 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                    </select>
                                </div>
                                <div class="col-md-5 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" name="ativo" id="editCursoAtivo" {{ $curso->ativo ? 'checked' : '' }}>
                                        <label class="form-check-label" for="editCursoAtivo">Ativo</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Imagem</label>
                                <input type="file" name="imagem" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif">
                                <div class="form-text">JPEG, PNG, JPG, GIF (máx 2 MB)</div>
                                @if($curso->imagem_url)
                                    <div class="pi-img-preview">
                                        <span style="font-size: 0.75rem; color: var(--pi-text-muted);">Imagem atual:</span>
                                        <img src="{{ $curso->imagem_url }}" alt="{{ $curso->nome }}">
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- COLUNA DIREITA --}}
                        <div class="col-md-6">
                            <div class="section-title">
                                <i class="fas fa-file-alt"></i> Conteúdo
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea name="descricao" class="form-control" rows="4">{{ $curso->descricao }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Programa do Curso</label>
                                <textarea name="programa" class="form-control" rows="6">{{ $curso->programa }}</textarea>
                                <div class="form-text">Use quebras de linha para criar listas ou tópicos</div>
                            </div>
                        </div>
                    </div>

                    {{-- SEÇÃO DE CENTROS --}}
                    <div class="mt-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="section-title mb-0" style="border: none; padding: 0;">
                                <i class="fas fa-building"></i> Centros de Formação
                            </div>
                            <button type="button" class="pi-btn pi-btn-primary pi-btn-sm" id="adicionarCentroEditBtn">
                                <i class="fas fa-plus"></i> Adicionar Centro
                            </button>
                        </div>
                        <div class="row g-2" id="centrosContainerEdit">
                            {{-- centros dinâmicos --}}
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3" style="border-top: 1px solid var(--pi-border);">
                        <button type="button" class="pi-btn pi-btn-outline" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="pi-btn pi-btn-primary">
                            <i class="fas fa-save me-1"></i> Atualizar Curso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Template para Centro no Modal de Edição --}}
<template id="centroCursoEditTemplate">
    <div class="col-12">
        <div class="pi-centro-card centro-card">
            <div class="centro-header">
                <span class="centro-numero numero-centro-edit">Centro 1</span>
                <button type="button" class="pi-action-btn delete remover-centro-edit" title="Remover"><i class="fas fa-times"></i></button>
            </div>
            <div class="row g-2">
                <div class="col-md-7">
                    <label class="form-label" style="font-size: 0.8125rem;">Centro <span style="color: var(--pi-danger);">*</span></label>
                    <select class="form-select centro-id-edit" style="border-radius: 0.5rem; font-size: 0.875rem;" required>
                        <option value="">Selecione um centro</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label" style="font-size: 0.8125rem;">Preço (Kz) <span style="color: var(--pi-danger);">*</span></label>
                    <input type="number" class="form-control preco-edit" step="0.01" min="0" placeholder="0,00" style="border-radius: 0.5rem; font-size: 0.875rem;" required>
                </div>
            </div>
        </div>
    </div>
</template>


{{-- ============================================= --}}
{{-- MODAL: Associar Centro                        --}}
{{-- ============================================= --}}
<div class="modal fade pi-modal" id="modalAdicionarCentro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon green">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h5 class="modal-title">Associar Novo Centro</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="formAdicionarCentroAjax" class="pi-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label">Centro <span class="required">*</span></label>
                            <select name="centro_id" class="form-select" required>
                                <option value="" disabled selected>Selecione um centro</option>
                                @foreach ($centros ?? [] as $centro)
                                    <option value="{{ $centro->id }}" {{ $curso->centros->contains($centro->id) ? 'disabled' : '' }}>
                                        {{ $centro->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Preço (Kz) <span class="required">*</span></label>
                            <input type="number" name="preco" class="form-control" step="0.01" min="0" placeholder="0,00" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formAdicionarCentroAjax" class="btn pi-btn-primary">
                    <i class="fas fa-save me-1"></i> Salvar
                </button>
            </div>
        </div>
    </div>
</div>


{{-- ============================================= --}}
{{-- MODAL: Editar Centro                          --}}
{{-- ============================================= --}}
<div class="modal fade pi-modal" id="modalEditarCentro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h5 class="modal-title">Editar Centro: <span id="editCentroNome"></span></h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
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
                <button type="submit" form="formEditarCentroAjax" class="btn pi-btn-primary">
                    <i class="fas fa-save me-1"></i> Atualizar
                </button>
            </div>
        </div>
    </div>
</div>


{{-- ============================================= --}}
{{-- MODAL: Adicionar Turma                        --}}
{{-- ============================================= --}}
<div class="modal fade pi-modal" id="modalAdicionarturma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon green">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h5 class="modal-title">Adicionar Turma</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="formAdicionarturmaAjax" class="pi-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Dias da Semana <span class="required">*</span></label>
                        <div class="pi-days-grid">
                            @foreach (['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'] as $dia)
                                <label class="pi-day-check">
                                    <input type="checkbox" name="dia_semana[]" value="{{ $dia }}">
                                    {{ substr($dia, 0, 3) }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Data de Arranque <span class="required">*</span></label>
                            <input type="date" name="data_arranque" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Duração (semanas)</label>
                            <input type="number" name="duracao_semanas" class="form-control" min="1" placeholder="Ex: 12">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Formador</label>
                            <select name="formador_id" class="form-select">
                                <option value="">Sem formador atribuído</option>
                                @foreach ($formadores ?? [] as $formador)
                                    <option value="{{ $formador->id }}">{{ $formador->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Centro <span class="required">*</span></label>
                            <select name="centro_id" id="adicionarturmaCentro" class="form-select" required>
                                <option value="" disabled selected>Selecione um centro</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Período <span class="required">*</span></label>
                            <select name="periodo" class="form-select" required>
                                <option value="" disabled selected>Selecione</option>
                                <option value="manha">Manha</option>
                                <option value="tarde">Tarde</option>
                                <option value="noite">Noite</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hora Início</label>
                            <input type="time" name="hora_inicio" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hora Fim</label>
                            <input type="time" name="hora_fim" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="planeada" selected>Planeada</option>
                                <option value="inscricoes_abertas">Inscrições Abertas</option>
                                <option value="em_andamento">Em Andamento</option>
                                <option value="concluida">Concluída</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Vagas Totais</label>
                            <input type="number" name="vagas_totais" class="form-control" min="1" placeholder="Ex: 30">
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input type="checkbox" name="publicado" class="form-check-input" id="addTurmaPublicado">
                                <label class="form-check-label" for="addTurmaPublicado">Publicar Turma</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formAdicionarturmaAjax" class="btn pi-btn-primary">
                    <i class="fas fa-save me-1"></i> Salvar
                </button>
            </div>
        </div>
    </div>
</div>


{{-- ============================================= --}}
{{-- MODAL: Editar Turma                           --}}
{{-- ============================================= --}}
<div class="modal fade pi-modal" id="modalEditarturma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h5 class="modal-title">Editar Turma</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarturmaAjax" class="pi-form">
                    @csrf
                    <input type="hidden" name="turma_id" id="editturmaId">
                    <div class="mb-3">
                        <label class="form-label">Dias da Semana <span class="required">*</span></label>
                        <div class="pi-days-grid">
                            @foreach (['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'] as $dia)
                                <label class="pi-day-check">
                                    <input type="checkbox" name="edit_dia_semana[]" value="{{ $dia }}">
                                    {{ substr($dia, 0, 3) }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Data de Arranque <span class="required">*</span></label>
                            <input type="date" name="edit_data_arranque" id="editturmaDataArranque" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Duração (semanas)</label>
                            <input type="number" name="edit_duracao_semanas" id="editturmaDuracao" class="form-control" min="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Formador</label>
                            <select name="edit_formador_id" id="editturmaFormador" class="form-select">
                                <option value="">Sem formador atribuído</option>
                                @foreach ($formadores ?? [] as $formador)
                                    <option value="{{ $formador->id }}">{{ $formador->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Centro <span class="required">*</span></label>
                            <select name="edit_centro_id" id="edittturmaCentro" class="form-select" required>
                                <option value="" disabled selected>Selecione um centro</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Período <span class="required">*</span></label>
                            <select name="edit_periodo" id="edittumaPeriodo" class="form-select" required>
                                <option value="" disabled>Selecione</option>
                                <option value="manha">Manha</option>
                                <option value="tarde">Tarde</option>
                                <option value="noite">Noite</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hora Início</label>
                            <input type="time" name="edit_hora_inicio" id="editturmaHoraInicio" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hora Fim</label>
                            <input type="time" name="edit_hora_fim" id="editturmaHoraFim" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="edit_status" id="editturmaStatus" class="form-select">
                                <option value="planeada">Planeada</option>
                                <option value="inscricoes_abertas">Inscrições Abertas</option>
                                <option value="em_andamento">Em Andamento</option>
                                <option value="concluida">Concluída</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarturmaAjax" class="btn pi-btn-primary">
                    <i class="fas fa-save me-1"></i> Atualizar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const cursoId = {{ $curso->id }};

// ============================================
// TABS
// ============================================
$(document).on('click', '.pi-tab', function() {
    const tab = $(this).data('tab');
    $('.pi-tab').removeClass('active');
    $(this).addClass('active');
    $('.pi-tab-content').removeClass('active');
    $('#tab-' + tab).addClass('active');
});

// ============================================
// Adicionar Centro - AJAX
// ============================================
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

// ============================================
// Editar Centro - Abre Modal
// ============================================
$(document).on("click", ".btn-editar-centro", function() {
    const id = $(this).data("centro-id");
    const nome = $(this).data("centro-nome");
    const preco = $(this).data("preco");
    
    $("#editCentroId").val(id);
    $("#editCentroNome").text(nome);
    $("#editCentroPreco").val(preco);
    $("#modalEditarCentro").modal("show");
});

// ============================================
// Atualizar Centro - AJAX
// ============================================
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

// ============================================
// Remover Centro - AJAX
// ============================================
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

// ============================================
// Adicionar Turma - Popula centros
// ============================================
$("#modalAdicionarturma").on("show.bs.modal", function() {
    $.ajax({
        url: `/api/cursos/${cursoId}`,
        method: "GET",
        success: function(response) {
            const curso = response.dados || response;
            let options = '<option value="" disabled selected>Selecione um centro</option>';
            if (curso.centros && curso.centros.length > 0) {
                curso.centros.forEach(function(centro) {
                    options += `<option value="${centro.id}">${centro.nome}</option>`;
                });
            } else {
                options = '<option value="" disabled>Nenhum centro associado</option>';
            }
            $("#adicionarturmaCentro").html(options);
        },
        error: function(err) {
            console.error("Erro ao carregar centros:", err);
            $("#adicionarturmaCentro").html('<option value="" disabled>Erro ao carregar centros</option>');
        }
    });
});

// ============================================
// Adicionar Turma - AJAX
// ============================================
$("#formAdicionarturmaAjax").on("submit", function(e) {
    e.preventDefault();
    
    const $form = $(this);
    const dias = $form.find("input[name=\"dia_semana[]\"]:checked").map(function() {
        return $(this).val();
    }).get();
    
    if (dias.length === 0) {
        Swal.fire({ icon: "warning", title: "Atenção!", text: "Selecione pelo menos um dia da semana." });
        return;
    }
    
    const formData = {
        curso_id: cursoId,
        centro_id: $form.find("select[name=\"centro_id\"]").val(),
        dia_semana: dias,
        data_arranque: $form.find("input[name=\"data_arranque\"]").val(),
        duracao_semanas: $form.find("input[name=\"duracao_semanas\"]").val() || null,
        periodo: $form.find("select[name=\"periodo\"]").val(),
        formador_id: $form.find("select[name=\"formador_id\"]").val() || null,
        hora_inicio: $form.find("input[name=\"hora_inicio\"]").val() || "",
        hora_fim: $form.find("input[name=\"hora_fim\"]").val() || "",
        status: $form.find("select[name=\"status\"]").val(),
        vagas_totais: $form.find("input[name=\"vagas_totais\"]").val() || null,
        publicado: $form.find("input[name=\"publicado\"]").is(":checked") ? 1 : 0
    };
    
    const allowedFields = ['curso_id', 'centro_id', 'dia_semana', 'data_arranque', 'duracao_semanas', 'periodo', 'formador_id', 'hora_inicio', 'hora_fim', 'status', 'vagas_totais', 'publicado'];
    const cleanFormData = {};
    allowedFields.forEach(field => {
        if (formData.hasOwnProperty(field)) {
            cleanFormData[field] = formData[field];
        }
    });
    
    $.ajax({
        url: `/api/turmas`,
        type: "POST",
        data: JSON.stringify(cleanFormData),
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
        },
        success: function(response) {
            $("#modalAdicionarturma").modal("hide");
            Swal.fire({ icon: "success", title: "Sucesso!", text: "Turma adicionada com sucesso!", timer: 2000 }).then(() => location.reload());
        },
        error: function(xhr) {
            console.error("Erro:", xhr);
            const errors = xhr.responseJSON?.errors || { error: [xhr.responseJSON?.message || "Erro desconhecido"] };
            const message = Object.values(errors).flat().join("\n");
            Swal.fire({ icon: "error", title: "Erro!", text: message || "Erro ao adicionar turma." });
        }
    });
});

// ============================================
// Editar Turma - Abre Modal
// ============================================
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
    const centroId = $(this).data("centro-id");
    
    if (typeof dias === "string") {
        dias = JSON.parse(dias);
    }
    
    $("#editturmaId").val(id);
    $("#editturmaDataArranque").val(dataArranque);
    $("#editturmaDuracao").val(duracaoSemanas || "");
    $("#editturmaFormador").val(formadorId || "");
    $("#edittumaPeriodo").val(periodo);
    $("#editturmaHoraInicio").val(horaInicio || "");
    $("#editturmaHoraFim").val(horaFim || "");
    $("#editturmaStatus").val(status);
    
    // Popular centros
    $.ajax({
        url: `/api/cursos/${cursoId}`,
        method: "GET",
        success: function(curso) {
            let options = '<option value="">Selecione um centro</option>';
            if (curso.centros && curso.centros.length > 0) {
                curso.centros.forEach(function(centro) {
                    options += `<option value="${centro.id}">${centro.nome}</option>`;
                });
            }
            $("#edittturmaCentro").html(options);
            if (centroId) {
                $("#edittturmaCentro").val(centroId);
            }
        },
        error: function(err) {
            console.error("Erro ao carregar centros:", err);
            $("#edittturmaCentro").html('<option value="">Erro ao carregar centros</option>');
        }
    });
    
    $("input[name=\"edit_dia_semana[]\"]").prop("checked", false).each(function() {
        if (dias && dias.includes($(this).val())) {
            $(this).prop("checked", true);
        }
    });
    
    $("#modalEditarturma").modal("show");
});

// ============================================
// Atualizar Turma - AJAX
// ============================================
$("#formEditarturmaAjax").on("submit", function(e) {
    e.preventDefault();
    const $form = $(this);
    const turmaId = $form.find("[name=\"turma_id\"]").val();
    
    const dias = $form.find("input[name=\"edit_dia_semana[]\"]:checked").map(function() {
        return $(this).val();
    }).get();
    
    if (dias.length === 0) {
        Swal.fire({ icon: "warning", title: "Atenção!", text: "Selecione pelo menos um dia da semana." });
        return;
    }
    
    const formData = {
        centro_id: $form.find("select[name=\"edit_centro_id\"]").val(),
        data_arranque: $form.find("input[name=\"edit_data_arranque\"]").val(),
        duracao_semanas: $form.find("input[name=\"edit_duracao_semanas\"]").val() || null,
        dia_semana: dias,
        periodo: $form.find("select[name=\"edit_periodo\"]").val(),
        formador_id: $form.find("select[name=\"edit_formador_id\"]").val() || null,
        hora_inicio: $form.find("input[name=\"edit_hora_inicio\"]").val() || "",
        hora_fim: $form.find("input[name=\"edit_hora_fim\"]").val() || "",
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
            Swal.fire({ icon: "success", title: "Sucesso!", text: "Turma atualizada com sucesso!", timer: 2000 }).then(() => location.reload());
        },
        error: function(xhr) {
            console.error("Erro:", xhr);
            const errors = xhr.responseJSON?.errors || { error: [xhr.responseJSON?.message || "Erro desconhecido"] };
            const message = Object.values(errors).flat().join("\n");
            Swal.fire({ icon: "error", title: "Erro!", text: message || "Erro ao atualizar turma." });
        }
    });
});

// ============================================
// Modal Editar Curso - Lógica
// ============================================
let centrosEditCount = 0;
let centrosDisponiveisEditList = [];

const cursoDataEdit = {!! json_encode([
    'id' => $curso->id,
    'centros' => $curso->centros
]) !!};

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

$('#modalEditarCurso').on('show.bs.modal', function() {
    const cursoIdValue = $('#formEditarCursoAjax').find("[name=\"curso_id\"]").val();
    $('#formEditarCursoAjax')[0].reset();
    $('#formEditarCursoAjax').find("[name=\"curso_id\"]").val(cursoIdValue);
    $('#centrosContainerEdit').empty();
    centrosEditCount = 0;
    carregarCentrosEdit();
    carregarCentrosExistentesEdit();
    if ($('#centrosContainerEdit').find('.col-12').length === 0) {
        adicionarCentroEdit();
    }
});

function carregarCentrosExistentesEdit() {
    if (!cursoDataEdit || !cursoDataEdit.centros || cursoDataEdit.centros.length === 0) return;
    
    cursoDataEdit.centros.forEach((centro, index) => {
        try {
            const template = document.getElementById('centroCursoEditTemplate');
            if (!template) return;
            const clone = template.content.cloneNode(true);
            const wrapper = document.createElement('div');
            wrapper.appendChild(clone);
            let html = wrapper.innerHTML.replace(/numero-centro-edit">Centro 1</, `numero-centro-edit">Centro ${index + 1}<`);
            const colDiv = document.createElement('div');
            colDiv.innerHTML = html;
            $('#centrosContainerEdit').append(colDiv.firstElementChild);
            
            const selects = $('#centrosContainerEdit').find('.centro-id-edit');
            const lastSelect = selects.last();
            centrosDisponiveisEditList.forEach(c => {
                lastSelect.append(`<option value="${c.id}">${c.nome}</option>`);
            });
            lastSelect.val(centro.id);
            const preco = centro.pivot && centro.pivot.preco ? centro.pivot.preco : '';
            $('#centrosContainerEdit').find('.preco-edit').last().val(preco);
            lastSelect.prop('disabled', true);
            $('#centrosContainerEdit').find('.preco-edit').last().prop('disabled', true);
            centrosEditCount++;
        } catch(e) {
            console.error('Erro ao carregar centro:', e, centro);
        }
    });
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

function atualizarNumeroCentrosEdit() {
    const badges = $('#centrosContainerEdit').find('.numero-centro-edit');
    badges.each((index, badge) => {
        $(badge).text('Centro ' + (index + 1));
    });
    const btnsRemover = $('#centrosContainerEdit').find('.remover-centro-edit');
    btnsRemover.prop('disabled', btnsRemover.length <= 1);
}

$(document).on('click', '#adicionarCentroEditBtn', function(e) {
    e.preventDefault();
    adicionarCentroEdit();
});

$(document).on('click', '.remover-centro-edit', function(e) {
    e.preventDefault();
    $(this).closest('.col-12').remove();
    atualizarNumeroCentrosEdit();
});

// ============================================
// Formulário Editar Curso - Submit
// ============================================
$("#formEditarCursoAjax").on("submit", function(e) {
    e.preventDefault();
    
    const $form = $(this);
    const cursoId = $form.find("[name=\"curso_id\"]").val();
    
    if (!cursoId) {
        Swal.fire("Erro!", "ID do curso não encontrado no formulário", "error");
        return;
    }
    
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
        const formData = new FormData();
        formData.append('nome', nome);
        formData.append('descricao', $form.find("[name=\"descricao\"]").val() || "");
        formData.append('programa', $form.find("[name=\"programa\"]").val() || "");
        formData.append('area', area);
        formData.append('modalidade', modalidade);
        formData.append('ativo', $form.find("[name=\"ativo\"]").is(":checked") ? 1 : 0);
        formData.append('imagem', imagemFile);
        
        let index = 0;
        $('#centrosContainerEdit').find('.centro-card').each(function() {
            const centroId = $(this).find('.centro-id-edit').val();
            const preco = $(this).find('.preco-edit').val();
            formData.append(`centro_curso[${index}][centro_id]`, centroId);
            formData.append(`centro_curso[${index}][preco]`, preco);
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
                $("#modalEditarCurso").modal("hide");
                Swal.fire({ icon: "success", title: "Sucesso!", text: "Curso atualizado com sucesso!", timer: 2000 }).then(() => location.reload());
            },
            error: function(xhr) {
                console.error("Status:", xhr.status);
                console.error("Response:", xhr.responseText);
                let message = "Erro desconhecido";
                if (xhr.responseJSON?.errors) message = Object.values(xhr.responseJSON.errors).flat().join("\n");
                else if (xhr.responseJSON?.message) message = xhr.responseJSON.message;
                else if (xhr.responseJSON?.error) message = xhr.responseJSON.error;
                Swal.fire({ icon: "error", title: "Erro!", text: message || "Erro ao atualizar curso." });
            }
        });
    } else {
        const formData = {
            nome: nome,
            descricao: $form.find("[name=\"descricao\"]").val() || "",
            programa: $form.find("[name=\"programa\"]").val() || "",
            area: area,
            modalidade: modalidade,
            ativo: $form.find("[name=\"ativo\"]").is(":checked") ? 1 : 0,
            centro_curso: []
        };
        
        $('#centrosContainerEdit').find('.centro-card').each(function() {
            const centroId = $(this).find('.centro-id-edit').val();
            const preco = $(this).find('.preco-edit').val();
            formData.centro_curso.push({ centro_id: centroId, preco: preco });
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
                $("#modalEditarCurso").modal("hide");
                Swal.fire({ icon: "success", title: "Sucesso!", text: "Curso atualizado com sucesso!", timer: 2000 }).then(() => location.reload());
            },
            error: function(xhr) {
                console.error("Status:", xhr.status);
                console.error("Response:", xhr.responseText);
                let message = "Erro desconhecido";
                if (xhr.responseJSON?.errors) message = Object.values(xhr.responseJSON.errors).flat().join("\n");
                else if (xhr.responseJSON?.message) message = xhr.responseJSON.message;
                else if (xhr.responseJSON?.error) message = xhr.responseJSON.error;
                Swal.fire({ icon: "error", title: "Erro!", text: message || "Erro ao atualizar curso." });
            }
        });
    }
});

// ============================================
// Inicializar
// ============================================
$(document).ready(function() {
    carregarCentrosEdit();
});

// ============================================
// Eliminar Curso
// ============================================
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
                url: `/cursos/${id}`,
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
