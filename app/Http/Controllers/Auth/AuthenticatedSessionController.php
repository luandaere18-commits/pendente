<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // Debug: Verificar se o route helper está funcionando
        logger('Login route accessed successfully');
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não conferem com os nossos registos.',
        ])->onlyInput('email');
    }

    /**
     * Handle an incoming API authentication request that creates a web session.
     * 
     * Este método permite que o frontend faça login via AJAX e obtenha tanto
     * um token de API quanto uma sessão web válida, resolvendo o problema
     * de autenticação híbrida (web + API) do sistema MC Comercial.
     * 
     * Funcionalidades:
     * - Valida credenciais do usuário
     * - Cria sessão web segura
     * - Gera token API para requisições AJAX
     * - Retorna dados em formato JSON para o frontend
     * 
     * @param Request $request Requisição contendo email e password
     * @return JsonResponse Resposta com token, usuário e URL de redirecionamento
     */
    public function apiLogin(Request $request)
    {
        // Validação dos dados de entrada
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentativa de autenticação
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenera a sessão por segurança
            $request->session()->regenerate();

            // Obtém o usuário autenticado
            $user = Auth::user();
            
            // Cria um token de API para uso futuro se necessário
            $token = $user->createToken('web-session')->plainTextToken;

            // Retorna resposta JSON com sucesso
            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user,
                'redirect' => '/dashboard'
            ]);
        }

        // Retorna erro em caso de credenciais inválidas
        return response()->json([
            'success' => false,
            'message' => 'As credenciais fornecidas não conferem com os nossos registos.'
        ], 401);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
