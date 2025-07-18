<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Descuento;

class DescuentoSeeder extends Seeder
{
    public function run(): void
    {
        Descuento::factory()->count(5)->create();
    }
}