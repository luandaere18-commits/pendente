@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Editar Item</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('itens.update', $item) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="categoria_id" class="form-label">Categoria *</label>
                    <select class="form-select @error('categoria_id') is-invalid @enderror" id="categoria_id" name="categoria_id" required>
                        <option value="">Selecione uma categoria</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $item->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->grupo->display_name }} - {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome *</label>
                    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $item->nome) }}" required>
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3">{{ old('descricao', $item->descricao) }}</textarea>
                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo *</label>
                            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                <option value="produto" {{ old('tipo', $item->tipo) == 'produto' ? 'selected' : '' }}>Produto</option>
                                <option value="servico" {{ old('tipo', $item->tipo) == 'servico' ? 'selected' : '' }}>Serviço</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço</label>
                            <input type="number" step="0.01" class="form-control @error('preco') is-invalid @enderror" id="preco" name="preco" value="{{ old('preco', $item->preco) }}" placeholder="0.00">
                            <small class="text-muted">Deixar vazio para serviços "Sob Consulta"</small>
                            @error('preco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ordem" class="form-label">Ordem</label>
                            <input type="number" class="form-control @error('ordem') is-invalid @enderror" id="ordem" name="ordem" value="{{ old('ordem', $item->ordem) }}">
                            @error('ordem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem</label>
                            <input type="file" class="form-control @error('imagem') is-invalid @enderror" id="imagem" name="imagem" accept="image/*">
                            <small class="text-muted">JPG, PNG, GIF (máx 2MB) - Deixar vazio para não alterar</small>
                            @error('imagem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if($item->imagem)
                    <div class="mb-3">
                        <label class="form-label">Imagem Atual</label>
                        <div>
                            <img src="{{ $item->imagem_url }}" alt="{{ $item->nome }}" style="max-height: 150px;">
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="destaque" name="destaque" value="1" {{ old('destaque', $item->destaque) ? 'checked' : '' }}>
                        <label class="form-check-label" for="destaque">
                            Destacar no site
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo', $item->ativo) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ativo">
                            Ativo
                        </label>
                    </div>
                </div>

                <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                    <a href="{{ route('itens.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Atualizar Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
