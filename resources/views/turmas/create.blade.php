@extends('layouts.app')

@section('title', 'Nova Turma')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-plus me-3 text-primary"></i>Nova Turma
                    </h1>
                    <p class="text-muted">Criar uma nova turma no sistema</p>
                </div>
                <a href="{{ route('turmas.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Informações da Turma
                    </h5>
                </div>
                <div class="card-body">
                    <form id="turmaForm">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="curso_id" class="form-label">Curso <span class="text-danger">*</span></label>
                                <select class="form-select" id="curso_id" name="curso_id" required>
                                    <option value="">Selecione o curso</option>
                                </select>
                                <div class="form-text">Escolha o curso para esta turma</div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="centro_id" class="form-label">Centro <span class="text-danger">*</span></label>
                                <select class="form-select" id="centro_id" name="centro_id" required disabled>
                                    <option value="">Selecione um curso primeiro</option>
                                </select>
                                <div class="form-text">Ao escolher o curso, selecione o centro onde a turma será ministrada</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="formador_id" class="form-label">Formador</label>
                                <select class="form-select" id="formador_id" name="formador_id">
                                    <option value="">Selecione um formador (opcional)</option>
                                    @forelse($formadores as $formador)
                                        <option value="{{ $formador->id }}">{{ $formador->nome }}</option>
                                    @empty
                                        <option disabled>Nenhum formador disponível</option>
                                    @endforelse
                                </select>
                                <div class="form-text">Escolha o formador que leciona esta turma</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dia_semana" class="form-label">Dias da Semana <span class="text-danger">*</span></label>
                                <select class="form-select" id="dia_semana" name="dia_semana" multiple required>
                                    <option value="Segunda">Segunda-feira</option>
                                    <option value="Terça">Terça-feira</option>
                                    <option value="Quarta">Quarta-feira</option>
                                    <option value="Quinta">Quinta-feira</option>
                                    <option value="Sexta">Sexta-feira</option>
                                    <option value="Sábado">Sábado</option>
                                    <option value="Domingo">Domingo</option>
                                </select>
                                <div class="form-text">Selecione um ou mais dias da semana</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="periodo" class="form-label">Período <span class="text-danger">*</span></label>
                                <select class="form-select" id="periodo" name="periodo" required>
                                    <option value="">Selecione o período</option>
                                    <option value="manha">Manha</option>
                                    <option value="tarde">Tarde</option>
                                    <option value="noite">Noite</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="hora_inicio" class="form-label">Hora de Início <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                                <div class="form-text">Hora específica de início</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="hora_fim" class="form-label">Hora de Fim <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="hora_fim" name="hora_fim" required>
                                <div class="form-text">Hora específica de término</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="duracao_semanas" class="form-label">Duração (Semanas) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="duracao_semanas" name="duracao_semanas" min="1" max="52" required>
                                <div class="form-text">Número de semanas de duração da turma</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="data_arranque" class="form-label">Data de Arranque <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="data_arranque" name="data_arranque" required>
                                <div class="form-text">Data de início da turma</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="vagas_totais" class="form-label">Vagas Totais <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="vagas_totais" name="vagas_totais" min="1" required>
                                <div class="form-text">Número total de vagas disponíveis</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="planeada">Planeada</option>
                                    <option value="inscricoes_abertas">Inscrições Abertas</option>
                                    <option value="em_andamento">Em Andamento</option>
                                    <option value="concluida">Concluída</option>
                                </select>
                                <div class="form-text">Status atual da turma</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="publicado" name="publicado" value="1">
                                    <label class="form-check-label" for="publicado">
                                        Publicar Turma
                                    </label>
                                    <div class="form-text">Marque para tornar a turma visível para inscrições</div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info" id="turmaAlert" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span id="turmaAlertMessage"></span>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('turmas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Turma
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
                        <i class="fas fa-info-circle me-2"></i>Ajuda
                    </h6>
                </div>
                <div class="card-body">
                    <h6>Dicas para criar uma turma:</h6>
                    <ul class="small">
                        <li><strong>Curso:</strong> Selecione o curso que será ministrado</li>
                        <li><strong>Dias:</strong> Dias da semana das aulas (pode selecionar múltiplos)</li>
                        <li><strong>Período:</strong> Manha, tarde ou noite</li>
                        <li><strong>Horas:</strong> Especifique horários exatos de início e fim</li>
                        <li><strong>Duração:</strong> Número de semanas da turma</li>
                    </ul>
                    
                    <h6 class="mt-3">Períodos sugeridos:</h6>
                    <ul class="small">
                        <li><strong>Manha:</strong> 07:00 - 12:00</li>
                        <li><strong>Tarde:</strong> 12:00 - 18:00</li>
                        <li><strong>Noite:</strong> 18:00 - 22:00</li>
                    </ul>
                    
                    <h6 class="mt-3">Validação de Horários:</h6>
                    <ul class="small">
                        <li><strong>Manha:</strong> 07:00 até 11:59</li>
                        <li><strong>Tarde:</strong> 12:00 até 17:59</li>
                        <li><strong>Noite:</strong> 18:00 até 21:59</li>
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
    carregarCursos();
    
    // quando o curso mudar carregamos centros relacionados
    $('#curso_id').on('change', function() {
        const cursoId = $(this).val();
        carregarCentros(cursoId);
        atualizarPreview();
    });

        validarHorarios();
    });

    // Submit do formulário
    $('#turmaForm').on('submit', function(e) {
        e.preventDefault();
        if (validarHorarios()) {
            criarTurma();
        }
    });
});

function carregarCursos() {
    $.ajax({
        url: '/cursos',
        type: 'GET',
        dataType: 'json',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(data) {
            let options = '<option value="">Selecione o curso</option>';
            data.forEach(function(curso) {
                if (curso.ativo) {
                    options += `<option value="${curso.id}">${curso.nome} - ${curso.area}</option>`;
                }
            });
            $('#curso_id').html(options);
        },
        error: function(xhr) {
            console.error('Erro ao carregar cursos:', xhr);
            $('#curso_id').html('<option value="">Erro ao carregar cursos</option>');
        }
    });
}

function carregarCentros(cursoId, selectedCentro) {
    const $centroSelect = $('#centro_id');
    if (!cursoId) {
        $centroSelect.html('<option value="">Selecione um curso primeiro</option>')
            .prop('disabled', true);
        return;
    }

    $.ajax({
        url: `/cursos/${cursoId}`,
        type: 'GET',
        dataType: 'json',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            const curso = response.dados || response;
            let opts = '<option value="">Selecione um centro</option>';
            const centros = curso.centros || [];
            centros.forEach(function(c) {
                const preco = c.pivot && c.pivot.preco ? parseFloat(c.pivot.preco).toLocaleString('pt-PT', {minimumFractionDigits:2, maximumFractionDigits:2}) + ' Kz' : '';
                opts += `<option value="${c.id}" data-preco="${c.pivot ? c.pivot.preco : ''}"${selectedCentro==c.id ? ' selected' : ''}>${c.nome}${preco ? ' ('+preco+')' : ''}</option>`;
            });
            $centroSelect.html(opts).prop('disabled', false);
        },
        error: function(xhr) {
            console.error('Erro ao carregar centros:', xhr);
            $centroSelect.html('<option value="">Erro ao carregar centros</option>').prop('disabled', true);
        }
    });
}

// atualiza preview deve incluir centro/price
function atualizarPreview() {
    const cursoId = $('#curso_id').val();
    const centroId = $('#centro_id').val();
    const diasSelecionados = $('#dia_semana').val();
    const periodo = $('#periodo').val();
    const horaInicio = $('#hora_inicio').val();
    const horaFim = $('#hora_fim').val();
    const duracao = $('#duracao_semanas').val();

    if (cursoId || diasSelecionados || periodo) {
        const cursoNome = $('#curso_id option:selected').text();
        const centroText = centroId ? $('#centro_id option:selected').text() : '';

        const periodoBadge = getPeriodoBadge(periodo);
        const diasFormatados = diasSelecionados ? diasSelecionados.map(dia => getDiaFormatado(dia)).join(', ') : '';
        const horarios = (horaInicio && horaFim) 
            ? `<p class="mb-1"><i class="fas fa-clock me-1"></i> ${horaInicio} - ${horaFim}</p>`
            : '';

        let preview = `
            <div class="text-center mb-3">
                <h6><i class="fas fa-calendar-alt me-2"></i>Turma</h6>
            </div>
            
            ${cursoId ? `<p class="mb-2"><strong><i class="fas fa-book me-1"></i> Curso:</strong><br>${cursoNome}</p>` : ''}
            ${centroText ? `<p class="mb-2"><strong><i class="fas fa-building me-1"></i> Centro:</strong><br>${centroText}</p>` : ''}
            ${diasFormatados ? `<p class="mb-2"><strong><i class="fas fa-calendar-day me-1"></i> Dias:</strong><br>${diasFormatados}</p>` : ''}
            ${periodo ? `<p class="mb-2"><strong><i class="fas fa-sun me-1"></i> Período:</strong><br>${periodoBadge}</p>` : ''}
            ${duracao ? `<p class="mb-2"><strong><i class="fas fa-hourglass-half me-1"></i> Duração:</strong><br>${duracao} semana(s)</p>` : ''}
            ${horarios}
        `;

        $('#previewContent').html(preview);
        $('#previewCard').show();
    } else {
        $('#previewCard').hide();
    }
}

function validarHorarios() {
    const horaInicio = $('#hora_inicio').val();
    const horaFim = $('#hora_fim').val();
    const periodo = $('#periodo').val();
    const diasSelecionados = $('#dia_semana').val();
    
    $('#turmaAlert').hide();
    
    if (!diasSelecionados || diasSelecionados.length === 0) {
        $('#turmaAlertMessage').text('Selecione pelo menos um dia da semana.');
        $('#turmaAlert').removeClass('alert-info').addClass('alert-warning').show();
        return false;
    }
    
    if (horaInicio && horaFim) {
        if (horaFim <= horaInicio) {
            $('#turmaAlertMessage').text('A hora de fim deve ser posterior à hora de início.');
            $('#turmaAlert').removeClass('alert-info').addClass('alert-warning').show();
            return false;
        }
        
        // Calcular duração
        const inicio = new Date(`2000-01-01 ${horaInicio}`);
        const fim = new Date(`2000-01-01 ${horaFim}`);
        const duracao = (fim - inicio) / (1000 * 60); // minutos
        
        if (duracao < 30) {
            $('#turmaAlertMessage').text('A duração mínima recomendada é de 30 minutos.');
            $('#turmaAlert').removeClass('alert-warning').addClass('alert-info').show();
        } else if (duracao > 480) { // 8 horas
            $('#turmaAlertMessage').text('A duração é superior a 8 horas. Verifique se está correto.');
            $('#turmaAlert').removeClass('alert-warning').addClass('alert-info').show();
        }
        
        // Validar hora com base no período
        if (periodo) {
            const [inicioHora] = horaInicio.split(':');
            const validacoes = {
                'manha': { min: 7, max: 11 },
                'tarde': { min: 12, max: 17 },
                'noite': { min: 18, max: 21 }
            };
            
            if (validacoes[periodo]) {
                const hora = parseInt(inicioHora);
                if (hora < validacoes[periodo].min || hora > validacoes[periodo].max) {
                    const msg = `A hora de início para o período "${periodo}" deve estar entre ${String(validacoes[periodo].min).padStart(2, '0')}:00 e ${String(validacoes[periodo].max).padStart(2, '0')}:59`;
                    $('#turmaAlertMessage').text(msg);
                    $('#turmaAlert').removeClass('alert-info').addClass('alert-warning').show();
                    return false;
                }
            }
        }
    }
    
    return true;
}

function atualizarPreview() {
    const cursoId = $('#curso_id').val();
    const diasSelecionados = $('#dia_semana').val();
    const periodo = $('#periodo').val();
    const horaInicio = $('#hora_inicio').val();
    const horaFim = $('#hora_fim').val();
    const duracao = $('#duracao_semanas').val();

    if (cursoId || diasSelecionados || periodo) {
        const cursoNome = $('#curso_id option:selected').text();
        
        const periodoBadge = getPeriodoBadge(periodo);
        const diasFormatados = diasSelecionados ? diasSelecionados.map(dia => getDiaFormatado(dia)).join(', ') : '';
        
        const horarios = (horaInicio && horaFim) 
            ? `<p class="mb-1"><i class="fas fa-clock me-1"></i> ${horaInicio} - ${horaFim}</p>`
            : '';

        let preview = `
            <div class="text-center mb-3">
                <h6><i class="fas fa-calendar-alt me-2"></i>Turma</h6>
            </div>
            
            ${cursoId ? `<p class="mb-2"><strong><i class="fas fa-book me-1"></i> Curso:</strong><br>${cursoNome}</p>` : ''}
            ${diasFormatados ? `<p class="mb-2"><strong><i class="fas fa-calendar-day me-1"></i> Dias:</strong><br>${diasFormatados}</p>` : ''}
            ${periodo ? `<p class="mb-2"><strong><i class="fas fa-sun me-1"></i> Período:</strong><br>${periodoBadge}</p>` : ''}
            ${duracao ? `<p class="mb-2"><strong><i class="fas fa-hourglass-half me-1"></i> Duração:</strong><br>${duracao} semana(s)</p>` : ''}
            ${horarios}
        `;

        $('#previewContent').html(preview);
        $('#previewCard').show();
    } else {
        $('#previewCard').hide();
    }
}

function getPeriodoBadge(periodo) {
    switch(periodo) {
        case 'manha':
            return '<span class="badge bg-warning text-dark"><i class="fas fa-sun me-1"></i>Manha</span>';
        case 'tarde':
            return '<span class="badge bg-primary"><i class="fas fa-cloud-sun me-1"></i>Tarde</span>';
        case 'noite':
            return '<span class="badge bg-dark"><i class="fas fa-moon me-1"></i>Noite</span>';
        default:
            return '';
    }
}

function getDiaFormatado(dia) {
    const diasMap = {
        'Segunda': 'Seg',
        'Terça': 'Ter',
        'Quarta': 'Qua',
        'Quinta': 'Qui',
        'Sexta': 'Sex',
        'Sábado': 'Sab',
        'Domingo': 'Dom'
    };
    return diasMap[dia] || dia;
}

function criarTurma() {
    const formData = {
        curso_id: parseInt($('#curso_id').val()),
        centro_id: parseInt($('#centro_id').val()),
        formador_id: $('#formador_id').val() ? parseInt($('#formador_id').val()) : null,
        dia_semana: $('#dia_semana').val(),
        periodo: $('#periodo').val(),
        hora_inicio: $('#hora_inicio').val(),
        hora_fim: $('#hora_fim').val(),
        duracao_semanas: parseInt($('#duracao_semanas').val())
    };

    $.ajax({
        url: '/turmas',
        method: 'POST',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        beforeSend: function() {
            $('#turmaForm button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Guardando...');
        },
        success: function(response) {
            Swal.fire({
                title: 'Sucesso!',
                text: 'Turma criada com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '{{ route("turmas.index") }}';
            });
        },
        error: function(xhr) {
            let message = 'Ocorreu um erro ao criar a turma.';
            if (xhr.responseJSON && xhr.responseJSON.mensagem) {
                message = xhr.responseJSON.mensagem;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                message = Object.values(xhr.responseJSON.errors)[0][0];
            }
            
            Swal.fire({
                title: 'Erro!',
                text: message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
            
            $('#turmaForm button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Guardar Turma');
        }
    });
}
</script>
@endsection
