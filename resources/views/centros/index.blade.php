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

    .pi-page { width: 100%; padding: 0; }

    .pi-page-header {
        background: var(--pi-primary-gradient);
        color: #fff;
        padding: 1rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 0.75rem;
    }
    .pi-page-header h1 { font-size: 1.25rem; font-weight: 700; margin: 0; letter-spacing: -0.02em; color: #fff; }
    .pi-page-header p { font-size: 0.75rem; color: rgba(255,255,255,0.75); margin: 0; }
    .pi-page-header .pi-btn-create {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.5rem 1rem; border-radius: var(--pi-radius);
        background: #fff; color: var(--pi-primary); font-weight: 600;
        font-size: 0.8125rem; border: none; cursor: pointer; transition: all 0.15s;
    }
    .pi-page-header .pi-btn-create:hover { background: #dbeafe; }

    .pi-stats-bar {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 0;
        background: #fff; border-bottom: 1px solid var(--pi-border);
    }
    .pi-stat {
        padding: 0.75rem 1.25rem; border-right: 1px solid var(--pi-border);
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

    .pi-toolbar {
        background: #fff; border-bottom: 1px solid var(--pi-border);
        padding: 0.625rem 1.25rem;
        display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem;
    }
    .pi-toolbar .search-wrap { position: relative; flex: 1; min-width: 200px; }
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
        display: inline-flex; align-items: center; gap: 0.25rem; cursor: pointer; white-space: nowrap;
    }
    .pi-btn-clear:hover { background: var(--pi-danger-light); color: var(--pi-danger); }

    .pi-table-wrap { background: #fff; overflow: auto; }
    .pi-table { width: 100%; margin: 0; border-collapse: collapse; font-size: 0.8125rem; }
    .pi-table thead th {
        background: var(--pi-primary); color: #fff;
        font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;
        padding: 0.625rem 1rem; white-space: nowrap;
        position: sticky; top: 0; z-index: 5; border-bottom: none;
    }
    .pi-table tbody td { padding: 0.5rem 1rem; vertical-align: middle; border-bottom: 1px solid #f0f4ff; }
    .pi-table tbody tr { transition: background 0.1s; }
    .pi-table tbody tr:hover { background: var(--pi-primary-light); }
    .pi-table tbody tr:last-child td { border-bottom: none; }
    .pi-table .mono { font-family: 'SF Mono','Fira Code',monospace; font-size: 0.6875rem; color: var(--pi-muted); }

    .pi-pagination-bar {
        background: var(--pi-primary); color: #fff;
        padding: 0.5rem 1.25rem;
        display: flex; align-items: center; justify-content: space-between; font-size: 0.75rem;
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

    .pi-empty { text-align: center; padding: 3rem 1rem; color: var(--pi-text-muted); }
    .pi-empty-icon { width: 3.5rem; height: 3.5rem; border-radius: 0.75rem; background: var(--pi-primary-light); display: inline-flex; align-items: center; justify-content: center; font-size: 1.25rem; margin-bottom: 0.75rem; color: var(--pi-primary); }
    .pi-empty h3 { font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem; color: var(--pi-text); }
    .pi-empty p { font-size: 0.8125rem; }

    .pi-mobile-cards { display: none; padding: 0.75rem; }
    .pi-mobile-card {
        background: #fff; border: 1px solid var(--pi-border); border-radius: var(--pi-radius);
        padding: 0.75rem; box-shadow: var(--pi-shadow); margin-bottom: 0.5rem;
    }
    .pi-mobile-card .card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.375rem; }
    .pi-mobile-card .card-name { font-weight: 600; font-size: 0.875rem; color: var(--pi-text); }
    .pi-mobile-card .card-meta { font-size: 0.6875rem; color: var(--pi-text-muted); margin-bottom: 0.375rem; }
    .pi-mobile-card .card-actions { display: flex; gap: 0.375rem; }
    .pi-mobile-card .card-actions .btn { font-size: 0.6875rem; padding: 0.2rem 0.5rem; }

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

    .pi-detail-row { display: flex; align-items: flex-start; gap: 0.625rem; padding: 0.5rem 0; border-bottom: 1px solid #f0f4ff; }
    .pi-detail-row:last-child { border-bottom: none; }
    .pi-detail-icon { width: 1.75rem; height: 1.75rem; border-radius: 0.375rem; background: var(--pi-primary-light); display: flex; align-items: center; justify-content: center; color: var(--pi-primary); font-size: 0.75rem; flex-shrink: 0; }
    .pi-detail-label { font-size: 0.6875rem; font-weight: 500; color: var(--pi-text-muted); text-transform: uppercase; letter-spacing: 0.03em; }
    .pi-detail-value { font-size: 0.8125rem; font-weight: 500; margin-top: 0.0625rem; }

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

    .pi-btn-primary { background: var(--pi-primary); border: none; color: #fff; border-radius: var(--pi-radius); padding: 0.4375rem 0.875rem; font-size: 0.8125rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.375rem; transition: all 0.15s; cursor: pointer; }
    .pi-btn-primary:hover { background: var(--pi-primary-dark); color: #fff; }

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
                <div class="pi-stat-value" style="color:var(--pi-primary)">{{ $centros->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon green"><i class="fas fa-map-marker-alt"></i></div>
            <div>
                <div class="pi-stat-label">Com Localização</div>
                <div class="pi-stat-value" style="color:var(--pi-success)">{{ $centros->filter(fn($c) => $c->localizacao)->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon cyan"><i class="fas fa-envelope"></i></div>
            <div>
                <div class="pi-stat-label">Com Email</div>
                <div class="pi-stat-value" style="color:var(--pi-info)">{{ $centros->filter(fn($c) => $c->email)->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon gray"><i class="fas fa-phone"></i></div>
            <div>
                <div class="pi-stat-label">Com Contacto</div>
                <div class="pi-stat-value" style="color:var(--pi-muted)">{{ $centros->filter(fn($c) => $c->contactos && count($c->contactos) > 0)->count() }}</div>
            </div>
        </div>
    </div>

    {{-- TOOLBAR --}}
    <div class="pi-toolbar">
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="filtroNome" placeholder="Buscar por nome do centro..." value="{{ request('nome') }}">
        </div>
        <div class="search-wrap" style="max-width:250px">
            <i class="fas fa-search"></i>
            <input type="text" id="filtroLocalizacao" placeholder="Buscar por localização..." value="{{ request('localizacao') }}">
        </div>
        <button class="pi-btn-clear" onclick="limparFiltros()">
            <i class="fas fa-times-circle"></i> Limpar
        </button>
    </div>

    {{-- TABLE --}}
    <div class="pi-table-wrap">
        <div class="pi-desktop-table">
            <table class="pi-table" id="centrosTable">
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
                <tbody>
                    @forelse($centros as $centro)
                        <tr>
                            <td class="mono">#{{ $centro->id }}</td>
                            <td><strong style="font-size:0.8125rem">{{ $centro->nome }}</strong></td>
                            <td style="font-size:0.75rem">{{ $centro->localizacao ?? '—' }}</td>
                            <td style="font-size:0.75rem">
                                @if($centro->contactos && is_array($centro->contactos))
                                    @foreach($centro->contactos as $contacto)
                                        <span style="display:block">{{ $contacto }}</span>
                                    @endforeach
                                @else
                                    <span style="color:var(--pi-text-muted)">—</span>
                                @endif
                            </td>
                            <td style="font-size:0.75rem;color:var(--pi-text-muted)">{{ $centro->email ?? '—' }}</td>
                            <td>
                                <div class="pi-actions">
                                    <button class="pi-action-btn view btn-visualizar-centro" data-centro-id="{{ $centro->id }}" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="pi-action-btn edit btn-editar-centro" data-centro-id="{{ $centro->id }}" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="pi-action-btn delete btn-eliminar-centro" data-centro-id="{{ $centro->id }}" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="pi-empty">
                                    <div class="pi-empty-icon"><i class="fas fa-inbox"></i></div>
                                    <h3>Nenhum centro cadastrado</h3>
                                    <p>Crie um novo centro para começar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="pi-mobile-cards">
            @forelse($centros as $centro)
                <div class="pi-mobile-card">
                    <div class="card-top">
                        <div>
                            <div class="card-name">{{ $centro->nome }}</div>
                            <div class="card-meta">{{ $centro->localizacao ?? 'Sem localização' }} · {{ $centro->email ?? 'Sem email' }}</div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="btn btn-sm btn-outline-primary btn-visualizar-centro" data-centro-id="{{ $centro->id }}"><i class="fas fa-eye me-1"></i>Ver</button>
                        <button class="btn btn-sm btn-outline-primary btn-editar-centro" data-centro-id="{{ $centro->id }}"><i class="fas fa-edit me-1"></i>Editar</button>
                        <button class="btn btn-sm btn-outline-danger btn-eliminar-centro" data-centro-id="{{ $centro->id }}"><i class="fas fa-trash me-1"></i>Eliminar</button>
                    </div>
                </div>
            @empty
                <div class="pi-empty">
                    <div class="pi-empty-icon"><i class="fas fa-inbox"></i></div>
                    <h3>Nenhum centro cadastrado</h3>
                    <p>Crie um novo centro para começar</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- PAGINATION BAR --}}
    <div class="pi-pagination-bar">
        <span class="info">Mostrando {{ $centros->count() }} centro(s)</span>
        <div class="pages">
            <button class="page-btn active">1</button>
        </div>
    </div>
</div>

{{-- MODAL: Visualizar Centro --}}
<div class="modal fade pi-modal" id="modalVisualizarCentro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:580px">
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-info-circle"></i> Informações Gerais</div>
                            <div class="mb-2">
                                <label class="form-label">Nome <span class="required">*</span></label>
                                <input type="text" class="form-control" name="nome" required placeholder="Ex: Centro de Lisboa">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Localização <span class="required">*</span></label>
                                <input type="text" class="form-control" name="localizacao" required placeholder="Ex: Avenida Principal, 123">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-phone"></i> Contacto</div>
                            <div class="mb-2">
                                <label class="form-label">Contacto(s) - Telefones <span class="required">*</span></label>
                                <input type="text" class="form-control" id="contactosInput" required placeholder="Ex: 923111111, 924222222">
                                <div class="form-text">Separe múltiplos telefones por vírgula</div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Ex: centro@email.com">
                            </div>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-info-circle"></i> Informações Gerais</div>
                            <div class="mb-2">
                                <label class="form-label">Nome <span class="required">*</span></label>
                                <input type="text" class="form-control" id="editNome" name="nome" required placeholder="Ex: Centro de Lisboa">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Localização <span class="required">*</span></label>
                                <input type="text" class="form-control" id="editLocalizacao" name="localizacao" required placeholder="Ex: Avenida Principal, 123">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-phone"></i> Contacto</div>
                            <div class="mb-2">
                                <label class="form-label">Contacto(s) - Telefones <span class="required">*</span></label>
                                <input type="text" class="form-control" id="editContactos" name="contactos" required placeholder="Ex: 923111111, 924222222">
                                <div class="form-text">Separe múltiplos telefones por vírgula</div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email" placeholder="Ex: centro@email.com">
                            </div>
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
<script>
$(document).ready(function() {
    configurarEventos();

    let filtroTimeout;
    $('#filtroNome, #filtroLocalizacao').on('input', function() {
        clearTimeout(filtroTimeout);
        filtroTimeout = setTimeout(aplicarFiltros, 300);
    });
});

function carregarCentros() { location.reload(); }

function aplicarFiltros() {
    const nome = $('#filtroNome').val() || '';
    const localizacao = $('#filtroLocalizacao').val() || '';
    let url = '/centros?';
    if (nome) url += `nome=${encodeURIComponent(nome)}&`;
    if (localizacao) url += `localizacao=${encodeURIComponent(localizacao)}`;
    window.location.href = url;
}

function limparFiltros() {
    $('#filtroNome').val('');
    $('#filtroLocalizacao').val('');
    window.location.href = '/centros';
}

function configurarEventos() {
    $('#modalNovoCentro').on('show.bs.modal', function() { $('#formNovoCentroAjax')[0].reset(); });

    $(document).on('click', '.btn-visualizar-centro', function(e) {
        e.preventDefault();
        visualizarCentro($(this).data('centro-id'));
    });
    $(document).on('click', '.btn-editar-centro', function(e) {
        e.preventDefault();
        abrirEdicaoCentro($(this).data('centro-id'));
    });
    $(document).on('click', '.btn-eliminar-centro', function(e) {
        e.preventDefault();
        eliminarCentro($(this).data('centro-id'));
    });
    $('#formNovoCentroAjax').on('submit', function(e) { e.preventDefault(); criarCentro(); });
    $('#formEditarCentroAjax').on('submit', function(e) { e.preventDefault(); atualizarCentro(); });
}

function visualizarCentro(centroId) {
    $.ajax({
        url: `/centros/${centroId}`,
        method: 'GET',
        success: function(response) {
            const centro = response.dados || response;
            const conteudo = `
                <div class="pi-detail-row">
                    <div class="pi-detail-icon"><i class="fas fa-building"></i></div>
                    <div><div class="pi-detail-label">Nome</div><div class="pi-detail-value">${centro.nome}</div></div>
                </div>
                <div class="pi-detail-row">
                    <div class="pi-detail-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div><div class="pi-detail-label">Localização</div><div class="pi-detail-value">${centro.localizacao || 'N/A'}</div></div>
                </div>
                <div class="pi-detail-row">
                    <div class="pi-detail-icon"><i class="fas fa-phone"></i></div>
                    <div><div class="pi-detail-label">Contacto(s)</div><div class="pi-detail-value">${(centro.contactos && centro.contactos.length > 0) ? centro.contactos.join(', ') : 'N/A'}</div></div>
                </div>
                <div class="pi-detail-row">
                    <div class="pi-detail-icon"><i class="fas fa-envelope"></i></div>
                    <div><div class="pi-detail-label">Email</div><div class="pi-detail-value">${centro.email || 'N/A'}</div></div>
                </div>
            `;
            $('#conteudoVisualizarCentro').html(conteudo);
            $('#modalVisualizarCentro').modal('show');
        },
        error: function(xhr) {
            Swal.fire({ icon: 'error', title: 'Erro!', text: xhr.responseJSON?.mensagem || 'Erro ao carregar detalhes', confirmButtonColor: '#1d4ed8' });
        }
    });
}

function abrirEdicaoCentro(centroId) {
    $.ajax({
        url: `/centros/${centroId}`,
        method: 'GET',
        success: function(response) {
            const centro = response.dados || response;
            $('#editCentroId').val(centro.id);
            $('#editNome').val(centro.nome);
            $('#editLocalizacao').val(centro.localizacao || '');
            $('#editContactos').val((centro.contactos && centro.contactos.length > 0) ? centro.contactos.join(', ') : '');
            $('#editEmail').val(centro.email || '');
            new bootstrap.Modal(document.getElementById('modalEditarCentro')).show();
        },
        error: function() {
            Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao carregar dados do centro', confirmButtonColor: '#1d4ed8' });
        }
    });
}

function criarCentro() {
    const contactosInput = $('#contactosInput').val().trim();
    const contactosArray = contactosInput.split(',').map(c => c.trim()).filter(c => c.length > 0);
    if (contactosArray.length === 0) {
        Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'Adicione pelo menos um contacto', confirmButtonColor: '#1d4ed8' });
        return;
    }
    const dados = {
        nome: $('#formNovoCentroAjax [name="nome"]').val(),
        localizacao: $('#formNovoCentroAjax [name="localizacao"]').val(),
        contactos: contactosArray,
        email: $('#formNovoCentroAjax [name="email"]').val()
    };
    $.ajax({
        url: '/centros',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(dados),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() {
            Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Centro criado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
            bootstrap.Modal.getInstance(document.getElementById('modalNovoCentro')).hide();
            $('#formNovoCentroAjax')[0].reset();
            carregarCentros();
        },
        error: function(xhr) {
            let mensagem = 'Erro ao criar centro';
            if (xhr.responseJSON?.errors) mensagem = Object.values(xhr.responseJSON.errors).flat().join(', ');
            else if (xhr.responseJSON?.mensagem) mensagem = xhr.responseJSON.mensagem;
            Swal.fire({ icon: 'error', title: 'Erro!', text: mensagem, confirmButtonColor: '#1d4ed8' });
        }
    });
}

function atualizarCentro() {
    const centroId = $('#editCentroId').val();
    const contactosInput = $('#editContactos').val().trim();
    const contactosArray = contactosInput.split(',').map(c => c.trim()).filter(c => c.length > 0);
    if (contactosArray.length === 0) {
        Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'Adicione pelo menos um contacto', confirmButtonColor: '#1d4ed8' });
        return;
    }
    const dados = {
        nome: $('#editNome').val(),
        localizacao: $('#editLocalizacao').val(),
        contactos: contactosArray,
        email: $('#editEmail').val()
    };
    $.ajax({
        url: `/centros/${centroId}`,
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(dados),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() {
            Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Centro atualizado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
            bootstrap.Modal.getInstance(document.getElementById('modalEditarCentro')).hide();
            carregarCentros();
        },
        error: function(xhr) {
            let mensagem = 'Erro ao atualizar centro';
            if (xhr.responseJSON?.errors) mensagem = Object.values(xhr.responseJSON.errors).flat().join(', ');
            else if (xhr.responseJSON?.mensagem) mensagem = xhr.responseJSON.mensagem;
            Swal.fire({ icon: 'error', title: 'Erro!', text: mensagem, confirmButtonColor: '#1d4ed8' });
        }
    });
}

function eliminarCentro(centroId) {
    Swal.fire({
        title: 'Eliminar centro?',
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
                url: `/centros/${centroId}`,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function() {
                    Swal.fire({ icon: 'success', title: 'Eliminado!', text: 'Centro eliminado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
                    carregarCentros();
                },
                error: function(xhr) {
                    let mensagem = 'Erro ao eliminar centro';
                    if (xhr.responseJSON?.mensagem) mensagem = xhr.responseJSON.mensagem;
                    else if (xhr.responseJSON?.message) mensagem = xhr.responseJSON.message;
                    else if (xhr.status === 409) mensagem = 'Este centro não pode ser eliminado (existem cursos associados)';
                    Swal.fire({ icon: 'error', title: 'Erro!', text: mensagem, confirmButtonColor: '#1d4ed8' });
                }
            });
        }
    });
}
</script>
@endsection
