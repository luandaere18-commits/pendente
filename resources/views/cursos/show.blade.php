@extends('layouts.app')

@section('title', 'Visualizar Curso - ' . $curso->nome)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-book me-3 text-primary"></i>{{ $curso->nome }}
                    </h1>
                    <p class="text-muted mb-0">{{ $curso->area }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <button type="button" class="btn btn-danger" onclick="eliminarCurso({{ $curso->id }})">
                        <i class="fas fa-trash me-2"></i>Eliminar
                    </button>
                    <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações Rápidas -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            @if($curso->imagem_url)
                                <img src="{{ $curso->imagem_url }}" alt="{{ $curso->nome }}" class="img-fluid rounded shadow" style="max-height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-light p-4 rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-image fa-2x"></i><br>
                                        <small>Sem imagem</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <div class="row g-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Modalidade</small>
                                    @if($curso->modalidade === 'online')
                                        <span class="badge bg-info">Online</span>
                                    @elseif($curso->modalidade === 'presencial')
                                        <span class="badge bg-warning text-dark">Presencial</span>
                                    @else
                                        <span class="badge bg-primary">Híbrido</span>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Status</small>
                                    @if($curso->ativo)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-secondary">Inativo</span>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block">Descrição</small>
                                    <small>{{ $curso->descricao ?? 'Sem descrição' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumo Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Resumo</h6>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted"><i class="fas fa-building me-2"></i>Centros:</small>
                        <strong>{{ $curso->centros->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Cronogramas:</small>
                        <strong>{{ $curso->cronogramas->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted"><i class="fas fa-chalkboard-user me-2"></i>Formadores:</small>
                        <strong>{{ $curso->formadores->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted"><i class="fas fa-users me-2"></i>Pré-inscrições:</small>
                        <strong>{{ $curso->preInscricoes->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Abas de Conteúdo -->
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="centros-tab" data-bs-toggle="tab" data-bs-target="#centros" type="button" role="tab">
                        <i class="fas fa-building me-2"></i>Centros ({{ $curso->centros->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cronogramas-tab" data-bs-toggle="tab" data-bs-target="#cronogramas" type="button" role="tab">
                        <i class="fas fa-calendar-alt me-2"></i>Cronogramas ({{ $curso->cronogramas->count() }})
                    </button>
                </li>
                @if($curso->formadores->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="formadores-tab" data-bs-toggle="tab" data-bs-target="#formadores" type="button" role="tab">
                            <i class="fas fa-chalkboard-user me-2"></i>Formadores ({{ $curso->formadores->count() }})
                        </button>
                    </li>
                @endif
                @if($curso->preInscricoes->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="inscricoes-tab" data-bs-toggle="tab" data-bs-target="#inscricoes" type="button" role="tab">
                            <i class="fas fa-users me-2"></i>Pré-inscrições ({{ $curso->preInscricoes->count() }})
                        </button>
                    </li>
                @endif
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">

            <!-- Aba: Centros -->
            <div class="tab-pane fade show active" id="centros" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Centros de Formação Associados</h6>
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="collapse" data-bs-target="#formAdicinarCentro">
                        <i class="fas fa-plus me-1"></i>Novo Centro
                    </button>
                </div>

                <!-- Formulário para Adicionar Centro -->
                <div class="collapse mb-3" id="formAdicinarCentro">
                    <div class="card border-success">
                        <div class="card-header bg-success bg-opacity-10 border-success">
                            <h6 class="mb-0">Associar Novo Centro</h6>
                        </div>
                        <div class="card-body">
                            <form id="formAdicionarCentroAjax" method="POST">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label small">Centro <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="centro_id" required>
                                            <option value="">Selecione um centro</option>
                                            @foreach ($centros ?? [] as $centro)
                                                <option value="{{ $centro->id }}" {{ $curso->centros->contains($centro->id) ? 'disabled' : '' }}>
                                                    {{ $centro->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small">Preço (€) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm" name="preco" placeholder="0.00" step="0.01" min="0" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small">Duração <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="duracao" placeholder="Ex: 40h" required>
                                    </div>
                                </div>
                                <div class="row g-2 mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label small">Data de Arranque <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control form-control-sm" name="data_arranque" required>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-sm btn-success w-100">
                                            <i class="fas fa-save me-1"></i>Salvar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @if($curso->centros->count() > 0)
                    <div class="row">
                        @foreach($curso->centros as $centro)
                            <div class="col-md-6 mb-3">
                                <div class="card border-success h-100">
                                    <div class="card-header bg-success bg-opacity-10 border-success">
                                        <h6 class="mb-0">{{ $centro->nome }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Preço</small>
                                            <strong>{{ number_format($centro->pivot->preco, 2, ',', '.') }} €</strong>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Duração</small>
                                            <strong>{{ $centro->pivot->duracao }}</strong>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Data de Arranque</small>
                                            <strong>{{ \Carbon\Carbon::parse($centro->pivot->data_arranque)->format('d/m/Y') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light border text-center">
                        <small class="text-muted">Nenhum centro associado</small>
                    </div>
                @endif
            </div>

            <!-- Aba: Cronogramas -->
            <div class="tab-pane fade" id="cronogramas" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Cronogramas</h6>
                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="collapse" data-bs-target="#formAdicionarCronograma">
                        <i class="fas fa-plus me-1"></i>Novo
                    </button>
                </div>

                <!-- Formulário para Adicionar Cronograma -->
                <div class="collapse mb-3" id="formAdicionarCronograma">
                    <div class="card border-warning">
                        <div class="card-header bg-warning bg-opacity-10 border-warning">
                            <h6 class="mb-0">Adicionar Cronograma</h6>
                        </div>
                        <div class="card-body">
                            <form id="formAdicionarCronogramaAjax" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small">Dias da Semana <span class="text-danger">*</span></label>
                                    <div class="dias-semana-checkboxes">
                                        @foreach (['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'] as $dia)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="dia_semana[]" value="{{ $dia }}" id="dia_{{ $dia }}">
                                                <label class="form-check-label small" for="dia_{{ $dia }}">{{ substr($dia, 0, 3) }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label class="form-label small">Período <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="periodo" required>
                                            <option value="">Selecione</option>
                                            <option value="manhã">Manhã</option>
                                            <option value="tarde">Tarde</option>
                                            <option value="noite">Noite</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small">Hora Início</label>
                                        <input type="time" class="form-control form-control-sm" name="hora_inicio">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small">Hora Fim</label>
                                        <input type="time" class="form-control form-control-sm" name="hora_fim">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-warning mt-3 w-100">
                                    <i class="fas fa-save me-1"></i>Salvar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @if($curso->cronogramas->count() > 0)
                    <div class="row">
                        @foreach($curso->cronogramas as $cronograma)
                            <div class="col-md-6 mb-3">
                                <div class="card border-warning h-100">
                                    <div class="card-header bg-warning bg-opacity-10 border-warning">
                                        <small class="text-muted">Cronograma #{{ $loop->iteration }}</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Dias</small>
                                            @if(is_array($cronograma->dia_semana))
                                                @foreach($cronograma->dia_semana as $dia)
                                                    <span class="badge bg-info">{{ substr($dia, 0, 3) }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Período</small>
                                            <span class="badge bg-{{ $cronograma->periodo === 'manhã' ? 'warning' : ($cronograma->periodo === 'tarde' ? 'info' : 'secondary') }}">
                                                {{ ucfirst($cronograma->periodo) }}
                                            </span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Horário</small>
                                            @if($cronograma->hora_inicio)
                                                <strong>{{ substr($cronograma->hora_inicio, 0, 5) }} - {{ substr($cronograma->hora_fim, 0, 5) }}</strong>
                                            @else
                                                <small class="text-muted">N/A</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light border text-center">
                        <small class="text-muted">Nenhum cronograma</small>
                    </div>
                @endif
            </div>

            <!-- Aba: Formadores -->
            @if($curso->formadores->count() > 0)
                <div class="tab-pane fade" id="formadores" role="tabpanel">
                    <div class="row">
                        @foreach($curso->formadores as $formador)
                            <div class="col-md-6 mb-3">
                                <div class="card border-primary h-100">
                                    <div class="card-header bg-primary bg-opacity-10 border-primary">
                                        <h6 class="mb-0">{{ $formador->nome }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Email</small>
                                            <a href="mailto:{{ $formador->email }}" class="text-decoration-none small">{{ $formador->email }}</a>
                                        </div>
                                        @if($formador->phone)
                                            <div class="mb-2">
                                                <small class="text-muted d-block">Telefone</small>
                                                <a href="tel:{{ $formador->phone }}" class="text-decoration-none small">{{ $formador->phone }}</a>
                                            </div>
                                        @endif
                                        @if($formador->especialidade)
                                            <div>
                                                <small class="text-muted d-block">Especialidade</small>
                                                <span class="badge bg-light text-dark">{{ $formador->especialidade }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Aba: Pré-inscrições -->
            @if($curso->preInscricoes->count() > 0)
                <div class="tab-pane fade" id="inscricoes" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><small>Nome</small></th>
                                    <th><small>Email</small></th>
                                    <th><small>Telefone</small></th>
                                    <th><small>Data</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($curso->preInscricoes as $inscricao)
                                    <tr>
                                        <td><small><strong>{{ $inscricao->nome }}</strong></small></td>
                                        <td><small><a href="mailto:{{ $inscricao->email }}">{{ $inscricao->email }}</a></small></td>
                                        <td>
                                            @if($inscricao->telefone)
                                                <small><a href="tel:{{ $inscricao->telefone }}">{{ $inscricao->telefone }}</a></small>
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>
                                        <td><small>{{ \Carbon\Carbon::parse($inscricao->created_at)->format('d/m/Y') }}</small></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
/**
 * Manipular formulário de adicionar centro
 */
$(document).ready(function() {
    $('#formAdicionarCentroAjax').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const cursoId = {{ $curso->id }};
        
        $.ajax({
            url: `/api/cursos/${cursoId}/centros`,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Centro associado com sucesso!',
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                let message = 'Erro ao associar centro.';
                if (Object.keys(errors).length > 0) {
                    message = Object.values(errors).flat().join('\n');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: message
                });
            }
        });
    });

    $('#formAdicionarCronogramaAjax').on('submit', function(e) {
        e.preventDefault();
        
        const dias = $('input[name="dia_semana[]"]:checked').map(function() {
            return this.value;
        }).get();
        
        if (dias.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Selecione pelo menos um dia da semana.'
            });
            return;
        }
        
        const formData = {
            dia_semana: dias,
            periodo: $('select[name="periodo"]').val(),
            hora_inicio: $('input[name="hora_inicio"]').val() || null,
            hora_fim: $('input[name="hora_fim"]').val() || null,
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        
        const cursoId = {{ $curso->id }};
        
        $.ajax({
            url: `/api/cronogramas`,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                curso_id: cursoId,
                ...formData
            }),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Cronograma adicionado com sucesso!',
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                let message = 'Erro ao adicionar cronograma.';
                if (Object.keys(errors).length > 0) {
                    message = Object.values(errors).flat().join('\n');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: message
                });
            }
        });
    });
});

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
                    ).then(() => {
                        window.location.href = "{{ route('cursos.index') }}";
                    });
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
