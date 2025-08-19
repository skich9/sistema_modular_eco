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
		// Para peticiones AJAX/API, devolver JSON en lugar de redirección
		if ($request->expectsJson() || $request->is('api/*')) {
			if (!Session::has('usuario_autenticado')) {
				return response()->json([
					'success' => false,
					'message' => 'No autenticado',
					'error' => 'Debe iniciar sesión para acceder a esta API'
				], 401);
			}

			$usuario = Session::get('usuario_autenticado');
			if (!$usuario || !isset($usuario['id']) || !isset($usuario['rol_id'])) {
				Session::forget('usuario_autenticado');
				return response()->json([
					'success' => false,
					'message' => 'Sesión inválida',
					'error' => 'Por favor, inicie sesión nuevamente'
				], 401);
			}
		} else {
			// Para peticiones web normales, mantener redirección
			if (!Session::has('usuario_autenticado')) {
				return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder a esta página');
			}

			$usuario = Session::get('usuario_autenticado');
			if (!$usuario || !isset($usuario['id']) || !isset($usuario['rol_id'])) {
				Session::forget('usuario_autenticado');
				return redirect()->route('login')->with('error', 'Sesión inválida. Por favor, inicie sesión nuevamente');
			}
		}

		return $next($request);
	}
}
