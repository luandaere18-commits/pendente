<?php

namespace App\Http\Controllers\Api;


use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Produtos",
 *     description="Operações relacionadas a produtos"
 * )
 */
class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

      /**
     * @OA\Get(
     *     path="/produtos",
     *     tags={"Produtos"},
     *     summary="Listar produtos",
     *     description="Retorna uma lista de produtos, com filtros opcionais por categoria, tipo, destaque e ativos.",
     *     @OA\Parameter(
     *         name="categoria_id",
     *         in="query",
     *         description="Filtrar por ID da categoria",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="tipo",
     *         in="query",
     *         description="Filtrar por tipo da categoria (loja ou snack)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="em_destaque",
     *         in="query",
     *         description="Filtrar apenas produtos em destaque",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="incluir_inativos",
     *         in="query",
     *         description="Incluir produtos inativos (apenas para admin)",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de produtos",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Produto"))
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Produto::with('categoria');

        // Filtrar por categoria se especificado
        if ($request->has('categoria_id')) {
            $query->porCategoria($request->categoria_id);
        }

        // Filtrar por tipo (loja ou snack)
        if ($request->has('tipo')) {
            $query->whereHas('categoria', function($q) use ($request) {
                $q->porTipo($request->tipo);
            });
        }

        // Filtrar apenas em destaque
        if ($request->has('em_destaque') && $request->em_destaque) {
            $query->emDestaque();
        }

        // Filtrar apenas ativos se não for admin
        if (!$request->has('incluir_inativos')) {
            $query->ativos();
        }

        $produtos = $query->orderBy('created_at', 'desc')->get();

        return response()->json($produtos);
    }

    /**
     * Store a newly created resource in storage.
     */

        /**
     * @OA\Post(
     *     path="/produtos",
     *     tags={"Produtos"},
     *     summary="Criar produto",
     *     security={{"bearerAuth": {}}},
     *     description="Cria um novo produto.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProdutoInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produto criado",
     *         @OA\JsonContent(ref="#/components/schemas/Produto")
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'ativo' => 'boolean',
            'em_destaque' => 'boolean'
        ]);

        $produto = Produto::create($validated);
        $produto->load('categoria');

        return response()->json($produto, 201);
    }

    /**
     * Display the specified resource.
     */

        /**
     * @OA\Get(
     *     path="/produtos/{id}",
     *     tags={"Produtos"},
     *     summary="Exibir produto",
     *     description="Exibe um produto pelo ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Produto")
     *     ),
     *     @OA\Response(response=404, description="Produto não encontrado")
     * )
     */
    public function show(Produto $produto): JsonResponse
    {
        $produto->load('categoria');
        return response()->json($produto);
    }

    /**
     * Update the specified resource in storage.
     */
        /**
     * @OA\Put(
     *     path="/produtos/{id}",
     *     tags={"Produtos"},
     *     summary="Atualizar produto",
     *     security={{"bearerAuth": {}}},
     *     description="Atualiza um produto existente.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProdutoInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto atualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Produto")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(response=404, description="Produto não encontrado")
     * )
     */
    public function update(Request $request, Produto $produto): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'sometimes|required|numeric|min:0',
            'imagem' => 'nullable|string',
            'categoria_id' => 'sometimes|required|exists:categorias,id',
            'ativo' => 'boolean',
            'em_destaque' => 'boolean'
        ]);

        $produto->update($validated);
        $produto->load('categoria');

        return response()->json($produto);
    }

    /**
     * Remove the specified resource from storage.
     */

        /**
     * @OA\Delete(
     *     path="/produtos/{id}",
     *     tags={"Produtos"},
     *     summary="Excluir produto",
     *     security={{"bearerAuth": {}}},
     *     description="Exclui um produto pelo ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Produto excluído com sucesso"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=404, description="Produto não encontrado")
     * )
     */
    public function destroy(Produto $produto): JsonResponse
    {
        $produto->delete();
        return response()->json(['message' => 'Produto excluído com sucesso']);
    }

    /**
     * Get produtos por categoria para a página pública
     */
    public function porCategoria(Categoria $categoria): JsonResponse
    {
        $produtos = $categoria->produtos()->ativos()->get();
        return response()->json($produtos);
    }

    /**
     * Get produtos em destaque
     */
    public function emDestaque(Request $request): JsonResponse
    {
        $query = Produto::with('categoria')->ativos()->emDestaque();

        if ($request->has('tipo')) {
            $query->whereHas('categoria', function($q) use ($request) {
                $q->porTipo($request->tipo);
            });
        }

        $produtos = $query->get();
        return response()->json($produtos);
    }
}
