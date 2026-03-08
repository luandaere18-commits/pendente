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
use App\Http\Controllers\Api\HorarioController;
use App\Http\Controllers\Api\FormadorController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\PreInscricaoController;


// Rotas de leitura - públicas mas com dados completos se autenticado
Route::get('/centros', [CentroController::class, 'index'])->name('api.centros.index');
Route::get('/centros/{id}', [CentroController::class, 'show']);

Route::get('/cursos', [CursoController::class, 'index'])->name('api.cursos.index');
Route::get('/cursos/{id}', [CursoController::class, 'show']);

Route::get('/horarios', [HorarioController::class, 'index']);
Route::get('/horarios/{id}', [HorarioController::class, 'show']);

Route::get('/formadores', [FormadorController::class, 'index'])->name('api.formadores.index');
Route::get('/formadores/{id}', [FormadorController::class, 'show']);

Route::get('/categorias', [CategoriaController::class, 'index']);
Route::get('/categorias/{categoria}', [CategoriaController::class, 'show']);

Route::get('/produtos', [ProdutoController::class, 'index']);
Route::get('/produtos/em-destaque', [ProdutoController::class, 'emDestaque']);
Route::get('/produtos/{produto}', [ProdutoController::class, 'show']);
Route::get('/categorias/{categoria}/produtos', [ProdutoController::class, 'porCategoria']);

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
    // Centros
    Route::post('/centros', [CentroController::class, 'store']);
    Route::put('/centros/{id}', [CentroController::class, 'update']);
    Route::delete('/centros/{id}', [CentroController::class, 'destroy']);

    // Cursos
    Route::post('/cursos', [CursoController::class, 'store']);
    Route::put('/cursos/{id}', [CursoController::class, 'update']);
    Route::delete('/cursos/{id}', [CursoController::class, 'destroy']);

    // Horários
    Route::post('/horarios', [HorarioController::class, 'store']);
    Route::put('/horarios/{id}', [HorarioController::class, 'update']);
    Route::delete('/horarios/{id}', [HorarioController::class, 'destroy']);

    // Formadores
    Route::post('/formadores', [FormadorController::class, 'store']);
    Route::put('/formadores/{id}', [FormadorController::class, 'update']);
    Route::delete('/formadores/{id}', [FormadorController::class, 'destroy']);

    // Categorias
    Route::post('/categorias', [CategoriaController::class, 'store']);
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update']);
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy']);

    // Produtos
    Route::post('/produtos', [ProdutoController::class, 'store']);
    Route::put('/produtos/{produto}', [ProdutoController::class, 'update']);
    Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy']);

    // Pre-inscrições (admin pode editar, deletar - ver está em grupo separado acima)
    Route::put('/pre-inscricoes/{id}', [PreInscricaoController::class, 'update']);
    Route::delete('/pre-inscricoes/{id}', [PreInscricaoController::class, 'destroy']);
});