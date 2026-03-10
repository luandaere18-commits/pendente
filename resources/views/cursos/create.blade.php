@extends('layouts.app')

@section('title', 'Novo Curso com Centros e Cronogramas')

@section('content')
<style>
    .container-compact {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: #e7f1ff;
        color: #0c63e4;
    }
    
    .accordion-button {
        padding: 0.75rem 1.25rem;
        font-weight: 500;
    }
    
    .accordion-body {
        padding: 1rem 1.25rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .form-control, .form-select {
        font-size: 0.95rem;
        padding: 0.5rem 0.75rem;
    }
    
    textarea.form-control {
        min-height: 80px;
    }
    
    .mb-3 {
        margin-bottom: 0.75rem !important;
    }
    
    .col-md-12 {
        margin-bottom: 0.5rem;
    }
</style>

<div class="container-compact">
    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">
                    <i class="fas fa-cog me-2 text-primary"></i>Novo Curso
                </h2>
                <p class="text-muted small">Criar curso com centros e cronogramas em uma única etapa</p>
            </div>
            <a href="{{ route('cursos.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <strong><i class="fas fa-exclamation-circle me-2"></i>Erros encontrados:</strong>
            <ol class="mb-0 mt-2 ps-3">
                @foreach ($errors->all() as $error)
                    <li class="small">{{ $error }}</li>
                @endforeach
            </ol>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('cursos.store') }}" method="POST" id="cursoSetupForm">
        @csrf

        <div class="accordion mb-3" id="cursoAccordion">
            <!-- 1. Informações do Curso -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#colapsoCurso">
                        <i class="fas fa-book me-2"></i>1. Informações do Curso
                    </button>
                </h2>
                <div id="colapsoCurso" class="accordion-collapse collapse show" data-bs-parent="#cursoAccordion">
                    <div class="accordion-body">
                        <div class="row g-2">
                            <div class="col-md-8">
                                <label for="nome" class="form-label small">Nome do Curso <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" required maxlength="100">
                                @error('nome')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="area" class="form-label small">Área <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm @error('area') is-invalid @enderror" id="area" name="area" value="{{ old('area') }}" required maxlength="100">
                                @error('area')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="modalidade" class="form-label small">Modalidade <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm @error('modalidade') is-invalid @enderror" id="modalidade" name="modalidade" required>
                                    <option value="">Selecione a modalidade</option>
                                    <option value="presencial" {{ old('modalidade') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                                    <option value="online" {{ old('modalidade') == 'online' ? 'selected' : '' }}>Online</option>
                                    <option value="hibrido" {{ old('modalidade') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                </select>
                                @error('modalidade')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="ativo" class="form-label small">Status</label>
                                <select class="form-select form-select-sm" id="ativo" name="ativo">
                                    <option value="1" selected>Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="descricao" class="form-label small">Descrição</label>
                                <textarea class="form-control form-control-sm" id="descricao" name="descricao" maxlength="1000" style="min-height: 70px;">{{ old('descricao') }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label for="programa" class="form-label small">Programa do Curso</label>
                                <textarea class="form-control form-control-sm" id="programa" name="programa" maxlength="5000" style="min-height: 80px;">{{ old('programa') }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="imagem" class="form-label small">Imagem do Curso</label>
                                <input type="file" class="form-control form-control-sm @error('imagem') is-invalid @enderror" id="imagem" name="imagem" accept="image/*">
                                <small class="text-muted">JPEG, PNG, JPG ou GIF (máx 2MB)</small>
                                @error('imagem')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Centros e Preços -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#colapsocentros">
                        <i class="fas fa-building me-2"></i>2. Centros e Informações de Preço
                    </button>
                </h2>
                <div id="colapsocentros" class="accordion-collapse collapse" data-bs-parent="#cursoAccordion">
                    <div class="accordion-body">
                        <div id="centrosContainer"></div>
                        
                        <button type="button" class="btn btn-outline-success btn-sm mt-2" id="adicionarCentroBtn">
                            <i class="fas fa-plus me-2"></i>Adicionar Centro
                        </button>

                        @error('centro_curso')
                            <div class="alert alert-danger mt-2 small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 3. Cronogramas -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#colapsoCronogramas">
                        <i class="fas fa-calendar-alt me-2"></i>3. Cronogramas (Dias e Horários)
                    </button>
                </h2>
                <div id="colapsoCronogramas" class="accordion-collapse collapse" data-bs-parent="#cursoAccordion">
                    <div class="accordion-body">
                        <div id="cronogramasContainer"></div>
                        
                        <button type="button" class="btn btn-outline-warning btn-sm mt-2" id="adicionarCronogramaBtn">
                            <i class="fas fa-plus me-2"></i>Adicionar Cronograma
                        </button>

                        @error('cronogramas')
                            <div class="alert alert-danger mt-2 small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="d-flex justify-content-end gap-2 mb-3">
            <a href="{{ route('cursos.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-times me-2"></i>Cancelar
            </a>
            <button type="submit" class="btn btn-sm btn-primary" id="submitBtn">
                <i class="fas fa-save me-2"></i>Guardar Curso
            </button>
        </div>
    </form>
</div>

<!-- Templates para Centro e Cronograma -->
<template id="centroTemplate">
    <div class="centro-item border rounded p-2 mb-2">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <small class="fw-bold">Centro <span class="numero-centro">1</span></small>
            <button type="button" class="btn btn-sm btn-outline-danger remover-centro" title="Remover centro">
                <i class="fas fa-trash"></i>
            </button>
        </div>

        <div class="row g-2">
            <div class="col-md-6">
                <label class="form-label small">Centro <span class="text-danger">*</span></label>
                <select class="form-select form-select-sm centro-select" name="centro_curso[INDEX][centro_id]" required>
                    <option value="">Selecione um centro</option>
                    @foreach ($centros as $centro)
                        <option value="{{ $centro->id }}">{{ $centro->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Preço (€) <span class="text-danger">*</span></label>
                <input type="number" class="form-control form-control-sm" name="centro_curso[INDEX][preco]" placeholder="0.00" step="0.01" min="0" required>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Duração <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" name="centro_curso[INDEX][duracao]" placeholder="Ex: 40h" maxlength="100" required>
            </div>

            <div class="col-md-6">
                <label class="form-label small">Data de Arranque <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-sm" name="centro_curso[INDEX][data_arranque]" required>
            </div>
        </div>
    </div>
</template>

<template id="cronogramaTemplate">
    <div class="cronograma-item border rounded p-2 mb-2">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <small class="fw-bold">Cronograma <span class="numero-cronograma">1</span></small>
            <button type="button" class="btn btn-sm btn-outline-danger remover-cronograma" title="Remover cronograma">
                <i class="fas fa-trash"></i>
            </button>
        </div>

        <div class="row g-2">
            <div class="col-md-12">
                <label class="form-label small">Dias da Semana <span class="text-danger">*</span></label>
                <div class="dias-semana-checkboxes">
                    @foreach ($diasSemana as $dia)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input dia-checkbox" type="checkbox" name="cronogramas[INDEX][dia_semana][]" value="{{ $dia }}" id="dia_INDEX_{{ $dia }}">
                            <label class="form-check-label small" for="dia_INDEX_{{ $dia }}">
                                {{ substr($dia, 0, 3) }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label small">Período <span class="text-danger">*</span></label>
                <select class="form-select form-select-sm" name="cronogramas[INDEX][periodo]" required>
                    <option value="">Selecione</option>
                    @foreach ($periodos as $periodo)
                        <option value="{{ $periodo }}">{{ ucfirst($periodo) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label small">Hora Início (HH:MM)</label>
                <input type="time" class="form-control form-control-sm" name="cronogramas[INDEX][hora_inicio]">
            </div>

            <div class="col-md-4">
                <label class="form-label small">Hora Fim (HH:MM)</label>
                <input type="time" class="form-control form-control-sm" name="cronogramas[INDEX][hora_fim]">
            </div>
        </div>
    </div>
</template>

@endsection

@section('scripts')
<script>
// Verificar se Bootstrap está carregado
if (typeof bootstrap === 'undefined') {
    console.error('Bootstrap não foi carregado!');
    alert('Erro: Bootstrap não foi carregado. Recarregue a página.');
} else {
    console.log('Bootstrap carregado com sucesso');
}

let centroCount = 0;
let cronogramaCount = 0;

$(document).ready(function() {
    console.log('Document ready - inicializando cursos form');
    
    // Adicionar primeiro centro e cronograma
    adicionarCentro();
    adicionarCronograma();

    // Eventos
    $(document).on('click', '#adicionarCentroBtn', function(e) {
        e.preventDefault();
        adicionarCentro();
    });
    $(document).on('click', '#adicionarCronogramaBtn', function(e) {
        e.preventDefault();
        adicionarCronograma();
    });
    $(document).on('click', '.remover-centro', removerCentro);
    $(document).on('click', '.remover-cronograma', removerCronograma);

    // Handle form submit
    $('#cursoSetupForm').on('submit', function(e) {
        const $submitBtn = $('#submitBtn');
        const originalHtml = $submitBtn.html();
        
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
        if (!template) {
            console.error('Template centroTemplate não encontrado!');
            return;
        }
        
        // Converter template content para string
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

function adicionarCronograma() {
    try {
        const template = document.getElementById('cronogramaTemplate');
        if (!template) {
            console.error('Template cronogramaTemplate não encontrado!');
            return;
        }
        
        // Converter template content para string
        const tempDiv = document.createElement('div');
        const clone = template.content.cloneNode(true);
        tempDiv.appendChild(clone);
        
        let html = tempDiv.innerHTML
            .replace(/INDEX/g, cronogramaCount)
            .replace(/numero-cronograma">1</g, `numero-cronograma">${cronogramaCount + 1}<`);
        
        $('#cronogramasContainer').append('<div class="cronograma-wrapper-' + cronogramaCount + '">' + html + '</div>');
        cronogramaCount++;
        
        atualizarBotoesRemover();
    } catch(e) {
        console.error('Erro ao adicionar cronograma:', e);
    }
}

function removerCronograma(e) {
    e.preventDefault();
    $(this).closest('[class*="cronograma-wrapper-"]').remove();
    atualizarBotoesRemover();
}

function atualizarBotoesRemover() {
    // Desabilitar botão de remover centro se houver apenas um
    $('.remover-centro').prop('disabled', $('.centro-item').length <= 1);
    
    // Desabilitar botão de remover cronograma se houver apenas um
    $('.remover-cronograma').prop('disabled', $('.cronograma-item').length <= 1);
}
</script>
@endsection
