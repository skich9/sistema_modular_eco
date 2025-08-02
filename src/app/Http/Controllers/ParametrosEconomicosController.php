<?php

namespace App\Http\Controllers;

use App\Models\ParametrosEconomicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParametrosEconomicosController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$parametros = ParametrosEconomicos::all();
		return response()->json([
			'success' => true,
			'data' => $parametros
		]);
	}

	/**
	 * Store a newly created resource in storage.
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
	 * Display the specified resource.
	 */
	public function show(string $id)
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

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
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
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
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
	public function toggleStatus(string $id)
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
}
