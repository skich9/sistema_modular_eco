<?php

namespace Database\Factories;

use App\Models\FormaPago;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormaPagoFactory extends Factory
{
    protected $model = FormaPago::class;

    public function definition(): array
    {
        $nombres = [
            'Efectivo',
            'Transferencia bancaria',
            'Depósito bancario',
            'QR',
            'Tarjeta',
            'Traspaso',
        ];
        return [
            'nombre' => $this->faker->unique()->randomElement($nombres),
            'descripcion' => $this->faker->sentence(),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
        ];
    }
}