<?php

namespace App\Http\Controllers;

use App\Models\Compromiso;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompromisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Compromiso::all());
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
            'usuario_id' => 'required|exists:usuarios,id',
            'monto' => 'required|numeric|min:0',
            'fecha_compromiso' => 'required|date',
            'fecha_vencimiento' => 'required|date|after:fecha_compromiso',
            'descripcion' => 'nullable|string',
            'estado' => 'nullable|string',
        ]);
        $compromiso = Compromiso::create($validated);
        return response()->json($compromiso, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $compromiso = Compromiso::find($id);
        if (!$compromiso) {
            return response()->json(['message' => 'Compromiso no encontrado'], 404);
        }
        return response()->json($compromiso);
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
        $compromiso = Compromiso::find($id);
        if (!$compromiso) {
            return response()->json(['message' => 'Compromiso no encontrado'], 404);
        }
        $validated = $request->validate([
            'usuario_id' => 'sometimes|required|exists:usuarios,id',
            'monto' => 'sometimes|required|numeric|min:0',
            'fecha_compromiso' => 'sometimes|required|date',
            'fecha_vencimiento' => 'sometimes|required|date|after:fecha_compromiso',
            'descripcion' => 'nullable|string',
            'estado' => 'nullable|string',
        ]);
        $compromiso->update($validated);
        return response()->json($compromiso);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $compromiso = Compromiso::find($id);
        if (!$compromiso) {
            return response()->json(['message' => 'Compromiso no encontrado'], 404);
        }
        $compromiso->delete();
        return response()->json(['message' => 'Compromiso eliminado correctamente']);
    }
}
