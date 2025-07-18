<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Egreso extends Model
{
    use HasFactory;

    protected $table = 'egresos';

    protected $fillable = [
        'usuario_id',
        'cod_ceta',
        'monto',
        'fecha_egreso',
        'tipo',
        'descripcion',
        'num_factura',
        'num_comprobante',
        'fecha_factura',
        'fecha_recibo',
        'autorizacion',
        'estado',
        'observaciones',
    ];

    // Relaciones
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }
} 