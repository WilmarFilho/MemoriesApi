<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/pages/{hash}', [PageController::class, 'index']); // Listar páginas pelo hash

// Rotas protegidas por autenticação
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);  // Obter dados do usuário autenticado
    
    Route::post('/logout', [AuthController::class, 'logout']);  // Deslogar usuário

    Route::post('/page/novo', [PageController::class, 'store']);  // Criar nova página
    Route::post('/page/{id}', [PageController::class, 'update']);  // Atualizar página
    Route::delete('/page/{id}', [PageController::class, 'destroy']);  // Excluir página
});
