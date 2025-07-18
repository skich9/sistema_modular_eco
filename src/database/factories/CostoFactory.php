<?php

namespace Database\Factories;

use App\Models\Costo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CostoFactory extends Factory
{
    protected $model = Costo::class;

    public function definition(): array
    {
        $nombres = [
            'Matrícula',
            'Mensualidad',
            'Material adicional',
            'Seguro',
            'Laboratorio',
        ];
        return [
            'nombre' => $this->faker->unique()->randomElement($nombres),
            'descripcion' => $this->faker->sentence(),
            'monto' => $this->faker->randomFloat(2, 50, 1000),
            'tipo' => $this->faker->randomElement(['fijo', 'variable', 'por pensum']),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
        ];
    }
} 