<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Costo;

class CostoSeeder extends Seeder
{
    public function run(): void
    {
        Costo::factory()->count(5)->create();
    }
}