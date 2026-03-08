<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use Illuminate\Http\Request;

class CentroController extends Controller
{
    public function index()
    {
        $centros = Centro::with(['cursos', 'formadores'])->get();
        return view('centros.index', compact('centros'));
    }

    public function create()
    {
        return view('centros.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:centros,nome',
            'localizacao' => 'required|string|max:150',
            'contactos' => 'required|array|min:1',
            'contactos.*' => 'required|string',
            'email' => 'nullable|email|max:100',
        ]);
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }
        
        $centro = Centro::create($validated);
        return redirect()->route('centros.index')->with('success', 'Centro criado com sucesso!');
    }

    public function show($id)
    {
        $centro = Centro::with(['cursos', 'formadores'])->findOrFail($id);
        return view('centros.show', compact('centro'));
    }

    public function edit($id)
    {
        $centro = Centro::findOrFail($id);
        return view('centros.edit', compact('centro'));
    }

    public function update(Request $request, $id)
    {
        $centro = Centro::findOrFail($id);
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:centros,nome,' . $centro->id,
            'localizacao' => 'required|string|max:150',
            'contactos' => 'required|array|min:1',
            'contactos.*' => 'required|string',
            'email' => 'nullable|email|max:100',
        ]);
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }
        
        $centro->update($validated);
        return redirect()->route('centros.index')->with('success', 'Centro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $centro = Centro::findOrFail($id);
        $centro->delete();
        return redirect()->route('centros.index')->with('success', 'Centro deletado com sucesso!');
    }
}
