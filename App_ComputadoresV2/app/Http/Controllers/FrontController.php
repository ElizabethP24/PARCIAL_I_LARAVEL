<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;


class FrontController extends Controller
{
    public function index()
    {
        $empleadosPorDepto = [
            'chart_title'        => 'Empleados por Departamento',
            'chart_type'         => 'bar',
            'report_type'        => 'group_by_string',
            'model'              => 'App\Models\Empleado',
            'group_by_field'     => 'departamento',
            'aggregate_function' => 'count',
        ];

        $salarioDepto = [
            'chart_title'        => 'Promedio Salario por Departamento',
            'chart_type'         => 'line',
            'report_type'        => 'group_by_string',
            'model'              => 'App\Models\Empleado',
            'group_by_field'     => 'departamento',
            'aggregate_function' => 'avg',
            'aggregate_field'    => 'salario',
        ];

        $ventasPorComputador = [
            'chart_title'        => 'Ventas por Computador',
            'chart_type'         => 'line',
            'report_type'        => 'group_by_string',
            'model'              => 'App\Models\Venta',
            'group_by_field'     => 'computador',
            'aggregate_function' => 'sum',
            'aggregate_field'    => 'cantidad',
        ];

        $ventasPorMes = [
            'chart_title'        => 'Ventas por Mes',
            'chart_type'         => 'bar',
            'report_type'        => 'group_by_string',
            'model'              => 'App\Models\Venta',
            'group_by_field'     => 'fecha',
            'aggregate_function' => 'sum',
            'aggregate_field'    => 'cantidad',
        ];

        $chartEmpleadosDepto = new LaravelChart($empleadosPorDepto);
        $chartSalarioDepto = new LaravelChart($salarioDepto);
        $chartVentasComputador = new LaravelChart($ventasPorComputador);
        $chartVentasMes = new LaravelChart($ventasPorMes);

        return view('dashboard', compact(
            'chartEmpleadosDepto',
            'chartSalarioDepto',
            'chartVentasComputador',
            'chartVentasMes'
        ));
    }
}
