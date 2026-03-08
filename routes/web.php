<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\FormadorController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\PreInscricaoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\SiteController;

/*
|--------------------------------------------------------------------------
| Site Público Routes
|--------------------------------------------------------------------------
*/

// Páginas do site público
Route::get('/', [SiteController::class, 'home'])->name('site.home');
Route::get('/home', [SiteController::class, 'home'])->name('site.home.alt');
Route::get('/site', [SiteController::class, 'home'])->name('site.home.alt2');
Route::get('/site/centros', [SiteController::class, 'centros'])->name('site.centros');
Route::get('/site/centro/{centro}', [SiteController::class, 'centro'])->name('site.centro');
Route::get('/site/cursos', [SiteController::class, 'cursos'])->name('site.cursos');
Route::get('/site/sobre', [SiteController::class, 'sobre'])->name('site.sobre');
Route::get('/site/contactos', [SiteController::class, 'contactos'])->name('site.contactos');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Rota para exibir a página de login
Route::get('/login', function () {
    return view('auth.login_new');
})->name('login');

// Rotas de autenticação
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rota híbrida para login via API que cria sessão web
Route::post('/api/web-login', [AuthenticatedSessionController::class, 'apiLogin'])->name('api.web.login');

Route::get('/debug-routes', function() {
    $routes = collect(\Route::getRoutes())->map(function ($route) {
        return [
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => $route->getActionName(),
        ];
    });
    
    return response()->json($routes);
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Cursos
    Route::resource('cursos', CursoController::class);
    Route::patch('cursos/{curso}/toggle-status', [CursoController::class, 'toggleStatus'])->name('cursos.toggle-status');
    
    // Centros
    Route::resource('centros', CentroController::class);
    
    // Formadores
    Route::resource('formadores', FormadorController::class)->parameters([
        'formadores' => 'formador'
    ]);
    
    // Horários
    Route::resource('horarios', HorarioController::class);
    
    // Pré-inscrições
    Route::resource('pre-inscricoes', PreInscricaoController::class)->parameters([
        'pre-inscricoes' => 'preInscricao'
    ]);
    Route::patch('pre-inscricoes/{preInscricao}/status', [PreInscricaoController::class, 'updateStatus'])->name('pre-inscricoes.update-status');
    
    // Categorias
    Route::resource('categorias', CategoriaController::class);
    
    // Produtos
    Route::resource('produtos', ProdutoController::class);
});
