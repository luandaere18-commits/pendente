<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use App\Models\Curso;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Horários",
 *     description="Operações relacionadas aos horários de cursos"
 * )
 */
class HorarioController extends Controller
{


    /**
     * @OA\Get(
     *     path="/horarios",
     *     tags={"Horários"},
     *     summary="Listar todos os horários",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de horários",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Horario"))
     *     )
     * )
     */
    public function index()
    {
        $horarios = Horario::with('curso')->get();
        return response()->json($horarios);
    }



    /**
     * @OA\Post(
     *     path="/horarios",
     *     tags={"Horários"},
     *     summary="Criar um novo horário",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/HorarioInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Horário criado",
     *         @OA\JsonContent(ref="#/components/schemas/Horario")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'centro_id' => 'required|exists:centros,id',
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

        $horario = Horario::create($validated);

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Horário cadastrado com sucesso!',
            'dados' => $horario
        ], 201);
    }



    /**
     * @OA\Get(
     *     path="/horarios/{id}",
     *     tags={"Horários"},
     *     summary="Buscar horário por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Horário encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Horario")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Horário não encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $horario = Horario::with('curso')->find($id);
        if (!$horario) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Horário não encontrado!'
            ], 404);
        }
        return response()->json(['status' => 'sucesso', 'dados' => $horario]);
    }



    /**
     * @OA\Put(
     *     path="/horarios/{id}",
     *     tags={"Horários"},
     *     summary="Atualizar horário (não permite editar curso_id e centro_id)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/HorarioUpdateInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Horário atualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Horario")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Horário não encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $horario = Horario::find($id);
        if (!$horario) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Horário não encontrado!'
            ], 404);
        }
        // Não permite editar curso_id e centro_id
        $validated = $request->validate([
            'dia_semana' => 'required|in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
            'periodo' => 'required|in:manhã,tarde,noite',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio'
        ]);
        // Garantir formato correto das horas
        $validated['hora_inicio'] = date('H:i', strtotime($validated['hora_inicio']));
        $validated['hora_fim'] = date('H:i', strtotime($validated['hora_fim']));
        // Verificar conflitos de horário (ignorando o horário atual)
        $dadosConflito = array_merge($validated, [
            'curso_id' => $horario->curso_id
        ]);
        $conflitos = $this->verificarConflitosHorario($dadosConflito, $id);
        if (!empty($conflitos)) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Conflito de horário detectado!',
                'conflitos' => $conflitos
            ], 422);
        }
        $horario->update($validated);
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Horário atualizado com sucesso!',
            'dados' => $horario
        ]);
    }



    /**
     * @OA\Delete(
     *     path="/horarios/{id}",
     *     tags={"Horários"},
     *     summary="Deletar horário",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Horário deletado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Horário não encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $horario = Horario::find($id);
        if (!$horario) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Horário não encontrado!'
            ], 404);
        }
        $horario->delete();
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Horário deletado com sucesso!'
        ]);
    }

    /**
     * Verificar conflitos de horário para um mesmo formador
     */
    private function verificarConflitosHorario($dadosHorario, $horarioIdIgnorar = null)
    {
        $conflitos = [];
        
        // Buscar o curso e seus formadores
        $curso = Curso::with('formadores')->find($dadosHorario['curso_id']);
        
        if (!$curso || $curso->formadores->isEmpty()) {
            return $conflitos; // Sem formadores, sem conflitos
        }

        foreach ($curso->formadores as $formador) {
            // Buscar todos os horários dos cursos deste formador
            $horariosFormador = Horario::whereHas('curso.formadores', function($query) use ($formador) {
                $query->where('formadores.id', $formador->id);
            })
            ->where('dia_semana', $dadosHorario['dia_semana'])
            ->when($horarioIdIgnorar, function($query, $id) {
                return $query->where('id', '!=', $id);
            })
            ->with(['curso.formadores'])
            ->get();

            foreach ($horariosFormador as $horarioExistente) {
                if ($this->horariosSeConflitam(
                    $dadosHorario['hora_inicio'], 
                    $dadosHorario['hora_fim'],
                    $horarioExistente->hora_inicio, 
                    $horarioExistente->hora_fim
                )) {
                    $conflitos[] = [
                        'formador' => $formador->nome,
                        'curso_conflitante' => $horarioExistente->curso->nome,
                        'dia_semana' => $horarioExistente->dia_semana,
                        'periodo' => $horarioExistente->periodo,
                        'hora_inicio' => $horarioExistente->hora_inicio,
                        'hora_fim' => $horarioExistente->hora_fim,
                        'mensagem' => "Formador {$formador->nome} já tem aula do curso '{$horarioExistente->curso->nome}' das {$horarioExistente->hora_inicio} às {$horarioExistente->hora_fim}"
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

