<?php

namespace App\Http\Controllers;

use App\Models\PreInscricao;
use Illuminate\Http\Request;

class PreInscricaoController extends Controller
{
    public function index()
    {
        $preInscricoes = PreInscricao::with(['curso', 'centro'])->get();
        return view('pre-inscricoes.index', compact('preInscricoes'));
    }

    public function create()
    {
        $cursos = \App\Models\Curso::all();
        $centros = \App\Models\Centro::all();
        $horarios = \App\Models\Horario::all();
        return view('pre-inscricoes.create', compact('cursos', 'centros', 'horarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'centro_id' => 'required|exists:centros,id',
            'horario_id' => 'nullable|exists:horarios,id',
            'nome_completo' => 'required|string|max:100',
            'contactos' => 'required|array|min:1',
            'contactos.*' => 'required|string',
            'email' => 'nullable|email|max:100',
            'observacoes' => 'nullable|string|max:500'
        ]);
        
        $validated['status'] = 'pendente'; // Status padrão
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }
        
        $preInscricao = PreInscricao::create($validated);
        return redirect()->route('pre-inscricoes.index')->with('success', 'Pré-inscrição criada com sucesso!');
    }

    public function show(PreInscricao $preInscricao)
    {
        $preInscricao->load(['curso', 'centro']);
        return view('pre-inscricoes.show', compact('preInscricao'));
    }

    public function edit(PreInscricao $preInscricao)
    {
        $cursos = \App\Models\Curso::all();
        $centros = \App\Models\Centro::all();
        $horarios = \App\Models\Horario::all();
        return view('pre-inscricoes.edit', compact('preInscricao', 'cursos', 'centros', 'horarios'));
    }

    public function update(Request $request, PreInscricao $preInscricao)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'centro_id' => 'required|exists:centros,id',
            'horario_id' => 'nullable|exists:horarios,id',
            'nome_completo' => 'required|string|max:100',
            'contactos' => 'required|array|min:1',
            'contactos.*' => 'required|string',
            'email' => 'nullable|email|max:100',
            'observacoes' => 'nullable|string|max:500',
            'status' => 'required|in:pendente,confirmado,cancelado'
        ]);
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }
        
        $preInscricao->update($validated);
        return redirect()->route('pre-inscricoes.index')->with('success', 'Pré-inscrição atualizada com sucesso!');
    }

    public function destroy(PreInscricao $preInscricao)
    {
        $preInscricao->delete();
        return redirect()->route('pre-inscricoes.index')->with('success', 'Pré-inscrição deletada com sucesso!');
    }

    public function updateStatus(Request $request, PreInscricao $preInscricao)
    {
        $preInscricao->status = $request->input('status', $preInscricao->status);
        $preInscricao->save();
        return redirect()->route('pre-inscricoes.index')->with('success', 'Status atualizado!');
    }
}
