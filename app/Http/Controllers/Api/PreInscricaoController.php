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
            'curso_id' => 'required|exists:cursos,id',
            'centro_id' => 'required|exists:centros,id',
            'horario_id' => 'nullable|exists:horarios,id',
            'nome_completo' => 'required|string|max:100',
            'contactos' => 'required|string',
            'email' => 'nullable|email|max:100',
            'observacoes' => 'nullable|string|max:500'
        ]);

        // Verificar se o curso está associado ao centro selecionado
        $curso = \App\Models\Curso::with('centros')->find($validated['curso_id']);
        $centro = \App\Models\Centro::find($validated['centro_id']);
        
        if (!$curso || !$centro) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Dados do curso ou centro não encontrados.'
            ], 404);
        }
        
        $cursoTemCentro = $curso->centros->contains('id', $validated['centro_id']);
        if (!$cursoTemCentro) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'O curso selecionado não está disponível no centro escolhido.'
            ], 422);
        }

        // Processar contactos - vem como JSON string do frontend
        try {
            $contactosArray = json_decode($validated['contactos'], true);
            if (!is_array($contactosArray) || empty($contactosArray)) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Contactos devem ser fornecidos como um array JSON válido'
                ], 422);
            }
            $validated['contactos'] = json_encode($contactosArray);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Formato de contactos inválido'
            ], 422);
        }
        $validated['status'] = 'pendente'; // Status padrão
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }

        $preInscricao = PreInscricao::create($validated);

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Pré-inscrição realizada!',
            'dados' => $preInscricao
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
        $preInscricoes = PreInscricao::with(['curso', 'centro', 'horario'])->get();
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
                'status' => 'erro',
                'mensagem' => 'Pré-inscrição não encontrada!'
            ], 404);
        }

        // Só permite editar o status
        $validated = $request->validate([
            'status' => 'required|in:pendente,confirmado,cancelado'
        ]);
        $preInscricao->update($validated);

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Status atualizado!',
            'dados' => $preInscricao
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
                'status' => 'erro',
                'mensagem' => 'Pré-inscrição não encontrada!'
            ], 404);
        }
        $preInscricao->delete();
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Pré-inscrição deletada com sucesso!'
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
        $preInscricao = PreInscricao::with(['curso', 'centro', 'horario'])->find($id);
        if (!$preInscricao) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Pré-inscrição não encontrada!'
            ], 404);
        }
        return response()->json([
            'status' => 'sucesso',
            'dados' => $preInscricao
        ]);
    }
}
