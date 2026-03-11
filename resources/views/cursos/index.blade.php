@extends('layouts.app')

@section('title', 'Cursos')

@section('content')

{{-- ============================================= --}}
{{-- HEADER                                        --}}
{{-- ============================================= --}}
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col-12 col-md-8 mb-2 mb-md-0">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <i class="fas fa-graduation-cap text-primary fa-lg"></i>
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-0">Gestão de Cursos</h1>
                    <p class="text-muted mb-0 small">Gerir todos os cursos disponíveis no sistema</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modalNovoCurso">
                <i class="fas fa-plus me-2"></i>Novo Curso
            </button>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- TABELA DE CURSOS                              --}}
    {{-- ============================================= --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-list text-primary"></i>
                <h5 class="mb-0 fw-semibold">Lista de Cursos</h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="cursosTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="width:60px">ID</th>
                            <th>Nome</th>
                            <th style="width:110px">Modalidade</th>
                            <th>Centro</th>
                            <th style="width:110px">Preço</th>
                            <th style="width:120px">Data Arranque</th>
                            <th style="width:90px" class="text-center">Status</th>
                            <th style="width:120px" class="text-end pe-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                                Carregando cursos...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Visualizar Detalhes do Curso           --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalVisualizarCurso" tabindex="-1" aria-labelledby="modalVisualizarCursoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-3">
            <div class="modal-header bg-primary text-white sticky-top">
                <h5 class="modal-title" id="modalVisualizarCursoLabel">
                    <i class="fas fa-book me-2"></i>Detalhes do Curso
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-4" id="conteudoVisualizarCurso">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Criar Novo Curso                       --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalNovoCurso" tabindex="-1" aria-labelledby="modalNovoCursoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-3">

            {{-- Header --}}
            <div class="modal-header bg-primary bg-opacity-10 border-0 py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-plus text-white small"></i>
                    </div>
                    <h5 class="modal-title fw-bold mb-0" id="modalNovoCursoLabel">Criar Novo Curso</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formNovoCursoAjax" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">

                        {{-- ====== COLUNA ESQUERDA ====== --}}
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100">
                                <div class="card-header bg-light border-bottom py-2 px-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-info-circle text-primary me-2"></i>Informações do Curso
                                    </h6>
                                </div>
                                <div class="card-body d-flex flex-column gap-3 p-3">

                                    {{-- Nome --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Nome <span class="text-danger">*</span></label>
                                        <input type="text" name="nome" class="form-control form-control-sm" placeholder="Ex: Gestão Empresarial" required>
                                    </div>

                                    {{-- Área --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Área <span class="text-danger">*</span></label>
                                        <input type="text" name="area" class="form-control form-control-sm" placeholder="Ex: Administração" required>
                                    </div>

                                    {{-- Modalidade + Status --}}
                                    <div class="row g-3">
                                        <div class="col-7">
                                            <label class="form-label fw-medium small mb-1">Modalidade <span class="text-danger">*</span></label>
                                            <select name="modalidade" class="form-select form-select-sm" required>
                                                <option value="">Selecione</option>
                                                <option value="presencial">Presencial</option>
                                                <option value="online">Online</option>
                                                <option value="hibrido">Híbrido</option>
                                            </select>
                                        </div>
                                        <div class="col-5 d-flex align-items-end">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="ativo" id="novoCursoAtivo" checked>
                                                <label class="form-check-label small" for="novoCursoAtivo">Ativo</label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Imagem --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">
                                            <i class="fas fa-image text-muted me-1"></i>Imagem
                                        </label>
                                        <input type="file" name="imagem" class="form-control form-control-sm" accept="image/jpeg,image/png,image/jpg,image/gif">
                                        <div class="form-text small">JPEG, PNG, JPG, GIF (máx 2 MB)</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ====== COLUNA DIREITA ====== --}}
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100">
                                <div class="card-header bg-light border-bottom py-2 px-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-file-alt text-primary me-2"></i>Conteúdo
                                    </h6>
                                </div>
                                <div class="card-body d-flex flex-column gap-3 p-3">

                                    {{-- Descrição --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Descrição</label>
                                        <textarea name="descricao" class="form-control form-control-sm" rows="4" placeholder="Breve descrição do curso..."></textarea>
                                    </div>

                                    {{-- Programa --}}
                                    <div class="flex-grow-1 d-flex flex-column">
                                        <label class="form-label fw-medium small mb-1">Programa do Curso</label>
                                        <textarea name="programa" class="form-control form-control-sm flex-grow-1" rows="6" placeholder="Conteúdo programático..."></textarea>
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
                            <button type="button" id="adicionarCentroModalBtn" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Adicionar Centro
                            </button>
                        </div>
                        <div id="centrosContainerModal" class="row g-3">
                            {{-- centros dinâmicos aqui --}}
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 bg-light px-4 py-3">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="submit" form="formNovoCursoAjax" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i>Criar Curso
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- Template para Centro no Modal                 --}}
{{-- ============================================= --}}
<template id="centroCursoTemplate">
    <div class="col-12 col-md-6">
        <div class="centro-card card border rounded-3 shadow-sm">
            <div class="card-header bg-light d-flex align-items-center justify-content-between py-2 px-3">
                <span class="badge bg-primary numero-centro-modal">Centro 1</span>
                <button type="button" class="btn btn-outline-danger btn-sm remover-centro-modal py-0 px-2" title="Remover">
                    <i class="fas fa-trash-alt small"></i>
                </button>
            </div>
            <div class="card-body p-3">
                <div class="d-flex flex-column gap-2">
                    <div>
                        <label class="form-label small mb-1 fw-medium">Centro <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm centro-id-modal" required>
                            <option value="">Selecione</option>
                        </select>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small mb-1 fw-medium">Preço (Kz) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control form-control-sm preco-modal" placeholder="0,00" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small mb-1 fw-medium">Duração <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm duracao-modal" placeholder="Ex: 3 meses" required>
                        </div>
                    </div>
                    <div>
                        <label class="form-label small mb-1 fw-medium">Data de Arranque <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm data-arranque-modal" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@section('scripts')
<script>
let centrosContainerModalCount = 0;
let centrosDisponiveisList = [];

$(document).ready(function() {
    carregarCursos();
    carregarCentros();
    configurarEventosModal();
});

/**
 * Carregar lista de centros disponíveis
 */
function carregarCentros() {
    $.ajax({
        url: '/api/centros',
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
 * Carregar detalhes do curso para visualização
 */
function carregarDetalhesCurso(cursoId) {
    $.ajax({
        url: `/api/cursos/${cursoId}`,
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        },
        success: function(curso) {
            const statusBadge = curso.ativo 
                ? '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Ativo</span>'
                : '<span class="badge bg-secondary"><i class="fas fa-times-circle me-1"></i>Inativo</span>';
            
            const modalidadeBadge = curso.modalidade === 'online' 
                ? '<span class="badge bg-info"><i class="fas fa-globe me-1"></i>Online</span>'
                : curso.modalidade === 'presencial'
                ? '<span class="badge bg-warning"><i class="fas fa-building me-1"></i>Presencial</span>'
                : '<span class="badge bg-primary"><i class="fas fa-laptop-house me-1"></i>Híbrido</span>';
            
            const imagemHtml = curso.imagem_url 
                ? `<img src="${curso.imagem_url}" alt="${curso.nome}" class="img-fluid rounded" style="max-width: 150px; max-height: 150px; object-fit: cover;">`
                : '<div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;"><i class="fas fa-image fa-2x text-muted"></i></div>';
            
            let centrosHtml = '';
            if (curso.centros && curso.centros.length > 0) {
                centrosHtml = '<div class="mt-3"><h6 class="fw-semibold mb-2"><i class="fas fa-building me-2 text-primary"></i>Centros Associados</h6><div class="list-group">';
                curso.centros.forEach(centro => {
                    centrosHtml += `
                        <div class="list-group-item px-3 py-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">${centro.nome}</h6>
                                    <small class="text-muted">Preço: <strong>${centro.pivot?.preco || 'N/A'} Kz</strong> | Duração: <strong>${centro.pivot?.duracao || 'N/A'}</strong></small>
                                </div>
                                <small class="text-muted">${centro.pivot?.data_arranque || 'N/A'}</small>
                            </div>
                        </div>
                    `;
                });
                centrosHtml += '</div></div>';
            }
            
            const conteudo = `
                <div class="row g-3">
                    <div class="col-md-3 text-center">
                        ${imagemHtml}
                    </div>
                    <div class="col-md-9">
                        <div class="mb-2">
                            <h5 class="fw-bold mb-2">${curso.nome}</h5>
                            <div class="d-flex gap-2 flex-wrap">
                                ${statusBadge}
                                ${modalidadeBadge}
                            </div>
                        </div>
                        <div class="mt-3">
                            <p class="mb-2"><strong>Área:</strong> ${curso.area}</p>
                            ${curso.descricao ? `<p class="mb-2"><strong>Descrição:</strong> ${curso.descricao}</p>` : ''}
                            ${curso.programa ? `<p class="mb-2"><strong>Programa:</strong> ${curso.programa}</p>` : ''}
                        </div>
                    </div>
                </div>
                ${centrosHtml}
            `;
            
            $('#conteudoVisualizarCurso').html(conteudo);
            $('#modalVisualizarCurso').modal('show');
        },
        error: function(err) {
            console.error('Erro ao carregar detalhes do curso:', err);
            Swal.fire('Erro!', 'Não foi possível carregar os detalhes do curso.', 'error');
        }
    });
}

/**
 * Configurar eventos do modal
 */
function configurarEventosModal() {
    $('#modalNovoCurso').on('show.bs.modal', function() {
        $('#formNovoCursoAjax')[0].reset();
        $('#centrosContainerModal').empty();
        centrosContainerModalCount = 0;
        adicionarCentroModal();
        $('#novoCursoAtivo').prop('checked', true);
    });

    $(document).on('click', '#adicionarCentroModalBtn', function(e) {
        e.preventDefault();
        adicionarCentroModal();
    });

    $(document).on('click', '.remover-centro-modal', function(e) {
        e.preventDefault();
        $(this).closest('.col-12').remove();
        atualizarNumeroCentrosModal();
    });

    // Visualizar detalhes do curso
    $(document).on('click', '.btn-visualizar-curso', function(e) {
        e.preventDefault();
        const cursoId = $(this).data('curso-id');
        carregarDetalhesCurso(cursoId);
    });
}

/**
 * Adicionar centro no modal
 */
function adicionarCentroModal() {
    const template = document.getElementById('centroCursoTemplate');
    if (!template) return;

    const clone = template.content.cloneNode(true);
    const wrapper = document.createElement('div');
    wrapper.appendChild(clone);

    const html = wrapper.innerHTML;
    $('#centrosContainerModal').append(html);

    const selects = $('#centrosContainerModal').find('.centro-id-modal');
    const lastSelect = selects.last();

    centrosDisponiveisList.forEach(centro => {
        lastSelect.append(`<option value="${centro.id}">${centro.nome}</option>`);
    });

    atualizarNumeroCentrosModal();
}

/**
 * Atualizar numeração dos centros
 */
function atualizarNumeroCentrosModal() {
    const badges = $('#centrosContainerModal').find('.numero-centro-modal');
    badges.each((index, badge) => {
        $(badge).text('Centro ' + (index + 1));
    });

    const btnsRemover = $('#centrosContainerModal').find('.remover-centro-modal');
    btnsRemover.prop('disabled', btnsRemover.length <= 1);
}

/**
 * Criar Novo Curso
 */
$("#formNovoCursoAjax").on("submit", function(e) {
    e.preventDefault();

    const $form = $(this);

    const nome = $form.find("[name=\"nome\"]").val().trim();
    const area = $form.find("[name=\"area\"]").val().trim();
    const modalidade = $form.find("[name=\"modalidade\"]").val().trim();

    if (!nome || !area || !modalidade) {
        Swal.fire("Erro!", "Preencha os campos obrigatórios (Nome, Área, Modalidade)", "error");
        return;
    }

    const centrosCount = $('#centrosContainerModal').find('.centro-id-modal').length;
    if (centrosCount === 0) {
        Swal.fire("Erro!", "Adicione pelo menos um centro", "error");
        return;
    }

    let centroValido = true;
    $('#centrosContainerModal').find('.centro-card').each(function() {
        const centroId = $(this).find('.centro-id-modal').val();
        const preco = $(this).find('.preco-modal').val();
        const duracao = $(this).find('.duracao-modal').val();
        const dataArranque = $(this).find('.data-arranque-modal').val();

        if (!centroId || !preco || !duracao || !dataArranque) {
            centroValido = false;
            return false;
        }
    });

    if (!centroValido) {
        Swal.fire("Erro!", "Preencha todos os dados dos centros (Centro, Preço, Duração, Data de Arranque)", "error");
        return;
    }

    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('descricao', $form.find("[name=\"descricao\"]").val().trim());
    formData.append('programa', $form.find("[name=\"programa\"]").val().trim());
    formData.append('area', area);
    formData.append('modalidade', modalidade);
    formData.append('ativo', $form.find("[name=\"ativo\"]").is(":checked") ? 1 : 0);

    const imagemFile = $form.find("[name=\"imagem\"]")[0].files[0];
    if (imagemFile) {
        formData.append('imagem', imagemFile);
    }

    let index = 0;
    $('#centrosContainerModal').find('.centro-card').each(function() {
        const centroId = $(this).find('.centro-id-modal').val();
        const preco = $(this).find('.preco-modal').val();
        const duracao = $(this).find('.duracao-modal').val();
        const dataArranque = $(this).find('.data-arranque-modal').val();

        formData.append(`centros[${index}][centro_id]`, centroId);
        formData.append(`centros[${index}][preco]`, preco);
        formData.append(`centros[${index}][duracao]`, duracao);
        formData.append(`centros[${index}][data_arranque]`, dataArranque);
        index++;
    });

    $.ajax({
        url: `/api/cursos`,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content"),
            "Accept": "application/json"
        },
        success: function(response) {
            console.log("Sucesso:", response);
            $("#modalNovoCurso").modal("hide");
            $form[0].reset();
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Curso criado com sucesso!",
                timer: 2000
            }).then(() => carregarCursos());
        },
        error: function(xhr, status, error) {
            console.error("Status:", xhr.status);
            console.error("Response:", xhr.responseText);

            let message = "Erro desconhecido";

            if (xhr.responseJSON?.errors) {
                message = Object.values(xhr.responseJSON.errors).flat().join("\n");
            } else if (xhr.responseJSON?.message) {
                message = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: message || "Erro ao criar curso."
            });
        }
    });
});

/**
 * Carrega a lista de cursos da API
 */
function carregarCursos() {
    $.ajax({
        url: '/api/cursos',
        method: 'GET',
        success: function(data) {
            let html = '';

            if (data.length === 0) {
                html = '<tr><td colspan="8" class="text-center text-muted py-5"><i class="fas fa-inbox fa-2x d-block mb-2 text-muted"></i>Nenhum curso encontrado</td></tr>';
            } else {
                data.forEach(function(curso) {
                    const statusBadge = curso.ativo
                        ? '<span class="badge bg-success-subtle text-success">Ativo</span>'
                        : '<span class="badge bg-secondary-subtle text-secondary">Inativo</span>';

                    const modalidadeBadge = curso.modalidade === 'online'
                        ? '<span class="badge bg-info-subtle text-info">Online</span>'
                        : curso.modalidade === 'presencial'
                        ? '<span class="badge bg-warning-subtle text-warning">Presencial</span>'
                        : '<span class="badge bg-primary-subtle text-primary">Híbrido</span>';

                    let centroCells = '';
                    if (curso.centros && curso.centros.length > 0) {
                        const centro = curso.centros[0];
                        const preco = centro.pivot.preco;
                        const dataArranque = new Date(centro.pivot.data_arranque).toLocaleDateString('pt-PT');
                        centroCells = `<td><span class="fw-medium">${centro.nome}</span></td><td>${parseFloat(preco).toLocaleString('pt-PT', {minimumFractionDigits: 2, maximumFractionDigits: 2})} Kz</td><td><small>${dataArranque}</small></td>`;
                    } else {
                        centroCells = `<td class="text-muted"><small>N/A</small></td><td class="text-muted"><small>N/A</small></td><td class="text-muted"><small>N/A</small></td>`;
                    }

                    html += `
                        <tr>
                            <td class="ps-3 text-muted">${curso.id}</td>
                            <td>
                                <div class="fw-semibold">${curso.nome}</div>
                                ${curso.descricao ? `<small class="text-muted">${curso.descricao.substring(0, 60)}...</small>` : ''}
                            </td>
                            <td>${modalidadeBadge}</td>
                            ${centroCells}
                            <td class="text-center">${statusBadge}</td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-visualizar-curso" data-curso-id="${curso.id}" title="Visualizar detalhes">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="/cursos/${curso.id}" class="btn btn-outline-info" title="Gerenciar curso">
                                        <i class="fas fa-sliders-h"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" onclick="eliminarCurso(${curso.id})" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }

            $('#cursosTable tbody').html(html);

            if ($.fn.DataTable.isDataTable('#cursosTable')) {
                $('#cursosTable').DataTable().destroy();
            }

            $('#cursosTable').DataTable({
                language: window.dataTablesPortuguese,
                responsive: true,
                pageLength: 25,
                order: [[0, 'desc']],
                columnDefs: [
                    { targets: 7, orderable: false }
                ],
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
            });
        },
        error: function(xhr) {
            console.error('Erro ao carregar cursos:', xhr);
            $('#cursosTable tbody').html('<tr><td colspan="8" class="text-center text-danger py-4"><i class="fas fa-exclamation-triangle me-2"></i>Erro ao carregar os dados</td></tr>');
        }
    });
}

/**
 * Elimina um curso específico
 */
function eliminarCurso(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: 'Esta ação irá eliminar o curso permanentemente!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Sim, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/cursos/${id}`,
                method: 'DELETE',
                success: function(response) {
                    Swal.fire('Eliminado!', 'O curso foi eliminado com sucesso.', 'success');
                    carregarCursos();
                },
                error: function(xhr) {
                    console.error('Erro ao eliminar curso:', xhr);
                    Swal.fire('Erro!', 'Ocorreu um erro ao eliminar o curso.', 'error');
                }
            });
        }
    });
}
</script>
@endsection
