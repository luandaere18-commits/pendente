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
        
        // Filtro por múltiplos centros
        if ($request->filled('centros')) {
            $centros = is_array($request->centros) ? $request->centros : explode(',', $request->centros);
            $query->whereHas('centros', function($q) use ($centros) {
                $q->whereIn('centros.id', $centros);
            });
        }

        // Filtro por centro único
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

        // Busca textual
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('nome', 'like', '%' . $busca . '%')
                  ->orWhere('descricao', 'like', '%' . $busca . '%')
                  ->orWhere('programa', 'like', '%' . $busca . '%')
                  ->orWhere('area', 'like', '%' . $busca . '%');
            });
        }

        $cursos = $query->get();
        
        // AJAX/JSON request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($cursos, 200);
        }
        
        return view('cursos.index', compact('cursos'));
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
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) {
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
            'centro_curso' => 'required|array|min:1',
            'centro_curso.*.centro_id' => 'required|integer|exists:centros,id',
            'centro_curso.*.preco' => 'required|numeric|min:0',
        ]);

        $curso = DB::transaction(function () use ($validated, $request) {
            $cursoData = [
                'nome' => $validated['nome'],
                'descricao' => $validated['descricao'] ?? null,
                'programa' => $validated['programa'] ?? null,
                'area' => $validated['area'],
                'modalidade' => $validated['modalidade'],
                'ativo' => $request->input('ativo', '1') == '1' ? true : false,
            ];

            // Upload de imagem
            if ($request->hasFile('imagem')) {
                $file = $request->file('imagem');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = Storage::disk('public')->putFileAs('cursos', $file, $filename);

                if (Storage::disk('public')->exists($path)) {
                    $cursoData['imagem_url'] = '/storage/' . $path;
                } else {
                    \Log::warning('Falha ao salvar imagem do curso: ' . $path);
                }
            }

            $curso = Curso::create($cursoData);

            // Associar centros
            foreach ($validated['centro_curso'] as $centroDado) {
                $curso->centros()->attach($centroDado['centro_id'], [
                    'preco' => $centroDado['preco']
                ]);
            }

            return $curso;
        }, 5);

        // AJAX/JSON request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Curso criado com sucesso!',
                'dados' => $curso->load('centros')
            ], 201);
        }

        return redirect()->route('cursos.index')->with('success', 'Curso criado com sucesso!');
    }

    public function show($id)
    {
        $curso = Curso::with([
            'centros' => function($query) {
                // Garantir que pegamos os campos necessários da relação
                $query->select('centros.id', 'centros.nome', 'centros.localizacao', 'centros.contactos', 'centros.email');
            },
            'turmas' => function($query) {
                // Eager load turmas com seus relacionamentos
                $query->with(['centro', 'formador']);
            }
        ])->find($id);
        
        if (!$curso) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Curso não encontrado!'
                ], 404);
            }
            abort(404);
        }

        // Log para debug - verificar se centros e pivot estão carregando
        \Log::info('Curso carregado para visualização', [
            'curso_id' => $curso->id,
            'centros_count' => $curso->centros->count(),
            'centros_com_pivot' => $curso->centros->map(function($c) {
                return [
                    'id' => $c->id,
                    'nome' => $c->nome,
                    'tem_pivot' => isset($c->pivot),
                    'preco' => $c->pivot->preco ?? null
                ];
            })->toArray(),
            'turmas_count' => $curso->turmas->count()
        ]);

        // AJAX/JSON request
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'dados' => $curso  // ← SEMPRE O MESMO FORMATO!
            ], 200);
        }

        $centros = Centro::all();
        $formadores = Formador::all();
        return view('cursos.show', compact('curso', 'centros', 'formadores'));
    }

    public function edit($id)
    {
        $curso = Curso::find($id);
        
        if (!$curso) {
            abort(404);
        }

        $curso->load(['centros', 'turmas.centro', 'turmas.formador']);
        $centros = Centro::all();
        $diasSemana = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
        $periodos = ['manha', 'tarde', 'noite'];
        
        return view('cursos.edit', compact('curso', 'centros', 'diasSemana', 'periodos'));
    }

    public function update(Request $request, $id)
    {
        try {
            $curso = Curso::findOrFail($id);

            $rules = [
                'nome' => 'required|string|max:100|unique:cursos,nome,' . $curso->id,
                'descricao' => 'nullable|string|max:1000',
                'programa' => 'nullable|string|max:10000',
                'area' => 'required|string|max:100',
                'modalidade' => 'required|in:presencial,online,hibrido',
                'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'ativo' => 'nullable|boolean',
                'centro_curso' => 'nullable|array',
                'centro_curso.*.centro_id' => 'nullable|integer|exists:centros,id',
                'centro_curso.*.preco' => 'nullable|numeric|min:0',
            ];
            
            $validated = $request->validate($rules);

            // Garantir que campos opcionais sejam string
            $validated['descricao'] = $validated['descricao'] ?? '';
            $validated['programa'] = $validated['programa'] ?? '';

            $cursoData = [
                'nome' => $validated['nome'],
                'descricao' => $validated['descricao'],
                'programa' => $validated['programa'],
                'area' => $validated['area'],
                'modalidade' => $validated['modalidade'],
                'ativo' => $request->input('ativo', '1') == '1' ? true : false,
            ];

            // Upload de imagem
            if ($request->hasFile('imagem')) {
                try {
                    $file = $request->file('imagem');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = Storage::disk('public')->putFileAs('cursos', $file, $filename);

                    if (Storage::disk('public')->exists($path)) {
                        $cursoData['imagem_url'] = '/storage/' . $path;
                    } else {
                        \Log::warning('Falha ao salvar imagem do curso: ' . $path);
                    }
                } catch (\Exception $imgError) {
                    \Log::error('Erro ao processar imagem: ' . $imgError->getMessage());
                    throw $imgError;
                }
            }

            $curso->update($cursoData);

            // Atualizar Centro-Curso se fornecido
            if (isset($validated['centro_curso']) && is_array($validated['centro_curso'])) {
                $centrosData = array_filter($validated['centro_curso'], function($item) {
                    return !empty($item['centro_id']) && isset($item['preco']) && $item['preco'] !== '';
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

            // AJAX/JSON request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'sucesso',
                    'mensagem' => 'Curso atualizado com sucesso',
                    'dados' => $curso->load('centros')
                ], 200);
            }

            return redirect()->route('cursos.index')->with('success', 'Curso atualizado com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar curso: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Erro ao atualizar curso'
                ], 500);
            }
            
            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar curso'])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $curso = Curso::findOrFail($id);

            // Verificar se existem turmas associadas
            if ($curso->turmas()->count() > 0) {
                $message = 'Não é possível eliminar o curso pois existem turmas associadas.';
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'status' => 'erro',
                        'mensagem' => $message
                    ], 409);
                }
                return redirect()->route('cursos.index')->with('error', $message);
            }

            DB::transaction(function () use ($curso) {
                // Remover associações com centros
                $curso->centros()->detach();

                // Remover imagem
                if ($curso->imagem_url) {
                    $path = ltrim(str_replace('/storage/', '', $curso->imagem_url), '/');
                    Storage::disk('public')->delete($path);
                }

                $curso->delete();
            });

            // AJAX/JSON request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'status' => 'sucesso',
                    'mensagem' => 'Curso deletado com sucesso'
                ], 200);
            }

            return redirect()->route('cursos.index')->with('success', 'Curso deletado com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Erro ao excluir curso: ' . $e->getMessage(), [
                'curso_id' => $id,
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);

            $msg = 'Erro ao eliminar curso. Por favor tente novamente.';
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => $msg
                ], 500);
            }

            return redirect()->route('cursos.index')->with('error', $msg);
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
            ]);

            // Verificar se centro já está associado
            if ($curso->centros()->where('centro_id', $validated['centro_id'])->exists()) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Este centro já está associado ao curso.'
                ], 409);
            }

            $curso->centros()->attach($validated['centro_id'], [
                'preco' => $validated['preco']
            ]);

            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Centro associado com sucesso!',
                'dados' => $curso->load('centros')
            ], 201);

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

            $curso->centros()->detach($centroId);

            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Centro desassociado com sucesso!',
                'dados' => $curso->load('centros')
            ], 200);

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
        try {
            $curso = Curso::findOrFail($id);

            $validated = $request->validate([
                'preco' => 'required|numeric|min:0',
            ]);

            // Verificar se centro está associado
            if (!$curso->centros()->where('centro_id', $centroId)->exists()) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Este centro não está associado ao curso.'
                ], 404);
            }

            $curso->centros()->updateExistingPivot($centroId, [
                'preco' => $validated['preco'],
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
            ], 500);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $curso = Curso::findOrFail($id);
            $curso->ativo = !$curso->ativo;
            $curso->save();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'status' => 'sucesso',
                    'mensagem' => 'Status do curso alterado!',
                    'ativo' => $curso->ativo
                ], 200);
            }

            return redirect()->route('cursos.index')->with('success', 'Status do curso alterado!');

        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Erro ao alterar status'
                ], 500);
            }
            return redirect()->route('cursos.index')->with('error', 'Erro ao alterar status');
        }
    }
}

