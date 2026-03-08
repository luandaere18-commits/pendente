<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use App\Models\Curso;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Página inicial do site
     */
    public function home()
    {
        return view('site.home');
    }

    /**
     * Página de centros
     */
    public function centros()
    {
        return view('site.centros');
    }

    /**
     * Página de cursos
     */
    public function cursos()
    {
        return view('site.cursos');
    }

    /**
     * Página de um centro específico
     */
    public function centro(Centro $centro)
    {
        return view('site.centro-detalhes', compact('centro'));
    }

    /**
     * Página sobre nós
     */
    public function sobre()
    {
        return view('site.sobre');
    }

    /**
     * Página de contactos
     */
    public function contactos()
    {
        return view('site.contactos');
    }
}
