@extends('layouts.app')

@section('title', 'Cronogramas')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-clock me-3 text-primary"></i>Gestão de Cronogramas
                    </h1>
                    <p class="text-muted">Gerir todos os cronogramas dos cursos no sistema</p>
                </div>
                <a href="{{ route('cronogramas.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Novo Cronograma
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Lista de Cronogramas
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover data-table" id="cronogramasTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Curso</th>
                            <th>Dia da Semana</th>
                            <th>Período</th>
                            <th>Hora Início</th>
                            <th>Hora Fim</th>
                            <th>Data Criação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center">
                                <i class="fas fa-spinner fa-spin me-2"></i>Carregando cronogramas...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Visualização -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Detalhes do Cronograma
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewModalContent">
                <!-- Conteúdo será carregado via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    carregarCronogramas();
});

/**
 * Carrega e exibe a lista de cronogramas
 * @function carregarCronogramas
 */
function carregarCronogramas() {
    $.ajax({
        url: '/api/cronogramas',
        method: 'GET',
        success: function(data) {
        let html = '';
        
        if (data.length === 0) {
            html = '<tr><td colspan="8" class="text-center text-muted">Nenhum cronograma encontrado</td></tr>';
        } else {
            data.forEach(function(cronograma) {
                const periodoBadge = getPeriodoBadge(cronograma.periodo);
                const diaSemana = getDiaSemanaFormatado(cronograma.dia_semana);
                
                const horaInicio = cronograma.hora_inicio ? cronograma.hora_inicio.substring(0, 5) : '-';
                const horaFim = cronograma.hora_fim ? cronograma.hora_fim.substring(0, 5) : '-';
                
                const dataFormatada = new Date(cronograma.created_at).toLocaleDateString('pt-PT');
                
                html += `
                    <tr>
                        <td>${cronograma.id}</td>
                        <td>
                            <strong>${cronograma.curso ? cronograma.curso.nome : 'N/A'}</strong>
                            ${cronograma.curso && cronograma.curso.area ? `<br><small class="text-muted">${cronograma.curso.area}</small>` : ''}
                        </td>
                        <td>${diaSemana}</td>
                        <td>${periodoBadge}</td>
                        <td class="text-center">${horaInicio}</td>
                        <td class="text-center">${horaFim}</td>
                        <td>${dataFormatada}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="visualizarCronograma(${cronograma.id})" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="/cronogramas/${cronograma.id}/edit" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarCronograma(${cronograma.id})" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }
        
        $('#cronogramasTable tbody').html(html);
        
        // Reinicializar DataTable se já existir
        if ($.fn.DataTable.isDataTable('#cronogramasTable')) {
            $('#cronogramasTable').DataTable().destroy();
        }
        
        $('#cronogramasTable').DataTable({
            language: window.dataTablesPortuguese,
            responsive: true,
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' + 
                 '<"row"<"col-sm-12"tr>>' + 
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            order: [[0, 'desc']]
        });
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                localStorage.removeItem('auth_token');
                window.location.href = '/login';
                return;
            }
            
            let html = '<tr><td colspan="8" class="text-center text-danger">Erro ao carregar cronogramas. Tente novamente.</td></tr>';
            $('#cronogramasTable tbody').html(html);
        }
    });
}

/**
 * Obtém a badge formatada para o período do cronograma
 * @param {string} periodo - O período (manhã, tarde, noite)
 * @returns {string} HTML da badge formatada
 */
function getPeriodoBadge(periodo) {
    switch(periodo) {
        case 'manhã':
            return '<span class="badge bg-warning text-dark"><i class="fas fa-sun me-1"></i>Manhã</span>';
        case 'tarde':
            return '<span class="badge bg-primary"><i class="fas fa-cloud-sun me-1"></i>Tarde</span>';
        case 'noite':
            return '<span class="badge bg-dark"><i class="fas fa-moon me-1"></i>Noite</span>';
        default:
            return '<span class="badge bg-secondary">N/A</span>';
    }
}

/**
 * Formata o nome do dia da semana
 * @param {string} dia - Dia da semana abreviado
 * @returns {string} Nome completo do dia da semana
 */
function getDiaSemanaFormatado(dia) {
    const dias = {
        'Segunda': 'Segunda-feira',
        'Terça': 'Terça-feira',
        'Quarta': 'Quarta-feira',
        'Quinta': 'Quinta-feira',
        'Sexta': 'Sexta-feira',
        'Sábado': 'Sábado',
        'Domingo': 'Domingo'
    };
    return dias[dia] || dia;
}

/**
 * Exibe os detalhes de um cronograma específico em modal
 * @param {number} id - ID do cronograma a visualizar
 */
function visualizarCronograma(id) {
    $.ajax({
        url: `/api/cronogramas/${id}`,
        method: 'GET',
        success: function(cronograma) {
        const periodoBadge = getPeriodoBadge(cronograma.periodo);
        const diaSemana = getDiaSemanaFormatado(cronograma.dia_semana);
        
        const horaInicio = cronograma.hora_inicio ? cronograma.hora_inicio.substring(0, 5) : 'Não definida';
        const horaFim = cronograma.hora_fim ? cronograma.hora_fim.substring(0, 5) : 'Não definida';
        
        let html = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5><i class="fas fa-book me-2 text-primary"></i>Curso</h5>
                    <div class="p-3 bg-light rounded">
                        <h6>${cronograma.curso ? cronograma.curso.nome : 'N/A'}</h6>
                        ${cronograma.curso && cronograma.curso.area ? `<p class="mb-1"><strong>Área:</strong> ${cronograma.curso.area}</p>` : ''}
                        ${cronograma.curso && cronograma.curso.modalidade ? `<p class="mb-0"><strong>Modalidade:</strong> ${cronograma.curso.modalidade}</p>` : ''}
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <h5><i class="fas fa-calendar-day me-2 text-info"></i>Dia da Semana</h5>
                    <div class="p-3 bg-light rounded">
                        <h6>${diaSemana}</h6>
                        <p class="mb-0"><strong>Período:</strong> ${periodoBadge}</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6><i class="fas fa-clock me-2"></i>Hora de Início</h6>
                    <p class="h5">${horaInicio}</p>
                </div>
                
                <div class="col-md-6 mb-3">
                    <h6><i class="fas fa-clock me-2"></i>Hora de Fim</h6>
                    <p class="h5">${horaFim}</p>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12">
                    <h6><i class="fas fa-info-circle me-2"></i>Informações Adicionais</h6>
                    <p class="mb-1"><strong>Data de Criação:</strong> ${new Date(cronograma.created_at).toLocaleDateString('pt-PT')}</p>
                    <p class="mb-0"><strong>Última Atualização:</strong> ${new Date(cronograma.updated_at).toLocaleDateString('pt-PT')}</p>
                </div>
            </div>
        `;
        
        $('#viewModalContent').html(html);
        $('#viewModal').modal('show');
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                localStorage.removeItem('auth_token');
                window.location.href = '/login';
                return;
            }
            
            Swal.fire(
                'Erro!',
                'Ocorreu um erro ao carregar os detalhes do cronograma.',
                'error'
            );
        }
    });
}

/**
 * Remove um cronograma após confirmação do utilizador
 * @param {number} id - ID do cronograma a eliminar
 */
function eliminarCronograma(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: 'Esta ação irá eliminar o cronograma permanentemente!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Sim, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/cronogramas/${id}`,
                method: 'DELETE',
                success: function(response) {
                    Swal.fire(
                        'Eliminado!',
                        'O cronograma foi eliminado com sucesso.',
                        'success'
                    );
                    carregarCronogramas();
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        localStorage.removeItem('auth_token');
                        window.location.href = '/login';
                        return;
                    }
                    
                    Swal.fire(
                        'Erro!',
                        'Ocorreu um erro ao eliminar o cronograma.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>
@endsection
