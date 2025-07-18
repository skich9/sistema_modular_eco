<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Compromiso extends Model
{
    use HasFactory;

    protected $table = 'compromisos';

    protected $fillable = [
        'usuario_id',
        'cod_ceta',
        'monto',
        'fecha_compromiso',
        'fecha_vencimiento',
        'estado',
        'descripcion',
        'observaciones',
    ];

    // Relaciones
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }
}