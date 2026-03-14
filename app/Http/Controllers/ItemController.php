<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $itens = Item::with(['categoria.grupo'])->ordenado()->get();
        return view('itens.index', compact('itens'));
    }

    public function create()
    {
        $categorias = Categoria::where('ativo', true)->ordenado()->get();
        return view('itens.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:itens,nome',
            'descricao' => 'nullable|string',
            'preco' => 'nullable|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo' => 'required|in:produto,servico',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
            'destaque' => 'boolean'
        ]);
        
        // Garantir que boolean fields sejam tratados corretamente
        $validated['ativo'] = $request->has('ativo') ? true : false;
        $validated['destaque'] = $request->has('destaque') ? true : false;
        
        // Processar upload de imagem
        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('itens', $file, $filename);

            if (Storage::disk('public')->exists($path)) {
                $validated['imagem'] = '/storage/' . $path;
            }
        }
        
        $item = Item::create($validated);
        return redirect()->route('itens.index')->with('success', 'Item criado com sucesso!');
    }

    public function show(Item $item)
    {
        $item->load(['categoria.grupo']);
        return view('itens.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $categorias = Categoria::where('ativo', true)->ordenado()->get();
        return view('itens.edit', compact('item', 'categorias'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:itens,nome,' . $item->id,
            'descricao' => 'nullable|string',
            'preco' => 'nullable|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo' => 'required|in:produto,servico',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
            'destaque' => 'boolean'
        ]);
        
        // Garantir que boolean fields sejam tratados corretamente
        $validated['ativo'] = $request->has('ativo') ? true : false;
        $validated['destaque'] = $request->has('destaque') ? true : false;
        
        // Processar upload de imagem se já existe, deletar a anterior
        if ($request->hasFile('imagem')) {
            if ($item->imagem) {
                // Remover '/storage/' se houver para obter o caminho correto
                $oldPath = str_replace('/storage/', '', $item->imagem);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            
            $file = $request->file('imagem');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('itens', $file, $filename);

            if (Storage::disk('public')->exists($path)) {
                $validated['imagem'] = '/storage/' . $path;
            }
        }
        
        $item->update($validated);
        return redirect()->route('itens.index')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy(Item $item)
    {
        // Deletar imagem se existir
        if ($item->imagem) {
            $imagemPath = str_replace('/storage/', '', $item->imagem);
            if (Storage::disk('public')->exists($imagemPath)) {
                Storage::disk('public')->delete($imagemPath);
            }
        }
        
        $item->delete();
        return redirect()->route('itens.index')->with('success', 'Item deletado com sucesso!');
    }
}
