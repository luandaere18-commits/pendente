@extends('layouts.app')

@section('title', 'Novo Centro')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-plus me-3 text-primary"></i>Novo Centro
                    </h1>
                    <p class="text-muted">Criar um novo centro de formação no sistema</p>
                </div>
                <a href="{{ route('centros.index') }}" class="btn btn-outline-secondary">
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
                        <i class="fas fa-building me-2"></i>Informações do Centro
                    </h5>
                </div>
                <div class="card-body">
                    <form id="centroForm">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nome" class="form-label">Nome do Centro <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" required maxlength="255">
                                <div class="form-text">Nome único do centro (máximo 255 caracteres)</div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" maxlength="255">
                                <div class="form-text">Email do centro (opcional)</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="localizacao" class="form-label">Localização <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="localizacao" name="localizacao" required maxlength="255">
                            <div class="form-text">Endereço completo ou localização do centro</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contactos <span class="text-danger">*</span></label>
                            <div id="contactosContainer">
                                <div class="contacto-item row align-items-end mb-2">
                                    <div class="col-md-10">
                                        <input type="tel" class="form-control contacto-valor" name="contactos[]" placeholder="Ex: 923212399" title="Telefone de Angola (9 dígitos)" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm remover-contacto" disabled>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="adicionarContacto">
                                <i class="fas fa-plus me-2"></i>Adicionar Telefone
                            </button>
                            <div class="form-text">Adicione até 5 direitos telefónicos do centro (pelo menos um é obrigatório)</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('centros.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Centro
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
                    <h6>Dicas para criar um centro:</h6>
                    <ul class="small">
                        <li><strong>Nome:</strong> Use um nome único e identificativo</li>
                        <li><strong>Localização:</strong> Seja específico no endereço</li>
                        <li><strong>Email:</strong> Email principal do centro (opcional)</li>
                        <li><strong>Contactos:</strong> Adicione vários tipos de contacto</li>
                    </ul>
                    
                    <div class="alert alert-warning alert-sm mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atenção:</strong> O nome do centro deve ser único no sistema.
                    </div>
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
$(document).ready(function() {
    // Preview em tempo real
    $('#centroForm input, #centroForm select').on('input change', function() {
        atualizarPreview();
    });

    // Adicionar contacto
    $('#adicionarContacto').on('click', function() {
        adicionarContacto();
    });

    // Remover contacto (delegação de eventos)
    $(document).on('click', '.remover-contacto', function() {
        $(this).closest('.contacto-item').remove();
        verificarBotoesRemover();
        atualizarPreview();
    });

    // Submit do formulário
    $('#centroForm').on('submit', function(e) {
        e.preventDefault();
        criarCentro();
    });

    // Atualizar preview quando contactos mudarem
    $(document).on('input change', '.contacto-valor', function() {
        atualizarPreview();
    });
});

function adicionarContacto() {
    const novoContacto = `
        <div class="contacto-item row align-items-end mb-2">
            <div class="col-md-10">
                <input type="tel" class="form-control contacto-valor" name="contactos[]" placeholder="Ex: 923212399" title="Telefone de Angola (9 dígitos)" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger btn-sm remover-contacto">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    
    $('#contactosContainer').append(novoContacto);
    verificarBotoesRemover();
}

function verificarBotoesRemover() {
    const totalContactos = $('.contacto-item').length;
    $('.remover-contacto').prop('disabled', totalContactos <= 1);
}

function atualizarPreview() {
    const nome = $('#nome').val();
    const localizacao = $('#localizacao').val();
    const email = $('#email').val();

    if (nome || localizacao) {
        // Coletar contactos
        let contactosHtml = '';
        $('.contacto-valor').each(function() {
            const valor = $(this).val().trim();
            if (valor) {
                contactosHtml += `<small class="d-block">📱 ${valor}</small>`;
            }
        });

        let preview = `
            <h6>${nome || 'Nome do Centro'}</h6>
            <p class="mb-1"><strong>Localização:</strong> ${localizacao || 'Não definida'}</p>
            <p class="mb-2"><strong>Email:</strong> ${email || 'Não definido'}</p>
            <div>
                <strong>Contactos:</strong>
                ${contactosHtml || '<small class="text-muted">Nenhum contacto adicionado</small>'}
            </div>
        `;

        $('#previewContent').html(preview);
        $('#previewCard').show();
    } else {
        $('#previewCard').hide();
    }
}

function criarCentro() {
    // Coletar contactos como array simples
    const contactos = [];
    $('.contacto-valor').each(function() {
        const valor = $(this).val().trim();
        if (valor) {
            contactos.push(valor);
        }
    });

    if (contactos.length === 0) {
        Swal.fire({
            title: 'Erro!',
            text: 'Por favor, adicione pelo menos um telefone!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Transformar array em FormData
    const formDataObj = new FormData();
    formDataObj.append('nome', $('#nome').val());
    formDataObj.append('localizacao', $('#localizacao').val());
    
    const email = $('#email').val();
    if (email) {
        formDataObj.append('email', email);
    }
    
    // Array de contactos
    contactos.forEach((tel, index) => {
        formDataObj.append(`contactos[${index}]`, tel);
    });
    
    // Adicionar CSRF token
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    console.log('CSRF Token:', csrfToken);
    formDataObj.append('_token', csrfToken);

    $.ajax({
        url: '/centros',
        method: 'POST',
        data: formDataObj,
        processData: false,
        contentType: false,
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            $('#centroForm button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Guardando...');
        },
        success: function(response) {
            Swal.fire({
                title: 'Sucesso!',
                text: 'Centro criado com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '{{ route("centros.index") }}';
            });
        },
        error: function(xhr) {
            console.error('Erro ao criar centro:', xhr);
            console.log('Response Text:', xhr.responseText);
            console.log('Response JSON:', xhr.responseJSON);
            console.log('Status:', xhr.status);
            
            if (xhr.status === 401) {
                Swal.fire({
                    title: 'Não Autorizado!',
                    text: 'Você precisa estar logado para criar centros. Redirecionando para login...',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '/login';
                });
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
            
            let message = 'Ocorreu um erro ao criar o centro.';
            let detailMessage = '';
            
            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                if (xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    detailMessage = errors.join('<br>');
                }
            } else if (xhr.responseText) {
                detailMessage = xhr.responseText.substring(0, 200);
            }

            Swal.fire({
                title: 'Erro!',
                html: message + (detailMessage ? '<br><small class="text-muted">' + detailMessage + '</small>' : ''),
                icon: 'error',
                confirmButtonText: 'OK'
            });
        },
        complete: function() {
            $('#centroForm button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Guardar Centro');
        }
    });
}
</script>
@endsection
