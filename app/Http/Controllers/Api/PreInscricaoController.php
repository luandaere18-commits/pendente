<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PreInscricao;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Pré-inscrições",
 *     description="Operações relacionadas às pré-inscrições de cursos"
 * )
 */
class PreInscricaoController extends Controller
{
   
    /**
     * @OA\Post(
     *     path="/pre-inscricoes",
     *     tags={"Pré-inscrições"},
     *     summary="Realizar uma nova pré-inscrição",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PreInscricaoInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pré-inscrição realizada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/PreInscricao")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'turma_id'      => 'required|exists:turmas,id',
            'nome_completo' => 'required|string|max:100',
            'contactos'     => 'required|array|min:1',
            'contactos.*'   => 'required|string|max:100',
            'email'         => 'nullable|email|max:100',
            'status'        => 'nullable|in:pendente,confirmado,cancelado',
            'observacoes'   => 'nullable|string|max:500',
        ]);

        // Verificar se a turma existe
        $turma = \App\Models\Turma::find($validated['turma_id']);
        
        if (!$turma) {
            return response()->json([
                'status'   => 'erro',
                'mensagem' => 'Turma não encontrada.',
            ], 404);
        }

        // Garante que contactos é um array sem valores vazios
        $validated['contactos'] = array_filter($validated['contactos'] ?? [], fn($c) => !empty(trim($c)));
        $validated['contactos'] = array_values($validated['contactos']);

        // Validação adicional: deve haver pelo menos 1 contacto após filtro
        if (empty($validated['contactos'])) {
            return response()->json([
                'status'   => 'erro',
                'mensagem' => 'Pelo menos um contacto é necessário.',
            ], 422);
        }

        $validated['status'] = $validated['status'] ?? 'pendente';
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }

        $preInscricao = PreInscricao::create($validated);

        // Carregar relações para que o frontend possa exibir curso/centro corretamente
        $preInscricao->load(['turma.curso', 'turma.centro']);

        return response()->json([
            'status'   => 'sucesso',
            'mensagem' => 'Pré-inscrição realizada com sucesso!',
            'dados'    => $preInscricao,
        ], 201);
    }



    /**
     * @OA\Get(
     *     path="/pre-inscricoes",
     *     tags={"Pré-inscrições"},
     *     summary="Listar todas as pré-inscrições",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de pré-inscrições",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/PreInscricao"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     )
     * )
     */
    public function index()
    {
        $preInscricoes = PreInscricao::with(['turma.curso', 'turma.centro'])->get();
        return response()->json($preInscricoes);
    }


    /**
     * @OA\Put(
     *     path="/pre-inscricoes/{id}",
     *     tags={"Pré-inscrições"},
     *     summary="Atualizar status da pré-inscrição (apenas status)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PreInscricaoStatusInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Status atualizado",
     *         @OA\JsonContent(ref="#/components/schemas/PreInscricao")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pré-inscrição não encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $preInscricao = PreInscricao::find($id);

        if (!$preInscricao) {
            return response()->json([
                'status'   => 'erro',
                'mensagem' => 'Pré-inscrição não encontrada!',
            ], 404);
        }

        // Só permite editar o status
        $validated = $request->validate([
            'status' => 'required|in:pendente,confirmado,cancelado',
        ]);
        
        // Controlar vagas_preenchidas nas turmas
        $statusAnterior = $preInscricao->status;
        $novoStatus     = $validated['status'];
        
        if ($statusAnterior !== $novoStatus) {
            $turma = $preInscricao->turma;
            
            // Se foi confirmado e agora é algo diferente (cancelado ou pendente)
            if ($statusAnterior === 'confirmado' && $novoStatus !== 'confirmado') {
                $turma->decrement('vagas_preenchidas');
            }
            // Se não era confirmado e agora é confirmado
            elseif ($statusAnterior !== 'confirmado' && $novoStatus === 'confirmado') {
                $turma->increment('vagas_preenchidas');
            }
        }
        
        $preInscricao->update($validated);

        return response()->json([
            'status'   => 'sucesso',
            'mensagem' => 'Status atualizado!',
            'dados'    => $preInscricao,
        ]);
    }


    /**
     * @OA\Delete(
     *     path="/pre-inscricoes/{id}",
     *     tags={"Pré-inscrições"},
     *     summary="Deletar pré-inscrição",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pré-inscrição deletada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pré-inscrição não encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $preInscricao = PreInscricao::find($id);
        if (!$preInscricao) {
            return response()->json([
                'status'   => 'erro',
                'mensagem' => 'Pré-inscrição não encontrada!',
            ], 404);
        }
        $preInscricao->delete();
        return response()->json([
            'status'   => 'sucesso',
            'mensagem' => 'Pré-inscrição deletada com sucesso!',
        ]);
    }


    /**
     * @OA\Get(
     *     path="/pre-inscricoes/{id}",
     *     tags={"Pré-inscrições"},
     *     summary="Buscar pré-inscrição por ID",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pré-inscrição encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/PreInscricao")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pré-inscrição não encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        $preInscricao = PreInscricao::with(['turma.curso', 'turma.centro'])->find($id);
        if (!$preInscricao) {
            return response()->json([
                'status'   => 'erro',
                'mensagem' => 'Pré-inscrição não encontrada!',
            ], 404);
        }
        return response()->json([
            'status' => 'sucesso',
            'dados'  => $preInscricao,
        ]);
    }
}
