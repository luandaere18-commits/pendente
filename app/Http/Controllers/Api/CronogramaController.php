<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cronograma;
use App\Models\Curso;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Cronogramas",
 *     description="Operações relacionadas aos cronogramas de cursos"
 * )
 */
class CronogramaController extends Controller
{


    /**
     * @OA\Get(
     *     path="/cronogramas",
     *     tags={"Cronogramas"},
     *     summary="Listar todos os cronogramas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de cronogramas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Cronograma"))
     *     )
     * )
     */
    public function index()
    {
        $cronogramas = Cronograma::with('curso')->get();
        return response()->json($cronogramas);
    }



    /**
     * @OA\Post(
     *     path="/cronogramas",
     *     tags={"Cronogramas"},
     *     summary="Criar um novo cronograma",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CronogramaInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cronograma criado",
     *         @OA\JsonContent(ref="#/components/schemas/Cronograma")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'dia_semana' => 'required|in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
            'periodo' => 'required|in:manhã,tarde,noite',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio'
        ]);

        // Garantir formato correto das horas
        $validated['hora_inicio'] = date('H:i', strtotime($validated['hora_inicio']));
        $validated['hora_fim'] = date('H:i', strtotime($validated['hora_fim']));

        // Verificar conflitos de horário
        $conflitos = $this->verificarConflitosHorario($validated);
        if (!empty($conflitos)) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Conflito de horário detectado!',
                'conflitos' => $conflitos
            ], 422);
        }

        $cronograma = Cronograma::create($validated);

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Cronograma cadastrado com sucesso!',
            'dados' => $cronograma
        ], 201);
    }



    /**
     * @OA\Get(
     *     path="/cronogramas/{id}",
     *     tags={"Cronogramas"},
     *     summary="Buscar cronograma por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cronograma encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Cronograma")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cronograma não encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $cronograma = Cronograma::with('curso')->find($id);
        if (!$cronograma) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Cronograma não encontrado!'
            ], 404);
        }
        return response()->json(['status' => 'sucesso', 'dados' => $cronograma]);
    }



    /**
     * @OA\Put(
     *     path="/cronogramas/{id}",
     *     tags={"Cronogramas"},
     *     summary="Atualizar cronograma (não permite editar curso_id)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CronogramaUpdateInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cronograma atualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Cronograma")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cronograma não encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $cronograma = Cronograma::find($id);
        if (!$cronograma) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Cronograma não encontrado!'
            ], 404);
        }
        // Não permite editar curso_id
        $validated = $request->validate([
            'dia_semana' => 'required|in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
            'periodo' => 'required|in:manhã,tarde,noite',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio'
        ]);
        // Garantir formato correto das horas
        $validated['hora_inicio'] = date('H:i', strtotime($validated['hora_inicio']));
        $validated['hora_fim'] = date('H:i', strtotime($validated['hora_fim']));
        // Verificar conflitos de horário (ignorando o cronograma atual)
        $dadosConflito = array_merge($validated, [
            'curso_id' => $cronograma->curso_id
        ]);
        $conflitos = $this->verificarConflitosHorario($dadosConflito, $id);
        if (!empty($conflitos)) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Conflito de horário detectado!',
                'conflitos' => $conflitos
            ], 422);
        }
        $cronograma->update($validated);
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Cronograma atualizado com sucesso!',
            'dados' => $cronograma
        ]);
    }



    /**
     * @OA\Delete(
     *     path="/cronogramas/{id}",
     *     tags={"Cronogramas"},
     *     summary="Deletar cronograma",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cronograma deletado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cronograma não encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $cronograma = Cronograma::find($id);
        if (!$cronograma) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Cronograma não encontrado!'
            ], 404);
        }
        $cronograma->delete();
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Cronograma deletado com sucesso!'
        ]);
    }

    /**
     * Verificar conflitos de horário para um mesmo formador
     */
    private function verificarConflitosHorario($dadosHorario, $cronogramaIdIgnorar = null)
    {
        $conflitos = [];
        
        // Buscar o curso e seus formadores
        $curso = Curso::with('formadores')->find($dadosHorario['curso_id']);
        
        if (!$curso || $curso->formadores->isEmpty()) {
            return $conflitos; // Sem formadores, sem conflitos
        }

        foreach ($curso->formadores as $formador) {
            // Buscar todos os cronogramas dos cursos deste formador
            $cronogramasFormador = Cronograma::whereHas('curso.formadores', function($query) use ($formador) {
                $query->where('formadores.id', $formador->id);
            })
            ->where('dia_semana', $dadosHorario['dia_semana'])
            ->when($cronogramaIdIgnorar, function($query, $id) {
                return $query->where('id', '!=', $id);
            })
            ->with(['curso.formadores'])
            ->get();

            foreach ($cronogramasFormador as $cronogramaExistente) {
                if ($this->horariosSeConflitam(
                    $dadosHorario['hora_inicio'], 
                    $dadosHorario['hora_fim'],
                    $cronogramaExistente->hora_inicio, 
                    $cronogramaExistente->hora_fim
                )) {
                    $conflitos[] = [
                        'formador' => $formador->nome,
                        'curso_conflitante' => $cronogramaExistente->curso->nome,
                        'dia_semana' => $cronogramaExistente->dia_semana,
                        'periodo' => $cronogramaExistente->periodo,
                        'hora_inicio' => $cronogramaExistente->hora_inicio,
                        'hora_fim' => $cronogramaExistente->hora_fim,
                        'mensagem' => "Formador {$formador->nome} já tem aula do curso '{$cronogramaExistente->curso->nome}' das {$cronogramaExistente->hora_inicio} às {$cronogramaExistente->hora_fim}"
                    ];
                }
            }
        }

        return $conflitos;
    }

    /**
     * Verificar se dois horários se conflitam
     */
    private function horariosSeConflitam($inicio1, $fim1, $inicio2, $fim2)
    {
        // Converter para timestamps para facilitar comparação
        $inicio1 = strtotime($inicio1);
        $fim1 = strtotime($fim1);
        $inicio2 = strtotime($inicio2);
        $fim2 = strtotime($fim2);

        // Verificar se há sobreposição
        return ($inicio1 < $fim2) && ($fim1 > $inicio2);
    }
}
