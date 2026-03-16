@extends('layouts.app')

@section('title', 'Grupos')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    :root {
        --pi-primary: #1d4ed8; --pi-primary-dark: #1e40af;
        --pi-primary-light: rgba(29,78,216,0.08);
        --pi-primary-gradient: linear-gradient(135deg,#1d4ed8 0%,#1e40af 100%);
        --pi-success: #16a34a; --pi-success-light: rgba(22,163,74,0.08);
        --pi-warning: #d97706; --pi-warning-light: rgba(217,119,6,0.08);
        --pi-danger: #dc2626;  --pi-danger-light: rgba(220,38,38,0.08);
        --pi-info: #0284c7;    --pi-info-light: rgba(2,132,199,0.08);
        --pi-muted: #64748b; --pi-border: #dbeafe; --pi-bg: #eff6ff;
        --pi-text: #1e3a8a; --pi-text-muted: #64748b;
        --pi-radius: 0.5rem; --pi-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }
    body { background-color:var(--pi-bg); font-family:'Plus Jakarta Sans','Inter',system-ui,sans-serif; color:var(--pi-text); }
    .pi-page { width:100%; padding:0; overflow-x:hidden; }

    .pi-page-header { background:var(--pi-primary-gradient); color:#fff; padding:1rem 1.5rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.75rem; }
    .pi-page-header h1 { font-size:1.25rem; font-weight:700; margin:0; letter-spacing:-0.02em; color:#fff; }
    .pi-page-header p  { font-size:0.75rem; color:rgba(255,255,255,0.75); margin:0; }
    .pi-page-header .pi-btn-create { display:inline-flex; align-items:center; gap:0.5rem; padding:0.5rem 1rem; border-radius:var(--pi-radius); background:#fff; color:var(--pi-primary); font-weight:600; font-size:0.8125rem; border:none; cursor:pointer; transition:all 0.15s; white-space:nowrap; flex-shrink:0; }
    .pi-page-header .pi-btn-create:hover { background:#dbeafe; }

    .pi-stats-bar { display:grid; grid-template-columns:repeat(4,1fr); gap:0; background:#fff; border-bottom:1px solid var(--pi-border); }
    .pi-stat { padding:0.75rem 1.25rem; border-right:1px solid var(--pi-border); display:flex; align-items:center; gap:0.75rem; min-width:0; }
    .pi-stat:last-child { border-right:none; }
    .pi-stat-icon { width:2.25rem; height:2.25rem; border-radius:0.5rem; display:flex; align-items:center; justify-content:center; font-size:0.875rem; flex-shrink:0; }
    .pi-stat-icon.blue  { background:var(--pi-primary-light); color:var(--pi-primary); }
    .pi-stat-icon.green { background:var(--pi-success-light); color:var(--pi-success); }
    .pi-stat-icon.cyan  { background:var(--pi-info-light);    color:var(--pi-info); }
    .pi-stat-icon.gray  { background:rgba(100,116,139,0.08);  color:var(--pi-muted); }
    .pi-stat-label { font-size:0.6875rem; font-weight:500; color:var(--pi-text-muted); text-transform:uppercase; letter-spacing:0.04em; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .pi-stat-value { font-size:1.375rem; font-weight:700; line-height:1; }

    .pi-toolbar { background:#fff; border-bottom:1px solid var(--pi-border); padding:0.625rem 1.25rem; display:flex; flex-wrap:nowrap; align-items:center; gap:0.5rem; overflow-x:auto; }
    .pi-toolbar .search-wrap { position:relative; flex:1 1 180px; min-width:140px; }
    .pi-toolbar .search-wrap i { position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:var(--pi-primary); font-size:0.8125rem; pointer-events:none; }
    .pi-toolbar .search-wrap input { width:100%; padding:0.375rem 0.75rem 0.375rem 2.25rem; border:1px solid var(--pi-border); border-radius:var(--pi-radius); font-size:0.8125rem; background:var(--pi-bg); height:2.125rem; transition:all 0.15s; }
    .pi-toolbar .search-wrap input:focus { outline:none; border-color:var(--pi-primary); box-shadow:0 0 0 2px var(--pi-primary-light); background:#fff; }
    .pi-btn-clear { border:none; background:transparent; color:var(--pi-text-muted); font-size:0.8125rem; padding:0.375rem 0.5rem; border-radius:var(--pi-radius); display:inline-flex; align-items:center; gap:0.25rem; cursor:pointer; white-space:nowrap; flex-shrink:0; }
    .pi-btn-clear:hover { background:var(--pi-danger-light); color:var(--pi-danger); }

    .pi-table-wrap { background:#fff; overflow-x:auto; -webkit-overflow-scrolling:touch; }
    .pi-table { width:100%; margin:0; border-collapse:collapse; font-size:0.8125rem; table-layout:auto; }
    .pi-table thead th { background:var(--pi-primary); color:#fff; font-size:0.6875rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; padding:0.625rem 1rem; white-space:nowrap; position:sticky; top:0; z-index:5; border-bottom:none; }
    .pi-table tbody td { padding:0.5rem 1rem; vertical-align:middle; border-bottom:1px solid #f0f4ff; white-space:nowrap; }
    .pi-table tbody tr { transition:background 0.1s; }
    .pi-table tbody tr:hover { background:var(--pi-primary-light); }
    .pi-table tbody tr:last-child td { border-bottom:none; }
    .pi-table .mono { font-family:'SF Mono','Fira Code',monospace; font-size:0.6875rem; color:var(--pi-muted); }

    .pi-pagination-bar { background:var(--pi-primary); color:#fff; padding:0.5rem 1.25rem; display:flex; align-items:center; justify-content:space-between; font-size:0.75rem; flex-wrap:wrap; gap:0.5rem; }
    .pi-pagination-bar .info { opacity:0.85; }
    .pi-pagination-bar .pages { display:flex; gap:0.25rem; flex-wrap:wrap; }
    .pi-pagination-bar .page-btn { padding:0.25rem 0.625rem; border-radius:0.25rem; border:1px solid rgba(255,255,255,0.3); background:transparent; color:#fff; cursor:pointer; font-size:0.75rem; font-weight:500; transition:all 0.15s; }
    .pi-pagination-bar .page-btn:hover { background:rgba(255,255,255,0.15); }
    .pi-pagination-bar .page-btn.active { background:#fff; color:var(--pi-primary); font-weight:700; border-color:#fff; }
    .pi-pagination-bar .page-btn:disabled { opacity:0.4; cursor:not-allowed; }

    .pi-badge { display:inline-flex; align-items:center; gap:0.25rem; padding:0.15rem 0.5rem; border-radius:9999px; font-size:0.6875rem; font-weight:600; }
    .pi-badge-success { background:var(--pi-success-light); color:#15803d; }
    .pi-badge-gray    { background:rgba(100,116,139,0.1);   color:var(--pi-muted); }
    .pi-badge-info    { background:var(--pi-info-light);    color:#0369a1; }

    .pi-actions { display:flex; align-items:center; justify-content:flex-end; gap:0.125rem; transition:opacity 0.15s; }
    @media (hover:hover) and (pointer:fine) { .pi-actions { opacity:0; } .pi-table tbody tr:hover .pi-actions { opacity:1; } }
    .pi-action-btn { width:1.75rem; height:1.75rem; border:none; border-radius:0.25rem; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.15s; font-size:0.75rem; }
    .pi-action-btn.view   { background:transparent; color:var(--pi-primary); }
    .pi-action-btn.view:hover   { background:var(--pi-primary-light); }
    .pi-action-btn.edit   { background:transparent; color:var(--pi-primary); border:1px solid var(--pi-primary); }
    .pi-action-btn.edit:hover   { background:var(--pi-primary); color:#fff; }
    .pi-action-btn.delete { background:transparent; color:var(--pi-danger); border:1px solid var(--pi-danger); }
    .pi-action-btn.delete:hover { background:var(--pi-danger); color:#fff; }

    .pi-empty { text-align:center; padding:3rem 1rem; color:var(--pi-text-muted); }
    .pi-empty-icon { width:3.5rem; height:3.5rem; border-radius:0.75rem; background:var(--pi-primary-light); display:inline-flex; align-items:center; justify-content:center; font-size:1.25rem; margin-bottom:0.75rem; color:var(--pi-primary); }
    .pi-empty h3 { font-size:1rem; font-weight:600; margin-bottom:0.25rem; color:var(--pi-text); }
    .pi-empty p { font-size:0.8125rem; }

    .pi-mobile-cards { display:none; padding:0.75rem; }
    .pi-mobile-card { background:#fff; border:1px solid var(--pi-border); border-radius:var(--pi-radius); padding:0.75rem; box-shadow:var(--pi-shadow); margin-bottom:0.5rem; }
    .pi-mobile-card .card-top { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.375rem; gap:0.5rem; }
    .pi-mobile-card .card-name { font-weight:600; font-size:0.875rem; color:var(--pi-text); word-break:break-word; }
    .pi-mobile-card .card-meta { font-size:0.6875rem; color:var(--pi-text-muted); margin-bottom:0.375rem; }
    .pi-mobile-card .card-actions { display:flex; gap:0.375rem; flex-wrap:wrap; }
    .pi-mobile-card .card-actions .btn { font-size:0.6875rem; padding:0.2rem 0.5rem; }

    .pi-modal .modal-content { border-radius:var(--pi-radius); border:1px solid var(--pi-border); box-shadow:0 25px 50px -12px rgba(0,0,0,0.15); }
    .pi-modal .modal-header { border-bottom:1px solid var(--pi-border); padding:1rem 1.25rem; background:var(--pi-primary-light); }
    .pi-modal .modal-header .header-flex { display:flex; align-items:center; gap:0.625rem; }
    .pi-modal .modal-header .header-icon { width:2.25rem; height:2.25rem; border-radius:0.5rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .pi-modal .modal-header .header-icon.blue   { background:var(--pi-primary); color:#fff; }
    .pi-modal .modal-header .header-icon.green  { background:var(--pi-success); color:#fff; }
    .pi-modal .modal-header .header-icon.orange { background:var(--pi-warning); color:#fff; }
    .pi-modal .modal-title    { font-size:0.9375rem; font-weight:600; margin:0; color:var(--pi-text); }
    .pi-modal .modal-subtitle { font-size:0.75rem; color:var(--pi-text-muted); margin:0; }
    .pi-modal .modal-body   { padding:1rem 1.25rem; }
    .pi-modal .modal-footer { border-top:1px solid var(--pi-border); padding:0.75rem 1.25rem; background:var(--pi-bg); }
    .pi-modal .modal-footer .btn { border-radius:var(--pi-radius); font-size:0.8125rem; font-weight:500; padding:0.4375rem 0.875rem; }

    .pi-detail-row { display:flex; align-items:flex-start; gap:0.625rem; padding:0.5rem 0; border-bottom:1px solid #f0f4ff; }
    .pi-detail-row:last-child { border-bottom:none; }
    .pi-detail-icon  { width:1.75rem; height:1.75rem; border-radius:0.375rem; background:var(--pi-primary-light); display:flex; align-items:center; justify-content:center; color:var(--pi-primary); font-size:0.75rem; flex-shrink:0; }
    .pi-detail-label { font-size:0.6875rem; font-weight:500; color:var(--pi-text-muted); text-transform:uppercase; letter-spacing:0.03em; }
    .pi-detail-value { font-size:0.8125rem; font-weight:500; margin-top:0.0625rem; word-break:break-word; }

    .pi-form .form-label { font-size:0.75rem; font-weight:500; margin-bottom:0.25rem; color:var(--pi-text); }
    .pi-form .form-label .required { color:var(--pi-danger); }
    .pi-form .form-control, .pi-form .form-select { border-radius:var(--pi-radius); border-color:var(--pi-border); font-size:0.8125rem; height:2.25rem; }
    .pi-form textarea.form-control { height:auto; }
    .pi-form .form-control:focus, .pi-form .form-select:focus { border-color:var(--pi-primary); box-shadow:0 0 0 2px var(--pi-primary-light); }
    .pi-form .form-text { font-size:0.6875rem; color:var(--pi-text-muted); }
    .pi-form .section-title { font-size:0.75rem; font-weight:600; color:var(--pi-primary); margin-bottom:0.625rem; padding-bottom:0.375rem; border-bottom:2px solid var(--pi-primary); display:flex; align-items:center; gap:0.375rem; text-transform:uppercase; letter-spacing:0.03em; }

    .pi-icone-preview { width:2.25rem; height:2.25rem; border-radius:0.5rem; background:var(--pi-primary-light); display:inline-flex; align-items:center; justify-content:center; color:var(--pi-primary); font-size:1rem; }

    .pi-btn-primary { background:var(--pi-primary); border:none; color:#fff; border-radius:var(--pi-radius); padding:0.4375rem 0.875rem; font-size:0.8125rem; font-weight:500; display:inline-flex; align-items:center; gap:0.375rem; transition:all 0.15s; cursor:pointer; }
    .pi-btn-primary:hover { background:var(--pi-primary-dark); color:#fff; }

    @media (max-width:991.98px) { .pi-desktop-table { display:none !important; } .pi-mobile-cards { display:block !important; } }
    @media (max-width:767.98px) {
        .pi-stats-bar { grid-template-columns:repeat(2,1fr); }
        .pi-stat { border-bottom:1px solid var(--pi-border); }
        .pi-page-header { flex-direction:column; align-items:stretch; }
        .pi-page-header .pi-btn-create { justify-content:center; }
        .pi-pagination-bar { flex-direction:column; gap:0.5rem; text-align:center; }
    }
    @media (max-width:575.98px) { .pi-page-header { padding:0.75rem; } .pi-page-header h1 { font-size:1.1rem; } .pi-toolbar { padding:0.5rem 0.75rem; } .pi-stat { padding:0.5rem 0.75rem; } .pi-stat-value { font-size:1.125rem; } }
    @media (max-width:374.98px) { .pi-stats-bar { grid-template-columns:1fr; } .pi-stat { border-right:none; } }
</style>
@endsection

@section('content')
<div class="pi-page">

    {{-- HEADER --}}
    <div class="pi-page-header">
        <div>
            <div style="display:flex;align-items:center;gap:0.625rem">
                <i class="fas fa-layer-group fa-lg" style="opacity:0.9"></i>
                <div>
                    <h1>Gestão de Grupos</h1>
                    <p>Gerir todos os grupos de categorias do sistema</p>
                </div>
            </div>
        </div>
        <button class="pi-btn-create" data-bs-toggle="modal" data-bs-target="#modalNovoGrupo">
            <i class="fas fa-plus"></i> Novo Grupo
        </button>
    </div>

    {{-- STATS --}}
    <div class="pi-stats-bar">
        <div class="pi-stat">
            <div class="pi-stat-icon blue"><i class="fas fa-layer-group"></i></div>
            <div style="min-width:0">
                <div class="pi-stat-label">Total</div>
                <div class="pi-stat-value" style="color:var(--pi-primary)">{{ $grupos->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div style="min-width:0">
                <div class="pi-stat-label">Ativos</div>
                <div class="pi-stat-value" style="color:var(--pi-success)">{{ $grupos->where('ativo', true)->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon gray"><i class="fas fa-times-circle"></i></div>
            <div style="min-width:0">
                <div class="pi-stat-label">Inativos</div>
                <div class="pi-stat-value" style="color:var(--pi-muted)">{{ $grupos->where('ativo', false)->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon cyan"><i class="fas fa-tags"></i></div>
            <div style="min-width:0">
                <div class="pi-stat-label">Categorias</div>
                <div class="pi-stat-value" style="color:var(--pi-info)">{{ $grupos->sum(fn($g) => $g->categorias_count ?? $g->categorias->count()) }}</div>
            </div>
        </div>
    </div>

    {{-- TOOLBAR --}}
    <div class="pi-toolbar">
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="filtroNome" placeholder="Pesquisar por nome ou display name...">
        </div>
        <button class="pi-btn-clear" id="btnLimparFiltros" onclick="limparFiltros()" disabled>
            <i class="fas fa-times-circle"></i> Limpar
        </button>
    </div>

    {{-- TABLE --}}
    <div class="pi-table-wrap">
        <div class="pi-desktop-table">
            <table class="pi-table">
                <thead>
                    <tr>
                        <th style="width:50px">ID</th>
                        <th>Nome</th>
                        <th>Display Name</th>
                        <th>Ícone</th>
                        <th style="text-align:center">Categorias</th>
                        <th style="text-align:center">Ordem</th>
                        <th style="text-align:center">Status</th>
                        <th style="text-align:right;width:100px">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaBody"></tbody>
            </table>
        </div>
        <div class="pi-mobile-cards" id="mobileCards"></div>
        <div class="pi-empty d-none" id="emptyState">
            <div class="pi-empty-icon"><i class="fas fa-inbox"></i></div>
            <h3>Nenhum grupo encontrado</h3>
            <p>Tente ajustar o filtro ou criar um novo grupo</p>
        </div>
    </div>

    <div class="pi-pagination-bar" id="paginationContainer">
        <span class="info" id="paginationInfo"></span>
        <div class="pages" id="paginationPages"></div>
    </div>
</div>

{{-- MODAL: Visualizar --}}
<div class="modal fade pi-modal" id="modalVisualizarGrupo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon green"><i class="fas fa-eye"></i></div>
                    <div>
                        <h5 class="modal-title">Detalhes do Grupo</h5>
                        <p class="modal-subtitle">Informações completas</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="conteudoVisualizarGrupo">
                <div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Criar --}}
<div class="modal fade pi-modal" id="modalNovoGrupo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue"><i class="fas fa-plus-circle"></i></div>
                    <div>
                        <h5 class="modal-title">Criar Novo Grupo</h5>
                        <p class="modal-subtitle">Preencha os dados do grupo</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNovoGrupoAjax" class="pi-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nome <span class="required">*</span></label>
                        <input type="text" class="form-control" name="nome" required placeholder="Ex: alimentacao">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Display Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="display_name" required placeholder="Ex: Alimentação">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ícone (Font Awesome)</label>
                        <div class="d-flex gap-2 align-items-center">
                            <input type="text" class="form-control" name="icone" id="novoIconeInput" placeholder="fas fa-utensils" oninput="previewIcone('novoIconeInput','novoIconePreview')">
                            <div class="pi-icone-preview" id="novoIconePreview"><i class="fas fa-question"></i></div>
                        </div>
                        <div class="form-text">Ex: fas fa-utensils, fas fa-box, fas fa-cogs</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ordem</label>
                        <input type="number" class="form-control" name="ordem" value="0">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="novoAtivo" name="ativo" value="1" checked>
                        <label class="form-check-label" for="novoAtivo" style="font-size:0.8125rem">Ativo</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoGrupoAjax" class="btn pi-btn-primary"><i class="fas fa-save"></i> Criar Grupo</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Editar --}}
<div class="modal fade pi-modal" id="modalEditarGrupo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon orange"><i class="fas fa-edit"></i></div>
                    <div>
                        <h5 class="modal-title">Editar Grupo</h5>
                        <p class="modal-subtitle">Atualizar dados do grupo</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarGrupoAjax" class="pi-form">
                    @csrf
                    <input type="hidden" id="editGrupoId">
                    <div class="mb-3">
                        <label class="form-label">Nome <span class="required">*</span></label>
                        <input type="text" class="form-control" id="editNome" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Display Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="editDisplayName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ícone (Font Awesome)</label>
                        <div class="d-flex gap-2 align-items-center">
                            <input type="text" class="form-control" id="editIconeInput" placeholder="fas fa-utensils" oninput="previewIcone('editIconeInput','editIconePreview')">
                            <div class="pi-icone-preview" id="editIconePreview"><i class="fas fa-question"></i></div>
                        </div>
                        <div class="form-text">Ex: fas fa-utensils, fas fa-box, fas fa-cogs</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ordem</label>
                        <input type="number" class="form-control" id="editOrdem">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="editAtivo" value="1">
                        <label class="form-check-label" for="editAtivo" style="font-size:0.8125rem">Ativo</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarGrupoAjax" class="btn pi-btn-primary"><i class="fas fa-save"></i> Guardar Alterações</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function() {
    'use strict';

    let allData = @json($grupos->loadCount('categorias')->values());
    let filteredData = [];
    let currentPage = 1;
    const PER_PAGE = 15;

    $(document).ready(function() {
        bindEventosFiltros();
        configurarEventos();
        aplicarFiltrosLocais();
    });

    window.previewIcone = function(inputId, previewId) {
        const val = document.getElementById(inputId).value.trim();
        const prev = document.getElementById(previewId);
        prev.innerHTML = val ? '<i class="' + val + '"></i>' : '<i class="fas fa-question"></i>';
    };

    /* ── FILTROS ── */
    function bindEventosFiltros() {
        let t;
        $('#filtroNome').on('input', function() { clearTimeout(t); t = setTimeout(aplicarFiltrosLocais, 250); });
    }

    function aplicarFiltrosLocais() {
        const nome = ($('#filtroNome').val() || '').toLowerCase().trim();
        filteredData = allData.filter(function(g) {
            if (nome && !(g.nome || '').toLowerCase().includes(nome) && !(g.display_name || '').toLowerCase().includes(nome)) return false;
            return true;
        });
        $('#btnLimparFiltros').prop('disabled', !nome);
        currentPage = 1;
        renderTabela();
    }

    window.limparFiltros = function() { $('#filtroNome').val(''); aplicarFiltrosLocais(); };

    /* ── RENDER ── */
    function esc(str) {
        if (!str && str !== 0) return '';
        const d = document.createElement('div'); d.textContent = String(str); return d.innerHTML;
    }

    function statusBadge(ativo) {
        return ativo
            ? '<span class="pi-badge pi-badge-success"><i class="fas fa-check" style="margin-right:0.2rem"></i>Ativo</span>'
            : '<span class="pi-badge pi-badge-gray">Inativo</span>';
    }

    function catCount(g) { return g.categorias_count ?? (g.categorias ? g.categorias.length : 0); }

    function renderTabela() {
        const total = filteredData.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;
        const start = (currentPage - 1) * PER_PAGE;
        const paged = filteredData.slice(start, start + PER_PAGE);

        if (total === 0) {
            $('#tabelaBody').empty(); $('#mobileCards').empty();
            $('#emptyState').removeClass('d-none');
            $('#paginationInfo').text('Nenhum grupo encontrado');
            $('#paginationPages').empty();
            return;
        }
        $('#emptyState').addClass('d-none');

        let html = '';
        paged.forEach(function(g) {
            const iconeHtml = g.icone
                ? '<span style="display:inline-flex;align-items:center;gap:0.375rem"><i class="' + esc(g.icone) + '" style="color:var(--pi-primary)"></i><span class="mono" style="font-size:0.6875rem">' + esc(g.icone) + '</span></span>'
                : '<span style="color:var(--pi-text-muted)">—</span>';

            html += '<tr>';
            html += '<td class="mono">#' + g.id + '</td>';
            html += '<td><strong style="font-size:0.8125rem">' + esc(g.nome) + '</strong></td>';
            html += '<td style="font-size:0.8125rem">' + esc(g.display_name) + '</td>';
            html += '<td>' + iconeHtml + '</td>';
            html += '<td style="text-align:center"><span class="pi-badge pi-badge-info">' + catCount(g) + '</span></td>';
            html += '<td style="text-align:center;color:var(--pi-text-muted);font-size:0.8125rem">' + (g.ordem ?? 0) + '</td>';
            html += '<td style="text-align:center">' + statusBadge(g.ativo) + '</td>';
            html += '<td><div class="pi-actions">';
            html += '<button class="pi-action-btn view"   onclick="visualizarGrupo(' + g.id + ')" title="Ver"><i class="fas fa-eye"></i></button>';
            html += '<button class="pi-action-btn edit"   onclick="abrirEdicaoGrupo(' + g.id + ')" title="Editar"><i class="fas fa-edit"></i></button>';
            html += '<button class="pi-action-btn delete" onclick="eliminarGrupo(' + g.id + ')" title="Eliminar"><i class="fas fa-trash"></i></button>';
            html += '</div></td></tr>';
        });
        $('#tabelaBody').html(html);

        let mhtml = '';
        paged.forEach(function(g) {
            mhtml += '<div class="pi-mobile-card">';
            mhtml += '<div class="card-top"><div><div class="card-name">' + (g.icone ? '<i class="' + esc(g.icone) + '" style="margin-right:0.375rem;color:var(--pi-primary)"></i>' : '') + esc(g.display_name) + '</div>';
            mhtml += '<div class="card-meta">' + esc(g.nome) + ' · ' + catCount(g) + ' categorias</div></div></div>';
            mhtml += '<div class="card-actions">';
            mhtml += '<button class="btn btn-sm btn-outline-primary" onclick="visualizarGrupo(' + g.id + ')"><i class="fas fa-eye me-1"></i>Ver</button>';
            mhtml += '<button class="btn btn-sm btn-outline-primary" onclick="abrirEdicaoGrupo(' + g.id + ')"><i class="fas fa-edit me-1"></i>Editar</button>';
            mhtml += '<button class="btn btn-sm btn-outline-danger"  onclick="eliminarGrupo(' + g.id + ')"><i class="fas fa-trash me-1"></i>Eliminar</button>';
            mhtml += '</div></div>';
        });
        $('#mobileCards').html(mhtml);

        const from = start + 1, to = Math.min(start + PER_PAGE, total);
        $('#paginationInfo').text('Mostrando ' + from + '–' + to + ' de ' + total + ' grupo(s)');

        if (totalPages > 1) {
            let ph = '<button class="page-btn" onclick="goToPage(' + (currentPage - 1) + ')"' + (currentPage <= 1 ? ' disabled' : '') + '><i class="fas fa-chevron-left" style="font-size:0.6rem"></i></button>';
            const maxB = 7; let sB = Math.max(1, currentPage - Math.floor(maxB / 2)); let eB = Math.min(totalPages, sB + maxB - 1);
            if (eB - sB < maxB - 1) sB = Math.max(1, eB - maxB + 1);
            for (let p = sB; p <= eB; p++) ph += '<button class="page-btn' + (p === currentPage ? ' active' : '') + '" onclick="goToPage(' + p + ')">' + p + '</button>';
            ph += '<button class="page-btn" onclick="goToPage(' + (currentPage + 1) + ')"' + (currentPage >= totalPages ? ' disabled' : '') + '><i class="fas fa-chevron-right" style="font-size:0.6rem"></i></button>';
            $('#paginationPages').html(ph);
        } else { $('#paginationPages').empty(); }
    }

    window.goToPage = function(page) {
        const totalPages = Math.max(1, Math.ceil(filteredData.length / PER_PAGE));
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderTabela();
        $('.pi-table-wrap')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    /* ── EVENTOS ── */
    function configurarEventos() {
        $('#modalNovoGrupo').on('show.bs.modal', function() {
            $('#formNovoGrupoAjax')[0].reset();
            document.getElementById('novoIconePreview').innerHTML = '<i class="fas fa-question"></i>';
        });
        $('#formNovoGrupoAjax').on('submit', function(e) { e.preventDefault(); criarGrupo(); });
        $('#formEditarGrupoAjax').on('submit', function(e) { e.preventDefault(); atualizarGrupo(); });
    }

    /* ── VISUALIZAR ── */
    window.visualizarGrupo = function(id) {
        const local = allData.find(function(g) { return g.id == id; });
        if (local) { renderVisualizarModal(local); return; }
        $('#conteudoVisualizarGrupo').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>');
        new bootstrap.Modal(document.getElementById('modalVisualizarGrupo')).show();
        $.ajax({ url: '/grupos/' + id, method: 'GET', success: function(r) { renderVisualizarModal(r.data || r); }, error: function() { $('#conteudoVisualizarGrupo').html('<div class="text-center py-3 text-danger">Erro ao carregar</div>'); } });
    };

    function renderVisualizarModal(g) {
        const iconeHtml = g.icone ? '<i class="' + esc(g.icone) + '" style="margin-right:0.375rem"></i>' + esc(g.icone) : '—';
        const conteudo = dr('fa-layer-group', 'Nome',         esc(g.nome))
            + dr('fa-tag',          'Display Name', esc(g.display_name))
            + dr('fa-icons',        'Ícone',        iconeHtml)
            + dr('fa-sort-numeric-up', 'Ordem',     esc(g.ordem ?? 0))
            + dr('fa-tags',         'Categorias',   '<span class="pi-badge pi-badge-info">' + catCount(g) + '</span>')
            + dr('fa-circle',       'Status',       statusBadge(g.ativo));
        $('#conteudoVisualizarGrupo').html(conteudo);
        new bootstrap.Modal(document.getElementById('modalVisualizarGrupo')).show();
    }

    function dr(icon, label, value) {
        return '<div class="pi-detail-row"><div class="pi-detail-icon"><i class="fas ' + icon + '"></i></div><div style="min-width:0;flex:1"><div class="pi-detail-label">' + label + '</div><div class="pi-detail-value">' + value + '</div></div></div>';
    }

    /* ── EDITAR ── */
    window.abrirEdicaoGrupo = function(id) {
        const local = allData.find(function(g) { return g.id == id; });
        if (local) { preencherFormEditar(local); return; }
        $.ajax({ url: '/grupos/' + id, method: 'GET', success: function(r) { preencherFormEditar(r.data || r); }, error: function() { Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao carregar dados', confirmButtonColor: '#1d4ed8' }); } });
    };

    function preencherFormEditar(g) {
        $('#editGrupoId').val(g.id);
        $('#editNome').val(g.nome);
        $('#editDisplayName').val(g.display_name);
        $('#editIconeInput').val(g.icone || '');
        $('#editOrdem').val(g.ordem ?? 0);
        $('#editAtivo').prop('checked', !!g.ativo);
        const prev = document.getElementById('editIconePreview');
        prev.innerHTML = g.icone ? '<i class="' + g.icone + '"></i>' : '<i class="fas fa-question"></i>';
        new bootstrap.Modal(document.getElementById('modalEditarGrupo')).show();
    }

    /* ── CRIAR ── */
    function criarGrupo() {
        const dados = {
            nome:         $('[name="nome"]', '#formNovoGrupoAjax').val(),
            display_name: $('[name="display_name"]', '#formNovoGrupoAjax').val(),
            icone:        $('[name="icone"]', '#formNovoGrupoAjax').val() || null,
            ordem:        parseInt($('[name="ordem"]', '#formNovoGrupoAjax').val()) || 0,
            ativo:        $('#novoAtivo').is(':checked') ? 1 : 0
        };
        $.ajax({
            url: "{{ route('grupos.store') }}", method: 'POST',
            contentType: 'application/json', data: JSON.stringify(dados),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(r) {
                const novo = r.data || r;
                if (novo && novo.id) { novo.categorias_count = 0; allData.unshift(novo); }
                aplicarFiltrosLocais();
                bootstrap.Modal.getInstance(document.getElementById('modalNovoGrupo')).hide();
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Grupo criado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
            },
            error: function(xhr) {
                let msg = 'Erro ao criar grupo';
                if (xhr.responseJSON?.errors) msg = Object.values(xhr.responseJSON.errors).flat().join(', ');
                else if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;
                Swal.fire({ icon: 'error', title: 'Erro!', text: msg, confirmButtonColor: '#1d4ed8' });
            }
        });
    }

    /* ── ATUALIZAR ── */
    function atualizarGrupo() {
        const id = $('#editGrupoId').val();
        const dados = {
            _method:      'PUT',
            nome:         $('#editNome').val(),
            display_name: $('#editDisplayName').val(),
            icone:        $('#editIconeInput').val() || null,
            ordem:        parseInt($('#editOrdem').val()) || 0,
            ativo:        $('#editAtivo').is(':checked') ? 1 : 0
        };
        $.ajax({
            url: '/grupos/' + id, method: 'POST',
            contentType: 'application/json', data: JSON.stringify(dados),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(r) {
                const upd = r.data || r;
                const idx = allData.findIndex(function(g) { return g.id == id; });
                if (idx !== -1 && upd && upd.id) { upd.categorias_count = allData[idx].categorias_count; allData[idx] = upd; }
                aplicarFiltrosLocais();
                bootstrap.Modal.getInstance(document.getElementById('modalEditarGrupo')).hide();
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Grupo atualizado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
            },
            error: function(xhr) {
                let msg = 'Erro ao atualizar grupo';
                if (xhr.responseJSON?.errors) msg = Object.values(xhr.responseJSON.errors).flat().join(', ');
                else if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;
                Swal.fire({ icon: 'error', title: 'Erro!', text: msg, confirmButtonColor: '#1d4ed8' });
            }
        });
    }

    /* ── ELIMINAR ── */
    window.eliminarGrupo = function(id) {
        Swal.fire({ title: 'Eliminar grupo?', text: 'Todas as categorias e itens associados podem ser afetados!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b', confirmButtonText: '<i class="fas fa-trash me-1"></i> Sim, eliminar!', cancelButtonText: 'Cancelar' })
        .then(function(result) {
            if (!result.isConfirmed) return;
            $.ajax({
                url: '/grupos/' + id, method: 'POST', data: { _method: 'DELETE' },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function() {
                    allData = allData.filter(function(g) { return g.id != id; });
                    aplicarFiltrosLocais();
                    Swal.fire({ icon: 'success', title: 'Eliminado!', text: 'Grupo eliminado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
                },
                error: function() { Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao eliminar grupo', confirmButtonColor: '#1d4ed8' }); }
            });
        });
    };

}());
</script>
@endsection
