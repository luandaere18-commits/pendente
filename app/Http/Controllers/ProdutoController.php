<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with(['categoria'])->get();
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        $categorias = \App\Models\Categoria::where('ativo', true)->get();
        return view('produtos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:produtos,nome',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'ativo' => 'boolean',
            'em_destaque' => 'boolean'
        ]);
        
        // Garantir que boolean fields sejam tratados corretamente
        $validated['ativo'] = $request->has('ativo') ? true : false;
        $validated['em_destaque'] = $request->has('em_destaque') ? true : false;
        
        $produto = Produto::create($validated);
        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
    }

    public function show(Produto $produto)
    {
        $produto->load(['categoria']);
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        $categorias = \App\Models\Categoria::where('ativo', true)->get();
        return view('produtos.edit', compact('produto', 'categorias'));
    }

    public function update(Request $request, Produto $produto)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:produtos,nome,' . $produto->id,
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'ativo' => 'boolean',
            'em_destaque' => 'boolean'
        ]);
        
        // Garantir que boolean fields sejam tratados corretamente
        $validated['ativo'] = $request->has('ativo') ? true : false;
        $validated['em_destaque'] = $request->has('em_destaque') ? true : false;
        
        $produto->update($validated);
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto deletado com sucesso!');
    }
}
