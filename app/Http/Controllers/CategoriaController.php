<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Grupo;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with(['grupo', 'itens'])->ordenado()->get();
        $grupos = Grupo::where('ativo', true)->ordenado()->get();
        return view('categorias.index', compact('categorias', 'grupos'));
    }

    public function create()
    {
        $grupos = Grupo::where('ativo', true)->ordenado()->get();
        return view('categorias.create', compact('grupos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:categorias,nome',
            'descricao' => 'nullable|string',
            'grupo_id' => 'required|exists:grupos,id',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean'
        ]);
        
        // Garantir que ativo seja boolean
        $validated['ativo'] = $request->has('ativo') ? true : false;
        
        $categoria = Categoria::create($validated);
        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function show(Categoria $categoria)
    {
        $categoria->load(['grupo', 'itens']);
        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        $grupos = Grupo::where('ativo', true)->ordenado()->get();
        return view('categorias.edit', compact('categoria', 'grupos'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:categorias,nome,' . $categoria->id,
            'descricao' => 'nullable|string',
            'grupo_id' => 'required|exists:grupos,id',
            'ordem' => 'nullable|integer|min:0',
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
