<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\ParametrosEconomicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MateriaWebController extends Controller
{
	/**
	 * Obtiene todas las materias para mostrar en la vista.
	 */
	public function index()
	{
		$materias = Materia::with('parametroEconomico')->get();
		return view('configuracion.materias.index', compact('materias'));
	}
	
	/**
	 * Obtiene todas las materias para mostrar en formato JSON.
	 */
	public function getAll()
	{
		$materias = Materia::with('parametroEconomico')->get();
		return response()->json([
			'success' => true,
			'data' => $materias
		]);
	}

	/**
	 * Almacena una nueva materia en la base de datos.
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'sigla_materia' => 'required|string|max:255',
			'cod_pensum' => 'required|string|max:50|exists:pensums,cod_pensum',
			'nombre_materia' => 'required|string|max:50',
			'nombre_material_oficial' => 'required|string|max:50',
			'estado' => 'required|boolean',
			'orden' => 'required|integer',
			'descripcion' => 'nullable|string|max:50',
			'id_parametro_economico' => 'required|integer|exists:parametros_economicos,id_parametro_economico',
			'nro_creditos' => 'required|numeric|min:0',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validator->errors()
			], 422);
		}

		$materia = Materia::create($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Materia creada exitosamente',
			'data' => $materia
		], 201);
	}

	/**
	 * Muestra una materia específica.
	 */
	public function show($sigla, $codPensum)
	{
		$materia = Materia::with('parametroEconomico')
			->where('sigla_materia', $sigla)
			->where('cod_pensum', $codPensum)
			->first();
		
		if (!$materia) {
			return response()->json([
				'success' => false,
				'message' => 'Materia no encontrada'
			], 404);
		}
		
		return response()->json([
			'success' => true,
			'data' => $materia
		]);
	}

	/**
	 * Actualiza una materia específica en la base de datos.
	 */
	public function update(Request $request, $sigla, $codPensum)
	{
		$materia = Materia::where('sigla_materia', $sigla)
			->where('cod_pensum', $codPensum)
			->first();
		
		if (!$materia) {
			return response()->json([
				'success' => false,
				'message' => 'Materia no encontrada'
			], 404);
		}

		$validator = Validator::make($request->all(), [
			'nombre_materia' => 'sometimes|required|string|max:50',
			'nombre_material_oficial' => 'sometimes|required|string|max:50',
			'estado' => 'sometimes|required|boolean',
			'orden' => 'sometimes|required|integer',
			'descripcion' => 'nullable|string|max:50',
			'id_parametro_economico' => 'sometimes|required|integer|exists:parametros_economicos,id_parametro_economico',
			'nro_creditos' => 'sometimes|required|numeric|min:0',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validator->errors()
			], 422);
		}

		$materia->update($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Materia actualizada exitosamente',
			'data' => $materia
		]);
	}

	/**
	 * Elimina una materia específica de la base de datos.
	 */
	public function destroy($sigla, $codPensum)
	{
		$materia = Materia::where('sigla_materia', $sigla)
			->where('cod_pensum', $codPensum)
			->first();
		
		if (!$materia) {
			return response()->json([
				'success' => false,
				'message' => 'Materia no encontrada'
			], 404);
		}

		$materia->delete();

		return response()->json([
			'success' => true,
			'message' => 'Materia eliminada exitosamente'
		]);
	}
	
	/**
	 * Actualiza el estado de la materia.
	 */
	public function toggleStatus(Request $request, $sigla, $codPensum)
	{
		$materia = Materia::where('sigla_materia', $sigla)
			->where('cod_pensum', $codPensum)
			->first();
		
		if (!$materia) {
			return response()->json([
				'success' => false,
				'message' => 'Materia no encontrada'
			], 404);
		}
		
		$materia->estado = !$materia->estado;
		$materia->save();
		
		return response()->json([
			'success' => true,
			'message' => 'Estado de la materia actualizado exitosamente',
			'data' => $materia
		]);
	}
	
	/**
	 * Obtiene los parámetros económicos para el select del formulario.
	 */
	public function getParametrosEconomicos()
	{
		$parametros = ParametrosEconomicos::where('estado', true)->get();
		return response()->json([
			'success' => true,
			'data' => $parametros
		]);
	}
}
