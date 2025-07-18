<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Inscripcion::all());
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
            'pensum_id' => 'required|exists:pensums,id',
            'gestion' => 'required|string',
            'estado' => 'nullable|string',
            'fecha_inscripcion' => 'nullable|date',
        ]);
        $inscripcion = Inscripcion::create($validated);
        return response()->json($inscripcion, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inscripcion = Inscripcion::find($id);
        if (!$inscripcion) {
            return response()->json(['message' => 'Inscripción no encontrada'], 404);
        }
        return response()->json($inscripcion);
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
        $inscripcion = Inscripcion::find($id);
        if (!$inscripcion) {
            return response()->json(['message' => 'Inscripción no encontrada'], 404);
        }
        $validated = $request->validate([
            'usuario_id' => 'sometimes|required|exists:usuarios,id',
            'pensum_id' => 'sometimes|required|exists:pensums,id',
            'gestion' => 'sometimes|required|string',
            'estado' => 'nullable|string',
            'fecha_inscripcion' => 'nullable|date',
        ]);
        $inscripcion->update($validated);
        return response()->json($inscripcion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inscripcion = Inscripcion::find($id);
        if (!$inscripcion) {
            return response()->json(['message' => 'Inscripción no encontrada'], 404);
        }
        $inscripcion->delete();
        return response()->json(['message' => 'Inscripción eliminada correctamente']);
    }
}
