    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Ventas</title>
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { border: 1px solid #444; padding: 6px; text-align: left; }
            th { background: #f2f2f2; }
        </style>
    </head>
    <body>
        <h2>Reporte de Ventas</h2>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
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
                    <td>{{ $v->cliente }}</td>
                    <td>{{ $v->computador }}</td>
                    <td>{{ $v->cantidad }}</td>
                    <td>${{ number_format($v->precio, 0, ',', '.') }}</td>
                    <td>${{ number_format($v->cantidad * $v->precio, 0, ',', '.') }}</td>
                    <td>{{ $v->fecha }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
    </html>
