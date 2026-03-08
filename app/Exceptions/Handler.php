<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    return response()->json([
                        'status' => 'erro',
                        'mensagem' => 'Acesso negado. Para realizar esta operação é necessário estar autenticado.'
                    ], 401);
                }
                
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => 'Ocorreu um erro ao processar sua requisição. Verifique se está autenticado e tente novamente.'
                ], 500);
            }
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
