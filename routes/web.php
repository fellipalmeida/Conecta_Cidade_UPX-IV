<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\PropostaController;


// Página inicial
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rotas de Autenticação

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Rotas Públicas de Reportes

Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
Route::get('/reportes/{id}', [ReporteController::class, 'show'])->name('reportes.show');
Route::post('/reportes/buscar-protocolo', [ReporteController::class, 'buscarPorProtocolo'])->name('reportes.buscar');

// Rotas Públicas de Propostas

Route::get('/propostas', [PropostaController::class, 'index'])->name('propostas.index');
Route::get('/propostas/{id}', [PropostaController::class, 'show'])->name('propostas.show');


// Rotas Autenticadas (Usuários Logados)
Route::middleware('auth')->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reportes/criar/novo', [ReporteController::class, 'create'])->name('reportes.create');
    Route::post('/reportes/criar', [ReporteController::class, 'store'])->name('reportes.store');
    Route::get('/meus-reportes', [ReporteController::class, 'meusReportes'])->name('reportes.meus');
    Route::post('/reportes/{id}/comentar', [ReporteController::class, 'addComment'])->name('reportes.comentar');
    Route::post('/propostas/{id}/votar', [PropostaController::class, 'votar'])->name('propostas.votar');
    Route::delete('/propostas/{id}/remover-voto', [PropostaController::class, 'removerVoto'])->name('propostas.remover-voto');
    Route::get('/minhas-votacoes', [PropostaController::class, 'minhasVotacoes'])->name('propostas.minhas-votacoes');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Route::get('/reportes', [AdminController::class, 'reportes'])->name('admin.reportes');
    // Route::post('/reportes/{id}/atualizar-status', [AdminController::class, 'atualizarStatus'])->name('admin.reportes.atualizar');
});
