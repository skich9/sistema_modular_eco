<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CustomAuth
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		// Verificar si el usuario está autenticado
		if (!Session::has('usuario_autenticado')) {
			return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder a esta página');
		}

		// Verificar que la sesión tenga los datos necesarios
		$usuario = Session::get('usuario_autenticado');
		if (!$usuario || !isset($usuario['id']) || !isset($usuario['rol_id'])) {
			Session::forget('usuario_autenticado');
			return redirect()->route('login')->with('error', 'Sesión inválida. Por favor, inicie sesión nuevamente');
		}

		return $next($request);
	}
}
