<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

class Venta extends Model
{
        protected $primaryKey = 'codigo';
        public $incrementing = true;
        protected $keyType = 'int';
        protected $fillable = ['codigo','documento_cliente','nombre_cliente','computador','cantidad','precio','fecha'];

        public function total(): float {
            return $this->cantidad * $this->precio;
        }

        // Interés compuesto aplicado a una venta
        public static function montoConInteres(float $monto, float $tasa, int $periodos): float {
            return $monto * pow(1 + $tasa, $periodos);
        }

    public function computadorRel()
    {
        return $this->belongsTo(Computador::class, 'computador');
    }
}

