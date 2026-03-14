<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rotas de autenticação
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum,web'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

// Controllers
use App\Http\Controllers\Api\CentroController;
use App\Http\Controllers\Api\CursoController;
use App\Http\Controllers\Api\TurmaController;
use App\Http\Controllers\Api\FormadorController;
use App\Http\Controllers\Api\GrupoController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\PreInscricaoController;


// Rotas de leitura - públicas mas com dados completos se autenticado
Route::get('/centros', [CentroController::class, 'index'])->name('api.centros.index');
Route::get('/centros/{id}', [CentroController::class, 'show']);

Route::get('/cursos', [CursoController::class, 'index'])->name('api.cursos.index');
Route::get('/cursos/{id}', [CursoController::class, 'show']);

Route::get('/turmas', [TurmaController::class, 'index']);
Route::get('/turmas/{id}', [TurmaController::class, 'show']);

Route::get('/formadores', [FormadorController::class, 'index'])->name('api.formadores.index');
Route::get('/formadores/{formador}', [FormadorController::class, 'show'])->name('api.formadores.show');

Route::get('/grupos', [GrupoController::class, 'index']);
Route::get('/grupos/{grupo}', [GrupoController::class, 'show']);

Route::get('/categorias', [CategoriaController::class, 'index']);
Route::get('/categorias/{categoria}', [CategoriaController::class, 'show']);

Route::get('/itens', [ItemController::class, 'index']);
Route::get('/itens/destacados', [ItemController::class, 'destacados']);
Route::get('/itens/{item}', [ItemController::class, 'show']);
Route::get('/categorias/{categoria}/itens', [ItemController::class, 'porCategoria']);

// Rotas protegidas de leitura admin apenas
Route::middleware(['auth:sanctum,web'])->group(function () {
    Route::get('/pre-inscricoes', [PreInscricaoController::class, 'index'])->name('api.pre-inscricoes.index');
    Route::get('/pre-inscricoes/{id}', [PreInscricaoController::class, 'show']);
});

// Apenas o público pode criar pré-inscrições
Route::post('/pre-inscricoes', [PreInscricaoController::class, 'store'])->name('api.pre-inscricoes.store');

// Rotas protegidas para admin (CRUD completo, exceto POST de pre-inscricoes)
// Aceita tanto autenticação via sessão web quanto token API
Route::middleware(['auth:sanctum,web'])->group(function () {
    // Cursos - TODOS os updates protegidos
    Route::put('/cursos/{id}', [CursoController::class, 'update']);
    Route::put('/cursos/{id}/centros/{centroId}', [CursoController::class, 'updateCentro']);
    // Centros
    Route::post('/centros', [CentroController::class, 'store']);
    Route::put('/centros/{id}', [CentroController::class, 'update']);
    Route::delete('/centros/{id}', [CentroController::class, 'destroy']);

    // Cursos
    Route::post('/cursos', [CursoController::class, 'store']);
    Route::delete('/cursos/{id}', [CursoController::class, 'destroy']);
    Route::post('/cursos/{id}/centros', [CursoController::class, 'attachCentro']);
    Route::delete('/cursos/{id}/centros/{centroId}', [CursoController::class, 'detachCentro']);

    // Turmas
    Route::post('/turmas', [TurmaController::class, 'store']);
    Route::put('/turmas/{id}', [TurmaController::class, 'update']);
    Route::delete('/turmas/{id}', [TurmaController::class, 'destroy']);

    // Formadores
    Route::post('/formadores', [FormadorController::class, 'store'])->name('api.formadores.store');
    Route::put('/formadores/{formador}', [FormadorController::class, 'update'])->name('api.formadores.update');
    Route::delete('/formadores/{formador}', [FormadorController::class, 'destroy'])->name('api.formadores.destroy');

    // Categorias
    Route::post('/categorias', [CategoriaController::class, 'store']);
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update']);
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy']);

    // Grupos
    Route::post('/grupos', [GrupoController::class, 'store']);
    Route::put('/grupos/{grupo}', [GrupoController::class, 'update']);
    Route::delete('/grupos/{grupo}', [GrupoController::class, 'destroy']);

    // Itens
    Route::post('/itens', [ItemController::class, 'store']);
    Route::put('/itens/{item}', [ItemController::class, 'update']);
    Route::delete('/itens/{item}', [ItemController::class, 'destroy']);

    // Pre-inscrições (admin pode editar, deletar - ver está em grupo separado acima)
    Route::put('/pre-inscricoes/{id}', [PreInscricaoController::class, 'update']);
    Route::delete('/pre-inscricoes/{id}', [PreInscricaoController::class, 'destroy']);
});