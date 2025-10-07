@extends('layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2" style="min-height: 450px;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ventas por computadores</h6>
                </div>
                <div class="card-body">
                    {!! $chartVentasComputador->renderHtml() !!}
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2" style="min-height: 450px;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Ventas por Mes</h6>
                </div>
                <div class="card-body">
                    {!! $chartVentasMes->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2" style="min-height: 450px;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Empleados por Departamento</h6>
                </div>
                <div class="card-body">
                    {!! $chartEmpleadosDepto->renderHtml() !!}
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2" style="min-height: 450px;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Promedio Salario por Departamento</h6>
                </div>
                <div class="card-body">
                    {!! $chartSalarioDepto->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    {!! $chartVentasComputador->renderChartJsLibrary() !!}
    {!! $chartVentasComputador->renderJs() !!}
    {!! $chartVentasMes->renderJs() !!}
    {!! $chartEmpleadosDepto->renderJs() !!}
    {!! $chartSalarioDepto->renderJs() !!}
@endsection
