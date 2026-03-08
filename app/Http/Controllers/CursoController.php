<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::with(['centros', 'formadores', 'horarios', 'preInscricoes'])->get();
        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:cursos,nome',
            'descricao' => 'nullable|string',
            'programa' => 'nullable|string',
            'area' => 'required|string|max:100',
            'modalidade' => 'required|in:presencial,online,hibrido',
            'imagem_url' => 'nullable|url|max:255',
            'ativo' => 'nullable'
        ]);
        
        // Garantir que ativo seja boolean
        $validated['ativo'] = $request->input('ativo', '1') == '1' ? true : false;
        
        $curso = Curso::create($validated);
        return redirect()->route('cursos.index')->with('success', 'Curso criado com sucesso!');
    }

    public function show(Curso $curso)
    {
        $curso->load(['centros', 'formadores', 'horarios', 'preInscricoes']);
        return view('cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:cursos,nome,' . $curso->id,
            'descricao' => 'nullable|string',
            'programa' => 'nullable|string',
            'area' => 'required|string|max:100',
            'modalidade' => 'required|in:presencial,online,hibrido',
            'imagem_url' => 'nullable|url|max:255',
            'ativo' => 'nullable'
        ]);
        
        // Garantir que ativo seja boolean
        $validated['ativo'] = $request->input('ativo', '1') == '1' ? true : false;
        
        $curso->update($validated);
        return redirect()->route('cursos.index')->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('cursos.index')->with('success', 'Curso deletado com sucesso!');
    }

    public function toggleStatus(Curso $curso)
    {
        $curso->ativo = !$curso->ativo;
        $curso->save();
        return redirect()->route('cursos.index')->with('success', 'Status do curso alterado!');
    }
}
