<?php

namespace App\Http\Controllers;

use App\Models\Formador;
use Illuminate\Http\Request;

class FormadorController extends Controller
{
    public function index()
    {
        $formadores = Formador::with(['cursos', 'centros'])->get();
        return view('formadores.index', compact('formadores'));
    }

    public function create()
    {
        return view('formadores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'contactos' => 'nullable|array',
            'contactos.*.tipo' => 'nullable|string',
            'contactos.*.valor' => 'nullable|string',
            'especialidade' => 'nullable|string|max:150',
            'bio' => 'nullable|string',
            'foto_url' => 'nullable|url|max:255'
        ]);
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }
        
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
                }
            }
            $validated['contactos'] = $contactosProcessados;
        } else {
            // Se não há contactos, define como array vazio
            $validated['contactos'] = [];
        }
        
        $formador = Formador::create($validated);
        return redirect()->route('formadores.index')->with('success', 'Formador criado com sucesso!');
    }

    public function show(Formador $formador)
    {
        $formador->load(['cursos', 'centros']);
        return view('formadores.show', compact('formador'));
    }

    public function edit(Formador $formador)
    {
        return view('formadores.edit', compact('formador'));
    }

    public function update(Request $request, Formador $formador)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'contactos' => 'nullable|array',
            'contactos.*.tipo' => 'nullable|string',
            'contactos.*.valor' => 'nullable|string',
            'especialidade' => 'nullable|string|max:150',
            'bio' => 'nullable|string',
            'foto_url' => 'nullable|url|max:255'
        ]);
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }
        
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
                }
            }
            $validated['contactos'] = $contactosProcessados;
        } else {
            // Se não há contactos, define como array vazio
            $validated['contactos'] = [];
        }
        
        $formador->update($validated);
        return redirect()->route('formadores.index')->with('success', 'Formador atualizado com sucesso!');
    }

    public function destroy(Formador $formador)
    {
        $formador->delete();
        return redirect()->route('formadores.index')->with('success', 'Formador deletado com sucesso!');
    }
}
