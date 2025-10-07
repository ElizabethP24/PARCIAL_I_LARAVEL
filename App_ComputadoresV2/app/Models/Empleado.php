<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

class Empleado extends Model
{
    protected $fillable = ['nombre','documento', 'salario', 'departamento'];

    //Calcular salario neto en Colombia (ejemplo simple: aplica salud 4%, pension 4%, retención 10% si aplica)
    public static function salarioNeto(float $salarioBruto): array {
        $salud = $salarioBruto * 0.04;
        $pension = $salarioBruto * 0.04;
        $retencion = ($salarioBruto > 3000000) ? $salarioBruto * 0.10 : 0;
        $neto = $salarioBruto - ($salud + $pension + $retencion);
        return [
            'salario_bruto' => $salarioBruto,
            'salud' => $salud,
            'pension' => $pension,
            'retencion' => $retencion,
            'salario_neto' => $neto
        ];
    }
}
