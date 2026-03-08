@extends('layouts.app')

@section('title', 'Novo Curso')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-plus me-3 text-primary"></i>Novo Curso
                    </h1>
                    <p class="text-muted">Criar um novo curso no sistema</p>
                </div>
                <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-book me-2"></i>Informações do Curso
                    </h5>
                </div>
                <div class="card-body">
                    <form id="cursoForm" action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nome" class="form-label">Nome do Curso <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" required maxlength="100">
                                <div class="form-text">Máximo 100 caracteres</div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="area" class="form-label">Área <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="area" name="area" required maxlength="100">
                                <div class="form-text">Ex: Informática, Gestão, etc.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modalidade" class="form-label">Modalidade <span class="text-danger">*</span></label>
                                <select class="form-select" id="modalidade" name="modalidade" required>
                                    <option value="">Selecione a modalidade</option>
                                    <option value="presencial">Presencial</option>
                                    <option value="online">Online</option>
                                    <option value="hibrido">Híbrido</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="ativo" class="form-label">Status</label>
                                <select class="form-select" id="ativo" name="ativo">
                                    <option value="1" selected>Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem do Curso</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                            <div class="form-text">Ficheiro de imagem (máximo 2MB)</div>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4" maxlength="1000"></textarea>
                            <div class="form-text">Descrição detalhada do curso (máximo 1000 caracteres)</div>
                        </div>

                        <div class="mb-3">
                            <label for="programa" class="form-label">Programa do Curso</label>
                            <textarea class="form-control" id="programa" name="programa" rows="8" maxlength="5000"></textarea>
                            <div class="form-text">Programa detalhado, módulos, objetivos, etc. (máximo 5000 caracteres)</div>
                        </div>

                        <hr>
                        <h6 class="mb-3"><i class="fas fa-building me-2"></i>Centros onde este curso é oferecido <span class="text-danger">*</span></h6>
                        
                        <div id="centrosContainer">
                            <!-- Centros serão adicionados aqui dinamicamente -->
                        </div>
                        
                        <button type="button" class="btn btn-outline-primary btn-sm" id="adicionarCentro">
                            <i class="fas fa-plus me-2"></i>Adicionar Centro
                        </button>
                        <div class="form-text">Adicione pelo menos um centro onde o curso será oferecido (obrigatório)</div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('cursos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Curso
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Ajuda
                    </h6>
                </div>
                <div class="card-body">
                    <h6>Dicas para criar um curso:</h6>
                    <ul class="small">
                        <li><strong>Nome:</strong> Use um nome claro e descritivo</li>
                        <li><strong>Área:</strong> Categorize por área de conhecimento</li>
                        <li><strong>Modalidade:</strong> Escolha se é presencial ou online</li>
                        <li><strong>Descrição:</strong> Explique o que o curso oferece</li>
                        <li><strong>Programa:</strong> Detalhe os módulos e conteúdos</li>
                    </ul>
                </div>
            </div>

            <div class="card mt-3" id="previewCard" style="display: none;">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-eye me-2"></i>Pré-visualização
                    </h6>
                </div>
                <div class="card-body" id="previewContent">
                    <!-- Preview será gerado aqui -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let centrosData = {};

$(document).ready(function() {
    // Carregar lista de centros
    carregarCentros();
    
    // Preview em tempo real
    $('#cursoForm input, #cursoForm select, #cursoForm textarea').on('input change', function() {
        atualizarPreview();
    });

    // Adicionar centro
    $('#adicionarCentro').on('click', function() {
        adicionarCentro();
    });

    // Remover centro (delegação de eventos)
    $(document).on('click', '.remover-centro', function() {
        $(this).closest('.centro-item').remove();
        verificarBotoesRemover();
        atualizarPreview();
    });

    // Validação e submissão AJAX
    $('#cursoForm').on('submit', function(e) {
        e.preventDefault();
        
        const centrosCount = $('.centro-item').length;
        if (centrosCount === 0) {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, adicione pelo menos um centro!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false;
        }

        submeterCurso();
    });
});

function carregarCentros() {
    $.ajax({
        url: '/api/centros',
        method: 'GET',
        headers: { 'Accept': 'application/json' },
        success: function(response) {
            centrosData = {};
            response.forEach(centro => {
                centrosData[centro.id] = centro.nome;
            });
            // Adicionar um centro vazio por padrão
            adicionarCentro();
        },
        error: function() {
            console.error('Erro ao carregar centros');
        }
    });
}

function adicionarCentro() {
    const centroIndex = $('.centro-item').length;
    let optionsHtml = '<option value="">Selecione um centro</option>';
    
    for (let id in centrosData) {
        optionsHtml += `<option value="${id}">${centrosData[id]}</option>`;
    }
    
    const novocentro = `
        <div class="centro-item card mb-3 p-3">
            <div class="row align-items-end">
                <div class="col-md-5">
                    <label class="form-label small">Centro <span class="text-danger">*</span></label>
                    <select class="form-select centro-select" name="centros[${centroIndex}][centro_id]" required>
                        ${optionsHtml}
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Preço (Kz) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="centros[${centroIndex}][preco]" step="0.01" min="0" required placeholder="0.00">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Duração <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="centros[${centroIndex}][duracao]" required placeholder="Ex: 12 semanas">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger btn-sm remover-centro" ${centroIndex === 0 ? 'disabled' : ''}>
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <label class="form-label small">Data de Arranque <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="centros[${centroIndex}][data_arranque]" required min="{{ date('Y-m-d') }}">
                </div>
            </div>
        </div>
    `;
    
    $('#centrosContainer').append(novocentro);
    verificarBotoesRemover();
}

function verificarBotoesRemover() {
    const totalCentros = $('.centro-item').length;
    $('.remover-centro').prop('disabled', totalCentros <= 1);
}

function atualizarPreview() {
    const nome = $('#nome').val();
    const area = $('#area').val();
    const modalidade = $('#modalidade').val();
    const ativo = $('#ativo').val();
    const descricao = $('#descricao').val();
    const centrosCount = $('.centro-item').length;

    if (nome || area || modalidade) {
        const statusBadge = ativo == '1' 
            ? '<span class="badge bg-success">Ativo</span>' 
            : '<span class="badge bg-secondary">Inativo</span>';
        
        const modalidadeBadge = modalidade === 'online' 
            ? '<span class="badge bg-info">Online</span>' 
            : modalidade === 'presencial' 
                ? '<span class="badge bg-warning text-dark">Presencial</span>' 
                : modalidade === 'hibrido'
                    ? '<span class="badge bg-primary">Híbrido</span>'
                    : '';

        let preview = `
            <h6>${nome || 'Nome do Curso'}</h6>
            <p class="mb-1"><strong>Área:</strong> ${area || 'Não definida'}</p>
            <p class="mb-2">
                ${modalidadeBadge} ${statusBadge}
            </p>
            <p class="small"><strong>Centros:</strong> ${centrosCount}</p>
            ${descricao ? `<p class="small text-muted">${descricao.substring(0, 100)}...</p>` : ''}
        `;

        $('#previewContent').html(preview);
        $('#previewCard').show();
    } else {
        $('#previewCard').hide();
    }
}

function submeterCurso() {
    // Validar que pelo menos um centro foi adicionado
    const centrosCount = $('.centro-item').length;
    if (centrosCount === 0) {
        Swal.fire({
            title: 'Erro!',
            text: 'Por favor, adicione pelo menos um centro!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Criar FormData do formulário
    const formDataObj = new FormData($('#cursoForm')[0]);
    
    // Adicionar CSRF token
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    formDataObj.append('_token', csrfToken);

    $.ajax({
        url: '{{ route("cursos.store") }}',
        method: 'POST',
        data: formDataObj,
        processData: false,
        contentType: false,
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            $('#cursoForm button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Guardando...');
        },
        success: function(response) {
            Swal.fire({
                title: 'Sucesso!',
                text: 'Curso criado com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '{{ route("cursos.index") }}';
            });
        },
        error: function(xhr) {
            console.error('Erro ao criar curso:', xhr);
            
            if (xhr.status === 401) {
                window.location.href = '/login';
                return;
            }
            
            if (xhr.status === 419) {
                Swal.fire({
                    title: 'Sessão Expirada!',
                    text: 'Por favor, recarregue a página e tente novamente.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
                return;
            }
            
            let message = 'Ocorreu um erro ao criar o curso.';
            let detailMessage = '';
            
            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                if (xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    detailMessage = errors.join('<br>');
                }
            }

            Swal.fire({
                title: 'Erro!',
                html: message + (detailMessage ? '<br><small class="text-muted">' + detailMessage + '</small>' : ''),
                icon: 'error',
                confirmButtonText: 'OK'
            });
        },
        complete: function() {
            $('#cursoForm button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Guardar Curso');
        }
    });
}
</script>
@endsection
