<?php

namespace App\Http\Controllers;

use App\Models\PreInscricao;
use App\Models\Turma;
use Illuminate\Http\Request;

class PreInscricaoController extends Controller
{
    public function index(Request $request)
    {
        $query = PreInscricao::with(['turma.curso', 'turma.centro']);

        // Filtrar por status
        if ($request->has('status') && !empty($request->get('status'))) {
            $query->where('status', $request->get('status'));
        }

        // Filtrar por curso (via turma.curso)
        if ($request->has('curso') && !empty($request->get('curso'))) {
            $query->whereHas('turma', function ($q) use ($request) {
                $q->where('curso_id', $request->get('curso'));
            });
        }

        // Filtrar por centro (via turma.centro)
        if ($request->has('centro') && !empty($request->get('centro'))) {
            $query->whereHas('turma', function ($q) use ($request) {
                $q->where('centro_id', $request->get('centro'));
            });
        }

        $preInscricoes = $query->get();
        
        // AJAX/JSON request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($preInscricoes, 200);
        }
        
        return view('pre-inscricoes.index', compact('preInscricoes'));
    }

    public function create()
    {
        $turmas = Turma::with('curso')->get();
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
            'status' => 'nullable|in:pendente,confirmado,cancelado',
            'observacoes' => 'nullable|string|max:500'
        ]);

        // Verificar se a turma existe
        $turma = Turma::find($validated['turma_id']);
        
        if (!$turma) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Turma não encontrada.'
                ], 404);
            }
            return back()->withErrors(['turma_id' => 'Turma não encontrada.']);
        }

        $validated['status'] = $validated['status'] ?? 'pendente'; // Status padrão
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }

        $preInscricao = PreInscricao::create($validated);

        // Carregar relações para que o frontend possa exibir curso/centro corretamente
        $preInscricao->load(['turma.curso', 'turma.centro']);

        // AJAX/JSON request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Pré-inscrição realizada!',
                'dados' => $preInscricao
            ], 201);
        }

        return redirect()->route('pre-inscricoes.index')->with('success', 'Pré-inscrição criada com sucesso!');
    }

    public function show($id)
    {
        $preInscricao = PreInscricao::with(['turma.curso', 'turma.centro'])->find($id);
        
        if (!$preInscricao) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Pré-inscrição não encontrada!'
                ], 404);
            }
            abort(404);
        }

        // AJAX/JSON request
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'dados' => $preInscricao
            ], 200);
        }

        return view('pre-inscricoes.show', compact('preInscricao'));
    }

    public function edit(PreInscricao $preInscricao)
    {
        $turmas = Turma::with('curso')->get();
        return view('pre-inscricoes.edit', compact('preInscricao', 'turmas'));
    }

    public function update(Request $request, $id)
    {
        $preInscricao = PreInscricao::find($id);

        if (!$preInscricao) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Pré-inscrição não encontrada!'
                ], 404);
            }
            abort(404);
        }

        // Só permite editar o status
        $validated = $request->validate([
            'status' => 'required|in:pendente,confirmado,cancelado'
        ]);
        
        // Controlar vagas_preenchidas nas turmas
        $statusAnterior = $preInscricao->status;
        $novoStatus = $validated['status'];
        
        if ($statusAnterior !== $novoStatus) {
            $turma = $preInscricao->turma;
            
            // Se foi confirmado e agora é algo diferente (cancelado ou pendente)
            if ($statusAnterior === 'confirmado' && $novoStatus !== 'confirmado') {
                $turma->decrement('vagas_preenchidas');
            }
            // Se não era confirmado e agora é confirmado
            else if ($statusAnterior !== 'confirmado' && $novoStatus === 'confirmado') {
                $turma->increment('vagas_preenchidas');
            }
        }
        
        $preInscricao->update($validated);

        // AJAX/JSON request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Status atualizado!',
                'dados' => $preInscricao
            ], 200);
        }

        return redirect()->route('pre-inscricoes.index')->with('success', 'Pré-inscrição atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $preInscricao = PreInscricao::find($id);
        
        if (!$preInscricao) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Pré-inscrição não encontrada!'
                ], 404);
            }
            abort(404);
        }

        $preInscricao->delete();

        // AJAX/JSON request
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Pré-inscrição deletada com sucesso!'
            ], 200);
        }

        return redirect()->route('pre-inscricoes.index')->with('success', 'Pré-inscrição deletada com sucesso!');
    }
}
