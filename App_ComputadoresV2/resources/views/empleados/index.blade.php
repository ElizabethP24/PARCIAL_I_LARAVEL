@extends('layout')

@section('title', 'Gestión de Empleados')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Empleados</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearEmpleadoModal">
        <i class="fas fa-user-plus fa-sm text-white-50"></i> Crear Empleado
    </button>
</div>

<!-- Row de métricas -->
<div class="row">

    <!-- Promedio salario por departamento -->
    <div class="col-xl-6 col-md-12 mb-4">
        <div class="card shadow h-100 p-3">
            <h5 class="text-primary mb-3">
                <i class="fas fa-coins"></i> Promedio salario por departamento
            </h5>
            @foreach($porDepto as $d => $avg)
                <div class="d-flex justify-content-between border-bottom py-1">
                    <span>{{ $d }}</span>
                    <span class="font-weight-bold">${{ number_format($avg, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Departamento con promedio más alto -->
    <div class="col-xl-6 col-md-12 mb-4">
        <div class="card shadow h-100 p-3">
            <h5 class="text-success mb-3">
                <i class="fas fa-building"></i> Departamento con promedio más alto
            </h5>
            <strong class="h5">
                {{ $deptMayor }}:
                ${{ number_format($porDepto[$deptMayor] ?? 0, 0, ',', '.') }}
            </strong>
        </div>
    </div>
</div>

    <div class="row">
        <!-- Top 5 empleados por encima del promedio -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow h-100 p-3">
                <h5 class="text-info mb-3">
                    <i class="fas fa-chart-line"></i> Top 5 empleados por encima del promedio
                </h5>

                @php
                    $top5 = collect($encimaPromedio)->sortByDesc('salario')->take(5);
                @endphp

                @if($top5->isEmpty())
                    <p class="text-muted">Ninguno</p>
                @else
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Departamento</th>
                                <th>Salario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($top5 as $emp)
                                <tr>
                                    <td>{{ $emp->nombre }}</td>
                                    <td>{{ $emp->documento }}</td>
                                    <td>{{ $emp->departamento }}</td>
                                    <td>${{ number_format($emp->salario, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
</div>

<!-- Tabla + Chart -->
<div class="row">
    <!-- Tabla -->
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Listado de empleados</h6>
                <a href="{{ route('empleados.exportar') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-file-pdf"></i> Exportar
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Salario</th>
                                <th>Departamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empleados as $e)
                                <tr>
                                    <td>{{ $e->nombre }}</td>
                                    <td>{{ $e->documento }}</td>
                                    <td>${{ number_format($e->salario, 0, ',', '.') }}</td>
                                    <td>{{ $e->departamento }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Empleados por departamento</h6>
            </div>
            <div class="card-body">
                {!! $empleadosChart->renderHtml() !!}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="crearEmpleadoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('empleados.create') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Documento</label>
                    <input type="number" name="documento" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Departamento</label>
                    <select name="departamento" class="form-select" required>
                        <option value="Ventas">Ventas</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Tecnología">Tecnología</option>
                        <option value="Talento Humano">Talento Humano</option>
                        <option value="Finanzas">Finanzas</option>
                        <option value="Atención al Cliente">Atención al Cliente</option>
                        <option value="Operaciones">Operaciones</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Salario</label>
                    <input type="number" name="salario" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('javascript')
    {!! $empleadosChart->renderChartJsLibrary() !!}
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
    {!! $empleadosChart->renderJs() !!}
@endsection
