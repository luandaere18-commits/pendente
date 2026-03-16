@extends('layouts.app')

@section('title', 'Itens')

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
    body { background-color: var(--pi-bg); font-family: 'Plus Jakarta Sans','Inter',system-ui,sans-serif; color: var(--pi-text); }
    .pi-page { width: 100%; padding: 0; overflow-x: hidden; }

    .pi-page-header { background: var(--pi-primary-gradient); color:#fff; padding:1rem 1.5rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.75rem; }
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
    .pi-stat-icon.yellow{ background:var(--pi-warning-light); color:var(--pi-warning); }
    .pi-stat-icon.gray  { background:rgba(100,116,139,0.08);  color:var(--pi-muted); }
    .pi-stat-label { font-size:0.6875rem; font-weight:500; color:var(--pi-text-muted); text-transform:uppercase; letter-spacing:0.04em; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .pi-stat-value { font-size:1.375rem; font-weight:700; line-height:1; }

    .pi-toolbar { background:#fff; border-bottom:1px solid var(--pi-border); padding:0.625rem 1.25rem; display:flex; flex-wrap:nowrap; align-items:center; gap:0.5rem; overflow-x:auto; }
    .pi-toolbar .search-wrap { position:relative; flex:1 1 160px; min-width:120px; }
    .pi-toolbar .search-wrap i { position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:var(--pi-primary); font-size:0.8125rem; pointer-events:none; }
    .pi-toolbar .search-wrap input { width:100%; padding:0.375rem 0.75rem 0.375rem 2.25rem; border:1px solid var(--pi-border); border-radius:var(--pi-radius); font-size:0.8125rem; background:var(--pi-bg); height:2.125rem; transition:all 0.15s; }
    .pi-toolbar .search-wrap input:focus { outline:none; border-color:var(--pi-primary); box-shadow:0 0 0 2px var(--pi-primary-light); background:#fff; }
    .pi-toolbar .search-wrap select { width:100%; padding:0.375rem 0.75rem 0.375rem 2.25rem; border:1px solid var(--pi-border); border-radius:var(--pi-radius); font-size:0.8125rem; background:var(--pi-bg); height:2.125rem; appearance:auto; }
    .pi-toolbar .search-wrap select:focus { outline:none; border-color:var(--pi-primary); box-shadow:0 0 0 2px var(--pi-primary-light); background:#fff; }
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
    .pi-badge-primary { background:var(--pi-primary-light); color:#1e40af; }
    .pi-badge-success { background:var(--pi-success-light); color:#15803d; }
    .pi-badge-warning { background:var(--pi-warning-light); color:#b45309; }
    .pi-badge-gray    { background:rgba(100,116,139,0.1);   color:var(--pi-muted); }

    .pi-actions { display:flex; align-items:center; justify-content:flex-end; gap:0.125rem; transition:opacity 0.15s; }
    @media (hover:hover) and (pointer:fine) {
        .pi-actions { opacity:0; }
        .pi-table tbody tr:hover .pi-actions { opacity:1; }
    }
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

    .pi-item-img { width:36px; height:36px; border-radius:0.375rem; object-fit:cover; border:1px solid var(--pi-border); }
    .pi-item-img-placeholder { width:36px; height:36px; border-radius:0.375rem; background:var(--pi-primary-light); display:inline-flex; align-items:center; justify-content:center; color:var(--pi-primary); font-size:0.75rem; }
    .pi-item-detail-img { max-width:140px; max-height:140px; object-fit:cover; border-radius:var(--pi-radius); border:2px solid var(--pi-border); }

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
                <i class="fas fa-box fa-lg" style="opacity:0.9"></i>
                <div>
                    <h1>Gestão de Itens</h1>
                    <p>Gerir todos os produtos e serviços do sistema</p>
                </div>
            </div>
        </div>
        <button class="pi-btn-create" data-bs-toggle="modal" data-bs-target="#modalNovoItem">
            <i class="fas fa-plus"></i> Novo Item
        </button>
    </div>

    {{-- STATS --}}
    <div class="pi-stats-bar">
        <div class="pi-stat">
            <div class="pi-stat-icon blue"><i class="fas fa-box"></i></div>
            <div style="min-width:0">
                <div class="pi-stat-label">Total</div>
                <div class="pi-stat-value" style="color:var(--pi-primary)">{{ $itens->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div style="min-width:0">
                <div class="pi-stat-label">Ativos</div>
                <div class="pi-stat-value" style="color:var(--pi-success)">{{ $itens->where('ativo', true)->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon yellow"><i class="fas fa-star"></i></div>
            <div style="min-width:0">
                <div class="pi-stat-label">Destaques</div>
                <div class="pi-stat-value" style="color:var(--pi-warning)">{{ $itens->where('destaque', true)->count() }}</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon cyan"><i class="fas fa-concierge-bell"></i></div>
            <div style="min-width:0">
                <div class="pi-stat-label">Serviços</div>
                <div class="pi-stat-value" style="color:var(--pi-info)">{{ $itens->where('tipo', 'servico')->count() }}</div>
            </div>
        </div>
    </div>

    {{-- TOOLBAR --}}
    <div class="pi-toolbar">
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="filtroNome" placeholder="Pesquisar por nome...">
        </div>
        <div class="search-wrap">
            <i class="fas fa-tag"></i>
            <select id="filtroTipo" style="padding-left:2.25rem">
                <option value="">Todos os tipos</option>
                <option value="produto">Produto</option>
                <option value="servico">Serviço</option>
            </select>
        </div>
        <div class="search-wrap">
            <i class="fas fa-layer-group"></i>
            <select id="filtroCategoria" style="padding-left:2.25rem">
                <option value="">Todas as categorias</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                @endforeach
            </select>
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
                        <th style="width:44px">Img</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Preço</th>
                        <th style="text-align:center">Destaque</th>
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
            <h3>Nenhum item encontrado</h3>
            <p>Tente ajustar os filtros ou criar um novo item</p>
        </div>
    </div>

    <div class="pi-pagination-bar" id="paginationContainer">
        <span class="info" id="paginationInfo"></span>
        <div class="pages" id="paginationPages"></div>
    </div>
</div>

{{-- MODAL: Visualizar --}}
<div class="modal fade pi-modal" id="modalVisualizarItem" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:560px">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon green"><i class="fas fa-eye"></i></div>
                    <div>
                        <h5 class="modal-title">Detalhes do Item</h5>
                        <p class="modal-subtitle">Informações completas</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="conteudoVisualizarItem">
                <div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Criar --}}
<div class="modal fade pi-modal" id="modalNovoItem" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon blue"><i class="fas fa-plus-circle"></i></div>
                    <div>
                        <h5 class="modal-title">Criar Novo Item</h5>
                        <p class="modal-subtitle">Preencha os dados do item</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNovoItemAjax" class="pi-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-info-circle"></i> Informações Gerais</div>
                            <div class="mb-2">
                                <label class="form-label">Categoria <span class="required">*</span></label>
                                <select class="form-select" name="categoria_id" id="novoCategoria" required>
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categorias as $cat)
                                        <option value="{{ $cat->id }}">{{ optional($cat->grupo)->display_name }} — {{ $cat->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Nome <span class="required">*</span></label>
                                <input type="text" class="form-control" name="nome" required placeholder="Nome do item">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Tipo <span class="required">*</span></label>
                                <select class="form-select" name="tipo" required>
                                    <option value="produto">Produto</option>
                                    <option value="servico">Serviço</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Preço</label>
                                <input type="number" step="0.01" class="form-control" name="preco" placeholder="0.00">
                                <div class="form-text">Deixar vazio para "Sob Consulta"</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-sliders-h"></i> Configurações</div>
                            <div class="mb-2">
                                <label class="form-label">Ordem</label>
                                <input type="number" class="form-control" name="ordem" value="0">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Imagem</label>
                                <input type="file" class="form-control" name="imagem" accept="image/*">
                                <div class="form-text">JPG, PNG, GIF (máx 2 MB)</div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control" name="descricao" rows="3" placeholder="Descrição opcional..."></textarea>
                            </div>
                            <div class="d-flex gap-3 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="novoDestaque" name="destaque" value="1">
                                    <label class="form-check-label" for="novoDestaque" style="font-size:0.8125rem">Destaque</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="novoAtivo" name="ativo" value="1" checked>
                                    <label class="form-check-label" for="novoAtivo" style="font-size:0.8125rem">Ativo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoItemAjax" class="btn pi-btn-primary"><i class="fas fa-save"></i> Criar Item</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Editar --}}
<div class="modal fade pi-modal" id="modalEditarItem" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-flex">
                    <div class="header-icon orange"><i class="fas fa-edit"></i></div>
                    <div>
                        <h5 class="modal-title">Editar Item</h5>
                        <p class="modal-subtitle">Atualizar dados do item</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarItemAjax" class="pi-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editItemId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-info-circle"></i> Informações Gerais</div>
                            <div class="mb-2">
                                <label class="form-label">Categoria <span class="required">*</span></label>
                                <select class="form-select" id="editCategoria" required>
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categorias as $cat)
                                        <option value="{{ $cat->id }}">{{ optional($cat->grupo)->display_name }} — {{ $cat->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Nome <span class="required">*</span></label>
                                <input type="text" class="form-control" id="editNome" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Tipo <span class="required">*</span></label>
                                <select class="form-select" id="editTipo" required>
                                    <option value="produto">Produto</option>
                                    <option value="servico">Serviço</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Preço</label>
                                <input type="number" step="0.01" class="form-control" id="editPreco" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="section-title"><i class="fas fa-sliders-h"></i> Configurações</div>
                            <div class="mb-2">
                                <label class="form-label">Ordem</label>
                                <input type="number" class="form-control" id="editOrdem">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Imagem (Nova)</label>
                                <input type="file" class="form-control" id="editImagem" accept="image/*">
                                <div class="form-text">Deixar vazio para manter a imagem atual</div>
                            </div>
                            <div id="editImagemAtualWrap" class="mb-2 d-none">
                                <label class="form-label">Imagem Atual</label>
                                <div><img id="editImagemAtual" src="" alt="" class="pi-item-detail-img"></div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control" id="editDescricao" rows="3"></textarea>
                            </div>
                            <div class="d-flex gap-3 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editDestaque" value="1">
                                    <label class="form-check-label" for="editDestaque" style="font-size:0.8125rem">Destaque</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editAtivo" value="1">
                                    <label class="form-check-label" for="editAtivo" style="font-size:0.8125rem">Ativo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarItemAjax" class="btn pi-btn-primary"><i class="fas fa-save"></i> Guardar Alterações</button>
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

    let allData = @json($itens->load('categoria.grupo')->values());
    let filteredData = [];
    let currentPage = 1;
    const PER_PAGE = 15;

    $(document).ready(function() {
        bindEventosFiltros();
        configurarEventos();
        aplicarFiltrosLocais();
    });

    /* ── FILTROS ── */
    function bindEventosFiltros() {
        let t;
        $('#filtroNome').on('input', function() { clearTimeout(t); t = setTimeout(aplicarFiltrosLocais, 250); });
        $('#filtroTipo, #filtroCategoria').on('change', aplicarFiltrosLocais);
    }

    function aplicarFiltrosLocais() {
        const nome = ($('#filtroNome').val() || '').toLowerCase().trim();
        const tipo = ($('#filtroTipo').val() || '').toLowerCase();
        const cat  = $('#filtroCategoria').val() || '';

        filteredData = allData.filter(function(it) {
            if (nome && !(it.nome || '').toLowerCase().includes(nome)) return false;
            if (tipo && (it.tipo || '') !== tipo) return false;
            if (cat  && String(it.categoria_id) !== cat) return false;
            return true;
        });

        const hasFilters = nome || tipo || cat;
        $('#btnLimparFiltros').prop('disabled', !hasFilters);
        currentPage = 1;
        renderTabela();
    }

    window.limparFiltros = function() {
        $('#filtroNome').val('');
        $('#filtroTipo').val('');
        $('#filtroCategoria').val('');
        aplicarFiltrosLocais();
    };

    /* ── RENDER ── */
    function esc(str) {
        if (!str && str !== 0) return '';
        const d = document.createElement('div');
        d.textContent = String(str);
        return d.innerHTML;
    }

    function tipoBadge(tipo) {
        if (tipo === 'produto') return '<span class="pi-badge pi-badge-primary"><i class="fas fa-box" style="margin-right:0.2rem"></i>Produto</span>';
        return '<span class="pi-badge pi-badge-warning"><i class="fas fa-concierge-bell" style="margin-right:0.2rem"></i>Serviço</span>';
    }

    function statusBadge(ativo) {
        return ativo
            ? '<span class="pi-badge pi-badge-success"><i class="fas fa-check" style="margin-right:0.2rem"></i>Ativo</span>'
            : '<span class="pi-badge pi-badge-gray">Inativo</span>';
    }

    function precoFormatado(it) {
        if (it.preco === null || it.preco === undefined || it.preco === '') return '<span style="color:var(--pi-text-muted)">Sob Consulta</span>';
        return 'Kz ' + Number(it.preco).toLocaleString('pt-AO', { minimumFractionDigits: 2 });
    }

    function catNome(it) {
        if (it.categoria && it.categoria.nome) return it.categoria.nome;
        return '—';
    }

    function renderTabela() {
        const total = filteredData.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;
        const start = (currentPage - 1) * PER_PAGE;
        const paged = filteredData.slice(start, start + PER_PAGE);

        if (total === 0) {
            $('#tabelaBody').empty(); $('#mobileCards').empty();
            $('#emptyState').removeClass('d-none');
            $('#paginationInfo').text('Nenhum item encontrado');
            $('#paginationPages').empty();
            return;
        }
        $('#emptyState').addClass('d-none');

        let html = '';
        paged.forEach(function(it) {
            const imgHtml = (it.imagem_url || it.imagem)
                ? '<img src="' + esc(it.imagem_url || it.imagem) + '" class="pi-item-img" alt="">'
                : '<div class="pi-item-img-placeholder"><i class="fas fa-box"></i></div>';
            const destaqueHtml = it.destaque
                ? '<i class="fas fa-star" style="color:var(--pi-warning)"></i>'
                : '<span style="color:var(--pi-text-muted)">—</span>';

            html += '<tr>';
            html += '<td class="mono">#' + it.id + '</td>';
            html += '<td>' + imgHtml + '</td>';
            html += '<td><strong style="font-size:0.8125rem">' + esc(it.nome) + '</strong></td>';
            html += '<td style="font-size:0.75rem">' + esc(catNome(it)) + '</td>';
            html += '<td>' + tipoBadge(it.tipo) + '</td>';
            html += '<td style="font-size:0.8125rem">' + precoFormatado(it) + '</td>';
            html += '<td style="text-align:center">' + destaqueHtml + '</td>';
            html += '<td style="text-align:center">' + statusBadge(it.ativo) + '</td>';
            html += '<td><div class="pi-actions">';
            html += '<button class="pi-action-btn view"   onclick="visualizarItem(' + it.id + ')" title="Ver"><i class="fas fa-eye"></i></button>';
            html += '<button class="pi-action-btn edit"   onclick="abrirEdicaoItem(' + it.id + ')" title="Editar"><i class="fas fa-edit"></i></button>';
            html += '<button class="pi-action-btn delete" onclick="eliminarItem(' + it.id + ')" title="Eliminar"><i class="fas fa-trash"></i></button>';
            html += '</div></td></tr>';
        });
        $('#tabelaBody').html(html);

        let mhtml = '';
        paged.forEach(function(it) {
            mhtml += '<div class="pi-mobile-card">';
            mhtml += '<div class="card-top"><div><div class="card-name">' + esc(it.nome) + '</div>';
            mhtml += '<div class="card-meta">' + esc(catNome(it)) + ' · ' + (it.tipo === 'produto' ? 'Produto' : 'Serviço') + '</div></div></div>';
            mhtml += '<div class="card-meta">' + precoFormatado(it) + (it.destaque ? ' · <i class="fas fa-star" style="color:var(--pi-warning)"></i> Destaque' : '') + '</div>';
            mhtml += '<div class="card-actions">';
            mhtml += '<button class="btn btn-sm btn-outline-primary" onclick="visualizarItem(' + it.id + ')"><i class="fas fa-eye me-1"></i>Ver</button>';
            mhtml += '<button class="btn btn-sm btn-outline-primary" onclick="abrirEdicaoItem(' + it.id + ')"><i class="fas fa-edit me-1"></i>Editar</button>';
            mhtml += '<button class="btn btn-sm btn-outline-danger"  onclick="eliminarItem(' + it.id + ')"><i class="fas fa-trash me-1"></i>Eliminar</button>';
            mhtml += '</div></div>';
        });
        $('#mobileCards').html(mhtml);

        const from = start + 1, to = Math.min(start + PER_PAGE, total);
        $('#paginationInfo').text('Mostrando ' + from + '–' + to + ' de ' + total + ' item(ns)');

        if (totalPages > 1) {
            let ph = '<button class="page-btn" onclick="goToPage(' + (currentPage - 1) + ')"' + (currentPage <= 1 ? ' disabled' : '') + '><i class="fas fa-chevron-left" style="font-size:0.6rem"></i></button>';
            const maxB = 7;
            let sB = Math.max(1, currentPage - Math.floor(maxB / 2));
            let eB = Math.min(totalPages, sB + maxB - 1);
            if (eB - sB < maxB - 1) sB = Math.max(1, eB - maxB + 1);
            for (let p = sB; p <= eB; p++) ph += '<button class="page-btn' + (p === currentPage ? ' active' : '') + '" onclick="goToPage(' + p + ')">' + p + '</button>';
            ph += '<button class="page-btn" onclick="goToPage(' + (currentPage + 1) + ')"' + (currentPage >= totalPages ? ' disabled' : '') + '><i class="fas fa-chevron-right" style="font-size:0.6rem"></i></button>';
            $('#paginationPages').html(ph);
        } else {
            $('#paginationPages').empty();
        }
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
        $('#modalNovoItem').on('show.bs.modal', function() { $('#formNovoItemAjax')[0].reset(); });
        $('#formNovoItemAjax').on('submit', function(e) { e.preventDefault(); criarItem(); });
        $('#formEditarItemAjax').on('submit', function(e) { e.preventDefault(); atualizarItem(); });
    }

    /* ── VISUALIZAR ── */
    window.visualizarItem = function(id) {
        const local = allData.find(function(it) { return it.id == id; });
        if (local) { renderVisualizarModal(local); return; }
        $('#conteudoVisualizarItem').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>');
        new bootstrap.Modal(document.getElementById('modalVisualizarItem')).show();
        $.ajax({
            url: '/itens/' + id, method: 'GET',
            success: function(r) { renderVisualizarModal(r.data || r); },
            error: function() { $('#conteudoVisualizarItem').html('<div class="text-center py-3 text-danger">Erro ao carregar</div>'); }
        });
    };

    function renderVisualizarModal(it) {
        let imgHtml = '';
        if (it.imagem_url || it.imagem) {
            imgHtml = '<div class="text-center mb-3"><img src="' + esc(it.imagem_url || it.imagem) + '" class="pi-item-detail-img" alt="' + esc(it.nome) + '"></div>';
        }
        const conteudo = imgHtml
            + dr('fa-box',            'Nome',       esc(it.nome))
            + dr('fa-layer-group',    'Categoria',  esc(catNome(it)))
            + dr('fa-tag',            'Tipo',       tipoBadge(it.tipo))
            + dr('fa-money-bill',     'Preço',      precoFormatado(it))
            + dr('fa-sort-numeric-up','Ordem',      esc(it.ordem ?? 0))
            + dr('fa-star',           'Destaque',   it.destaque ? '<i class="fas fa-star" style="color:var(--pi-warning)"></i> Sim' : 'Não')
            + dr('fa-circle',         'Status',     statusBadge(it.ativo))
            + (it.descricao ? dr('fa-align-left', 'Descrição', '<span style="font-weight:400;white-space:normal">' + esc(it.descricao) + '</span>') : '');
        $('#conteudoVisualizarItem').html(conteudo);
        new bootstrap.Modal(document.getElementById('modalVisualizarItem')).show();
    }

    function dr(icon, label, value) {
        return '<div class="pi-detail-row"><div class="pi-detail-icon"><i class="fas ' + icon + '"></i></div>'
            + '<div style="min-width:0;flex:1"><div class="pi-detail-label">' + label + '</div>'
            + '<div class="pi-detail-value">' + value + '</div></div></div>';
    }

    /* ── EDITAR ── */
    window.abrirEdicaoItem = function(id) {
        const local = allData.find(function(it) { return it.id == id; });
        if (local) { preencherFormEditar(local); return; }
        $.ajax({
            url: '/itens/' + id, method: 'GET',
            success: function(r) { preencherFormEditar(r.data || r); },
            error: function() { Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao carregar dados', confirmButtonColor: '#1d4ed8' }); }
        });
    };

    function preencherFormEditar(it) {
        $('#editItemId').val(it.id);
        $('#editNome').val(it.nome);
        $('#editCategoria').val(it.categoria_id);
        $('#editTipo').val(it.tipo);
        $('#editPreco').val(it.preco !== null && it.preco !== undefined ? it.preco : '');
        $('#editOrdem').val(it.ordem ?? 0);
        $('#editDescricao').val(it.descricao || '');
        $('#editDestaque').prop('checked', !!it.destaque);
        $('#editAtivo').prop('checked', !!it.ativo);
        $('#editImagem').val('');
        if (it.imagem_url || it.imagem) {
            $('#editImagemAtual').attr('src', it.imagem_url || it.imagem);
            $('#editImagemAtualWrap').removeClass('d-none');
        } else {
            $('#editImagemAtualWrap').addClass('d-none');
        }
        new bootstrap.Modal(document.getElementById('modalEditarItem')).show();
    }

    /* ── CRIAR ── */
    function criarItem() {
        const formData = new FormData(document.getElementById('formNovoItemAjax'));
        if (!$('#novoDestaque').is(':checked')) formData.delete('destaque');
        if (!$('#novoAtivo').is(':checked'))    formData.delete('ativo');
        $.ajax({
            url: "{{ route('itens.store') }}", method: 'POST',
            data: formData, processData: false, contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(r) {
                const novo = r.data || r;
                if (novo && novo.id) allData.unshift(novo);
                aplicarFiltrosLocais();
                bootstrap.Modal.getInstance(document.getElementById('modalNovoItem')).hide();
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Item criado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
            },
            error: function(xhr) {
                let msg = 'Erro ao criar item';
                if (xhr.responseJSON?.errors) msg = Object.values(xhr.responseJSON.errors).flat().join(', ');
                else if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;
                Swal.fire({ icon: 'error', title: 'Erro!', text: msg, confirmButtonColor: '#1d4ed8' });
            }
        });
    }

    /* ── ATUALIZAR ── */
    function atualizarItem() {
        const id = $('#editItemId').val();
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('nome',         $('#editNome').val());
        formData.append('categoria_id', $('#editCategoria').val());
        formData.append('tipo',         $('#editTipo').val());
        formData.append('preco',        $('#editPreco').val());
        formData.append('ordem',        $('#editOrdem').val());
        formData.append('descricao',    $('#editDescricao').val());
        formData.append('destaque',     $('#editDestaque').is(':checked') ? '1' : '0');
        formData.append('ativo',        $('#editAtivo').is(':checked')    ? '1' : '0');
        const img = $('#editImagem')[0].files[0];
        if (img) formData.append('imagem', img);
        $.ajax({
            url: '/itens/' + id, method: 'POST',
            data: formData, processData: false, contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(r) {
                const upd = r.data || r;
                const idx = allData.findIndex(function(it) { return it.id == id; });
                if (idx !== -1 && upd && upd.id) allData[idx] = upd;
                aplicarFiltrosLocais();
                bootstrap.Modal.getInstance(document.getElementById('modalEditarItem')).hide();
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Item atualizado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
            },
            error: function(xhr) {
                let msg = 'Erro ao atualizar item';
                if (xhr.responseJSON?.errors) msg = Object.values(xhr.responseJSON.errors).flat().join(', ');
                else if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;
                Swal.fire({ icon: 'error', title: 'Erro!', text: msg, confirmButtonColor: '#1d4ed8' });
            }
        });
    }

    /* ── ELIMINAR ── */
    window.eliminarItem = function(id) {
        Swal.fire({ title: 'Eliminar item?', text: 'Esta ação é irreversível!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b', confirmButtonText: '<i class="fas fa-trash me-1"></i> Sim, eliminar!', cancelButtonText: 'Cancelar' })
        .then(function(result) {
            if (!result.isConfirmed) return;
            $.ajax({
                url: '/itens/' + id, method: 'POST', data: { _method: 'DELETE' },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function() {
                    allData = allData.filter(function(it) { return it.id != id; });
                    aplicarFiltrosLocais();
                    Swal.fire({ icon: 'success', title: 'Eliminado!', text: 'Item eliminado com sucesso', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end', background: '#16a34a', color: '#fff' });
                },
                error: function() { Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao eliminar item', confirmButtonColor: '#1d4ed8' }); }
            });
        });
    };

}());
</script>
@endsection
