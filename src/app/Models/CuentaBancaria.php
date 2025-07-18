<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CuentaBancaria extends Model
{
    use HasFactory;

    protected $table = 'cuentas_bancarias';

    protected $fillable = [
        'banco',
        'numero_cuenta',
        'tipo_cuenta',
        'titular',
        'estado',
    ];

    // Relaciones
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'cuenta_bancaria_id');
    }
} 