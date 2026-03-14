<?php

namespace App\Http\Controllers\Api;

use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Grupos",
 *     description="Operações relacionadas a grupos de produtos e serviços"
 * )
 */
class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/grupos",
     *     tags={"Grupos"},
     *     summary="Listar grupos",
     *     description="Retorna uma lista de grupos com suas categorias e itens",
     *     @OA\Parameter(
     *         name="incluir_inativos",
     *         in="query",
     *         description="Incluir grupos inativos (apenas para admin)",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de grupos",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Grupo"))
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Grupo::with(['categorias.itens']);

        // Filtrar apenas ativos se não for admin
        if (!$request->has('incluir_inativos')) {
            $query->ativos();
        }

        $grupos = $query->ordenado()->get();

        return response()->json($grupos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/grupos",
     *     tags={"Grupos"},
     *     summary="Criar grupo",
     *     security={{"bearerAuth": {}}},
     *     description="Cria um novo grupo.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GrupoInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Grupo criado",
     *         @OA\JsonContent(ref="#/components/schemas/Grupo")
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:grupos',
            'display_name' => 'required|string|max:255',
            'icone' => 'nullable|string|max:255',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean'
        ]);

        $grupo = Grupo::create($validated);
        $grupo->load('categorias.itens');

        return response()->json($grupo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/grupos/{id}",
     *     tags={"Grupos"},
     *     summary="Exibir grupo",
     *     description="Exibe um grupo com suas categorias e itens",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Grupo encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Grupo")
     *     ),
     *     @OA\Response(response=404, description="Grupo não encontrado")
     * )
     */
    public function show(Grupo $grupo): JsonResponse
    {
        $grupo->load('categorias.itens');
        return response()->json($grupo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/grupos/{id}",
     *     tags={"Grupos"},
     *     summary="Atualizar grupo",
     *     security={{"bearerAuth": {}}},
     *     description="Atualiza um grupo existente.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GrupoInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Grupo atualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Grupo")
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=404, description="Grupo não encontrado")
     * )
     */
    public function update(Request $request, Grupo $grupo): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255|unique:grupos,nome,' . $grupo->id,
            'display_name' => 'sometimes|required|string|max:255',
            'icone' => 'nullable|string|max:255',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean'
        ]);

        $grupo->update($validated);
        $grupo->load('categorias.itens');

        return response()->json($grupo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/grupos/{id}",
     *     tags={"Grupos"},
     *     summary="Excluir grupo",
     *     security={{"bearerAuth": {}}},
     *     description="Exclui um grupo pelo ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Grupo excluído com sucesso"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=404, description="Grupo não encontrado")
     * )
     */
    public function destroy(Grupo $grupo): JsonResponse
    {
        $grupo->delete();
        return response()->json(['message' => 'Grupo excluído com sucesso']);
    }
}
