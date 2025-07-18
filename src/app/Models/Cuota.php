<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuota extends Model
{
    use HasFactory;

    protected $table = 'cuotas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'monto',
        'fecha_vencimiento',
        'estado',
        'tipo',
    ];

    // Relaciones
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }
}