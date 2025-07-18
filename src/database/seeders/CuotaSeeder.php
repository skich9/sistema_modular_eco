<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cuota;

class CuotaSeeder extends Seeder
{
    public function run(): void
    {
        Cuota::factory()->count(6)->create();
    }
}