<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'preco' => 'nullable|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_item' => 'required|in:produto,servico',
            'ativo' => 'boolean',
            'em_destaque' => 'boolean'
        ]);
        
        // Garantir que boolean fields sejam tratados corretamente
        $validated['ativo'] = $request->has('ativo') ? true : false;
        $validated['em_destaque'] = $request->has('em_destaque') ? true : false;
        
        // Processar upload de imagem
        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('produtos', $file, $filename);

            if (Storage::disk('public')->exists($path)) {
                $validated['imagem'] = $path;
            }
        }
        
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
            'preco' => 'nullable|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_item' => 'required|in:produto,servico',
            'ativo' => 'boolean',
            'em_destaque' => 'boolean'
        ]);
        
        // Garantir que boolean fields sejam tratados corretamente
        $validated['ativo'] = $request->has('ativo') ? true : false;
        $validated['em_destaque'] = $request->has('em_destaque') ? true : false;
        
        // Processar upload de imagem se já existe, deletar a anterior
        if ($request->hasFile('imagem')) {
            if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
                Storage::disk('public')->delete($produto->imagem);
            }
            
            $file = $request->file('imagem');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('produtos', $file, $filename);

            if (Storage::disk('public')->exists($path)) {
                $validated['imagem'] = $path;
            }
        }
        
        $produto->update($validated);
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        // Deletar imagem se existir
        if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
            Storage::disk('public')->delete($produto->imagem);
        }
        
        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto deletado com sucesso!');
    }
}
