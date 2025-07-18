<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inscripcion;

class InscripcionSeeder extends Seeder
{
    public function run(): void
    {
        Inscripcion::factory()->count(20)->create();
    }
}