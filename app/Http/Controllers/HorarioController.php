<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        $horarios = Horario::with(['curso', 'centro'])->get();
        return view('horarios.index', compact('horarios'));
    }

    public function create()
    {
        $cursos = \App\Models\Curso::all();
        $centros = \App\Models\Centro::all();
        return view('horarios.create', compact('cursos', 'centros'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'centro_id' => 'required|exists:centros,id',
            'dia_semana' => 'required|string|max:50',
            'periodo' => 'required|string|max:50',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i'
        ]);
        $horario = Horario::create($validated);
        return redirect()->route('horarios.index')->with('success', 'Horário criado com sucesso!');
    }

    public function show(Horario $horario)
    {
        $horario->load(['curso', 'centro']);
        return view('horarios.show', compact('horario'));
    }

    public function edit(Horario $horario)
    {
        $cursos = \App\Models\Curso::all();
        $centros = \App\Models\Centro::all();
        return view('horarios.edit', compact('horario', 'cursos', 'centros'));
    }

    public function update(Request $request, Horario $horario)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'centro_id' => 'required|exists:centros,id',
            'dia_semana' => 'required|string|max:50',
            'periodo' => 'required|string|max:50',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i'
        ]);
        $horario->update($validated);
        return redirect()->route('horarios.index')->with('success', 'Horário atualizado com sucesso!');
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();
        return redirect()->route('horarios.index')->with('success', 'Horário deletado com sucesso!');
    }
}
