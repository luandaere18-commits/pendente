@extends('layouts.public')

@section('title', 'Centro de Formação')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('site.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('site.centros') }}">Centros</a></li>
                <li class="breadcrumb-item active" id="breadcrumb-centro">...</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Centro Header -->
<section class="section bg-light" id="centro-header">
    <div class="container">
        <div class="loading text-center">
            <div class="spinner"></div>
            <p>Carregando informações do centro...</p>
        </div>
    </div>
</section>

<!-- Cursos Disponíveis -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3><i class="fas fa-book me-2 text-primary"></i>Cursos Disponíveis</h3>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" id="filtroArea" style="width: auto;">
                            <option value="">Todas as áreas</option>
                        </select>
                        <select class="form-select form-select-sm" id="filtroModalidade" style="width: auto;">
                            <option value="">Todas as modalidades</option>
                            <option value="presencial">Presencial</option>
                            <option value="online">Online</option>
                        </select>
                    </div>
                </div>
                
                <div id="cursos-container">
                    <div class="loading text-center">
                        <div class="spinner"></div>
                        <p>Carregando cursos...</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Informações do Centro -->
                <div class="card mb-4" id="info-centro">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações do Centro</h6>
                    </div>
                    <div class="card-body">
                        <div class="loading text-center py-3">
                            <div class="spinner"></div>
                        </div>
                    </div>
                </div>

                <!-- Formulário de Contacto Rápido -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-phone me-2"></i>Contacto Rápido</h6>
                    </div>
                    <div class="card-body">
                        <form id="contactoRapidoForm">
                            <input type="hidden" id="centro_contacto_id" name="centro_id">
                            <div class="mb-3">
                                <label class="form-label">Nome *</label>
                                <input type="text" class="form-control" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="tel" class="form-control" name="telefone">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mensagem *</label>
                                <textarea class="form-control" name="mensagem" rows="3" required placeholder="Gostaria de saber mais sobre..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-paper-plane me-2"></i>Enviar Mensagem
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal de Pré-Inscrição -->
<div class="modal fade" id="preInscricaoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Pré-Inscrição
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="preInscricaoForm">
                    <input type="hidden" id="modal_curso_id" name="curso_id">
                    <input type="hidden" id="modal_centro_id" name="centro_id">
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Curso:</strong> <span id="modal_curso_nome"></span><br>
                        <strong>Centro:</strong> <span id="modal_centro_nome"></span>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Nome Completo *</label>
                            <input type="text" class="form-control" name="nome_completo" required maxlength="100">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" maxlength="100">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Horário Preferido</label>
                        <select class="form-select" name="horario_id" id="modal_horarios">
                            <option value="">Selecionar horário (opcional)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Contactos *</label>
                        <div id="modal-contactos-container">
                            <div class="input-group mb-2">
                                <select class="form-select contacto-tipo" style="max-width: 130px;">
                                    <option value="telefone">Telefone</option>
                                    <option value="telemovel">Telemóvel</option>
                                    <option value="whatsapp">WhatsApp</option>
                                </select>
                                <input type="text" class="form-control contacto-valor" placeholder="Número" required>
                                <button type="button" class="btn btn-outline-success" onclick="adicionarContactoModal()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Observações</label>
                        <textarea class="form-control" name="observacoes" rows="3" maxlength="500" placeholder="Informações adicionais (opcional)"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="submeterPreInscricao()">
                    <i class="fas fa-paper-plane me-2"></i>Enviar Pré-Inscrição
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Sucesso -->
<div class="modal fade" id="sucessoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>Sucesso!
                </h5>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                <h5>Pré-Inscrição Enviada!</h5>
                <p class="text-muted">Recebemos a sua solicitação e entraremos em contacto em breve.</p>
                <p><strong>Referência:</strong> <span id="referenciaInscricao"></span></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let centroAtual = null;
let cursosDisponiveis = [];
let horariosDisponiveis = [];

$(document).ready(function() {
    const centroId = {{ $centro->id ?? 'null' }};
    
    if (centroId) {
        carregarCentro(centroId);
        carregarCursos(centroId);
        carregarHorarios(centroId);
    } else {
        window.location.href = '{{ route("site.centros") }}';
    }

    // Filtros
    $('#filtroArea, #filtroModalidade').on('change', filtrarCursos);
    
    // Formulário de contacto
    $('#contactoRapidoForm').on('submit', function(e) {
        e.preventDefault();
        enviarContacto();
    });
});

function carregarCentro(id) {
    $.get(`/api/centros/${id}`)
        .done(function(centro) {
            centroAtual = centro;
            exibirCentro(centro);
        })
        .fail(function() {
            $('#centro-header').html(`
                <div class="container text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h5>Centro não encontrado</h5>
                    <a href="{{ route('site.centros') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar aos Centros
                    </a>
                </div>
            `);
        });
}

function exibirCentro(centro) {
    // Header
    const headerHtml = `
        <div class="text-center">
            <h1 class="section-title">${centro.nome}</h1>
            <p class="section-subtitle">
                <i class="fas fa-map-marker-alt me-2"></i>${centro.localizacao}
            </p>
        </div>
    `;
    $('#centro-header').html(headerHtml);
    
    // Breadcrumb
    $('#breadcrumb-centro').text(centro.nome);
    
    // Info lateral
    let contactosHtml = '';
    
    if (centro.contactos) {
        try {
            // Laravel já converte para array automaticamente devido ao cast
            if (Array.isArray(centro.contactos)) {
                contactosHtml = centro.contactos.map((c, index) => {
                    // Se c é objeto com tipo e valor
                    if (typeof c === 'object' && c.tipo && c.valor) {
                        return `<p class="mb-1"><strong>${c.tipo}:</strong> ${c.valor}</p>`;
                    }
                    // Se c é apenas string (formato atual)
                    else if (typeof c === 'string') {
                        return `<p class="mb-1"><strong>Telefone ${index + 1}:</strong> ${c}</p>`;
                    }
                    return '';
                }).filter(item => item !== '').join('');
            }
            // Se não é array, tentar tratar como string
            else if (typeof centro.contactos === 'string') {
                contactosHtml = `<p class="mb-1"><strong>Contacto:</strong> ${centro.contactos}</p>`;
            }
        } catch (e) {
            console.error('Erro ao processar contactos:', e);
            console.log('Contactos originais:', centro.contactos);
            
            // Fallback mais seguro
            contactosHtml = `<p class="mb-1"><strong>Contacto:</strong> ${JSON.stringify(centro.contactos)}</p>`;
        }
    }
    
    const infoHtml = `
        <h6 class="text-primary">${centro.nome}</h6>
        <p class="mb-2">
            <i class="fas fa-map-marker-alt me-2 text-muted"></i>${centro.localizacao}
        </p>
        ${centro.email ? `
            <p class="mb-2">
                <i class="fas fa-envelope me-2 text-muted"></i>
                <a href="mailto:${centro.email}">${centro.email}</a>
            </p>
        ` : ''}
        ${contactosHtml ? `
            <hr>
            <h6 class="text-muted">Contactos:</h6>
            ${contactosHtml}
        ` : ''}
        <hr>
        <h6 class="text-muted">Horário:</h6>
        <p class="mb-1">Segunda - Sexta: 9h00 - 18h00</p>
        <p class="mb-1">Sábado: 9h00 - 13h00</p>
        <p class="mb-0">Domingo: Encerrado</p>
    `;
    $('#info-centro .card-body').html(infoHtml);
    
    // Set form
    $('#centro_contacto_id').val(centro.id);
}

function carregarCursos(centroId) {
    $.get(`/api/cursos?centro_id=${centroId}&ativo=1`, function(cursos) {
        // Os cursos já vêm filtrados pelo centro e apenas ativos
        cursosDisponiveis = cursos;
        
        // Preencher filtro de áreas
        const areas = [...new Set(cursosDisponiveis.map(curso => curso.area))];
        $('#filtroArea').html('<option value="">Todas as áreas</option>');
        areas.forEach(area => {
            $('#filtroArea').append(`<option value="${area}">${area}</option>`);
        });
        
        exibirCursos();
    }).fail(function() {
        $('#cursos-container').html(`
            <div class="text-center py-5">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h5>Erro ao carregar cursos</h5>
                <p class="text-muted">Tente novamente mais tarde.</p>
                <button class="btn btn-primary" onclick="carregarCursos(${centroId})">
                    <i class="fas fa-redo me-2"></i>Tentar Novamente
                </button>
            </div>
        `);
    });
}

function carregarHorarios(centroId) {
    $.get('/api/horarios', function(horarios) {
        horariosDisponiveis = horarios.filter(h => h.centro_id == centroId);
    });
}

function filtrarCursos() {
    exibirCursos();
}

function exibirCursos() {
    const areaFiltro = $('#filtroArea').val();
    const modalidadeFiltro = $('#filtroModalidade').val();
    
    let cursosFiltrados = cursosDisponiveis;
    
    if (areaFiltro) {
        cursosFiltrados = cursosFiltrados.filter(curso => curso.area === areaFiltro);
    }
    
    if (modalidadeFiltro) {
        cursosFiltrados = cursosFiltrados.filter(curso => curso.modalidade === modalidadeFiltro);
    }

    let html = '';
    
    if (cursosFiltrados.length === 0) {
        html = `
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h5>Nenhum curso encontrado</h5>
                <p class="text-muted">Tente ajustar os filtros ou entre em contacto connosco.</p>
                <button class="btn btn-primary" onclick="$('#filtroArea, #filtroModalidade').val(''); exibirCursos();">
                    <i class="fas fa-redo me-2"></i>Limpar Filtros
                </button>
            </div>
        `;
    } else {
        cursosFiltrados.forEach(curso => {
            const modalidadeBadge = curso.modalidade === 'online' 
                ? '<span class="badge bg-info">Online</span>' 
                : '<span class="badge bg-warning text-dark">Presencial</span>';
            
            const imagem = curso.imagem_url 
                ? `<img src="${curso.imagem_url}" alt="${curso.nome}" class="card-img-top">` 
                : `<div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                     <i class="fas fa-book fa-3x text-muted"></i>
                   </div>`;

            // Encontrar dados específicos deste centro
            const centroDados = curso.centros && curso.centros.find(c => c.id == centroAtual?.id);
            const precoInfo = centroDados?.pivot?.preco 
                ? `<p class="card-text"><strong>Preço:</strong> ${parseFloat(centroDados.pivot.preco).toLocaleString('pt-AO')} AOA</p>`
                : '';
            const duracaoInfo = centroDados?.pivot?.duracao 
                ? `<p class="card-text"><strong>Duração:</strong> ${centroDados.pivot.duracao}</p>`
                : '';
            const dataArranqueInfo = centroDados?.pivot?.data_arranque 
                ? `<p class="card-text"><strong>Início:</strong> ${new Date(centroDados.pivot.data_arranque).toLocaleDateString('pt-PT')}</p>`
                : '';

            html += `
                <div class="card mb-4">
                    <div class="row g-0">
                        <div class="col-md-4">
                            ${imagem}
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title">${curso.nome || 'Nome não disponível'}</h5>
                                    ${modalidadeBadge}
                                </div>
                                <p class="card-text">
                                    <strong>Área:</strong> ${curso.area || 'Não especificada'}
                                </p>
                                ${precoInfo}
                                ${duracaoInfo}
                                ${dataArranqueInfo}
                                ${curso.descricao ? `
                                    <p class="card-text text-muted">${curso.descricao}</p>
                                ` : ''}
                                ${curso.programa ? `
                                    <details class="mb-3">
                                        <summary class="text-primary" style="cursor: pointer;">Ver programa do curso</summary>
                                        <div class="mt-2 p-3 bg-light rounded">
                                            <pre style="white-space: pre-wrap; font-family: inherit; margin: 0;">${curso.programa}</pre>
                                        </div>
                                    </details>
                                ` : ''}
                                <button class="btn btn-primary" onclick="abrirPreInscricao(${curso.id}, '${(curso.nome || 'Curso').replace(/'/g, '\\&apos;')}')">
                                    <i class="fas fa-user-plus me-2"></i>Fazer Pré-Inscrição
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    }
    
    $('#cursos-container').html(html);
}

function abrirPreInscricao(cursoId, cursoNome) {
    if (!centroAtual) {
        alert('Erro: Informações do centro não carregadas. Recarregue a página.');
        return;
    }
    
    $('#modal_curso_id').val(cursoId || '');
    $('#modal_centro_id').val(centroAtual.id || '');
    $('#modal_curso_nome').text(cursoNome || 'Curso');
    $('#modal_centro_nome').text(centroAtual.nome || 'Centro');
    
    // Carregar horários para este curso
    const horariosEste = horariosDisponiveis.filter(h => h.curso_id == cursoId);
    let horariosHtml = '<option value="">Selecionar horário (opcional)</option>';
    
    horariosEste.forEach(horario => {
        const horaTexto = horario.hora_inicio && horario.hora_fim 
            ? ` (${horario.hora_inicio} - ${horario.hora_fim})`
            : '';
        horariosHtml += `<option value="${horario.id}">${horario.dia_semana} - ${horario.periodo}${horaTexto}</option>`;
    });
    
    $('#modal_horarios').html(horariosHtml);
    
    // Limpar form
    $('#preInscricaoForm')[0].reset();
    $('#modal-contactos-container').html(`
        <div class="input-group mb-2">
            <select class="form-select contacto-tipo" style="max-width: 130px;">
                <option value="telefone">Telefone</option>
                <option value="telemovel">Telemóvel</option>
                <option value="whatsapp">WhatsApp</option>
            </select>
            <input type="text" class="form-control contacto-valor" placeholder="Número" required>
            <button type="button" class="btn btn-outline-success" onclick="adicionarContactoModal()">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    `);
    
    $('#preInscricaoModal').modal('show');
}

function adicionarContactoModal() {
    const novoContacto = `
        <div class="input-group mb-2">
            <select class="form-select contacto-tipo" style="max-width: 130px;">
                <option value="telefone">Telefone</option>
                <option value="telemovel">Telemóvel</option>
                <option value="whatsapp">WhatsApp</option>
            </select>
            <input type="text" class="form-control contacto-valor" placeholder="Número" required>
            <button type="button" class="btn btn-outline-danger" onclick="$(this).closest('.input-group').remove()">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    $('#modal-contactos-container').append(novoContacto);
}

function submeterPreInscricao() {
    const contactos = [];
    $('#modal-contactos-container .input-group').each(function() {
        const tipo = $(this).find('.contacto-tipo').val();
        const valor = $(this).find('.contacto-valor').val();
        if (valor && valor.trim()) {
            contactos.push({ tipo, valor: valor.trim() });
        }
    });

    if (contactos.length === 0) {
        alert('Adicione pelo menos um contacto.');
        return;
    }

    const nomeCompleto = $('input[name="nome_completo"]').val();
    if (!nomeCompleto || !nomeCompleto.trim()) {
        alert('Nome completo é obrigatório.');
        return;
    }

    const cursoId = $('#modal_curso_id').val();
    const centroId = $('#modal_centro_id').val();
    
    if (!cursoId || !centroId) {
        alert('Erro: Dados do curso ou centro não encontrados.');
        return;
    }

    const dados = {
        curso_id: parseInt(cursoId),
        centro_id: parseInt(centroId),
        horario_id: $('#modal_horarios').val() ? parseInt($('#modal_horarios').val()) : null,
        nome_completo: nomeCompleto.trim(),
        email: $('input[name="email"]').val()?.trim() || null,
        contactos: JSON.stringify(contactos),
        observacoes: $('textarea[name="observacoes"]').val()?.trim() || null
    };

    console.log('Dados a enviar:', dados);

    $.ajax({
        url: '/api/pre-inscricoes',
        method: 'POST',
        data: JSON.stringify(dados),
        contentType: 'application/json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            $('#preInscricaoModal').modal('hide');
            // A resposta pode ter o ID diretamente ou dentro de 'dados'
            const inscricaoId = response.dados?.id || response.id || 'N/A';
            $('#referenciaInscricao').text(`#${inscricaoId}`);
            $('#sucessoModal').modal('show');
        },
        error: function(xhr) {
            console.error('Erro na pré-inscrição:', xhr);
            console.error('Response:', xhr.responseJSON);
            console.error('Status:', xhr.status);
            console.error('Status Text:', xhr.statusText);
            
            let mensagem = 'Erro ao enviar pré-inscrição. Tente novamente.';
            
            if (xhr.responseJSON && xhr.responseJSON.mensagem) {
                mensagem = xhr.responseJSON.mensagem;
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                mensagem = xhr.responseJSON.message;
            } else if (xhr.status === 422) {
                mensagem = 'Dados inválidos. Verifique os campos preenchidos.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    mensagem += '\n\nDetalhes:\n' + errors.join('\n');
                }
            } else if (xhr.status === 404) {
                mensagem = 'Dados do curso ou centro não encontrados.';
            } else if (xhr.status === 500) {
                mensagem = 'Erro interno do servidor. Tente novamente mais tarde.';
            }
            
            alert(mensagem);
        }
    });
}

function enviarContacto() {
    // Simulação de envio de contacto
    alert('Mensagem enviada! Entraremos em contacto em breve.');
    $('#contactoRapidoForm')[0].reset();
}
</script>
@endsection
