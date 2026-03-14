<?php

namespace App\Http\Controllers;

use App\Models\Formador;
use App\Models\Centro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormadorController extends Controller
{
    public function index(Request $request)
    {
        // Carregar formadores com relacionamentos necessários
        $query = Formador::with(['centros', 'turmas.curso']);
        
        // Filtro por nome
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }
        
        // Filtro por especialidade
        if ($request->filled('especialidade')) {
            $query->where('especialidade', 'like', '%' . $request->especialidade . '%');
        }
        
        $formadores = $query->get();
        
        // DEBUG: Verificar se os dados estão sendo carregados
        \Log::info('Formadores carregados: ' . $formadores->count());
        foreach($formadores as $f) {
            \Log::info('Formador: ' . $f->nome, [
                'cursos_count' => $f->cursos_count,
                'centros_count' => $f->centros->count(),
                'turmas_count' => $f->turmas->count(),
                'contactos' => $f->contactos,
                'contactos_count' => $f->contactos_count
            ]);
        }
        
        $centros = Centro::all();
        
        // Se for requisição AJAX, retornar JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($formadores);
        }
        
        return view('formadores.index', compact('formadores', 'centros'))->with([
            'filtroNome' => $request->nome ?? '',
            'filtroEspecialidade' => $request->especialidade ?? ''
        ]);
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
            'contactos.*' => 'nullable|string|max:50',
            'especialidade' => 'nullable|string|max:150',
            'bio' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'centros' => 'nullable|array',
            'centros.*' => 'nullable|integer|exists:centros,id'
        ]);
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }
        
        // Processar contactos: garantir apenas strings válidas
        if (isset($validated['contactos']) && is_array($validated['contactos'])) {
            $contactosProcessados = [];
            foreach ($validated['contactos'] as $contacto) {
                if (is_string($contacto) && !empty(trim($contacto))) {
                    $contactosProcessados[] = trim($contacto);
                }
            }
            $validated['contactos'] = $contactosProcessados;
        } else {
            // Se não há contactos, define como array vazio
            $validated['contactos'] = [];
        }
        
        // Upload de foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('formadores', $file, $filename);

            if (Storage::disk('public')->exists($path)) {
                $validated['foto_url'] = '/storage/' . $path;
            } else {
                \Log::warning('Falha ao salvar foto do formador: ' . $path);
            }
        }
        unset($validated['foto']);
        
        // Coletar centros para associação
        $centros = $validated['centros'] ?? [];
        unset($validated['centros']);
        
        $formador = Formador::create($validated);
        
        // Associar centros se fornecidos
        if (!empty($centros)) {
            $formador->centros()->sync($centros);
        }
        
        // Se for requisição AJAX ou JSON, retornar JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'message' => 'Formador criado com sucesso',
                'data' => $formador->load(['centros'])
            ], 201);
        }
        
        return redirect()->route('formadores.index')->with('success', 'Formador criado com sucesso!');
    }

    public function show(Formador $formador)
    {
        $formador->load(['centros', 'turmas.curso', 'cursos']);
        
        // Se for requisição AJAX ou JSON, retornar JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'data' => $formador
            ]);
        }
        
        return view('formadores.show', compact('formador'));
    }

    public function edit(Formador $formador)
    {
        $formador->load(['centros', 'turmas.curso', 'cursos']);
        
        // Se for requisição AJAX ou JSON, retornar JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'data' => $formador
            ]);
        }
        
        return view('formadores.edit', compact('formador'));
    }

    public function update(Request $request, Formador $formador)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'contactos' => 'nullable|array',
            'contactos.*' => 'nullable|string|max:50',
            'especialidade' => 'nullable|string|max:150',
            'bio' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'centros' => 'nullable|array',
            'centros.*' => 'nullable|integer|exists:centros,id'
        ]);
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }
        
        // Processar contactos: garantir apenas strings válidas
        if (isset($validated['contactos']) && is_array($validated['contactos'])) {
            $contactosProcessados = [];
            foreach ($validated['contactos'] as $contacto) {
                if (is_string($contacto) && !empty(trim($contacto))) {
                    $contactosProcessados[] = trim($contacto);
                }
            }
            $validated['contactos'] = $contactosProcessados;
        } else {
            // Se não há contactos, define como array vazio
            $validated['contactos'] = [];
        }
        
        // Upload de foto se nova foi enviada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('formadores', $file, $filename);

            if (Storage::disk('public')->exists($path)) {
                $validated['foto_url'] = '/storage/' . $path;
            } else {
                \Log::warning('Falha ao salvar foto do formador: ' . $path);
            }
        }
        unset($validated['foto']);
        
        // Coletar centros para associação
        $centros = $validated['centros'] ?? [];
        unset($validated['centros']);
        
        $formador->update($validated);
        
        // Associar centros se fornecidos
        if (!empty($centros)) {
            $formador->centros()->sync($centros);
        } else {
            // Se não há centros, limpar associações
            $formador->centros()->sync([]);
        }
        
        // Se for requisição AJAX ou JSON, retornar JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'message' => 'Formador atualizado com sucesso',
                'data' => $formador->load(['centros'])
            ]);
        }
        
        return redirect()->route('formadores.index')->with('success', 'Formador atualizado com sucesso!');
    }

    public function destroy(Formador $formador)
    {
        $formador->delete();
        
        // Se for requisição AJAX ou JSON, retornar JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'message' => 'Formador eliminado com sucesso'
            ]);
        }
        
        return redirect()->route('formadores.index')->with('success', 'Formador eliminado com sucesso!');
    }
}
