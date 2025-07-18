<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CuentaBancaria;

class CuentaBancariaSeeder extends Seeder
{
    public function run(): void
    {
        CuentaBancaria::factory()->count(5)->create();
    }
}