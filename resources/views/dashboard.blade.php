@extends('layouts.app')

@section('title', 'Dashboard')

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

    /* ── BLUE HEADER ── */
    .pi-page-header {
        background: var(--pi-primary-gradient);
        color: #fff;
        padding: 1rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 0.75rem;
    }
    .pi-page-header h1 { font-size: 1.25rem; font-weight: 700; margin: 0; letter-spacing: -0.02em; color: #fff; }
    .pi-page-header p { font-size: 0.75rem; color: rgba(255,255,255,0.75); margin: 0; }

    /* ── STATS BAR ── */
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
    .pi-stat-icon.cyan { background: var(--pi-info-light); color: var(--pi-info); }
    .pi-stat-icon.yellow { background: var(--pi-warning-light); color: var(--pi-warning); }
    .pi-stat-label { font-size: 0.6875rem; font-weight: 500; color: var(--pi-text-muted); text-transform: uppercase; letter-spacing: 0.04em; }
    .pi-stat-value { font-size: 1.375rem; font-weight: 700; line-height: 1; }

    /* ── CARDS ── */
    .pi-card {
        background: #fff; border: 1px solid var(--pi-border); border-radius: var(--pi-radius);
        box-shadow: var(--pi-shadow); overflow: hidden; margin: 0.75rem;
    }
    .pi-card-header {
        border-bottom: 1px solid var(--pi-border); padding: 0.625rem 1rem;
        display: flex; align-items: center; justify-content: space-between;
        background: var(--pi-primary-light);
    }
    .pi-card-header h2 { font-size: 0.8125rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.375rem; color: var(--pi-text); }
    .pi-card-header .count-badge { background: var(--pi-primary); color: #fff; font-size: 0.625rem; font-weight: 700; padding: 0.125rem 0.4375rem; border-radius: 9999px; }
    .pi-card-body { padding: 1rem; }

    /* ── TABLE ── */
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

    /* ── BADGES ── */
    .pi-badge {
        display: inline-flex; align-items: center; gap: 0.25rem;
        padding: 0.15rem 0.5rem; border-radius: 9999px;
        font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.01em;
    }
    .pi-badge-pendente { background: var(--pi-warning-light); color: #92610a; }
    .pi-badge-confirmado { background: var(--pi-success-light); color: #1e6e49; }
    .pi-badge-cancelado { background: var(--pi-danger-light); color: #a71d2a; }

    /* ── PROGRESS BAR ── */
    .pi-progress-wrap { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem; }
    .pi-progress-label { font-size: 0.75rem; font-weight: 500; color: var(--pi-text); min-width: 120px; }
    .pi-progress-bar { flex: 1; height: 6px; background: #e9ecef; border-radius: 3px; overflow: hidden; }
    .pi-progress-bar-fill { height: 100%; border-radius: 3px; transition: width 0.3s ease; }
    .pi-progress-value { font-size: 0.6875rem; font-weight: 600; min-width: 30px; text-align: right; }

    /* ── QUICK ACTIONS ── */
    .pi-actions-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem; }
    .pi-action-card {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 1.25rem 0.75rem; border-radius: var(--pi-radius);
        text-decoration: none; transition: all 0.15s; gap: 0.5rem;
        font-size: 0.8125rem; font-weight: 600; cursor: pointer; border: none;
    }
    .pi-action-card i { font-size: 1.5rem; }
    .pi-action-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .pi-action-card.primary { background: var(--pi-primary); color: #fff; }
    .pi-action-card.primary:hover { background: var(--pi-primary-dark); color: #fff; }
    .pi-action-card.success { background: var(--pi-success); color: #fff; }
    .pi-action-card.success:hover { background: #15803d; color: #fff; }
    .pi-action-card.info { background: var(--pi-info); color: #fff; }
    .pi-action-card.info:hover { background: #0369a1; color: #fff; }
    .pi-action-card.warning { background: var(--pi-warning); color: #fff; }
    .pi-action-card.warning:hover { background: #b45309; color: #fff; }

    /* ── EMPTY ── */
    .pi-empty { text-align: center; padding: 2.5rem 1rem; color: var(--pi-text-muted); }
    .pi-empty-icon { width: 3rem; height: 3rem; border-radius: 0.75rem; background: var(--pi-primary-light); display: inline-flex; align-items: center; justify-content: center; font-size: 1.125rem; margin-bottom: 0.5rem; color: var(--pi-primary); }
    .pi-empty h3 { font-size: 0.9375rem; font-weight: 600; margin-bottom: 0.125rem; color: var(--pi-text); }
    .pi-empty p { font-size: 0.75rem; }

    /* ── RESPONSIVE ── */
    @media (max-width: 991.98px) {
        .pi-actions-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 767.98px) {
        .pi-stats-bar { grid-template-columns: repeat(2, 1fr); }
        .pi-stat { border-bottom: 1px solid var(--pi-border); }
        .pi-page-header { flex-direction: column; align-items: stretch; }
        .pi-actions-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 575.98px) {
        .pi-page-header { padding: 0.75rem; }
        .pi-stat { padding: 0.5rem 0.75rem; }
        .pi-card { margin: 0.5rem; }
        .pi-actions-grid { grid-template-columns: 1fr 1fr; gap: 0.5rem; }
    }
</style>
@endsection

@section('content')
<div class="pi-page">

    {{-- BLUE HEADER --}}
    <div class="pi-page-header">
        <div>
            <div style="display:flex;align-items:center;gap:0.625rem">
                <i class="fas fa-tachometer-alt fa-lg" style="opacity:0.9"></i>
                <div>
                    <h1>Dashboard</h1>
                    <p>Visão geral do sistema de gestão de formação</p>
                </div>
            </div>
        </div>
    </div>

    {{-- STATS BAR --}}
    <div class="pi-stats-bar">
        <div class="pi-stat">
            <div class="pi-stat-icon blue"><i class="fas fa-book"></i></div>
            <div>
                <div class="pi-stat-label">Cursos</div>
                <div class="pi-stat-value" style="color:var(--pi-primary)" id="total-cursos">-</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon green"><i class="fas fa-building"></i></div>
            <div>
                <div class="pi-stat-label">Centros</div>
                <div class="pi-stat-value" style="color:var(--pi-success)" id="total-centros">-</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon cyan"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <div class="pi-stat-label">Formadores</div>
                <div class="pi-stat-value" style="color:var(--pi-info)" id="total-formadores">-</div>
            </div>
        </div>
        <div class="pi-stat">
            <div class="pi-stat-icon yellow"><i class="fas fa-user-plus"></i></div>
            <div>
                <div class="pi-stat-label">Pré-Inscrições</div>
                <div class="pi-stat-value" style="color:var(--pi-warning)" id="total-pre-inscricoes">-</div>
            </div>
        </div>
    </div>

    {{-- CONTENT AREA --}}
    <div style="display:grid;grid-template-columns:1fr 340px;gap:0;align-items:start">

        {{-- ÚLTIMAS PRÉ-INSCRIÇÕES --}}
        <div class="pi-card" style="margin-right:0">
            <div class="pi-card-header">
                <h2><i class="fas fa-chart-line" style="color:var(--pi-primary)"></i> Últimas Pré-Inscrições</h2>
            </div>
            <div style="overflow-x:auto">
                <table class="pi-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Curso</th>
                            <th>Centro</th>
                            <th>Data</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="ultimas-inscricoes">
                        <tr>
                            <td colspan="5">
                                <div class="pi-empty">
                                    <div class="pi-empty-icon"><i class="fas fa-spinner fa-spin"></i></div>
                                    <p>Carregando...</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ESTATÍSTICAS RÁPIDAS --}}
        <div class="pi-card" style="margin-left:0">
            <div class="pi-card-header">
                <h2><i class="fas fa-chart-pie" style="color:var(--pi-success)"></i> Estatísticas Rápidas</h2>
            </div>
            <div class="pi-card-body">
                <div class="pi-progress-wrap">
                    <span class="pi-progress-label">Cursos Online</span>
                    <div class="pi-progress-bar">
                        <div class="pi-progress-bar-fill" id="progress-online" style="width:0%;background:var(--pi-primary)"></div>
                    </div>
                    <span class="pi-progress-value" id="cursos-online" style="color:var(--pi-primary)">0</span>
                </div>
                <div class="pi-progress-wrap">
                    <span class="pi-progress-label">Cursos Presenciais</span>
                    <div class="pi-progress-bar">
                        <div class="pi-progress-bar-fill" id="progress-presencial" style="width:0%;background:var(--pi-success)"></div>
                    </div>
                    <span class="pi-progress-value" id="cursos-presencial" style="color:var(--pi-success)">0</span>
                </div>
                <div class="pi-progress-wrap">
                    <span class="pi-progress-label">Pendentes</span>
                    <div class="pi-progress-bar">
                        <div class="pi-progress-bar-fill" id="progress-pendentes" style="width:0%;background:var(--pi-warning)"></div>
                    </div>
                    <span class="pi-progress-value" id="pendentes" style="color:var(--pi-warning)">0</span>
                </div>

                <div style="text-align:center;margin-top:1.25rem">
                    <a href="{{ route('pre-inscricoes.index') }}" style="display:inline-flex;align-items:center;gap:0.375rem;padding:0.4375rem 0.875rem;border-radius:var(--pi-radius);background:var(--pi-primary);color:#fff;font-size:0.8125rem;font-weight:500;text-decoration:none;transition:all 0.15s">
                        <i class="fas fa-eye"></i> Ver Detalhes
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- AÇÕES RÁPIDAS --}}
    <div class="pi-card">
        <div class="pi-card-header">
            <h2><i class="fas fa-bolt" style="color:var(--pi-warning)"></i> Ações Rápidas</h2>
        </div>
        <div class="pi-card-body">
            <div class="pi-actions-grid">
                <a href="{{ route('cursos.create') }}" class="pi-action-card primary">
                    <i class="fas fa-plus-circle"></i>
                    Novo Curso
                </a>
                <a href="{{ route('centros.create') }}" class="pi-action-card success">
                    <i class="fas fa-building"></i>
                    Novo Centro
                </a>
                <a href="{{ route('formadores.create') }}" class="pi-action-card info">
                    <i class="fas fa-user-plus"></i>
                    Novo Formador
                </a>
                <a href="{{ route('turmas.create') }}" class="pi-action-card warning">
                    <i class="fas fa-clock"></i>
                    Nova Turma
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    carregarEstatisticas();
    carregarUltimasInscricoes();
});

function carregarEstatisticas() {
    // Carregar total de cursos
    $.ajax({
        url: '/cursos',
        method: 'GET',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        success: function(data) {
            let cursos = Array.isArray(data) ? data : (data.data || []);
            $('#total-cursos').text(cursos.length);

            // Calcular cursos online vs presencial
            let online = 0, presencial = 0;
            cursos.forEach(function(c) {
                if (c.turmas && Array.isArray(c.turmas)) {
                    c.turmas.forEach(function(t) {
                        if (t.modalidade === 'online') online++;
                        else if (t.modalidade === 'presencial') presencial++;
                    });
                }
            });
            let total = online + presencial;
            $('#cursos-online').text(online);
            $('#cursos-presencial').text(presencial);
            if (total > 0) {
                $('#progress-online').css('width', (online / total * 100) + '%');
                $('#progress-presencial').css('width', (presencial / total * 100) + '%');
            }
        },
        error: function(xhr) {
            console.error('Erro ao carregar cursos:', xhr);
            $('#total-cursos').text('0');
        }
    });

    // Carregar total de centros
    $.ajax({
        url: '/centros',
        method: 'GET',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        success: function(data) {
            let centros = Array.isArray(data) ? data : (data.data || []);
            $('#total-centros').text(centros.length);
        },
        error: function(xhr) {
            console.error('Erro ao carregar centros:', xhr);
            $('#total-centros').text('0');
        }
    });

    // Carregar total de formadores
    $.ajax({
        url: '/formadores',
        method: 'GET',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        success: function(data) {
            let formadores = Array.isArray(data) ? data : (data.data || []);
            $('#total-formadores').text(formadores.length);
        },
        error: function(xhr) {
            console.error('Erro ao carregar formadores:', xhr);
            $('#total-formadores').text('0');
        }
    });

    // Carregar pré-inscrições
    $.ajax({
        url: '/pre-inscricoes',
        method: 'GET',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        success: function(data) {
            let inscricoes = Array.isArray(data) ? data : (data.data || []);
            const pendentes = inscricoes.filter(function(i) { return i.status === 'pendente'; }).length;
            $('#total-pre-inscricoes').text(pendentes);
            $('#pendentes').text(pendentes);
            if (inscricoes.length > 0) {
                $('#progress-pendentes').css('width', (pendentes / inscricoes.length * 100) + '%');
            }
        },
        error: function(xhr) {
            console.error('Erro ao carregar pré-inscrições:', xhr);
            $('#total-pre-inscricoes').text('0');
        }
    });
}

function carregarUltimasInscricoes() {
    $.ajax({
        url: '/pre-inscricoes',
        method: 'GET',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        success: function(data) {
            let inscricoes = Array.isArray(data) ? data : (data.data || []);
            let html = '';

            if (!inscricoes || inscricoes.length === 0) {
                html = '<tr><td colspan="5"><div class="pi-empty"><div class="pi-empty-icon"><i class="fas fa-inbox"></i></div><h3>Nenhuma pré-inscrição</h3><p>Ainda não existem pré-inscrições no sistema</p></div></td></tr>';
            } else {
                inscricoes.sort(function(a, b) {
                    return new Date(b.created_at) - new Date(a.created_at);
                });
                var ultimas = inscricoes.slice(0, 5);

                ultimas.forEach(function(inscricao) {
                    var statusBadge = getStatusBadge(inscricao.status);
                    var dataFormatada = '';
                    try {
                        dataFormatada = new Date(inscricao.created_at).toLocaleDateString('pt-PT', {
                            year: 'numeric', month: '2-digit', day: '2-digit',
                            hour: '2-digit', minute: '2-digit'
                        });
                    } catch(e) { dataFormatada = '—'; }

                    var cursoNome = 'N/A';
                    var centroNome = 'N/A';
                    if (inscricao.turma) {
                        if (inscricao.turma.curso) cursoNome = inscricao.turma.curso.nome;
                        if (inscricao.turma.centro) centroNome = inscricao.turma.centro.nome;
                    }

                    html += '<tr>';
                    html += '<td><strong>' + escHtml(inscricao.nome_completo) + '</strong></td>';
                    html += '<td style="font-size:0.75rem;color:var(--pi-text-muted)">' + escHtml(cursoNome) + '</td>';
                    html += '<td style="font-size:0.75rem;color:var(--pi-text-muted)">' + escHtml(centroNome) + '</td>';
                    html += '<td style="font-size:0.75rem">' + dataFormatada + '</td>';
                    html += '<td>' + statusBadge + '</td>';
                    html += '</tr>';
                });
            }

            $('#ultimas-inscricoes').html(html);
        },
        error: function(xhr) {
            console.error('Erro ao carregar últimas inscrições:', xhr);
            $('#ultimas-inscricoes').html(
                '<tr><td colspan="5"><div class="pi-empty"><div class="pi-empty-icon" style="background:var(--pi-danger-light);color:var(--pi-danger)"><i class="fas fa-exclamation-triangle"></i></div><h3>Erro ao carregar</h3><p>Não foi possível carregar os dados</p></div></td></tr>'
            );
        }
    });
}

function escHtml(str) {
    if (!str) return '';
    var div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function getStatusBadge(status) {
    switch(status) {
        case 'pendente': return '<span class="pi-badge pi-badge-pendente"><i class="fas fa-clock"></i> Pendente</span>';
        case 'confirmado': return '<span class="pi-badge pi-badge-confirmado"><i class="fas fa-check-circle"></i> Confirmado</span>';
        case 'cancelado': return '<span class="pi-badge pi-badge-cancelado"><i class="fas fa-times-circle"></i> Cancelado</span>';
        default: return '<span class="pi-badge" style="background:rgba(100,116,139,0.08);color:#475569">' + escHtml(status) + '</span>';
    }
}
</script>
@endsection
