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
        \Log::info('Api\TurmaController@store - Dados recebidos:', $request->all());
        
        $validated = $request->validate([
                'curso_id' => 'required|exists:cursos,id',
                'centro_id' => 'required|exists:centros,id',
                'formador_id' => 'nullable|exists:formadores,id',
                'data_arranque' => 'required|date',
                'duracao_semanas' => 'nullable|integer|min:1',
                'dia_semana' => 'required|array|min:1',
                'dia_semana.*' => 'required|in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
                'periodo' => 'required|in:manha,tarde,noite,manhã,tarde,noite',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fim' => 'nullable|date_format:H:i',
                'status' => 'nullable|in:planeada,inscricoes_abertas,em_andamento,concluida',
                'vagas_totais' => 'nullable|integer|min:1',
                'publicado' => 'nullable|boolean'
            ]);
            
            \Log::info('Dados validados com sucesso:', $validated);

        // Normalizar período (adicionar acento conforme migration)
        $validated['periodo'] = str_replace('manha', 'manhã', $validated['periodo']);
        
        \Log::info('Api\TurmaController@store - Período normalizado:', $validated['periodo']);
        
        // Definir status padrão se não fornecido
        if (empty($validated['status'])) {
            $validated['status'] = 'planeada';
        }

        // Validar que o centro está associado ao curso
        if (!\DB::table('centro_curso')->where('centro_id', $validated['centro_id'])->where('curso_id', $validated['curso_id'])->exists()) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'O centro selecionado não oferece o curso escolhido.',
                'errors' => ['centro_id' => ['O centro selecionado não oferece o curso escolhido.']]
            ], 422);
        }

        // Validar hora_inicio com base no periodo
        $this->validarHoraComPeriodo($validated);
        
        // Validar que hora_fim > hora_inicio se ambas estão preenchidas
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

    /**
     * Validar hora de início com base no período
     * 
     * @param array $data
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validarHoraComPeriodo(&$data)
    {
        if (!isset($data['hora_inicio']) || !isset($data['periodo'])) {
            return;
        }

        $hora = $data['hora_inicio'];
        $periodo = $data['periodo'];

        $validacoes = [
            'manha' => ['07:00', '12:00'],   // 07:00 até 11:59
            'manhã' => ['07:00', '12:00'],   // 07:00 até 11:59
            'tarde' => ['12:00', '18:00'],   // 12:00 até 17:59
            'noite' => ['18:00', '22:00'],   // 18:00 até 21:59
        ];

        if (isset($validacoes[$periodo])) {
            [$horaMin, $horaMax] = $validacoes[$periodo];
            
            if ($hora < $horaMin || $hora >= $horaMax) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'hora_inicio' => "A hora de início deve estar entre {$horaMin} e " . date('H:i', strtotime($horaMax) - 60) . " para o período de {$periodo}."
                ]);
            }
        }
    }

    /**
     * Validar que hora_fim é maior que hora_inicio
     * 
     * @param array $data
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validarHoraFimMaiorQueHoraInicio(&$data)
    {
        // Se ambas as horas estão preenchidas, validar
        if (isset($data['hora_inicio']) && isset($data['hora_fim']) && 
            !empty($data['hora_inicio']) && !empty($data['hora_fim'])) {
            
            if ($data['hora_fim'] <= $data['hora_inicio']) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'hora_fim' => 'A hora de fim deve ser maior que a hora de início.'
                ]);
            }
        }
    }
}
