<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use App\Models\Curso;
use App\Models\Formador;
use App\Models\Grupo;
use App\Models\Turma;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Página inicial do site
     */
    public function home()
    {
        $cursos = Curso::where('ativo', true)->get();
        $centros = Centro::orderBy('nome')->get();
        $turmas = Turma::with(['curso', 'centro', 'formador'])
                       ->where('publicado', true)
                       ->orderBy('data_arranque', 'asc')
                       ->get();
        
        return view('pages.home', compact('cursos', 'centros', 'turmas'));
    }

    /**
     * Página de centros
     */
    public function centros()
    {
        $centros = Centro::orderBy('nome')->get();
        $turmas = Turma::with(['curso', 'centro'])->where('publicado', true)->get();
        $cursos = Curso::all();
        
        return view('pages.centros', compact('centros', 'turmas', 'cursos'));
    }

    /**
     * Página de cursos
     */
    public function cursos()
    {
        $turmas = Turma::with(['curso', 'centro', 'formador'])
            ->where('publicado', true)
            ->orderBy('data_arranque', 'asc')
            ->get();

        // Obter cursos únicos das turmas publicadas
        $cursos = $turmas->pluck('curso')->unique('id')->values();

        // Obter centros para filtro
        $centros = Centro::orderBy('nome')->get();

        // Obter áreas únicas dos cursos
        $areas = $cursos->pluck('area')
                       ->unique()
                       ->sort()
                       ->values();
        
        return view('pages.cursos', compact('turmas', 'cursos', 'centros', 'areas'));
    }

    /**
     * Página de um centro específico
     */
    public function centro($id = null)
    {
        return view('pages.centro-detalhe', ['centroId' => $id]);
    }

    /**
     * Página sobre nós
     */
    public function sobre()
    {
        $formadores = Formador::orderBy('nome')->get();
        
        return view('pages.sobre', compact('formadores'));
    }

    /**
     * Página de serviços
     */
    public function servicos()
    {
        return view('pages.servicos');
    }

    /**
     * Página de contactos
     */
    public function contactos()
    {
        return view('pages.contactos');
    }

    /**
     * Página da loja
     */
    public function loja()
    {
        $grupos = Grupo::with(['categorias.itens'])
                      ->orderBy('nome')
                      ->get();
        
        return view('pages.loja', compact('grupos'));
    }
}
