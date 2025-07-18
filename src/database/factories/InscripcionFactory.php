<?php

namespace Database\Factories;

use App\Models\Inscripcion;
use App\Models\Usuario;
use App\Models\Pensum;
use Illuminate\Database\Eloquent\Factories\Factory;

class InscripcionFactory extends Factory
{
    protected $model = Inscripcion::class;

    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::inRandomOrder()->first()?->id ?? Usuario::factory(),
            'pensum_id' => Pensum::inRandomOrder()->first()?->id ?? Pensum::factory(),
            'gestion' => $this->faker->randomElement(['2024/1', '2024/2', '2025/1']),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
            'fecha_inscripcion' => $this->faker->date(),
        ];
    }
}