@extends('layouts.app')

@section('title', 'Centros')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-building me-3 text-primary"></i>Gestão de Centros
                    </h1>
                    <p class="text-muted">Gerir todos os centros de formação no sistema</p>
                </div>
                <a href="{{ route('centros.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Novo Centro
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Lista de Centros
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover data-table" id="centrosTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Localização</th>
                            <th>Email</th>
                            <th>Contactos</th>
                            <th>Data Criação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($centros as $centro)
                            <tr>
                                <td>{{ $centro->id }}</td>
                                <td><strong>{{ $centro->nome }}</strong></td>
                                <td>{{ $centro->localizacao }}</td>
                                <td>{{ $centro->email ?? 'Não definido' }}</td>
                                <td>
                                    @if($centro->contactos && is_array($centro->contactos))
                                        @foreach($centro->contactos as $contacto)
                                            <small class="d-block"><strong>Contacto:</strong> {{ $contacto }}</small>
                                        @endforeach
                                    @else
                                        <small class="text-muted">Não definido</small>
                                    @endif
                                </td>
                                <td>{{ $centro->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-info btn-sm" onclick="visualizarCentro({{ $centro->id }})" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('centros.edit', $centro->id) }}" class="btn btn-outline-warning btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarCentro({{ $centro->id }})" title="Deletar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Nenhum centro encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Visualização -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Detalhes do Centro
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewModalContent">
                <!-- Conteúdo será carregado via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Inicializar DataTable se necessário
    $('#centrosTable').DataTable({
        language: {
            url: '/js/datatables-pt.js'
        }
    });
});



/**
 * Visualiza os detalhes de um centro específico
 * @param {number} id - ID do centro
 */
function visualizarCentro(id) {
    $.ajax({
        url: `/api/centros/${id}`,
        method: 'GET',
        success: function(centro) {
            let contactosHtml = '';
            try {
                const contactosObj = typeof centro.contactos === 'string' ? JSON.parse(centro.contactos) : centro.contactos;
                if (contactosObj && typeof contactosObj === 'object') {
                    contactosHtml = Object.entries(contactosObj).map(([tipo, valor]) => 
                        `<p class="mb-1"><strong>${tipo}:</strong> ${valor}</p>`
                    ).join('');
                } else {
                    contactosHtml = '<p class="text-muted">Nenhum contacto definido</p>';
                }
            } catch (e) {
                contactosHtml = '<p class="text-muted">Formato de contactos inválido</p>';
            }
            
            let html = `
                <div class="row">
                    <div class="col-md-6">
                        <h4>${centro.nome}</h4>
                        <p class="mb-2"><strong>Localização:</strong> ${centro.localizacao}</p>
                        <p class="mb-2"><strong>Email:</strong> ${centro.email || 'Não definido'}</p>
                        <p class="mb-2"><strong>Data de Criação:</strong> ${new Date(centro.created_at).toLocaleDateString('pt-PT')}</p>
                    </div>
                    <div class="col-md-6">
                        <h6><strong>Contactos:</strong></h6>
                        <div class="bg-light p-3 rounded">
                            ${contactosHtml}
                        </div>
                    </div>
                </div>
            `;
            
            $('#viewModalContent').html(html);
            $('#viewModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Erro ao carregar detalhes do centro:', error);
            alert('Erro ao carregar os detalhes do centro.');
        }
    });
}

/**
 * Elimina um centro específico
 * @param {number} id - ID do centro a eliminar
 */
function eliminarCentro(id) {
    if (confirm('Tem certeza que deseja deletar este centro? Esta ação não pode ser desfeita.')) {
        // Criar um formulário para enviar a requisição DELETE
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/centros/${id}`;
        form.style.display = 'none';
        
        // Adicionar token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        
        // Adicionar método DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        // Adicionar ao body e submeter
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
