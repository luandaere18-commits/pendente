@extends('layouts.app')

@section('title', 'Detalhes da Pré-Inscrição')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-user-check me-3 text-primary"></i>Detalhes da Pré-Inscrição
                    </h1>
                    <p class="text-muted">Informações completas da pré-inscrição registada</p>
                </div>
                <a href="{{ route('pre-inscricoes.index') }}" class="btn btn-outline-secondary">
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
                        <i class="fas fa-id-card me-2"></i>Informações Pessoais
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <p><strong>Nome Completo:</strong></p>
                            <p>{{ $preInscricao->nome_completo }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Email:</strong></p>
                            <p>{{ $preInscricao->email ?? '<span class="text-muted">—</span>' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>Informações da Turma
                    </h5>
                </div>
                <div class="card-body">
                    @if($preInscricao->turma)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Curso:</strong></p>
                                <p>{{ $preInscricao->turma->curso->nome ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Centro:</strong></p>
                                <p>{{ $preInscricao->turma->centro->nome ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <p><strong>Período:</strong></p>
                                <p>{{ ucfirst($preInscricao->turma->periodo) }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Dias:</strong></p>
                                <p>
                                    @if(is_array($preInscricao->turma->dia_semana))
                                        {{ implode(', ', $preInscricao->turma->dia_semana) }}
                                    @else
                                        {{ $preInscricao->turma->dia_semana }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Horário:</strong></p>
                                <p>
                                    @if($preInscricao->turma->hora_inicio && $preInscricao->turma->hora_fim)
                                        {{ $preInscricao->turma->hora_inicio }} - {{ $preInscricao->turma->hora_fim }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">Nenhuma turma selecionada para esta pré-inscrição.</p>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-phone me-2"></i>Contactos
                    </h5>
                </div>
                <div class="card-body">
                    @if($preInscricao->contactos && count($preInscricao->contactos) > 0)
                        <ul class="list-unstyled">
                            @foreach($preInscricao->contactos as $tipo => $valor)
                                <li class="mb-2">
                                    <strong>{{ ucfirst($tipo) }}:</strong> {{ $valor }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Nenhum contacto registado.</p>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-sticky-note me-2"></i>Observações
                    </h5>
                </div>
                <div class="card-body">
                    <p>{{ $preInscricao->observacoes ?? '<span class="text-muted">Sem observações</span>' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        @php
                            $statusClass = '';
                            $statusText = '';
                            if ($preInscricao->status === 'pendente') {
                                $statusClass = 'bg-warning';
                                $statusText = 'Pendente';
                            } elseif ($preInscricao->status === 'confirmado') {
                                $statusClass = 'bg-success';
                                $statusText = 'Confirmado';
                            } elseif ($preInscricao->status === 'cancelado') {
                                $statusClass = 'bg-danger';
                                $statusText = 'Cancelado';
                            }
                        @endphp
                        <span class="badge {{ $statusClass }} p-2">{{ $statusText }}</span>
                    </div>
                    
                    <hr>
                    
                    <p><strong>Data de Criação:</strong><br>
                    <small>{{ $preInscricao->created_at->format('d/m/Y H:i') }}</small></p>
                    
                    <p><strong>Última Atualização:</strong><br>
                    <small>{{ $preInscricao->updated_at->format('d/m/Y H:i') }}</small></p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-cog me-2"></i>Ações
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('pre-inscricoes.edit', $preInscricao->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-2"></i>Editar
                        </a>
                        <form action="{{ route('pre-inscricoes.destroy', $preInscricao->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja eliminar esta pré-inscrição?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-trash me-2"></i>Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
