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
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ativo' => 'nullable',
            'centros' => 'required|array|min:1',
            'centros.*.centro_id' => 'required|integer|exists:centros,id',
            'centros.*.preco' => 'required|numeric|min:0',
            'centros.*.duracao' => 'required|string|max:100',
            'centros.*.data_arranque' => 'required|date|after_or_equal:today'
        ]);
        
        // Garantir que ativo seja boolean
        $validated['ativo'] = $request->input('ativo', '1') == '1' ? true : false;
        
        // Separar dados do curso dos dados dos centros
        $centrosData = $validated['centros'];
        unset($validated['centros']);
        
        // Criar o curso
        $curso = Curso::create($validated);
        
        // Adicionar centros ao curso (muitos-para-muitos)
        foreach ($centrosData as $centroDado) {
            $curso->centros()->attach($centroDado['centro_id'], [
                'preco' => $centroDado['preco'],
                'duracao' => $centroDado['duracao'],
                'data_arranque' => $centroDado['data_arranque'] ?? null
            ]);
        }
        
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
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ativo' => 'nullable',
            'centros' => 'required|array|min:1',
            'centros.*.centro_id' => 'required|integer|exists:centros,id',
            'centros.*.preco' => 'required|numeric|min:0',
            'centros.*.duracao' => 'required|string|max:100',
            'centros.*.data_arranque' => 'required|date|after_or_equal:today'
        ]);
        
        // Garantir que ativo seja boolean
        $validated['ativo'] = $request->input('ativo', '1') == '1' ? true : false;
        
        // Processar upload de imagem
        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('cursos', $filename, 'public');
            $validated['imagem_url'] = '/storage/' . $path;
        }
        
        // Separar dados do curso dos dados dos centros
        $centrosData = $validated['centros'];
        unset($validated['centros']);
        
        // Atualizar o curso
        $curso->update($validated);
        
        // Atualizar centros (remover todos e adicionar novamente)
        $curso->centros()->detach();
        
        foreach ($centrosData as $centroDado) {
            $curso->centros()->attach($centroDado['centro_id'], [
                'preco' => $centroDado['preco'],
                'duracao' => $centroDado['duracao'],
                'data_arranque' => $centroDado['data_arranque'] ?? null
            ]);
        }
        
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
