@extends('layouts.app')

@section('title', 'Novo Curso')

@section('content')
<style>
    .container-form {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 15px;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.375rem 0.375rem 0 0;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: 0.35rem;
        font-size: 0.875rem;
    }
    
    .form-control, .form-select {
        font-size: 0.9375rem;
        padding: 0.4375rem 0.75rem;
        border-radius: 0.25rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    textarea.form-control {
        resize: vertical;
    }
    
    .section-divider {
        border-top: 1px solid #e9ecef;
        margin: 1.5rem 0;
        padding-top: 1.5rem;
    }
    
    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .section-title i {
        color: #667eea;
    }
    
    .centro-item {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1rem;
        margin-bottom: 1rem;
        position: relative;
    }
    
    .centro-item .numero-centro {
        font-weight: 600;
        color: #667eea;
    }
    
    .btn-remove {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
    }
    
    .btn-group-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .alert-box {
        margin-bottom: 1rem;
    }
    
    .row {
        margin-bottom: 0.75rem;
    }
    
    .row:last-child {
        margin-bottom: 0;
    }
</style>

<div class="container-form py-4">
    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0"><i class="fas fa-plus-circle text-primary me-2"></i>Criar Novo Curso</h2>
            <a href="{{ route('cursos.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Voltar
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show alert-box" role="alert">
            <strong><i class="fas fa-exclamation-circle me-2"></i>Erros encontrados:</strong>
            <ul class="mb-0 mt-2 ps-3">
                @foreach ($errors->all() as $error)
                    <li class="small">{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('cursos.store') }}" method="POST" id="cursoSetupForm" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Informações do Curso e Centros</h5>
            </div>
            <div class="card-body">
                
                <!-- Seção: Informações Básicas -->
                <div class="section-title">
                    <i class="fas fa-book-open"></i> Informações Básicas
                </div>
                
                <div class="row">
                    <div class="col-lg-7">
                        <label for="nome" class="form-label">Nome do Curso <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" required maxlength="100" placeholder="Informe o nome do curso">
                        @error('nome')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-5">
                        <label for="area" class="form-label">Área <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ old('area') }}" required maxlength="100" placeholder="Ex: Tecnologia">
                        @error('area')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <label for="modalidade" class="form-label">Modalidade <span class="text-danger">*</span></label>
                        <select class="form-select @error('modalidade') is-invalid @enderror" id="modalidade" name="modalidade" required>
                            <option value="">Selecione a modalidade</option>
                            <option value="presencial" {{ old('modalidade') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                            <option value="online" {{ old('modalidade') == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="hibrido" {{ old('modalidade') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                        </select>
                        @error('modalidade')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-3">
                        <label for="ativo" class="form-label">Status</label>
                        <select class="form-select" id="ativo" name="ativo">
                            <option value="1" selected>Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="imagem" class="form-label">Imagem</label>
                        <input type="file" class="form-control form-control-sm @error('imagem') is-invalid @enderror" id="imagem" name="imagem" accept="image/*">
                        @error('imagem')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" maxlength="1000" rows="2" placeholder="Descreva o curso brevemente">{{ old('descricao') }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="programa" class="form-label">Programa do Curso</label>
                        <textarea class="form-control" id="programa" name="programa" maxlength="5000" rows="3" placeholder="Informe os detalhes e conteúdo do programa">{{ old('programa') }}</textarea>
                    </div>
                </div>

                <!-- Seção: Centros -->
                <div class="section-divider"></div>
                <div class="section-title">
                    <i class="fas fa-building"></i> Centros de Formação
                </div>

                <div id="centrosContainer"></div>
                
                <button type="button" class="btn btn-outline-success btn-sm" id="adicionarCentroBtn">
                    <i class="fas fa-plus me-1"></i>Adicionar Centro
                </button>

                @error('centro_curso')
                    <div class="alert alert-danger mt-2 small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botões de Ação -->
            <div style="background: #f8f9fa; padding: 1rem 1.5rem; border-top: 1px solid #dee2e6; border-radius: 0 0 0.375rem 0.375rem; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-times me-1"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">
                    <i class="fas fa-save me-1"></i>Guardar Curso
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Template Centro -->
<template id="centroTemplate">
    <div class="centro-item">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div><strong>Centro <span class="numero-centro badge bg-primary">1</span></strong></div>
            <button type="button" class="btn btn-sm btn-close remover-centro" aria-label="Remover" title="Remover centro"></button>
        </div>
        <div class="row g-2">
            <div class="col-md-8">
                <label class="form-label">Centro <span class="text-danger">*</span></label>
                <select class="form-select form-select-sm centro-select" name="centro_curso[INDEX][centro_id]" required>
                    <option value="">Selecione um centro</option>
                    @foreach ($centros as $centro)
                        <option value="{{ $centro->id }}">{{ $centro->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Preço (€) <span class="text-danger">*</span></label>
                <input type="number" class="form-control form-control-sm" name="centro_curso[INDEX][preco]" placeholder="0.00" step="0.01" min="0" required>
            </div>
        </div>
    </div>
</template>

@endsection

@section('scripts')
<script>
let centroCount = 0;

$(document).ready(function() {
    // Adicionar primeiro centro
    adicionarCentro();

    // Eventos
    $(document).on('click', '#adicionarCentroBtn', function(e) {
        e.preventDefault();
        adicionarCentro();
    });
    $(document).on('click', '.remover-centro', removerCentro);

    // Handle form submit
    $('#cursoSetupForm').on('submit', function(e) {
        const $submitBtn = $('#submitBtn');
        
        // Mostrar spinner e desabilitar botão
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Guardando...');
        
        // Mostrar SweetAlert
        Swal.fire({
            title: 'Processando...',
            text: 'Por favor aguarde enquanto guardamos os dados.',
            icon: 'info',
            allowOutsideClick: false,
            didOpen: (modal) => {
                Swal.showLoading();
            }
        });
    });
});

function adicionarCentro() {
    try {
        const template = document.getElementById('centroTemplate');
        if (!template) return;
        
        const tempDiv = document.createElement('div');
        const clone = template.content.cloneNode(true);
        tempDiv.appendChild(clone);
        
        let html = tempDiv.innerHTML
            .replace(/INDEX/g, centroCount)
            .replace(/numero-centro">1</g, `numero-centro">${centroCount + 1}<`);
        
        $('#centrosContainer').append('<div class="centro-wrapper-' + centroCount + '">' + html + '</div>');
        centroCount++;
        
        atualizarBotoesRemover();
    } catch(e) {
        console.error('Erro ao adicionar centro:', e);
    }
}

function removerCentro(e) {
    e.preventDefault();
    $(this).closest('[class*="centro-wrapper-"]').remove();
    atualizarBotoesRemover();
}

function atualizarBotoesRemover() {
    $('.remover-centro').prop('disabled', $('.centro-item').length <= 1);
}
</script>
@endsection
