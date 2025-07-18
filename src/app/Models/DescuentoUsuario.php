<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DescuentoUsuario extends Model
{
    use HasFactory;

    protected $table = 'descuento_usuario';

    protected $fillable = [
        'descuento_id',
        'usuario_id',
        'inscripcion_id',
        'cuota_id',
        'monto',
        'porcentaje',
        'fecha_asignacion',
        'observaciones',
    ];

    // Relaciones
    public function descuento(): BelongsTo
    {
        return $this->belongsTo(Descuento::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(Inscripcion::class);
    }

    public function cuota(): BelongsTo
    {
        return $this->belongsTo(Cuota::class);
    }
}