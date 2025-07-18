<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Descuento extends Model
{
    use HasFactory;

    protected $table = 'descuentos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'porcentaje',
        'tipo',
        'estado',
    ];

    // Relaciones
    public function descuentoUsuarios(): HasMany
    {
        return $this->hasMany(DescuentoUsuario::class);
    }
}