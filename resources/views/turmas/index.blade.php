@extends('layouts.app')

@section('title', 'Turmas')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-clock me-3 text-primary"></i>Gestão de Turmas
                    </h1>
                    <p class="text-muted">Gerir todas as turmas dos cursos no sistema</p>
                </div>
                <a href="{{ route('turmas.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Nova Turma
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Lista de Turmas
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover data-table" id="turmasTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Curso</th>
                            <th>Dias da Semana</th>
                            <th>Período</th>
                            <th>Hora Início</th>
                            <th>Hora Fim</th>
                            <th>Duração (Semanas)</th>
                            <th>Data Criação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="9" class="text-center">
                                <i class="fas fa-spinner fa-spin me-2"></i>Carregando turmas...
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
                    <i class="fas fa-eye me-2"></i>Detalhes da Turma
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
    carregarTurmas();
});

/**
 * Carrega e exibe a lista de turmas
 * @function carregarTurmas
 */
function carregarTurmas() {
    $.ajax({
        url: '/api/turmas',
        method: 'GET',
        success: function(data) {
        let html = '';
        
        if (data.length === 0) {
            html = '<tr><td colspan="9" class="text-center text-muted">Nenhuma turma encontrada</td></tr>';
        } else {
            data.forEach(function(turma) {
                const periodoBadge = getPeriodoBadge(turma.periodo);
                const diaSemana = getDiaSemanaFormatado(turma.dia_semana);
                
                const horaInicio = turma.hora_inicio ? turma.hora_inicio.substring(0, 5) : '-';
                const horaFim = turma.hora_fim ? turma.hora_fim.substring(0, 5) : '-';
                const dataExtenso = new Date(turma.created_at).toLocaleDateString('pt-PT');
                
                const cursoNome = turma.curso ? turma.curso.nome : 'N/A';
                const duracao = turma.duracao_semanas || '-';
                
                html += `
                <tr>
                    <td><strong>#${turma.id}</strong></td>
                    <td>${cursoNome}</td>
                    <td><small>${diaSemana}</small></td>
                    <td>${periodoBadge}</td>
                    <td>${horaInicio}</td>
                    <td>${horaFim}</td>
                    <td class="text-center"><span class="badge bg-info">${duracao} sem.</span></td>
                    <td><small>${dataExtenso}</small></td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-info" onclick="verDetalhes(${turma.id})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="/turmas/${turma.id}/edit" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger" onclick="deletarTurma(${turma.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                `;
            });
        }
        
        $('#turmasTable tbody').html(html);
        }, 
        error: function() {
            $('#turmasTable tbody').html(
                '<tr><td colspan="9" class="text-center text-danger">Erro ao carregar turmas</td></tr>'
            );
        }
    });
}

function verDetalhes(turmaId) {
    $.ajax({
        url: `/api/turmas/${turmaId}`,
        method: 'GET',
        success: function(turma) {
            const periodoBadge = getPeriodoBadge(turma.periodo);
            const diaSemana = getDiaSemanaFormatado(turma.dia_semana);
            const horaInicio = turma.hora_inicio ? turma.hora_inicio.substring(0, 5) : '-';
            const horaFim = turma.hora_fim ? turma.hora_fim.substring(0, 5) : '-';
            const cursoNome = turma.curso ? turma.curso.nome : 'N/A';
            const duracao = turma.duracao_semanas || '-';
            
            const content = `
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Curso:</strong>
                        <p>${cursoNome}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Dias da Semana:</strong>
                        <p>${diaSemana}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Período:</strong>
                        <p>${periodoBadge}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Duração:</strong>
                        <p>${duracao} semanas</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Hora Início:</strong>
                        <p>${horaInicio}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Hora Fim:</strong>
                        <p>${horaFim}</p>
                    </div>
                </div>
            `;
            
            $('#viewModalContent').html(content);
            $('#viewModal').modal('show');
        },
        error: function() {
            alert('Erro ao carregar detalhes da turma');
        }
    });
}

function deletarTurma(turmaId) {
    Swal.fire({
        title: 'Tem certeza?',
        text: 'Esta ação não pode ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, deletar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/turmas/${turmaId}`,
                method: 'DELETE',
                success: function(response) {
                    Swal.fire('Deletado!', response.mensagem, 'success');
                    carregarTurmas();
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.mensagem || 'Erro ao deletar turma';
                    Swal.fire('Erro!', message, 'error');
                }
            });
        }
    });
}

function getPeriodoBadge(periodo) {
    switch(periodo) {
        case 'manha':
            return '<span class="badge bg-warning text-dark"><i class="fas fa-sun me-1"></i>Manhã</span>';
        case 'tarde':
            return '<span class="badge bg-primary"><i class="fas fa-cloud-sun me-1"></i>Tarde</span>';
        case 'noite':
            return '<span class="badge bg-dark"><i class="fas fa-moon me-1"></i>Noite</span>';
        default:
            return '<span class="badge bg-secondary">' + periodo + '</span>';
    }
}

function getDiaSemanaFormatado(diasArray) {
    if (!Array.isArray(diasArray)) {
        const dias = {
            'Segunda': 'Segunda-feira',
            'Terça': 'Terça-feira',
            'Quarta': 'Quarta-feira',
            'Quinta': 'Quinta-feira',
            'Sexta': 'Sexta-feira',
            'Sábado': 'Sábado',
            'Domingo': 'Domingo'
        };
        return dias[diasArray] || diasArray;
    }
    
    const diasMap = {
        'Segunda': 'Seg',
        'Terça': 'Ter',
        'Quarta': 'Qua',
        'Quinta': 'Qui',
        'Sexta': 'Sex',
        'Sábado': 'Sab',
        'Domingo': 'Dom'
    };
    
    return diasArray.map(dia => diasMap[dia] || dia).join(', ');
}
</script>
@endsection
