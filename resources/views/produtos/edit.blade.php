@extends('layouts.app')

@section('title', 'Editar Produto')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-edit me-3 text-primary"></i>Editar Produto
                    </h1>
                    <p class="text-muted">Atualizar informações do produto</p>
                </div>
                <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">
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
                        <i class="fas fa-box me-2"></i>Informações do Produto
                    </h5>
                </div>
                <div class="card-body">
                    <form id="produtoForm" method="POST" action="{{ route('produtos.update', $produto->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="produto_id" name="id" value="{{ $produto->id }}">
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nome" class="form-label">Nome do Produto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" required maxlength="100" value="{{ $produto->nome }}">
                                <div class="form-text">Máximo 100 caracteres</div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="preco" class="form-label">Preço (€) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="preco" name="preco" step="0.01" min="0" required value="{{ $produto->preco }}">
                                <div class="form-text">Ex: 12.50</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="categoria_id" class="form-label">Categoria <span class="text-danger">*</span></label>
                                <select class="form-select" id="categoria_id" name="categoria_id" required>
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categorias as $categoria)
                                        @if($categoria->ativo)
                                            <option value="{{ $categoria->id }}" {{ $produto->categoria_id == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nome }} ({{ $categoria->tipo }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="ativo" class="form-label">Status</label>
                                <select class="form-select" id="ativo" name="ativo">
                                    <option value="1" {{ $produto->ativo ? 'selected' : '' }}>Ativo</option>
                                    <option value="0" {{ !$produto->ativo ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="em_destaque" class="form-label">Em Destaque</label>
                                <select class="form-select" id="em_destaque" name="em_destaque">
                                    <option value="0" {{ !$produto->em_destaque ? 'selected' : '' }}>Não</option>
                                    <option value="1" {{ $produto->em_destaque ? 'selected' : '' }}>Sim</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="imagem_url" class="form-label">URL da Imagem</label>
                            <input type="url" class="form-control" id="imagem_url" name="imagem_url" maxlength="255" value="{{ $produto->imagem_url }}">
                            <div class="form-text">URL opcional para a imagem do produto</div>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4" maxlength="1000">{{ $produto->descricao }}</textarea>
                            <div class="form-text">Descrição detalhada do produto (máximo 1000 caracteres)</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('produtos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Atualizar Produto
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
                    <p><strong>ID:</strong> {{ $produto->id }}</p>
                    <p><strong>Data de Criação:</strong><br><small>{{ $produto->created_at->format('d/m/Y H:i') }}</small></p>
                    <p><strong>Última Atualização:</strong><br><small>{{ $produto->updated_at->format('d/m/Y H:i') }}</small></p>
                    @if($produto->categoria)
                        <p><strong>Categoria Atual:</strong><br><small>{{ $produto->categoria->nome }} ({{ $produto->categoria->tipo }})</small></p>
                    @endif
                    <hr>
                    <h6 class="text-warning">Atenção:</h6>
                    <ul class="small">
                        <li>As alterações serão salvas imediatamente</li>
                        <li>Certifique-se de que todos os dados estão corretos</li>
                        <li>Produtos inativos não aparecerão nas listagens públicas</li>
                        <li>Produtos em destaque aparecem em posição privilegiada</li>
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
const produtoId = {{ $produto->id ?? 'null' }};

$(document).ready(function() {
    // Os dados já estão carregados no formulário via Blade
    // Apenas inicializar o preview
    atualizarPreview();

    // Preview em tempo real
    $('#produtoForm input, #produtoForm select, #produtoForm textarea').on('input change', function() {
        atualizarPreview();
    });

    // Submit do formulário - usando submit normal (não AJAX)
});

function atualizarPreview() {
    const nome = $('#nome').val();
    const preco = $('#preco').val();
    const categoria_id = $('#categoria_id').val();
    const categoria_nome = $('#categoria_id option:selected').text();
    const ativo = $('#ativo').val();
    const em_destaque = $('#em_destaque').val();
    const imagem_url = $('#imagem_url').val();
    const descricao = $('#descricao').val();

    if (nome || preco) {
        const statusBadge = ativo == '1' 
            ? '<span class="badge bg-success">Ativo</span>' 
            : '<span class="badge bg-secondary">Inativo</span>';
        
        const destaqueBadge = em_destaque == '1' 
            ? '<span class="badge bg-warning text-dark">Em Destaque</span>' 
            : '<span class="badge bg-light text-dark">Normal</span>';
        
        const imagem = imagem_url 
            ? `<img src="${imagem_url}" alt="Preview" class="img-fluid rounded mb-2" style="max-height: 100px;" onerror="this.style.display='none'">` 
            : '';

        const precoFormatado = preco ? `€${parseFloat(preco).toFixed(2)}` : 'Preço não definido';

        let preview = `
            <div class="text-center mb-2">${imagem}</div>
            <h6>${nome || 'Nome do Produto'}</h6>
            <p class="mb-1"><strong>Preço:</strong> <span class="text-success">${precoFormatado}</span></p>
            <p class="mb-1"><strong>Categoria:</strong> ${categoria_id ? categoria_nome.split(' (')[0] : 'Não selecionada'}</p>
            <p class="mb-2">
                ${statusBadge} ${destaqueBadge}
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
