<?php

use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PensumController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\FormaPagoController;
use App\Http\Controllers\CuentaBancariaController;
use App\Http\Controllers\CuotaController;
use App\Http\Controllers\BecaController;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\CostoController;
use App\Http\Controllers\CompromisoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('pensums', PensumController::class);
Route::apiResource('inscripciones', InscripcionController::class);
Route::apiResource('formas_pago', FormaPagoController::class);
Route::apiResource('cuentas_bancarias', CuentaBancariaController::class);
Route::apiResource('cuotas', CuotaController::class);
Route::apiResource('becas', BecaController::class);
Route::apiResource('descuentos', DescuentoController::class);
Route::apiResource('costos', CostoController::class);
Route::apiResource('compromisos', CompromisoController::class);  


Route::get('/productos',[ProductosController::class,'index']);
Route::get('/productos/{id}',[ProductosController::class,'show']);
Route::post('/productos',[ProductosController::class,'store']);
Route::put('/productos/{id}',[ProductosController::class,'update']);
Route::delete('/productos/{id}',[ProductosController::class,'destroy']);
