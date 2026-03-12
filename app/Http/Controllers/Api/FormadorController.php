<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Formador;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        try {
            // Busca todos os formadores, incluindo centros
            $formadores = Formador::with('centros')->get();
            
            // Retorna lista de formadores
            return response()->json(['data' => $formadores]);
        } catch (\Exception $e) {
            \Log::error('Erro ao carregar formadores: ' . $e->getMessage());
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Erro ao carregar formadores: ' . $e->getMessage()
            ], 500);
        }
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
            'contactos.*' => 'nullable|string',
            'especialidade' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_url' => 'nullable|url|max:255',
            'centros' => 'nullable|array',
            'centros.*' => 'integer|exists:centros,id'
        ]);

        // Processar contactos: remover strings vazias
        $contactosProcessados = [];
        if (isset($validated['contactos']) && is_array($validated['contactos'])) {
            foreach ($validated['contactos'] as $contacto) {
                if (is_string($contacto) && !empty(trim($contacto))) {
                    $contactosProcessados[] = trim($contacto);
                }
            }
        }
        $validated['contactos'] = $contactosProcessados;
        
        // Normaliza o email para minúsculas
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }

        // Remover campos que não se deve criar diretamente
        unset($validated['foto_url']);

        // Processar upload de foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('formadores', $filename, 'public');
            $validated['foto_url'] = '/storage/' . $path;
        }

        // Remove 'foto' do validated pois já foi processada
        unset($validated['foto']);

        // Cria o formador
        $formador = Formador::create($validated);
        
        // Associa centros ao formador, se enviados
        if ($request->has('centros') && is_array($request->centros)) {
            $formador->centros()->sync($request->centros);
        }
        
        // Retorna resposta de sucesso com dados completos
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Formador cadastrado com sucesso!',
            'data' => $formador->load(['centros', 'turmas.curso'])
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
    public function show(Formador $formador)
    {
        // Busca formador por ID, incluindo centros e turmas
        $formador = $formador->load(['centros', 'turmas.curso']);
        // Retorna dados do formador
        return response()->json(['data' => $formador]);
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
    public function update(Request $request, Formador $formador)
    {
        // Validação dos dados recebidos
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => ['nullable', 'email', 'max:100', Rule::unique('formadores')->ignore($formador->id)],
            'contactos' => 'nullable|array',
            'contactos.*' => 'nullable|string',
            'especialidade' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_url' => 'nullable|url|max:255',
            'centros' => 'nullable|array',
            'centros.*' => 'integer|exists:centros,id'
        ]);
        
        // Processar contactos: remover strings vazias
        $contactosProcessados = [];
        if (isset($validated['contactos']) && is_array($validated['contactos'])) {
            foreach ($validated['contactos'] as $contacto) {
                if (is_string($contacto) && !empty(trim($contacto))) {
                    $contactosProcessados[] = trim($contacto);
                }
            }
        }
        $validated['contactos'] = $contactosProcessados;
        
        // Normaliza o email para minúsculas
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }

        // Processar upload de foto antes de unset
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('formadores', $filename, 'public');
            $validated['foto_url'] = '/storage/' . $path;
        } else {
            // Remover foto_url se não houve novo upload
            unset($validated['foto_url']);
        }

        // Remove 'foto' do validated (sempre, pois já foi processada)
        unset($validated['foto']);

        // Atualiza dados do formador (incluindo foto_url se houve upload)
        $formador->update($validated);
        
        // Atualiza centros associados (replace com novos, remover antigos se necessário)
        if ($request->has('centros') && is_array($request->centros)) {
            $formador->centros()->sync($request->centros);
        } elseif ($request->has('centros') && $request->centros === null) {
            // Se centros foi explicitamente enviado como null, remover todos
            $formador->centros()->detach();
        }
        
        // Retorna resposta de sucesso
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Formador atualizado com sucesso!',
            'data' => $formador->load(['centros', 'turmas.curso'])
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
    public function destroy(Formador $formador)
    {
        // Remove associações N:N antes de deletar
        $formador->centros()->detach();
        $formador->delete();
        // Retorna resposta de sucesso
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Formador deletado com sucesso!'
        ]);
    }
}