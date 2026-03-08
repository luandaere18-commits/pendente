<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Formador;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Formadores",
 *     description="Operações relacionadas aos formadores"
 * )
 */
class FormadorController extends Controller
{


    /**
     * @OA\Get(
     *     path="/formadores",
     *     tags={"Formadores"},
     *     summary="Listar todos os formadores",
     *     @OA\Parameter(
     *         name="busca",
     *         in="query",
     *         required=false,
     *         description="Busca textual em nome, especialidade ou bio",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de formadores",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Formador"))
     *     )
     * )
     */
    public function index(Request $request)
    {
        // Busca todos os formadores, incluindo cursos e centros relacionados
        $query = Formador::with(['cursos', 'centros']);
        // Permite busca textual por nome, especialidade ou bio
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('nome', 'like', "%$busca%")
                  ->orWhere('especialidade', 'like', "%$busca%")
                  ->orWhere('bio', 'like', "%$busca%");
            });
        }
        $formadores = $query->get();
        // Retorna lista de formadores
        return response()->json($formadores);
    }


    /**
     * @OA\Post(
     *     path="/formadores",
     *     tags={"Formadores"},
     *     summary="Criar um novo formador",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FormadorInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Formador criado",
     *         @OA\JsonContent(ref="#/components/schemas/Formador")
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos na requisição
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|unique:formadores,email',
            'contactos' => 'nullable|array',
            'contactos.*.tipo' => 'nullable|string',
            'contactos.*.valor' => 'nullable|string',
            'especialidade' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500',
            'foto_url' => 'nullable|url|max:255',
            'cursos' => 'array',
            'cursos.*' => 'exists:cursos,id',
            'centros' => 'array',
            'centros.*' => 'exists:centros,id'
        ]);

        // Processar contactos: garantir formato consistente
        if (isset($validated['contactos']) && is_array($validated['contactos'])) {
            $contactosProcessados = [];
            foreach ($validated['contactos'] as $contacto) {
                if (is_array($contacto) && !empty($contacto['tipo']) && !empty($contacto['valor'])) {
                    // Formato novo: array de objetos - só adiciona se ambos tipo e valor estiverem preenchidos
                    $contactosProcessados[] = [
                        'tipo' => $contacto['tipo'],
                        'valor' => $contacto['valor']
                    ];
                } elseif (is_string($contacto)) {
                    // Formato antigo: string simples
                    $contactosProcessados[] = $contacto;
                }
            }
            $validated['contactos'] = $contactosProcessados;
        } else {
            // Se não há contactos, define como array vazio
            $validated['contactos'] = [];
        }
        
        // Normaliza o email para minúsculas
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }
        // Cria o formador
        $formador = Formador::create($validated);
        // Associa cursos ao formador, se enviados
        if ($request->has('cursos')) {
            $formador->cursos()->sync($request->cursos);
        }
        // Associa centros ao formador, se enviados
        if ($request->has('centros')) {
            $formador->centros()->sync($request->centros);
        }
        // Retorna resposta de sucesso com dados completos
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Formador cadastrado com sucesso!',
            'dados' => $formador->load(['cursos', 'centros'])
        ], 201);
    }



    /**
     * @OA\Get(
     *     path="/formadores/{id}",
     *     tags={"Formadores"},
     *     summary="Buscar formador por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formador encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Formador")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formador não encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        // Busca formador por ID, incluindo cursos e centros
        $formador = Formador::with(['cursos', 'centros'])->find($id);
        if (!$formador) {
            // Retorna erro se não encontrado
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Formador não encontrado!'
            ], 404);
        }
        // Retorna dados do formador
        return response()->json(['status' => 'sucesso', 'dados' => $formador]);
    }



    /**
     * @OA\Put(
     *     path="/formadores/{id}",
     *     tags={"Formadores"},
     *     summary="Atualizar formador",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FormadorInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formador atualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Formador")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formador não encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Busca formador para atualizar
        $formador = Formador::find($id);
        if (!$formador) {
            // Retorna erro se não encontrado
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Formador não encontrado!'
            ], 404);
        }
        // Validação dos dados recebidos
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|unique:formadores,email' . ($request->method() === 'PUT' ? ',' . $id : ''),
            'contactos' => 'nullable|array',
            'contactos.*.tipo' => 'nullable|string',
            'contactos.*.valor' => 'nullable|string',
            'especialidade' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500',
            'foto_url' => 'nullable|url|max:255',
            'cursos' => 'array',
            'cursos.*' => 'exists:cursos,id',
            'centros' => 'array',
            'centros.*' => 'exists:centros,id'
        ]);
        
        // Processar contactos: garantir formato consistente
        if (isset($validated['contactos']) && is_array($validated['contactos'])) {
            $contactosProcessados = [];
            foreach ($validated['contactos'] as $contacto) {
                if (is_array($contacto) && !empty($contacto['tipo']) && !empty($contacto['valor'])) {
                    // Formato novo: array de objetos - só adiciona se ambos tipo e valor estiverem preenchidos
                    $contactosProcessados[] = [
                        'tipo' => $contacto['tipo'],
                        'valor' => $contacto['valor']
                    ];
                } elseif (is_string($contacto)) {
                    // Formato antigo: string simples
                    $contactosProcessados[] = $contacto;
                }
            }
            $validated['contactos'] = $contactosProcessados;
        } else {
            // Se não há contactos, define como array vazio
            $validated['contactos'] = [];
        }
        
        // Normaliza o email para minúsculas
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }
        // Atualiza dados do formador
        $formador->update($validated);
        // Atualiza cursos associados
        if ($request->has('cursos')) {
            $formador->cursos()->sync($request->cursos);
        }
        // Atualiza centros associados
        if ($request->has('centros')) {
            $formador->centros()->sync($request->centros);
        }
        // Retorna resposta de sucesso
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Formador atualizado com sucesso!',
            'dados' => $formador->load(['cursos', 'centros'])
        ]);
    }



    /**
     * @OA\Delete(
     *     path="/formadores/{id}",
     *     tags={"Formadores"},
     *     summary="Deletar formador",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formador deletado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formador não encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        // Busca formador para deletar
        $formador = Formador::find($id);
        if (!$formador) {
            // Retorna erro se não encontrado
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Formador não encontrado!'
            ], 404);
        }
        // Remove associações N:N antes de deletar
        $formador->cursos()->detach();
        $formador->centros()->detach();
        $formador->delete();
        // Retorna resposta de sucesso
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Formador deletado com sucesso!'
        ]);
    }
}