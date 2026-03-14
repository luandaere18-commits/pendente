@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Grupos</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('grupos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Novo Grupo
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
                    <th>Display Name</th>
                    <th>Ícone</th>
                    <th>Ordem</th>
                    <th>Categorias</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grupos as $grupo)
                    <tr>
                        <td>
                            <strong>{{ $grupo->nome }}</strong>
                        </td>
                        <td>{{ $grupo->display_name }}</td>
                        <td>
                            @if($grupo->icone)
                                <i class="{{ $grupo->icone }}"></i> {{ $grupo->icone }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $grupo->ordem }}</td>
                        <td>
                            <span class="badge bg-info">{{ $grupo->categorias_count ?? count($grupo->categorias) }}</span>
                        </td>
                        <td>
                            @if($grupo->ativo)
                                <span class="badge bg-success">Ativo</span>
                            @else
                                <span class="badge bg-secondary">Inativo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('grupos.edit', $grupo) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza?')">
                                    <i class="fas fa-trash"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Nenhum grupo encontrado</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
