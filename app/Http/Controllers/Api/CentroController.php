<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Centro;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Centros",
 *     description="Operações relacionadas aos centros"
 * )
 */
class CentroController extends Controller
{
    //
    /**
     * @OA\Get(
     *     path="/centros",
     *     tags={"Centros"},
     *     summary="Listar todos os centros",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de centros",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Centro"))
     *     )
     * )
     */
    public function index()
    {
        // Retorna todos os centros com relacionamentos relevantes
        return response()->json(Centro::with(['cursos', 'formadores'])->get());
    }

    /**
     * @OA\Post(
     *     path="/centros",
     *     tags={"Centros"},
     *     summary="Criar um novo centro",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CentroInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Centro criado",
     *         @OA\JsonContent(ref="#/components/schemas/Centro")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     )
     * )
     */
    // Criar
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                'unique:centros,nome'
            ],
            'localizacao' => [
                'required',
                'string',
                'max:150'
            ],
            'contactos' => [
                'required',
                'array',
                'min:1'
            ],
            'contactos.*' => [
                'required',
                'string',
                'regex:/^9\d{8}$/'
            ],
            'email' => [
                'nullable',
                'email',
                'max:100'
            ]
        ]);

        // Formatar dados
        $validated['contactos'] = array_map('strval', $validated['contactos']);
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }

        // Inserção dos dados validados no banco
        $centro = Centro::create($validated);

        // Retorno de resposta JSON para o frontend
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Centro cadastrado com sucesso!',
            'dados' => $centro
        ], 201); // 201 = Created
    }

    // Busca por ID com cursos e formadores associados
    /**
     * @OA\Get(
     *     path="/centros/{id}",
     *     tags={"Centros"},
     *     summary="Buscar centro por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Centro encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Centro")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Centro não encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        // Busca o centro pelo ID, incluindo cursos e formadores relacionados
        $centro = Centro::with(['cursos', 'formadores'])->find($id);

        // Verifica se o centro foi encontrado
        if (!$centro) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Centro não encontrado!'
            ], 404); // 404 = Not Found
        }

        // Retorna o centro encontrado com relacionamentos
        return response()->json($centro);
    }

    // Editar
    /**
     * @OA\Put(
     *     path="/centros/{id}",
     *     tags={"Centros"},
     *     summary="Atualizar centro",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CentroInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Centro atualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Centro")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Centro não encontrado"
     *     )
     * )
     */
 
    public function update(Request $request, $id)
    {
        $centro = Centro::find($id);

        if (!$centro) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Centro não encontrado!'
            ], 404); // 404 = Not Found
        }

        // Validação dos dados recebidos
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                'unique:centros,nome,' . $centro->id
            ],
            'localizacao' => [
                'required',
                'string',
                'max:150'
            ],
            'contactos' => [
                'required',
                'array',
                'min:1'
            ],
            'contactos.*' => [
                'required',
                'string',
                'regex:/^9\d{8}$/'
            ],
            'email' => [
                'nullable',
                'email',
                'max:100'
            ]
        ]);

        // Formatar dados
        $validated['contactos'] = array_map('strval', $validated['contactos']);
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }

        // Atualização dos dados do centro
        $centro->update($validated);

        // Retorno de resposta JSON para o frontend
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Centro atualizado com sucesso!',
            'dados' => $centro
        ]);
    }

    // Deletar
    /**
     * @OA\Delete(
     *     path="/centros/{id}",
     *     tags={"Centros"},
     *     summary="Deletar centro",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Centro deletado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Centro não encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $centro = Centro::find($id);

        if (!$centro) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Centro não encontrado!'
            ], 404); // 404 = Not Found
        }

        // Deletar o centro
        $centro->delete();

        // Retorno de resposta JSON para o frontend
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Centro deletado com sucesso!'
        ]);
    }
}