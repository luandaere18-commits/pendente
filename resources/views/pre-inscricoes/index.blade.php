@extends('layouts.app')

@section('title', 'Pré-Inscrições')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-user-plus me-3 text-primary"></i>Gestão de Pré-Inscrições
                    </h1>
                    <p class="text-muted">Gerir todas as pré-inscrições dos candidatos</p>
                </div>
                <a href="{{ route('pre-inscricoes.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Nova Pré-Inscrição
                </a>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="filtroStatus" class="form-label">Status</label>
                    <select class="form-select" id="filtroStatus">
                        <option value="">Todos os status</option>
                        <option value="pendente">Pendente</option>
                        <option value="confirmado">Confirmado</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filtroCurso" class="form-label">Curso</label>
                    <select class="form-select" id="filtroCurso">
                        <option value="">Todos os cursos</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filtroCentro" class="form-label">Centro</label>
                    <select class="form-select" id="filtroCentro">
                        <option value="">Todos os centros</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-secondary me-2" onclick="aplicarFiltros()">
                        <i class="fas fa-filter me-2"></i>Filtrar
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="limparFiltros()">
                        <i class="fas fa-times me-2"></i>Limpar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Lista de Pré-Inscrições
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover data-table" id="preInscricoesTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Curso</th>
                            <th>Centro</th>
                            <th>Horário</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($preInscricoes as $preInscricao)
                            <tr>
                                <td>{{ $preInscricao->id }}</td>
                                <td><strong>{{ $preInscricao->nome_completo }}</strong></td>
                                <td>{{ $preInscricao->email ?? 'Não informado' }}</td>
                                <td>{{ $preInscricao->curso->nome ?? 'Curso não encontrado' }}</td>
                                <td>{{ $preInscricao->centro->nome ?? 'Centro não encontrado' }}</td>
                                <td>
                                    @if($preInscricao->horario)
                                        {{ $preInscricao->horario->dia_semana }} - {{ $preInscricao->horario->periodo }}
                                    @else
                                        <span class="text-muted">Não definido</span>
                                    @endif
                                </td>
                                <td>
                                    @if($preInscricao->status === 'pendente')
                                        <span class="badge bg-warning">Pendente</span>
                                    @elseif($preInscricao->status === 'confirmado')
                                        <span class="badge bg-success">Confirmado</span>
                                    @elseif($preInscricao->status === 'cancelado')
                                        <span class="badge bg-danger">Cancelado</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $preInscricao->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $preInscricao->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-info btn-sm" onclick="visualizarPreInscricao({{ $preInscricao->id }})" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('pre-inscricoes.edit', $preInscricao->id) }}" class="btn btn-outline-warning btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="deletarPreInscricao({{ $preInscricao->id }})" title="Deletar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Nenhuma pré-inscrição encontrada</td>
                            </tr>
                        @endforelse
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
                    <i class="fas fa-eye me-2"></i>Detalhes da Pré-Inscrição
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
    // Inicializar DataTable se necessário
    $('#preInscricoesTable').DataTable({
        language: {
            url: '/js/datatables-pt.js'
        }
    });
});

/**
 * Visualiza os detalhes de uma pré-inscrição específica
 * @param {number} id - ID da pré-inscrição
 */
function visualizarPreInscricao(id) {
    $.ajax({
        url: `/api/pre-inscricoes/${id}`,
        method: 'GET',
        success: function(preInscricao) {
            const statusBadge = getStatusBadge(preInscricao.status);
            
            let contactos = '';
            if (preInscricao.contactos) {
                try {
                    const contactosObj = typeof preInscricao.contactos === 'string' 
                        ? JSON.parse(preInscricao.contactos) 
                        : preInscricao.contactos;
                    
                    contactos = '<ul class="list-unstyled mb-0">';
                    Object.keys(contactosObj).forEach(key => {
                        contactos += `<li><strong>${key}:</strong> ${contactosObj[key]}</li>`;
                    });
                    contactos += '</ul>';
                } catch (e) {
                    contactos = preInscricao.contactos;
                }
            } else {
                contactos = '<span class="text-muted">Nenhum contacto registado</span>';
            }
            
            let html = `
                <div class="row">
                    <div class="col-md-6">
                        <h5>${preInscricao.nome_completo}</h5>
                        <p class="mb-2"><strong>Email:</strong> ${preInscricao.email || '<span class="text-muted">N/A</span>'}</p>
                        <p class="mb-2"><strong>Status:</strong> ${statusBadge}</p>
                        <p class="mb-2"><strong>Data de Inscrição:</strong> ${new Date(preInscricao.created_at).toLocaleDateString('pt-PT')}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Curso:</strong> ${preInscricao.curso ? preInscricao.curso.nome : '<span class="text-muted">N/A</span>'}</p>
                        <p class="mb-2"><strong>Centro:</strong> ${preInscricao.centro ? preInscricao.centro.nome : '<span class="text-muted">N/A</span>'}</p>
                        <p class="mb-2"><strong>Horário:</strong> ${preInscricao.horario ? preInscricao.horario.descricao : '<span class="text-muted">N/A</span>'}</p>
                    </div>
                </div>
                
                <div class="mt-3">
                    <h6><strong>Contactos:</strong></h6>
                    ${contactos}
                </div>
                
                ${preInscricao.observacoes ? `
                    <div class="mt-3">
                        <h6><strong>Observações:</strong></h6>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">${preInscricao.observacoes}</p>
                        </div>
                    </div>
                ` : ''}
            `;
            
            $('#viewModalContent').html(html);
            $('#viewModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Erro ao carregar detalhes da pré-inscrição:', error);
            alert('Erro ao carregar os detalhes da pré-inscrição.');
        }
    });
}

/**
 * Deleta uma pré-inscrição específica
 * @param {number} id - ID da pré-inscrição a deletar
 */
function deletarPreInscricao(id) {
    if (confirm('Tem certeza que deseja deletar esta pré-inscrição? Esta ação não pode ser desfeita.')) {
        // Criar um formulário para enviar a requisição DELETE
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/pre-inscricoes/${id}`;
        form.style.display = 'none';
        
        // Adicionar token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        
        // Adicionar método DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        // Adicionar ao body e submeter
        document.body.appendChild(form);
        form.submit();
    }
}

function getStatusBadge(status) {
    switch (status) {
        case 'pendente':
            return '<span class="badge bg-warning">Pendente</span>';
        case 'confirmado':
            return '<span class="badge bg-success">Confirmado</span>';
        case 'cancelado':
            return '<span class="badge bg-danger">Cancelado</span>';
        default:
            return '<span class="badge bg-secondary">Desconhecido</span>';
    }
}

function aplicarFiltros() {
    // Implementar filtros se necessário
    console.log('Filtros aplicados');
}

function limparFiltros() {
    $('#filtroStatus').val('');
    $('#filtroCurso').val('');
    $('#filtroCentro').val('');
    console.log('Filtros limpos');
}
</script>
@endsection
