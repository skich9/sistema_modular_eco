<?php

namespace App\Http\Controllers;

use App\Models\Pensum;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PensumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Pensum::all());
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
            'codigo' => 'required|string|unique:pensums,codigo',
            'codigo_carrera' => 'required|string',
            'estado' => 'nullable|string',
        ]);
        $pensum = Pensum::create($validated);
        return response()->json($pensum, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $pensum = Pensum::find($id);
        if (!$pensum) {
            return response()->json(['message' => 'Pensum no encontrado'], 404);
        }
        return response()->json($pensum);
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
        $pensum = Pensum::find($id);
        if (!$pensum) {
            return response()->json(['message' => 'Pensum no encontrado'], 404);
        }
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'codigo' => 'sometimes|required|string|unique:pensums,codigo,' . $id,
            'codigo_carrera' => 'sometimes|required|string',
            'estado' => 'nullable|string',
        ]);
        $pensum->update($validated);
        return response()->json($pensum);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pensum = Pensum::find($id);
        if (!$pensum) {
            return response()->json(['message' => 'Pensum no encontrado'], 404);
        }
        $pensum->delete();
        return response()->json(['message' => 'Pensum eliminado correctamente']);
    }
}
