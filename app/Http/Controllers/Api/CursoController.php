<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Cursos",
 *     description="Operações relacionadas aos cursos"
 * )
 */
class CursoController extends Controller
{
/**
 * @OA\Get(
 *     path="/cursos",
 *     tags={"Cursos"},
 *     summary="Listar todos os cursos",
 *     @OA\Parameter(
 *         name="busca",
 *         in="query",
 *         required=false,
 *         description="Busca textual em múltiplos campos",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de cursos",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Curso"))
 *     )
 * )
 */

    public function index(Request $request)
    {
        $query = Curso::with(['centros', 'formadores']);

        // Filtro por múltiplos centros (busca em relacionamento many-to-many)
        if ($request->filled('centros')) {
            $centros = is_array($request->centros) ? $request->centros : explode(',', $request->centros);
            $query->whereHas('centros', function($q) use ($centros) {
                $q->whereIn('centros.id', $centros);
            });
        }

        // Filtro por centro único (para compatibilidade com o frontend)
        if ($request->filled('centro_id')) {
            $query->whereHas('centros', function($q) use ($request) {
                $q->where('centros.id', $request->centro_id);
            });
        }

        // Filtro por área
        if ($request->filled('area')) {
            $query->where('area', 'like', '%' . $request->area . '%');
        }

        // Filtro por modalidade
        if ($request->filled('modalidade')) {
            $query->where('modalidade', $request->modalidade);
        }

        // Filtro por status (ativo/inativo)
        if ($request->filled('ativo')) {
            $query->where('ativo', $request->ativo);
        }

        // Filtro por faixa de preço (na tabela pivô centro_curso)
        if ($request->filled('preco_min') || $request->filled('preco_max')) {
            $query->whereHas('centros', function($q) use ($request) {
                if ($request->filled('preco_min')) {
                    $q->wherePivot('preco', '>=', $request->preco_min);
                }
                if ($request->filled('preco_max')) {
                    $q->wherePivot('preco', '<=', $request->preco_max);
                }
            });
        }

        // Filtro por data de arranque (na tabela pivô centro_curso)
        if ($request->filled('data_arranque')) {
            $query->whereHas('centros', function($q) use ($request) {
                $q->wherePivot('data_arranque', $request->data_arranque);
            });
        }

        // Filtro por data de criação
        if ($request->filled('data_inicio')) {
            $query->where('created_at', '>=', $request->data_inicio);
        }
        if ($request->filled('data_fim')) {
            $query->where('created_at', '<=', $request->data_fim . ' 23:59:59');
        }

        // Busca textual em múltiplos campos
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('nome', 'like', '%' . $busca . '%')
                  ->orWhere('descricao', 'like', '%' . $busca . '%')
                  ->orWhere('programa', 'like', '%' . $busca . '%')
                  ->orWhere('area', 'like', '%' . $busca . '%')
                  ->orWhereHas('centros', function($subQ) use ($busca) {
                      $subQ->where('nome', 'like', '%' . $busca . '%')
                           ->orWhere('localizacao', 'like', '%' . $busca . '%');
                  })
                  ->orWhereHas('formadores', function($subQ) use ($busca) {
                      $subQ->where('nome', 'like', '%' . $busca . '%')
                           ->orWhere('especialidade', 'like', '%' . $busca . '%');
                  });
            });
        }

        // Ordenação
        $ordenarPor = $request->get('ordenar_por', 'created_at');
        $ordenarDirecao = $request->get('ordenar_direcao', 'desc');
        $query->orderBy($ordenarPor, $ordenarDirecao);

        // Paginação
        if ($request->filled('paginar') && $request->paginar == 'true') {
            $porPagina = $request->get('por_pagina', 10);
            $cursos = $query->paginate($porPagina);
        } else {
            $cursos = $query->get();
        }

        return response()->json($cursos);
    }

        /**
     * @OA\Post(
     *     path="/cursos",
     *     tags={"Cursos"},
     *     summary="Criar um novo curso",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CursoInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Curso criado",
     *         @OA\JsonContent(ref="#/components/schemas/Curso")
     *     )
     * )
     */


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',  // Aumentado de 100 para 255
            'descricao' => 'required|string',
            'programa' => 'nullable|string',
            'area' => 'nullable|string|max:100',
            'modalidade' => 'required|in:presencial,online,hibrido',  // Adicionado 'hibrido'
            'imagem_url' => 'nullable|url|max:255',
            'ativo' => 'boolean',
            'centros' => 'required|array|min:1',
            'centros.*.centro_id' => 'required|exists:centros,id',
            'centros.*.preco' => 'required|numeric|min:0',
            'centros.*.duracao' => 'required|string|max:50',
            'centros.*.data_arranque' => 'nullable|date',
            'formadores' => 'array'
        ]);

        // Separe apenas os campos do curso
        $cursoData = collect($validated)->only([
            'nome',
            'descricao',
            'programa',
            'area',
            'modalidade',
            'imagem_url',
            'ativo'
        ])->toArray();

        $curso = Curso::create($cursoData);

        // Associar centros com dados extras (preço, duração e data_arranque)
        $centrosPivot = [];
        foreach ($validated['centros'] as $centro) {
            $centrosPivot[$centro['centro_id']] = [
                'preco' => $centro['preco'],
                'duracao' => $centro['duracao'],
                'data_arranque' => $centro['data_arranque'] ?? null,
            ];
        }
        $curso->centros()->sync($centrosPivot);

        // Sincronizar formadores
        if (!empty($validated['formadores'])) {
            $curso->formadores()->sync($validated['formadores']);
        }

        $curso->load(['centros', 'formadores']);

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Curso cadastrado com sucesso!',
            'dados' => $curso
        ], 201);
    }

      /**
     * @OA\Get(
     *     path="/cursos/{id}",
     *     tags={"Cursos"},
     *     summary="Buscar curso por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Curso encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Curso")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Curso não encontrado"
     *     )
     * )
     */

    public function show($id)
    {
        $curso = Curso::with(['centros', 'formadores'])->find($id);

        if (!$curso) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Curso não encontrado!'
            ], 404);
        }

        return response()->json([
            'status' => 'sucesso',
            'dados' => $curso
        ]);
    }

      /**
     * @OA\Put(
     *     path="/cursos/{id}",
     *     tags={"Cursos"},
     *     summary="Atualizar curso",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CursoInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Curso atualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Curso")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Curso não encontrado"
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $curso = Curso::find($id);

        if (!$curso) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Curso não encontrado!'
            ], 404);
        }

        // Validação condicional: permite edição parcial quando é API JSON
        $rules = [
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'sometimes|string',
            'programa' => 'nullable|string',
            'area' => 'sometimes|string|max:100',
            'modalidade' => 'sometimes|in:presencial,online,hibrido',
            'imagem_url' => 'nullable|url|max:255',
            'ativo' => 'nullable|boolean',
            'centros' => 'nullable|array',
            'centros.*.centro_id' => 'required_unless:centros,null|exists:centros,id',
            'centros.*.preco' => 'required_unless:centros,null|numeric|min:0',
            'centros.*.duracao' => 'required_unless:centros,null|string|max:50',
            'centros.*.data_arranque' => 'nullable|date',
            'formadores' => 'nullable|array'
        ];

        $validated = $request->validate($rules);

        // Separe apenas os campos do curso que foram enviados
        $cursoData = collect($validated)->only([
            'nome',
            'descricao',
            'programa',
            'area',
            'modalidade',
            'imagem_url',
            'ativo'
        ])->filter(function($value) {
            return !is_null($value);
        })->toArray();

        if (!empty($cursoData)) {
            $curso->update($cursoData);
        }

        // Atualizar associações com centros apenas se foram fornecidos
        if (!empty($validated['centros'])) {
            $centrosPivot = [];
            foreach ($validated['centros'] as $centro) {
                $centrosPivot[$centro['centro_id']] = [
                    'preco' => $centro['preco'],
                    'duracao' => $centro['duracao'],
                    'data_arranque' => $centro['data_arranque'] ?? null,
                ];
            }
            $curso->centros()->sync($centrosPivot);
        }

        // Sincronizar formadores apenas se foram fornecidos
        if (!empty($validated['formadores'])) {
            $curso->formadores()->sync($validated['formadores']);
        }

        $curso->load(['centros', 'formadores']);

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Curso atualizado com sucesso!',
            'dados' => $curso
        ]);
    }
    /**
     * @OA\Delete(
     *     path="/cursos/{id}",
     *     tags={"Cursos"},
     *     summary="Deletar curso",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Curso deletado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Curso não encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $curso = Curso::findOrFail($id);
            
            // Remove as relações primeiro
            $curso->centros()->detach();
            $curso->formadores()->detach();
            
            $curso->delete();
    
            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Curso deletado com sucesso!'
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Curso não encontrado. Verifique se o ID está correto.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Erro ao deletar curso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Associar um centro a um curso
     */
    public function attachCentro(Request $request, $id)
    {
        try {
            $curso = Curso::findOrFail($id);

            $validated = $request->validate([
                'centro_id' => 'required|integer|exists:centros,id',
                'preco' => 'required|numeric|min:0',
                'duracao' => 'required|string|max:100',
                'data_arranque' => 'required|date|after_or_equal:today',
            ]);

            // Verificar se centro já está associado
            if ($curso->centros()->where('centro_id', $validated['centro_id'])->exists()) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Este centro já está associado ao curso.'
                ], 422);
            }

            // Associar centro
            $curso->centros()->attach($validated['centro_id'], [
                'preco' => $validated['preco'],
                'duracao' => $validated['duracao'],
                'data_arranque' => $validated['data_arranque']
            ]);

            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Centro associado com sucesso!',
                'dados' => $curso->load('centros')
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Erro de validação',
                'erros' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Erro ao associar centro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Desassociar um centro de um curso
     */
    public function detachCentro($id, $centroId)
    {
        try {
            $curso = Curso::findOrFail($id);

            // Verificar se centro está associado
            if (!$curso->centros()->where('centro_id', $centroId)->exists()) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Este centro não está associado ao curso.'
                ], 404);
            }

            // Desassociar centro
            $curso->centros()->detach($centroId);

            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Centro desassociado com sucesso!',
                'dados' => $curso->load('centros')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Erro ao desassociar centro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualizar dados de um centro associado a um curso (pivot data)
     */
    public function updateCentro(Request $request, $id, $centroId)
    {
        $curso = Curso::findOrFail($id);

        $validated = $request->validate([
            'preco' => 'required|numeric|min:0',
            'duracao' => 'required|string|max:100',
            'data_arranque' => 'required|date',
        ]);

        try {
            $curso->centros()->updateExistingPivot($centroId, [
                'preco' => $validated['preco'],
                'duracao' => $validated['duracao'],
                'data_arranque' => $validated['data_arranque']
            ]);

            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Centro atualizado com sucesso!',
                'dados' => $curso->load('centros')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Erro ao atualizar centro: ' . $e->getMessage()
            ], 400);
        }
    }
}
