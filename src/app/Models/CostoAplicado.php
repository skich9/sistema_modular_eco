<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CostoAplicado extends Model
{
    use HasFactory;

    protected $table = 'costo_aplicado';

    protected $fillable = [
        'costo_id',
        'tipo_usuario',
        'concepto',
        'monto',
        'vigencia_inicio',
        'vigencia_fin',
        'estado',
        'observaciones',
    ];

    // Relaciones
    public function costo(): BelongsTo
    {
        return $this->belongsTo(Costo::class);
    }
} 