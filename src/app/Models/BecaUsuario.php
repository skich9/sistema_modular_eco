<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BecaUsuario extends Model
{
    use HasFactory;

    protected $table = 'beca_usuario';

    protected $fillable = [
        'beca_id',
        'usuario_id',
        'inscripcion_id',
        'cuota_id',
        'monto',
        'porcentaje',
        'fecha_asignacion',
        'observaciones',
    ];

    // Relaciones
    public function beca(): BelongsTo
    {
        return $this->belongsTo(Beca::class);
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