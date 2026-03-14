@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>{{ $item->nome }}</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('itens.edit', $item) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <form action="{{ route('itens.destroy', $item) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?')">
                    <i class="fas fa-trash"></i> Deletar
                </button>
            </form>
            <a href="{{ route('itens.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @if($item->imagem)
                <div class="card">
                    <img src="{{ $item->imagem_url }}" class="card-img-top" alt="{{ $item->nome }}">
                </div>
            @endif
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informações</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Categoria:</strong><br>
                            <span class="badge bg-secondary">{{ $item->categoria->nome ?? '-' }}</span><br>
                            <small class="text-muted">{{ $item->categoria->grupo->display_name ?? '-' }}</small>
                        </div>
                        <div class="col-md-6">
                            <strong>Tipo:</strong><br>
                            @if($item->tipo === 'produto')
                                <span class="badge bg-primary">Produto</span>
                            @else
                                <span class="badge bg-warning">Serviço</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Preço:</strong><br>
                            {{ $item->preco_formatado }}
                        </div>
                        <div class="col-md-6">
                            <strong>Ordem:</strong><br>
                            {{ $item->ordem }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Status:</strong><br>
                            @if($item->ativo)
                                <span class="badge bg-success">Ativo</span>
                            @else
                                <span class="badge bg-secondary">Inativo</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <strong>Destaque:</strong><br>
                            @if($item->destaque)
                                <i class="fas fa-star text-warning"></i> Sim
                            @else
                                Não
                            @endif
                        </div>
                    </div>

                    @if($item->descricao)
                        <div class="mb-3">
                            <strong>Descrição:</strong><br>
                            {{ $item->descricao }}
                        </div>
                    @endif

                    <div class="text-muted mt-4">
                        <small>
                            Criado em: {{ $item->created_at->format('d/m/Y H:i') }}<br>
                            Última atualização: {{ $item->updated_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
