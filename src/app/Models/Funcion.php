<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcion extends Model
{
    use HasFactory;

    protected $table = 'funciones'; // Asegúrate que coincida con tu tabla
    protected $primaryKey = 'id_funcion';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];
    
    // Opcional: Para evitar pluralización automática
    public function getTable()
    {
        return 'funciones';
    }
}
