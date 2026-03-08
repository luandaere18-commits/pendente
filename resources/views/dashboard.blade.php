@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 mb-3">
                <i class="fas fa-tachometer-alt me-3 text-primary"></i>Dashboard
            </h1>
            <p class="text-muted">Visão geral do sistema de gestão de formação</p>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row mb-5">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="flex-grow-1">
                            <h5 class="card-title text-primary mb-0">Total de Cursos</h5>
                            <h2 class="display-6 fw-bold mb-0" id="total-cursos">-</h2>
                        </div>
                        <div class="fs-1 text-primary opacity-25">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                    </div>
                    <small class="text-muted mt-2">Cursos ativos no sistema</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="flex-grow-1">
                            <h5 class="card-title text-success mb-0">Centros</h5>
                            <h2 class="display-6 fw-bold mb-0" id="total-centros">-</h2>
                        </div>
                        <div class="fs-1 text-success opacity-25">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%"></div>
                    </div>
                    <small class="text-muted mt-2">Centros registados</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="flex-grow-1">
                            <h5 class="card-title text-info mb-0">Formadores</h5>
                            <h2 class="display-6 fw-bold mb-0" id="total-formadores">-</h2>
                        </div>
                        <div class="fs-1 text-info opacity-25">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 85%"></div>
                    </div>
                    <small class="text-muted mt-2">Formadores registados</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="flex-grow-1">
                            <h5 class="card-title text-warning mb-0">Pré-Inscrições</h5>
                            <h2 class="display-6 fw-bold mb-0" id="total-pre-inscricoes">-</h2>
                        </div>
                        <div class="fs-1 text-warning opacity-25">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 90%"></div>
                    </div>
                    <small class="text-muted mt-2">Pendentes de aprovação</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos e Informações Adicionais -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>Últimas Pré-Inscrições
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
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
                                    <td colspan="5" class="text-center text-muted">
                                        <i class="fas fa-spinner fa-spin me-2"></i>Carregando...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Estatísticas Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Cursos Online</span>
                            <span class="badge bg-primary" id="cursos-online">0</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-primary" id="progress-online" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Cursos Presenciais</span>
                            <span class="badge bg-success" id="cursos-presencial">0</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-success" id="progress-presencial" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Pendentes</span>
                            <span class="badge bg-warning text-dark" id="pendentes">0</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-warning" id="progress-pendentes" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('pre-inscricoes.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>Ver Detalhes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Ações Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('cursos.create') }}" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-plus-circle fa-2x mb-2 d-block"></i>
                                Novo Curso
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('centros.create') }}" class="btn btn-success w-100 py-3">
                                <i class="fas fa-building fa-2x mb-2 d-block"></i>
                                Novo Centro
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('formadores.create') }}" class="btn btn-info w-100 py-3">
                                <i class="fas fa-user-plus fa-2x mb-2 d-block"></i>
                                Novo Formador
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('horarios.create') }}" class="btn btn-warning w-100 py-3">
                                <i class="fas fa-clock fa-2x mb-2 d-block"></i>
                                Novo Horário
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    carregarEstatisticas();
    carregarUltimasInscricoes();
});

/**
 * Carrega as estatísticas do dashboard fazendo requisições autenticadas para a API
 */
function carregarEstatisticas() {
    // Carregar total de cursos
    $.ajax({
        url: '/api/cursos',
        method: 'GET',
        success: function(data) {
        $('#total-cursos').text(data.length);
        
        const online = data.filter(curso => curso.modalidade === 'online').length;
        const presencial = data.filter(curso => curso.modalidade === 'presencial').length;
        const total = data.length;
        
        $('#cursos-online').text(online);
        $('#cursos-presencial').text(presencial);
        
        if (total > 0) {
            $('#progress-online').css('width', (online / total * 100) + '%');
            $('#progress-presencial').css('width', (presencial / total * 100) + '%');
        }
        },
        error: function(xhr) {
            console.error('Erro ao carregar cursos:', xhr);
            if (xhr.status === 401) {
                localStorage.removeItem('auth_token');
                window.location.href = '/login';
            }
        }
    });
    
    // Carregar total de centros
    $.ajax({
        url: '/api/centros',
        method: 'GET',
        success: function(data) {
            $('#total-centros').text(data.length);
        },
        error: function(xhr) {
            console.error('Erro ao carregar centros:', xhr);
            if (xhr.status === 401) {
                localStorage.removeItem('auth_token');
                window.location.href = '/login';
            }
        }
    });
    
    // Carregar total de formadores
    $.ajax({
        url: '/api/formadores',
        method: 'GET',
        success: function(data) {
            $('#total-formadores').text(data.length);
        },
        error: function(xhr) {
            console.error('Erro ao carregar formadores:', xhr);
            if (xhr.status === 401) {
                localStorage.removeItem('auth_token');
                window.location.href = '/login';
            }
        }
    });
    
    // Carregar pré-inscrições
    $.ajax({
        url: '/api/pre-inscricoes',
        method: 'GET',
        success: function(data) {
        const pendentes = data.filter(inscricao => inscricao.status === 'pendente').length;
        $('#total-pre-inscricoes').text(pendentes);
        $('#pendentes').text(pendentes);
        
        if (data.length > 0) {
            $('#progress-pendentes').css('width', (pendentes / data.length * 100) + '%');
        }
        },
        error: function(xhr) {
            console.error('Erro ao carregar pré-inscrições:', xhr);
            if (xhr.status === 401) {
                localStorage.removeItem('auth_token');
                window.location.href = '/login';
            }
        }
    });
}

/**
 * Carrega as últimas pré-inscrições para exibir na tabela do dashboard
 */
function carregarUltimasInscricoes() {
    $.ajax({
        url: '/api/pre-inscricoes',
        method: 'GET',
        success: function(data) {
        let html = '';
        
        if (data.length === 0) {
            html = '<tr><td colspan="5" class="text-center text-muted">Nenhuma pré-inscrição encontrada</td></tr>';
        } else {
            // Mostrar apenas as últimas 5
            const ultimas = data.slice(0, 5);
            
            ultimas.forEach(function(inscricao) {
                const statusClass = getStatusClass(inscricao.status);
                const statusText = getStatusText(inscricao.status);
                const data_formatada = new Date(inscricao.created_at).toLocaleDateString('pt-PT');
                const cursoNome = inscricao.curso ? inscricao.curso.nome : `#${inscricao.curso_id}`;
                const centroNome = inscricao.centro ? inscricao.centro.nome : `#${inscricao.centro_id}`;
                html += `
                    <tr>
                        <td>${inscricao.nome_completo}</td>
                        <td><small class="text-muted">${cursoNome}</small></td>
                        <td><small class="text-muted">${centroNome}</small></td>
                        <td><small>${data_formatada}</small></td>
                        <td><span class="badge ${statusClass}">${statusText}</span></td>
                    </tr>
                `;
            });
        }
        
        $('#ultimas-inscricoes').html(html);
        },
        error: function(xhr) {
            console.error('Erro ao carregar últimas inscrições:', xhr);
            if (xhr.status === 401) {
                localStorage.removeItem('auth_token');
                window.location.href = '/login';
            }
        }
    });
}

/**
 * Retorna a classe CSS adequada para o status da pré-inscrição
 * @param {string} status - O status da pré-inscrição
 * @returns {string} - A classe CSS correspondente
 */
function getStatusClass(status) {
    switch(status) {
        case 'pendente': return 'bg-warning text-dark';
        case 'confirmado': return 'bg-success';
        case 'cancelado': return 'bg-danger';
        default: return 'bg-secondary';
    }
}

/**
 * Retorna o texto legível para o status da pré-inscrição
 * @param {string} status - O status da pré-inscrição
 * @returns {string} - O texto correspondente ao status
 */
function getStatusText(status) {
    switch(status) {
        case 'pendente': return 'Pendente';
        case 'confirmado': return 'Confirmado';
        case 'cancelado': return 'Cancelado';
        default: return status;
    }
}
</script>
@endsection
