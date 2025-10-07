<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{

    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'proveedor',
        'estado',
    ];

    public function computadores()
    {
        return $this->hasMany(Computador::class, 'categoria_id', 'id');
    }
}
