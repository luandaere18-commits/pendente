@extends('layouts.app')

@section('title', 'Editar Curso')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-edit me-3 text-primary"></i>Editar Curso
                    </h1>
                    <p class="text-muted">Atualizar informações do curso</p>
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
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-book me-2"></i>Informações do Curso
                    </h5>
                </div>
                <div class="card-body">
                    <form id="cursoForm" action="{{ route('cursos.update', $curso->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nome" class="form-label">Nome do Curso <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" value="{{ $curso->nome }}" required maxlength="100">
                                <div class="form-text">Máximo 100 caracteres</div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="area" class="form-label">Área <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="area" name="area" value="{{ $curso->area }}" required maxlength="100">
                                <div class="form-text">Ex: Informática, Gestão, etc.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modalidade" class="form-label">Modalidade <span class="text-danger">*</span></label>
                                <select class="form-select" id="modalidade" name="modalidade" required>
                                    <option value="">Selecione a modalidade</option>
                                    <option value="presencial" {{ $curso->modalidade === 'presencial' ? 'selected' : '' }}>Presencial</option>
                                    <option value="online" {{ $curso->modalidade === 'online' ? 'selected' : '' }}>Online</option>
                                    <option value="hibrido" {{ $curso->modalidade === 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="ativo" class="form-label">Status</label>
                                <select class="form-select" id="ativo" name="ativo">
                                    <option value="1" {{ $curso->ativo ? 'selected' : '' }}>Ativo</option>
                                    <option value="0" {{ !$curso->ativo ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="imagem_url" class="form-label">URL da Imagem</label>
                            <input type="url" class="form-control" id="imagem_url" name="imagem_url" value="{{ $curso->imagem_url }}" maxlength="255">
                            <div class="form-text">URL opcional para a imagem do curso</div>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4" maxlength="1000">{{ $curso->descricao }}</textarea>
                            <div class="form-text">Descrição detalhada do curso (máximo 1000 caracteres)</div>
                        </div>

                        <div class="mb-3">
                            <label for="programa" class="form-label">Programa do Curso</label>
                            <textarea class="form-control" id="programa" name="programa" rows="8" maxlength="5000">{{ $curso->programa }}</textarea>
                            <div class="form-text">Programa detalhado, módulos, objetivos, etc. (máximo 5000 caracteres)</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cursos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Atualizar Curso
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
                    <p><strong>ID:</strong> {{ $curso->id }}</p>
                    <p><strong>Data de Criação:</strong><br><small>{{ $curso->created_at->format('d/m/Y H:i') }}</small></p>
                    <p><strong>Última Atualização:</strong><br><small>{{ $curso->updated_at->format('d/m/Y H:i') }}</small></p>
                    
                    <hr>
                    
                    <h6 class="text-warning">Atenção:</h6>
                    <ul class="small">
                        <li>As alterações serão salvas imediatamente</li>
                        <li>Certifique-se de que todos os dados estão corretos</li>
                        <li>Cursos inativos não aparecerão nas listagens públicas</li>
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
$(document).ready(function() {
    // Configurar headers AJAX globalmente
    $.ajaxSetup({
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    const cursoId = {{ $curso->id ?? 'null' }};
    
    // Os dados já estão carregados no formulário via Blade
    // Apenas inicializar o preview
    atualizarPreview();

    // Preview em tempo real
    $('#cursoForm input, #cursoForm select, #cursoForm textarea').on('input change', function() {
        atualizarPreview();
    });

    // Submit do formulário - usando submit normal (não AJAX)
});

// Funções AJAX removidas - usando formulário normal

function atualizarPreview() {
    const nome = $('#nome').val();
    const area = $('#area').val();
    const modalidade = $('#modalidade').val();
    const ativo = $('#ativo').val();
    const imagem_url = $('#imagem_url').val();
    const descricao = $('#descricao').val();

    if (nome || area || modalidade) {
        const statusBadge = ativo == '1' 
            ? '<span class="badge bg-success">Ativo</span>' 
            : '<span class="badge bg-secondary">Inativo</span>';
        
        const modalidadeBadge = modalidade === 'online' 
            ? '<span class="badge bg-info">Online</span>' 
            : modalidade === 'presencial' 
                ? '<span class="badge bg-warning text-dark">Presencial</span>' 
                : '';
        
        const imagem = imagem_url 
            ? `<img src="${imagem_url}" alt="Preview" class="img-fluid rounded mb-2" style="max-height: 100px;" onerror="this.style.display='none'">` 
            : '';

        let preview = `
            <div class="text-center mb-2">${imagem}</div>
            <h6>${nome || 'Nome do Curso'}</h6>
            <p class="mb-1"><strong>Área:</strong> ${area || 'Não definida'}</p>
            <p class="mb-2">
                ${modalidadeBadge} ${statusBadge}
            </p>
            ${descricao ? `<p class="small text-muted">${descricao.substring(0, 100)}...</p>` : ''}
        `;

        $('#previewContent').html(preview);
        $('#previewCard').show();
    } else {
        $('#previewCard').hide();
    }
}

// Função atualizarCurso removida - usando formulário normal
</script>
@endsection
