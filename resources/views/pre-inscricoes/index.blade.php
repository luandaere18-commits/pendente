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
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovaPreInscricao">
                <i class="fas fa-plus me-2"></i>Nova Pré-Inscrição
            </button>
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
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-eye text-primary"></i>
                    <h5 class="modal-title fw-semibold mb-0">Detalhes da Pré-Inscrição</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="viewModalContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="text-muted mt-3 mb-0">Carregando detalhes...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Criar Pré-Inscrição -->
<div class="modal fade" id="modalNovaPreInscricao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            {{-- Header --}}
            <div class="modal-header bg-light border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-plus text-primary"></i>
                    </div>
                    <h5 class="modal-title fw-semibold mb-0">Criar Nova Pré-Inscrição</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formCriarPreInscricao">
                    @csrf

                    {{-- Turma --}}
                    <div class="mb-3">
                        <label for="criarTurmaId" class="form-label fw-semibold">Turma <span class="text-danger">*</span></label>
                        <select class="form-select" id="criarTurmaId" name="turma_id" required>
                            <option value="">Selecione uma turma...</option>
                        </select>
                        <small class="form-text text-muted">Selecione a turma para esta pré-inscrição</small>
                    </div>

                    {{-- Nome Completo --}}
                    <div class="mb-3">
                        <label for="criarNomeCompleto" class="form-label fw-semibold">Nome Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="criarNomeCompleto" name="nome_completo" required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="criarEmail" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="criarEmail" name="email">
                    </div>

                    {{-- Contactos --}}
                    <div class="mb-3">
                        <label for="criarContactos" class="form-label fw-semibold">Contactos</label>
                        <input type="text" class="form-control" id="criarContactos" name="contactos[]" placeholder="ex: +351 91 234 5678">
                        <small class="form-text text-muted">Pode adicionar vários contactos</small>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label for="criarStatus" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="criarStatus" name="status" required>
                            <option value="pendente">Pendente</option>
                            <option value="confirmado">Confirmado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>

                    {{-- Observações --}}
                    <div class="mb-3">
                        <label for="criarObservacoes" class="form-label fw-semibold">Observações</label>
                        <textarea class="form-control" id="criarObservacoes" name="observacoes" rows="3"></textarea>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-primary" onclick="salvarPreInscricao()">
                    <i class="fas fa-save me-2"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Carregar opções de filtro
    carregarFiltros();
    // Carregar turmas para o formulário
    carregarTurmas();
});

/**
 * Carrega as turmas para o dropdown de criação
 */
function carregarTurmas() {
    $.get('/api/turmas?per_page=1000', function(data) {
        let options = '<option value="">Selecione uma turma...</option>';
        if (data.data && data.data.length > 0) {
            data.data.forEach(function(turma) {
                options += `<option value="${turma.id}">${turma.curso.nome} - ${turma.periodo}</option>`;
            });
        }
        $('#criarTurmaId').html(options);
    });
}

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
 * Salva uma nova pré-inscrição
 */
function salvarPreInscricao() {
    const form = document.getElementById('formCriarPreInscricao');
    const formData = new FormData(form);
    const data = {
        turma_id: formData.get('turma_id'),
        nome_completo: formData.get('nome_completo'),
        email: formData.get('email'),
        status: formData.get('status'),
        observacoes: formData.get('observacoes'),
        contactos: [formData.get('contactos[]')].filter(c => c)
    };

    // Validação
    if (!data.turma_id) {
        Swal.fire('Aviso', 'Selecione uma turma', 'warning');
        return;
    }
    if (!data.nome_completo) {
        Swal.fire('Aviso', 'Insira o nome completo', 'warning');
        return;
    }

    $.ajax({
        url: '/api/pre-inscricoes',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            Swal.fire('Sucesso!', 'Pré-inscrição criada com sucesso', 'success');
            document.getElementById('formCriarPreInscricao').reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalNovaPreInscricao'));
            modal.hide();
            // Recarregar página após um pequeno delay
            setTimeout(() => location.reload(), 1000);
        },
        error: function(xhr, status, error) {
            console.error('Erro ao criar pré-inscrição:', error);
            const mensagem = xhr.responseJSON?.message || 'Erro ao criar a pré-inscrição.';
            Swal.fire('Erro', mensagem, 'error');
        }
    });
}

/**
 * Visualiza os detalhes de uma pré-inscrição específica
 * @param {number} id - ID da pré-inscrição
 */
function visualizarPreInscricao(id) {
    const modal = new bootstrap.Modal(document.getElementById('viewModal'));
    modal.show();

    $.ajax({
        url: `/API/pre-inscricoes/${id}`,
        method: 'GET',
        success: function(response) {
            // Montar conteúdo HTML
            let html = `
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold text-muted small">Nome Completo</label>
                        <p class="mb-0">${response.nome_completo}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold text-muted small">Email</label>
                        <p class="mb-0">${response.email || '—'}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold text-muted small">Turma</label>
                        <p class="mb-0">${response.turma?.curso?.nome || 'Sem turma'}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold text-muted small">Status</label>
                        <p class="mb-0">${getStatusBadge(response.status)}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold text-muted small">Período</label>
                        <p class="mb-0">${response.turma?.periodo || '—'}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold text-muted small">Data de Arranque</label>
                        <p class="mb-0">${response.turma?.data_arranque ? new Date(response.turma.data_arranque).toLocaleDateString() : '—'}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="fw-semibold text-muted small">Observações</label>
                        <p class="mb-0">${response.observacoes || 'Sem observações'}</p>
                    </div>
                </div>
            `;
            document.getElementById('viewModalContent').innerHTML = html;
        },
        error: function(xhr, status, error) {
            console.error('Erro ao carregar pré-inscrição:', error);
            document.getElementById('viewModalContent').innerHTML = '<p class="text-danger">Erro ao carregar os detalhes da pré-inscrição.</p>';
        }
    });
}

/**
 * Confirma uma pré-inscrição (muda status para confirmado)
 * @param {number} id - ID da pré-inscrição
 */
function confirmarPreInscricao(id) {
    Swal.fire({
        title: 'Confirmar Pré-Inscrição',
        text: 'Tem certeza que deseja confirmar esta pré-inscrição?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            atualizarStatusPreInscricao(id, 'confirmado');
        }
    });
}

/**
 * Cancela uma pré-inscrição (muda status para cancelado)
 * @param {number} id - ID da pré-inscrição
 */
function cancelarPreInscricao(id) {
    Swal.fire({
        title: 'Cancelar Pré-Inscrição',
        text: 'Tem certeza que deseja cancelar esta pré-inscrição?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, cancelar',
        cancelButtonText: 'Não, voltar'
    }).then((result) => {
        if (result.isConfirmed) {
            atualizarStatusPreInscricao(id, 'cancelado');
        }
    });
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
            const statusText = status === 'confirmado' ? 'confirmada' : 'cancelada';
            Swal.fire('Sucesso!', `Pré-inscrição ${statusText} com sucesso`, 'success');
            // Recarregar página após um pequeno delay
            setTimeout(() => location.reload(), 1000);
        },
        error: function(xhr, status, error) {
            console.error('Erro ao atualizar status:', error);
            const errorMsg = xhr.responseJSON?.message || 'Erro ao atualizar o status da pré-inscrição.';
            Swal.fire('Erro', errorMsg, 'error');
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

/**
 * Retorna o badge HTML para o status
 * @param {string} status - Status da pré-inscrição
 */
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
