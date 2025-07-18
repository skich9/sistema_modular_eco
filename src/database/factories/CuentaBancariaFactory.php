<?php

namespace Database\Factories;

use App\Models\CuentaBancaria;
use Illuminate\Database\Eloquent\Factories\Factory;

class CuentaBancariaFactory extends Factory
{
    protected $model = CuentaBancaria::class;

    public function definition(): array
    {
        $bancos = [
            'Banco Unión',
            'Banco Mercantil',
            'Banco Nacional',
            'Banco FIE',
            'Banco BISA',
        ];
        $tipos = ['Caja de ahorro', 'Cuenta corriente'];
        return [
            'banco' => $this->faker->randomElement($bancos),
            'numero_cuenta' => $this->faker->unique()->bankAccountNumber(),
            'tipo_cuenta' => $this->faker->randomElement($tipos),
            'titular' => $this->faker->name(),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
        ];
    }
} 