<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Centro;
use App\Models\Cronograma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::with(['centros', 'formadores', 'cronogramas', 'preInscricoes'])->get();
        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        $centros = Centro::all();
        $diasSemana = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
        $periodos = ['manhã', 'tarde', 'noite'];
        
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
            'descricao' => 'nullable|string',
            'programa' => 'nullable|string',
            'area' => 'required|string|max:100',
            'modalidade' => 'required|in:presencial,online,hibrido',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ativo' => 'nullable',
            
            // Centro-Curso
            'centro_curso' => 'required|array|min:1',
            'centro_curso.*.centro_id' => 'required|integer|exists:centros,id',
            'centro_curso.*.preco' => 'required|numeric|min:0',
            'centro_curso.*.duracao' => 'required|string|max:100',
            'centro_curso.*.data_arranque' => 'required|date|after_or_equal:today',
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
                $path = $file->storeAs('cursos', $filename, 'public');
                $cursoData['imagem_url'] = '/storage/' . $path;
            }

            // Criar o Curso
            $curso = Curso::create($cursoData);

            // Criar Centro-Curso (relação muitos-para-muitos)
            foreach ($validated['centro_curso'] as $centroDado) {
                $curso->centros()->attach($centroDado['centro_id'], [
                    'preco' => $centroDado['preco'],
                    'duracao' => $centroDado['duracao'],
                    'data_arranque' => $centroDado['data_arranque'] ?? null
                ]);
            }

            return $curso;
        }, 5); // 5 tentativas em caso de deadlock

        // 2. Criar Cronogramas INDEPENDENTEMENTE (fora da transação)
        // Removido - cronogramas são agora gerenciados independentemente

        return redirect()->route('cursos.index')
            ->with('success', 'Curso e centros criados com sucesso!');
    }

    public function show(Curso $curso)
    {
        $curso->load(['centros', 'formadores', 'cronogramas', 'preInscricoes']);
        $centros = Centro::all();
        return view('cursos.show', compact('curso', 'centros'));
    }

    public function edit(Curso $curso)
    {
        $curso->load(['centros', 'cronogramas']);
        $centros = Centro::all();
        $diasSemana = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
        $periodos = ['manhã', 'tarde', 'noite'];
        
        return view('cursos.edit', compact('curso', 'centros', 'diasSemana', 'periodos'));
    }

    public function update(Request $request, Curso $curso)
    {
        // Validação diferenciada: se vem de API (JSON), aceita parcial; se form, exige centros
        $isApi = $request->wantsJson();
        
        $rules = [
            'nome' => 'required|string|max:100|unique:cursos,nome,' . $curso->id,
            'descricao' => 'nullable|string',
            'programa' => 'nullable|string',
            'area' => 'required|string|max:100',
            'modalidade' => 'required|in:presencial,online,hibrido',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ativo' => 'nullable',
        ];
        
        // Só exige centros se for formulário tradicional (não API JSON)
        if (!$isApi) {
            $rules['centro_curso'] = 'required|array|min:1';
            $rules['centro_curso.*.centro_id'] = 'required|integer|exists:centros,id';
            $rules['centro_curso.*.preco'] = 'required|numeric|min:0';
            $rules['centro_curso.*.duracao'] = 'required|string|max:100';
            $rules['centro_curso.*.data_arranque'] = 'required|date|after_or_equal:today';
        }
        
        $validated = $request->validate($rules);

        // 1. Atualizar Curso
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
            $path = $file->storeAs('cursos', $filename, 'public');
            $cursoData['imagem_url'] = '/storage/' . $path;
        }

        // Atualizar o Curso
        $curso->update($cursoData);

        // 2. Só atualizar Centro-Curso se for formulário (não é API)
        if (!$isApi && isset($validated['centro_curso'])) {
            DB::transaction(function () use ($validated, $curso) {
                $curso->centros()->detach();
                foreach ($validated['centro_curso'] as $centroDado) {
                    $curso->centros()->attach($centroDado['centro_id'], [
                        'preco' => $centroDado['preco'],
                        'duracao' => $centroDado['duracao'],
                        'data_arranque' => $centroDado['data_arranque'] ?? null
                    ]);
                }
            }, 5);
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
            'duracao' => 'required|string|max:100',
            'data_arranque' => 'required|date',
        ]);

        try {
            $curso->centros()->attach($validated['centro_id'], [
                'preco' => $validated['preco'],
                'duracao' => $validated['duracao'],
                'data_arranque' => $validated['data_arranque'] ?? null
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
            'duracao' => 'required|string|max:100',
            'data_arranque' => 'required|date',
        ]);

        try {
            $curso->centros()->updateExistingPivot($centroId, [
                'preco' => $validated['preco'],
                'duracao' => $validated['duracao'],
                'data_arranque' => $validated['data_arranque']
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

