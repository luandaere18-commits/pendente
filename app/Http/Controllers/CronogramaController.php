<?php

namespace App\Http\Controllers;

use App\Models\Cronograma;
use Illuminate\Http\Request;

class CronogramaController extends Controller
{
    public function index()
    {
        $cronogramas = Cronograma::with(['curso'])->get();
        return view('cronogramas.index', compact('cronogramas'));
    }

    public function create()
    {
        $cursos = \App\Models\Curso::all();
        return view('cronogramas.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'dia_semana' => 'required|array|min:1',
            'dia_semana.*' => 'required|in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
            'periodo' => 'required|in:manhã,tarde,noite',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i'
        ]);
        
        // Validar hora_inicio com base no periodo
        $this->validarHoraComPeriodo($validated);
        
        // Validar que hora_fim > hora_inicio
        $this->validarHoraFimMaiorQueHoraInicio($validated);
        
        $cronograma = Cronograma::create($validated);
        return redirect()->route('cronogramas.index')->with('success', 'Cronograma criado com sucesso!');
    }

    public function show(Cronograma $cronograma)
    {
        $cronograma->load(['curso']);
        return view('cronogramas.show', compact('cronograma'));
    }

    public function edit(Cronograma $cronograma)
    {
        $cursos = \App\Models\Curso::all();
        return view('cronogramas.edit', compact('cronograma', 'cursos'));
    }

    public function update(Request $request, Cronograma $cronograma)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'dia_semana' => 'required|array|min:1',
            'dia_semana.*' => 'required|in:Segunda,Terça,Quarta,Quinta,Sexta,Sábado,Domingo',
            'periodo' => 'required|in:manhã,tarde,noite',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i'
        ]);
        
        // Validar hora_inicio com base no periodo
        $this->validarHoraComPeriodo($validated);
        
        // Validar que hora_fim > hora_inicio
        $this->validarHoraFimMaiorQueHoraInicio($validated);
        
        $cronograma->update($validated);
        return redirect()->route('cronogramas.index')->with('success', 'Cronograma atualizado com sucesso!');
    }

    public function destroy(Cronograma $cronograma)
    {
        $cronograma->delete();
        return redirect()->route('cronogramas.index')->with('success', 'Cronograma deletado com sucesso!');
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
            'manhã' => ['07:00', '12:00'],   // 07:00 até 11:59
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
