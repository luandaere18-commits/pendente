@extends('layouts.app')

@section('title', 'Formadores')

@section('content')

{{-- ============================================= --}}
{{-- HEADER                                        --}}
{{-- ============================================= --}}
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col-12 col-md-8 mb-3 mb-md-0">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                    <i class="fas fa-chalkboard-teacher text-primary fa-lg"></i>
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-0">Gestão de Formadores</h1>
                    <p class="text-muted mb-0 small">Gerir todos os formadores disponíveis no sistema</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovoFormador">
                <i class="fas fa-plus me-2"></i>Novo Formador
            </button>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- FILTROS                                       --}}
    {{-- ============================================= --}}
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="filtroNome" class="form-label small fw-semibold text-muted">Nome</label>
                    <input type="text" id="filtroNome" class="form-control form-control-sm" 
                           placeholder="Pesquisar por nome..." value="{{ $filtroNome ?? '' }}"
                           onchange="aplicarFiltros()">
                </div>
                <div class="col-12 col-md-6">
                    <label for="filtroEspecialidade" class="form-label small fw-semibold text-muted">Especialidade</label>
                    <input type="text" id="filtroEspecialidade" class="form-control form-control-sm" 
                           placeholder="Pesquisar por especialidade..." value="{{ $filtroEspecialidade ?? '' }}"
                           onchange="aplicarFiltros()">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="limparFiltros()">
                        <i class="fas fa-undo me-1"></i>Limpar Filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- TABELA DE FORMADORES                          --}}
    {{-- ============================================= --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-list text-primary"></i>
                <h5 class="mb-0 fw-semibold">Lista de Formadores</h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="formadoresTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="width:60px">ID</th>
                            <th>Nome</th>
                            <th class="d-none d-md-table-cell">Email</th>
                            <th class="d-none d-lg-table-cell">Especialidade</th>
                            <th class="text-center" style="width:90px">Cursos</th>
                            <th class="text-center" style="width:90px">Contactos</th>
                            <th class="text-end pe-3" style="width:130px">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formadores as $formador)
                            <tr>
                                <td class="ps-3"><small class="text-muted">#{{ $formador->id }}</small></td>
                                <td><strong>{{ $formador->nome }}</strong></td>
                                <td class="d-none d-md-table-cell"><small>{{ $formador->email ?? '—' }}</small></td>
                                <td class="d-none d-lg-table-cell"><small>{{ $formador->especialidade ?? '—' }}</small></td>
                                <td class="text-center">
                                    @php
                                        // Contar cursos únicos através das turmas
                                        $cursosCount = $formador->turmas->pluck('curso_id')->unique()->count();
                                    @endphp
                                    <span class="badge bg-info-subtle text-info">{{ $cursosCount }}</span>
                                </td>
                                <td class="text-center">
                                    @if($formador->contactos && is_array($formador->contactos))
                                        @php
                                            $totalContactos = count($formador->contactos);
                                        @endphp
                                        
                                        @if($totalContactos > 0)
                                            <span class="badge bg-success-subtle text-success">{{ $totalContactos }}</span>
                                            
                                            {{-- Tooltip com os números --}}
                                            <i class="fas fa-info-circle text-muted ms-1" 
                                               data-bs-toggle="tooltip" 
                                               title="{{ implode(', ', $formador->contactos) }}" 
                                               style="cursor: help;"></i>
                                        @else
                                            <span class="badge bg-secondary">0</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-info btn-visualizar-formador" data-formador-id="{{ $formador->id }}" title="Ver detalhes">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-editar-formador" data-formador-id="{{ $formador->id }}" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-eliminar-formador" data-formador-id="{{ $formador->id }}" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div class="mb-2"><i class="fas fa-inbox fa-2x text-muted"></i></div>
                                    Nenhum formador cadastrado
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
{{-- MODAL: Visualizar Detalhes do Formador       --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalVisualizarFormador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-user-tie text-primary"></i>
                    <h5 class="modal-title fw-semibold mb-0">Detalhes do Formador</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="conteudoVisualizarFormador">
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

{{-- ============================================= --}}
{{-- MODAL: Criar Novo Formador                   --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalNovoFormador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            {{-- Header --}}
            <div class="modal-header bg-light border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-user-plus text-primary"></i>
                    </div>
                    <h5 class="modal-title fw-semibold mb-0">Criar Novo Formador</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formNovoFormadorAjax" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">

                        {{-- COLUNA ESQUERDA --}}
                        <div class="col-12 col-md-6">
                            <div class="card border bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-id-card me-2"></i>Informações do Formador
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Nome <span class="text-danger">*</span></label>
                                        <input type="text" name="nome" class="form-control form-control-sm" placeholder="Nome completo" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Email</label>
                                        <input type="email" name="email" class="form-control form-control-sm" placeholder="email@centro.ao">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Especialidade</label>
                                        <input type="text" name="especialidade" class="form-control form-control-sm" placeholder="Ex: Informática, Design...">
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">
                                            <i class="fas fa-camera me-1 text-muted"></i>Foto
                                        </label>
                                        <input type="file" name="foto" class="form-control form-control-sm" accept="image/*">
                                        <div class="form-text small">JPEG, PNG, JPG, GIF (máx 2 MB)</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- COLUNA DIREITA --}}
                        <div class="col-12 col-md-6">
                            <div class="card border bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-address-book me-2"></i>Contactos
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">
                                            <i class="fas fa-phone me-1 text-muted"></i>Contacto
                                        </label>
                                        <input type="text" name="contacto_telefone" class="form-control form-control-sm" placeholder="+244 900 000 000">
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">Biografia</label>
                                        <textarea name="bio" class="form-control form-control-sm" rows="7" placeholder="Breve descrição profissional..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ====== SEÇÃO DE CENTROS ====== --}}
                    <div class="mt-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-semibold mb-0">
                                <i class="fas fa-building text-primary me-2"></i>Centros de Formação
                            </h6>
                            <button type="button" id="adicionarCentroNovoFormadorBtn" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Adicionar Centro
                            </button>
                        </div>
                        <div id="centrosContainerNovoFormador" class="row g-3">
                            {{-- centros dinâmicos aqui --}}
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="submit" form="formNovoFormadorAjax" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Salvar Formador
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Editar Formador                       --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalEditarFormador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            {{-- Header --}}
            <div class="modal-header bg-light border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-2 bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-user-edit text-warning"></i>
                    </div>
                    <h5 class="modal-title fw-semibold mb-0">Editar Formador</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formEditarFormadorAjax">
                    @csrf
                    <input type="hidden" id="editFormadorId">
                    <div class="row g-4">

                        {{-- COLUNA ESQUERDA --}}
                        <div class="col-12 col-md-6">
                            <div class="card border bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-id-card me-2"></i>Informações do Formador
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Nome <span class="text-danger">*</span></label>
                                        <input type="text" id="editNome" class="form-control form-control-sm" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Email</label>
                                        <input type="email" id="editEmail" class="form-control form-control-sm">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Especialidade</label>
                                        <input type="text" id="editEspecialidade" class="form-control form-control-sm">
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">
                                            <i class="fas fa-camera me-1 text-muted"></i>Foto (Nova)
                                        </label>
                                        <input type="file" id="editFoto" name="foto" class="form-control form-control-sm" accept="image/*">
                                        <div class="form-text small">Deixe em branco para manter a foto atual</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- COLUNA DIREITA --}}
                        <div class="col-12 col-md-6">
                            <div class="card border bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-address-book me-2"></i>Contactos
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">
                                            <i class="fas fa-phone me-1 text-muted"></i>Contacto
                                        </label>
                                        <input type="text" id="editContactoTelefone" class="form-control form-control-sm" placeholder="+244 900 000 000">
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">Biografia</label>
                                        <textarea id="editBio" class="form-control form-control-sm" rows="7"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ====== SEÇÃO DE CENTROS ====== --}}
                    <div class="mt-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-semibold mb-0">
                                <i class="fas fa-building text-primary me-2"></i>Centros de Formação
                            </h6>
                            <button type="button" id="adicionarCentroEditarFormadorBtn" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Adicionar Centro
                            </button>
                        </div>
                        <div id="centrosContainerEditarFormador" class="row g-3">
                            {{-- centros dinâmicos aqui --}}
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="submit" form="formEditarFormadorAjax" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Guardar Alterações
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

{{-- ============================================= --}}
{{-- Template para Centro no Modal                 --}}
{{-- ============================================= --}}
<template id="centroFormadorTemplate">
    <div class="col-12 col-md-6">
        <div class="centro-card card border rounded-3 shadow-sm">
            <div class="card-header bg-light d-flex align-items-center justify-content-between py-2 px-3">
                <span class="badge bg-primary numero-centro-modal">Centro 1</span>
                <button type="button" class="btn btn-outline-danger btn-sm remover-centro-modal py-0 px-2" title="Remover">
                    <i class="fas fa-trash-alt small"></i>
                </button>
            </div>
            <div class="card-body p-3">
                <div>
                    <label class="form-label small mb-1 fw-medium">Centro <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm centro-id-modal" required>
                        <option value="">Selecione</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>

@section('scripts')
<script>
let centrosDisponiveisList = [];
let centrosContainerNovoFormadorCount = 0;
let centrosContainerEditarFormadorCount = 0;

$(document).ready(function() {
    carregarCentros();
    configurarEventosModal();
});

/**
 * Carregar lista de centros disponíveis
 */
function carregarCentros() {
    $.ajax({
        url: '/centros',
        method: 'GET',
        success: function(data) {
            centrosDisponiveisList = data;
        },
        error: function(err) {
            console.error('Erro ao carregar centros:', err);
        }
    });
}

/**
 * Configurar eventos do modal
 */
function configurarEventosModal() {
    $('#modalNovoFormador').on('show.bs.modal', function() {
        $('#formNovoFormadorAjax')[0].reset();
        $('#centrosContainerNovoFormador').empty();
        centrosContainerNovoFormadorCount = 0;
        adicionarCentroNovoFormador();
    });

    $('#modalEditarFormador').on('show.bs.modal', function() {
        $('#centrosContainerEditarFormador').empty();
        centrosContainerEditarFormadorCount = 0;
    });

    $(document).on('click', '#adicionarCentroNovoFormadorBtn', function(e) {
        e.preventDefault();
        adicionarCentroNovoFormador();
    });

    $(document).on('click', '#adicionarCentroEditarFormadorBtn', function(e) {
        e.preventDefault();
        adicionarCentroEditarFormador();
    });

    $(document).on('click', '.remover-centro-modal', function(e) {
        e.preventDefault();
        $(this).closest('.col-12').remove();
        atualizarNumeroCentros();
    });

    // Delegated actions on table buttons
    $(document).on('click', '.btn-visualizar-formador', function() {
        const id = $(this).data('formador-id');
        if (id) {
            visualizarFormador(id);
        }
    });

    $(document).on('click', '.btn-editar-formador', function() {
        const id = $(this).data('formador-id');
        if (id) {
            abrirEdicaoFormador(id);
        }
    });

    $(document).on('click', '.btn-eliminar-formador', function() {
        const id = $(this).data('formador-id');
        if (id) {
            eliminarFormador(id);
        }
    });

    // Ativar tooltips do Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
}

/**
 * Adicionar centro no modal de novo formador
 */
function adicionarCentroNovoFormador() {
    const template = document.getElementById('centroFormadorTemplate');
    if (!template) return;

    const clone = template.content.cloneNode(true);
    const wrapper = document.createElement('div');
    wrapper.appendChild(clone);

    const html = wrapper.innerHTML;
    $('#centrosContainerNovoFormador').append(html);

    const selects = $('#centrosContainerNovoFormador').find('.centro-id-modal');
    const lastSelect = selects.last();

    centrosDisponiveisList.forEach(centro => {
        lastSelect.append(`<option value="${centro.id}">${centro.nome}</option>`);
    });

    // Desabilitar centros já selecionados
    lastSelect.on('change', function() {
        atualizarSelectsDeCentros();
    });

    atualizarSelectsDeCentros();
    atualizarNumeroCentros();
}

/**
 * Adicionar centro no modal de editar formador
 */
function adicionarCentroEditarFormador(centrosAssociados = []) {
    const template = document.getElementById('centroFormadorTemplate');
    if (!template) return;

    const clone = template.content.cloneNode(true);
    const wrapper = document.createElement('div');
    wrapper.appendChild(clone);

    const html = wrapper.innerHTML;
    $('#centrosContainerEditarFormador').append(html);

    const selects = $('#centrosContainerEditarFormador').find('.centro-id-modal');
    const lastSelect = selects.last();

    // Preencher opções de centros disponíveis
    centrosDisponiveisList.forEach(centro => {
        lastSelect.append(`<option value="${centro.id}">${centro.nome}</option>`);
    });

    // Ao mudar este select, atualizar visibilidade de todos os dropdowns
    lastSelect.on('change', function() {
        atualizarSelectsDeCentrosEditar();
    });

    // Atualizar visibilidade e numeração
    atualizarSelectsDeCentrosEditar();
    atualizarNumeroCentros();
}

/**
 * Atualizar numeração dos centros
 */
function atualizarNumeroCentros() {
    const badges = $('.numero-centro-modal');
    badges.each((index, badge) => {
        $(badge).text('Centro ' + (index + 1));
    });

    const btnsRemover = $('.remover-centro-modal');
    btnsRemover.prop('disabled', btnsRemover.length <= 1);
}

/**
 * Atualizar status de centros (ocultar duplicados)
 */
function atualizarSelectsDeCentros() {
    const selects = $('select.centro-id-modal:not(#centrosContainerEditarFormador select)');
    const allSelectedIds = [];
    
    // Coletar todos os valores selecionados nos dropdowns de NOVO formador
    selects.each(function() {
        const val = $(this).val();
        if (val) {
            allSelectedIds.push(val);
        }
    });
    
    // Para cada dropdown, esconder opções que já estão selecionadas em outro
    selects.each(function() {
        const select = $(this);
        const selectedInThis = select.val();
        
        select.find('option').each(function() {
            const optionId = $(this).val();
            
            if (optionId === '') {
                // Opção vazia sempre visível
                $(this).prop('hidden', false);
            } else if (optionId === selectedInThis) {
                // Opção atualmente selecionada sempre visível
                $(this).prop('hidden', false);
            } else if (allSelectedIds.includes(optionId)) {
                // Se está selecionado em outro dropdown, esconder
                $(this).prop('hidden', true);
            } else {
                // Caso contrário, mostrar
                $(this).prop('hidden', false);
            }
        });
    });
}

/**
 * Atualizar dropdowns de centros no modal de editar formador
 * Oculta centros que já estão selecionados em outro dropdown
 */
function atualizarSelectsDeCentrosEditar() {
    const selectsEditar = $('#centrosContainerEditarFormador').find('.centro-id-modal');
    const allSelectedIds = [];
    
    // Coletar todos os valores atualmente selecionados
    selectsEditar.each(function() {
        const val = $(this).val();
        if (val) {
            allSelectedIds.push(val);
        }
    });
    
    // Para cada dropdown, atualizar visibilidade das opções
    selectsEditar.each(function() {
        const select = $(this);
        const selectedInThis = select.val();
        
        select.find('option').each(function() {
            const optionId = $(this).val();
            
            if (optionId === '') {
                // Opção vazia sempre visível
                $(this).prop('hidden', false);
            } else if (optionId === selectedInThis) {
                // Opção atualmente selecionada sempre visível
                $(this).prop('hidden', false);
            } else if (allSelectedIds.includes(optionId)) {
                // Se está selecionado em outro dropdown, esconder
                $(this).prop('hidden', true);
            } else {
                // Caso contrário, mostrar
                $(this).prop('hidden', false);
            }
        });
    });
}

/**
 * Carrega a lista de formadores via API
 */
/**
 * Visualizar detalhes do formador
 */
window.visualizarFormador = function(id) {
    $.ajax({
        url: `/formadores/${id}`,
        method: 'GET',
        success: function(response) {
            const formador = response.data || response;
            let contactosHtml = '<span class="text-muted">Sem contactos</span>';
            
            if (formador.contactos && Array.isArray(formador.contactos) && formador.contactos.length > 0) {
                contactosHtml = formador.contactos.map(function(c) { 
                    let telefone = typeof c === 'string' ? c : (c.valor || c);
                    return `<span class="badge bg-info-subtle text-info me-1"><i class="fas fa-phone me-1"></i>${telefone}</span>`;
                }).join('');
            }
            
            let centrosHtml = '<span class="text-muted">Nenhum centro associado</span>';
            if (formador.centros && Array.isArray(formador.centros) && formador.centros.length > 0) {
                centrosHtml = formador.centros.map(function(c) {
                    return `<span class="badge bg-primary-subtle text-primary me-1"><i class="fas fa-building me-1"></i>${c.nome}</span>`;
                }).join('');
            }
            
            const fotoHtml = formador.foto_url
                ? `<img src="${formador.foto_url}" class="rounded-3 shadow-sm" style="width:100%;max-width:180px;aspect-ratio:1;object-fit:cover;" alt="${formador.nome}">`
                : '<div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto" style="width:180px;height:180px;"><i class="fas fa-user text-primary fa-4x"></i></div>';
            
            const conteudo = `
                <div class="row g-4">
                    <div class="col-12 col-md-4 text-center">${fotoHtml}</div>
                    <div class="col-12 col-md-8">
                        <h5 class="fw-bold mb-3">${formador.nome}</h5>
                        <div class="row g-3">
                            <div class="col-12"><small class="text-muted d-block fw-medium"><i class="fas fa-envelope me-1"></i>Email</small><small>${formador.email || '—'}</small></div>
                            <div class="col-12"><small class="text-muted d-block fw-medium"><i class="fas fa-star me-1"></i>Especialidade</small><small>${formador.especialidade || '—'}</small></div>
                            <div class="col-12"><small class="text-muted d-block fw-medium mb-1"><i class="fas fa-phone me-1"></i>Contactos</small>${contactosHtml}</div>
                            <div class="col-12"><small class="text-muted d-block fw-medium mb-1"><i class="fas fa-building me-1"></i>Centros</small>${centrosHtml}</div>
                            <div class="col-12"><small class="text-muted d-block fw-medium"><i class="fas fa-align-left me-1"></i>Biografia</small><small>${formador.bio || '—'}</small></div>
                        </div>
                    </div>
                </div>
            `;
            
            $('#conteudoVisualizarFormador').html(conteudo);
            new bootstrap.Modal(document.getElementById('modalVisualizarFormador')).show();
        },
        error: function() {
            Swal.fire('Erro', 'Erro ao carregar detalhes', 'error');
        }
    });
};

/**
 * Abrir modal para editar formador
 */
window.abrirEdicaoFormador = function(id) {
    $.ajax({
        url: `/formadores/${id}`,
        method: 'GET',
        success: function(response) {
            const formador = response.data || response;
            $('#editFormadorId').val(formador.id);
            $('#editNome').val(formador.nome);
            $('#editEmail').val(formador.email || '');
            $('#editEspecialidade').val(formador.especialidade || '');
            $('#editBio').val(formador.bio || '');
            
            let primeroContacto = '';
            if (formador.contactos && Array.isArray(formador.contactos) && formador.contactos.length > 0) {
                primeroContacto = typeof formador.contactos[0] === 'string' ? formador.contactos[0] : (formador.contactos[0].valor || '');
            }
            $('#editContactoTelefone').val(primeroContacto);
            
            // Coletar IDs de centros já associados a este formador
            const centrosAssociados = [];
            if (formador.centros && formador.centros.length > 0) {
                formador.centros.forEach(function(centro) {
                    centrosAssociados.push(centro.id);
                });
            }
            
            // Limpar container
            $('#centrosContainerEditarFormador').empty();
            centrosContainerEditarFormadorCount = 0;
            
            // Aguardar para renderizar os centros
            setTimeout(function() {
                if (centrosAssociados && centrosAssociados.length > 0) {
                    // Adicionar dropdowns para CADA centro associado
                    centrosAssociados.forEach(function(centroId) {
                        adicionarCentroEditarFormador();
                    });
                    
                    // Após todos serem adicionados, selecionar os valores
                    setTimeout(function() {
                        const selects = $('#centrosContainerEditarFormador').find('.centro-id-modal');
                        selects.each(function(idx) {
                            if (idx < centrosAssociados.length) {
                                $(this).val(centrosAssociados[idx]);
                            }
                        });
                        // Atualizar visibilidade dos dropdowns
                        atualizarSelectsDeCentrosEditar();
                        atualizarNumeroCentros();
                    }, 100);
                } else {
                    // Se não há centros, adicionar um vazio
                    adicionarCentroEditarFormador();
                }
            }, 100);
            
            new bootstrap.Modal(document.getElementById('modalEditarFormador')).show();
        },
        error: function() {
            Swal.fire('Erro', 'Erro ao carregar dados', 'error');
        }
    });
};

/**
 * Criar novo formador
 */
$('#formNovoFormadorAjax').on('submit', function(e) {
    e.preventDefault();
    
    const form = $(this)[0];
    const formData = new FormData(form);

    // Processar contactos como array simples de strings
    const telefone = $('input[name="contacto_telefone"]').val();
    if (telefone && telefone.trim() !== '') {
        formData.append('contactos[0]', telefone.trim());
    }

    // Processar centros
    const centrosArray = [];
    $('#centrosContainerNovoFormador').find('.centro-card').each(function() {
        const centroId = $(this).find('.centro-id-modal').val();
        if (centroId) {
            centrosArray.push(parseInt(centroId));
        }
    });
    
    // Remover centros que possam ter sido adicionados pelo formulário
    const keys = Array.from(formData.keys());
    keys.forEach(key => {
        if (key.startsWith('centros')) {
            formData.delete(key);
        }
    });
    
    // Adicionar centros com indices
    centrosArray.forEach((centroId, index) => {
        formData.append(`centros[${index}]`, centroId);
    });

    // Debug
    console.log('Enviando FormData - Novo Formador:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    $.ajax({
        url: "{{ route('formadores.store') }}",
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(response) {
            Swal.fire('Sucesso!', 'Formador criado com sucesso', 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalNovoFormador')).hide();
            $('#formNovoFormadorAjax')[0].reset();
            location.reload();
        },
        error: function(xhr) {
            console.error('Erro completo:', xhr);
            console.error('Response:', xhr.responseText);
            
            let mensagem = 'Erro ao criar formador';
            if (xhr.responseJSON?.errors) {
                mensagem = Object.values(xhr.responseJSON.errors).flat().join(', ');
            } else if (xhr.responseJSON?.message) {
                mensagem = xhr.responseJSON.message;
            }
            Swal.fire('Erro', mensagem, 'error');
        }
    });
});

/**
 * Editar formador
 */
$('#formEditarFormadorAjax').on('submit', function(e) {
    e.preventDefault();
    
    const formadorId = $('#editFormadorId').val();
    
    // Construir FormData com os dados
    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('nome', $('#editNome').val());
    formData.append('email', $('#editEmail').val());
    formData.append('especialidade', $('#editEspecialidade').val());
    formData.append('bio', $('#editBio').val());
    
    // Adicionar contacto como string simples
    const telefone = $('#editContactoTelefone').val();
    if (telefone && telefone.trim() !== '') {
        formData.append('contactos[0]', telefone.trim());
    }
    
    // Coletar centros selecionados
    const centrosArray = [];
    $('#centrosContainerEditarFormador').find('.centro-card').each(function() {
        const centroId = $(this).find('.centro-id-modal').val();
        if (centroId) {
            centrosArray.push(parseInt(centroId));
        }
    });
    
    // Adicionar centros com indices
    centrosArray.forEach((centroId, index) => {
        formData.append(`centros[${index}]`, centroId);
    });
    
    // Debug
    console.log('Enviando FormData - Editar Formador:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
    
    $.ajax({
        url: `/formadores/${formadorId}`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(response) {
            console.log('Sucesso:', response);
            Swal.fire('Sucesso!', 'Formador atualizado com sucesso', 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalEditarFormador')).hide();
            location.reload();
        },
        error: function(xhr) {
            console.error('Erro completo:', xhr);
            console.error('Response:', xhr.responseText);
            
            let mensagem = 'Erro ao atualizar formador';
            if (xhr.responseJSON?.errors) {
                mensagem = Object.values(xhr.responseJSON.errors).flat().join(', ');
            } else if (xhr.responseJSON?.message) {
                mensagem = xhr.responseJSON.message;
            }
            Swal.fire('Erro', mensagem, 'error');
        }
    });
});

/**
 * Eliminar formador
 */
window.eliminarFormador = function(id) {
    Swal.fire({
        title: 'Confirmar Eliminação',
        text: 'Tem a certeza que deseja eliminar este formador?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/formadores/${id}`,
                method: 'POST',
                data: {_method: 'DELETE'},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function() {
                    Swal.fire('Eliminado!', 'Formador eliminado com sucesso', 'success');
                    location.reload();
                },
                error: function() {
                    Swal.fire('Erro', 'Erro ao eliminar formador', 'error');
                }
            });
        }
    });
};

/**
 * Aplicar filtros na tabela de formadores
 */
function aplicarFiltros() {
    let nome = $('#filtroNome').val();
    let especialidade = $('#filtroEspecialidade').val();
    
    let url = '/formadores?';
    
    if (nome) url += 'nome=' + encodeURIComponent(nome) + '&';
    if (especialidade) url += 'especialidade=' + encodeURIComponent(especialidade) + '&';
    
    // Remove o último '&' se existir
    url = url.replace(/&$/, '');
    
    console.log('Redirecionando para:', url);
    window.location.href = url;
}

/**
 * Limpar todos os filtros
 */
function limparFiltros() {
    window.location.href = '/formadores';
}
</script>
@endsection
