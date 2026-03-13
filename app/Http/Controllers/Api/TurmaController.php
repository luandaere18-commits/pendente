<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Turma;
use App\Models\Curso;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Turmas",
 *     description="Operações relacionadas às turmas de cursos"
 * )
 */
class TurmaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/turmas",
     *     tags={"Turmas"},
     *     summary="Listar todas as turmas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de turmas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Turma"))
     *     )
     * )
     */
    public function index()
    {
        $turmas = Turma::with(['curso', 'formador', 'centro'])->get();
        return response()->json($turmas);
    }

    /**
     * @OA\Post(
     *     path="/turmas",
     *     tags={"Turmas"},
     *     summary="Criar uma nova turma",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TurmaInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Turma criada",
     *         @OA\JsonContent(ref="#/components/schemas/Turma")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'centro_id' => 'required|exists:centros,id',
            'formador_id' => 'nullable|exists:formadores,id',
            'data_arranque' => 'required|date|after:today',
            'duracao_semanas' => 'nullable|integer|min:1',
            'dia_semana' => 'required|array|min:1',
            'dia_semana.*' => 'required|in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
            'periodo' => 'required|in:manha,tarde,noite,manha,tarde,noite',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i',
            'status' => 'nullable|in:planeada,inscricoes_abertas,em_andamento,concluida',
            'vagas_totais' => 'nullable|integer|min:1',
            'publicado' => 'nullable|boolean'
        ]);

        // Normalizar período (adicionar acento conforme migration)
        $validated['periodo'] = str_replace('manha', 'manha', $validated['periodo']);
        
        // Definir status padrão se não fornecido
        if (empty($validated['status'])) {
            $validated['status'] = 'planeada';
        }

        // Validar hora_fim > hora_inicio se ambas estão preenchidas
        if (!empty($validated['hora_inicio']) && !empty($validated['hora_fim'])) {
            if ($validated['hora_fim'] <= $validated['hora_inicio']) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'A hora de fim deve ser maior que a hora de início.',
                    'errors' => ['hora_fim' => ['A hora de fim deve ser maior que a hora de início.']]
                ], 422);
            }
        }

        // Garantir que dia_semana é um array
        if (!is_array($validated['dia_semana'])) {
            $validated['dia_semana'] = [$validated['dia_semana']];
        }
        
        // Validação: formador obrigatório se status = inscricoes_abertas
        if ($validated['status'] === 'inscricoes_abertas' && empty($validated['formador_id'])) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Formador obrigatório para turmas com inscrições abertas.',
                'errors' => ['formador_id' => ['Formador obrigatório para turmas com inscrições abertas.']]
            ], 422);
        }

        $turma = Turma::create($validated);

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Turma cadastrada com sucesso!',
            'dados' => $turma
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/turmas/{id}",
     *     tags={"Turmas"},
     *     summary="Buscar turma por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Turma encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Turma")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Turma não encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        $turma = Turma::with(['curso', 'formador'])->find($id);
        if (!$turma) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Turma não encontrada!'
            ], 404);
        }
        return response()->json(['status' => 'sucesso', 'dados' => $turma]);
    }

    /**
     * @OA\Put(
     *     path="/turmas/{id}",
     *     tags={"Turmas"},
     *     summary="Atualizar turma (não permite editar curso_id)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TurmaUpdateInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Turma atualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Turma")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Turma não encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $turma = Turma::find($id);
        if (!$turma) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Turma não encontrada!'
            ], 404);
        }
        
        // Não permite editar curso_id
        $validated = $request->validate([
            'centro_id' => 'nullable|exists:centros,id',
            'formador_id' => 'nullable|exists:formadores,id',
            'data_arranque' => 'nullable|date|after:today',
            'duracao_semanas' => 'nullable|integer|min:1',
            'dia_semana' => 'required|array|min:1',
            'dia_semana.*' => 'required|in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
            'periodo' => 'required|in:manha,tarde,noite,manha,tarde,noite',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i',
            'status' => 'nullable|in:planeada,inscricoes_abertas,em_andamento,concluida',
            'vagas_totais' => 'nullable|integer|min:1',
            'publicado' => 'nullable|boolean'
        ]);
        
        // Normalizar período (adicionar acento conforme migration)
        $validated['periodo'] = str_replace('manha', 'manha', $validated['periodo']);
        
        // Definir status padrão se não fornecido
        if (empty($validated['status'])) {
            $validated['status'] = 'planeada';
        }
        
        // Validar hora_fim > hora_inicio se ambas estão preenchidas
        if (!empty($validated['hora_inicio']) && !empty($validated['hora_fim'])) {
            if ($validated['hora_fim'] <= $validated['hora_inicio']) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'A hora de fim deve ser maior que a hora de início.',
                    'errors' => ['hora_fim' => ['A hora de fim deve ser maior que a hora de início.']]
                ], 422);
            }
        }
        
        // Validação: formador obrigatório se status = inscricoes_abertas
        if ($validated['status'] === 'inscricoes_abertas' && empty($validated['formador_id'])) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Formador obrigatório para turmas com inscrições abertas.',
                'errors' => ['formador_id' => ['Formador obrigatório para turmas com inscrições abertas.']]
            ], 422);
        }
        
        $turma->update($validated);
        
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Turma atualizada com sucesso!',
            'dados' => $turma
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/turmas/{id}",
     *     tags={"Turmas"},
     *     summary="Deletar turma",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Turma deletada"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Turma não encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $turma = Turma::find($id);
        if (!$turma) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Turma não encontrada!'
            ], 404);
        }
        $turma->delete();
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Turma deletada com sucesso!'
        ]);
    }
}
