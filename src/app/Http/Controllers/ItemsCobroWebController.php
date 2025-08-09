<?php

namespace App\Http\Controllers;

use App\Models\ItemsCobro;
use App\Models\ParametrosEconomicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemsCobroWebController extends Controller
{
	/**
	 * Obtiene todos los items de cobro para mostrar en la vista.
	 */
	public function index()
	{
		$items = ItemsCobro::with('parametroEconomico')->get();
		return view('configuracion.items_cobro.index', compact('items'));
	}
	
	/**
	 * Obtiene todos los items de cobro para mostrar en formato JSON.
	 */
	public function getAll()
	{
		$items = ItemsCobro::with('parametroEconomico')->get();
		return response()->json([
			'success' => true,
			'data' => $items
		]);
	}

	/**
	 * Almacena un nuevo item de cobro en la base de datos.
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'codigo_producto_interno' => 'required|string|max:15|unique:items_cobro',
			'unidad_medida' => 'required|integer',
			'nombre_servicio' => 'required|string|max:100',
			'nro_creditos' => 'required|numeric|min:0',
			'costo' => 'nullable|integer',
			'facturado' => 'required|boolean',
			'actividad_economica' => 'required|string|max:255',
			'descripcion' => 'nullable|string|max:50',
			'tipo_item' => 'required|string|max:40',
			'estado' => 'nullable|boolean',
			'id_parametro_economico' => 'required|integer|exists:parametros_economicos,id_parametro_economico',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validator->errors()
			], 422);
		}

		$item = ItemsCobro::create($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Item de cobro creado exitosamente',
			'data' => $item
		], 201);
	}

	/**
	 * Muestra un item de cobro específico.
	 */
	public function show($id)
	{
		$item = ItemsCobro::with('parametroEconomico')->find($id);
		
		if (!$item) {
			return response()->json([
				'success' => false,
				'message' => 'Item de cobro no encontrado'
			], 404);
		}
		
		return response()->json([
			'success' => true,
			'data' => $item
		]);
	}

	/**
	 * Actualiza un item de cobro específico en la base de datos.
	 */
	public function update(Request $request, $id)
	{
		$item = ItemsCobro::find($id);
		
		if (!$item) {
			return response()->json([
				'success' => false,
				'message' => 'Item de cobro no encontrado'
			], 404);
		}

		$validator = Validator::make($request->all(), [
			'codigo_producto_interno' => 'sometimes|required|string|max:15|unique:items_cobro,codigo_producto_interno,' . $id . ',id_item',
			'unidad_medida' => 'sometimes|required|integer',
			'nombre_servicio' => 'sometimes|required|string|max:100',
			'nro_creditos' => 'sometimes|required|numeric|min:0',
			'costo' => 'nullable|integer',
			'facturado' => 'sometimes|required|boolean',
			'actividad_economica' => 'sometimes|required|string|max:255',
			'descripcion' => 'nullable|string|max:50',
			'tipo_item' => 'sometimes|required|string|max:40',
			'estado' => 'nullable|boolean',
			'id_parametro_economico' => 'sometimes|required|integer|exists:parametros_economicos,id_parametro_economico',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validator->errors()
			], 422);
		}

		$item->update($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Item de cobro actualizado exitosamente',
			'data' => $item
		]);
	}

	/**
	 * Elimina un item de cobro específico de la base de datos.
	 */
	public function destroy($id)
	{
		$item = ItemsCobro::find($id);
		
		if (!$item) {
			return response()->json([
				'success' => false,
				'message' => 'Item de cobro no encontrado'
			], 404);
		}

		$item->delete();

		return response()->json([
			'success' => true,
			'message' => 'Item de cobro eliminado exitosamente'
		]);
	}
	
	/**
	 * Actualiza el estado del item de cobro.
	 */
	public function toggleStatus(Request $request, $id)
	{
		$item = ItemsCobro::find($id);
		
		if (!$item) {
			return response()->json([
				'success' => false,
				'message' => 'Item de cobro no encontrado'
			], 404);
		}
		
		$item->estado = !$item->estado;
		$item->save();
		
		return response()->json([
			'success' => true,
			'message' => 'Estado del item de cobro actualizado exitosamente',
			'data' => $item
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
