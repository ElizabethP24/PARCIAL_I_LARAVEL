@extends('layout')

@section('title', 'Gestión de Computadores')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Encabezado -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tienda de Computadores</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearComputadorModal">
                <i class="fas fa-plus"></i> Crear Computador
            </button>
        </div>
    <!-- Cards de computadores -->
    <div class="row justify-content-center">
        @foreach($computadores as $c)
            <div class="col-md-3 mb-4">
                <div class="card shadow h-100">
                    <img src="{{ $c->imagen_url }}" class="card-img-top mx-auto d-block" alt="{{ $c->nombre }}" style="height:180px;width:200px;object-fit:cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $c->nombre }}</h5>
                        <p class="mb-1"><small class="text-muted">{{ $c->marca }} {{ $c->modelo }}</small></p>
                        <p class="text-success fw-bold">${{ number_format($c->precio, 0, ',', '.') }}</p>
                        <p class="text-muted">Stock: {{ $c->cantidad }}</p>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#verComputadorModal{{ $c->id }}">
                            <i class="fas fa-eye"></i> Ver ahora
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

        <!-- Tabla -->
        <div id="listaComputadores" class="card shadow mt-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Listado de Computadores</h6>
                <a href="{{ route('computadores.exportar') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-file-pdf"></i> Exportar
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Imagen</th>
                                <th>Portatil</th>
                                <th>Categoría</th>
                                <th>Código de Barras</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($computadores as $c)
                                <tr>
                                    <td>{{ $c->id }}</td>
                                    <td>{{ $c->nombre }}</td>
                                    <td>${{ number_format($c->precio, 0, ',', '.') }}</td>
                                    <td>{{ $c->cantidad }}</td>
                                    <td><img src="{{ $c->imagen_url }}" width="50" height="50" style="object-fit:cover;"></td>
                                    <td>{{ $c->portatil ? 'Sí' : 'No' }}</td>
                                    <td>{{ $c->categoria->nombre ?? 'Sin categoría' }}</td>
                                    <td>{{ $c->codigo_barras }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarComputadorModal{{ $c->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarComputadorModal{{ $c->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Crear--}}
<div class="modal fade" id="crearComputadorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ url('/computadores/store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Computador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-2">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Marca</label>
                    <input type="text" name="marca" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">Modelo</label>
                    <input type="text" name="modelo" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">Procesador</label>
                    <input type="text" name="procesador" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">RAM (GB)</label>
                    <input type="number" name="ram_gb" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Almacenamiento (GB)</label>
                    <input type="number" name="almacenamiento_gb" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">¿Es portátil?</label>
                    <select name="portatil" class="form-control" required>
                        <option value="1" selected>Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-control" required>
                        <option value="">-- Seleccione --</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Código de Barras</label>
                    <input type="text" name="codigo_barras" class="form-control" value="{{ old('codigo_barras') }}">
                </div>
                <div class="mb-2">
                    <label class="form-label">Imagen</label>
                    <input type="file" name="imagen" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Ver --}}
@foreach($computadores as $c)
    <div class="modal fade" id="verComputadorModal{{ $c->id }}" tabindex="-1" aria-labelledby="verComputadorLabel{{ $c->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="verComputadorLabel{{ $c->id }}">Detalles del Computador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="{{ $c->imagen_url }}" alt="{{ $c->nombre }}" class="img-fluid rounded mb-3">
                        </div>
                        <div class="col-md-8">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>ID:</strong> {{ $c->id }}</li>
                                <li class="list-group-item"><strong>Nombre:</strong> {{ $c->nombre }}</li>
                                <li class="list-group-item"><strong>Marca:</strong> {{ $c->marca }}</li>
                                <li class="list-group-item"><strong>Modelo:</strong> {{ $c->modelo }}</li>
                                <li class="list-group-item"><strong>Procesador:</strong> {{ $c->procesador }}</li>
                                <li class="list-group-item"><strong>RAM (GB):</strong> {{ $c->ram_gb }}</li>
                                <li class="list-group-item"><strong>Almacenamiento (GB):</strong> {{ $c->almacenamiento_gb }}</li>
                                <li class="list-group-item"><strong>Cantidad:</strong> {{ $c->cantidad }}</li>
                                <li class="list-group-item"><strong>Portátil:</strong> {{ $c->portatil ? 'Sí' : 'No' }}</li>
                                <li class="list-group-item"><strong>Categoría:</strong> {{ $c->categoria->nombre ?? 'Sin categoría' }}</li>
                                <li class="list-group-item"><strong>Código de Barras:</strong> {{ $c->codigo_barras }}</li>
                                <li class="list-group-item"><strong>Precio:</strong> ${{ number_format($c->precio, 0, ',', '.') }}</li>
                                <li class="list-group-item"><strong>Creado:</strong> {{ $c->created_at }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Modal Editar y Eliminar --}}
@foreach($computadores as $c)
    {{-- Editar --}}
    <div class="modal fade" id="editarComputadorModal{{ $c->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ url('/computadores/'.$c->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Computador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" value="{{ $c->nombre }}" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Marca</label>
                        <input type="text" name="marca" value="{{ $c->marca }}" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Modelo</label>
                        <input type="text" name="modelo" value="{{ $c->modelo }}" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Procesador</label>
                        <input type="text" name="procesador" value="{{ $c->procesador }}" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">RAM (GB)</label>
                        <input type="number" name="ram_gb" value="{{ $c->ram_gb }}" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Almacenamiento (GB)</label>
                        <input type="number" name="almacenamiento_gb" value="{{ $c->almacenamiento_gb }}" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" value="{{ $c->cantidad }}" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" name="precio" value="{{ $c->precio }}" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Categoría</label>
                        <select name="categoria_id" class="form-control" required>
                            <option value="">-- Seleccione --</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ (old('categoria_id', $c->categoria_id) == $categoria->id) ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Código de Barras</label>
                        <input type="text" name="codigo_barras" value="{{ $c->codigo_barras }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="portatil_{{ $c->id }}">¿Es portátil?</label>
                        <select name="portatil" id="portatil_{{ $c->id }}" class="form-control" required>
                            <option value="1" {{ old('portatil', $c->portatil) == 1 ? 'selected' : '' }}>Sí</option>
                            <option value="0" {{ old('portatil', $c->portatil) == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Imagen (opcional)</label>
                        <input type="file" name="imagen" class="form-control">
                        <div class="mt-2">
                            <img src="{{ $c->imagen_url }}" alt="{{ $c->nombre }}" width="120">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Eliminar --}}
    <div class="modal fade" id="eliminarComputadorModal{{ $c->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ url('/computadores/'.$c->id) }}" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Computador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Seguro que deseas eliminar <strong>{{ $c->nombre }}</strong>?
                    <p class="text-danger small mt-2">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

@endsection

