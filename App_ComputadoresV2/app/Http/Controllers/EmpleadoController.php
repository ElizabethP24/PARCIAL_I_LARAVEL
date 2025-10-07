<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;


class EmpleadoController extends Controller
{
    public function index()
        {
            $empleados = Empleado::all();
            $porDepto = $this->promedioPorDepartamento($empleados);
            $deptMayor = $this->departamentoMayorPromedio($porDepto);
            $encimaPromedio = $this->empleadosEncimaPromedio($empleados, $porDepto);

            $empleadosPorDepto = [];
            foreach ($empleados as $e) {
                $empleadosPorDepto[$e->departamento] = ($empleadosPorDepto[$e->departamento] ?? 0) + 1;
            }
            $empleadosPorDeptoChartOptions = [
                'chart_title'        => 'Empleados por Departamento',
                'chart_type'         => 'bar',
                'report_type'        => 'group_by_string',
                'model'              => 'App\Models\Empleado',
                'group_by_field'     => 'departamento',
                'aggregate_function' => 'count',
                'aggregate_field'    => 'id',
                'chart_options' => [
                    'chart' => [
                        'height' => 300,
                        'width'  => 400,
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

            $empleadosChart = new LaravelChart($empleadosPorDeptoChartOptions);

            return view('empleados.index', compact('empleados', 'porDepto', 'deptMayor', 'encimaPromedio', 'empleadosPorDepto', 'empleadosChart'));
        }

        public function create(Request $request)
        {
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'documento' => 'required|numeric|digits:10|unique:empleados',
                'salario' => 'required|numeric|min:0',
                'departamento' => 'required|string|max:100',
            ]);
            Empleado::create($validated);
            return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente');
        }

        // a) Promedio de salarios por departamento
        private function promedioPorDepartamento($empleados): array
        {
            $sum = []; $count = [];
            foreach ($empleados as $e) {
                $d = $e->departamento;
                $sum[$d] = ($sum[$d] ?? 0) + $e->salario;
                $count[$d] = ($count[$d] ?? 0) + 1;
            }
            $res = [];
            foreach ($sum as $d => $s) {
                $res[$d] = $s / $count[$d];
            }
            return $res;
        }

        // b) departamento con salario promedio más alto
        private function departamentoMayorPromedio(array $porDepto): ?string
        {
            if (empty($porDepto)) {
                return null;
            }
            arsort($porDepto);
            $keys = array_keys($porDepto);
            return $keys[0];
        }

        // c) empleados que ganan por encima del promedio de su departamento
        private function empleadosEncimaPromedio($empleados, array $porDepto): array
        {
            $out = [];
            foreach ($empleados as $e) {
                if ($e->salario > ($porDepto[$e->departamento] ?? 0)) {
                    $out[] = $e;
                    if (count($out) >= 5) {
                        break;
                    }
                }
            }
            return $out;
        }
        // Exportar a PDF
        public function exportarPdf()
        {
            $empleados = Empleado::all();
            $options = new Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $html = view('empleados.pdf', compact('empleados'))->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents(public_path('documents/empleados.pdf'), $output);
            return response()->download(public_path('documents/empleados.pdf'));
        }
}
