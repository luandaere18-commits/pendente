@extends('layouts.app')

@section('title', 'Gerenciar Turma - ' . $turma->curso->nome)

@section('content')
<div class="container-fluid py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('turmas.index') }}"><i class="fas fa-clock me-1"></i>Turmas</a></li>
            <li class="breadcrumb-item active">{{ $turma->curso->nome }}</li>
        </ol>
    </nav>

    {{-- ============================================= --}}
    {{-- CARD PRINCIPAL - Informações da Turma        --}}
    {{-- ============================================= --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-start">

                {{-- Info principal --}}
                <div class="col-md-9">
                    <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                        <h3 class="fw-bold mb-0">{{ $turma->curso->nome }}</h3>
                        @php
                            $statusBadges = [
                                'planeada' => 'bg-secondary',
                                'inscricoes_abertas' => 'bg-success',
                                'em_andamento' => 'bg-info',
                                'concluida' => 'bg-secondary'
                            ];
                            $statusNomes = [
                                'planeada' => 'Planeada',
                                'inscricoes_abertas' => 'Inscrições Abertas',
                                'em_andamento' => 'Em Andamento',
                                'concluida' => 'Concluída'
                            ];
                        @endphp
                        <span class="badge {{ $statusBadges[$turma->status] ?? 'bg-secondary' }}">
                            <i class="fas fa-info-circle me-1"></i>{{ $statusNomes[$turma->status] ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="row g-3 mb-2">
                        <div class="col-md-4">
                            <p class="mb-1"><strong><i class="fas fa-calendar me-1"></i>Dias:</strong></p>
                            <p class="text-muted">
                                @if($turma->dia_semana && is_array($turma->dia_semana))
                                    {{ implode(', ', $turma->dia_semana) }}
                                @else
                                    {{ $turma->dia_semana ?? 'N/A' }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong><i class="fas fa-sun me-1"></i>Período:</strong></p>
                            <p class="text-muted">{{ ucfirst(str_replace('manhã', 'Manhã', str_replace('tarde', 'Tarde', str_replace('noite', 'Noite', $turma->periodo)))) }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong><i class="fas fa-clock me-1"></i>Horário:</strong></p>
                            <p class="text-muted">
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $turma->hora_inicio)->format('H:i') }} - 
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $turma->hora_fim)->format('H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <p class="mb-1"><strong><i class="fas fa-user me-1"></i>Formador:</strong></p>
                            <p class="text-muted">
                                @if($turma->formador)
                                    <span class="badge bg-light text-dark">{{ $turma->formador->nome }}</span>
                                @else
                                    <span class="text-muted">Não atribuído</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong><i class="fas fa-hourglass-half me-1"></i>Duração:</strong></p>
                            <p class="text-muted">{{ $turma->duracao_semanas ?? 'N/A' }} semana(s)</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong><i class="fas fa-calendar-check me-1"></i>Data Arranque:</strong></p>
                            <p class="text-muted">{{ \Carbon\Carbon::parse($turma->data_arranque)->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <p class="mb-1"><strong><i class="fas fa-users me-1"></i>Vagas:</strong></p>
                            <p class="text-muted">
                                @if($turma->vagas_totais)
                                    <span class="badge bg-info">{{ $turma->vagas_totais - $turma->vagas_preenchidas }}/{{ $turma->vagas_totais }}</span> 
                                    ({{ $turma->vagas_preenchidas }} preenchidas)
                                @else
                                    <span class="text-muted">Sem limite</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong><i class="fas fa-globe me-1"></i>Visibilidade:</strong></p>
                            <p class="text-muted">
                                @if($turma->publicado)
                                    <span class="badge bg-success"><i class="fas fa-eye me-1"></i>Público</span>
                                @else
                                    <span class="badge bg-secondary"><i class="fas fa-eye-slash me-1"></i>Privado</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    </div>
                </div>

                {{-- Ações + Contadores --}}
                <div class="col-md-3">
                    {{-- Botões de ação --}}
                    <div class="d-flex gap-2 mb-3 justify-content-md-end flex-wrap">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditarTurma">
                            <i class="fas fa-edit me-1"></i>Editar
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="eliminarTurmaShow({{ $turma->id }})">
                            <i class="fas fa-trash me-1"></i>Eliminar
                        </button>
                        <a href="{{ route('turmas.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Voltar
                        </a>
                    </div>

                    {{-- Mini contadores --}}
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="bg-warning-subtle rounded p-2 text-center">
                                <div class="fw-bold text-warning fs-5" id="contagemInscricoes">{{ $turma->preInscricoes->count() }}</div>
                                <small class="text-muted"><i class="fas fa-user-plus me-1"></i>Pré-inscrições</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- ABA: PRÉ-INSCRIÇÕES                          --}}
    {{-- ============================================= --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0"><i class="fas fa-user-plus me-2 text-warning"></i>Pré-inscrições Ligadas a Esta Turma</h5>
                <span class="badge bg-warning text-dark fs-6">{{ $turma->preInscricoes->count() }}</span>
            </div>
        </div>

        <div class="card-body p-4">
            @if($turma->preInscricoes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user me-1 text-muted"></i>Nome</th>
                                <th><i class="fas fa-envelope me-1 text-muted"></i>Email</th>
                                <th><i class="fas fa-phone me-1 text-muted"></i>Telefone</th>
                                <th><i class="fas fa-calendar me-1 text-muted"></i>Data</th>
                                <th><i class="fas fa-info-circle me-1 text-muted"></i>Status</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($turma->preInscricoes as $inscricao)
                                <tr class="row-inscricao" data-status="{{ $inscricao->status }}">
                                    <td><strong>{{ $inscricao->nome_completo ?? $inscricao->nome }}</strong></td>
                                    <td><a href="mailto:{{ $inscricao->email }}" class="text-decoration-none">{{ $inscricao->email }}</a></td>
                                    <td>
                                        @if($inscricao->telefone ?? ($inscricao->contactos['telefone'] ?? null))
                                            <a href="tel:{{ $inscricao->telefone ?? $inscricao->contactos['telefone'] }}" class="text-decoration-none">{{ $inscricao->telefone ?? $inscricao->contactos['telefone'] }}</a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($inscricao->created_at)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($inscricao->status === 'pendente')
                                            <span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half me-1"></i>Pendente</span>
                                        @elseif($inscricao->status === 'confirmado')
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Confirmado</span>
                                        @elseif($inscricao->status === 'cancelado')
                                            <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Cancelado</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($inscricao->status === 'pendente')
                                            <button class="btn btn-sm btn-outline-success me-1 btn-aceitar-inscricao"
                                                    data-inscricao-id="{{ $inscricao->id }}"
                                                    type="button"
                                                    title="Aceitar">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-rejeitar-inscricao"
                                                    data-inscricao-id="{{ $inscricao->id }}"
                                                    type="button"
                                                    title="Rejeitar">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-user-plus fa-3x mb-3 opacity-25"></i>
                    <p class="mb-0">Nenhuma pré-inscrição ligada a esta turma.</p>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- ============================================= --}}
{{-- MODAL: Editar Turma                           --}}
{{-- ============================================= --}}
<div class="modal fade" id="modalEditarTurma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-edit text-primary"></i>
                    <h5 class="modal-title fw-semibold mb-0">Editar Turma</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditarTurmaShow">
                    @csrf
                    <input type="hidden" id="turmaIdShow" value="{{ $turma->id }}">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Período</label>
                            <select id="periodoShow" class="form-select" required>
                                <option value="manhã" {{ $turma->periodo === 'manhã' ? 'selected' : '' }}>Manhã</option>
                                <option value="tarde" {{ $turma->periodo === 'tarde' ? 'selected' : '' }}>Tarde</option>
                                <option value="noite" {{ $turma->periodo === 'noite' ? 'selected' : '' }}>Noite</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Status</label>
                            <select id="statusShow" class="form-select" required>
                                <option value="planeada" {{ $turma->status === 'planeada' ? 'selected' : '' }}>Planeada</option>
                                <option value="inscricoes_abertas" {{ $turma->status === 'inscricoes_abertas' ? 'selected' : '' }}>Inscrições Abertas</option>
                                <option value="em_andamento" {{ $turma->status === 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                                <option value="concluida" {{ $turma->status === 'concluida' ? 'selected' : '' }}>Concluída</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Hora Início</label>
                            <input type="time" id="horaInicioShow" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $turma->hora_inicio)->format('H:i') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Hora Fim</label>
                            <input type="time" id="horaFimShow" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $turma->hora_fim)->format('H:i') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Duração (Semanas)</label>
                            <input type="number" id="duracaoShow" value="{{ $turma->duracao_semanas }}" min="1" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Data Arranque</label>
                            <input type="date" id="dataArranqueShow" value="{{ $turma->data_arranque }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Formador</label>
                            <select id="formadorIdShow" class="form-select">
                                <option value="">Selecione (opcional)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Vagas Disponíveis</label>
                            <input type="number" id="vagasTotaisShow" value="{{ $turma->vagas_totais }}" min="1" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="publicadoShow" {{ $turma->publicado ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium" for="publicadoShow">
                                    <i class="fas fa-globe me-1 text-info"></i>Publicar no site
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="fw-semibold mb-3">Dias da Semana</h6>
                        <div class="row g-2">
                            @foreach(['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'] as $dia)
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input dia-semana-show" type="checkbox" value="{{ $dia }}" id="dia_{{ $dia }}_show">
                                        <label class="form-check-label" for="dia_{{ $dia }}_show">{{ $dia }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarTurmaShow" class="btn btn-primary">Guardar Alterações</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    carregarFormadores();
    preencherDiasSemana();
    configurarFormulario();
});

// Carregar formadores
function carregarFormadores() {
    $.ajax({
        url: '/api/formadores',
        method: 'GET',
        success: function(data) {
            const select = $('#formadorIdShow');
            select.append('<option value="">Sem formador</option>');
            data.forEach(f => {
                const selected = f.id === {{ $turma->formador_id ?? 'null' }} ? 'selected' : '';
                select.append(`<option value="${f.id}" ${selected}>${f.nome}</option>`);
            });
        }
    });
}

// Preencher dias da semana
function preencherDiasSemana() {
    const dias = {!! json_encode($turma->dia_semana ?? []) !!};
    dias.forEach(dia => {
        $(`#dia_${dia}_show`).prop('checked', true);
    });
}

// Configurar envio do formulário
function configurarFormulario() {
    $('#formEditarTurmaShow').on('submit', function(e) {
        e.preventDefault();
        const dias = [];
        $('.dia-semana-show:checked').each(function() {
            dias.push($(this).val());
        });

        if (dias.length === 0) {
            Swal.fire('Aviso', 'Selecione pelo menos um dia', 'warning');
            return;
        }

        const dados = {
            periodo: $('#periodoShow').val(),
            status: $('#statusShow').val(),
            hora_inicio: $('#horaInicioShow').val(),
            hora_fim: $('#horaFimShow').val(),
            duracao_semanas: $('#duracaoShow').val(),
            data_arranque: $('#dataArranqueShow').val(),
            formador_id: $('#formadorIdShow').val() || null,
            vagas_totais: $('#vagasTotaisShow').val() || null,
            publicado: $('#publicadoShow').is(':checked'),
            dia_semana: dias
        };

        $.ajax({
            url: `/api/turmas/{{ $turma->id }}`,
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(dados),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function() {
                Swal.fire('Sucesso!', 'Turma atualizada', 'success').then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                Swal.fire('Erro', 'Erro ao atualizar turma', 'error');
            }
        });
    });

    // Aceitar inscrição
    $(document).on('click', '.btn-aceitar-inscricao', function() {
        const id = $(this).data('inscricao-id');
        atualizarStatusInscricao(id, 'confirmado');
    });

    // Rejeitar inscrição
    $(document).on('click', '.btn-rejeitar-inscricao', function() {
        const id = $(this).data('inscricao-id');
        atualizarStatusInscricao(id, 'cancelado');
    });
}

function atualizarStatusInscricao(id, status) {
    $.ajax({
        url: `/api/pre-inscricoes/${id}`,
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify({ status: status }),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() {
            Swal.fire('Sucesso!', 'Status atualizado', 'success').then(() => {
                location.reload();
            });
        },
        error: function() {
            Swal.fire('Erro', 'Erro ao atualizar status', 'error');
        }
    });
}

// Eliminar turma (função do botão Eliminar na página show)
function eliminarTurmaShow(id) {
    Swal.fire({
        title: 'Confirmar eliminação',
        text: 'Tem certeza que deseja eliminar esta turma?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/turmas/${id}`,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function() {
                    Swal.fire('Eliminado!', 'Turma eliminada com sucesso', 'success').then(() => {
                        window.location.href = "{{ route('turmas.index') }}";
                    });
                },
                error: function() {
                    Swal.fire('Erro', 'Erro ao eliminar turma', 'error');
                }
            });
        }
    });
}
</script>
@endsection
