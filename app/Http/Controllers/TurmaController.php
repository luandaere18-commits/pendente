<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index(Request $request)
    {
        $query = Turma::with(['curso', 'formador', 'centro']);
        
        if ($request->has('curso_id') && $request->curso_id) {
            $query->where('curso_id', $request->curso_id);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('periodo') && $request->periodo) {
            $query->where('periodo', $request->periodo);
        }
        
        // Suportar paginação com per_page
        if ($request->has('per_page')) {
            $turmas = $query->paginate($request->per_page);
        } else {
            $turmas = $query->get();
        }
        
        // Se for requisição AJAX, retornar JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($turmas, 200);
        }
        
        $todosOsCursos = \App\Models\Curso::all();
        
        return view('turmas.index', compact('turmas', 'todosOsCursos'))->with([
            'filtroCurso' => $request->curso_id,
            'filtroStatus' => $request->status,
            'filtroPeriodo' => $request->periodo
        ]);
    }

    public function create()
    {
        $cursos = \App\Models\Curso::all();
        $formadores = \App\Models\Formador::all();
        return view('turmas.create', compact('cursos', 'formadores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'centro_id' => 'required|exists:centros,id',
            'formador_id' => 'nullable|exists:formadores,id',
            'duracao_semanas' => 'nullable|integer|min:1',
            'dia_semana' => 'required|array|min:1',
            'dia_semana.*' => 'required|in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
            'periodo' => 'required|in:manha,tarde,noite',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i',
            'data_arranque' => 'required|date',
            'vagas_totais' => 'required|integer|min:1',
            'status' => 'nullable|in:planeada,inscricoes_abertas,em_andamento,concluida',
            'publicado' => 'nullable|boolean'
        ]);
        
        // Validar que o centro está associado ao curso
        if (!\DB::table('centro_curso')->where('centro_id', $validated['centro_id'])->where('curso_id', $validated['curso_id'])->exists()) {
            return back()->withErrors(['centro_id' => 'O centro selecionado não oferece o curso escolhido.'])->withInput();
        }
        
        // Validar hora_inicio com base no periodo
        $this->validarHoraComPeriodo($validated);
        
        // Validar que hora_fim > hora_inicio
        $this->validarHoraFimMaiorQueHoraInicio($validated);
        
        $turma = Turma::create($validated);
        return redirect()->route('turmas.index')->with('success', 'Turma criada com sucesso!');
    }

    public function show(Turma $turma)
    {
        $turma->load(['curso', 'formador', 'centro']);
        
        // Retornar JSON para requisições AJAX
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['dados' => $turma], 200);
        }
        
        return view('turmas.show', compact('turma'));
    }

    public function edit(Turma $turma)
    {
        $cursos = \App\Models\Curso::all();
        $formadores = \App\Models\Formador::all();
        return view('turmas.edit', compact('turma', 'cursos', 'formadores'));
    }

    public function update(Request $request, Turma $turma)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'centro_id' => 'required|exists:centros,id',
            'formador_id' => 'nullable|exists:formadores,id',
            'duracao_semanas' => 'nullable|integer|min:1',
            'dia_semana' => 'required|array|min:1',
            'dia_semana.*' => 'required|in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
            'periodo' => 'required|in:manha,tarde,noite',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i',
            'data_arranque' => 'required|date',
            'vagas_totais' => 'required|integer|min:1',
            'status' => 'nullable|in:planeada,inscricoes_abertas,em_andamento,concluida',
            'publicado' => 'nullable|boolean'
        ]);
        
        // Validar que o centro está associado ao curso
        if (!\DB::table('centro_curso')->where('centro_id', $validated['centro_id'])->where('curso_id', $validated['curso_id'])->exists()) {
            return back()->withErrors(['centro_id' => 'O centro selecionado não oferece o curso escolhido.'])->withInput();
        }
        
        // Validar hora_inicio com base no periodo
        $this->validarHoraComPeriodo($validated);
        
        // Validar que hora_fim > hora_inicio
        $this->validarHoraFimMaiorQueHoraInicio($validated);
        
        $turma->update($validated);
        return redirect()->route('turmas.index')->with('success', 'Turma atualizada com sucesso!');
    }

    public function destroy(Turma $turma)
    {
        $turma->delete();
        return redirect()->route('turmas.index')->with('success', 'Turma deletada com sucesso!');
    }

    /**
     * Validar hora de início com base no período
     * 
     * @param array $data
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validarHoraComPeriodo(&$data)
    {
        if (!isset($data['hora_inicio']) || !isset($data['periodo'])) {
            return;
        }

        $hora = $data['hora_inicio'];
        $periodo = $data['periodo'];

        $validacoes = [
            'manha' => ['07:00', '12:00'],   // 07:00 até 11:59
            'tarde' => ['12:00', '18:00'],   // 12:00 até 17:59
            'noite' => ['18:00', '22:00'],   // 18:00 até 21:59
        ];

        if (isset($validacoes[$periodo])) {
            [$horaMin, $horaMax] = $validacoes[$periodo];
            
            if ($hora < $horaMin || $hora >= $horaMax) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'hora_inicio' => "A hora de início deve estar entre {$horaMin} e " . date('H:i', strtotime($horaMax) - 60) . " para o período de {$periodo}."
                ]);
            }
        }
    }

    /**
     * Validar que hora_fim é maior que hora_inicio
     * 
     * @param array $data
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validarHoraFimMaiorQueHoraInicio(&$data)
    {
        // Se ambas as horas estão preenchidas, validar
        if (isset($data['hora_inicio']) && isset($data['hora_fim']) && 
            !empty($data['hora_inicio']) && !empty($data['hora_fim'])) {
            
            if ($data['hora_fim'] <= $data['hora_inicio']) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'hora_fim' => 'A hora de fim deve ser maior que a hora de início.'
                ]);
            }
        }
    }
}
