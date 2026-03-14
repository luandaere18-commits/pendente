<?php


namespace App\Http\Controllers\Api;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Categorias",
 *     description="Operações relacionadas a categorias de produtos e serviços"
 * )
 */
class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

        /**
     * @OA\Get(
     *     path="/categorias",
     *     tags={"Categorias"},
     *     summary="Listar categorias",
     *     description="Retorna uma lista de categorias com itens",
     *     @OA\Parameter(
     *         name="grupo_id",
     *         in="query",
     *         description="Filtrar por ID do grupo",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de categorias",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Categoria"))
     *     )
     * )
     */

    public function index(Request $request): JsonResponse
    {
        $query = Categoria::ativas()->with(['grupo', 'itens']);

        // Filtrar por grupo se especificado
        if ($request->has('grupo_id')) {
            $query->where('grupo_id', $request->grupo_id);
        }

        $categorias = $query->withCount('itens')->ordenado()->get();

        return response()->json($categorias);
    }

    /**
     * Store a newly created resource in storage.
     */

        /**
     * @OA\Post(
     *     path="/categorias",
     *     tags={"Categorias"},
     *     summary="Criar categoria",
     *     security={{"bearerAuth": {}}},
     *     description="Cria uma nova categoria.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CategoriaInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoria criada",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     )
     * )
     */

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'grupo_id' => 'required|exists:grupos,id',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean'
        ]);

        $categoria = Categoria::create($validated);
        $categoria->load('grupo', 'itens');

        return response()->json($categoria, 201);
    }

    /**
     * Display the specified resource.
     */

        /**
     * @OA\Get(
     *     path="/categorias/{id}",
     *     tags={"Categorias"},
     *     summary="Exibir categoria",
     *     description="Exibe uma categoria com seus itens e grupo.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     ),
     *     @OA\Response(response=404, description="Categoria não encontrada")
     * )
     */
    public function show(Categoria $categoria): JsonResponse
    {
        $categoria->load('grupo', 'itens');
        return response()->json($categoria);
    }

    /**
     * Update the specified resource in storage.
     */

        /**
     * @OA\Put(
     *     path="/categorias/{id}",
     *     tags={"Categorias"},
     *     summary="Atualizar categoria",
     *     security={{"bearerAuth": {}}},
     *     description="Atualiza uma categoria existente.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CategoriaInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria atualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     ),
     *     @OA\Response(response=404, description="Categoria não encontrada")
     * )
     */
    public function update(Request $request, Categoria $categoria): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'grupo_id' => 'sometimes|required|exists:grupos,id',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean'
        ]);

        $categoria->update($validated);
        $categoria->load('grupo', 'itens');

        return response()->json($categoria);
    }

    /**
     * Remove the specified resource from storage.
     */

        /**
     * @OA\Delete(
     *     path="/categorias/{id}",
     *     tags={"Categorias"},
     *     summary="Excluir categoria",
     *     security={{"bearerAuth": {}}},
     *     description="Exclui uma categoria pelo ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Categoria excluída com sucesso"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=404, description="Categoria não encontrada")
     * )
     */
    public function destroy(Categoria $categoria): JsonResponse
    {
        $categoria->delete();
        return response()->json(['message' => 'Categoria excluída com sucesso']);
    }
}

