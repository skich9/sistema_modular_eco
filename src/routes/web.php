<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioWebController;
use App\Http\Controllers\RolWebController;
use App\Http\Controllers\FuncionWebController;
use App\Http\Controllers\EconomicoWebController;
use App\Http\Controllers\ParametrosEconomicosWebController;
use App\Http\Controllers\AsignacionCostosWebController;
use App\Http\Controllers\ItemsCobroWebController;
use App\Http\Controllers\MateriaWebController;
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

    
    // Rutas para parámetros económicos
    Route::prefix('configuracion')->group(function () {
        // Parámetros Económicos
        Route::get('/parametros-economicos', [ParametrosEconomicosWebController::class, 'index'])->name('parametros_economicos.index');
        Route::post('/parametros-economicos', [ParametrosEconomicosWebController::class, 'store'])->name('parametros_economicos.store');
        Route::get('/parametros-economicos/{id}/edit', [ParametrosEconomicosWebController::class, 'edit'])->name('parametros_economicos.edit');
        Route::put('/parametros-economicos/{id}', [ParametrosEconomicosWebController::class, 'update'])->name('parametros_economicos.update');
        Route::delete('/parametros-economicos/{id}', [ParametrosEconomicosWebController::class, 'destroy'])->name('parametros_economicos.destroy');
        Route::get('/parametros-economicos/{id}/show', [ParametrosEconomicosWebController::class, 'show'])->name('parametros_economicos.show');
        Route::post('/parametros-economicos/{id}/toggle-status', [ParametrosEconomicosWebController::class, 'toggleStatus'])->name('parametros_economicos.toggle-status');
        
        // Asignación Económica
        Route::get('/asignacion-economica', [AsignacionCostosWebController::class, 'index'])->name('asignacion_economica.index');
        Route::get('/asignacion-economica/{codPensum}/{gestion}', [AsignacionCostosWebController::class, 'showAsignacion'])->name('asignacion_economica.show');
        Route::post('/asignacion-economica/costo-semestral', [AsignacionCostosWebController::class, 'storeCostoSemestral'])->name('asignacion_economica.store_costo');
        Route::post('/asignacion-economica/asignacion', [AsignacionCostosWebController::class, 'storeAsignacion'])->name('asignacion_economica.store_asignacion');
        Route::get('/asignacion-economica/{codPensum}/{codInscrip}/{idAsignacion}/show', [AsignacionCostosWebController::class, 'show'])->name('asignacion_economica.show_asignacion');
        Route::put('/asignacion-economica/{codPensum}/{codInscrip}/{idAsignacion}', [AsignacionCostosWebController::class, 'updateAsignacion'])->name('asignacion_economica.update_asignacion');
        Route::delete('/asignacion-economica/{codPensum}/{codInscrip}/{idAsignacion}', [AsignacionCostosWebController::class, 'destroyAsignacion'])->name('asignacion_economica.destroy_asignacion');
        Route::post('/asignacion-economica/{codPensum}/{codInscrip}/{idAsignacion}/toggle-status', [AsignacionCostosWebController::class, 'toggleStatus'])->name('asignacion_economica.toggle_status');
        
        // Items de Cobro
        Route::get('/items-cobro', [ItemsCobroWebController::class, 'getAll'])->name('items_cobro.all');
        Route::post('/items-cobro', [ItemsCobroWebController::class, 'store'])->name('items_cobro.store');
        Route::get('/items-cobro/{id}/show', [ItemsCobroWebController::class, 'show'])->name('items_cobro.show');
        Route::put('/items-cobro/{id}', [ItemsCobroWebController::class, 'update'])->name('items_cobro.update');
        Route::delete('/items-cobro/{id}', [ItemsCobroWebController::class, 'destroy'])->name('items_cobro.destroy');
        Route::post('/items-cobro/{id}/toggle-status', [ItemsCobroWebController::class, 'toggleStatus'])->name('items_cobro.toggle-status');
        Route::get('/parametros-economicos-select', [ItemsCobroWebController::class, 'getParametrosEconomicos'])->name('items_cobro.parametros');
        
        // Materias
        Route::get('/materias', [MateriaWebController::class, 'getAll'])->name('materias.all');
        Route::post('/materias', [MateriaWebController::class, 'store'])->name('materias.store');
        Route::get('/materias/{sigla}/{codPensum}/show', [MateriaWebController::class, 'show'])->name('materias.show');
        Route::put('/materias/{sigla}/{codPensum}', [MateriaWebController::class, 'update'])->name('materias.update');
        Route::delete('/materias/{sigla}/{codPensum}', [MateriaWebController::class, 'destroy'])->name('materias.destroy');
        Route::post('/materias/{sigla}/{codPensum}/toggle-status', [MateriaWebController::class, 'toggleStatus'])->name('materias.toggle-status');
    });
});


