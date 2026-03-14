<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with(['categorias.itens'])->ordenado()->get();
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        return view('grupos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:grupos,nome',
            'display_name' => 'required|string|max:100',
            'icone' => 'nullable|string|max:100',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean'
        ]);
        
        // Garantir que ativo seja boolean
        $validated['ativo'] = $request->has('ativo') ? true : false;
        
        $grupo = Grupo::create($validated);
        return redirect()->route('grupos.index')->with('success', 'Grupo criado com sucesso!');
    }

    public function show(Grupo $grupo)
    {
        $grupo->load(['categorias.itens']);
        return view('grupos.show', compact('grupo'));
    }

    public function edit(Grupo $grupo)
    {
        return view('grupos.edit', compact('grupo'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:grupos,nome,' . $grupo->id,
            'display_name' => 'required|string|max:100',
            'icone' => 'nullable|string|max:100',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean'
        ]);
        
        // Garantir que ativo seja boolean
        $validated['ativo'] = $request->has('ativo') ? true : false;
        
        $grupo->update($validated);
        return redirect()->route('grupos.index')->with('success', 'Grupo atualizado com sucesso!');
    }

    public function destroy(Grupo $grupo)
    {
        $grupo->delete();
        return redirect()->route('grupos.index')->with('success', 'Grupo deletado com sucesso!');
    }
}
