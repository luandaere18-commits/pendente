@extends('layouts.app')

@section('title', 'Formadores')

@section('content')

{{-- ============================================= --}}
{{-- HEADER                                        --}}
{{-- ============================================= --}}
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col-12 col-md-8 mb-3 mb-md-0">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                    <i class="fas fa-chalkboard-teacher text-primary fa-lg"></i>
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-0">Gestão de Formadores</h1>
                    <p class="text-muted mb-0 small">Gerir todos os formadores disponíveis no sistema</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovoFormador">
                <i class="fas fa-plus me-2"></i>Novo Formador
            </button>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- TABELA DE FORMADORES                          --}}
    {{-- ============================================= --}}
    <div class="card border-0 shadow-sm">
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
                            <th style="width:56px">Foto</th>
                            <th>Nome</th>
                            <th class="d-none d-md-table-cell">Email</th>
                            <th class="d-none d-lg-table-cell">Especialidade</th>
                            <th class="text-center" style="width:90px">Contactos</th>
                            <th class="text-center" style="width:80px">Turmas</th>
                            <th class="text-end pe-3" style="width:130px">Ações</th>
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
<div class="modal fade" id="modalVisualizarFormador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-user-tie text-primary"></i>
                    <h5 class="modal-title fw-semibold mb-0">Detalhes do Formador</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="conteudoVisualizarFormador">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="text-muted mt-3 mb-0">Carregando detalhes...</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Criar Novo Formador                   --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalNovoFormador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            {{-- Header --}}
            <div class="modal-header bg-light border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-user-plus text-primary"></i>
                    </div>
                    <h5 class="modal-title fw-semibold mb-0">Criar Novo Formador</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formNovoFormadorAjax" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">

                        {{-- COLUNA ESQUERDA --}}
                        <div class="col-12 col-md-6">
                            <div class="card border bg-light border-0 h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-id-card me-2"></i>Informações do Formador
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Nome <span class="text-danger">*</span></label>
                                        <input type="text" name="nome" class="form-control" placeholder="Nome completo" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="email@centro.ao">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Especialidade</label>
                                        <input type="text" name="especialidade" class="form-control" placeholder="Ex: Informática, Design...">
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">
                                            <i class="fas fa-camera me-1 text-muted"></i>Foto
                                        </label>
                                        <input type="file" name="foto" class="form-control form-control-sm" accept="image/*">
                                        <div class="form-text">JPEG, PNG, JPG, GIF (máx 2 MB)</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- COLUNA DIREITA --}}
                        <div class="col-12 col-md-6">
                            <div class="card border bg-light border-0 h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-address-book me-2"></i>Contactos e Biografia
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">
                                            <i class="fas fa-phone me-1 text-muted"></i>Contacto
                                        </label>
                                        <input type="text" name="contacto_telefone" class="form-control" placeholder="+244 900 000 000">
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">Biografia</label>
                                        <textarea name="bio" class="form-control" rows="7" placeholder="Breve descrição profissional..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="submit" form="formNovoFormadorAjax" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Salvar Formador
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL: Editar Formador                       --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalEditarFormador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            {{-- Header --}}
            <div class="modal-header bg-light border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-2 bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                        <i class="fas fa-user-edit text-warning"></i>
                    </div>
                    <h5 class="modal-title fw-semibold mb-0">Editar Formador</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">
                <form id="formEditarFormadorAjax">
                    @csrf
                    <input type="hidden" id="editFormadorId">
                    <div class="row g-4">

                        {{-- COLUNA ESQUERDA --}}
                        <div class="col-12 col-md-6">
                            <div class="card border bg-light border-0 h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-id-card me-2"></i>Informações do Formador
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Nome <span class="text-danger">*</span></label>
                                        <input type="text" id="editNome" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Email</label>
                                        <input type="email" id="editEmail" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">Especialidade</label>
                                        <input type="text" id="editEspecialidade" class="form-control">
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">
                                            <i class="fas fa-camera me-1 text-muted"></i>Foto (Nova)
                                        </label>
                                        <input type="file" id="editFoto" class="form-control form-control-sm" accept="image/*">
                                        <div class="form-text">Deixe em branco para manter a foto atual</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- COLUNA DIREITA --}}
                        <div class="col-12 col-md-6">
                            <div class="card border bg-light border-0 h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-address-book me-2"></i>Contactos e Biografia
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-medium small">
                                            <i class="fas fa-phone me-1 text-muted"></i>Contacto
                                        </label>
                                        <input type="text" id="editContactoTelefone" class="form-control" placeholder="+244 900 000 000">
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-medium small">Biografia</label>
                                        <textarea id="editBio" class="form-control" rows="7"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="submit" form="formEditarFormadorAjax" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Guardar Alterações
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    carregarFormadores();
});

/**
 * Carrega a lista de formadores via API
 */
function carregarFormadores() {
    $.ajax({
        url: '/api/formadores',
        method: 'GET',
        success: function(response) {
            // Suportar { data: [...] } ou array direto
            const data = Array.isArray(response) ? response : (response.data || []);
            let html = '';
            
            if (data.length === 0) {
                html = '<tr><td colspan="8" class="text-center text-muted py-5"><i class="fas fa-inbox me-2"></i>Nenhum formador encontrado</td></tr>';
            } else {
                data.forEach(function(formador) {
                    const foto = formador.foto_url 
                        ? `<img src="${formador.foto_url}" alt="${formador.nome}" class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">`
                        : '<div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:40px;"><i class="fas fa-user text-primary"></i></div>';
                    
                    const email = formador.email || '<span class="text-muted">—</span>';
                    const especialidade = formador.especialidade || '<span class="text-muted">—</span>';
                    
                    let contactos = '<span class="badge bg-secondary-subtle text-secondary">0</span>';
                    if (formador.contactos && Array.isArray(formador.contactos) && formador.contactos.length > 0) {
                        contactos = `<span class="badge bg-info-subtle text-info">${formador.contactos.length}</span>`;
                    }
                    
                    const turmas = formador.turmas ? formador.turmas.length : 0;
                    const turmasBadge = turmas > 0
                        ? `<span class="badge bg-success-subtle text-success">${turmas}</span>`
                        : '<span class="badge bg-secondary-subtle text-secondary">0</span>';
                    
                    html += `
                        <tr>
                            <td class="ps-3"><strong class="text-muted">#${formador.id}</strong></td>
                            <td>${foto}</td>
                            <td><strong>${formador.nome}</strong></td>
                            <td class="d-none d-md-table-cell"><small>${email}</small></td>
                            <td class="d-none d-lg-table-cell"><small>${especialidade}</small></td>
                            <td class="text-center">${contactos}</td>
                            <td class="text-center">${turmasBadge}</td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="visualizarFormador(${formador.id})" title="Visualizar"><i class="fas fa-eye"></i></button>
                                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="abrirEdicaoFormador(${formador.id})" title="Editar"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarFormador(${formador.id})" title="Eliminar"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }
            
            $('#formadoresTable tbody').html(html);
        },
        error: function(err) {
            console.error('Erro ao carregar formadores:', err);
            $('#formadoresTable tbody').html(
                '<tr><td colspan="8" class="text-center text-danger py-5"><i class="fas fa-exclamation-triangle me-2"></i>Erro ao carregar os dados</td></tr>'
            );
        }
    });
}

/**
 * Visualizar detalhes do formador
 */
window.visualizarFormador = function(id) {
    $.ajax({
        url: `/api/formadores/${id}`,
        method: 'GET',
        success: function(response) {
            const formador = response.data;
            let contactosHtml = '<span class="text-muted">Sem contactos</span>';
            
            if (formador.contactos && Array.isArray(formador.contactos) && formador.contactos.length > 0) {
                contactosHtml = formador.contactos.map(function(c) { 
                    let telefone = typeof c === 'string' ? c : (c.valor || c);
                    return `<span class="badge bg-info-subtle text-info me-1"><i class="fas fa-phone me-1"></i>${telefone}</span>`;
                }).join('');
            }
            
            const fotoHtml = formador.foto_url
                ? `<img src="${formador.foto_url}" class="rounded-3 shadow-sm" style="width:100%;max-width:180px;aspect-ratio:1;object-fit:cover;" alt="${formador.nome}">`
                : '<div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto" style="width:180px;height:180px;"><i class="fas fa-user text-primary fa-4x"></i></div>';
            
            const conteudo = `
                <div class="row g-4">
                    <div class="col-12 col-md-4 text-center">${fotoHtml}</div>
                    <div class="col-12 col-md-8">
                        <h5 class="fw-bold mb-3">${formador.nome}</h5>
                        <div class="row g-3">
                            <div class="col-12"><small class="text-muted d-block fw-medium"><i class="fas fa-envelope me-1"></i>Email</small><small>${formador.email || '—'}</small></div>
                            <div class="col-12"><small class="text-muted d-block fw-medium"><i class="fas fa-star me-1"></i>Especialidade</small><small>${formador.especialidade || '—'}</small></div>
                            <div class="col-12"><small class="text-muted d-block fw-medium mb-1"><i class="fas fa-phone me-1"></i>Contactos</small>${contactosHtml}</div>
                            <div class="col-12"><small class="text-muted d-block fw-medium"><i class="fas fa-align-left me-1"></i>Biografia</small><small>${formador.bio || '—'}</small></div>
                        </div>
                    </div>
                </div>
            `;
            
            $('#conteudoVisualizarFormador').html(conteudo);
            new bootstrap.Modal(document.getElementById('modalVisualizarFormador')).show();
        },
        error: function() {
            Swal.fire('Erro', 'Erro ao carregar detalhes', 'error');
        }
    });
};

/**
 * Abrir modal para editar formador
 */
window.abrirEdicaoFormador = function(id) {
    $.ajax({
        url: `/api/formadores/${id}`,
        method: 'GET',
        success: function(response) {
            const formador = response.data;
            $('#editFormadorId').val(formador.id);
            $('#editNome').val(formador.nome);
            $('#editEmail').val(formador.email || '');
            $('#editEspecialidade').val(formador.especialidade || '');
            $('#editBio').val(formador.bio || '');
            
            let primeroContacto = '';
            if (formador.contactos && Array.isArray(formador.contactos) && formador.contactos.length > 0) {
                primeroContacto = typeof formador.contactos[0] === 'string' ? formador.contactos[0] : (formador.contactos[0].valor || '');
            }
            $('#editContactoTelefone').val(primeroContacto);
            
            new bootstrap.Modal(document.getElementById('modalEditarFormador')).show();
        },
        error: function() {
            Swal.fire('Erro', 'Erro ao carregar dados', 'error');
        }
    });
};

/**
 * Criar novo formador
 */
$('#formNovoFormadorAjax').on('submit', function(e) {
    e.preventDefault();
    
    const telefone = $('input[name="contacto_telefone"]').val();
    
    $.ajax({
        url: "{{ route('api.formadores.store') }}",
        method: 'POST',
        data: JSON.stringify({
            nome: $('input[name="nome"]').val(),
            email: $('input[name="email"]').val(),
            especialidade: $('input[name="especialidade"]').val(),
            bio: $('textarea[name="bio"]').val(),
            contactos: telefone ? [telefone] : []
        }),
        contentType: 'application/json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() {
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

/**
 * Editar formador
 */
$('#formEditarFormadorAjax').on('submit', function(e) {
    e.preventDefault();
    
    const formadorId = $('#editFormadorId').val();
    const telefone = $('#editContactoTelefone').val();
    
    $.ajax({
        url: `/api/formadores/${formadorId}`,
        method: 'PUT',
        data: JSON.stringify({
            nome: $('#editNome').val(),
            email: $('#editEmail').val(),
            especialidade: $('#editEspecialidade').val(),
            bio: $('#editBio').val(),
            contactos: telefone ? [telefone] : []
        }),
        contentType: 'application/json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() {
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

/**
 * Eliminar formador
 */
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
                url: `/api/formadores/${id}`,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function() {
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
</script>
@endsection
