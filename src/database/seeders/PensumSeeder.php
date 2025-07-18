<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pensum;

class PensumSeeder extends Seeder
{
    public function run(): void
    {
        Pensum::factory()->count(10)->create();
    }
} 