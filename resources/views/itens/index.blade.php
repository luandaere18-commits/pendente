@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Itens</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('itens.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Novo Item
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th>Preço</th>
                    <th>Destaque</th>
                    <th>Ordem</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($itens as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->nome }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $item->categoria->nome ?? '-' }}</span>
                        </td>
                        <td>
                            @if($item->tipo === 'produto')
                                <span class="badge bg-primary">Produto</span>
                            @else
                                <span class="badge bg-warning">Serviço</span>
                            @endif
                        </td>
                        <td>
                            {{ $item->preco_formatado }}
                        </td>
                        <td>
                            @if($item->destaque)
                                <i class="fas fa-star text-warning"></i> Sim
                            @else
                                Não
                            @endif
                        </td>
                        <td>{{ $item->ordem }}</td>
                        <td>
                            @if($item->ativo)
                                <span class="badge bg-success">Ativo</span>
                            @else
                                <span class="badge bg-secondary">Inativo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('itens.show', $item) }}" class="btn btn-sm btn-outline-info" title="Ver detalhes">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('itens.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('itens.destroy', $item) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza?')" title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Nenhum item encontrado</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
