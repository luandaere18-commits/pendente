@extends('layouts.app')

@section('title', 'Editar Categoria')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-edit me-3 text-primary"></i>Editar Categoria
                    </h1>
                    <p class="text-muted">Atualizar informações da categoria</p>
                </div>
                <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">
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
                        <i class="fas fa-tags me-2"></i>Informações da Categoria
                    </h5>
                </div>
                <div class="card-body">
                    <form id="categoriaForm" method="POST" action="{{ route('categorias.update', $categoria->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="categoria_id" name="id" value="{{ $categoria->id }}">
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nome" class="form-label">Nome da Categoria <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" required maxlength="100" value="{{ $categoria->nome }}">
                                <div class="form-text">Máximo 100 caracteres</div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="tipo" class="form-label">Tipo <span class="text-danger">*</span></label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="">Selecione o tipo</option>
                                    <option value="loja" {{ $categoria->tipo == 'loja' ? 'selected' : '' }}>Loja</option>
                                    <option value="snack" {{ $categoria->tipo == 'snack' ? 'selected' : '' }}>Snack</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="ativo" class="form-label">Status</label>
                                <select class="form-select" id="ativo" name="ativo">
                                    <option value="1" {{ $categoria->ativo ? 'selected' : '' }}>Ativo</option>
                                    <option value="0" {{ !$categoria->ativo ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4" maxlength="1000">{{ $categoria->descricao }}</textarea>
                            <div class="form-text">Descrição detalhada da categoria (máximo 1000 caracteres)</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Atualizar Categoria
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
                <div class="card-body">
                    <p><strong>ID:</strong> {{ $categoria->id }}</p>
                    <p><strong>Data de Criação:</strong><br><small>{{ $categoria->created_at->format('d/m/Y H:i') }}</small></p>
                    <p><strong>Última Atualização:</strong><br><small>{{ $categoria->updated_at->format('d/m/Y H:i') }}</small></p>
                    <hr>
                    <h6 class="text-warning">Atenção:</h6>
                    <ul class="small">
                        <li>As alterações serão salvas imediatamente</li>
                        <li>Certifique-se de que todos os dados estão corretos</li>
                        <li>Categorias inativas não aparecerão nas listagens públicas</li>
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
const categoriaId = {{ $categoria->id ?? 'null' }};

$(document).ready(function() {
    // Os dados já estão carregados no formulário via Blade
    // Apenas inicializar o preview
    atualizarPreview();

    // Preview em tempo real
    $('#categoriaForm input, #categoriaForm select, #categoriaForm textarea').on('input change', function() {
        atualizarPreview();
    });

    // Submit do formulário - usando submit normal (não AJAX)
});

function atualizarPreview() {
    const nome = $('#nome').val();
    const tipo = $('#tipo').val();
    const ativo = $('#ativo').val();
    const descricao = $('#descricao').val();

    if (nome || tipo) {
        const statusBadge = ativo == '1' 
            ? '<span class="badge bg-success">Ativo</span>' 
            : '<span class="badge bg-secondary">Inativo</span>';
        
        const tipoBadge = tipo === 'loja' 
            ? '<span class="badge bg-info">Loja</span>' 
            : tipo === 'snack' 
                ? '<span class="badge bg-warning text-dark">Snack</span>' 
                : '';

        let preview = `
            <h6>${nome || 'Nome da Categoria'}</h6>
            <p class="mb-2">
                ${tipoBadge} ${statusBadge}
            </p>
            ${descricao ? `<p class="small text-muted">${descricao.substring(0, 100)}...</p>` : ''}
        `;

        $('#previewContent').html(preview);
        $('#previewCard').show();
    } else {
        $('#previewCard').hide();
    }
}
</script>
@endsection
