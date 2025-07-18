<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Cuota::all());
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
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'monto' => 'required|numeric',
            'fecha_vencimiento' => 'nullable|date',
            'estado' => 'nullable|string',
            'tipo' => 'nullable|string',
        ]);
        $cuota = Cuota::create($validated);
        return response()->json($cuota, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cuota = Cuota::find($id);
        if (!$cuota) {
            return response()->json(['message' => 'Cuota no encontrada'], 404);
        }
        return response()->json($cuota);
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
        $cuota = Cuota::find($id);
        if (!$cuota) {
            return response()->json(['message' => 'Cuota no encontrada'], 404);
        }
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'monto' => 'sometimes|required|numeric',
            'fecha_vencimiento' => 'nullable|date',
            'estado' => 'nullable|string',
            'tipo' => 'nullable|string',
        ]);
        $cuota->update($validated);
        return response()->json($cuota);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cuota = Cuota::find($id);
        if (!$cuota) {
            return response()->json(['message' => 'Cuota no encontrada'], 404);
        }
        $cuota->delete();
        return response()->json(['message' => 'Cuota eliminada correctamente']);
    }
}
