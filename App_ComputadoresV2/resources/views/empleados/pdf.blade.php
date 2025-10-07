<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Empleados</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Reporte de Empleados</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Departamento</th>
                <th>Salario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $e)
            <tr>
                <td>{{ $e->nombre }}</td>
                <td>{{ $e->documento }}</td>
                <td>{{ $e->departamento }}</td>
                <td>${{ number_format($e->salario, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
