<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Centro;
use App\Models\Formador;
use App\Models\PreInscricao;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Aqui podemos adicionar estatísticas se necessário
        // Por agora, as estatísticas são carregadas via AJAX
        
        return view('dashboard');
    }
}
