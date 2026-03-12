@extends('layouts.app')

@section('title', 'Pré-Inscrições')

@section('content')
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col-12 col-md-8 mb-3 mb-md-0">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                    <i class="fas fa-user-check text-primary fa-lg"></i>
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-0">Gestão de Pré-Inscrições</h1>
                    <p class="text-muted mb-0 small">Gerir todas as pré-inscrições dos candidatos</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <a href="{{ route('pre-inscricoes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nova Pré-Inscrição
            </a>
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="filtroStatus" class="form-label small fw-semibold">Status</label>
                    <select class="form-select form-select-sm" id="filtroStatus" onchange="aplicarFiltros()">
                        <option value="">Todos os status</option>
                        <option value="pendente">Pendente</option>
                        <option value="confirmado">Confirmado</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filtroCurso" class="form-label small fw-semibold">Curso</label>
                    <select class="form-select form-select-sm" id="filtroCurso" onchange="aplicarFiltros()">
                        <option value="">Todos os cursos</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filtroCentro" class="form-label small fw-semibold">Centro</label>
                    <select class="form-select form-select-sm" id="filtroCentro" onchange="aplicarFiltros()">
                        <option value="">Todos os centros</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="limparFiltros()">
                        <i class="fas fa-redo me-1"></i>Limpar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- TABELA DE PRÉ-INSCRIÇÕES --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-list text-primary"></i>
                <h5 class="mb-0 fw-semibold">Lista de Pré-Inscrições</h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="preInscricoesTable" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-2" style="width:50px">ID</th>
                            <th style="width:200px">Nome</th>
                            <th style="width:180px">Email</th>
                            <th style="width:180px">Turma</th>
                            <th class="text-center" style="width:110px">Período</th>
                            <th class="text-center" style="width:100px">Dias</th>
                            <th class="text-center" style="width:110px">Arranque</th>
                            <th class="text-center" style="width:100px">Status</th>
                            <th class="text-end pe-2" style="width:180px">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($preInscricoes as $preInscricao)
                            <tr>
                                <td class="ps-2"><small class="text-muted">#{{ $preInscricao->id }}</small></td>
                                <td><strong>{{ $preInscricao->nome_completo }}</strong></td>
                                <td><small>{{ $preInscricao->email ?? '—' }}</small></td>
                                <td>
                                    @if($preInscricao->turma)
                                        <small><strong>{{ $preInscricao->turma->curso->nome ?? 'Curso desconhecido' }}</strong></small>
                                    @else
                                        <span class="text-muted small">Sem turma</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($preInscricao->turma)
                                        <span class="badge bg-secondary">{{ ucfirst(str_replace('manhã', 'Manhã', str_replace('tarde', 'Tarde', str_replace('noite', 'Noite', $preInscricao->turma->periodo)))) }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($preInscricao->turma && $preInscricao->turma->dia_semana)
                                        <small>{{ implode(', ', $preInscricao->turma->dia_semana) }}</small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($preInscricao->turma && $preInscricao->turma->data_arranque)
                                        <small>{{ \Carbon\Carbon::parse($preInscricao->turma->data_arranque)->format('d/m/Y') }}</small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($preInscricao->status === 'pendente')
                                        <span class="badge bg-warning text-dark">Pendente</span>
                                    @elseif($preInscricao->status === 'confirmado')
                                        <span class="badge bg-success">Confirmado</span>
                                    @elseif($preInscricao->status === 'cancelado')
                                        <span class="badge bg-danger">Cancelado</span>
                                    @endif
                                </td>
                                <td class="text-end pe-2">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-info" onclick="visualizarPreInscricao({{ $preInscricao->id }})" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if($preInscricao->status !== 'confirmado')
                                        <button type="button" class="btn btn-outline-success" onclick="confirmarPreInscricao({{ $preInscricao->id }})" title="Confirmar">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                        @if($preInscricao->status !== 'cancelado')
                                        <button type="button" class="btn btn-outline-danger" onclick="cancelarPreInscricao({{ $preInscricao->id }})" title="Cancelar">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <div class="mb-2"><i class="fas fa-inbox fa-2x text-muted"></i></div>
                                    Nenhuma pré-inscrição encontrada
                                </td>
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
    // Carregar opções de filtro
    carregarFiltros();
});

/**
 * Carrega as opções de filtros (cursos e centros)
 */
function carregarFiltros() {
    // Carregar cursos
    $.get('/api/cursos', function(data) {
        let options = '<option value="">Todos os cursos</option>';
        data.forEach(function(curso) {
            if (curso.ativo) {
                options += `<option value="${curso.id}">${curso.nome}</option>`;
            }
        });
        $('#filtroCurso').html(options);
    });
    
    // Carregar centros
    $.get('/api/centros', function(data) {
        let options = '<option value="">Todos os centros</option>';
        data.forEach(function(centro) {
            if (centro.ativo) {
                options += `<option value="${centro.id}">${centro.nome}</option>`;
            }
        });
        $('#filtroCentro').html(options);
    });
}

/**
 * Visualiza os detalhes de uma pré-inscrição específica
 * @param {number} id - ID da pré-inscrição
 */
function visualizarPreInscricao(id) {
    $.ajax({
        url: `/pre-inscricoes/${id}`,
        method: 'GET',
        success: function(response) {
            // Redirecionar para a página show
            window.location.href = `/pre-inscricoes/${id}`;
        },
        error: function(xhr, status, error) {
            console.error('Erro ao carregar pré-inscrição:', error);
            alert('Erro ao carregar os detalhes da pré-inscrição.');
        }
    });
}

/**
 * Confirma uma pré-inscrição (muda status para confirmado)
 * @param {number} id - ID da pré-inscrição
 */
function confirmarPreInscricao(id) {
    if (confirm('Tem certeza que deseja confirmar esta pré-inscrição?')) {
        atualizarStatusPreInscricao(id, 'confirmado');
    }
}

/**
 * Cancela uma pré-inscrição (muda status para cancelado)
 * @param {number} id - ID da pré-inscrição
 */
function cancelarPreInscricao(id) {
    if (confirm('Tem certeza que deseja cancelar esta pré-inscrição?')) {
        atualizarStatusPreInscricao(id, 'cancelado');
    }
}

/**
 * Atualiza o status de uma pré-inscrição
 * @param {number} id - ID da pré-inscrição
 * @param {string} status - Novo status
 */
function atualizarStatusPreInscricao(id, status) {
    $.ajax({
        url: `/api/pre-inscricoes/${id}`,
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify({ status: status }),
        success: function(response) {
            // Recarregar a página para refletir as mudanças
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error('Erro ao atualizar status:', error);
            const errorMsg = xhr.responseJSON?.message || 'Erro ao atualizar o status da pré-inscrição.';
            alert(errorMsg);
        }
    });
}

/**
 * Aplica filtros e recarrega a tabela
 */
function aplicarFiltros() {
    const status = $('#filtroStatus').val();
    const curso = $('#filtroCurso').val();
    const centro = $('#filtroCentro').val();
    
    // Montar URL com parâmetros
    let url = '/pre-inscricoes?';
    if (status) url += `status=${status}&`;
    if (curso) url += `curso=${curso}&`;
    if (centro) url += `centro=${centro}`;
    
    // Redirecionar para a URL com filtros
    window.location.href = url;
}

/**
 * Limpa os filtros
 */
function limparFiltros() {
    $('#filtroStatus').val('');
    $('#filtroCurso').val('');
    $('#filtroCentro').val('');
    window.location.href = '/pre-inscricoes';
}

function getStatusBadge(status) {
    switch (status) {
        case 'pendente':
            return '<span class="badge bg-warning text-dark">Pendente</span>';
        case 'confirmado':
            return '<span class="badge bg-success">Confirmado</span>';
        case 'cancelado':
            return '<span class="badge bg-danger">Cancelado</span>';
        default:
            return '<span class="badge bg-secondary">Desconhecido</span>';
    }
}
</script>
@endsection
