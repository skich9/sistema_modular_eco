<?php

use App\Http\Controllers\ProductosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/productos',[ProductosController::class,'index']);
Route::get('/productos/{id}',[ProductosController::class,'show']);
Route::post('/productos',[ProductosController::class,'store']);
Route::put('/productos/{id}',[ProductosController::class,'update']);
Route::delete('/productos/{id}',[ProductosController::class,'destroy']);
