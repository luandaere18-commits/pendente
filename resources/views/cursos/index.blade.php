@extends('layouts.app')

@section('title', 'Cursos')

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
    .pi-badge-ativo { background: var(--pi-success-light); color: #1e6e49; }
    .pi-badge-inativo { background: rgba(100, 116, 139, 0.1); color: #475569; }
    .pi-badge-presencial { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-badge-online { background: var(--pi-info-light); color: #0369a1; }
    .pi-badge-hibrido { background: var(--pi-warning-light); color: #92610a; }

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

    /* Course image in table */
    .pi-curso-img { width: 40px; height: 40px; border-radius: 0.5rem; object-fit: cover; border: 1px solid var(--pi-border); }
    .pi-curso-img-placeholder { width: 40px; height: 40px; border-radius: 0.5rem; background: #f0f2f5; display: inline-flex; align-items: center; justify-content: center; color: var(--pi-text-muted); font-size: 0.875rem; }

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
    .pi-form .form-text { font-size: 0.75rem; color: var(--pi-text-muted); }
    .pi-form .section-title { font-size: 0.8125rem; font-weight: 600; color: var(--pi-primary); margin-bottom: 0.75rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--pi-border); display: flex; align-items: center; gap: 0.5rem; }

    /* Course detail image in modal */
    .pi-curso-detail-img { max-width: 150px; max-height: 150px; object-fit: cover; border-radius: 0.5rem; border: 1px solid var(--pi-border); }
    .pi-curso-detail-img-placeholder { width: 150px; height: 150px; border-radius: 0.5rem; background: #f0f2f5; display: flex; align-items: center; justify-content: center; color: var(--pi-text-muted); font-size: 2rem; }

    /* Image upload area */
    .pi-upload-area { border: 2px dashed var(--pi-border); border-radius: 0.5rem; padding: 1.5rem; text-align: center; cursor: pointer; transition: all 0.15s; }
    .pi-upload-area:hover { border-color: var(--pi-primary); background: var(--pi-primary-light); }
    .pi-upload-area i { font-size: 1.5rem; color: var(--pi-text-muted); margin-bottom: 0.5rem; }

    /* Centro card in form */
    .pi-centro-card { background: var(--pi-bg); border: 1px solid var(--pi-border); border-radius: 0.5rem; padding: 1rem; margin-bottom: 0.75rem; position: relative; }
    .pi-centro-card .centro-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; }
    .pi-centro-card .centro-number { font-size: 0.75rem; font-weight: 600; color: var(--pi-primary); background: var(--pi-primary-light); padding: 0.125rem 0.5rem; border-radius: 9999px; }

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

    {{-- ============================================= --}}
    {{-- HEADER                                        --}}
    {{-- ============================================= --}}
    <div class="pi-header">
        <div class="pi-header-left">
            <div class="pi-header-icon">
                <i class="fas fa-graduation-cap fa-lg"></i>
            </div>
            <div>
                <h1>Gestão de Cursos</h1>
                <p>Gerir todos os cursos disponíveis no sistema</p>
            </div>
        </div>
        <button class="btn pi-btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovoCurso">
            <i class="fas fa-plus"></i> Novo Curso
        </button>
    </div>

    {{-- ============================================= --}}
    {{-- STATS                                         --}}
    {{-- ============================================= --}}
    <div class="pi-stats">
        <div class="pi-stat-card">
            <div class="stat-label">Total de Cursos</div>
            <div class="stat-value text-primary">{{ $cursos->count() }}</div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-label">Ativos</div>
            <div class="stat-value text-success">{{ $cursos->where('ativo', true)->count() }}</div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-label">Inativos</div>
            <div class="stat-value text-muted">{{ $cursos->where('ativo', false)->count() }}</div>
        </div>
        <div class="pi-stat-card">
            <div class="stat-label">Modalidades</div>
            <div class="stat-value text-info">{{ $cursos->pluck('modalidade')->unique()->count() }}</div>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- FILTERS                                       --}}
    {{-- ============================================= --}}
    <div class="pi-filters">
        <div class="pi-filters-header">
            <i class="fas fa-filter"></i> Filtros
        </div>
        <div class="pi-filters-grid">
            <input type="text" class="form-control" id="filtroNome" placeholder="Buscar por nome..." value="{{ request('nome') }}">
            <select class="form-select" id="filtroModalidade">
                <option value="">Todas as modalidades</option>
                <option value="presencial" {{ request('modalidade') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                <option value="online" {{ request('modalidade') == 'online' ? 'selected' : '' }}>Online</option>
                <option value="hibrido" {{ request('modalidade') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
            </select>
            <select class="form-select" id="filtroStatus">
                <option value="">Todos os status</option>
                <option value="1" {{ request('ativo') === '1' ? 'selected' : '' }}>Ativo</option>
                <option value="0" {{ request('ativo') === '0' ? 'selected' : '' }}>Inativo</option>
            </select>
            <div class="d-flex gap-2">
                <button class="pi-btn-clear" onclick="limparFiltros()">
                    <i class="fas fa-times"></i> Limpar
                </button>
            </div>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- TABLE                                         --}}
    {{-- ============================================= --}}
    <div class="pi-table-card">
        <div class="pi-table-header">
            <h2>Lista de Cursos</h2>
            <small>{{ $cursos->count() }} curso(s)</small>
        </div>

        {{-- Desktop Table --}}
        <div class="pi-desktop-table">
            <table class="pi-table">
                <thead>
                    <tr>
                        <th style="width:60px">ID</th>
                        <th>Nome</th>
                        <th>Modalidade</th>
                        <th>Centro(s)</th>
                        <th>Preço Médio</th>
                        <th>Status</th>
                        <th style="text-align:right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cursos as $curso)
                        <tr>
                            <td class="mono">#{{ $curso->id }}</td>
                            <td><strong>{{ $curso->nome }}</strong></td>
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
                                    <i class="{{ $modIcons[$curso->modalidade] ?? 'fas fa-question' }}" style="margin-right:0.25rem"></i>
                                    {{ ucfirst($curso->modalidade) }}
                                </span>
                            </td>
                            <td style="font-size:0.8125rem">
                                @if($curso->centros->count() > 0)
                                    {{ $curso->centros->count() }} centro(s)
                                @else
                                    <span style="color:var(--pi-text-muted)">—</span>
                                @endif
                            </td>
                            <td style="font-size:0.8125rem">
                                @if($curso->centros->count() > 0)
                                    {{ number_format($curso->centros->avg('pivot.preco'), 2, ',', '.') }} Kz
                                @else
                                    <span style="color:var(--pi-text-muted)">—</span>
                                @endif
                            </td>
                            <td>
                                @if($curso->ativo)
                                    <span class="pi-badge pi-badge-ativo"><i class="fas fa-check-circle" style="margin-right:0.25rem"></i>Ativo</span>
                                @else
                                    <span class="pi-badge pi-badge-inativo"><i class="fas fa-times-circle" style="margin-right:0.25rem"></i>Inativo</span>
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
                                    <button class="pi-action-btn delete" onclick="eliminarCurso({{ $curso->id }})" title="Eliminar">
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
                        <div style="display:flex;align-items:center;gap:0.75rem">
                            @if($curso->imagem)
                                <img src="{{ asset('storage/' . $curso->imagem) }}" alt="{{ $curso->nome }}" class="pi-curso-img">
                            @else
                                <div class="pi-curso-img-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            <div>
                                <div class="card-name">{{ $curso->nome }}</div>
                                <div class="card-meta">{{ ucfirst($curso->modalidade) }} &bull; {{ $curso->centros->count() }} centro(s)</div>
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
                            <span>{{ number_format($curso->centros->avg('pivot.preco'), 2, ',', '.') }} Kz</span>
                        @endif
                    </div>
                    <div class="card-actions">
                        <button class="btn btn-sm btn-outline-secondary btn-visualizar-curso" data-curso-id="{{ $curso->id }}"><i class="fas fa-eye me-1"></i>Ver</button>
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('cursos.edit', $curso) }}"><i class="fas fa-edit me-1"></i>Editar</a>
                        <button class="btn btn-sm btn-outline-danger" onclick="eliminarCurso({{ $curso->id }})"><i class="fas fa-trash me-1"></i>Eliminar</button>
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
                    <p class="text-muted mt-2">Carregando...</p>
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

            {{-- Header --}}
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div>
                        <h5 class="modal-title">Criar Novo Curso</h5>
                        <p class="modal-subtitle">Preencha os dados do curso</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body">
                <form id="formNovoCursoAjax" class="pi-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        {{-- ====== COLUNA ESQUERDA ====== --}}
                        <div class="col-md-6">
                            <div class="section-title">
                                <i class="fas fa-info-circle"></i> Informações do Curso
                            </div>

                            {{-- Nome --}}
                            <div class="mb-3">
                                <label class="form-label">Nome <span class="required">*</span></label>
                                <input type="text" class="form-control" name="nome" required placeholder="Nome do curso">
                            </div>

                            {{-- Área --}}
                            <div class="mb-3">
                                <label class="form-label">Área <span class="required">*</span></label>
                                <input type="text" class="form-control" name="area" required placeholder="Área do curso">
                            </div>

                            {{-- Modalidade + Status --}}
                            <div class="row mb-3">
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
                                        <label class="form-check-label" for="novoCursoAtivo">Ativo</label>
                                    </div>
                                </div>
                            </div>

                            {{-- Imagem --}}
                            <div class="mb-3">
                                <label class="form-label">Imagem</label>
                                <input type="file" class="form-control" name="imagem" accept="image/jpeg,image/png,image/jpg,image/gif">
                                <div class="form-text">JPEG, PNG, JPG, GIF (máx 2 MB)</div>
                            </div>
                        </div>

                        {{-- ====== COLUNA DIREITA ====== --}}
                        <div class="col-md-6">
                            <div class="section-title">
                                <i class="fas fa-file-alt"></i> Conteúdo
                            </div>

                            {{-- Descrição --}}
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control" name="descricao" rows="4" placeholder="Descrição do curso"></textarea>
                            </div>

                            {{-- Programa --}}
                            <div class="mb-3">
                                <label class="form-label">Programa do Curso</label>
                                <textarea class="form-control" name="programa" rows="4" placeholder="Programa detalhado"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ====== SEÇÃO DE CENTROS ====== --}}
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="section-title mb-0 pb-0 border-0">
                                <i class="fas fa-building"></i> Centros de Formação
                            </div>
                            <button type="button" class="btn btn-sm pi-btn-primary" id="adicionarCentroModalBtn">
                                <i class="fas fa-plus"></i> Adicionar Centro
                            </button>
                        </div>
                        <div id="centrosContainerModal">
                            {{-- centros dinâmicos aqui --}}
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="submit" form="formNovoCursoAjax" class="btn pi-btn-primary">
                    <i class="fas fa-check"></i> Criar Curso
                </button>
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
                <button type="button" class="btn btn-sm btn-outline-danger remover-centro-modal" title="Remover">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="form-label">Centro <span class="required">*</span></label>
                    <select class="form-select centro-id-modal" required>
                        <option value="">Selecione o centro</option>
                    </select>
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
        url: '/api/centros',
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
 * Carregar detalhes do curso para visualização
 */
function carregarDetalhesCurso(cursoId) {
    $.ajax({
        url: `/api/cursos/${cursoId}`,
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        },
        success: function(response) {
            const curso = response.dados || response;
            
            const statusBadge = curso.ativo 
                ? '<span class="pi-badge pi-badge-ativo"><i class="fas fa-check-circle" style="margin-right:0.25rem"></i>Ativo</span>'
                : '<span class="pi-badge pi-badge-inativo"><i class="fas fa-times-circle" style="margin-right:0.25rem"></i>Inativo</span>';
            
            const modClasses = { 'online': 'pi-badge-online', 'presencial': 'pi-badge-presencial', 'hibrido': 'pi-badge-hibrido' };
            const modIcons = { 'online': 'fas fa-globe', 'presencial': 'fas fa-building', 'hibrido': 'fas fa-laptop-house' };
            const modalidadeBadge = `<span class="pi-badge ${modClasses[curso.modalidade] || 'pi-badge-presencial'}"><i class="${modIcons[curso.modalidade] || 'fas fa-question'}" style="margin-right:0.25rem"></i>${curso.modalidade ? curso.modalidade.charAt(0).toUpperCase() + curso.modalidade.slice(1) : 'N/A'}</span>`;
            
            const imagemHtml = curso.imagem_url 
                ? `<img src="${curso.imagem_url}" alt="${curso.nome}" class="pi-curso-detail-img">`
                : '<div class="pi-curso-detail-img-placeholder"><i class="fas fa-image"></i></div>';
            
            // Seção de Centros
            let centrosHtml = '';
            if (curso.centros && curso.centros.length > 0) {
                centrosHtml = `
                    <div class="mt-3">
                        <div class="section-title" style="font-size:0.8125rem;font-weight:600;color:var(--pi-primary);padding-bottom:0.5rem;border-bottom:1px solid var(--pi-border);display:flex;align-items:center;gap:0.5rem">
                            <i class="fas fa-building"></i> Centros Associados
                        </div>
                        <table class="pi-table" style="font-size:0.8125rem">
                            <thead><tr><th>Centro</th><th>Preço (Kz)</th></tr></thead>
                            <tbody>`;
                curso.centros.forEach(centro => {
                    const preco = centro.pivot?.preco ? parseFloat(centro.pivot.preco).toLocaleString('pt-PT') : 'N/A';
                    centrosHtml += `<tr><td><strong>${centro.nome}</strong></td><td>${preco}</td></tr>`;
                });
                centrosHtml += '</tbody></table></div>';
            }
            
            // Seção de Turmas
            let turmasHtml = '';
            if (curso.turmas && curso.turmas.length > 0) {
                turmasHtml = `
                    <div class="mt-3">
                        <div class="section-title" style="font-size:0.8125rem;font-weight:600;color:var(--pi-info);padding-bottom:0.5rem;border-bottom:1px solid var(--pi-border);display:flex;align-items:center;gap:0.5rem">
                            <i class="fas fa-calendar"></i> Turmas
                        </div>
                        <table class="pi-table" style="font-size:0.8125rem">
                            <thead><tr><th>Dias</th><th>Período</th><th>Início</th><th>Fim</th><th>Semanas</th></tr></thead>
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
                    
                    turmasHtml += `
                        <tr>
                            <td><strong>${dias}</strong></td>
                            <td><span class="pi-badge pi-badge-periodo">${periodo}</span></td>
                            <td>${turma.hora_inicio || 'N/A'}</td>
                            <td>${turma.hora_fim || 'N/A'}</td>
                            <td>${turma.duracao_semanas || 'N/A'}</td>
                        </tr>`;
                });
                turmasHtml += '</tbody></table></div>';
            }
            
            const conteudo = `
                <div class="row g-3 mb-3">
                    <div class="col-md-3 text-center">
                        ${imagemHtml}
                    </div>
                    <div class="col-md-9 ps-md-3" style="min-width:0;">
                        <h5 style="font-weight:700;margin-bottom:0.5rem">${curso.nome}</h5>
                        <div class="d-flex gap-2 flex-wrap mb-3">
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
                                <div class="pi-detail-value" style="font-weight:400">${curso.descricao}</div>
                            </div>
                        </div>` : ''}
                        ${curso.programa ? `
                        <div class="pi-detail-row">
                            <div class="pi-detail-icon"><i class="fas fa-book"></i></div>
                            <div>
                                <div class="pi-detail-label">Programa</div>
                                <div class="pi-detail-value" style="font-weight:400">${curso.programa}</div>
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
            Swal.fire('Erro!', 'Não foi possível carregar os detalhes do curso.', 'error');
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

    // Visualizar detalhes do curso
    $(document).on('click', '.btn-visualizar-curso', function(e) {
        e.preventDefault();
        const cursoId = $(this).data('curso-id');
        carregarDetalhesCurso(cursoId);
    });
}

/**
 * Adicionar centro no modal
 */
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

/**
 * Atualizar numeração dos centros
 */
function atualizarNumeroCentrosModal() {
    const badges = $('#centrosContainerModal').find('.numero-centro-modal');
    badges.each((index, badge) => {
        $(badge).text('Centro ' + (index + 1));
    });

    const btnsRemover = $('#centrosContainerModal').find('.remover-centro-modal');
    btnsRemover.prop('disabled', btnsRemover.length <= 1);
}

/**
 * Criar Novo Curso
 */
$("#formNovoCursoAjax").on("submit", function(e) {
    e.preventDefault();

    const $form = $(this);

    const nome = $form.find("[name=\"nome\"]").val().trim();
    const area = $form.find("[name=\"area\"]").val().trim();
    const modalidade = $form.find("[name=\"modalidade\"]").val().trim();

    if (!nome || !area || !modalidade) {
        Swal.fire("Erro!", "Preencha os campos obrigatórios (Nome, Área, Modalidade)", "error");
        return;
    }

    const centrosCount = $('#centrosContainerModal').find('.centro-id-modal').length;
    if (centrosCount === 0) {
        Swal.fire("Erro!", "Adicione pelo menos um centro", "error");
        return;
    }

    let centroValido = true;
    $('#centrosContainerModal').find('.centro-card').each(function() {
        const centroId = $(this).find('.centro-id-modal').val();
        const preco = $(this).find('.preco-modal').val();

        if (!centroId || !preco) {
            centroValido = false;
            return false;
        }
    });

    if (!centroValido) {
        Swal.fire("Erro!", "Preencha todos os dados dos centros (Centro, Preço)", "error");
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
    if (imagemFile) {
        formData.append('imagem', imagemFile);
    }

    let index = 0;
    $('#centrosContainerModal').find('.centro-card').each(function() {
        const centroId = $(this).find('.centro-id-modal').val();
        const preco = $(this).find('.preco-modal').val();

        formData.append(`centros[${index}][centro_id]`, centroId);
        formData.append(`centros[${index}][preco]`, preco);
        index++;
    });

    $.ajax({
        url: `/api/cursos`,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content"),
            "Accept": "application/json"
        },
        success: function(response) {
            console.log("Sucesso:", response);
            $("#modalNovoCurso").modal("hide");
            $form[0].reset();
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Curso criado com sucesso!",
                timer: 2000
            }).then(() => carregarCursos());
        },
        error: function(xhr, status, error) {
            console.error("Status:", xhr.status);
            console.error("Response:", xhr.responseText);

            let message = "Erro desconhecido";

            if (xhr.responseJSON?.errors) {
                message = Object.values(xhr.responseJSON.errors).flat().join("\n");
            } else if (xhr.responseJSON?.message) {
                message = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: message || "Erro ao criar curso."
            });
        }
    });
});

/**
 * Filtros
 */
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

function carregarCursos() {
    location.reload();
}

/**
 * Elimina um curso específico
 */
function eliminarCurso(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: 'Esta ação irá eliminar o curso permanentemente!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Sim, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/cursos/${id}`,
                method: 'DELETE',
                headers: {
                    "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content"),
                    "Accept": "application/json"
                },
                success: function(response) {
                    Swal.fire('Eliminado!', 'O curso foi eliminado com sucesso.', 'success');
                    carregarCursos();
                },
                error: function(xhr) {
                    console.error('Erro ao eliminar curso:', xhr);
                    Swal.fire('Erro!', 'Ocorreu um erro ao eliminar o curso.', 'error');
                }
            });
        }
    });
}
</script>
@endsection
