    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Computadores</title>
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { border: 1px solid #444; padding: 6px; text-align: left; }
            th { background: #f2f2f2; }
            img { max-width: 80px; max-height: 60px; object-fit: cover; }
        </style>
    </head>
    <body>
        <h2>Reporte de Computadores</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Procesador</th>
                    <th>RAM (GB)</th>
                    <th>Almacenamiento (GB)</th>
                    <th>Portátil</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Categoría</th>
                    <th>Código de Barras</th>
                    <th>Imagen</th>
                    <th>Creado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($computadores as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ $c->marca }}</td>
                    <td>{{ $c->modelo }}</td>
                    <td>{{ $c->procesador }}</td>
                    <td>{{ $c->ram_gb }}</td>
                    <td>{{ $c->almacenamiento_gb }}</td>
                    <td>{{ $c->portatil ? 'Sí' : 'No' }}</td>
                    <td>${{ number_format($c->precio, 0, ',', '.') }}</td>
                    <td>{{ $c->cantidad }}</td>
                    <td>{{ $c->categoria->nombre ?? 'Sin categoría' }}</td>
                    <td>{{ $c->codigo_barras }}</td>
                    <td>
                        @if($c->imagen)
                            <img src="{{ asset('storage/' . $c->imagen) }}" alt="{{ $c->nombre }}">
                        @else
                            <img src="{{ asset('images/default-computer.png') }}" alt="{{ $c->nombre }}">
                        @endif
                    </td>
                    <td>{{ $c->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
    </html>
