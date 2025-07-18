<?php

namespace Database\Factories;

use App\Models\Cuota;
use Illuminate\Database\Eloquent\Factories\Factory;

class CuotaFactory extends Factory
{
    protected $model = Cuota::class;

    public function definition(): array
    {
        $n = $this->faker->numberBetween(1, 6);
        return [
            'nombre' => 'Cuota ' . $n,
            'descripcion' => $this->faker->sentence(),
            'monto' => $this->faker->randomFloat(2, 100, 500),
            'fecha_vencimiento' => $this->faker->dateTimeBetween('+1 week', '+6 months'),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
            'tipo' => $this->faker->randomElement(['mensualidad', 'extraordinaria']),
        ];
    }
} 