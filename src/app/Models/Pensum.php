<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pensum extends Model
{
    use HasFactory;

    protected $table = 'pensums';

    protected $fillable = [
        'nombre',
        'codigo',
        'codigo_carrera',
        'estado',
    ];

    // Relaciones
    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class);
    }
}