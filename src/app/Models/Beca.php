<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beca extends Model
{
    use HasFactory;

    protected $table = 'becas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'porcentaje',
        'tipo',
        'estado',
    ];

    // Relaciones
    public function becaUsuarios(): HasMany
    {
        return $this->hasMany(BecaUsuario::class);
    }
}