<?php

namespace App\Http\Controllers;

use App\Models\Costo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CostoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Costo::all());
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
            'nombre' => 'required|string|max:255|unique:costos,nombre',
            'descripcion' => 'nullable|string',
            'monto' => 'required|numeric|min:0',
            'tipo' => 'nullable|string',
            'estado' => 'nullable|string',
        ]);
        $costo = Costo::create($validated);
        return response()->json($costo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $costo = Costo::find($id);
        if (!$costo) {
            return response()->json(['message' => 'Costo no encontrado'], 404);
        }
        return response()->json($costo);
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
        $costo = Costo::find($id);
        if (!$costo) {
            return response()->json(['message' => 'Costo no encontrado'], 404);
        }
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255|unique:costos,nombre,' . $id,
            'descripcion' => 'nullable|string',
            'monto' => 'sometimes|required|numeric|min:0',
            'tipo' => 'nullable|string',
            'estado' => 'nullable|string',
        ]);
        $costo->update($validated);
        return response()->json($costo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $costo = Costo::find($id);
        if (!$costo) {
            return response()->json(['message' => 'Costo no encontrado'], 404);
        }
        $costo->delete();
        return response()->json(['message' => 'Costo eliminado correctamente']);
    }
}
