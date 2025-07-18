<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Costo extends Model
{
    use HasFactory;

    protected $table = 'costos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'monto',
        'tipo',
        'estado',
    ];

    // Relaciones
    public function costoAplicados(): HasMany
    {
        return $this->hasMany(CostoAplicado::class);
    }
} 