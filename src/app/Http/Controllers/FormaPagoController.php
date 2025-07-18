<?php

namespace App\Http\Controllers;

use App\Models\FormaPago;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormaPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(FormaPago::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:formas_pago,nombre',
            'descripcion' => 'nullable|string',
            'estado' => 'nullable|string',
        ]);
        $formaPago = FormaPago::create($validated);
        return response()->json($formaPago, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $formaPago = FormaPago::find($id);
        if (!$formaPago) {
            return response()->json(['message' => 'Forma de pago no encontrada'], 404);
        }
        return response()->json($formaPago);
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
         $formaPago = FormaPago::find($id);
        if (!$formaPago) {
            return response()->json(['message' => 'Forma de pago no encontrada'], 404);
        }
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255|unique:formas_pago,nombre,' . $id,
            'descripcion' => 'nullable|string',
            'estado' => 'nullable|string',
        ]);
        $formaPago->update($validated);
        return response()->json($formaPago);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $formaPago = FormaPago::find($id);
        if (!$formaPago) {
            return response()->json(['message' => 'Forma de pago no encontrada'], 404);
        }
        $formaPago->delete();
        return response()->json(['message' => 'Forma de pago eliminada correctamente']);
    }
}
