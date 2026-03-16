@extends('layouts.app')

@section('title', 'Dashboard')

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
        --pi-violet: #7c3aed;  --pi-violet-light: rgba(124,58,237,0.08);
        --pi-muted: #64748b; --pi-border: #dbeafe; --pi-bg: #eff6ff;
        --pi-card: #ffffff;
        --pi-text: #1e3a8a; --pi-text-muted: #64748b;
        --pi-radius: 0.5rem; --pi-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    *, *::before, *::after { box-sizing: border-box; }
    body { background-color: var(--pi-bg); font-family: 'Plus Jakarta Sans','Inter',system-ui,sans-serif; color: var(--pi-text); }
    .pi-page { width: 100%; padding: 0; }

    /* ── HEADER ── */
    .pi-page-header {
        background: var(--pi-primary-gradient); color: #fff;
        padding: 1rem 1.5rem; display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 0.75rem;
    }
    .pi-page-header h1 { font-size: 1.25rem; font-weight: 700; margin: 0; letter-spacing: -0.02em; color: #fff; }
    .pi-page-header p { font-size: 0.75rem; color: rgba(255,255,255,0.75); margin: 0; }
    .pi-header-meta { display: flex; align-items: center; gap: 0.5rem; }
    .pi-header-meta .pi-chip { background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.25); color: #fff; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; display: flex; align-items: center; gap: 0.375rem; }
    .pi-refresh-btn { background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: #fff; border-radius: var(--pi-radius); padding: 0.375rem 0.75rem; font-size: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 0.375rem; transition: all 0.15s; }
    .pi-refresh-btn:hover { background: rgba(255,255,255,0.25); }

    /* ── KPI STRIP ── */
    .pi-kpi-strip {
        display: grid; grid-template-columns: repeat(4,1fr); gap: 0;
        background: #fff; border-bottom: 1px solid var(--pi-border);
    }
    .pi-kpi {
        padding: 0.875rem 1.25rem; border-right: 1px solid var(--pi-border);
        display: flex; align-items: center; gap: 0.875rem; min-width: 0;
        position: relative; transition: background 0.15s;
    }
    .pi-kpi:last-child { border-right: none; }
    .pi-kpi:hover { background: var(--pi-bg); }
    .pi-kpi-icon { width: 2.5rem; height: 2.5rem; border-radius: 0.625rem; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
    .pi-kpi-icon.blue   { background: var(--pi-primary-light); color: var(--pi-primary); }
    .pi-kpi-icon.green  { background: var(--pi-success-light); color: var(--pi-success); }
    .pi-kpi-icon.cyan   { background: var(--pi-info-light);    color: var(--pi-info); }
    .pi-kpi-icon.yellow { background: var(--pi-warning-light); color: var(--pi-warning); }
    .pi-kpi-icon.red    { background: var(--pi-danger-light);  color: var(--pi-danger); }
    .pi-kpi-icon.violet { background: var(--pi-violet-light);  color: var(--pi-violet); }
    .pi-kpi-label { font-size: 0.6875rem; font-weight: 500; color: var(--pi-text-muted); text-transform: uppercase; letter-spacing: 0.04em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .pi-kpi-value { font-size: 1.5rem; font-weight: 700; line-height: 1.1; }
    .pi-kpi-sub { font-size: 0.625rem; color: var(--pi-text-muted); margin-top: 0.1rem; }
    .pi-kpi-trend { position: absolute; top: 0.5rem; right: 0.75rem; font-size: 0.625rem; font-weight: 600; padding: 0.1rem 0.35rem; border-radius: 9999px; }
    .pi-kpi-trend.up   { background: var(--pi-success-light); color: var(--pi-success); }
    .pi-kpi-trend.down { background: var(--pi-danger-light);  color: var(--pi-danger); }

    /* ── KPI ROW 2 ── */
    .pi-kpi-strip-2 {
        display: grid; grid-template-columns: repeat(4,1fr); gap: 0;
        background: #fff; border-bottom: 2px solid var(--pi-border);
    }
    .pi-kpi-strip-2 .pi-kpi { border-bottom: none; }

    /* ── CONTENT GRID ── */
    .pi-content { padding: 1rem 1.25rem; display: flex; flex-direction: column; gap: 1rem; }
    .pi-row { display: grid; gap: 1rem; }
    .pi-row-3-2 { grid-template-columns: 1fr 1fr 1fr; }
    .pi-row-2-1 { grid-template-columns: 2fr 1fr; }
    .pi-row-2   { grid-template-columns: 1fr 1fr; }
    .pi-row-3   { grid-template-columns: 1fr 1fr 1fr; }

    /* ── CARD ── */
    .pi-card {
        background: var(--pi-card); border: 1px solid var(--pi-border);
        border-radius: var(--pi-radius); box-shadow: var(--pi-shadow); overflow: hidden;
    }
    .pi-card-header {
        border-bottom: 1px solid var(--pi-border); padding: 0.625rem 1rem;
        display: flex; align-items: center; justify-content: space-between;
        background: var(--pi-primary-light); min-height: 2.75rem;
    }
    .pi-card-header h2 { font-size: 0.8125rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.375rem; color: var(--pi-text); }
    .pi-card-header-right { display: flex; align-items: center; gap: 0.5rem; }
    .pi-card-tab { font-size: 0.6875rem; font-weight: 600; padding: 0.1875rem 0.5rem; border-radius: 9999px; cursor: pointer; transition: all 0.15s; border: 1px solid transparent; }
    .pi-card-tab.active { background: var(--pi-primary); color: #fff; border-color: var(--pi-primary); }
    .pi-card-tab:not(.active) { color: var(--pi-text-muted); border-color: var(--pi-border); background: #fff; }
    .pi-card-body { padding: 1rem; }
    .pi-card-body.no-pad { padding: 0; }

    /* ── CHART CONTAINERS ── */
    .pi-chart-wrap { position: relative; }
    .pi-chart-wrap canvas { display: block; }

    /* ── TABLE ── */
    .pi-table { width: 100%; border-collapse: collapse; font-size: 0.8125rem; }
    .pi-table thead th {
        background: var(--pi-primary); color: #fff; font-size: 0.6875rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.05em; padding: 0.5rem 0.875rem;
        white-space: nowrap; border-bottom: none;
    }
    .pi-table tbody td { padding: 0.5rem 0.875rem; vertical-align: middle; border-bottom: 1px solid #f0f4ff; }
    .pi-table tbody tr { transition: background 0.1s; }
    .pi-table tbody tr:hover { background: var(--pi-bg); }
    .pi-table tbody tr:last-child td { border-bottom: none; }
    .pi-table .mono { font-family:'SF Mono','Fira Code',monospace; font-size:0.6875rem; color:var(--pi-muted); }

    /* ── BADGES ── */
    .pi-badge { display:inline-flex;align-items:center;gap:0.25rem;padding:0.15rem 0.5rem;border-radius:9999px;font-size:0.6875rem;font-weight:600; }
    .pi-badge-pendente   { background:var(--pi-warning-light); color:#92610a; }
    .pi-badge-confirmado { background:var(--pi-success-light); color:#1e6e49; }
    .pi-badge-cancelado  { background:var(--pi-danger-light);  color:#a71d2a; }
    .pi-badge-info       { background:var(--pi-info-light);    color:#0369a1; }
    .pi-badge-primary    { background:var(--pi-primary-light); color:#1e40af; }

    /* ── PROGRESS ── */
    .pi-prog-item { display:flex; align-items:center; gap:0.625rem; margin-bottom:0.625rem; }
    .pi-prog-item:last-child { margin-bottom:0; }
    .pi-prog-label { font-size:0.75rem; font-weight:500; color:var(--pi-text); flex:0 0 110px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .pi-prog-bar-wrap { flex:1; height:7px; background:#e9ecef; border-radius:4px; overflow:hidden; }
    .pi-prog-bar-fill { height:100%; border-radius:4px; transition:width 0.6s ease; }
    .pi-prog-val { font-size:0.6875rem; font-weight:700; min-width:28px; text-align:right; }

    /* ── QUICK ACTIONS ── */
    .pi-actions-grid { display:grid;grid-template-columns:repeat(4,1fr);gap:0.75rem; }
    .pi-action-card { display:flex;flex-direction:column;align-items:center;justify-content:center;padding:1.125rem 0.75rem;border-radius:var(--pi-radius);text-decoration:none;transition:all 0.15s;gap:0.375rem;font-size:0.75rem;font-weight:600;cursor:pointer;border:none; }
    .pi-action-card i { font-size:1.375rem; }
    .pi-action-card:hover { transform:translateY(-2px);box-shadow:0 6px 16px rgba(0,0,0,0.12); }
    .pi-action-card.primary { background:var(--pi-primary); color:#fff; }
    .pi-action-card.primary:hover { background:var(--pi-primary-dark); color:#fff; }
    .pi-action-card.success { background:var(--pi-success); color:#fff; }
    .pi-action-card.success:hover { background:#15803d; color:#fff; }
    .pi-action-card.info { background:var(--pi-info); color:#fff; }
    .pi-action-card.info:hover { background:#0369a1; color:#fff; }
    .pi-action-card.warning { background:var(--pi-warning); color:#fff; }
    .pi-action-card.warning:hover { background:#b45309; color:#fff; }
    .pi-action-card.violet { background:var(--pi-violet); color:#fff; }
    .pi-action-card.violet:hover { background:#6d28d9; color:#fff; }
    .pi-action-card.danger { background:var(--pi-danger); color:#fff; }
    .pi-action-card.danger:hover { background:#b91c1c; color:#fff; }
    .pi-action-card.gray { background:#475569; color:#fff; }
    .pi-action-card.gray:hover { background:#334155; color:#fff; }
    .pi-action-card.teal { background:#0d9488; color:#fff; }
    .pi-action-card.teal:hover { background:#0f766e; color:#fff; }

    /* ── RANKING LIST ── */
    .pi-rank-item { display:flex; align-items:center; gap:0.625rem; padding:0.5rem 0; border-bottom:1px solid #f0f4ff; }
    .pi-rank-item:last-child { border-bottom:none; }
    .pi-rank-num { width:1.5rem; height:1.5rem; border-radius:50%; background:var(--pi-primary-light); color:var(--pi-primary); font-size:0.6875rem; font-weight:700; display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .pi-rank-num.gold { background:#fef3c7; color:#b45309; }
    .pi-rank-num.silver { background:#f1f5f9; color:#475569; }
    .pi-rank-num.bronze { background:#fef2e0; color:#b45309; }
    .pi-rank-label { flex:1;min-width:0;font-size:0.8125rem;font-weight:500;overflow:hidden;text-overflow:ellipsis;white-space:nowrap; }
    .pi-rank-label small { display:block;font-size:0.6875rem;color:var(--pi-text-muted);font-weight:400; }
    .pi-rank-val { font-size:0.8125rem;font-weight:700;color:var(--pi-primary);flex-shrink:0; }

    /* ── ACTIVITY ── */
    .pi-activity-item { display:flex;align-items:flex-start;gap:0.625rem;padding:0.5rem 0;border-bottom:1px solid #f0f4ff; }
    .pi-activity-item:last-child { border-bottom:none; }
    .pi-activity-dot { width:0.5rem;height:0.5rem;border-radius:50%;flex-shrink:0;margin-top:0.3rem; }
    .pi-activity-text { flex:1;min-width:0; }
    .pi-activity-text strong { font-size:0.8125rem;font-weight:600;color:var(--pi-text); }
    .pi-activity-text span { font-size:0.75rem;color:var(--pi-text-muted); }
    .pi-activity-time { font-size:0.6875rem;color:var(--pi-text-muted);flex-shrink:0; }

    /* ── EMPTY STATE ── */
    .pi-empty { text-align:center;padding:2rem 1rem;color:var(--pi-text-muted); }
    .pi-empty-icon { width:3rem;height:3rem;border-radius:0.75rem;background:var(--pi-primary-light);display:inline-flex;align-items:center;justify-content:center;font-size:1.125rem;margin-bottom:0.5rem;color:var(--pi-primary); }
    .pi-empty h3 { font-size:0.9375rem;font-weight:600;margin-bottom:0.125rem;color:var(--pi-text); }
    .pi-empty p { font-size:0.75rem;margin:0; }

    /* ── LOADING SPINNER ── */
    .pi-loading { display:flex;align-items:center;justify-content:center;min-height:120px; }
    .pi-loading .spinner-border { color:var(--pi-primary); }

    /* ── DIVIDER ── */
    .pi-divider { border:none;border-top:1px solid var(--pi-border);margin:0.75rem 0; }

    /* ── RESPONSIVE ── */
    @media (max-width:1199.98px) { .pi-row-3-2 { grid-template-columns:1fr 1fr; } .pi-row-3 { grid-template-columns:1fr 1fr; } }
    @media (max-width:991.98px) {
        .pi-kpi-strip, .pi-kpi-strip-2 { grid-template-columns:repeat(2,1fr); }
        .pi-kpi { border-bottom:1px solid var(--pi-border); }
        .pi-row-3-2 { grid-template-columns:1fr; }
        .pi-row-2-1 { grid-template-columns:1fr; }
        .pi-row-2   { grid-template-columns:1fr; }
        .pi-row-3   { grid-template-columns:1fr 1fr; }
        .pi-actions-grid { grid-template-columns:repeat(4,1fr); }
    }
    @media (max-width:767.98px) {
        .pi-kpi-strip, .pi-kpi-strip-2 { grid-template-columns:repeat(2,1fr); }
        .pi-row-3   { grid-template-columns:1fr; }
        .pi-actions-grid { grid-template-columns:repeat(2,1fr); }
        .pi-content { padding:0.75rem; gap:0.75rem; }
    }
    @media (max-width:575.98px) {
        .pi-kpi-strip, .pi-kpi-strip-2 { grid-template-columns:1fr 1fr; }
        .pi-kpi { padding:0.625rem 0.875rem; }
        .pi-kpi-icon { width:2rem;height:2rem;font-size:0.8125rem; }
        .pi-kpi-value { font-size:1.25rem; }
        .pi-actions-grid { grid-template-columns:repeat(2,1fr); gap:0.5rem; }
        .pi-content { padding:0.5rem; }
    }
</style>
@endsection

@section('content')
<div class="pi-page">

    {{-- HEADER --}}
    <div class="pi-page-header">
        <div style="display:flex;align-items:center;gap:0.625rem">
            <i class="fas fa-tachometer-alt fa-lg" style="opacity:0.9"></i>
            <div>
                <h1>Dashboard</h1>
                <p>Visão geral e análise do sistema de gestão de formação</p>
            </div>
        </div>
        <div class="pi-header-meta">
            <div class="pi-chip"><i class="fas fa-calendar-day"></i> <span id="data-atual"></span></div>
            <button class="pi-refresh-btn" onclick="recarregarTudo()"><i class="fas fa-sync-alt"></i> Atualizar</button>
        </div>
    </div>

    {{-- KPI ROW 1 --}}
    <div class="pi-kpi-strip">
        <div class="pi-kpi">
            <div class="pi-kpi-icon blue"><i class="fas fa-book-open"></i></div>
            <div style="min-width:0">
                <div class="pi-kpi-label">Total de Cursos</div>
                <div class="pi-kpi-value" style="color:var(--pi-primary)" id="kpi-cursos">—</div>
                <div class="pi-kpi-sub" id="kpi-cursos-ativos"></div>
            </div>
        </div>
        <div class="pi-kpi">
            <div class="pi-kpi-icon green"><i class="fas fa-building"></i></div>
            <div style="min-width:0">
                <div class="pi-kpi-label">Centros de Formação</div>
                <div class="pi-kpi-value" style="color:var(--pi-success)" id="kpi-centros">—</div>
                <div class="pi-kpi-sub" id="kpi-centros-sub"></div>
            </div>
        </div>
        <div class="pi-kpi">
            <div class="pi-kpi-icon cyan"><i class="fas fa-chalkboard-teacher"></i></div>
            <div style="min-width:0">
                <div class="pi-kpi-label">Formadores</div>
                <div class="pi-kpi-value" style="color:var(--pi-info)" id="kpi-formadores">—</div>
                <div class="pi-kpi-sub" id="kpi-formadores-sub"></div>
            </div>
        </div>
        <div class="pi-kpi">
            <div class="pi-kpi-icon violet"><i class="fas fa-users-class"></i></div>
            <div style="min-width:0">
                <div class="pi-kpi-label">Turmas</div>
                <div class="pi-kpi-value" style="color:var(--pi-violet)" id="kpi-turmas">—</div>
                <div class="pi-kpi-sub" id="kpi-turmas-sub"></div>
            </div>
        </div>
    </div>

    {{-- KPI ROW 2 --}}
    <div class="pi-kpi-strip-2">
        <div class="pi-kpi">
            <div class="pi-kpi-icon yellow"><i class="fas fa-user-plus"></i></div>
            <div style="min-width:0">
                <div class="pi-kpi-label">Total Pré-Inscrições</div>
                <div class="pi-kpi-value" style="color:var(--pi-warning)" id="kpi-total-inscricoes">—</div>
                <div class="pi-kpi-sub">Todas as inscrições</div>
            </div>
        </div>
        <div class="pi-kpi">
            <div class="pi-kpi-icon yellow"><i class="fas fa-clock"></i></div>
            <div style="min-width:0">
                <div class="pi-kpi-label">Pendentes</div>
                <div class="pi-kpi-value" style="color:var(--pi-warning)" id="kpi-pendentes">—</div>
                <div class="pi-kpi-sub" id="kpi-pendentes-pct"></div>
            </div>
        </div>
        <div class="pi-kpi">
            <div class="pi-kpi-icon green"><i class="fas fa-check-circle"></i></div>
            <div style="min-width:0">
                <div class="pi-kpi-label">Confirmadas</div>
                <div class="pi-kpi-value" style="color:var(--pi-success)" id="kpi-confirmadas">—</div>
                <div class="pi-kpi-sub" id="kpi-confirmadas-pct"></div>
            </div>
        </div>
        <div class="pi-kpi">
            <div class="pi-kpi-icon red"><i class="fas fa-times-circle"></i></div>
            <div style="min-width:0">
                <div class="pi-kpi-label">Canceladas</div>
                <div class="pi-kpi-value" style="color:var(--pi-danger)" id="kpi-canceladas">—</div>
                <div class="pi-kpi-sub" id="kpi-canceladas-pct"></div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="pi-content">

        {{-- ROW 1: Inscrições por mês (line) + Status distribuição (doughnut) + Turmas modalidade (doughnut) --}}
        <div class="pi-row pi-row-3-2">
            {{-- Evolução de Inscrições --}}
            <div class="pi-card" style="grid-column: span 2">
                <div class="pi-card-header">
                    <h2><i class="fas fa-chart-line" style="color:var(--pi-primary)"></i> Evolução de Pré-Inscrições</h2>
                    <div class="pi-card-header-right">
                        <span class="pi-card-tab active" id="tab-6m"   onclick="mudarPeriodo('6m')">6 meses</span>
                        <span class="pi-card-tab"        id="tab-3m"   onclick="mudarPeriodo('3m')">3 meses</span>
                        <span class="pi-card-tab"        id="tab-12m"  onclick="mudarPeriodo('12m')">12 meses</span>
                    </div>
                </div>
                <div class="pi-card-body">
                    <div class="pi-chart-wrap" style="height:220px">
                        <canvas id="chartEvolucao"></canvas>
                    </div>
                </div>
            </div>

            {{-- Distribuição por Status --}}
            <div class="pi-card">
                <div class="pi-card-header">
                    <h2><i class="fas fa-chart-pie" style="color:var(--pi-warning)"></i> Inscrições por Status</h2>
                </div>
                <div class="pi-card-body">
                    <div class="pi-chart-wrap" style="height:160px">
                        <canvas id="chartStatus"></canvas>
                    </div>
                    <div id="legendaStatus" style="margin-top:0.75rem"></div>
                </div>
            </div>
        </div>

        {{-- ROW 2: Top Cursos + Centros ranking + Modalidade --}}
        <div class="pi-row pi-row-3">
            {{-- Top Cursos mais inscritos --}}
            <div class="pi-card">
                <div class="pi-card-header">
                    <h2><i class="fas fa-trophy" style="color:var(--pi-warning)"></i> Top Cursos</h2>
                    <span style="font-size:0.6875rem;color:var(--pi-text-muted)">por inscrições</span>
                </div>
                <div class="pi-card-body">
                    <div id="rankingCursos">
                        <div class="pi-loading"><div class="spinner-border spinner-border-sm" role="status"></div></div>
                    </div>
                </div>
            </div>

            {{-- Top Centros --}}
            <div class="pi-card">
                <div class="pi-card-header">
                    <h2><i class="fas fa-map-marker-alt" style="color:var(--pi-success)"></i> Top Centros</h2>
                    <span style="font-size:0.6875rem;color:var(--pi-text-muted)">por turmas</span>
                </div>
                <div class="pi-card-body">
                    <div id="rankingCentros">
                        <div class="pi-loading"><div class="spinner-border spinner-border-sm" role="status"></div></div>
                    </div>
                </div>
            </div>

            {{-- Turmas por modalidade --}}
            <div class="pi-card">
                <div class="pi-card-header">
                    <h2><i class="fas fa-layer-group" style="color:var(--pi-info)"></i> Turmas por Modalidade</h2>
                </div>
                <div class="pi-card-body">
                    <div class="pi-chart-wrap" style="height:140px">
                        <canvas id="chartModalidade"></canvas>
                    </div>
                    <div id="legendaModalidade" style="margin-top:0.75rem"></div>
                    <hr class="pi-divider">
                    <div id="statsModalidade"></div>
                </div>
            </div>
        </div>

        {{-- ROW 3: Últimas inscrições + Cursos por centro --}}
        <div class="pi-row pi-row-2-1">
            {{-- Tabela Últimas Inscrições --}}
            <div class="pi-card">
                <div class="pi-card-header">
                    <h2><i class="fas fa-history" style="color:var(--pi-primary)"></i> Últimas Pré-Inscrições</h2>
                    <a href="{{ route('pre-inscricoes.index') }}" style="font-size:0.75rem;color:var(--pi-primary);text-decoration:none;font-weight:500;display:flex;align-items:center;gap:0.25rem">
                        Ver todas <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div style="overflow-x:auto">
                    <table class="pi-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Candidato</th>
                                <th>Curso</th>
                                <th>Centro</th>
                                <th>Modalidade</th>
                                <th>Data</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="ultimas-inscricoes">
                            <tr><td colspan="7"><div class="pi-loading"><div class="spinner-border spinner-border-sm" role="status"></div></div></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Painel lateral: Cursos por Formador + Taxa confirmação --}}
            <div style="display:flex;flex-direction:column;gap:1rem">
                {{-- Taxa de conversão --}}
                <div class="pi-card">
                    <div class="pi-card-header">
                        <h2><i class="fas fa-percentage" style="color:var(--pi-success)"></i> Taxa de Confirmação</h2>
                    </div>
                    <div class="pi-card-body">
                        <div style="text-align:center;margin-bottom:0.75rem">
                            <div style="font-size:2.5rem;font-weight:800;color:var(--pi-success);line-height:1" id="taxa-confirmacao">—</div>
                            <div style="font-size:0.75rem;color:var(--pi-text-muted);margin-top:0.25rem">das inscrições confirmadas</div>
                        </div>
                        <div id="progressStatuses"></div>
                        <hr class="pi-divider">
                        <div style="font-size:0.6875rem;color:var(--pi-text-muted);text-align:center" id="info-atualizacao"></div>
                    </div>
                </div>

                {{-- Formadores por atividade --}}
                <div class="pi-card">
                    <div class="pi-card-header">
                        <h2><i class="fas fa-user-tie" style="color:var(--pi-violet)"></i> Formadores Ativos</h2>
                    </div>
                    <div class="pi-card-body">
                        <div id="rankingFormadores">
                            <div class="pi-loading"><div class="spinner-border spinner-border-sm" role="status"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROW 4: Cursos por Centro (bar chart) --}}
        <div class="pi-card">
            <div class="pi-card-header">
                <h2><i class="fas fa-chart-bar" style="color:var(--pi-info)"></i> Pré-Inscrições por Centro de Formação</h2>
            </div>
            <div class="pi-card-body">
                <div class="pi-chart-wrap" style="height:200px">
                    <canvas id="chartCentros"></canvas>
                </div>
            </div>
        </div>

        {{-- ROW 5: Ações Rápidas --}}
        <div class="pi-card">
            <div class="pi-card-header">
                <h2><i class="fas fa-bolt" style="color:var(--pi-warning)"></i> Ações Rápidas</h2>
            </div>
            <div class="pi-card-body">
                <div class="pi-actions-grid">
                    <a href="{{ route('cursos.create') }}" class="pi-action-card primary">
                        <i class="fas fa-plus-circle"></i>Novo Curso
                    </a>
                    <a href="{{ route('centros.create') }}" class="pi-action-card success">
                        <i class="fas fa-building"></i>Novo Centro
                    </a>
                    <a href="{{ route('formadores.create') }}" class="pi-action-card info">
                        <i class="fas fa-user-plus"></i>Novo Formador
                    </a>
                    <a href="{{ route('turmas.create') }}" class="pi-action-card warning">
                        <i class="fas fa-clock"></i>Nova Turma
                    </a>
                    <a href="{{ route('pre-inscricoes.index') }}" class="pi-action-card violet">
                        <i class="fas fa-clipboard-list"></i>Pré-Inscrições
                    </a>
                    <a href="{{ route('cursos.index') }}" class="pi-action-card teal">
                        <i class="fas fa-book-open"></i>Lista Cursos
                    </a>
                    <a href="{{ route('centros.index') }}" class="pi-action-card gray">
                        <i class="fas fa-map-marked-alt"></i>Lista Centros
                    </a>
                    <a href="{{ route('formadores.index') }}" class="pi-action-card danger">
                        <i class="fas fa-chalkboard-teacher"></i>Lista Formadores
                    </a>
                </div>
            </div>
        </div>

    </div>{{-- /pi-content --}}
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function() {
'use strict';

/* ───────────────── HELPERS ───────────────── */
function esc(str) {
    if (!str) return '';
    var d = document.createElement('div'); d.textContent = String(str); return d.innerHTML;
}
function fmt(n) { return Number(n || 0).toLocaleString('pt-AO'); }
function pct(val, total) {
    if (!total) return '0%';
    return Math.round(val / total * 100) + '%';
}
function formatDate(str) {
    if (!str) return '—';
    try {
        return new Date(str).toLocaleDateString('pt-PT', { year:'numeric', month:'2-digit', day:'2-digit', hour:'2-digit', minute:'2-digit' });
    } catch(e) { return '—'; }
}
function formatDateShort(str) {
    if (!str) return '—';
    try { return new Date(str).toLocaleDateString('pt-PT', { month:'short', day:'2-digit' }); }
    catch(e) { return '—'; }
}

/* ───────────────── STATE ───────────────── */
var state = {
    cursos: [], centros: [], formadores: [], turmas: [], inscricoes: [],
    periodo: '6m',
    charts: {}
};

/* ───────────────── INIT ───────────────── */
$(document).ready(function() {
    atualizarDataAtual();
    Chart.defaults.font.family = "'Plus Jakarta Sans','Inter',system-ui,sans-serif";
    Chart.defaults.color = '#64748b';
    recarregarTudo();
});

window.recarregarTudo = function() {
    carregarTodos();
};

window.mudarPeriodo = function(p) {
    state.periodo = p;
    ['tab-3m','tab-6m','tab-12m'].forEach(function(id) {
        document.getElementById(id).classList.remove('active');
    });
    document.getElementById('tab-' + p).classList.add('active');
    if (state.inscricoes.length > 0) renderChartEvolucao();
};

function atualizarDataAtual() {
    var d = new Date();
    document.getElementById('data-atual').textContent = d.toLocaleDateString('pt-PT', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
}

/* ───────────────── CARREGAR DADOS ───────────────── */
function carregarTodos() {
    var reqs = [
        $.ajax({ url:'/cursos',         method:'GET', headers:{ 'Accept':'application/json','X-Requested-With':'XMLHttpRequest' } }),
        $.ajax({ url:'/centros',        method:'GET', headers:{ 'Accept':'application/json','X-Requested-With':'XMLHttpRequest' } }),
        $.ajax({ url:'/formadores',     method:'GET', headers:{ 'Accept':'application/json','X-Requested-With':'XMLHttpRequest' } }),
        $.ajax({ url:'/turmas',         method:'GET', headers:{ 'Accept':'application/json','X-Requested-With':'XMLHttpRequest' } }),
        $.ajax({ url:'/pre-inscricoes', method:'GET', headers:{ 'Accept':'application/json','X-Requested-With':'XMLHttpRequest' } })
    ];

    $.when.apply($, reqs).then(function(rCursos, rCentros, rFormadores, rTurmas, rInscricoes) {
        state.cursos     = norm(rCursos[0]);
        state.centros    = norm(rCentros[0]);
        state.formadores = norm(rFormadores[0]);
        state.turmas     = norm(rTurmas[0]);
        state.inscricoes = norm(rInscricoes[0]);

        renderTudo();
    }).fail(function() {
        console.warn('Erro ao carregar dados do dashboard.');
        renderTudo();
    });
}

function norm(data) {
    if (!data) return [];
    if (Array.isArray(data)) return data;
    if (data.data && Array.isArray(data.data)) return data.data;
    return [];
}

/* ───────────────── RENDER GERAL ───────────────── */
function renderTudo() {
    renderKPIs();
    renderChartStatus();
    renderChartEvolucao();
    renderChartModalidade();
    renderChartCentros();
    renderRankingCursos();
    renderRankingCentros();
    renderRankingFormadores();
    renderUltimasInscricoes();
    renderTaxaConfirmacao();

    var agora = new Date();
    document.getElementById('info-atualizacao').textContent = 'Atualizado às ' + agora.toLocaleTimeString('pt-PT', { hour:'2-digit', minute:'2-digit' });
}

/* ───────────────── KPIs ───────────────── */
function renderKPIs() {
    var ins = state.inscricoes;
    var pend = ins.filter(function(i){ return i.status === 'pendente'; }).length;
    var conf = ins.filter(function(i){ return i.status === 'confirmado'; }).length;
    var canc = ins.filter(function(i){ return i.status === 'cancelado'; }).length;
    var total = ins.length;

    document.getElementById('kpi-cursos').textContent    = fmt(state.cursos.length);
    document.getElementById('kpi-centros').textContent   = fmt(state.centros.length);
    document.getElementById('kpi-formadores').textContent= fmt(state.formadores.length);
    document.getElementById('kpi-turmas').textContent    = fmt(state.turmas.length);
    document.getElementById('kpi-total-inscricoes').textContent = fmt(total);
    document.getElementById('kpi-pendentes').textContent  = fmt(pend);
    document.getElementById('kpi-confirmadas').textContent= fmt(conf);
    document.getElementById('kpi-canceladas').textContent = fmt(canc);

    document.getElementById('kpi-pendentes-pct').textContent   = pct(pend, total) + ' do total';
    document.getElementById('kpi-confirmadas-pct').textContent = pct(conf, total) + ' do total';
    document.getElementById('kpi-canceladas-pct').textContent  = pct(canc, total) + ' do total';

    /* sub-labels */
    var cursosAtivos = state.cursos.filter(function(c){ return c.ativo || c.ativo === undefined; }).length;
    document.getElementById('kpi-cursos-ativos').textContent = cursosAtivos + ' ativos';

    var online    = state.turmas.filter(function(t){ return t.modalidade === 'online'; }).length;
    var presencial = state.turmas.filter(function(t){ return t.modalidade === 'presencial'; }).length;
    document.getElementById('kpi-turmas-sub').textContent = online + ' online · ' + presencial + ' presencial';
}

/* ───────────────── CHART: STATUS (DOUGHNUT) ───────────────── */
function renderChartStatus() {
    var ins = state.inscricoes;
    var pend = ins.filter(function(i){ return i.status === 'pendente'; }).length;
    var conf = ins.filter(function(i){ return i.status === 'confirmado'; }).length;
    var canc = ins.filter(function(i){ return i.status === 'cancelado'; }).length;

    var ctx = document.getElementById('chartStatus').getContext('2d');
    if (state.charts.status) state.charts.status.destroy();
    state.charts.status = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pendentes', 'Confirmadas', 'Canceladas'],
            datasets: [{ data: [pend, conf, canc], backgroundColor: ['#f59e0b','#16a34a','#dc2626'], borderWidth: 2, borderColor: '#fff', hoverOffset: 6 }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '68%',
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: function(ctx) { var t = pend+conf+canc; return ctx.label + ': ' + ctx.parsed + ' (' + pct(ctx.parsed, t) + ')'; } } } }
        }
    });

    var total = pend + conf + canc;
    document.getElementById('legendaStatus').innerHTML =
        legItem('#f59e0b', 'Pendentes',   pend, total) +
        legItem('#16a34a', 'Confirmadas', conf, total) +
        legItem('#dc2626', 'Canceladas',  canc, total);
}

function legItem(cor, label, val, total) {
    return '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.3rem">' +
        '<div style="display:flex;align-items:center;gap:0.375rem"><div style="width:0.625rem;height:0.625rem;border-radius:50%;background:' + cor + ';flex-shrink:0"></div><span style="font-size:0.75rem">' + label + '</span></div>' +
        '<span style="font-size:0.75rem;font-weight:700;color:' + cor + '">' + val + ' <span style="font-weight:400;color:#64748b">(' + pct(val,total) + ')</span></span></div>';
}

/* ───────────────── CHART: EVOLUÇÃO (LINE) ───────────────── */
function renderChartEvolucao() {
    var meses = { '3m': 3, '6m': 6, '12m': 12 }[state.periodo] || 6;
    var agora = new Date();
    var labels = [], pendData = [], confData = [], cancData = [];

    for (var i = meses - 1; i >= 0; i--) {
        var d = new Date(agora.getFullYear(), agora.getMonth() - i, 1);
        var ano = d.getFullYear(); var mes = d.getMonth();
        labels.push(d.toLocaleDateString('pt-PT', { month:'short', year:'2-digit' }));

        var insMes = state.inscricoes.filter(function(ins) {
            var dt = new Date(ins.created_at);
            return dt.getFullYear() === ano && dt.getMonth() === mes;
        });
        pendData.push(insMes.filter(function(x){ return x.status === 'pendente'; }).length);
        confData.push(insMes.filter(function(x){ return x.status === 'confirmado'; }).length);
        cancData.push(insMes.filter(function(x){ return x.status === 'cancelado'; }).length);
    }

    var ctx = document.getElementById('chartEvolucao').getContext('2d');
    if (state.charts.evolucao) state.charts.evolucao.destroy();

    var gradBlue = ctx.createLinearGradient(0, 0, 0, 200);
    gradBlue.addColorStop(0, 'rgba(29,78,216,0.15)'); gradBlue.addColorStop(1, 'rgba(29,78,216,0)');
    var gradGreen = ctx.createLinearGradient(0, 0, 0, 200);
    gradGreen.addColorStop(0, 'rgba(22,163,74,0.12)'); gradGreen.addColorStop(1, 'rgba(22,163,74,0)');

    state.charts.evolucao = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                { label:'Pendentes',   data: pendData, borderColor:'#f59e0b', backgroundColor:'rgba(245,158,11,0.08)', borderWidth:2, tension:0.4, fill:true, pointRadius:3, pointHoverRadius:5 },
                { label:'Confirmadas', data: confData, borderColor:'#16a34a', backgroundColor: gradGreen,              borderWidth:2.5, tension:0.4, fill:true, pointRadius:3, pointHoverRadius:5 },
                { label:'Canceladas',  data: cancData, borderColor:'#dc2626', backgroundColor:'rgba(220,38,38,0.06)', borderWidth:2, tension:0.4, fill:true, pointRadius:3, pointHoverRadius:5 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position:'top', labels:{ boxWidth:10, padding:16, font:{ size:11 } } }, tooltip: { cornerRadius: 6 } },
            scales: {
                x: { grid:{ display:false }, ticks:{ font:{ size:11 } } },
                y: { beginAtZero:true, grid:{ color:'rgba(219,234,254,0.5)' }, ticks:{ stepSize:1, font:{ size:11 } } }
            }
        }
    });
}

/* ───────────────── CHART: MODALIDADE (DOUGHNUT) ───────────────── */
function renderChartModalidade() {
    var online     = state.turmas.filter(function(t){ return t.modalidade === 'online'; }).length;
    var presencial = state.turmas.filter(function(t){ return t.modalidade === 'presencial'; }).length;
    var hibrido    = state.turmas.filter(function(t){ return t.modalidade === 'hibrido' || t.modalidade === 'híbrido'; }).length;
    var outros     = state.turmas.length - online - presencial - hibrido;

    var ctx = document.getElementById('chartModalidade').getContext('2d');
    if (state.charts.modalidade) state.charts.modalidade.destroy();
    state.charts.modalidade = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Online','Presencial','Híbrido','Outros'],
            datasets: [{ data: [online, presencial, hibrido, outros], backgroundColor: ['#1d4ed8','#16a34a','#7c3aed','#94a3b8'], borderWidth: 2, borderColor: '#fff', hoverOffset: 4 }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '62%',
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: function(c) { return c.label + ': ' + c.parsed; } } } }
        }
    });

    var total = state.turmas.length || 1;
    document.getElementById('legendaModalidade').innerHTML =
        legItem('#1d4ed8','Online',    online,    total) +
        legItem('#16a34a','Presencial',presencial,total) +
        (hibrido ? legItem('#7c3aed','Híbrido', hibrido, total) : '');

    document.getElementById('statsModalidade').innerHTML =
        '<div style="display:flex;justify-content:space-between;font-size:0.75rem"><span style="color:var(--pi-text-muted)">Total de Turmas</span><strong>' + state.turmas.length + '</strong></div>';
}

/* ───────────────── CHART: CENTROS (BAR) ───────────────── */
function renderChartCentros() {
    var contagem = {};
    state.centros.forEach(function(c) { contagem[c.nome || c.id] = 0; });
    state.inscricoes.forEach(function(ins) {
        var centroNome = null;
        if (ins.turma && ins.turma.centro) centroNome = ins.turma.centro.nome;
        if (centroNome) {
            if (contagem[centroNome] === undefined) contagem[centroNome] = 0;
            contagem[centroNome]++;
        }
    });

    var entries = Object.entries(contagem).sort(function(a,b){ return b[1]-a[1]; }).slice(0, 8);
    var labels = entries.map(function(e){ return e[0]; });
    var values = entries.map(function(e){ return e[1]; });

    var colors = ['#1d4ed8','#2563eb','#3b82f6','#60a5fa','#93c5fd','#bfdbfe','#dbeafe','#eff6ff'];

    var ctx = document.getElementById('chartCentros').getContext('2d');
    if (state.charts.centros) state.charts.centros.destroy();
    state.charts.centros = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{ label:'Pré-Inscrições', data: values, backgroundColor: colors, borderRadius: 6, borderSkipped: false }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, indexAxis: 'y',
            plugins: { legend: { display:false }, tooltip:{ callbacks:{ label: function(c){ return ' ' + c.parsed.x + ' inscrições'; } } } },
            scales: {
                x: { beginAtZero:true, grid:{ color:'rgba(219,234,254,0.4)' }, ticks:{ font:{ size:11 }, stepSize:1 } },
                y: { grid:{ display:false }, ticks:{ font:{ size:11 } } }
            }
        }
    });
}

/* ───────────────── RANKING: CURSOS ───────────────── */
function renderRankingCursos() {
    var contagem = {};
    state.cursos.forEach(function(c) { contagem[c.id] = { nome: c.nome, count: 0 }; });
    state.inscricoes.forEach(function(ins) {
        var cursoId = null;
        if (ins.turma && ins.turma.curso_id) cursoId = ins.turma.curso_id;
        else if (ins.turma && ins.turma.curso) cursoId = ins.turma.curso.id;
        if (cursoId && contagem[cursoId] !== undefined) contagem[cursoId].count++;
    });

    var ranking = Object.values(contagem).sort(function(a,b){ return b.count - a.count; }).slice(0, 5);
    var max = ranking.length ? ranking[0].count : 1;

    if (!ranking.length || ranking.every(function(r){ return !r.count; })) {
        document.getElementById('rankingCursos').innerHTML = '<div class="pi-empty"><div class="pi-empty-icon"><i class="fas fa-trophy"></i></div><p>Sem dados disponíveis</p></div>';
        return;
    }

    var html = '';
    ranking.forEach(function(r, i) {
        var numClass = i === 0 ? 'gold' : (i === 1 ? 'silver' : (i === 2 ? 'bronze' : ''));
        html += '<div class="pi-rank-item">' +
            '<div class="pi-rank-num ' + numClass + '">' + (i+1) + '</div>' +
            '<div class="pi-rank-label">' + esc(r.nome) + '<small>' + r.count + ' inscrições</small></div>' +
            '<div>' +
                '<div style="width:70px;height:6px;background:#e9ecef;border-radius:3px;overflow:hidden;margin-bottom:2px">' +
                    '<div style="height:100%;background:var(--pi-primary);border-radius:3px;width:' + (max ? Math.round(r.count/max*100) : 0) + '%"></div>' +
                '</div>' +
                '<div style="font-size:0.6875rem;font-weight:700;color:var(--pi-primary);text-align:right">' + r.count + '</div>' +
            '</div>' +
        '</div>';
    });
    document.getElementById('rankingCursos').innerHTML = html;
}

/* ───────────────── RANKING: CENTROS ───────────────── */
function renderRankingCentros() {
    var contagem = {};
    state.centros.forEach(function(c) { contagem[c.id] = { nome: c.nome, count: 0 }; });
    state.turmas.forEach(function(t) {
        var centroId = t.centro_id || (t.centro && t.centro.id);
        if (centroId && contagem[centroId] !== undefined) contagem[centroId].count++;
    });

    var ranking = Object.values(contagem).sort(function(a,b){ return b.count - a.count; }).slice(0, 5);
    var max = ranking.length ? ranking[0].count : 1;

    if (!ranking.length || ranking.every(function(r){ return !r.count; })) {
        document.getElementById('rankingCentros').innerHTML = '<div class="pi-empty"><div class="pi-empty-icon"><i class="fas fa-building"></i></div><p>Sem dados disponíveis</p></div>';
        return;
    }

    var html = '';
    ranking.forEach(function(r, i) {
        var numClass = i === 0 ? 'gold' : (i === 1 ? 'silver' : (i === 2 ? 'bronze' : ''));
        html += '<div class="pi-rank-item">' +
            '<div class="pi-rank-num ' + numClass + '">' + (i+1) + '</div>' +
            '<div class="pi-rank-label">' + esc(r.nome) + '<small>' + r.count + ' turmas</small></div>' +
            '<div>' +
                '<div style="width:70px;height:6px;background:#e9ecef;border-radius:3px;overflow:hidden;margin-bottom:2px">' +
                    '<div style="height:100%;background:var(--pi-success);border-radius:3px;width:' + (max ? Math.round(r.count/max*100) : 0) + '%"></div>' +
                '</div>' +
                '<div style="font-size:0.6875rem;font-weight:700;color:var(--pi-success);text-align:right">' + r.count + '</div>' +
            '</div>' +
        '</div>';
    });
    document.getElementById('rankingCentros').innerHTML = html;
}

/* ───────────────── RANKING: FORMADORES ───────────────── */
function renderRankingFormadores() {
    var contagem = {};
    state.formadores.forEach(function(f) { contagem[f.id] = { nome: f.nome || f.name, count: 0 }; });
    state.turmas.forEach(function(t) {
        var fId = t.formador_id || (t.formador && t.formador.id);
        if (fId && contagem[fId] !== undefined) contagem[fId].count++;
    });

    var ranking = Object.values(contagem).sort(function(a,b){ return b.count - a.count; }).slice(0, 4);

    if (!ranking.length) {
        document.getElementById('rankingFormadores').innerHTML = '<div class="pi-empty"><div class="pi-empty-icon"><i class="fas fa-user-tie"></i></div><p>Sem dados</p></div>';
        return;
    }

    var html = '';
    ranking.forEach(function(r, i) {
        var ini = (r.nome || '?').charAt(0).toUpperCase();
        var colors = ['#1d4ed8','#16a34a','#7c3aed','#d97706'];
        html += '<div class="pi-activity-item">' +
            '<div style="width:2rem;height:2rem;border-radius:50%;background:' + colors[i % colors.length] + ';color:#fff;display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;flex-shrink:0">' + ini + '</div>' +
            '<div class="pi-activity-text"><strong>' + esc(r.nome) + '</strong><span style="display:block">' + r.count + ' turma(s)</span></div>' +
            '<div class="pi-activity-time"><span class="pi-badge pi-badge-primary">' + r.count + '</span></div>' +
        '</div>';
    });
    document.getElementById('rankingFormadores').innerHTML = html;
}

/* ───────────────── TAXA DE CONFIRMAÇÃO ───────────────── */
function renderTaxaConfirmacao() {
    var ins = state.inscricoes;
    var total = ins.length;
    var pend = ins.filter(function(i){ return i.status === 'pendente'; }).length;
    var conf = ins.filter(function(i){ return i.status === 'confirmado'; }).length;
    var canc = ins.filter(function(i){ return i.status === 'cancelado'; }).length;

    var taxa = total ? Math.round(conf / total * 100) : 0;
    document.getElementById('taxa-confirmacao').textContent = taxa + '%';

    var barras = [
        { label:'Confirmadas', val: conf, total: total, cor: '#16a34a' },
        { label:'Pendentes',   val: pend, total: total, cor: '#f59e0b' },
        { label:'Canceladas',  val: canc, total: total, cor: '#dc2626' }
    ];
    var html = '';
    barras.forEach(function(b) {
        var w = b.total ? Math.round(b.val / b.total * 100) : 0;
        html += '<div class="pi-prog-item">' +
            '<div class="pi-prog-label">' + b.label + '</div>' +
            '<div class="pi-prog-bar-wrap"><div class="pi-prog-bar-fill" style="width:' + w + '%;background:' + b.cor + '"></div></div>' +
            '<div class="pi-prog-val" style="color:' + b.cor + '">' + b.val + '</div>' +
        '</div>';
    });
    document.getElementById('progressStatuses').innerHTML = html;
}

/* ───────────────── ÚLTIMAS INSCRIÇÕES ───────────────── */
function renderUltimasInscricoes() {
    var ins = state.inscricoes.slice().sort(function(a,b){ return new Date(b.created_at) - new Date(a.created_at); }).slice(0, 8);
    if (!ins.length) {
        document.getElementById('ultimas-inscricoes').innerHTML =
            '<tr><td colspan="7"><div class="pi-empty"><div class="pi-empty-icon"><i class="fas fa-inbox"></i></div><h3>Nenhuma pré-inscrição</h3><p>Ainda não existem pré-inscrições</p></div></td></tr>';
        return;
    }

    var html = '';
    ins.forEach(function(ins, idx) {
        var cursoNome  = ins.turma && ins.turma.curso  ? ins.turma.curso.nome   : '—';
        var centroNome = ins.turma && ins.turma.centro ? ins.turma.centro.nome  : '—';
        var modalidade = ins.turma ? (ins.turma.modalidade || '—') : '—';
        var badge = statusBadge(ins.status);
        var modBadge = '<span class="pi-badge ' + (modalidade === 'online' ? 'pi-badge-primary' : 'pi-badge-info') + '" style="font-size:0.6rem">' + esc(modalidade) + '</span>';

        html += '<tr>' +
            '<td class="mono">#' + ins.id + '</td>' +
            '<td><strong style="font-size:0.8125rem">' + esc(ins.nome_completo) + '</strong>' +
                (ins.email ? '<div style="font-size:0.6875rem;color:var(--pi-text-muted)">' + esc(ins.email) + '</div>' : '') +
            '</td>' +
            '<td style="font-size:0.75rem;max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">' + esc(cursoNome) + '</td>' +
            '<td style="font-size:0.75rem">' + esc(centroNome) + '</td>' +
            '<td>' + modBadge + '</td>' +
            '<td style="font-size:0.75rem;white-space:nowrap">' + formatDate(ins.created_at) + '</td>' +
            '<td>' + badge + '</td>' +
        '</tr>';
    });
    document.getElementById('ultimas-inscricoes').innerHTML = html;
}

function statusBadge(status) {
    switch(status) {
        case 'pendente':   return '<span class="pi-badge pi-badge-pendente"><i class="fas fa-clock"></i> Pendente</span>';
        case 'confirmado': return '<span class="pi-badge pi-badge-confirmado"><i class="fas fa-check-circle"></i> Confirmado</span>';
        case 'cancelado':  return '<span class="pi-badge pi-badge-cancelado"><i class="fas fa-times-circle"></i> Cancelado</span>';
        default: return '<span class="pi-badge" style="background:rgba(100,116,139,0.08);color:#475569">' + esc(status || '—') + '</span>';
    }
}

}());
</script>
@endsection
