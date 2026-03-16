@extends('layouts.app')

@section('title', 'Gerenciar Turma - ' . $turma->curso->nome)

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
    .pi-btn-success { background: var(--pi-success); color: #fff; }
    .pi-btn-outline { background: transparent; color: var(--pi-text-muted); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); }
    .pi-btn-outline:hover { background: var(--pi-bg); color: var(--pi-text); }

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
    .pi-badge-planeada { background: rgba(100,116,139,0.08); color: #475569; }
    .pi-badge-inscricoes { background: var(--pi-success-light); color: #15803d; }
    .pi-badge-andamento { background: var(--pi-info-light); color: #0369a1; }
    .pi-badge-concluida { background: rgba(30,41,59,0.08); color: #1e293b; }
    .pi-badge-periodo { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-badge-dia { background: var(--pi-info-light); color: #0369a1; font-size: 0.625rem; padding: 0.0625rem 0.375rem; }
    .pi-badge-pub-sim { background: var(--pi-success-light); color: #15803d; }
    .pi-badge-pub-nao { background: rgba(100,116,139,0.08); color: #475569; }
    .pi-badge-pendente { background: var(--pi-warning-light); color: #92400e; }
    .pi-badge-confirmado { background: var(--pi-success-light); color: #15803d; }
    .pi-badge-cancelado { background: var(--pi-danger-light); color: #b91c1c; }
    .pi-badge-success { background: var(--pi-success-light); color: #15803d; }
    .pi-badge-secondary { background: rgba(100,116,139,0.08); color: #475569; }

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
    .pi-action-btn.accept { background: transparent; color: var(--pi-success); border: 1px solid var(--pi-success); }
    .pi-action-btn.accept:hover { background: var(--pi-success); color: #fff; }
    .pi-action-btn.reject { background: transparent; color: var(--pi-danger); border: 1px solid var(--pi-danger); }
    .pi-action-btn.reject:hover { background: var(--pi-danger); color: #fff; }

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
    $statusClasses = [
        'planeada' => 'pi-badge-planeada',
        'inscricoes_abertas' => 'pi-badge-inscricoes',
        'em_andamento' => 'pi-badge-andamento',
        'concluida' => 'pi-badge-concluida'
    ];
    $statusNomes = [
        'planeada' => 'Planeada',
        'inscricoes_abertas' => 'Inscrições Abertas',
        'em_andamento' => 'Em Andamento',
        'concluida' => 'Concluída'
    ];
    $periodoIcones = [
        'manha' => 'fas fa-sun',
        'tarde' => 'fas fa-cloud-sun',
        'noite' => 'fas fa-moon'
    ];
    $totalInscricoes = $turma->preInscricoes->count();
    $pendentes = $turma->preInscricoes->where('status', 'pendente')->count();
    $confirmados = $turma->preInscricoes->where('status', 'confirmado')->count();
    $cancelados = $turma->preInscricoes->where('status', 'cancelado')->count();
@endphp

<div class="pi-page">

    {{-- BLUE HEADER --}}
    <div class="pi-page-header">
        <div class="pi-breadcrumb-bar">
            <a href="{{ route('turmas.index') }}"><i class="fas fa-chalkboard-teacher me-1"></i>Turmas</a>
            <span class="sep"><i class="fas fa-chevron-right" style="font-size:0.5rem"></i></span>
            <span>{{ $turma->curso->nome }}</span>
        </div>
        <div class="pi-header-row">
            <div style="display:flex;align-items:center;gap:0.625rem;min-width:0">
                <i class="fas fa-chalkboard fa-lg" style="opacity:0.9;flex-shrink:0"></i>
                <div style="min-width:0">
                    <h1>{{ $turma->curso->nome }}</h1>
                    <div style="display:flex;gap:0.375rem;margin-top:0.25rem;flex-wrap:wrap">
                        <span class="pi-badge" style="background:rgba(255,255,255,0.2);color:#fff">
                            {{ $statusNomes[$turma->status] ?? 'N/A' }}
                        </span>
                        <span class="pi-badge" style="background:rgba(255,255,255,0.15);color:#fff">
                            <i class="{{ $periodoIcones[$turma->periodo] ?? 'fas fa-clock' }}"></i>
                            {{ ucfirst($turma->periodo) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="pi-header-actions">
                <button class="pi-btn pi-btn-white" data-bs-toggle="modal" data-bs-target="#modalEditarTurmaShow">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button class="pi-btn pi-btn-danger-outline" onclick="eliminarTurmaShow({{ $turma->id }})">
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
                <a href="{{ route('turmas.index') }}" class="pi-btn pi-btn-ghost">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    {{-- STATS BAR --}}
    <div class="pi-stats-bar">
        <div class="pi-stat">
            <div class="pi-stat-icon blue"><i class="fas fa-users"></i></div>
            <div>
                <div class="pi-stat-label">Total Pré-inscrições</div>
                <div class="pi-stat-value" style="color:var(--pi-primary)">{{ $totalInscricoes }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon orange"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div class="pi-stat-label">Pendentes</div>
                <div class="pi-stat-value" style="color:var(--pi-warning)">{{ $pendentes }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="pi-stat-label">Confirmados</div>
                <div class="pi-stat-value" style="color:var(--pi-success)">{{ $confirmados }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon cyan"><i class="fas fa-chair"></i></div>
            <div>
                <div class="pi-stat-label">Vagas</div>
                <div class="pi-stat-value" style="color:var(--pi-info)">{{ $turma->vagas_preenchidas ?? 0 }}/{{ $turma->vagas_totais ?? '∞' }}</div>
            </div>
        </div>
    </div>

    {{-- INFORMAÇÕES DA TURMA --}}
    <div class="pi-card">
        <div class="pi-card-header">
            <h2><i class="fas fa-info-circle" style="color:var(--pi-primary)"></i> Informações da Turma</h2>
        </div>
        <div class="pi-card-body">
            <div class="pi-info-grid">
                <div class="pi-info-item">
                    <span class="pi-info-label"><i class="fas fa-book me-1"></i>Curso</span>
                    <span class="pi-info-value">{{ $turma->curso->nome ?? 'N/A' }}</span>
                </div>
                <div class="pi-info-item">
                    <span class="pi-info-label"><i class="fas fa-building me-1"></i>Centro</span>
                    <span class="pi-info-value">{{ $turma->centro->nome ?? '—' }}</span>
                </div>
                <div class="pi-info-item">
                    <span class="pi-info-label"><i class="fas fa-user-tie me-1"></i>Formador</span>
                    <span class="pi-info-value">
                        @if($turma->formador)
                            <span style="color:var(--pi-success);font-weight:500"><i class="fas fa-user-tie me-1" style="font-size:0.625rem"></i>{{ $turma->formador->nome }}</span>
                        @else
                            <span class="pi-badge" style="background:var(--pi-warning-light);color:#92400e"><i class="fas fa-exclamation-triangle"></i> Não atribuído</span>
                        @endif
                    </span>
                </div>

                <div class="pi-info-item">
                    <span class="pi-info-label"><i class="fas fa-calendar-day me-1"></i>Dias</span>
                    <span class="pi-info-value">
                        @if($turma->dia_semana && is_array($turma->dia_semana))
                            @foreach($turma->dia_semana as $dia)
                                <span class="pi-badge pi-badge-dia">{{ substr($dia, 0, 3) }}</span>
                            @endforeach
                        @else
                            —
                        @endif
                    </span>
                </div>
                <div class="pi-info-item">
                    <span class="pi-info-label"><i class="{{ $periodoIcones[$turma->periodo] ?? 'fas fa-clock' }} me-1"></i>Período</span>
                    <span class="pi-info-value">
                        <span class="pi-badge pi-badge-periodo">
                            <i class="{{ $periodoIcones[$turma->periodo] ?? 'fas fa-clock' }}"></i>
                            {{ ucfirst($turma->periodo) }}
                        </span>
                    </span>
                </div>
                <div class="pi-info-item">
                    <span class="pi-info-label"><i class="fas fa-clock me-1"></i>Horário</span>
                    <span class="pi-info-value">{{ $turma->hora_inicio ?: '—' }} - {{ $turma->hora_fim ?: '—' }}</span>
                </div>

                <div class="pi-info-item">
                    <span class="pi-info-label"><i class="fas fa-hourglass me-1"></i>Duração</span>
                    <span class="pi-info-value">{{ $turma->duracao_semanas ?? 'N/A' }} semana(s)</span>
                </div>
                <div class="pi-info-item">
                    <span class="pi-info-label"><i class="fas fa-calendar me-1"></i>Data Arranque</span>
                    <span class="pi-info-value">{{ \Carbon\Carbon::parse($turma->data_arranque)->format('d/m/Y') }}</span>
                </div>
                <div class="pi-info-item">
                    <span class="pi-info-label"><i class="fas fa-eye me-1"></i>Visibilidade</span>
                    <span class="pi-info-value">
                        @if($turma->publicado)
                            <span class="pi-badge pi-badge-pub-sim"><i class="fas fa-eye me-1"></i>Público</span>
                        @else
                            <span class="pi-badge pi-badge-pub-nao"><i class="fas fa-eye-slash me-1"></i>Privado</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- PRÉ-INSCRIÇÕES --}}
    <div class="pi-card">
        <div class="pi-card-header">
            <h2>
                <i class="fas fa-clipboard-list" style="color:var(--pi-primary)"></i>
                Pré-inscrições Ligadas a Esta Turma
            </h2>
            <span class="count-badge">{{ $totalInscricoes }}</span>
        </div>

        @if($totalInscricoes > 0)
            {{-- Desktop table --}}
            <div class="pi-desktop-table pi-table-wrap">
                <table class="pi-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Observações</th>
                            <th>Data</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($turma->preInscricoes as $inscricao)
                            <tr>
                                <td><strong>{{ $inscricao->nome_completo ?? $inscricao->nome }}</strong></td>
                                <td>
                                    <a href="mailto:{{ $inscricao->email }}" style="color:var(--pi-primary);text-decoration:none">
                                        {{ $inscricao->email }}
                                    </a>
                                </td>
                                <td>
                                    @php
                                        $telefone = $inscricao->telefone ?? (is_array($inscricao->contactos) && count($inscricao->contactos) ? $inscricao->contactos[0] : null);
                                    @endphp
                                    @if($telefone)
                                        <a href="tel:{{ $telefone }}" style="color:var(--pi-text);text-decoration:none">{{ $telefone }}</a>
                                    @else
                                        <span style="color:var(--pi-text-muted)">—</span>
                                    @endif
                                </td>
                                <td style="font-size:0.75rem;color:var(--pi-text-muted)">{{ $inscricao->observacoes ?: '—' }}</td>
                                <td style="font-size:0.75rem;color:var(--pi-text-muted)">{{ \Carbon\Carbon::parse($inscricao->created_at)->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    @if($inscricao->status === 'pendente')
                                        <span class="pi-badge pi-badge-pendente"><i class="fas fa-hourglass-half"></i> Pendente</span>
                                    @elseif($inscricao->status === 'confirmado')
                                        <span class="pi-badge pi-badge-confirmado"><i class="fas fa-check-circle"></i> Confirmado</span>
                                    @elseif($inscricao->status === 'cancelado')
                                        <span class="pi-badge pi-badge-cancelado"><i class="fas fa-times-circle"></i> Cancelado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="pi-actions">
                                        @if($inscricao->status === 'pendente')
                                            <button class="pi-action-btn accept btn-aceitar-inscricao" data-inscricao-id="{{ $inscricao->id }}" title="Aceitar">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="pi-action-btn reject btn-rejeitar-inscricao" data-inscricao-id="{{ $inscricao->id }}" title="Rejeitar">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile cards --}}
            <div class="pi-mobile-cards">
                @foreach($turma->preInscricoes as $inscricao)
                    <div class="pi-mobile-card">
                        <div class="card-top">
                            <span class="card-name">{{ $inscricao->nome_completo ?? $inscricao->nome }}</span>
                            @if($inscricao->status === 'pendente')
                                <span class="pi-badge pi-badge-pendente"><i class="fas fa-hourglass-half"></i> Pendente</span>
                            @elseif($inscricao->status === 'confirmado')
                                <span class="pi-badge pi-badge-confirmado"><i class="fas fa-check-circle"></i> Confirmado</span>
                            @elseif($inscricao->status === 'cancelado')
                                <span class="pi-badge pi-badge-cancelado"><i class="fas fa-times-circle"></i> Cancelado</span>
                            @endif
                        </div>
                        <div class="card-details">
                            <span><i class="fas fa-envelope me-1"></i>{{ $inscricao->email }}</span>
                            @php
                                $telefone = $inscricao->telefone ?? (is_array($inscricao->contactos) && count($inscricao->contactos) ? $inscricao->contactos[0] : null);
                            @endphp
                            @if($telefone)
                                <span><i class="fas fa-phone me-1"></i>{{ $telefone }}</span>
                            @endif
                            @if($inscricao->observacoes)
                                <span><i class="fas fa-comment me-1"></i>{{ $inscricao->observacoes }}</span>
                            @endif
                            <span><i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($inscricao->created_at)->format('d/m/Y') }}</span>
                        </div>
                        @if($inscricao->status === 'pendente')
                            <div class="card-actions">
                                <button class="pi-btn pi-btn-success btn-aceitar-inscricao" data-inscricao-id="{{ $inscricao->id }}" style="font-size:0.6875rem;padding:0.2rem 0.5rem">
                                    <i class="fas fa-check"></i> Aceitar
                                </button>
                                <button class="pi-btn pi-btn-danger btn-rejeitar-inscricao" data-inscricao-id="{{ $inscricao->id }}" style="font-size:0.6875rem;padding:0.2rem 0.5rem">
                                    <i class="fas fa-times"></i> Rejeitar
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="pi-empty">
                <div class="pi-empty-icon"><i class="fas fa-clipboard"></i></div>
                <h3>Nenhuma pré-inscrição</h3>
                <p>Ainda não existem pré-inscrições ligadas a esta turma.</p>
            </div>
        @endif
    </div>

</div>

{{-- MODAL: Editar Turma --}}
<div class="modal fade pi-modal" id="modalEditarTurmaShow" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue"><i class="fas fa-edit"></i></div>
                    <div>
                        <h5 class="modal-title">Editar Turma</h5>
                        <p class="modal-subtitle">{{ $turma->curso->nome }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarTurmaShow" class="pi-form">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="curso_id" value="{{ $turma->curso_id }}">
                    <input type="hidden" id="editTurmaIdShow" name="turma_id" value="{{ $turma->id }}">
                    <input type="hidden" id="centroIdHidden" name="centro_id" value="{{ $turma->centro_id }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-info-circle"></i> Informações da Turma</div>

                            <div class="mb-2">
                                <label class="form-label">Centro <span class="required">*</span></label>
                                <select id="centroIdShow" name="centro_id" class="form-select" required disabled>
                                    <option value="">Selecione o centro</option>
                                </select>
                                <div class="form-text">O centro não pode ser alterado após a criação da turma.</div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Formador</label>
                                <select id="formadorIdShow" name="formador_id" class="form-select">
                                    <option value="">Sem formador</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Período <span class="required">*</span></label>
                                <select id="periodoShow" name="periodo" class="form-select" required>
                                    <option value="manha" {{ $turma->periodo === 'manha' || $turma->periodo === 'manhã' ? 'selected' : '' }}>Manhã</option>
                                    <option value="tarde" {{ $turma->periodo === 'tarde' ? 'selected' : '' }}>Tarde</option>
                                    <option value="noite" {{ $turma->periodo === 'noite' ? 'selected' : '' }}>Noite</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Modalidade <span class="required">*</span></label>
                                <select id="modalidadeShow" name="modalidade" class="form-select" required>
                                    <option value="">Selecione</option>
                                    <option value="presencial" {{ $turma->modalidade === 'presencial' ? 'selected' : '' }}>Presencial</option>
                                    <option value="online" {{ $turma->modalidade === 'online' ? 'selected' : '' }}>Online</option>
                                    <option value="hibrido" {{ $turma->modalidade === 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Status</label>
                                <select id="statusShow" name="status" class="form-select">
                                    <option value="planeada" {{ $turma->status === 'planeada' ? 'selected' : '' }}>Planeada</option>
                                    <option value="inscricoes_abertas" {{ $turma->status === 'inscricoes_abertas' ? 'selected' : '' }}>Inscrições Abertas</option>
                                    <option value="em_andamento" {{ $turma->status === 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                                    <option value="concluida" {{ $turma->status === 'concluida' ? 'selected' : '' }}>Concluída</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-clock"></i> Horário</div>

                            <div class="mb-2">
                                <label class="form-label">Hora Início <span class="required">*</span></label>
                                <input type="time" id="horaInicioShow" name="hora_inicio" class="form-control" value="{{ $turma->hora_inicio }}" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Hora Fim</label>
                                <input type="time" id="horaFimShow" name="hora_fim" class="form-control" value="{{ $turma->hora_fim }}">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Duração (Semanas)</label>
                                <input type="number" id="duracaoShow" name="duracao_semanas" class="form-control" value="{{ $turma->duracao_semanas }}" min="1">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Data Arranque <span class="required">*</span></label>
                                <input type="date" id="dataArranqueShow" name="data_arranque" class="form-control"
                                       value="{{ \Carbon\Carbon::parse($turma->data_arranque)->format('Y-m-d') }}" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Vagas Disponíveis</label>
                                <input type="number" id="vagasTotaisShow" name="vagas_totais" class="form-control" value="{{ $turma->vagas_totais }}" min="1">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Vagas Preenchidas</label>
                                <input type="number" class="form-control" value="{{ $turma->vagas_preenchidas ?? 0 }}" disabled>
                                <div class="form-text">Atualizado automaticamente quando pré-inscrições são confirmadas.</div>
                            </div>

                            <div class="mb-2">
                                <div class="form-check">
                                    <input type="checkbox" id="publicadoShow" name="publicado" class="form-check-input" {{ $turma->publicado ? 'checked' : '' }}>
                                    <label class="form-check-label" for="publicadoShow" style="font-size:0.8125rem">Publicar no site</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <div class="section-title"><i class="fas fa-calendar-week"></i> Dias da Semana</div>
                        <div class="pi-days-grid">
                            @foreach(['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'] as $dia)
                                <label class="pi-day-check">
                                    <input type="checkbox" class="dia-semana-show" name="dia_semana[]" value="{{ $dia }}"
                                           {{ in_array($dia, $turma->dia_semana ?? []) ? 'checked' : '' }}>
                                    {{ $dia }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarTurmaShow" class="btn pi-btn-primary">
                    <i class="fas fa-save me-1"></i> Guardar Alterações
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    carregarCentros();
    carregarFormadores();
    configurarFormulario();
});

function carregarCentros() {
    const cursoId = {{ $turma->curso_id }};
    $.ajax({
        url: '/cursos/' + cursoId,
        method: 'GET',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        success: function(response) {
            const centros = (response.dados && response.dados.centros) || response.centros || [];
            const select = $('#centroIdShow');
            select.empty().append('<option value="">Selecione um centro</option>');
            centros.forEach(function(c) {
                const selected = c.id === {{ $turma->centro_id }} ? 'selected' : '';
                select.append('<option value="' + c.id + '" ' + selected + '>' + c.nome + '</option>');
            });
        },
        error: function(err) {
            console.error('Erro ao carregar centros:', err);
            $('#centroIdShow').html('<option value="">Erro ao carregar centros</option>');
        }
    });
}

function carregarFormadores() {
    $.ajax({
        url: '/formadores',
        method: 'GET',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        success: function(response) {
            const data = Array.isArray(response) ? response : (response.data || []);
            const select = $('#formadorIdShow');
            select.empty().append('<option value="">Sem formador</option>');
            const formadorAtual = {{ $turma->formador_id ?? 'null' }};
            data.forEach(function(f) {
                const selected = f.id === formadorAtual ? 'selected' : '';
                select.append('<option value="' + f.id + '" ' + selected + '>' + f.nome + '</option>');
            });
        },
        error: function(xhr) {
            console.error('Erro ao carregar formadores:', xhr);
        }
    });
}

function configurarFormulario() {
    $('#formEditarTurmaShow').on('submit', function(e) {
        e.preventDefault();

        const turmaId = $('#editTurmaIdShow').val();
        if (!turmaId) {
            Swal.fire({ icon: 'error', title: 'Erro!', text: 'ID da turma não encontrado', confirmButtonColor: '#1d4ed8' });
            return;
        }

        const dias = [];
        $('.dia-semana-show:checked').each(function() { dias.push($(this).val()); });
        if (dias.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'Selecione pelo menos um dia', confirmButtonColor: '#1d4ed8' });
            return;
        }

        const horaInicio = $('#horaInicioShow').val();
        if (!horaInicio) {
            Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'Hora de início é obrigatória', confirmButtonColor: '#1d4ed8' });
            return;
        }

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('curso_id', $('input[name="curso_id"]').val());
        formData.append('centro_id', $('#centroIdHidden').val());
        formData.append('periodo', $('#periodoShow').val());
        formData.append('modalidade', $('#modalidadeShow').val());
        formData.append('status', $('#statusShow').val());
        formData.append('hora_inicio', horaInicio);
        formData.append('hora_fim', $('#horaFimShow').val() || '');
        formData.append('duracao_semanas', $('#duracaoShow').val() || '');
        formData.append('data_arranque', $('#dataArranqueShow').val());
        formData.append('formador_id', $('#formadorIdShow').val() || '');
        formData.append('vagas_totais', $('#vagasTotaisShow').val() || '');
        formData.append('publicado', $('#publicadoShow').is(':checked') ? '1' : '0');
        dias.forEach(function(dia, index) { formData.append('dia_semana[' + index + ']', dia); });

        const $btn = $('button[form="formEditarTurmaShow"]');
        const textoOriginal = $btn.html();
        $btn.prop('disabled', true).html('<span class="pi-spinner"></span> Guardando...');

        $.ajax({
            url: '/turmas/' + turmaId,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarTurmaShow'));
                if (modal) modal.hide();
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Turma atualizada com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
                setTimeout(function() { location.reload(); }, 400);
            },
            error: function(xhr) {
                let mensagem = 'Erro ao atualizar turma';
                if (xhr.responseJSON?.errors) {
                    mensagem = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                } else if (xhr.responseJSON?.message) {
                    mensagem = xhr.responseJSON.message;
                }
                Swal.fire({ icon: 'error', title: 'Erro!', html: mensagem, confirmButtonColor: '#1d4ed8' });
            },
            complete: function() { $btn.prop('disabled', false).html(textoOriginal); }
        });
    });

    $(document).on('click', '.btn-aceitar-inscricao', function() {
        const id = $(this).data('inscricao-id');
        atualizarStatusInscricao(id, 'confirmado');
    });

    $(document).on('click', '.btn-rejeitar-inscricao', function() {
        const id = $(this).data('inscricao-id');
        atualizarStatusInscricao(id, 'cancelado');
    });
}

function atualizarStatusInscricao(id, status) {
    $.ajax({
        url: '/pre-inscricoes/' + id,
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify({ status: status }),
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function() {
            Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Status atualizado', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
            setTimeout(function() { location.reload(); }, 400);
        },
        error: function() {
            Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao atualizar status', confirmButtonColor: '#1d4ed8' });
        }
    });
}

function eliminarTurmaShow(id) {
    Swal.fire({
        title: 'Eliminar turma?',
        text: 'Esta ação é irreversível!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="fas fa-trash me-1"></i> Sim, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then(function(result) {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            $.ajax({
                url: '/turmas/' + id,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function() {
                    Swal.fire({ icon: 'success', title: 'Eliminada!', text: 'Turma eliminada com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' }).then(function() {
                        window.location.href = "{{ route('turmas.index') }}";
                    });
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao eliminar turma', confirmButtonColor: '#1d4ed8' });
                }
            });
        }
    });
}
</script>
@endsection
