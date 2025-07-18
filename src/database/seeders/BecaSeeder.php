<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Beca;

class BecaSeeder extends Seeder
{
    public function run(): void
    {
        Beca::factory()->count(5)->create();
    }
} 