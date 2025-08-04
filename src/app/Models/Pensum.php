<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pensum extends Model
{
    use HasFactory;
    
    protected $table = 'pensums';
    protected $primaryKey = 'cod_pensum';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'cod_pensum',
        'nombre',
        'descripcion',
        'estado'
    ];
    
    // Relaciones
    public function materias()
    {
        return $this->hasMany(Materia::class, 'cod_pensum', 'cod_pensum');
    }
    
    public function costosemestrales()
    {
        return $this->hasMany(CostoSemestral::class, 'cod_pensum', 'cod_pensum');
    }
}
