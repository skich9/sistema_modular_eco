<?php

namespace App\Http\Controllers;

use App\Models\ParametrosEconomicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParametrosEconomicosWebController extends Controller
{
	/**
	 * Muestra la lista de parámetros económicos.
	 */
	public function index()
	{
		$parametros = ParametrosEconomicos::all();
		return view('configuracion.parametros_economicos.index', compact('parametros'));
	}

	/**
	 * Almacena un nuevo parámetro económico en la base de datos.
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nombre' => 'required|string|max:20|unique:parametros_economicos',
			'valor' => 'required|numeric|min:0',
			'descripcion' => 'required|string|max:50',
			'estado' => 'required|boolean',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validator->errors()
			], 422);
		}

		$parametro = ParametrosEconomicos::create($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Parámetro económico creado exitosamente',
			'data' => $parametro
		], 201);
	}

	/**
	 * Muestra el formulario para editar un parámetro económico.
	 */
	public function edit($id)
	{
		$parametro = ParametrosEconomicos::find($id);
		
		if (!$parametro) {
			return redirect()->route('parametros_economicos.index')
				->with('error', 'Parámetro económico no encontrado');
		}
		
		return view('configuracion.parametros_economicos.edit', compact('parametro'));
	}

	/**
	 * Actualiza el parámetro económico especificado en la base de datos.
	 */
	public function update(Request $request, $id)
	{
		$parametro = ParametrosEconomicos::find($id);
		
		if (!$parametro) {
			return response()->json([
				'success' => false,
				'message' => 'Parámetro económico no encontrado'
			], 404);
		}

		$validator = Validator::make($request->all(), [
			'nombre' => 'sometimes|required|string|max:20|unique:parametros_economicos,nombre,' . $id . ',id_parametro_economico',
			'valor' => 'sometimes|required|numeric|min:0',
			'descripcion' => 'sometimes|required|string|max:50',
			'estado' => 'sometimes|required|boolean',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validator->errors()
			], 422);
		}

		$parametro->update($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Parámetro económico actualizado exitosamente',
			'data' => $parametro
		]);
	}

	/**
	 * Elimina el parámetro económico especificado de la base de datos.
	 */
	public function destroy($id)
	{
		$parametro = ParametrosEconomicos::find($id);
		
		if (!$parametro) {
			return response()->json([
				'success' => false,
				'message' => 'Parámetro económico no encontrado'
			], 404);
		}

		// Verificar si el parámetro tiene relaciones antes de eliminar
		if ($parametro->itemsCobro()->count() > 0 || $parametro->materias()->count() > 0) {
			return response()->json([
				'success' => false,
				'message' => 'No se puede eliminar el parámetro económico porque tiene elementos asociados'
			], 400);
		}

		$parametro->delete();

		return response()->json([
			'success' => true,
			'message' => 'Parámetro económico eliminado exitosamente'
		]);
	}
	
	/**
	 * Actualiza el estado del parámetro económico.
	 */
	public function toggleStatus(Request $request, $id)
	{
		$parametro = ParametrosEconomicos::find($id);
		
		if (!$parametro) {
			return response()->json([
				'success' => false,
				'message' => 'Parámetro económico no encontrado'
			], 404);
		}
		
		$parametro->estado = !$parametro->estado;
		$parametro->save();
		
		return response()->json([
			'success' => true,
			'message' => 'Estado del parámetro económico actualizado exitosamente',
			'data' => $parametro
		]);
	}
	
	/**
	 * Obtiene los datos de un parámetro económico para mostrar en un modal.
	 */
	public function show($id)
	{
		$parametro = ParametrosEconomicos::find($id);
		
		if (!$parametro) {
			return response()->json([
				'success' => false,
				'message' => 'Parámetro económico no encontrado'
			], 404);
		}
		
		return response()->json([
			'success' => true,
			'data' => $parametro
		]);
	}
}
