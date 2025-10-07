<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class VentaController extends Controller
{
    public function index()
    {
        // Todas las ventas
        $ventas = Venta::with('computadorRel')->orderByDesc('codigo')->get();

        $ventas = Venta::select('ventas.*', DB::raw('(SELECT nombre FROM computadores WHERE computadores.id = ventas.computador) as computador_nombre'))
        ->orderByDesc('codigo')
        ->get();

        // 1) Total unidades vendidas (SUM cantidad)
        $total_unidades = (int) Venta::select(DB::raw('COALESCE(SUM(cantidad),0) as total_unidades'))
            ->value('total_unidades');

        // 2) Total en dinero vendido (SUM cantidad * precio)
        $total_vendido = (float) Venta::select(DB::raw('COALESCE(SUM(cantidad * precio),0) as total'))
            ->value('total');

        // 3) Computador más vendido (por unidades) y su cantidad
        $computadorRow = Venta::select('computador', DB::raw('SUM(cantidad) as total_cantidad'))
            ->groupBy('computador')
            ->orderByDesc('total_cantidad')
            ->first();
        $computadorTop = $computadorRow ? \App\Models\Computador::find($computadorRow->computador)->nombre : null;
        $computadorTopCantidad = $computadorRow ? (int) $computadorRow->total_cantidad : 0;

        // 4) Cliente que más gastó (monto total)
        $clientesTop = Venta::select('nombre_cliente', DB::raw('SUM(cantidad * precio) as total_gastado'))
        ->groupBy('nombre_cliente')
        ->orderByDesc('total_gastado')
        ->take(5)
        ->pluck('total_gastado', 'nombre_cliente');


        // Gráfico: Total vendido por computador (pastel)
        $ventasPorComputador = $ventas->groupBy(function($v) {
            return $v->computadorRel->nombre ?? 'Computador eliminado';
        })->map(function($group) {
            return $group->sum('cantidad');
        })->toArray();
        $chart_options = [
        'chart_title'        => 'Total Vendido por Computador',
        'chart_type'         => 'pie',
        'report_type'        => 'group_by_string',
        'model'              => 'App\Models\Venta',
        'group_by_field'     => 'computador',
        'aggregate_function' => 'sum',
        'aggregate_field'    => 'cantidad',
        'filter_field'       => 'fecha',
        'filter_days'        => 365,

        'chart_options' => [
            'chart' => [
                'height' => 300,
                'width'  => 300,
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                    'labels' => [
                        'font' => [
                            'size' => 12,
                            'weight' => 'bold',
                        ],
                        'color' => '#000',
                    ]
                ],
                'datalabels' => [
                    'color' => '#000',
                    'anchor' => 'center',
                    'align'  => 'center',
                    'font'   => [
                        'weight' => 'bold',
                        'size'   => 12,
                    ],
                    'formatter' => 'function(value, context) {
                        let label = context.chart.data.labels[context.dataIndex];
                        return label + ": " + value + " uds";
                    }'
                ]
            ]
        ]
    ];

    $chart = new LaravelChart($chart_options);
        return view('ventas.index', compact(
            'ventas',
            'total_unidades',
            'total_vendido',
            'computadorTop',
            'computadorTopCantidad',
            'clientesTop',
            'chart'
        ));
    }

    //Guardar nueva venta.
    public function create(Request $request)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'documento_cliente' => 'required|integer',
            'computador' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0.01',
            'fecha' => 'required|date',
        ]);
        Venta::create($request->only(['nombre_cliente','documento_cliente','computador','cantidad','precio','fecha']));
        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    // Exportar ventas a PDF
    public function exportarPdf()
    {
        $ventas = Venta::all();
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $html = view('ventas.pdf', compact('ventas'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents(public_path('documents/ventas.pdf'), $output);
        return response()->download(public_path('documents/ventas.pdf'));
    }
}
