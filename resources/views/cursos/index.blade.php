@extends('layouts.app')

@section('title', 'Cursos')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-book me-3 text-primary"></i>Gestão de Cursos
                    </h1>
                    <p class="text-muted">Gerir todos os cursos disponíveis no sistema</p>
                </div>
                <a href="{{ route('cursos.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Novo Curso
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Lista de Cursos
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover data-table" id="cursosTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Modalidade</th>
                            <th>Centro</th>
                            <th>Preço</th>
                            <th>Data Arranque</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center">
                                <i class="fas fa-spinner fa-spin me-2"></i>Carregando cursos...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    carregarCursos();
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
            html = '<tr><td colspan="8" class="text-center text-muted">Nenhum curso encontrado</td></tr>';
        } else {
            data.forEach(function(curso) {
                const statusBadge = curso.ativo 
                    ? '<span class="badge bg-success">Ativo</span>' 
                    : '<span class="badge bg-secondary">Inativo</span>';
                
                const modalidadeBadge = curso.modalidade === 'online' 
                    ? '<span class="badge bg-info">Online</span>' 
                    : curso.modalidade === 'presencial'
                    ? '<span class="badge bg-warning text-dark">Presencial</span>'
                    : '<span class="badge bg-primary">Híbrido</span>';
                
                // Extrair informações do primeiro centro
                let centroCells = '';
                if (curso.centros && curso.centros.length > 0) {
                    const centro = curso.centros[0];
                    const preco = centro.pivot.preco;
                    const dataArranque = new Date(centro.pivot.data_arranque).toLocaleDateString('pt-PT');
                    centroCells = `<td>${centro.nome}</td><td>${parseFloat(preco).toLocaleString('pt-PT', {minimumFractionDigits: 2, maximumFractionDigits: 2})} Kz</td><td>${dataArranque}</td>`;
                } else {
                    centroCells = `<td class="text-muted"><i class="fas fa-times"></i> N/A</td><td class="text-muted">N/A</td><td class="text-muted">N/A</td>`;
                }
                
                html += `
                    <tr>
                        <td>${curso.id}</td>
                        <td>
                            <strong>${curso.nome}</strong>
                            ${curso.descricao ? `<br><small class="text-muted">${curso.descricao.substring(0, 50)}...</small>` : ''}
                        </td>
                        <td>${modalidadeBadge}</td>
                        ${centroCells}
                        <td>${statusBadge}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/cursos/${curso.id}" class="btn btn-sm btn-outline-primary" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="/cursos/${curso.id}/edit" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarCurso(${curso.id})" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }
        
        $('#cursosTable tbody').html(html);
        
        // Reinicializar DataTable se já existir
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
            $('#cursosTable tbody').html('<tr><td colspan="8" class="text-center text-danger">Erro ao carregar os dados</td></tr>');
        }
    });
}

/**
 * Elimina um curso específico
 * @param {number} id - ID do curso a eliminar
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
                    Swal.fire(
                        'Eliminado!',
                        'O curso foi eliminado com sucesso.',
                        'success'
                    );
                    carregarCursos();
                },
                error: function(xhr) {
                    console.error('Erro ao eliminar curso:', xhr);
                    Swal.fire(
                        'Erro!',
                        'Ocorreu um erro ao eliminar o curso.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>
@endsection
