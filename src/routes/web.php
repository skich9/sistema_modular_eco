<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioWebController;
use App\Http\Controllers\RolWebController;
use App\Http\Controllers\FuncionWebController;

// ========== RUTAS DE AUTENTICACIÓN ==========

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Rutas de login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth.custom')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Cambio de contraseña
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    
    // Rutas para gestión de usuarios
    Route::resource('usuarios', UsuarioWebController::class)->except(['create', 'edit']);
    Route::post('/usuarios/{id}/toggle-status', [UsuarioWebController::class, 'toggleStatus'])->name('usuarios.toggle-status');
    
    // Rutas para gestión de roles
    Route::resource('roles', RolWebController::class)->except(['create', 'edit']);
    Route::post('/roles/{id}/toggle-status', [RolWebController::class, 'toggleStatus'])->name('roles.toggle-status');
    
    // Rutas para gestión de funciones
    Route::resource('funciones', FuncionWebController::class)->except(['create', 'edit']);
    Route::post('/funciones/{id}/toggle-status', [FuncionWebController::class, 'toggleStatus'])->name('funciones.toggle-status');
});


