<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use App\Models\Curso;
use App\Models\Turma;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Página inicial do site
     */
    public function home()
    {
        return view('site.home-novo');
    }

    /**
     * Página de centros
     */
    public function centros()
    {
        return view('site.centros-novo');
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
        
        return view('site.cursos-novo', compact('turmas'));
    }

    /**
     * Página de um centro específico
     */
    public function centro($id = null)
    {
        return view('site.centro-detalhe-novo', ['centroId' => $id]);
    }

    /**
     * Página sobre nós
     */
    public function sobre()
    {
        return view('site.sobre-novo');
    }

    /**
     * Página de contactos
     */
    public function contactos()
    {
        return view('site.contactos-novo');
    }
}
