@extends('layouts.app')

@section('title', 'Turmas')

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
    .pi-stat-card .stat-value.text-info { color: var(--pi-info) !important; }
    .pi-stat-card .stat-value.text-muted { color: var(--pi-muted) !important; }

    /* Filters */
    .pi-filters { background: var(--pi-card); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); padding: 1.25rem; box-shadow: var(--pi-shadow); margin-bottom: 1.25rem; width: 100%; }
    .pi-filters-header { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem; font-size: 0.875rem; font-weight: 500; color: var(--pi-text-muted); }
    .pi-filters-header .badge { font-size: 0.7rem; }
    .pi-filters-grid { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 0.75rem; align-items: end; }
    .pi-filters .form-control, .pi-filters .form-select { border-radius: 0.5rem; border-color: var(--pi-border); font-size: 0.875rem; height: 2.5rem; }
    .pi-filters .form-control:focus, .pi-filters .form-select:focus { border-color: var(--pi-primary); box-shadow: 0 0 0 3px var(--pi-primary-light); }
    .pi-btn-clear { border: none; background: transparent; color: var(--pi-text-muted); font-size: 0.875rem; padding: 0.5rem 0.75rem; border-radius: 0.5rem; display: inline-flex; align-items: center; gap: 0.375rem; cursor: pointer; white-space: nowrap; }
    .pi-btn-clear:hover { background: #f0f0f0; color: var(--pi-text); }

    /* Table card */
    .pi-table-card { background: var(--pi-card); border: 1px solid var(--pi-border); border-radius: var(--pi-radius); box-shadow: var(--pi-shadow); overflow: hidden; }
    .pi-table-header { border-bottom: 1px solid var(--pi-border); padding: 0.75rem 1.25rem; display: flex; align-items: center; justify-content: space-between; }
    .pi-table-header h2 { font-size: 0.875rem; font-weight: 600; margin: 0; }
    .pi-table-header small { font-size: 0.75rem; color: var(--pi-text-muted); }

    /* Table */
    .pi-table { width: 100%; margin: 0; font-size: 0.92rem; }
    .pi-table thead th { background: rgba(51, 102, 204, 0.08); border-bottom: 1px solid var(--pi-border); font-size: 0.82rem; font-weight: 600; color: var(--pi-primary); text-transform: uppercase; letter-spacing: 0.03em; padding: 0.75rem 1rem; white-space: nowrap; }
    .pi-table tbody td { padding: 0.75rem 1rem; vertical-align: middle; border-bottom: 1px solid #f0f2f5; }
    .pi-table tbody tr:hover { background: #f8f9fb; }
    .pi-table tbody tr:last-child td { border-bottom: none; }
    .pi-table .mono { font-family: 'SF Mono', 'Fira Code', monospace; font-size: 0.75rem; color: var(--pi-text-muted); }

    /* Status badges */
    .pi-badge { display: inline-flex; align-items: center; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.01em; }
    .pi-badge-planeada { background: rgba(100, 116, 139, 0.1); color: #475569; }
    .pi-badge-inscricoes { background: var(--pi-success-light); color: #1e6e49; }
    .pi-badge-andamento { background: var(--pi-info-light); color: #0369a1; }
    .pi-badge-concluida { background: rgba(30, 41, 59, 0.1); color: #1e293b; }
    .pi-badge-periodo { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-badge-dia { background: var(--pi-info-light); color: #0369a1; font-size: 0.6875rem; }
    .pi-badge-pub-sim { background: var(--pi-success-light); color: #1e6e49; }
    .pi-badge-pub-nao { background: rgba(100, 116, 139, 0.1); color: #475569; }

    /* Action buttons */
    .pi-actions { display: flex; align-items: center; justify-content: flex-end; gap: 0.25rem; }
    .pi-action-btn { width: 2rem; height: 2rem; border: none; border-radius: 0.375rem; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s; font-size: 0.8125rem; }
    .pi-action-btn.view { background: transparent; color: var(--pi-text-muted); }
    .pi-action-btn.view:hover { background: #f0f0f0; color: var(--pi-text); }
    .pi-action-btn.edit { background: transparent; color: var(--pi-primary); border: 1px solid var(--pi-primary); }
    .pi-action-btn.edit:hover { background: var(--pi-primary); color: #fff; }
    .pi-action-btn.delete { background: transparent; color: var(--pi-danger); border: 1px solid var(--pi-danger); }
    .pi-action-btn.delete:hover { background: var(--pi-danger); color: #fff; }

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
    .pi-mobile-card .card-meta { font-size: 0.75rem; color: var(--pi-text-muted); margin-bottom: 0.5rem; }
    .pi-mobile-card .card-details { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.75rem; font-size: 0.8125rem; color: var(--pi-text-muted); }
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
    .pi-form .section-title { font-size: 0.8125rem; font-weight: 600; color: var(--pi-primary); margin-bottom: 0.75rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--pi-border); display: flex; align-items: center; gap: 0.5rem; }

    /* Days grid */
    .pi-days-grid { display: flex; flex-wrap: wrap; gap: 0.5rem; }
    .pi-day-check { display: flex; align-items: center; gap: 0.375rem; font-size: 0.8125rem; }
    .pi-day-check input[type="checkbox"] { width: 1rem; height: 1rem; accent-color: var(--pi-primary); }

    /* Loading spinner */
    .pi-spinner { display: inline-block; width: 1rem; height: 1rem; border: 2px solid #fff; border-right-color: transparent; border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 0.375rem; }
    @keyframes spin { to { transform: rotate(360deg); } }

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
    }
    @media (max-width: 575.98px) {
        .pi-page { padding: 1rem 0.75rem; }
    }

    /* Select2 overrides */
    .select2-container--bootstrap-5 .select2-selection { border-radius: 0.5rem !important; border-color: var(--pi-border) !important; height: 2.5rem !important; font-size: 0.875rem !important; }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered { line-height: 2.5rem !important; }
</style>
@endsection

@section('content')
<div class="pi-page">
    {{-- HEADER --}}
    <div class="pi-header">
        <div class="pi-header-left">
            <div class="pi-header-icon">
                <i class="fas fa-chalkboard-teacher fa-lg"></i>
            </div>
            <div>
                <h1>Gestão de Turmas</h1>
                <p>Gerir todas as turmas dos cursos no sistema</p>
            </div>
        </div>
        <button class="btn pi-btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovasTurma">
            <i class="fas fa-plus"></i> Nova Turma
        </button>
    </div>

    {{-- STATS --}}
    <div class="pi-stats">
        <div class="pi-stat-card">
            <div class="stat-label">Total de Turmas</div>
            <div class="stat-value text-primary">{{ $turmas->count() }}</div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-label">Inscrições Abertas</div>
            <div class="stat-value text-success">{{ $turmas->where('status', 'inscricoes_abertas')->count() }}</div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-label">Em Andamento</div>
            <div class="stat-value text-info">{{ $turmas->where('status', 'em_andamento')->count() }}</div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-label">Concluídas</div>
            <div class="stat-value text-muted">{{ $turmas->where('status', 'concluida')->count() }}</div>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="pi-filters">
        <div class="pi-filters-header">
            <i class="fas fa-filter"></i> Filtros
        </div>
        <div class="pi-filters-grid">
            <select class="form-select" id="filtroCurso">
                <option value="">Todos os cursos</option>
            </select>
            <select class="form-select" id="filtroStatus">
                <option value="">Todos os status</option>
                <option value="planeada">Planeada</option>
                <option value="inscricoes_abertas">Inscrições Abertas</option>
                <option value="em_andamento">Em Andamento</option>
                <option value="concluida">Concluída</option>
            </select>
            <select class="form-select" id="filtroPeriodo">
                <option value="">Todos os períodos</option>
                <option value="manha">Manhã</option>
                <option value="tarde">Tarde</option>
                <option value="noite">Noite</option>
            </select>
            <button class="pi-btn-clear" onclick="limparFiltros()">
                <i class="fas fa-times"></i> Limpar
            </button>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="pi-table-card">
        <div class="pi-table-header">
            <h2>Lista de Turmas</h2>
            <small>{{ $turmas->count() }} turma(s)</small>
        </div>

        {{-- Desktop Table --}}
        <div class="pi-desktop-table">
            <table class="pi-table">
                <thead>
                    <tr>
                        <th style="width:60px">ID</th>
                        <th>Curso</th>
                        <th>Centro</th>
                        <th>Formador</th>
                        <th>Dias</th>
                        <th>Status</th>
                        <th>Período</th>
                        <th>Horário</th>
                        <th>Vagas</th>
                        <th>Público</th>
                        <th style="text-align:right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($turmas as $turma)
                        <tr>
                            <td class="mono">#{{ $turma->id }}</td>
                            <td><strong>{{ $turma->curso->nome ?? 'N/A' }}</strong></td>
                            <td style="font-size:0.8125rem">{{ $turma->centro->nome ?? '—' }}</td>
                            <td style="font-size:0.8125rem">
                                @if($turma->formador)
                                    <strong>{{ $turma->formador->nome }}</strong>
                                @else
                                    <span style="color:var(--pi-text-muted)"><i class="fas fa-exclamation-triangle" style="color:var(--pi-warning);margin-right:0.25rem"></i>Não atribuído</span>
                                @endif
                            </td>
                            <td>
                                @if($turma->dia_semana && is_array($turma->dia_semana))
                                    @foreach($turma->dia_semana as $dia)
                                        <span class="pi-badge pi-badge-dia">{{ substr($dia, 0, 3) }}</span>
                                    @endforeach
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'planeada' => 'pi-badge-planeada',
                                        'inscricoes_abertas' => 'pi-badge-inscricoes',
                                        'em_andamento' => 'pi-badge-andamento',
                                        'concluida' => 'pi-badge-concluida'
                                    ];
                                    $statusLabels = [
                                        'planeada' => 'Planeada',
                                        'inscricoes_abertas' => 'Inscrições',
                                        'em_andamento' => 'Em Andamento',
                                        'concluida' => 'Concluída'
                                    ];
                                @endphp
                                <span class="pi-badge {{ $statusClass[$turma->status] ?? 'pi-badge-planeada' }}">
                                    {{ $statusLabels[$turma->status] ?? $turma->status }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $icones = [
                                        'manha' => 'fas fa-sun',
                                        'tarde' => 'fas fa-cloud-sun',
                                        'noite' => 'fas fa-moon'
                                    ];
                                    $icone = $icones[$turma->periodo] ?? 'fas fa-clock';
                                @endphp
                                <span class="pi-badge pi-badge-periodo">
                                    <i class="{{ $icone }}" style="margin-right:0.25rem"></i>{{ ucfirst($turma->periodo) }}
                                </span>
                            </td>
                            <td style="font-size:0.8125rem;white-space:nowrap">
                                @if($turma->hora_inicio && $turma->hora_fim)
                                    {{ $turma->hora_inicio }} - {{ $turma->hora_fim }}
                                @else
                                    —
                                @endif
                            </td>
                            <td style="font-size:0.8125rem;text-align:center">{{ $turma->vagas_preenchidas ?? 0 }}/{{ $turma->vagas_totais ?? 0 }}</td>
                            <td>
                                @if($turma->publicado)
                                    <span class="pi-badge pi-badge-pub-sim">Sim</span>
                                @else
                                    <span class="pi-badge pi-badge-pub-nao">Não</span>
                                @endif
                            </td>
                            <td>
                                <div class="pi-actions">
                                    <button class="pi-action-btn view" onclick="visualizarTurma({{ $turma->id }})" title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="pi-action-btn edit" onclick="window.location.href='{{ route('turmas.show', $turma) }}'" title="Gerir">
                                        <i class="fas fa-cogs"></i>
                                    </button>
                                    <button class="pi-action-btn delete" onclick="eliminarTurma({{ $turma->id }})" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">
                                <div class="pi-empty">
                                    <div class="pi-empty-icon"><i class="fas fa-inbox"></i></div>
                                    <h3>Nenhuma turma cadastrada</h3>
                                    <p>Crie uma nova turma para começar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="pi-mobile-cards">
            @forelse($turmas as $turma)
                <div class="pi-mobile-card">
                    <div class="card-top">
                        <div>
                            <div class="card-name">{{ $turma->curso->nome ?? 'N/A' }}</div>
                            <div class="card-meta">{{ $turma->centro->nome ?? '—' }} &bull; {{ $turma->formador->nome ?? 'Sem formador' }}</div>
                        </div>
                        @php
                            $statusClass = [
                                'planeada' => 'pi-badge-planeada',
                                'inscricoes_abertas' => 'pi-badge-inscricoes',
                                'em_andamento' => 'pi-badge-andamento',
                                'concluida' => 'pi-badge-concluida'
                            ];
                            $statusLabels = [
                                'planeada' => 'Planeada',
                                'inscricoes_abertas' => 'Inscrições',
                                'em_andamento' => 'Em Andamento',
                                'concluida' => 'Concluída'
                            ];
                        @endphp
                        <span class="pi-badge {{ $statusClass[$turma->status] ?? 'pi-badge-planeada' }}">
                            {{ $statusLabels[$turma->status] ?? $turma->status }}
                        </span>
                    </div>
                    <div class="card-details">
                        <span class="pi-badge pi-badge-periodo"><i class="{{ $icones[$turma->periodo] ?? 'fas fa-clock' }}" style="margin-right:0.25rem"></i>{{ ucfirst($turma->periodo) }}</span>
                        @if($turma->hora_inicio && $turma->hora_fim)
                            <span>{{ $turma->hora_inicio }} - {{ $turma->hora_fim }}</span>
                        @endif
                        <span>{{ $turma->vagas_preenchidas ?? 0 }}/{{ $turma->vagas_totais ?? 0 }} vagas</span>
                    </div>
                    <div class="card-actions">
                        <button class="btn btn-sm btn-outline-secondary" onclick="visualizarTurma({{ $turma->id }})"><i class="fas fa-eye me-1"></i>Ver</button>
                        <button class="btn btn-sm btn-outline-primary" onclick="window.location.href='{{ route('turmas.show', $turma) }}'" ><i class="fas fa-cogs me-1"></i>Gerir</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="eliminarTurma({{ $turma->id }})"><i class="fas fa-trash me-1"></i>Eliminar</button>
                    </div>
                </div>
            @empty
                <div class="pi-empty">
                    <div class="pi-empty-icon"><i class="fas fa-inbox"></i></div>
                    <h3>Nenhuma turma cadastrada</h3>
                    <p>Crie uma nova turma para começar</p>
                </div>
            @endforelse
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
                    <p class="text-muted mt-2">Carregando...</p>
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
                            <div class="section-title">
                                <i class="fas fa-info-circle"></i> Informações da Turma
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Curso <span class="required">*</span></label>
                                <select class="form-select" name="curso_id" required>
                                    <option value="">Selecione o curso</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Centro <span class="required">*</span></label>
                                <select class="form-select" name="centro_id" disabled>
                                    <option value="">Selecione um curso primeiro</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Formador</label>
                                <select class="form-select" name="formador_id">
                                    <option value="">Selecione (opcional)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Período <span class="required">*</span></label>
                                <select class="form-select" name="periodo" id="periodoNovo" required>
                                    <option value="">Selecione ou detecte pela hora</option>
                                    <option value="manha">Manhã</option>
                                    <option value="tarde">Tarde</option>
                                    <option value="noite">Noite</option>
                                </select>
                                <div class="form-text">Detecta automaticamente baseado na hora de início</div>
                            </div>

                            <div class="mb-3">
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
                            <div class="section-title">
                                <i class="fas fa-clock"></i> Horário
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hora Início <span class="required">*</span></label>
                                <input type="time" class="form-control" name="hora_inicio" id="horaInicioNovo" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hora Fim</label>
                                <input type="time" class="form-control" name="hora_fim">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Duração (Semanas)</label>
                                <input type="number" class="form-control" name="duracao_semanas" min="1">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vagas Disponíveis</label>
                                <input type="number" class="form-control" name="vagas_totais" min="1">
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="publicado" id="publicadoNovo">
                                    <label class="form-check-label" for="publicadoNovo">Publicar no site</label>
                                </div>
                                <div class="form-text">Marque para mostrar esta turma no site público</div>
                            </div>
                        </div>
                    </div>

                    {{-- DIAS DA SEMANA --}}
                    <div class="mb-3">
                        <div class="section-title">
                            <i class="fas fa-calendar-week"></i> Dias da Semana
                        </div>
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
                            <div class="section-title">
                                <i class="fas fa-info-circle"></i> Informações da Turma
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Curso <span class="required">*</span></label>
                                <select class="form-select" id="editCursoId" name="curso_id" required>
                                    <option value="">Selecione o curso</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Formador</label>
                                <select class="form-select" id="editFormadorId" name="formador_id">
                                    <option value="">Selecione (opcional)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Período <span class="required">*</span></label>
                                <select class="form-select" id="editPeriodo" name="periodo" required>
                                    <option value="">Selecione ou detecte pela hora</option>
                                    <option value="manha">Manhã</option>
                                    <option value="tarde">Tarde</option>
                                    <option value="noite">Noite</option>
                                </select>
                                <div class="form-text">Detecta automaticamente baseado na hora de início</div>
                            </div>

                            <div class="mb-3">
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
                            <div class="section-title">
                                <i class="fas fa-clock"></i> Horário
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hora Início <span class="required">*</span></label>
                                <input type="time" class="form-control" id="editHoraInicio" name="hora_inicio" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hora Fim</label>
                                <input type="time" class="form-control" id="editHoraFim" name="hora_fim">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Duração (Semanas)</label>
                                <input type="number" class="form-control" id="editDuracaoSemanas" name="duracao_semanas" min="1">
                            </div>
                        </div>
                    </div>

                    {{-- DIAS DA SEMANA --}}
                    <div class="mb-3">
                        <div class="section-title">
                            <i class="fas fa-calendar-week"></i> Dias da Semana
                        </div>
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
                    <div class="mb-3">
                        <label class="form-label">Data de Arranque <span class="required">*</span></label>
                        <input type="date" class="form-control" id="editDataArranque" name="data_arranque" required>
                        <div class="form-text">Selecione apenas datas futuras</div>
                    </div>

                    {{-- VAGAS E PUBLICAÇÃO --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vagas Disponíveis</label>
                            <input type="number" class="form-control" id="editVagasTotais" name="vagas_totais" min="1">
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="editPublicado" name="publicado">
                                <label class="form-check-label" for="editPublicado">Publicar no site</label>
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
$(document).ready(function() {
    console.log('JavaScript das turmas carregado');
    carregarFormadores();
    configurarEventosModal();
    configurarValidacoes();
    configurarAutoPreenchimento();
});

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
    
    fetch('/cursos')
        .then(response => {
            console.log('Resposta HTTP:', response.status);
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
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Resposta completa da API:', response);

            let options = '<option value="">Selecione um centro</option>';
            if (response.dados && response.dados.centros && response.dados.centros.length > 0) {
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
            Swal.fire('Erro', 'Não foi possível carregar os centros para este curso.', 'error');
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
 * Recarregar página para atualizar lista de turmas
 */
function aplicarFiltros() {
    const curso = $('#filtroCurso').val() || '';
    const status = $('#filtroStatus').val() || '';
    const periodo = $('#filtroPeriodo').val() || '';
    
    let url = '/turmas?';
    if (curso) url += `curso_id=${curso}&`;
    if (status) url += `status=${encodeURIComponent(status)}&`;
    if (periodo) url += `periodo=${encodeURIComponent(periodo)}`;
    
    window.location.href = url;
}

function limparFiltros() {
    $('#filtroCurso').val('');
    $('#filtroStatus').val('');
    $('#filtroPeriodo').val('');
    window.location.href = '/turmas';
}

function carregarTurmas() {
    location.reload();
}

/**
 * Configurar eventos do modal
 */
function configurarEventosModal() {
    carregarCursos();
    
    $(window).on('focus', function() {
        console.log('Página ganhou foco, recarregando cursos...');
        carregarCursos();
    });
    
    $('#modalNovasTurma').on('show.bs.modal', function() {
        console.log('Modal de nova turma aberto');
        $('#formNovaTurmaAjax')[0].reset();
        $('#diasError').hide();
        $('#formNovaTurmaAjax .is-invalid').removeClass('is-invalid');
        $('.dia-semana').prop('checked', false);
        $('#modalNovasTurma select[name="centro_id"]').html('<option value="">Selecione um curso primeiro</option>').prop('disabled', true);
        carregarCursos();
        carregarFormadores();
    });

    $(document).on('change', 'select[name="curso_id"]', function() {
        const cursoId = $(this).val();
        console.log('Evento change no select de curso disparado. Valor selecionado:', cursoId);
        if (cursoId) {
            carregarCentrosPorCurso(cursoId);
        } else {
            $('#modalNovasTurma select[name="centro_id"]').html('<option value="">Selecione o centro</option>').prop('disabled', true);
        }
    });

    $('#formNovaTurmaAjax').on('submit', function(e) {
        e.preventDefault();
        criarTurma();
    });

    $('#formEditarTurmaAjax').on('submit', function(e) {
        e.preventDefault();
        atualizarTurma();
    });

    // Bind filter changes
    $('#filtroCurso, #filtroStatus, #filtroPeriodo').on('change', aplicarFiltros);
}

/**
 * Configurar validações de data
 */
function configurarValidacoes() {
    const hoje = new Date().toISOString().split('T')[0];
    $('#dataArranqueNovo').attr('min', hoje);
    $('#editDataArranque').attr('min', hoje);
    
    $('input[name="data_arranque"], #editDataArranque').on('change', function() {
        const dataEscolhida = new Date($(this).val());
        const dataHoje = new Date(hoje);
        if (dataEscolhida < dataHoje) {
            $(this).val('');
            Swal.fire('Aviso', 'Selecione uma data futura', 'warning');
        }
    });
}

/**
 * Auto-preencher período baseado na hora de início
 */
function configurarAutoPreenchimento() {
    function detectarPeriodo(hora) {
        if (!hora) return '';
        const horas = parseInt(hora.split(':')[0]);
        if (horas >= 6 && horas < 12) return 'manha';
        if (horas >= 12 && horas < 18) return 'tarde';
        if (horas >= 18 || horas < 6) return 'noite';
        return '';
    }
    
    $('#horaInicioNovo').on('change', function() {
        const periodo = detectarPeriodo($(this).val());
        if (periodo) {
            $('#periodoNovo').val(periodo);
        }
    });
    
    $('#editHoraInicio').on('change', function() {
        const periodo = detectarPeriodo($(this).val());
        if (periodo) {
            $('#editPeriodo').val(periodo);
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
            const turma = response.dados || response.data;
            
            const cursoNome = turma.curso ? turma.curso.nome : 'N/A';
            const formadorNome = turma.formador ? turma.formador.nome : 'Sem atribuição';
            const diaSemana = turma.dia_semana ? turma.dia_semana.join(', ') : '—';
            const horaInicio = turma.hora_inicio || '—';
            const horaFim = turma.hora_fim || '—';
            const duracao = turma.duracao_semanas || '—';
            const dataArranque = turma.data_arranque ? new Date(turma.data_arranque).toLocaleDateString('pt-PT') : '—';
            
            let conteudo = '';
            conteudo += detailRow('fa-book', 'Curso', cursoNome);
            conteudo += detailRow('fa-user-tie', 'Formador', formadorNome);
            conteudo += detailRow('fa-calendar-week', 'Dias', diaSemana);
            conteudo += detailRow('fa-sun', 'Período', getPeriodoBadge(turma.periodo));
            conteudo += detailRow('fa-info-circle', 'Status', getStatusBadge(turma.status));
            conteudo += detailRow('fa-clock', 'Horário', horaInicio + ' - ' + horaFim);
            conteudo += detailRow('fa-hourglass-half', 'Duração', duracao + ' semana(s)');
            conteudo += detailRow('fa-calendar-alt', 'Data de Arranque', dataArranque);
            
            $('#conteudoVisualizarTurma').html(conteudo);
            new bootstrap.Modal(document.getElementById('modalVisualizarTurma')).show();
        },
        error: function() {
            Swal.fire('Erro', 'Erro ao carregar detalhes da turma', 'error');
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
            Swal.fire('Erro', 'Erro ao carregar dados da turma', 'error');
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
        Swal.fire('Aviso', 'Selecione pelo menos um dia da semana', 'warning');
        return;
    }

    const formador_id = $('select[name="formador_id"]').val();
    const status = $('select[name="status"]').val();

    if (status === 'inscricoes_abertas' && !formador_id) {
        $('select[name="formador_id"]').addClass('is-invalid');
        Swal.fire('Aviso', 'Para "Inscrições Abertas" é obrigatório selecionar um formador', 'warning');
        return;
    }

    const dados = {
        curso_id: $('select[name="curso_id"]').val(),
        centro_id: $('#modalNovasTurma select[name="centro_id"]').val(),
        formador_id: formador_id || null,
        periodo: $('select[name="periodo"]').val(),
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
    if (!dados.hora_inicio) { $('input[name="hora_inicio"]').addClass('is-invalid'); erros.push('Hora de início é obrigatória'); }
    if (!dados.data_arranque) { $('input[name="data_arranque"]').addClass('is-invalid'); erros.push('Data de arranque é obrigatória'); }

    if (erros.length > 0) {
        Swal.fire('Erro', erros.join('<br>'), 'error');
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
            Swal.fire('Sucesso!', 'Turma criada com sucesso', 'success');
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

            Swal.fire('Erro', mensagem, 'error');
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
        Swal.fire('Aviso', 'Selecione pelo menos um dia da semana', 'warning');
        return;
    }
    
    const formador_id = $('#editFormadorId').val();
    const status = $('#editStatus').val();
    
    if (status === 'inscricoes_abertas' && !formador_id) {
        Swal.fire('Aviso', 'Para "Inscrições Abertas" é obrigatório selecionar um formador', 'warning');
        return;
    }
    
    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('curso_id', $('#editCursoId').val());
    formData.append('formador_id', formador_id || null);
    formData.append('periodo', $('#editPeriodo').val());
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
            Swal.fire('Sucesso!', 'Turma atualizada com sucesso', 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalEditarTurma')).hide();
            carregarTurmas();
        },
        error: function(xhr) {
            const errors = xhr.responseJSON?.errors || {};
            let mensagem = 'Erro ao atualizar turma';
            if (Object.keys(errors).length > 0) {
                mensagem = Object.values(errors).flat().join(', ');
            }
            Swal.fire('Erro', mensagem, 'error');
        }
    });
}

/**
 * Eliminar turma
 */
window.eliminarTurma = function(id) {
    if (!id || id === '') {
        Swal.fire('Erro', 'ID da turma inválido', 'error');
        return;
    }
    
    Swal.fire({
        title: 'Confirmar Eliminação',
        text: 'Tem a certeza que deseja eliminar esta turma?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, eliminar!',
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
                    Swal.fire('Eliminada!', 'Turma eliminada com sucesso', 'success');
                    carregarTurmas();
                },
                error: function() {
                    Swal.fire('Erro', 'Erro ao eliminar turma', 'error');
                }
            });
        }
    });
};

/**
 * Auxiliar: Gerar badge de período
 */
function getPeriodoBadge(periodo) {
    const icones = { 'manha': 'fa-sun', 'tarde': 'fa-cloud-sun', 'noite': 'fa-moon' };
    const labels = { 'manha': 'Manhã', 'tarde': 'Tarde', 'noite': 'Noite' };
    const icon = icones[periodo] || 'fa-clock';
    const label = labels[periodo] || 'N/A';
    return '<span class="pi-badge pi-badge-periodo"><i class="fas ' + icon + '" style="margin-right:0.25rem"></i>' + label + '</span>';
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
