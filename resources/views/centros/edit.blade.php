@extends('layouts.app')

@section('title', 'Editar Centro')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-edit me-3 text-primary"></i>Editar Centro
                    </h1>
                    <p class="text-muted">Atualizar informações do centro de formação</p>
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
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-building me-2"></i>Informações do Centro
                    </h5>
                </div>
                <div class="card-body">
                    <form id="centroForm" action="{{ route('centros.update', $centro->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nome" class="form-label">Nome do Centro <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" value="{{ $centro->nome }}" required maxlength="255">
                                <div class="form-text">Nome único do centro (máximo 255 caracteres)</div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $centro->email }}" maxlength="255">
                                <div class="form-text">Email do centro (opcional)</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="localizacao" class="form-label">Localização <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="localizacao" name="localizacao" value="{{ $centro->localizacao }}" required maxlength="255">
                            <div class="form-text">Endereço completo ou localização do centro</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contactos <span class="text-danger">*</span></label>
                            <div id="contactosContainer">
                                <!-- Contactos serão carregados aqui -->
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="adicionarContacto">
                                <i class="fas fa-plus me-2"></i>Adicionar Telefone
                            </button>
                            <div class="form-text">Adicione até 5 telefones do centro (pelo menos um é obrigatório)</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('centros.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Atualizar Centro
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
                        <i class="fas fa-info-circle me-2"></i>Informações
                    </h6>
                </div>
                <div class="card-body" id="infoCard">
                    <div class="text-center py-3">
                        <i class="fas fa-spinner fa-spin"></i>
                        <p class="mb-0 mt-2">Carregando...</p>
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
    const centroId = {{ $centro->id ?? 'null' }};
    
    if (centroId) {
        carregarCentro(centroId);
    } else {
        Swal.fire('Erro!', 'ID do centro não fornecido.', 'error').then(() => {
            window.location.href = '{{ route("centros.index") }}';
        });
    }

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
        atualizarCentro();
    });

    // Atualizar preview quando contactos mudarem
    $(document).on('input change', '.contacto-tipo, .contacto-valor', function() {
        atualizarPreview();
    });
});

function carregarCentro(id) {
    $.get(`/centros/${id}`)
        .done(function(response) {
            // Preencher formulário
            const centro = response.dados || response;
            // ID já disponível na view
            $('#nome').val(centro.nome);
            $('#localizacao').val(centro.localizacao);
            $('#email').val(centro.email || '');

            // Carregar contactos
            carregarContactos(centro.contactos);

            // Mostrar informações
            mostrarInformacoesCentro(centro);

            // Mostrar formulário
            $('#loadingContent').hide();
            $('#centroForm').show();

            // Atualizar preview inicial
            atualizarPreview();
        })
        .fail(function(xhr) {
            if (xhr.status === 401) {
                localStorage.removeItem('auth_token');
                window.location.href = '/login';
                return;
            }
            
            Swal.fire('Erro!', 'Centro não encontrado.', 'error').then(() => {
                window.location.href = '{{ route("centros.index") }}';
            });
        });
}

function carregarContactos(contactosData) {
    $('#contactosContainer').empty();
    
    try {
        let contactos = [];
        if (contactosData) {
            if (typeof contactosData === 'string') {
                contactos = JSON.parse(contactosData);
            } else {
                contactos = contactosData;
            }
        }
        
        // Garantir que é um array
        if (!Array.isArray(contactos)) {
            contactos = [];
        }
        
        if (contactos && contactos.length > 0) {
            contactos.forEach((valor) => {
                adicionarContactoComDados(valor);
            });
        } else {
            // Se não há contactos, adicionar um item vazio
            adicionarContacto();
        }
    } catch (e) {
        console.error('Erro ao carregar contactos:', e);
        // Se há erro no JSON, adicionar um item vazio
        adicionarContacto();
    }
    
    verificarBotoesRemover();
}

function adicionarContactoComDados(valor = '') {
    const novoContacto = `
        <div class="contacto-item row align-items-end mb-2">
            <div class="col-md-10">
                <input type="tel" class="form-control contacto-valor" name="contactos[]" value="${valor}" placeholder="Ex: 923212399" title="Telefone de Angola (9 dígitos)" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger btn-sm remover-contacto">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    
    $('#contactosContainer').append(novoContacto);
}

function adicionarContacto() {
    adicionarContactoComDados();
    verificarBotoesRemover();
}

function verificarBotoesRemover() {
    const totalContactos = $('.contacto-item').length;
    $('.remover-contacto').prop('disabled', totalContactos <= 1);
}

function mostrarInformacoesCentro(centro) {
    const dataFormatada = new Date(centro.created_at).toLocaleDateString('pt-PT');
    const dataAtualizacao = new Date(centro.updated_at).toLocaleDateString('pt-PT');

    const infoHtml = `
        <p><strong>ID:</strong> ${centro.id}</p>
        <p><strong>Data de Criação:</strong><br><small>${dataFormatada}</small></p>
        <p><strong>Última Atualização:</strong><br><small>${dataAtualizacao}</small></p>
        
        <hr>
        
        <h6 class="text-warning">Atenção:</h6>
        <ul class="small">
            <li>As alterações serão salvas imediatamente</li>
            <li>Certifique-se de que todos os dados estão corretos</li>
            <li>O nome do centro deve ser único no sistema</li>
        </ul>
    `;

    $('#infoCard').html(infoHtml);
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

function atualizarCentro() {
    const centroId = {{ $centro->id }};
    
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

    // Transformar em FormData
    const formDataObj = new FormData();
    formDataObj.append('_method', 'PUT');
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
    formDataObj.append('_token', csrfToken);

    $.ajax({
        url: `/centros/${centroId}`,
        method: 'POST',
        data: formDataObj,
        processData: false,
        contentType: false,
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            $('#centroForm button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Atualizando...');
        },
        success: function(response) {
            Swal.fire({
                title: 'Sucesso!',
                text: 'Centro atualizado com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '{{ route("centros.index") }}';
            });
        },
        error: function(xhr) {
            console.error('Erro ao atualizar centro:', xhr);
            
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
            
            let message = 'Ocorreu um erro ao atualizar o centro.';
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
            $('#centroForm button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Atualizar Centro');
        }
    });
}
</script>
@endsection
