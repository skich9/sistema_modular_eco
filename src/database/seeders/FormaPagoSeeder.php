<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormaPago;

class FormaPagoSeeder extends Seeder
{
    public function run(): void
    {
        FormaPago::factory()->count(6)->create();
    }
}