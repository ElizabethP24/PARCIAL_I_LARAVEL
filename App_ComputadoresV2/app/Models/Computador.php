<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Computador extends Model
{
    use HasFactory;

    protected $table = 'computadores';
    protected $fillable = [
        'nombre',
        'marca',
        'modelo',
        'procesador',
        'ram_gb',
        'almacenamiento_gb',
        'cantidad',
        'precio',
        'imagen',
        'portatil',
        'categoria_id',
        'codigo_barras',
    ];

    public function getImagenUrlAttribute()
    {
        return $this->imagen
            ? asset('storage/' . $this->imagen)
            : asset('images/no-image.png');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }

}
