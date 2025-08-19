<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioWebController;
use App\Http\Controllers\RolWebController;
use App\Http\Controllers\FuncionWebController;
use App\Http\Controllers\ParametrosSistemaController;
use App\Http\Controllers\CarreraController;

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
    
    // Rutas para parámetros del sistema
    Route::get('/parametros-sistema', [ParametrosSistemaController::class, 'index'])->name('parametros_sistema.index');
    
    // API para parámetros económicos
    Route::get('/api/parametros-economicos', [ParametrosSistemaController::class, 'getParametrosEconomicos'])->name('api.parametros_economicos');
    Route::post('/api/parametros-economicos', [ParametrosSistemaController::class, 'storeParametroEconomico'])->name('api.parametros_economicos.store');
    Route::get('/api/parametros-economicos/{id}', [ParametrosSistemaController::class, 'showParametroEconomico'])->name('api.parametros_economicos.show');
    Route::put('/api/parametros-economicos/{id}', [ParametrosSistemaController::class, 'updateParametroEconomico'])->name('api.parametros_economicos.update');
    Route::delete('/api/parametros-economicos/{id}', [ParametrosSistemaController::class, 'destroyParametroEconomico'])->name('api.parametros_economicos.destroy');
    Route::put('/api/parametros-economicos/{id}/toggle-status', [ParametrosSistemaController::class, 'toggleStatusParametroEconomico'])->name('api.parametros_economicos.toggle-status');
    
    // API para items de cobro
    Route::get('/api/items-cobro', [ParametrosSistemaController::class, 'getItemsCobro'])->name('api.items_cobro');
    Route::post('/api/items-cobro', [ParametrosSistemaController::class, 'storeItemCobro'])->name('api.items_cobro.store');
    Route::get('/api/items-cobro/{id}', [ParametrosSistemaController::class, 'showItemCobro'])->name('api.items_cobro.show');
    Route::put('/api/items-cobro/{id}', [ParametrosSistemaController::class, 'updateItemCobro'])->name('api.items_cobro.update');
    Route::delete('/api/items-cobro/{id}', [ParametrosSistemaController::class, 'destroyItemCobro'])->name('api.items_cobro.destroy');
    Route::put('/api/items-cobro/{id}/toggle-status', [ParametrosSistemaController::class, 'toggleStatusItemCobro'])->name('api.items_cobro.toggle-status');
    
    // API para materias
    Route::get('/api/materias', [ParametrosSistemaController::class, 'getMaterias'])->name('api.materias');
    Route::post('/api/materias', [ParametrosSistemaController::class, 'storeMateria'])->name('api.materias.store');
    Route::get('/api/materias/{sigla}/{codPensum}', [ParametrosSistemaController::class, 'showMateria'])->name('api.materias.show');
    Route::put('/api/materias/{sigla}/{codPensum}', [ParametrosSistemaController::class, 'updateMateria'])->name('api.materias.update');
    Route::delete('/api/materias/{sigla}/{codPensum}', [ParametrosSistemaController::class, 'destroyMateria'])->name('api.materias.destroy');
    Route::put('/api/materias/{sigla}/{codPensum}/toggle-status', [ParametrosSistemaController::class, 'toggleStatusMateria'])->name('api.materias.toggle-status');
    
    // Rutas para carreras académicas
    Route::get('/carrera/{codigo}', [CarreraController::class, 'show'])->name('carrera.show');
    
    // API para pensums de carrera
    Route::get('/api/carreras/{codigoCarrera}/pensums', [CarreraController::class, 'getPensums'])->name('api.carrera.pensums');
    
    // API para materias de pensum
    Route::get('/api/pensums/{codPensum}/materias', [CarreraController::class, 'getMaterias'])->name('api.pensum.materias');
    Route::post('/api/pensums/materias', [CarreraController::class, 'storeMateria'])->name('api.pensum.materias.store');
    Route::put('/api/pensums/materias/{sigla}/{codPensum}', [CarreraController::class, 'updateMateria'])->name('api.pensum.materias.update');
    Route::delete('/api/pensums/materias/{sigla}/{codPensum}', [CarreraController::class, 'destroyMateria'])->name('api.pensum.materias.destroy');
    Route::post('/api/pensums/materias/{sigla}/{codPensum}/toggle-status', [CarreraController::class, 'toggleStatusMateria'])->name('api.pensum.materias.toggle-status');
});
   


