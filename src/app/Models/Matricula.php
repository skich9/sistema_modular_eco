<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Matricula extends Model
{
    use HasFactory;

    protected $table = 'matriculas';

    protected $fillable = [
        'usuario_id',
        'inscripcion_id',
        'cod_ceta',
        'cod_inscrip',
        'cod_pensum',
        'gestion',
        'kardex_economico',
        'num_pago_matri',
        'costo',
        'descuento',
        'matriculatotal',
        'pago_completo',
        'num_factura',
        'num_comprobante',
        'fecha_pago',
        'razon',
        'nit',
        'autorizacion',
        'valido',
        'concepto',
        'codigo_control',
        'code_tipo_pago',
        'nro_cuenta',
        'nro_deposito',
        'fecha_deposito',
        'nro_nota',
        'observaciones',
    ];

    // Relaciones
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(Inscripcion::class);
    }
}