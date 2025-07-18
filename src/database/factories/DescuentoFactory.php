<?php

namespace Database\Factories;

use App\Models\Descuento;
use Illuminate\Database\Eloquent\Factories\Factory;

class DescuentoFactory extends Factory
{
    protected $model = Descuento::class;

    public function definition(): array
    {
        $nombres = [
            'Descuento por hermano',
            'Descuento pronto pago',
            'Descuento convenio',
            'Descuento especial',
            'Descuento por nota',
        ];
        return [
            'nombre' => $this->faker->unique()->randomElement($nombres),
            'descripcion' => $this->faker->sentence(),
            'porcentaje' => $this->faker->randomElement([5, 10, 15, 20, 25]),
            'tipo' => $this->faker->randomElement(['por cuota', 'por matrícula', 'general']),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
        ];
    }
}