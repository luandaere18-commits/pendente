@extends('layouts.app')

@section('title', 'Formadores')

@section('content')

{{-- ============================================= --}}
{{-- HEADER                                        --}}
{{-- ============================================= --}}
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col-12 col-md-8 mb-2 mb-md-0">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <i class="fas fa-chalkboard-teacher text-primary fa-lg"></i>
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-0">Gestão de Formadores</h1>
                    <p class="text-muted mb-0 small">Gerir todos os formadores disponíveis no sistema</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modalNovoFormador">
                <i class="fas fa-plus me-2"></i>Novo Formador
            </button>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- TABELA DE FORMADORES                          --}}
    {{-- ============================================= --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-list text-primary"></i>
                <h5 class="mb-0 fw-semibold">Lista de Formadores</h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="formadoresTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="width:60px">ID</th>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Especialidade</th>
                            <th style="width:90px">Contactos</th>
                            <th style="width:80px" class="text-center">Turmas</th>
                            <th style="width:120px" class="text-end pe-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                                Carregando formadores...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Visualizar Detalhes do Formador       --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalVisualizarFormador" tabindex="-1" aria-labelledby="modalVisualizarFormadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-3">
            <div class="modal-header bg-primary text-white sticky-top">
                <h5 class="modal-title" id="modalVisualizarFormadorLabel">
                    <i class="fas fa-user-tie me-2"></i>Detalhes do Formador
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-4" id="conteudoVisualizarFormador">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Criar Novo Formador                   --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalNovoFormador" tabindex="-1" aria-labelledby="modalNovoFormadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-3">

            {{-- Header --}}
            <div class="modal-header bg-primary bg-opacity-10 border-0 py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-plus text-white small"></i>
                    </div>
                    <h5 class="modal-title fw-bold mb-0" id="modalNovoFormadorLabel">Criar Novo Formador</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formNovoFormadorAjax" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">

                        {{-- ====== COLUNA ESQUERDA ====== --}}
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100">
                                <div class="card-header bg-light border-bottom py-2 px-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-info-circle text-primary me-2"></i>Informações do Formador
                                    </h6>
                                </div>
                                <div class="card-body d-flex flex-column gap-3 p-3">

                                    {{-- Nome --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Nome <span class="text-danger">*</span></label>
                                        <input type="text" name="nome" class="form-control form-control-sm" placeholder="Ex: João Silva" required>
                                    </div>

                                    {{-- Email --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Email</label>
                                        <input type="email" name="email" class="form-control form-control-sm" placeholder="Ex: joao@centro.ao">
                                    </div>

                                    {{-- Especialidade --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Especialidade</label>
                                        <input type="text" name="especialidade" class="form-control form-control-sm" placeholder="Ex: Informática">
                                    </div>

                                    {{-- Foto --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">
                                            <i class="fas fa-image text-muted me-1"></i>Foto
                                        </label>
                                        <input type="file" name="foto_url" class="form-control form-control-sm" accept="image/jpeg,image/png,image/jpg,image/gif">
                                        <div class="form-text small">JPEG, PNG, JPG, GIF (máx 2 MB)</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ====== COLUNA DIREITA ====== --}}
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100">
                                <div class="card-header bg-light border-bottom py-2 px-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-file-alt text-primary me-2"></i>Contactos e Biografia
                                    </h6>
                                </div>
                                <div class="card-body d-flex flex-column gap-3 p-3">

                                    {{-- Contacto Telefone --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">
                                            <i class="fas fa-phone me-1"></i>Contacto
                                        </label>
                                        <input type="tel" name="contacto_telefone" class="form-control form-control-sm" placeholder="Ex: 923456789">
                                    </div>

                                    {{-- Biografia --}}
                                    <div class="flex-grow-1 d-flex flex-column">
                                        <label class="form-label fw-medium small mb-1">Biografia</label>
                                        <textarea name="bio" class="form-control form-control-sm flex-grow-1" rows="8" placeholder="Breve descrição do formador..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-light border-top py-3 px-4">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="submit" form="formNovoFormadorAjax" class="btn btn-primary btn-sm">
                    <i class="fas fa-save me-1"></i>Salvar Formador
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Editar Formador                       --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalEditarFormador" tabindex="-1" aria-labelledby="modalEditarFormadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-3">

            {{-- Header --}}
            <div class="modal-header bg-primary bg-opacity-10 border-0 py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-edit text-white small"></i>
                    </div>
                    <h5 class="modal-title fw-bold mb-0" id="modalEditarFormadorLabel">Editar Formador</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formEditarFormadorAjax" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="formador_id" id="editFormadorId">
                    <div class="row g-4">

                        {{-- ====== COLUNA ESQUERDA ====== --}}
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100">
                                <div class="card-header bg-light border-bottom py-2 px-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-info-circle text-primary me-2"></i>Informações do Formador
                                    </h6>
                                </div>
                                <div class="card-body d-flex flex-column gap-3 p-3">

                                    {{-- Nome --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Nome <span class="text-danger">*</span></label>
                                        <input type="text" name="edit_nome" id="editNome" class="form-control form-control-sm" required>
                                    </div>

                                    {{-- Email --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Email</label>
                                        <input type="email" name="edit_email" id="editEmail" class="form-control form-control-sm">
                                    </div>

                                    {{-- Especialidade --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">Especialidade</label>
                                        <input type="text" name="edit_especialidade" id="editEspecialidade" class="form-control form-control-sm">
                                    </div>

                                    {{-- Foto --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">
                                            <i class="fas fa-image text-muted me-1"></i>Foto (Nova)
                                        </label>
                                        <input type="file" name="edit_foto_url" class="form-control form-control-sm" accept="image/jpeg,image/png,image/jpg,image/gif">
                                        <div class="form-text small">Deixe em branco para manter a foto atual</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ====== COLUNA DIREITA ====== --}}
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100">
                                <div class="card-header bg-light border-bottom py-2 px-3">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-file-alt text-primary me-2"></i>Contactos e Biografia
                                    </h6>
                                </div>
                                <div class="card-body d-flex flex-column gap-3 p-3">

                                    {{-- Contacto Telefone --}}
                                    <div>
                                        <label class="form-label fw-medium small mb-1">
                                            <i class="fas fa-phone me-1"></i>Contacto
                                        </label>
                                        <input type="tel" name="edit_contacto_telefone" id="editContactoTelefone" class="form-control form-control-sm">
                                    </div>

                                    {{-- Biografia --}}
                                    <div class="flex-grow-1 d-flex flex-column">
                                        <label class="form-label fw-medium small mb-1">Biografia</label>
                                        <textarea name="edit_bio" id="editBio" class="form-control form-control-sm flex-grow-1" rows="8"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-light border-top py-3 px-4">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="submit" form="formEditarFormadorAjax" class="btn btn-primary btn-sm">
                    <i class="fas fa-save me-1"></i>Guardar Alterações
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let table = null;
    
    // Dados iniciais já carregados no servidor
    let formadoresIniciais = @json($formadores ?? []);

    // ===== Carregar Formadores =====
    function carregarFormadores() {
        console.log('Iniciando carregamento de formadores');
        $.ajax({
            url: '{{ route('api.formadores.index') }}',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('Resposta da API:', response);
                const data = response.data || [];
                console.log('Dados extraídos:', data);
                populateTable(data);
            },
            error: function(xhr) {
                console.error('Erro ao carregar formadores:', xhr);
                // Se houver erro, usa os dados iniciais
                if (formadoresIniciais.length > 0) {
                    console.log('Usando dados iniciais do servidor');
                    populateTable(formadoresIniciais);
                } else {
                    Swal.fire('Erro', 'Erro ao carregar formadores', 'error');
                }
            }
        });
    }

    // ===== Popular Tabela =====
    function populateTable(formadores) {
        console.log('populateTable chamada com:', formadores);
        
        if (table) {
            table.destroy();
        }

        const tbody = $('#formadoresTable tbody');
        tbody.empty();

        if (formadores.length === 0) {
            tbody.html('<tr><td colspan="8" class="text-center py-5 text-muted">Nenhum formador encontrado</td></tr>');
            return;
        }

        formadores.forEach(function(formador) {
            const foto = formador.foto_url ? `<img src="${formador.foto_url}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;" alt="${formador.nome}">` : `<div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width:40px;height:40px;"><i class="fas fa-user text-muted"></i></div>`;
            
            const contactos = formador.contactos && formador.contactos.length > 0 
                ? `<span class="badge bg-info">${formador.contactos.length}</span>` 
                : '<span class="badge bg-secondary">0</span>';
            
            const turmas = formador.turmas ? formador.turmas.length : 0;
            const turmasBadge = turmas > 0 
                ? `<span class="badge bg-success">${turmas}</span>` 
                : '<span class="badge bg-secondary">0</span>';

            const row = `
                <tr>
                    <td class="ps-3"><strong>#${formador.id}</strong></td>
                    <td>${foto}</td>
                    <td><strong>${formador.nome}</strong></td>
                    <td><small>${formador.email || '-'}</small></td>
                    <td><small>${formador.especialidade || '-'}</small></td>
                    <td>${contactos}</td>
                    <td class="text-center">${turmasBadge}</td>
                    <td class="text-end pe-3">
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-primary" onclick="visualizarFormador(${formador.id})" title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-outline-warning" onclick="abrirEdicaoFormador(${formador.id})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger" onclick="eliminarFormador(${formador.id})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });

        // Inicializar DataTable
        console.log('Inicializando DataTable com', formadores.length, 'formadores');
        table = $('#formadoresTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt_pt.json'
            },
            paging: true,
            searching: true,
            ordering: true,
            responsive: true,
            autoWidth: false,
            bDestroy: true,
            order: [[0, 'desc']]
        });
        console.log('DataTable inicializado:', table);
    }

    // ===== Visualizar Formador =====
    window.visualizarFormador = function(id) {
        $.ajax({
            url: `{{ route('api.formadores.show', ['formador' => ':id']) }}`.replace(':id', id),
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                const formador = response.data;
                let turmasHtml = '';

                if (formador.turmas && formador.turmas.length > 0) {
                    turmasHtml = '<div class="mt-3"><h6 class="fw-bold mb-2"><i class="fas fa-book me-2"></i>Turmas Associadas:</h6>';
                    turmasHtml += '<div class="list-group">';
                    formador.turmas.forEach(function(turma) {
                        turmasHtml += `
                            <div class="list-group-item py-2">
                                <small class="text-muted">
                                    <i class="fas fa-chalkboard me-1"></i>
                                    <strong>${turma.curso.nome}</strong> - ${turma.periodo || 'N/A'}
                                </small>
                            </div>
                        `;
                    });
                    turmasHtml += '</div></div>';
                } else {
                    turmasHtml = '<div class="alert alert-info alert-sm mt-3"><small>Sem turmas associadas</small></div>';
                }

                const contactosHtml = formador.contactos && formador.contactos.length > 0
                    ? formador.contactos.map(c => `<span class="badge bg-info"><i class="fas fa-phone me-1"></i>${c}</span>`).join(' ')
                    : '<span class="text-muted">Sem contactos</span>';

                const conteudo = `
                    <div class="row">
                        <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                            ${formador.foto_url 
                                ? `<img src="${formador.foto_url}" class="rounded-3" style="width:100%;max-width:200px;" alt="${formador.nome}">` 
                                : `<div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width:200px;height:200px;margin:0 auto;"><i class="fas fa-user text-muted fa-5x"></i></div>`
                            }
                        </div>
                        <div class="col-12 col-md-8">
                            <h5 class="fw-bold mb-3">${formador.nome}</h5>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1"><strong>Email:</strong></small>
                                <small>${formador.email || '-'}</small>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1"><strong>Especialidade:</strong></small>
                                <small>${formador.especialidade || '-'}</small>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1"><strong>Contactos:</strong></small>
                                ${contactosHtml}
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1"><strong>Biografia:</strong></small>
                                <small>${formador.bio || '-'}</small>
                            </div>
                        </div>
                    </div>
                    ${turmasHtml}
                `;

                $('#conteudoVisualizarFormador').html(conteudo);
                const modal = new bootstrap.Modal(document.getElementById('modalVisualizarFormador'));
                modal.show();
            },
            error: function(xhr) {
                console.error('Erro ao carregar detalhes do formador:', xhr);
                Swal.fire('Erro', 'Erro ao carregar detalhes do formador', 'error');
            }
        });
    };

    // ===== Abrir Modal Edição =====
    window.abrirEdicaoFormador = function(id) {
        $.ajax({
            url: `{{ route('api.formadores.show', ['formador' => ':id']) }}`.replace(':id', id),
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                const formador = response.data;
                $('#editFormadorId').val(formador.id);
                $('#editNome').val(formador.nome);
                $('#editEmail').val(formador.email || '');
                $('#editEspecialidade').val(formador.especialidade || '');
                $('#editBio').val(formador.bio || '');
                $('#editContactoTelefone').val(formador.contactos && formador.contactos[0] ? formador.contactos[0] : '');

                const modal = new bootstrap.Modal(document.getElementById('modalEditarFormador'));
                modal.show();
            },
            error: function(xhr) {
                console.error('Erro ao carregar dados do formador:', xhr);
                Swal.fire('Erro', 'Erro ao carregar dados do formador', 'error');
            }
        });
    };

    // ===== Criar Formador =====
    $('#formNovoFormadorAjax').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const telefone = formData.get('contacto_telefone');
        if (telefone) {
            formData.delete('contacto_telefone');
        }

        $.ajax({
            url: '{{ route('api.formadores.store') }}',
            method: 'POST',
            data: JSON.stringify({
                nome: formData.get('nome'),
                email: formData.get('email'),
                especialidade: formData.get('especialidade'),
                bio: formData.get('bio'),
                contactos: telefone ? [telefone] : []
            }),
            contentType: 'application/json',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire('Sucesso!', 'Formador criado com sucesso', 'success');
                bootstrap.Modal.getInstance(document.getElementById('modalNovoFormador')).hide();
                $('#formNovoFormadorAjax')[0].reset();
                carregarFormadores();
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                let mensagem = 'Erro ao criar formador';
                if (Object.keys(errors).length > 0) {
                    mensagem = Object.values(errors).flat().join(', ');
                }
                Swal.fire('Erro', mensagem, 'error');
            }
        });
    });

    // ===== Editar Formador =====
    $('#formEditarFormadorAjax').on('submit', function(e) {
        e.preventDefault();
        
        const formadorId = $('#editFormadorId').val();
        const telefone = $('#editContactoTelefone').val();

        $.ajax({
            url: `{{ route('api.formadores.update', ['formador' => ':id']) }}`.replace(':id', formadorId),
            method: 'PUT',
            data: JSON.stringify({
                nome: $('#editNome').val(),
                email: $('#editEmail').val(),
                especialidade: $('#editEspecialidade').val(),
                bio: $('#editBio').val(),
                contactos: telefone ? [telefone] : []
            }),
            contentType: 'application/json',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire('Sucesso!', 'Formador atualizado com sucesso', 'success');
                bootstrap.Modal.getInstance(document.getElementById('modalEditarFormador')).hide();
                carregarFormadores();
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                let mensagem = 'Erro ao atualizar formador';
                if (Object.keys(errors).length > 0) {
                    mensagem = Object.values(errors).flat().join(', ');
                }
                Swal.fire('Erro', mensagem, 'error');
            }
        });
    });

    // ===== Eliminar Formador =====
    window.eliminarFormador = function(id) {
        Swal.fire({
            title: 'Confirmar Eliminação',
            text: 'Tem a certeza que deseja eliminar este formador?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ route('api.formadores.destroy', ['formador' => ':id']) }}`.replace(':id', id),
                    method: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Eliminado!', 'Formador eliminado com sucesso', 'success');
                        carregarFormadores();
                    },
                    error: function() {
                        Swal.fire('Erro', 'Erro ao eliminar formador', 'error');
                    }
                });
            }
        });
    };

    // ===== Inicializar =====
    carregarFormadores();
});
</script>
@endpush
