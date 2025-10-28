<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\PropostaController;

/*
|--------------------------------------------------------------------------
| Web Routes - Conecta Cidade
|--------------------------------------------------------------------------
*/

// Página inicial
Route::get('/', [HomeController::class, 'index'])->name('home');

// ============================================
// Rotas de Autenticação
// ============================================
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Registro
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// Rotas Públicas de Reportes
// ============================================
Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
Route::get('/reportes/{id}', [ReporteController::class, 'show'])->name('reportes.show');
Route::post('/reportes/buscar-protocolo', [ReporteController::class, 'buscarPorProtocolo'])->name('reportes.buscar');

// ============================================
// Rotas Públicas de Propostas
// ============================================
Route::get('/propostas', [PropostaController::class, 'index'])->name('propostas.index');
Route::get('/propostas/{id}', [PropostaController::class, 'show'])->name('propostas.show');

// ============================================
// Rotas Autenticadas (Usuários Logados)
// ============================================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reportes - Criar
    Route::get('/reportes/criar/novo', [ReporteController::class, 'create'])->name('reportes.create');
    Route::post('/reportes/criar', [ReporteController::class, 'store'])->name('reportes.store');

    // Reportes - Meus Reportes
    Route::get('/meus-reportes', [ReporteController::class, 'meusReportes'])->name('reportes.meus');

    // Reportes - Comentários
    Route::post('/reportes/{id}/comentar', [ReporteController::class, 'addComment'])->name('reportes.comentar');

    // Propostas - Votação
    Route::post('/propostas/{id}/votar', [PropostaController::class, 'votar'])->name('propostas.votar');
    Route::delete('/propostas/{id}/remover-voto', [PropostaController::class, 'removerVoto'])->name('propostas.remover-voto');

    // Propostas - Minhas Votações
    Route::get('/minhas-votacoes', [PropostaController::class, 'minhasVotacoes'])->name('propostas.minhas-votacoes');
});

// ============================================
// Rotas Admin (adicionar depois)
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Route::get('/reportes', [AdminController::class, 'reportes'])->name('admin.reportes');
    // Route::post('/reportes/{id}/atualizar-status', [AdminController::class, 'atualizarStatus'])->name('admin.reportes.atualizar');
});
