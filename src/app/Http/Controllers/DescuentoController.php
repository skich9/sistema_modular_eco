<?php

namespace App\Http\Controllers;

use App\Models\Descuento;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DescuentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Descuento::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:descuentos,nombre',
            'descripcion' => 'nullable|string',
            'porcentaje' => 'required|numeric|min:0|max:100',
            'tipo' => 'nullable|string',
            'estado' => 'nullable|string',
        ]);
        $descuento = Descuento::create($validated);
        return response()->json($descuento, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $descuento = Descuento::find($id);
        if (!$descuento) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }
        return response()->json($descuento);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $descuento = Descuento::find($id);
        if (!$descuento) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255|unique:descuentos,nombre,' . $id,
            'descripcion' => 'nullable|string',
            'porcentaje' => 'sometimes|required|numeric|min:0|max:100',
            'tipo' => 'nullable|string',
            'estado' => 'nullable|string',
        ]);
        $descuento->update($validated);
        return response()->json($descuento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $descuento = Descuento::find($id);
        if (!$descuento) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }
        $descuento->delete();
        return response()->json(['message' => 'Descuento eliminado correctamente']);
    }
}
