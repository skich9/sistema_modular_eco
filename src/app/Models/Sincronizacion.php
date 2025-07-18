<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sincronizacion extends Model
{
    use HasFactory;

    protected $table = 'sincronizaciones';

    protected $fillable = [
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'detalle',
    ];
} 
