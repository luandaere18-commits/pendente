<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Centro;
use App\Models\Formador;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $query = Curso::with(['centros', 'turmas']);
        
        if ($request->has('nome') && $request->nome) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }
        
        if ($request->has('modalidade') && $request->modalidade) {
            $query->where('modalidade', $request->modalidade);
        }
        
        if ($request->has('ativo') && $request->ativo !== '') {
            $query->where('ativo', (bool)$request->ativo);
        }
        
        $cursos = $query->get();
        
        return view('cursos.index', compact('cursos'))->with([
            'filtroNome' => $request->nome,
            'filtroModalidade' => $request->modalidade,
            'filtroStatus' => $request->ativo
        ]);
    }

    public function create()
    {
        $centros = Centro::all();
        $diasSemana = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
        $periodos = ['manha', 'tarde', 'noite'];
        
        return view('cursos.create', compact('centros', 'diasSemana', 'periodos'));
    }

    public function store(Request $request)
    {
        // Validar dados do curso
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) {
                    // Verificar se curso com este nome já existe
                    if (Curso::where('nome', $value)->exists()) {
                        $fail('Um curso com este nome já existe.');
                    }
                },
            ],
            'descricao' => 'nullable|string|max:1000',
            'programa' => 'nullable|string|max:5000',
            'area' => 'required|string|max:100',
            'modalidade' => 'required|in:presencial,online,hibrido',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ativo' => 'nullable',
            
            // Centro-Curso
            'centro_curso' => 'required|array|min:1',
            'centro_curso.*.centro_id' => 'required|integer|exists:centros,id',
            'centro_curso.*.preco' => 'required|numeric|min:0',
        ]);

        // 1. Criar Curso e Centro-Curso em transação atômica
        $curso = DB::transaction(function () use ($validated, $request) {
            // Preparar dados do curso
            $cursoData = [
                'nome' => $validated['nome'],
                'descricao' => $validated['descricao'] ?? null,
                'programa' => $validated['programa'] ?? null,
                'area' => $validated['area'],
                'modalidade' => $validated['modalidade'],
                'ativo' => $request->input('ativo', '1') == '1' ? true : false,
            ];

            // Processar upload de imagem
            if ($request->hasFile('imagem')) {
                $file = $request->file('imagem');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = Storage::disk('public')->putFileAs('cursos', $file, $filename);

                // Garantir que o arquivo existe antes de salvar a URL
                if (Storage::disk('public')->exists($path)) {
                    $cursoData['imagem_url'] = Storage::disk('public')->url($path);
                } else {
                    \Log::warning('Falha ao salvar imagem do curso (arquivo não encontrado): ' . $path);
                }
            }

            // Criar o Curso
            $curso = Curso::create($cursoData);

            // Criar Centro-Curso (relação muitos-para-muitos)
            foreach ($validated['centro_curso'] as $centroDado) {
                $curso->centros()->attach($centroDado['centro_id'], [
                    'preco' => $centroDado['preco']
                ]);
            }

            return $curso;
        }, 5); // 5 tentativas em caso de deadlock

        // 2. Criar turmas INDEPENDENTEMENTE (fora da transação)
        // Removido - turmas são agora gerenciados independentemente

        return redirect()->route('cursos.index')
            ->with('success', 'Curso e centros criados com sucesso!');
    }

    public function show(Curso $curso)
    {
        // Eager load relationships to avoid N+1 when exibiting turmas com centro/formador
        $curso->load(['centros', 'turmas.centro', 'turmas.formador']);
        $centros = Centro::all();
        $formadores = Formador::all();
        return view('cursos.show', compact('curso', 'centros', 'formadores'));
    }

    public function edit(Curso $curso)
    {
        $curso->load(['centros', 'turmas.centro', 'turmas.formador']);
        $centros = Centro::all();
        $diasSemana = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
        $periodos = ['manha', 'tarde', 'noite'];
        
        return view('cursos.edit', compact('curso', 'centros', 'diasSemana', 'periodos'));
    }

    public function update(Request $request, Curso $curso)
    {
        try {
            // Validação diferenciada: se vem de API (JSON), aceita parcial; se form, centros são opcionais
            $isApi = $request->wantsJson() || $request->isJson();
        
        $rules = [
            'nome' => 'required|string|max:100|unique:cursos,nome,' . $curso->id,
            'descricao' => 'nullable|string|max:1000',
            'programa' => 'nullable|string|max:10000', // Aumentado para permitir listas maiores
            'area' => 'required|string|max:100',
            'modalidade' => 'required|in:presencial,online,hibrido',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ativo' => 'nullable|boolean',
            'centro_curso' => 'nullable|array',
            'centro_curso.*.centro_id' => 'nullable|integer|exists:centros,id',
            'centro_curso.*.preco' => 'nullable|numeric|min:0',
        ];
        
        $validated = $request->validate($rules);

        // CORREÇÃO: Garantir que campos opcionais sejam string, nunca null
        $validated['descricao'] = isset($validated['descricao']) && $validated['descricao'] !== null 
            ? (string)$validated['descricao'] 
            : '';
            
        $validated['programa'] = isset($validated['programa']) && $validated['programa'] !== null 
            ? (string)$validated['programa'] 
            : '';

        // 1. Atualizar Curso
        $cursoData = [
            'nome' => $validated['nome'],
            'descricao' => $validated['descricao'] ?? '',
            'programa' => $validated['programa'] ?? '',
            'area' => $validated['area'],
            'modalidade' => $validated['modalidade'],
            'ativo' => $request->input('ativo', '1') == '1' ? true : false,
        ];

        // Processar upload de imagem
        if ($request->hasFile('imagem')) {
            try {
                \Log::info('Upload de imagem iniciado', [
                    'file_name' => $request->file('imagem')->getClientOriginalName(),
                    'file_size' => $request->file('imagem')->getSize(),
                    'file_mime' => $request->file('imagem')->getMimeType(),
                ]);

                $file = $request->file('imagem');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = Storage::disk('public')->putFileAs('cursos', $file, $filename);

                if (Storage::disk('public')->exists($path)) {
                    // Usar caminho relativo para evitar problemas de host/porta (ex: localhost:8000)
                    $cursoData['imagem_url'] = '/storage/' . $path;
                    \Log::info('Imagem guardada com sucesso', [
                        'path' => $path,
                        'url' => $cursoData['imagem_url'],
                    ]);
                } else {
                    \Log::warning('Falha ao salvar imagem do curso (arquivo não encontrado): ' . $path);
                }
            } catch (\Exception $imgError) {
                \Log::error('Erro ao processar imagem: ' . $imgError->getMessage(), [
                    'exception' => $imgError,
                    'trace' => $imgError->getTraceAsString(),
                ]);
                throw $imgError;
            }
        }

        // Atualizar o Curso
        $curso->update($cursoData);

        // 2. Atualizar Centro-Curso se for formulário e houver dados válidos
        if (!$isApi && isset($validated['centro_curso'])) {
            $centrosData = $validated['centro_curso'];
            // Filtrar entradas válidas (centro_id não vazio e preco válido)
            $centrosData = array_filter($centrosData, function($item) {
                return !empty($item['centro_id']) && isset($item['preco']) && $item['preco'] !== '' && is_numeric($item['preco']) && $item['preco'] >= 0;
            });
            if (!empty($centrosData)) {
                DB::transaction(function () use ($centrosData, $curso) {
                    $curso->centros()->detach();
                    foreach ($centrosData as $centroDado) {
                        $curso->centros()->attach($centroDado['centro_id'], [
                            'preco' => $centroDado['preco']
                        ]);
                    }
                }, 5);
            }
        }

        // Retornar resposta apropriada
        if ($isApi) {
            return response()->json([
                'success' => true,
                'message' => 'Curso atualizado com sucesso',
                'data' => $curso
            ]);
        }

        return redirect()->route('cursos.index')
            ->with('success', 'Curso atualizado com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar curso: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);
            
            if ($isApi) {
                return response()->json([
                    'status' => 'erro',
                    'error' => $e->getMessage(),
                    'debug' => config('app.debug') ? $e->getTraceAsString() : null,
                    'message' => 'Erro ao atualizar curso'
                ], 500);
            }
            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar curso: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Curso deletado com sucesso'
            ]);
        }
        
        return redirect()->route('cursos.index')->with('success', 'Curso deletado com sucesso!');
    }

    public function toggleStatus(Curso $curso)
    {
        $curso->ativo = !$curso->ativo;
        $curso->save();
        return redirect()->route('cursos.index')->with('success', 'Status do curso alterado!');
    }

    /**
     * Associar um centro a um curso
     */
    public function attachCentro(Request $request, Curso $curso)
    {
        $validated = $request->validate([
            'centro_id' => 'required|integer|exists:centros,id',
            'preco' => 'required|numeric|min:0',
        ]);

        try {
            $curso->centros()->attach($validated['centro_id'], [
                'preco' => $validated['preco']
            ]);

            return response()->json(['success' => true, 'message' => 'Centro associado com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Atualizar um centro associado a um curso
     */
    public function updateCentro(Request $request, Curso $curso, $centroId)
    {
        $validated = $request->validate([
            'preco' => 'required|numeric|min:0',
        ]);

        try {
            $curso->centros()->updateExistingPivot($centroId, [
                'preco' => $validated['preco']
            ]);

            return response()->json(['success' => true, 'message' => 'Centro atualizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Desassociar um centro de um curso
     */
    public function detachCentro(Request $request, Curso $curso, $centroId)
    {
        try {
            $curso->centros()->detach($centroId);
            return response()->json(['success' => true, 'message' => 'Centro removido com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}

