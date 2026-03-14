@extends('layouts.app')

@section('title', 'Gerenciar Turma - ' . $turma->curso->nome)

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

    /* Stats */
    .pi-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem; margin-bottom: 1.5rem; }
    .pi-stat-card { display: flex; align-items: center; gap: 0.75rem; background: var(--pi-card); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); padding: 0.75rem 1rem; box-shadow: var(--pi-shadow); }
    .pi-stat-card .stat-icon { width: 2.25rem; height: 2.25rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; margin-bottom: 0; flex-shrink: 0; }
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
    .pi-badge-planeada { background: rgba(100, 116, 139, 0.1); color: #475569; }
    .pi-badge-inscricoes { background: var(--pi-success-light); color: #1e6e49; }
    .pi-badge-andamento { background: var(--pi-info-light); color: #0369a1; }
    .pi-badge-concluida { background: rgba(30, 41, 59, 0.1); color: #1e293b; }
    .pi-badge-periodo { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-badge-dia { background: var(--pi-info-light); color: #0369a1; font-size: 0.6875rem; }
    .pi-badge-pub-sim { background: var(--pi-success-light); color: #1e6e49; }
    .pi-badge-pub-nao { background: rgba(100, 116, 139, 0.1); color: #475569; }
    .pi-badge-pendente { background: var(--pi-warning-light); color: #92610a; }
    .pi-badge-confirmado { background: var(--pi-success-light); color: #1e6e49; }
    .pi-badge-cancelado { background: var(--pi-danger-light); color: #b91c1c; }

    /* Table */
    .pi-table { width: 100%; margin: 0; font-size: 0.92rem; }
    .pi-table thead th { background: rgba(51, 102, 204, 0.08); border-bottom: 1px solid var(--pi-border); font-size: 0.82rem; font-weight: 600; color: var(--pi-primary); text-transform: uppercase; letter-spacing: 0.03em; padding: 0.75rem 1rem; white-space: nowrap; }
    .pi-table tbody td { padding: 0.75rem 1rem; vertical-align: middle; border-bottom: 1px solid #f0f2f5; }
    .pi-table tbody tr:hover { background: #f8f9fb; }
    .pi-table tbody tr:last-child td { border-bottom: none; }

    /* Action buttons */
    .pi-actions { display: flex; align-items: center; justify-content: flex-end; gap: 0.25rem; }
    .pi-action-btn { width: 2rem; height: 2rem; border: none; border-radius: 0.375rem; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s; font-size: 0.8125rem; }
    .pi-action-btn.accept { background: transparent; color: var(--pi-success); border: 1px solid var(--pi-success); }
    .pi-action-btn.accept:hover { background: var(--pi-success); color: #fff; }
    .pi-action-btn.reject { background: transparent; color: var(--pi-danger); border: 1px solid var(--pi-danger); }
    .pi-action-btn.reject:hover { background: var(--pi-danger); color: #fff; }

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

    /* Responsive */
    @media (max-width: 991.98px) {
        .pi-desktop-table { display: none !important; }
        .pi-mobile-cards { display: block !important; }
        .pi-info-grid { grid-template-columns: repeat(2, 1fr); }
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

    {{-- BREADCRUMB --}}
    <div class="pi-breadcrumb">
        <a href="{{ route('turmas.index') }}"><i class="fas fa-chalkboard-teacher me-1"></i>Turmas</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">{{ $turma->curso->nome }}</span>
    </div>

    {{-- HEADER --}}
    <div class="pi-header">
        <div class="pi-header-left">
            <div class="pi-header-icon">
                <i class="fas fa-chalkboard fa-lg"></i>
            </div>
            <div>
                <h1>{{ $turma->curso->nome }}</h1>
                <p>
                    <span class="pi-badge {{ $statusClasses[$turma->status] ?? 'pi-badge-planeada' }}">
                        {{ $statusNomes[$turma->status] ?? 'N/A' }}
                    </span>
                </p>
            </div>
        </div>
        <div class="pi-header-actions">
            <button class="pi-btn pi-btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditarTurmaShow">
                <i class="fas fa-edit"></i> Editar
            </button>
            <button class="pi-btn pi-btn-danger" onclick="eliminarTurmaShow({{ $turma->id }})">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
            <a href="{{ route('turmas.index') }}" class="pi-btn pi-btn-outline">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    {{-- STATS --}}
    <div class="pi-stats">
        <div class="pi-stat-card">
            <div class="stat-icon blue"><i class="fas fa-users"></i></div>
            <div class="stat-content">
                <div class="stat-label">Total Pré-inscrições</div>
                <div class="stat-value text-primary">{{ $totalInscricoes }}</div>
            </div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-icon orange"><i class="fas fa-hourglass-half"></i></div>
            <div class="stat-content">
                <div class="stat-label">Pendentes</div>
                <div class="stat-value text-warning">{{ $pendentes }}</div>
            </div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-content">
                <div class="stat-label">Confirmados</div>
                <div class="stat-value text-success">{{ $confirmados }}</div>
            </div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-icon cyan"><i class="fas fa-chair"></i></div>
            <div class="stat-content">
                <div class="stat-label">Vagas</div>
                <div class="stat-value text-info">{{ $turma->vagas_preenchidas ?? 0 }}/{{ $turma->vagas_totais ?? '∞' }}</div>
            </div>
        </div>
    </div>

    {{-- INFORMAÇÕES DA TURMA --}}
    <div class="pi-card">
        <div class="pi-card-header">
            <h2><i class="fas fa-info-circle" style="color: var(--pi-primary);"></i> Informações da Turma</h2>
        </div>
        <div class="pi-card-body">
            <div class="pi-info-grid">
                {{-- Linha 1 --}}
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
                            {{ $turma->formador->nome }}
                        @else
                            <span style="color: var(--pi-warning);"><i class="fas fa-exclamation-triangle me-1"></i>Não atribuído</span>
                        @endif
                    </span>
                </div>

                {{-- Linha 2 --}}
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

                {{-- Linha 3 --}}
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
                <i class="fas fa-clipboard-list" style="color: var(--pi-primary);"></i>
                Pré-inscrições Ligadas a Esta Turma
            </h2>
            <span class="count-badge">{{ $totalInscricoes }}</span>
        </div>

        @if($totalInscricoes > 0)
            {{-- Desktop table --}}
            <div class="pi-desktop-table">
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
                                    <a href="mailto:{{ $inscricao->email }}" style="color: var(--pi-primary); text-decoration: none;">
                                        {{ $inscricao->email }}
                                    </a>
                                </td>
                                <td>
                                    @php
                                        $telefone = $inscricao->telefone ?? (is_array($inscricao->contactos) && count($inscricao->contactos) ? $inscricao->contactos[0] : null);
                                    @endphp
                                    @if($telefone)
                                        <a href="tel:{{ $telefone }}" style="color: var(--pi-text); text-decoration: none;">{{ $telefone }}</a>
                                    @else
                                        <span style="color: var(--pi-text-muted);">—</span>
                                    @endif
                                </td>
                                <td style="font-size: 0.8125rem; color: var(--pi-text-muted);">
                                    {{ $inscricao->observacoes ?: '—' }}
                                </td>
                                <td style="font-size: 0.8125rem; color: var(--pi-text-muted);">
                                    {{ \Carbon\Carbon::parse($inscricao->created_at)->format('d/m/Y H:i') }}
                                </td>
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
            <div class="pi-mobile-cards" style="padding: 1rem;">
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
                                <button class="pi-btn pi-btn-success btn-aceitar-inscricao" data-inscricao-id="{{ $inscricao->id }}" style="font-size: 0.75rem; padding: 0.25rem 0.625rem;">
                                    <i class="fas fa-check"></i> Aceitar
                                </button>
                                <button class="pi-btn pi-btn-danger btn-rejeitar-inscricao" data-inscricao-id="{{ $inscricao->id }}" style="font-size: 0.75rem; padding: 0.25rem 0.625rem;">
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


{{-- ============================================= --}}
{{-- MODAL: Editar Turma                           --}}
{{-- ============================================= --}}
<div class="modal fade pi-modal" id="modalEditarTurmaShow" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div>
                        <h5 class="modal-title">Editar Turma</h5>
                        <p class="mb-0" style="font-size: 0.8125rem; color: var(--pi-text-muted);">{{ $turma->curso->nome }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body">
                <form id="formEditarTurmaShow" class="pi-form">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="curso_id" value="{{ $turma->curso_id }}">
                    <input type="hidden" id="editTurmaIdShow" name="turma_id" value="{{ $turma->id }}">
                    <input type="hidden" id="centroIdHidden" name="centro_id" value="{{ $turma->centro_id }}">

                    <div class="row g-3">
                        {{-- COLUNA ESQUERDA --}}
                        <div class="col-md-6">
                            <div class="section-title">
                                <i class="fas fa-info-circle"></i> Informações da Turma
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Centro <span class="required">*</span></label>
                                <select id="centroIdShow" name="centro_id" class="form-select" required disabled>
                                    <option value="">Selecione o centro</option>
                                </select>
                                <div class="form-text">O centro não pode ser alterado após a criação da turma.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Formador</label>
                                <select id="formadorIdShow" name="formador_id" class="form-select">
                                    <option value="">Selecione (opcional)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Período <span class="required">*</span></label>
                                <select id="periodoShow" name="periodo" class="form-select" required>
                                    <option value="manha" {{ $turma->periodo === 'manha' || $turma->periodo === 'manhã' ? 'selected' : '' }}>Manha</option>
                                    <option value="tarde" {{ $turma->periodo === 'tarde' ? 'selected' : '' }}>Tarde</option>
                                    <option value="noite" {{ $turma->periodo === 'noite' ? 'selected' : '' }}>Noite</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select id="statusShow" name="status" class="form-select">
                                    <option value="planeada" {{ $turma->status === 'planeada' ? 'selected' : '' }}>Planeada</option>
                                    <option value="inscricoes_abertas" {{ $turma->status === 'inscricoes_abertas' ? 'selected' : '' }}>Inscrições Abertas</option>
                                    <option value="em_andamento" {{ $turma->status === 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                                    <option value="concluida" {{ $turma->status === 'concluida' ? 'selected' : '' }}>Concluída</option>
                                </select>
                            </div>
                        </div>

                        {{-- COLUNA DIREITA --}}
                        <div class="col-md-6">
                            <div class="section-title">
                                <i class="fas fa-clock"></i> Horário
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hora Início <span class="required">*</span></label>
                                <input type="time" id="horaInicioShow" name="hora_inicio" class="form-control" value="{{ $turma->hora_inicio }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hora Fim</label>
                                <input type="time" id="horaFimShow" name="hora_fim" class="form-control" value="{{ $turma->hora_fim }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Duração (Semanas)</label>
                                <input type="number" id="duracaoShow" name="duracao_semanas" class="form-control" value="{{ $turma->duracao_semanas }}" min="1">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Data Arranque <span class="required">*</span></label>
                                <input type="date" id="dataArranqueShow" name="data_arranque" class="form-control" 
                                       value="{{ \Carbon\Carbon::parse($turma->data_arranque)->format('Y-m-d') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vagas Disponíveis</label>
                                <input type="number" id="vagasTotaisShow" name="vagas_totais" class="form-control" value="{{ $turma->vagas_totais }}" min="1">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vagas Preenchidas</label>
                                <input type="number" class="form-control" value="{{ $turma->vagas_preenchidas ?? 0 }}" disabled>
                                <div class="form-text">Atualizado automaticamente quando pré-inscrições são confirmadas.</div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" id="publicadoShow" name="publicado" class="form-check-input" {{ $turma->publicado ? 'checked' : '' }}>
                                    <label class="form-check-label" for="publicadoShow">Publicar no site</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DIAS DA SEMANA --}}
                    <div class="mt-3">
                        <div class="section-title">
                            <i class="fas fa-calendar-week"></i> Dias da Semana
                        </div>
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

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
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

// Carregar centros disponíveis
function carregarCentros() {
    const cursoId = {{ $turma->curso_id }};
    $.ajax({
        url: `/cursos/${cursoId}`,
        method: 'GET',
        success: function(response) {
            const centros = response.dados?.centros || [];
            const select = $('#centroIdShow');
            select.empty().append('<option value="">Selecione um centro</option>');

            centros.forEach(c => {
                const selected = c.id === {{ $turma->centro_id }} ? 'selected' : '';
                select.append(`<option value="${c.id}" ${selected}>${c.nome}</option>`);
            });
        },
        error: function(err) {
            console.error('Erro ao carregar centros:', err);
            $('#centroIdShow').html('<option value="">Erro ao carregar centros</option>');
        }
    });
}

// Carregar formadores
function carregarFormadores() {
    $.ajax({
        url: '/formadores',
        method: 'GET',
        success: function(response) {
            const data = Array.isArray(response) ? response : (response.data || []);
            const select = $('#formadorIdShow');
            select.empty().append('<option value="">Sem formador</option>');

            const formadorAtual = {{ $turma->formador_id ?? 'null' }};

            data.forEach(f => {
                const selected = f.id === formadorAtual ? 'selected' : '';
                select.append(`<option value="${f.id}" ${selected}>${f.nome}</option>`);
            });
        },
        error: function(xhr) {
            console.error('Erro ao carregar formadores:', xhr);
        }
    });
}

// Configurar envio do formulário - COM METHOD SPOOFING
function configurarFormulario() {
    $('#formEditarTurmaShow').on('submit', function(e) {
        e.preventDefault();

        // Extrair e validar ID da turma no início
        const turmaId = $('#editTurmaIdShow').val();
        console.log('ID da turma:', turmaId);
        
        if (!turmaId) {
            Swal.fire('Erro', 'ID da turma não encontrado', 'error');
            console.error('Campo #editTurmaIdShow está vazio!');
            return;
        }

        const dias = [];
        $('.dia-semana-show:checked').each(function() {
            dias.push($(this).val());
        });

        if (dias.length === 0) {
            Swal.fire('Aviso', 'Selecione pelo menos um dia', 'warning');
            return;
        }

        const horaInicio = $('#horaInicioShow').val();
        if (!horaInicio) {
            Swal.fire('Aviso', 'Hora de início é obrigatória', 'warning');
            return;
        }

        // Usar FormData para method spoofing
        const formData = new FormData();
        
        // Method spoofing - IMPORTANTE!
        formData.append('_method', 'PUT');
        
        // Adicionar todos os campos
        formData.append('curso_id', $('input[name="curso_id"]').val());
        formData.append('centro_id', $('#centroIdHidden').val());
        formData.append('periodo', $('#periodoShow').val());
        formData.append('status', $('#statusShow').val());
        formData.append('hora_inicio', horaInicio);
        formData.append('hora_fim', $('#horaFimShow').val() || '');
        formData.append('duracao_semanas', $('#duracaoShow').val() || '');
        formData.append('data_arranque', $('#dataArranqueShow').val());
        formData.append('formador_id', $('#formadorIdShow').val() || '');
        formData.append('vagas_totais', $('#vagasTotaisShow').val() || '');
        formData.append('publicado', $('#publicadoShow').is(':checked') ? '1' : '0');
        
        // Adicionar dias da semana (array)
        dias.forEach(function(dia, index) {
            formData.append(`dia_semana[${index}]`, dia);
        });

        console.log('Enviando FormData:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        console.log('URL da requisição:', `/turmas/${turmaId}`);

        $.ajax({
            url: `/turmas/${turmaId}`,
            method: 'POST',  // ← POST com method spoofing
            data: formData,
            contentType: false,  // ← Importante para FormData
            processData: false,  // ← Importante para FormData
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Sucesso:', response);
                Swal.fire('Sucesso!', 'Turma atualizada com sucesso', 'success').then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                console.error('Erro detalhado:', xhr);
                console.error('Status:', xhr.status);
                console.error('URL enviada:', xhr.responseURL);
                
                let mensagem = 'Erro ao atualizar turma';
                
                if (xhr.responseJSON?.errors) {
                    mensagem = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                } else if (xhr.responseJSON?.message) {
                    mensagem = xhr.responseJSON.message;
                }
                
                Swal.fire('Erro', mensagem, 'error');
            }
        });
    });

    // Aceitar inscrição
    $(document).on('click', '.btn-aceitar-inscricao', function() {
        const id = $(this).data('inscricao-id');
        atualizarStatusInscricao(id, 'confirmado');
    });

    // Rejeitar inscrição
    $(document).on('click', '.btn-rejeitar-inscricao', function() {
        const id = $(this).data('inscricao-id');
        atualizarStatusInscricao(id, 'cancelado');
    });
}

function atualizarStatusInscricao(id, status) {
    $.ajax({
        url: `/pre-inscricoes/${id}`,
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify({ status: status }),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() {
            Swal.fire('Sucesso!', 'Status atualizado', 'success').then(() => {
                location.reload();
            });
        },
        error: function() {
            Swal.fire('Erro', 'Erro ao atualizar status', 'error');
        }
    });
}

// Eliminar turma
function eliminarTurmaShow(id) {
    Swal.fire({
        title: 'Confirmar eliminação',
        text: 'Tem certeza que deseja eliminar esta turma?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/turmas/${id}`,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function() {
                    Swal.fire('Eliminado!', 'Turma eliminada com sucesso', 'success').then(() => {
                        window.location.href = "{{ route('turmas.index') }}";
                    });
                },
                error: function() {
                    Swal.fire('Erro', 'Erro ao eliminar turma', 'error');
                }
            });
        }
    });
}
</script>
@endsection
