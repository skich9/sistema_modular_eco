<?php

namespace App\Http\Controllers;

use App\Models\Beca;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BecaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Beca::all());
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
            'nombre' => 'required|string|max:255|unique:becas,nombre',
            'descripcion' => 'nullable|string',
            'porcentaje' => 'required|numeric|min:0|max:100',
            'tipo' => 'nullable|string',
            'estado' => 'nullable|string',
        ]);
        $beca = Beca::create($validated);
        return response()->json($beca, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $beca = Beca::find($id);
        if (!$beca) {
            return response()->json(['message' => 'Beca no encontrada'], 404);
        }
        return response()->json($beca);
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
        $beca = Beca::find($id);
        if (!$beca) {
            return response()->json(['message' => 'Beca no encontrada'], 404);
        }
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255|unique:becas,nombre,' . $id,
            'descripcion' => 'nullable|string',
            'porcentaje' => 'sometimes|required|numeric|min:0|max:100',
            'tipo' => 'nullable|string',
            'estado' => 'nullable|string',
        ]);
        $beca->update($validated);
        return response()->json($beca);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $beca = Beca::find($id);
        if (!$beca) {
            return response()->json(['message' => 'Beca no encontrada'], 404);
        }
        $beca->delete();
        return response()->json(['message' => 'Beca eliminada correctamente']);
    }
}
