<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Itens",
 *     description="Operações relacionadas a itens (produtos e serviços)"
 * )
 */
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/itens",
     *     tags={"Itens"},
     *     summary="Listar itens",
     *     description="Retorna uma lista de itens, com filtros opcionais por categoria, tipo, destaque e ativos.",
     *     @OA\Parameter(
     *         name="categoria_id",
     *         in="query",
     *         description="Filtrar por ID da categoria",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="grupo_id",
     *         in="query",
     *         description="Filtrar por ID do grupo",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="tipo",
     *         in="query",
     *         description="Filtrar por tipo (produto ou servico)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="destaque",
     *         in="query",
     *         description="Filtrar apenas itens em destaque",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="incluir_inativos",
     *         in="query",
     *         description="Incluir itens inativos (apenas para admin)",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de itens",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Item"))
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Item::with('categoria.grupo');

        // Filtrar por categoria se especificado
        if ($request->has('categoria_id')) {
            $query->porCategoria($request->categoria_id);
        }

        // Filtrar por grupo se especificado
        if ($request->has('grupo_id')) {
            $query->porGrupo($request->grupo_id);
        }

        // Filtrar por tipo (produto ou servico)
        if ($request->has('tipo')) {
            $query->porTipo($request->tipo);
        }

        // Filtrar apenas em destaque
        if ($request->has('destaque') && $request->destaque) {
            $query->destacados();
        }

        // Filtrar apenas ativos se não for admin
        if (!$request->has('incluir_inativos')) {
            $query->ativos();
        }

        $itens = $query->ordenado()->get();

        return response()->json($itens);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/itens",
     *     tags={"Itens"},
     *     summary="Criar item",
     *     security={{"bearerAuth": {}}},
     *     description="Cria um novo item.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ItemInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Item criado",
     *         @OA\JsonContent(ref="#/components/schemas/Item")
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'nullable|numeric|min:0',
            'imagem' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo' => 'required|in:produto,servico',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
            'destaque' => 'boolean'
        ]);

        $item = Item::create($validated);
        $item->load('categoria.grupo');

        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/itens/{id}",
     *     tags={"Itens"},
     *     summary="Exibir item",
     *     description="Exibe um item pelo ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Item")
     *     ),
     *     @OA\Response(response=404, description="Item não encontrado")
     * )
     */
    public function show(Item $item): JsonResponse
    {
        $item->load('categoria.grupo');
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/itens/{id}",
     *     tags={"Itens"},
     *     summary="Atualizar item",
     *     security={{"bearerAuth": {}}},
     *     description="Atualiza um item existente.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ItemInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item atualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Item")
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=404, description="Item não encontrado")
     * )
     */
    public function update(Request $request, Item $item): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255|unique:itens,nome,' . $item->id,
            'descricao' => 'nullable|string',
            'preco' => 'nullable|numeric|min:0',
            'imagem' => 'nullable|string',
            'categoria_id' => 'sometimes|required|exists:categorias,id',
            'tipo' => 'sometimes|required|in:produto,servico',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
            'destaque' => 'boolean'
        ]);

        $item->update($validated);
        $item->load('categoria.grupo');

        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/itens/{id}",
     *     tags={"Itens"},
     *     summary="Excluir item",
     *     security={{"bearerAuth": {}}},
     *     description="Exclui um item pelo ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Item excluído com sucesso"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=404, description="Item não encontrado")
     * )
     */
    public function destroy(Item $item): JsonResponse
    {
        $item->delete();
        return response()->json(['message' => 'Item excluído com sucesso']);
    }

    /**
     * Get itens por categoria para a página pública
     */
    public function porCategoria(Categoria $categoria): JsonResponse
    {
        $itens = $categoria->itens()->ativos()->ordenado()->get();
        return response()->json($itens);
    }

    /**
     * Get itens em destaque
     */
    public function destacados(Request $request): JsonResponse
    {
        $query = Item::with('categoria.grupo')->ativos()->destacados();

        if ($request->has('tipo')) {
            $query->porTipo($request->tipo);
        }

        if ($request->has('grupo_id')) {
            $query->porGrupo($request->grupo_id);
        }

        $itens = $query->ordenado()->get();
        return response()->json($itens);
    }
}
