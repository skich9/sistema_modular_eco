<?php

namespace App\Http\Controllers;

use App\Models\CuentaBancaria;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CuentaBancariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(CuentaBancaria::all());
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
            'banco' => 'required|string|max:255',
            'numero_cuenta' => 'required|string|unique:cuentas_bancarias,numero_cuenta',
            'tipo_cuenta' => 'required|string',
            'titular' => 'required|string',
            'estado' => 'nullable|string',
        ]);
        $cuenta = CuentaBancaria::create($validated);
        return response()->json($cuenta, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cuenta = CuentaBancaria::find($id);
        if (!$cuenta) {
            return response()->json(['message' => 'Cuenta bancaria no encontrada'], 404);
        }
        return response()->json($cuenta);
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
        $cuenta = CuentaBancaria::find($id);
        if (!$cuenta) {
            return response()->json(['message' => 'Cuenta bancaria no encontrada'], 404);
        }
        $validated = $request->validate([
            'banco' => 'sometimes|required|string|max:255',
            'numero_cuenta' => 'sometimes|required|string|unique:cuentas_bancarias,numero_cuenta,' . $id,
            'tipo_cuenta' => 'sometimes|required|string',
            'titular' => 'sometimes|required|string',
            'estado' => 'nullable|string',
        ]);
        $cuenta->update($validated);
        return response()->json($cuenta);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cuenta = CuentaBancaria::find($id);
        if (!$cuenta) {
            return response()->json(['message' => 'Cuenta bancaria no encontrada'], 404);
        }
        $cuenta->delete();
        return response()->json(['message' => 'Cuenta bancaria eliminada correctamente']);
    }
}
