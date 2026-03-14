<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use App\Helpers\PhoneValidator;
use Illuminate\Http\Request;

class CentroController extends Controller
{
    public function index(Request $request)
    {
        $query = Centro::with(['cursos', 'formadores']);
        
        if ($request->has('nome') && $request->nome) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }
        
        if ($request->has('localizacao') && $request->localizacao) {
            $query->where('localizacao', 'like', '%' . $request->localizacao . '%');
        }
        
        $centros = $query->get();
        
        // Se for AJAX, retorna JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($centros);
        }
        
        return view('centros.index', compact('centros'))->with([
            'filtroNome' => $request->nome,
            'filtroLocalizacao' => $request->localizacao
        ]);
    }

    public function create()
    {
        return view('centros.create');
    }

    public function store(Request $request)
    {
        // Validação com as mesmas regras do controller API (incluindo validação de telefone)
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                'unique:centros,nome'
            ],
            'localizacao' => [
                'required',
                'string',
                'max:150'
            ],
            'contactos' => [
                'required',
                'array',
                'min:1'
            ],
            'contactos.*' => [
                'required',
                'string',
                function($attribute, $value, $fail) {
                    if (!PhoneValidator::isValid($value)) {
                        $fail('O valor de ' . $attribute . ' deve ser um número de telefone válido de Angola (ex: 923111111, 923 111 111, +244923111111)');
                    }
                }
            ],
            'email' => [
                'nullable',
                'email',
                'max:100',
                'unique:centros,email'
            ]
        ]);

        // Normalizar telefones para formato padrão (9 dígitos)
        $validated['contactos'] = array_map(function($phone) {
            return PhoneValidator::normalize($phone);
        }, $validated['contactos']);
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }
        
        $centro = Centro::create($validated);

        // Se for AJAX, retorna JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Centro cadastrado com sucesso!',
                'dados' => $centro
            ], 201);
        }

        return redirect()->route('centros.index')->with('success', 'Centro criado com sucesso!');
    }

    public function show($id)
    {
        $centro = Centro::with(['cursos', 'formadores'])->findOrFail($id);

        // Se for AJAX, retorna JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($centro);
        }

        return view('centros.show', compact('centro'));
    }

    public function edit($id)
    {
        $centro = Centro::findOrFail($id);
        return view('centros.edit', compact('centro'));
    }

    public function update(Request $request, $id)
    {
        $centro = Centro::findOrFail($id);

        // Validação com as mesmas regras do controller API (incluindo validação de telefone)
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                'unique:centros,nome,' . $centro->id
            ],
            'localizacao' => [
                'required',
                'string',
                'max:150'
            ],
            'contactos' => [
                'required',
                'array',
                'min:1'
            ],
            'contactos.*' => [
                'required',
                'string',
                function($attribute, $value, $fail) {
                    if (!PhoneValidator::isValid($value)) {
                        $fail('O valor de ' . $attribute . ' deve ser um número de telefone válido de Angola (ex: 923111111, 923 111 111, +244923111111)');
                    }
                }
            ],
            'email' => [
                'nullable',
                'email',
                'max:100',
                'unique:centros,email,' . $centro->id
            ]
        ]);

        // Normalizar telefones para formato padrão (9 dígitos)
        $validated['contactos'] = array_map(function($phone) {
            return PhoneValidator::normalize($phone);
        }, $validated['contactos']);
        
        // Normalizar email para lowercase se fornecido
        if (!empty($validated['email'])) {
            $validated['email'] = strtolower($validated['email']);
        }
        
        $centro->update($validated);

        // Se for AJAX, retorna JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Centro atualizado com sucesso!',
                'dados' => $centro
            ]);
        }

        return redirect()->route('centros.index')->with('success', 'Centro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $centro = Centro::findOrFail($id);
        
        // Verificar se o centro tem cursos associados
        if ($centro->cursos()->count() > 0) {
            $msg = 'Não é possível apagar este centro porque possui ' . $centro->cursos()->count() . ' curso(s) associado(s). Remova os cursos primeiro.';
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['status' => 'erro', 'mensagem' => $msg], 409);
            }
            
            return redirect()->route('centros.index')->with('error', $msg);
        }
        
        // Verificar se o centro tem formadores associados
        if ($centro->formadores()->count() > 0) {
            $msg = 'Não é possível apagar este centro porque possui ' . $centro->formadores()->count() . ' formador(es) associado(s). Remova as associações primeiro.';
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['status' => 'erro', 'mensagem' => $msg], 409);
            }
            
            return redirect()->route('centros.index')->with('error', $msg);
        }
        
        $centro->delete();

        // Se for AJAX, retorna JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['status' => 'sucesso', 'mensagem' => 'Centro deletado com sucesso!']);
        }

        return redirect()->route('centros.index')->with('success', 'Centro deletado com sucesso!');
    }
}
