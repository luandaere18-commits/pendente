@extends('layouts.app')

@section('title', 'Centros')

@section('content')

{{-- ============================================= --}}
{{-- HEADER                                        --}}
{{-- ============================================= --}}
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col-12 col-md-8 mb-2 mb-md-0">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <i class="fas fa-building text-success fa-lg"></i>
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-0">Gestão de Centros</h1>
                    <p class="text-muted mb-0 small">Gerir todos os centros de formação do sistema</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modalNovoCentro">
                <i class="fas fa-plus me-2"></i>Novo Centro
            </button>
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="filtroNome" class="form-label small fw-semibold">Nome do Centro</label>
                    <input type="text" class="form-control form-control-sm" id="filtroNome" value="{{ $filtroNome ?? '' }}" onchange="aplicarFiltros()" placeholder="Filtrar por nome...">
                </div>
                <div class="col-md-4">
                    <label for="filtroLocalizacao" class="form-label small fw-semibold">Localização</label>
                    <input type="text" class="form-control form-control-sm" id="filtroLocalizacao" value="{{ $filtroLocalizacao ?? '' }}" onchange="aplicarFiltros()" placeholder="Filtrar por localização...">
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="limparFiltros()">
                        <i class="fas fa-redo me-1"></i>Limpar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- TABELA DE CENTROS                             --}}
    {{-- ============================================= --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-list text-success"></i>
                <h5 class="mb-0 fw-semibold">Lista de Centros</h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="centrosTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="width:60px">ID</th>
                            <th>Nome</th>
                            <th style="width:200px">Localização</th>
                            <th>Contacto(s)</th>
                            <th style="width:150px">Email</th>
                            <th style="width:120px" class="text-end pe-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($centros as $centro)
                            <tr>
                                <td class="ps-3"><small class="text-muted">#{{ $centro->id }}</small></td>
                                <td><strong>{{ $centro->nome }}</strong></td>
                                <td><small>{{ $centro->localizacao ?? '—' }}</small></td>
                                <td>
                                    @if($centro->contactos && is_array($centro->contactos))
                                        @foreach($centro->contactos as $contacto)
                                            <small class="d-block">{{ $contacto }}</small>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td><small>{{ $centro->email ?? '—' }}</small></td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-info btn-visualizar-centro" onclick="visualizarCentro({{ $centro->id }})" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-editar-centro" 
                                                data-centro-id="{{ $centro->id }}"
                                                data-centro-nome="{{ $centro->nome }}"
                                                data-localizacao="{{ $centro->localizacao }}"
                                                data-email="{{ $centro->email }}"
                                                onclick="editarCentro({{ $centro->id }})" 
                                                title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-eliminar-centro" onclick="eliminarCentro({{ $centro->id }})" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="mb-2"><i class="fas fa-inbox fa-2x text-muted"></i></div>
                                    Nenhum centro cadastrado
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Visualizar Detalhes do Centro          --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalVisualizarCentro" tabindex="-1" aria-labelledby="modalVisualizarCentroLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-3">
            <div class="modal-header bg-success text-white sticky-top">
                <h5 class="modal-title" id="modalVisualizarCentroLabel">
                    <i class="fas fa-building me-2"></i>Detalhes do Centro
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-4" id="conteudoVisualizarCentro">
                <div class="text-center">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Criar Novo Centro                      --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalNovoCentro" tabindex="-1" aria-labelledby="modalNovoCentroLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-3">

            {{-- Header --}}
            <div class="modal-header bg-success bg-opacity-10 border-0 py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-plus text-white small"></i>
                    </div>
                    <h5 class="modal-title fw-bold mb-0" id="modalNovoCentroLabel">Criar Novo Centro</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formNovoCentroAjax">
                    @csrf
                    <div class="row g-4">

                        {{-- ====== COLUNA ESQUERDA ====== --}}
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100">
                                <div class="card-header bg-light border-bottom py-2 px-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-info-circle text-success me-2"></i>Informações Gerais
                                    </h6>
                                </div>
                                <div class="card-body d-flex flex-column gap-3 p-3">

                                    {{-- Nome --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Nome <span class="text-danger">*</span></label>
                                        <input type="text" name="nome" class="form-control form-control-sm" placeholder="Ex: Centro de Lisboa" required>
                                    </div>

                                    {{-- Localização --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Localização <span class="text-danger">*</span></label>
                                        <input type="text" name="localizacao" class="form-control form-control-sm" placeholder="Ex: Avenida Principal, 123" required>
                                    </div>


                                </div>
                            </div>
                        </div>

                        {{-- ====== COLUNA DIREITA ====== --}}
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100">
                                <div class="card-header bg-light border-bottom py-2 px-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-phone text-success me-2"></i>Contacto
                                    </h6>
                                </div>
                                <div class="card-body d-flex flex-column gap-3 p-3">

                                    {{-- Contacto(s) --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Contacto(s) - Telefones <span class="text-danger">*</span></label>
                                        <input type="text" name="contactos_novo" class="form-control form-control-sm" placeholder="Ex: 923111111, 924222222" required>
                                        <small class="text-muted d-block mt-1">Separe múltiplos telefones por vírgula</small>
                                    </div>

                                    {{-- Email --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Email</label>
                                        <input type="email" name="email" class="form-control form-control-sm" placeholder="Ex: centro@email.com">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 bg-light px-4 py-3">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="submit" form="formNovoCentroAjax" class="btn btn-success px-4">
                    <i class="fas fa-save me-1"></i>Criar Centro
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Editar Centro                          --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalEditarCentro" tabindex="-1" aria-labelledby="modalEditarCentroLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-3">

            {{-- Header --}}
            <div class="modal-header bg-success bg-opacity-10 border-0 py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-edit text-white small"></i>
                    </div>
                    <h5 class="modal-title fw-bold mb-0" id="modalEditarCentroLabel">Editar Centro</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formEditarCentroAjax">
                    @csrf
                    <input type="hidden" name="centro_id" id="editCentroId" >
                    
                    <div class="row g-4">

                        {{-- ====== COLUNA ESQUERDA ====== --}}
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100">
                                <div class="card-header bg-light border-bottom py-2 px-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-info-circle text-success me-2"></i>Informações Gerais
                                    </h6>
                                </div>
                                <div class="card-body d-flex flex-column gap-3 p-3">

                                    {{-- Nome --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Nome <span class="text-danger">*</span></label>
                                        <input type="text" id="editNome" class="form-control form-control-sm" placeholder="Ex: Centro de Lisboa" required>
                                    </div>

                                    {{-- Localização --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Localização <span class="text-danger">*</span></label>
                                        <input type="text" id="editLocalizacao" class="form-control form-control-sm" placeholder="Ex: Avenida Principal, 123" required>
                                    </div>


                                </div>
                            </div>
                        </div>

                        {{-- ====== COLUNA DIREITA ====== --}}
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100">
                                <div class="card-header bg-light border-bottom py-2 px-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-phone text-success me-2"></i>Contacto
                                    </h6>
                                </div>
                                <div class="card-body d-flex flex-column gap-3 p-3">

                                    {{-- Contacto(s) --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Contacto(s) - Telefones <span class="text-danger">*</span></label>
                                        <input type="text" id="editContactos" class="form-control form-control-sm" placeholder="Ex: 923111111, 924222222" required>
                                        <small class="text-muted d-block mt-1">Separe múltiplos telefones por vírgula</small>
                                    </div>

                                    {{-- Email --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Email</label>
                                        <input type="email" id="editEmail" class="form-control form-control-sm" placeholder="Ex: centro@email.com">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 bg-light px-4 py-3">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="submit" form="formEditarCentroAjax" class="btn btn-success px-4">
                    <i class="fas fa-save me-1"></i>Guardar Alterações
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    configurarEventos();
});

/**
 * Recarregar página para atualizar lista de centros
 */
function carregarCentros() {
    location.reload();
}

/**
 * Aplicar filtros à tabela
 */
function aplicarFiltros() {
    const nome = $('#filtroNome').val() || '';
    const localizacao = $('#filtroLocalizacao').val() || '';
    
    let url = '/centros?';
    if (nome) url += `nome=${encodeURIComponent(nome)}&`;
    if (localizacao) url += `localizacao=${encodeURIComponent(localizacao)}`;
    
    window.location.href = url;
}

/**
 * Limpar todos os filtros
 */
function limparFiltros() {
    $('#filtroNome').val('');
    $('#filtroLocalizacao').val('');
    window.location.href = '/centros';
}

/**
 * Configurar eventos dos botões
 */
function configurarEventos() {
    // Modal de criar - resetar form
    $('#modalNovoCentro').on('show.bs.modal', function() {
        $('#formNovoCentroAjax')[0].reset();
    });

    // Visualizar Centro
    $(document).on('click', '.btn-visualizar', function(e) {
        e.preventDefault();
        const centroId = $(this).data('centro-id');
        visualizarCentro(centroId);
    });

    // Editar Centro
    $(document).on('click', '.btn-editar', function(e) {
        e.preventDefault();
        const centroId = $(this).data('centro-id');
        abrirEdicaoCentro(centroId);
    });

    // Eliminar Centro
    $(document).on('click', '.btn-eliminar', function(e) {
        e.preventDefault();
        const centroId = $(this).data('centro-id');
        eliminarCentro(centroId);
    });

    // Submeter form de criar
    $('#formNovoCentroAjax').on('submit', function(e) {
        e.preventDefault();
        criarCentro();
    });

    // Submeter form de editar
    $('#formEditarCentroAjax').on('submit', function(e) {
        e.preventDefault();
        atualizarCentro();
    });
}

/**
 * Visualizar detalhes do centro
 */
function visualizarCentro(centroId) {
    $.ajax({
        url: `/api/centros/${centroId}`,
        method: 'GET',
        success: function(response) {
            const centro = response.dados || response;
            
            const statusBadge = centro.ativo 
                ? '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Ativo</span>'
                : '<span class="badge bg-secondary"><i class="fas fa-times-circle me-1"></i>Inativo</span>';
            
            let conteudo = `
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-building me-2 text-success"></i>Nome:</strong><br>
                            <span class="fs-5">${centro.nome}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-map-marker-alt me-2 text-success"></i>Localização:</strong><br>
                            <span>${centro.localizacao || 'N/A'}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-phone me-2 text-success"></i>Contacto(s):</strong><br>
                            ${(centro.contactos && centro.contactos.length > 0) ? centro.contactos.map(c => `<span class="badge bg-light text-dark">${c}</span>`).join(' ') : '<span class="text-muted">N/A</span>'}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="fas fa-envelope me-2 text-success"></i>Email:</strong><br>
                            <span>${centro.email || 'N/A'}</span>
                        </p>
                    </div>
                </div>
            `;
            
            $('#conteudoVisualizarCentro').html(conteudo);
            new bootstrap.Modal(document.getElementById('modalVisualizarCentro')).show();
        },
        error: function() {
            Swal.fire('Erro', 'Erro ao carregar detalhes do centro', 'error');
        }
    });
}

/**
 * Abrir modal de edição
 */
function abrirEdicaoCentro(centroId) {
    $.ajax({
        url: `/api/centros/${centroId}`,
        method: 'GET',
        success: function(response) {
            const centro = response.dados || response;
            
            $('#editCentroId').val(centro.id);
            $('#editNome').val(centro.nome);
            $('#editLocalizacao').val(centro.localizacao || '');
            $('#editContactos').val((centro.contactos && centro.contactos.length > 0) ? centro.contactos.join(', ') : '');
            $('#editEmail').val(centro.email || '');
            
            new bootstrap.Modal(document.getElementById('modalEditarCentro')).show();
        },
        error: function() {
            Swal.fire('Erro', 'Erro ao carregar dados do centro', 'error');
        }
    });
}

/**
 * Criar novo centro
 */
function criarCentro() {
    const contactosInput = $('[name="contactos_novo"]').val().trim();
    const contactosArray = contactosInput.split(',').map(c => c.trim()).filter(c => c.length > 0);
    
    if (contactosArray.length === 0) {
        Swal.fire('Aviso', 'Adicione pelo menos um contacto', 'warning');
        return;
    }
    
    const dados = {
        nome: $('[name="nome"]').val(),
        localizacao: $('[name="localizacao"]').val(),
        contactos: contactosArray,
        email: $('[name="email"]').val()
    };
    
    $.ajax({
        url: '/api/centros',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(dados),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() {
            Swal.fire('Sucesso!', 'Centro criado com sucesso', 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalNovoCentro')).hide();
            $('#formNovoCentroAjax')[0].reset();
            carregarCentros();
        },
        error: function(xhr) {
            const errors = xhr.responseJSON?.errors || {};
            let mensagem = 'Erro ao criar centro';
            if (Object.keys(errors).length > 0) {
                mensagem = Object.values(errors).flat().join(', ');
            }
            Swal.fire('Erro', mensagem, 'error');
        }
    });
}

/**
 * Atualizar centro
 */
function atualizarCentro() {
    const centroId = $('#editCentroId').val();
    const contactosInput = $('#editContactos').val().trim();
    const contactosArray = contactosInput.split(',').map(c => c.trim()).filter(c => c.length > 0);
    
    if (contactosArray.length === 0) {
        Swal.fire('Aviso', 'Adicione pelo menos um contacto', 'warning');
        return;
    }
    
    const dados = {
        nome: $('#editNome').val(),
        localizacao: $('#editLocalizacao').val(),
        contactos: contactosArray,
        email: $('#editEmail').val()
    };
    
    $.ajax({
        url: `/api/centros/${centroId}`,
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(dados),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() {
            Swal.fire('Sucesso!', 'Centro atualizado com sucesso', 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalEditarCentro')).hide();
            carregarCentros();
        },
        error: function(xhr) {
            const errors = xhr.responseJSON?.errors || {};
            let mensagem = 'Erro ao atualizar centro';
            if (Object.keys(errors).length > 0) {
                mensagem = Object.values(errors).flat().join(', ');
            }
            Swal.fire('Erro', mensagem, 'error');
        }
    });
}

/**
 * Eliminar centro
 */
function eliminarCentro(centroId) {
    Swal.fire({
        title: 'Confirmar Eliminação',
        text: 'Tem a certeza que deseja eliminar este centro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/centros/${centroId}`,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function() {
                    Swal.fire('Eliminado!', 'Centro eliminado com sucesso', 'success');
                    carregarCentros();
                },
                error: function() {
                    Swal.fire('Erro', 'Erro ao eliminar centro', 'error');
                }
            });
        }
    });
}
</script>
@endsection
