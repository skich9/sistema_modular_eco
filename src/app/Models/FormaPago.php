<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormaPago extends Model
{
    use HasFactory;

    protected $table = 'formas_pago';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    // Relaciones
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'forma_pago_id');
    }
}