<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with(['produtos'])->get();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:categorias,nome',
            'descricao' => 'nullable|string',
            'tipo' => 'required|in:loja,snack',
            'ativo' => 'boolean'
        ]);
        
        // Garantir que ativo seja boolean
        $validated['ativo'] = $request->has('ativo') ? true : false;
        
        $categoria = Categoria::create($validated);
        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function show(Categoria $categoria)
    {
        $categoria->load(['produtos']);
        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:categorias,nome,' . $categoria->id,
            'descricao' => 'nullable|string',
            'tipo' => 'required|in:loja,snack',
            'ativo' => 'boolean'
        ]);
        
        // Garantir que ativo seja boolean
        $validated['ativo'] = $request->has('ativo') ? true : false;
        
        $categoria->update($validated);
        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoria deletada com sucesso!');
    }
}
