<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'usuario_id',
        'accion',
        'tabla',
        'registro_id',
        'descripcion',
        'fecha',
    ];

    // Relaciones
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }
}