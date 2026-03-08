<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * Controlador de Autenticação da API
 * 
 * Este controlador gerencia a autenticação de usuários através da API RESTful,
 * utilizando Laravel Sanctum para geração e gerenciamento de tokens de acesso.
 * Fornece endpoints para login, logout e obtenção de dados do usuário autenticado.
 */

/**
 * Controlador de Autenticação da API
 * 
 * Esta classe é responsável por gerenciar todas as operações de autenticação
 * da API, incluindo login, logout e recuperação de dados do usuário autenticado.
 * 
 * Utiliza o Laravel Sanctum para geração e gerenciamento de tokens de acesso.
 * O Sanctum é um sistema de autenticação leve e flexível que permite autenticação
 * via tokens para SPAs, aplicações móveis e APIs simples baseadas em tokens.
 * 
 * Fluxo de Autenticação:
 * 1. Cliente envia credenciais (email/senha) para o endpoint de login
 * 2. Credenciais são validadas contra a base de dados
 * 3. Se válidas, um token de acesso é gerado usando Sanctum
 * 4. Token é retornado ao cliente para uso em requisições subsequentes
 * 5. Cliente inclui o token no header Authorization: Bearer {token}
 * 6. Middleware de autenticação valida o token em cada requisição protegida
 * 
 * @package App\Http\Controllers\Api
 * @author Sistema de Autenticação
 * @version 1.0
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Autenticação"},
     *     summary="Login do admin",
     *     description="Autentica o admin e retorna um token de acesso",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="mucuanha.chineva@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="senha123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login bem sucedido",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|LongTokenString"),
     *             @OA\Property(property="user", type="object", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    /**
     * Realiza o login do usuário e retorna um token de acesso
     * 
     * Este método implementa o processo completo de autenticação:
     * 1. Valida os dados de entrada (email e senha obrigatórios)
     * 2. Verifica as credenciais contra a base de dados usando o Guard padrão
     * 3. Gera um token de acesso único usando Laravel Sanctum
     * 4. Retorna o token e os dados do usuário para o cliente
     * 
     * Sobre Laravel Sanctum:
     * - Cria tokens de acesso pessoais que são hash SHA-256
     * - Cada token é único e pode ser revogado individualmente
     * - Os tokens são armazenados na tabela 'personal_access_tokens'
     * - Não há expiração por padrão (pode ser configurada)
     * 
     * @param Request $request Objeto da requisição HTTP contendo email e password
     * @return \Illuminate\Http\JsonResponse
     *         - Sucesso (200): {'token': string, 'user': User}
     *         - Erro (401): {'message': 'Credenciais inválidas'}
     *         - Erro (422): Erros de validação dos campos
     */
    public function login(Request $request)
    {
        // Validação dos dados de entrada usando as regras do Laravel
        // O método validate() automaticamente retorna erro 422 se falhar
        $credentials = $request->validate([
            'email' => ['required', 'email'], // Email obrigatório e válido
            'password' => ['required'],       // Senha obrigatória
        ]);

        // Tentativa de autenticação usando o Guard padrão do Laravel
        // Auth::attempt() verifica email/senha contra a tabela users
        // Retorna false se as credenciais não coincidirem
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        // Recupera o usuário autenticado da sessão
        $user = Auth::user();
        
        // Gera um novo token de acesso usando Sanctum
        // 'api-token' é o nome do token (pode ser usado para identificação)
        // plainTextToken retorna o token em texto plano (só disponível na criação)
        $token = $user->createToken('api-token')->plainTextToken;

        // Retorna resposta de sucesso com o token e dados do usuário
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Autenticação"},
     *     summary="Logout do admin",
     *     description="Remove o token de acesso atual",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout realizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     )
     * )
     */
    /**
     * Realiza o logout do usuário removendo o token de acesso atual
     * 
     * Este método implementa o processo de logout seguro:
     * 1. Identifica o token usado na requisição atual
     * 2. Remove o token da base de dados (tabela personal_access_tokens)
     * 3. Invalida imediatamente o acesso do cliente
     * 
     * Segurança do Logout:
     * - Apenas o token atual é removido (outras sessões permanecem ativas)
     * - O token é completamente removido da base de dados
     * - Requisições subsequentes com este token retornarão 401 Unauthorized
     * - O usuário pode fazer logout de todas as sessões chamando tokens()->delete()
     * 
     * @param Request $request Objeto da requisição HTTP (deve conter token válido)
     * @return \Illuminate\Http\JsonResponse
     *         - Sucesso (200): {'message': 'Logout realizado com sucesso'}
     *         - Erro (401): Se o token for inválido ou não existir
     */
    public function logout(Request $request)
    {
        // Obtém o token usado na requisição atual e o remove da base de dados
        // currentAccessToken() retorna o modelo PersonalAccessToken
        // delete() remove fisicamente o token da tabela personal_access_tokens
        $request->user()->currentAccessToken()->delete();
        
        // Confirma o logout bem-sucedido
        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/user",
     *     tags={"Autenticação"},
     *     summary="Obter usuário autenticado",
     *     description="Retorna os dados do usuário atualmente autenticado",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Dados do usuário",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     )
     * )
     */
    /**
     * Retorna os dados do usuário atualmente autenticado
     * 
     * Este método fornece uma forma segura de obter informações
     * do usuário autenticado baseando-se no token fornecido na requisição.
     * 
     * Processo de Autenticação:
     * 1. O middleware 'auth:sanctum' valida o token antes de chegar aqui
     * 2. Se o token for válido, o usuário é carregado automaticamente
     * 3. $request->user() retorna o modelo User associado ao token
     * 4. Os dados são retornados em formato JSON
     * 
     * Tratamento de Erros:
     * - Captura qualquer exceção durante a recuperação dos dados
     * - Retorna erro 500 em caso de falha inesperada
     * - Middleware já trata erros 401 para tokens inválidos
     * 
     * @param Request $request Objeto da requisição HTTP (deve conter token válido)
     * @return \Illuminate\Http\JsonResponse
     *         - Sucesso (200): Dados completos do usuário em JSON
     *         - Erro (401): Token inválido ou ausente (tratado pelo middleware)
     *         - Erro (500): Erro interno do servidor
     */
    public function user(Request $request)
    {
        try {
            // Retorna o usuário associado ao token atual
            // $request->user() é automaticamente populado pelo middleware auth:sanctum
            // Contém todos os dados do modelo User (exceto campos hidden como password)
            return response()->json($request->user());
        } catch (\Exception $e) {
            // Captura qualquer exceção inesperada durante a operação
            // Log do erro poderia ser adicionado aqui para debug
            return response()->json(['message' => 'Erro ao obter dados do usuário'], 500);
        }
    }
}
