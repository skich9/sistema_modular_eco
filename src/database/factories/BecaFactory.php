<?php

namespace Database\Factories;

use App\Models\Beca;
use Illuminate\Database\Eloquent\Factories\Factory;

class BecaFactory extends Factory
{
    protected $model = Beca::class;

    public function definition(): array
    {
        $nombres = [
            'Beca Excelencia',
            'Beca Social',
            'Beca Deportiva',
            'Beca Cultural',
            'Beca Parcial',
        ];
        return [
            'nombre' => $this->faker->unique()->randomElement($nombres),
            'descripcion' => $this->faker->sentence(),
            'porcentaje' => $this->faker->randomElement([25, 50, 75, 100]),
            'tipo' => $this->faker->randomElement(['total', 'parcial', 'por cuota']),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
        ];
    }
}