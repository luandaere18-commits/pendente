<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * Middleware de Autenticação Híbrida
 * 
 * Este middleware permite autenticação tanto via sessão web (cookies)
 * quanto via tokens de API (Bearer tokens). É útil para aplicações
 * que precisam suportar ambos os métodos de autenticação.
 * 
 * Ordem de verificação:
 * 1. Verifica se há uma sessão web válida
 * 2. Se não houver, verifica se há um token Bearer válido
 * 3. Se não houver nenhum, redireciona para login ou retorna 401
 */
class HybridAuth
{
    /**
     * Handle an incoming request.
     * 
     * Este método implementa autenticação híbrida que permite tanto
     * autenticação via sessão web quanto via tokens API Bearer.
     * 
     * Fluxo de autenticação:
     * 1. Primeiro verifica se há sessão web ativa
     * 2. Se não há sessão, verifica token Bearer no header
     * 3. Se token válido, autentica o usuário para a requisição
     * 4. Se nenhum método funcionar, retorna erro apropriado
     *
     * @param  \Illuminate\Http\Request  $request Requisição HTTP
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next Próximo middleware
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse Resposta HTTP
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Primeiro tenta autenticação via sessão web
        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        // 2. Se não há sessão web, tenta autenticação via token
        $token = $request->bearerToken();
        
        if ($token) {
            // Busca o token na base de dados
            $accessToken = PersonalAccessToken::findToken($token);
            
            if ($accessToken && $accessToken->can('*')) {
                // Define o usuário autenticado para esta requisição
                Auth::setUser($accessToken->tokenable);
                return $next($request);
            }
        }

        // 3. Se é uma requisição AJAX/API, retorna erro 401
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Não autorizado. Token inválido ou expirado.'
            ], 401);
        }

        // 4. Se é uma requisição web, redireciona para login
        return redirect()->guest(route('login'));
    }
}
