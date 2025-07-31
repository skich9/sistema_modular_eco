<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ========== RUTAS DE AUTENTICACIÓN ==========

// Redirigir la raíz al login
Route::get('/', function () {
	return redirect()->route('login');
});

// Rutas de login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth.custom')->group(function () {
	// Dashboard
	Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
	
	// Cambio de contraseña
	Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
	Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password.post');
});

// Logout (no necesita middleware porque destruye la sesión)
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
