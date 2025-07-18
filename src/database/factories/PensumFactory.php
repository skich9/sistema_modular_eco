<?php

namespace Database\Factories;

use App\Models\Pensum;
use Illuminate\Database\Eloquent\Factories\Factory;

class PensumFactory extends Factory
{
    protected $model = Pensum::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word() . ' Pensum',
            'codigo' => $this->faker->unique()->bothify('PENSUM-####'),
            'codigo_carrera' => $this->faker->randomElement(['ING-SIS', 'ADM-EMP']),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
        ];
    }
}