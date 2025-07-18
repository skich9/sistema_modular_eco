<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prorroga extends Model
{
    use HasFactory;

    protected $table = 'prorrogas';

    protected $fillable = [
        'usuario_id',
        'cod_ceta',
        'cuota_id',
        'fecha_solicitud',
        'fecha_prorroga',
        'estado',
        'motivo',
        'observaciones',
    ];

    // Relaciones
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    public function cuota(): BelongsTo
    {
        return $this->belongsTo(Cuota::class);
    }
}