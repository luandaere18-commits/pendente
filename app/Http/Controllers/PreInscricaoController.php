<?php

namespace App\Http\Controllers;

use App\Models\PreInscricao;
use Illuminate\Http\Request;

class PreInscricaoController extends Controller
{
    public function index()
    {
        $preInscricoes = PreInscricao::with(['turma.curso'])->get();
        return view('pre-inscricoes.index', compact('preInscricoes'));
    }

    public function create()
    {
        $turmas = \App\Models\Turma::with('curso')->get();
        return view('pre-inscricoes.create', compact('turmas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'turma_id' => 'required|exists:turmas,id',
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
        $preInscricao->load(['turma.curso']);
        return view('pre-inscricoes.show', compact('preInscricao'));
    }

    public function edit(PreInscricao $preInscricao)
    {
        $turmas = \App\Models\Turma::with('curso')->get();
        return view('pre-inscricoes.edit', compact('preInscricao', 'turmas'));
    }

    public function update(Request $request, PreInscricao $preInscricao)
    {
        $validated = $request->validate([
            'turma_id' => 'required|exists:turmas,id',
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
