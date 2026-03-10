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
            'nome' => 'required|string|max:100|unique:cursos,nome',
            'descricao' => 'nullable|string',
            'programa' => 'nullable|string',
            'area' => 'required|string|max:100',
            'modalidade' => 'required|in:presencial,online,hibrido',
            'ativo' => 'nullable',
            
            // Centro-Curso
            'centro_curso' => 'required|array|min:1',
            'centro_curso.*.centro_id' => 'required|integer|exists:centros,id',
            'centro_curso.*.preco' => 'required|numeric|min:0',
            'centro_curso.*.duracao' => 'required|string|max:100',
            'centro_curso.*.data_arranque' => 'required|date|after_or_equal:today',
            
            // Cronogramas
            'cronogramas' => 'required|array|min:1',
            'cronogramas.*.dia_semana' => 'required|array|min:1',
            'cronogramas.*.dia_semana.*' => 'required|in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
            'cronogramas.*.periodo' => 'required|in:manhã,tarde,noite',
            'cronogramas.*.hora_inicio' => 'nullable|date_format:H:i',
            'cronogramas.*.hora_fim' => 'nullable|date_format:H:i',
        ]);

        // Executar tudo em uma transação
        return DB::transaction(function () use ($validated, $request) {
            // Preparar dados do curso
            $cursoData = [
                'nome' => $validated['nome'],
                'descricao' => $validated['descricao'] ?? null,
                'programa' => $validated['programa'] ?? null,
                'area' => $validated['area'],
                'modalidade' => $validated['modalidade'],
                'ativo' => $request->input('ativo', '1') == '1' ? true : false,
            ];

            // 1. Criar o Curso
            $curso = Curso::create($cursoData);

            // 2. Criar Centro-Curso (relação muitos-para-muitos)
            foreach ($validated['centro_curso'] as $centroDado) {
                $curso->centros()->attach($centroDado['centro_id'], [
                    'preco' => $centroDado['preco'],
                    'duracao' => $centroDado['duracao'],
                    'data_arranque' => $centroDado['data_arranque'] ?? null
                ]);
            }

            // 3. Criar Cronogramas
            foreach ($validated['cronogramas'] as $cronoDado) {
                // Validar hora_fim > hora_inicio
                if (!empty($cronoDado['hora_inicio']) && !empty($cronoDado['hora_fim'])) {
                    if ($cronoDado['hora_fim'] <= $cronoDado['hora_inicio']) {
                        throw ValidationException::withMessages([
                            'cronogramas.*.hora_fim' => 'A hora de fim deve ser maior que a hora de início.'
                        ]);
                    }
                }

                // Validar hora_inicio com base no período
                $this->validarHoraComPeriodo($cronoDado);

                Cronograma::create([
                    'curso_id' => $curso->id,
                    'dia_semana' => $cronoDado['dia_semana'], // Array de dias da semana
                    'periodo' => $cronoDado['periodo'],
                    'hora_inicio' => $cronoDado['hora_inicio'] ?? null,
                    'hora_fim' => $cronoDado['hora_fim'] ?? null,
                ]);
            }

            return redirect()->route('cursos.index')
                ->with('success', 'Curso, centros e cronogramas criados com sucesso!');
        }, 5); // 5 tentativas em caso de deadlock
    }

    public function show(Curso $curso)
    {
        $curso->load(['centros', 'formadores', 'cronogramas', 'preInscricoes']);
        return view('cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:cursos,nome,' . $curso->id,
            'descricao' => 'nullable|string',
            'programa' => 'nullable|string',
            'area' => 'required|string|max:100',
            'modalidade' => 'required|in:presencial,online,hibrido',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ativo' => 'nullable',
            'centros' => 'required|array|min:1',
            'centros.*.centro_id' => 'required|integer|exists:centros,id',
            'centros.*.preco' => 'required|numeric|min:0',
            'centros.*.duracao' => 'required|string|max:100',
            'centros.*.data_arranque' => 'required|date|after_or_equal:today'
        ]);
        
        // Garantir que ativo seja boolean
        $validated['ativo'] = $request->input('ativo', '1') == '1' ? true : false;
        
        // Processar upload de imagem
        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('cursos', $filename, 'public');
            $validated['imagem_url'] = '/storage/' . $path;
        }
        
        // Separar dados do curso dos dados dos centros
        $centrosData = $validated['centros'];
        unset($validated['centros']);
        
        // Atualizar o curso
        $curso->update($validated);
        
        // Atualizar centros (remover todos e adicionar novamente)
        $curso->centros()->detach();
        
        foreach ($centrosData as $centroDado) {
            $curso->centros()->attach($centroDado['centro_id'], [
                'preco' => $centroDado['preco'],
                'duracao' => $centroDado['duracao'],
                'data_arranque' => $centroDado['data_arranque'] ?? null
            ]);
        }
        
        return redirect()->route('cursos.index')->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('cursos.index')->with('success', 'Curso deletado com sucesso!');
    }

    public function toggleStatus(Curso $curso)
    {
        $curso->ativo = !$curso->ativo;
        $curso->save();
        return redirect()->route('cursos.index')->with('success', 'Status do curso alterado!');
    }

    /**
     * Validar hora de início com base no período
     */
    private function validarHoraComPeriodo(&$data)
    {
        if (!isset($data['hora_inicio']) || !isset($data['periodo']) || empty($data['hora_inicio'])) {
            return;
        }

        $hora = $data['hora_inicio'];
        $periodo = $data['periodo'];

        $validacoes = [
            'manhã' => ['07:00', '12:00'],
            'tarde' => ['12:00', '18:00'],
            'noite' => ['18:00', '22:00'],
        ];

        if (isset($validacoes[$periodo])) {
            [$horaMin, $horaMax] = $validacoes[$periodo];

            if ($hora < $horaMin || $hora >= $horaMax) {
                throw ValidationException::withMessages([
                    'cronogramas.*.hora_inicio' => "A hora de início deve estar entre {$horaMin} e " . date('H:i', strtotime($horaMax) - 60) . " para o período de {$periodo}."
                ]);
            }
        }
    }
}
