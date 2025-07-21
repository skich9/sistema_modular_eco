<?php

namespace App\Http\Controllers;

use App\Models\Prorroga;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProrrogaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Prorroga::all());
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
            'fecha_solicitud' => 'required|date',
            'fecha_vencimiento_original' => 'required|date',
            'fecha_vencimiento_nueva' => 'required|date|after:fecha_vencimiento_original',
            'motivo' => 'required|string',
            'estado' => 'nullable|string',
            'aprobado_por' => 'nullable|string',
        ]);
        $prorroga = Prorroga::create($validated);
        return response()->json($prorroga, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prorroga = Prorroga::find($id);
        if (!$prorroga) {
            return response()->json(['message' => 'Prórroga no encontrada'], 404);
        }
        return response()->json($prorroga);
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
        $prorroga = Prorroga::find($id);
        if (!$prorroga) {
            return response()->json(['message' => 'Prórroga no encontrada'], 404);
        }
        $validated = $request->validate([
            'usuario_id' => 'sometimes|required|exists:usuarios,id',
            'fecha_solicitud' => 'sometimes|required|date',
            'fecha_vencimiento_original' => 'sometimes|required|date',
            'fecha_vencimiento_nueva' => 'sometimes|required|date|after:fecha_vencimiento_original',
            'motivo' => 'sometimes|required|string',
            'estado' => 'nullable|string',
            'aprobado_por' => 'nullable|string',
        ]);
        $prorroga->update($validated);
        return response()->json($prorroga);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prorroga = Prorroga::find($id);
        if (!$prorroga) {
            return response()->json(['message' => 'Prórroga no encontrada'], 404);
        }
        $prorroga->delete();
        return response()->json(['message' => 'Prórroga eliminada correctamente']);
    }
}
