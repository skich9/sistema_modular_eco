<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\FuncionController;
use App\Http\Controllers\AsignacionFuncionController;
// use App\Http\Controllers\ProductosController; // Comentado - no existe
// use App\Http\Controllers\PensumController; // Comentado - no existe
// Comentado - controladores no existen
// use App\Http\Controllers\InscripcionController;
// use App\Http\Controllers\FormaPagoController;
// use App\Http\Controllers\CuentaBancariaController;
// use App\Http\Controllers\CuotaController;
// use App\Http\Controllers\BecaController;
// use App\Http\Controllers\DescuentoController;
// use App\Http\Controllers\CostoController;
// use App\Http\Controllers\CompromisoController;
// use App\Http\Controllers\ProrrogaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ========== RUTAS PRINCIPALES DE AUTENTICACIÓN Y GESTIÓN ==========

// Usuarios - Rutas de recursos completas
Route::apiResource('usuarios', UsuarioController::class);
// Rutas adicionales para usuarios
Route::post('usuarios/{id}/asignar-funciones', [UsuarioController::class, 'asignarFunciones']);
Route::get('usuarios/rol/{idRol}', [UsuarioController::class, 'usuariosPorRol']);
Route::patch('usuarios/{id}/estado', [UsuarioController::class, 'cambiarEstado']);

// Roles - Rutas de recursos completas
Route::apiResource('roles', RolController::class);
// Rutas adicionales para roles
Route::patch('roles/{id}/estado', [RolController::class, 'cambiarEstado']);
Route::get('roles/activos', [RolController::class, 'rolesActivos']);

// Funciones - Rutas de recursos completas
Route::apiResource('funciones', FuncionController::class);
// Rutas adicionales para funciones
Route::patch('funciones/{id}/estado', [FuncionController::class, 'cambiarEstado']);
Route::get('funciones/activas', [FuncionController::class, 'funcionesActivas']);
Route::get('funciones/{id}/usuarios', [FuncionController::class, 'usuariosAsignados']);

// Asignaciones de Funciones - Rutas de recursos completas
Route::apiResource('asignaciones', AsignacionFuncionController::class);
// Rutas adicionales para asignaciones
Route::patch('asignaciones/{id}/finalizar', [AsignacionFuncionController::class, 'finalizar']);
Route::get('asignaciones/usuario/{idUsuario}', [AsignacionFuncionController::class, 'asignacionesPorUsuario']);
Route::get('asignaciones/activas', [AsignacionFuncionController::class, 'asignacionesActivas']);

// ========== RUTAS DEL SISTEMA ACADÉMICO/FINANCIERO ==========

// Comentado - controladores no existen
// Route::apiResource('pensums', PensumController::class);
// Route::apiResource('inscripciones', InscripcionController::class);
// Route::apiResource('formas_pago', FormaPagoController::class);
// Route::apiResource('cuentas_bancarias', CuentaBancariaController::class);
// Route::apiResource('cuotas', CuotaController::class);
// Route::apiResource('becas', BecaController::class);
// Route::apiResource('descuentos', DescuentoController::class);
// Route::apiResource('costos', CostoController::class);
// Route::apiResource('compromisos', CompromisoController::class);
// Route::apiResource('prorrogas', ProrrogaController::class);

// Comentado - ProductosController no existe
// Route::get('/productos', [ProductosController::class, 'index']);
// Route::get('/productos/{id}', [ProductosController::class, 'show']);
// Route::post('/productos', [ProductosController::class, 'store']);
// Route::put('/productos/{id}', [ProductosController::class, 'update']);
// Route::delete('/productos/{id}', [ProductosController::class, 'destroy']);

// ========== RUTAS PARA PARÁMETROS DEL SISTEMA ==========

// Comentado - controladores no existen en esta ubicación
// use App\Http\Controllers\Api\MateriaController;
// use App\Http\Controllers\Api\ParametrosEconomicosController;
// use App\Http\Controllers\Api\ItemsCobroController;

// Comentado - estas rutas están duplicadas en web.php y causan conflictos
// Route::prefix('parametros-sistema')->group(function () {
//     // Materias
//     Route::get('/materias', [MateriaController::class, 'index']);
//     Route::post('/materias', [MateriaController::class, 'store']);
//     Route::get('/materias/{sigla}/{pensum}', [MateriaController::class, 'show']);
//     Route::put('/materias/{sigla}/{pensum}', [MateriaController::class, 'update']);
//     Route::delete('/materias/{sigla}/{pensum}', [MateriaController::class, 'destroy']);
//     Route::put('/materias/{sigla}/{pensum}/toggle-status', [MateriaController::class, 'toggleStatus']);
//     
//     // Parámetros económicos
//     Route::get('/parametros-economicos', [ParametrosEconomicosController::class, 'index']);
//     Route::post('/parametros-economicos', [ParametrosEconomicosController::class, 'store']);
//     Route::get('/parametros-economicos/{id}', [ParametrosEconomicosController::class, 'show']);
//     Route::put('/parametros-economicos/{id}', [ParametrosEconomicosController::class, 'update']);
//     Route::delete('/parametros-economicos/{id}', [ParametrosEconomicosController::class, 'destroy']);
//     Route::put('/parametros-economicos/{id}/toggle-status', [ParametrosEconomicosController::class, 'toggleStatus']);
//     
//     // Items de cobro
//     Route::get('/items-cobro', [ItemsCobroController::class, 'index']);
//     Route::post('/items-cobro', [ItemsCobroController::class, 'store']);
//     Route::get('/items-cobro/{id}', [ItemsCobroController::class, 'show']);
//     Route::put('/items-cobro/{id}', [ItemsCobroController::class, 'update']);
//     Route::delete('/items-cobro/{id}', [ItemsCobroController::class, 'destroy']);
//     Route::put('/items-cobro/{id}/toggle-status', [ItemsCobroController::class, 'toggleStatus']);
// });
