@extends('layout')

@section('title', 'Gestión de Ventas')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ventas</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearVentaModal">
        <i class="fas fa-cart-plus fa-sm text-white-50"></i> Crear Venta
    </button>
</div>

<!-- Row de métricas -->
<div class="row">

    <!-- Total ventas -->
    <div class="col-xl-6 col-md-12 mb-4">
        <div class="card shadow h-100 p-3">
            <h5 class="text-primary mb-3">
                <i class="fas fa-boxes"></i> Total ventas (unidades)
            </h5>
            <strong class="h4">{{ number_format($total_unidades, 0, ',', '.') }}</strong>
        </div>
    </div>

    <!-- Total vendido -->
    <div class="col-xl-6 col-md-12 mb-4">
        <div class="card shadow h-100 p-3">
            <h5 class="text-success mb-3">
                <i class="fas fa-dollar-sign"></i> Total vendido
            </h5>
            <strong class="h4">${{ number_format($total_vendido ?? 0, 0, ',', '.') }}</strong>
        </div>
    </div>
</div>

<div class="row">

    <!-- Computador más vendido -->
    <div class="col-xl-6 col-md-12 mb-4">
        <div class="card shadow h-100 p-3 bg-light">
            <h5 class="text-info mb-3">
                <i class="fas fa-star"></i> Computador más vendido
            </h5>
            <strong class="h5">{{ $computadorTop ?? 'Ninguno' }}</strong>
        </div>
    </div>

    <!-- Clientes que más han gastado -->
    <div class="col-xl-6 col-md-12 mb-4">
        <div class="card shadow h-100 p-3">
            <h5 class="text-warning mb-3">
                <i class="fas fa-users"></i> Clientes que más han gastado
            </h5>
            @if(empty($clientesTop) || count($clientesTop) === 0)
                <p class="text-muted">Ninguno</p>
            @else
                <ul class="list-unstyled">
                    @foreach($clientesTop as $c => $total)
                        <li><i class="fas fa-user"></i> {{ $c }} - ${{ number_format($total, 0, ',', '.') }}</li>
                    @endforeach
                </ul>
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
                <h6 class="m-0 font-weight-bold text-primary">Listado de ventas</h6>
                <a href="{{ route('ventas.exportar') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-file-pdf"></i> Exportar
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Código</th>
                                <th>Documento Cliente</th>
                                <th>Nombre Cliente</th>
                                <th>Computador</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Total</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventas as $v)
                                <tr>
                                    <td>{{ $v->codigo }}</td>
                                    <td>{{ $v->documento_cliente }}</td>
                                    <td>{{ $v->nombre_cliente }}</td>
                                    <td>{{ $v->computadorRel->nombre ?? 'Computador eliminado' }}</td>
                                    <td>{{ $v->cantidad }}</td>
                                    <td>${{ number_format($v->precio, 0, ',', '.') }}</td>
                                    <td>${{ number_format($v->cantidad * $v->precio, 0, ',', '.') }}</td>
                                    <td>{{ $v->fecha }}</td>
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
                <h6 class="m-0 font-weight-bold text-primary">Ventas por computador</h6>
            </div>
            <div class="card-body">
                {!! $chart->renderHtml() !!}
            </div>
        </div>
    </div>
</div>

<!-- Modal crear venta -->
<div class="modal fade" id="crearVentaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('ventas.create') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Nueva Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Documento Cliente</label>
                    <input type="number" name="documento_cliente" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre Cliente</label>
                    <input type="text" name="nombre_cliente" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Código Computador</label>
                    <input type="number" name="computador" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio Unitario</label>
                    <input name="precio" type="number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <input name="fecha" type="date" class="form-control" required>
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
    {!! $chart->renderChartJsLibrary() !!}
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
    {!! $chart->renderJs() !!}
@endsection
