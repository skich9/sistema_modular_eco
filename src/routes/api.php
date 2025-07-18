<?php

use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PensumController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\FormaPagoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('pensums', PensumController::class);
Route::apiResource('inscripciones', InscripcionController::class);
Route::apiResource('formas_pago', FormaPagoController::class);


Route::get('/productos',[ProductosController::class,'index']);
Route::get('/productos/{id}',[ProductosController::class,'show']);
Route::post('/productos',[ProductosController::class,'store']);
Route::put('/productos/{id}',[ProductosController::class,'update']);
Route::delete('/productos/{id}',[ProductosController::class,'destroy']);
