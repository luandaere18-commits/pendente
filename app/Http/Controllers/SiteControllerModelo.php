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
    public function home()
    {
        $centros = Centro::all();
        $cursos = Curso::where('ativo', true)->get();
        $turmas = Turma::with(['curso', 'centro', 'formador'])
            ->where('publicado', true)
            ->orderBy('data_arranque')
            ->get();

        return view('pages.home', compact('centros', 'cursos', 'turmas'));
    }

    public function cursos()
    {
        $cursos = Curso::where('ativo', true)->get();
        $centros = Centro::all();
        $turmas = Turma::where('publicado', true)->get();
        $areas = $cursos->pluck('area')->unique()->values();

        return view('pages.cursos', compact('cursos', 'centros', 'turmas', 'areas'));
    }

    public function centros()
    {
        $centros = Centro::all();
        $cursos = Curso::where('ativo', true)->get();
        $turmas = Turma::where('publicado', true)->get();

        return view('pages.centros', compact('centros', 'cursos', 'turmas'));
    }

    public function loja()
    {
        $grupos = Grupo::with(['categorias.itens' => function ($q) {
            $q->where('ativo', true)->orderBy('ordem');
        }])->where('ativo', true)->orderBy('ordem')->get();

        return view('pages.loja', compact('grupos'));
    }

    public function sobre()
    {
        $formadores = Formador::all();
        return view('pages.sobre', compact('formadores'));
    }

    public function contactos()
    {
        return view('pages.contactos');
    }

    // ── API Endpoints ──

    public function apiGrupos()
    {
        return Grupo::with(['categorias.itens'])->where('ativo', true)->orderBy('ordem')->get();
    }

    public function apiTurmasCurso(Curso $curso)
    {
        return Turma::with(['centro', 'formador'])
            ->where('curso_id', $curso->id)
            ->where('publicado', true)
            ->get()
            ->map(function ($t) {
                $t->data_arranque_formatada = \Carbon\Carbon::parse($t->data_arranque)->translatedFormat('d \\d\\e F \\d\\e Y');
                return $t;
            });
    }

    public function apiPreInscricao(Request $request)
    {
        $request->validate([
            'turma_id' => 'required|exists:turmas,id',
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'telefone' => 'nullable|string|max:20',
        ]);

        // TODO: Guardar pré-inscrição na base de dados
        // PreInscricao::create($request->only('turma_id', 'nome', 'email', 'telefone'));

        return response()->json(['message' => 'Pré-inscrição realizada com sucesso!']);
    }

    public function apiContacto(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'assunto' => 'required|string',
            'mensagem' => 'required|string',
        ]);

        // TODO: Guardar contacto ou enviar email
        return response()->json(['message' => 'Mensagem enviada com sucesso!']);
    }

    public function apiNewsletter(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        // TODO: Guardar email de newsletter
        return response()->json(['message' => 'Subscrito com sucesso!']);
    }
}
