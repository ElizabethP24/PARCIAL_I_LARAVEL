@extends('layout')

@section('title', 'Gestión de Categorías')

@section('content')
<div class="container py-4">

    <h2 class="mb-4 text-center">Gestión de Categorías de Computadores</h2>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Botón Crear --}}
    <div class="text-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal">
            <i class="bi bi-plus-circle"></i> Nueva Categoría
        </button>
    </div>

    {{-- Tabla de Categorías --}}
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Proveedor</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorias as $c)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $c->nombre }}</td>
                            <td>{{ $c->descripcion }}</td>
                            <td>{{ $c->proveedor }}</td>
                            <td>
                                @if ($c->estado)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#verCategoriaModal{{ $c->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editarCategoriaModal{{ $c->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarCategoriaModal{{ $c->id }}">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Modal Ver --}}
                        <div class="modal fade" id="verCategoriaModal{{ $c->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title">Detalles de Categoría</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <p><strong>Nombre:</strong> {{ $c->nombre }}</p>
                                        <p><strong>Descripción:</strong> {{ $c->descripcion }}</p>
                                        <p><strong>Proveedor:</strong> {{ $c->proveedor }}</p>
                                        <p><strong>Estado:</strong> {{ $c->estado ? 'Activo' : 'Inactivo' }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Editar --}}
                        <div class="modal fade" id="editarCategoriaModal{{ $c->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('categorias.update', $c->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title">Editar Categoría</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" name="nombre" class="form-control" value="{{ $c->nombre }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Descripción</label>
                                                <textarea name="descripcion" class="form-control" rows="2">{{ $c->descripcion }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Proveedor</label>
                                                <input type="text" name="proveedor" class="form-control" value="{{ $c->proveedor }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Estado</label>
                                                <select name="estado" class="form-select">
                                                    <option value="1" {{ $c->estado ? 'selected' : '' }}>Activo</option>
                                                    <option value="0" {{ !$c->estado ? 'selected' : '' }}>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-warning text-white">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Eliminar --}}
                        <div class="modal fade" id="eliminarCategoriaModal{{ $c->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('categorias.destroy', $c->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Eliminar Categoría</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Seguro que deseas eliminar la categoría <strong>{{ $c->nombre }}</strong>?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">No hay categorías registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Crear --}}
<div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Nueva Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Proveedor</label>
                        <input type="text" name="proveedor" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Tabs de Categorías --}}
<ul class="nav nav-tabs justify-content-center mb-4" id="categoriaTabs" role="tablist">
    @foreach ($categorias as $index => $categoria)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $categoria->id }}" data-bs-toggle="tab"
                data-bs-target="#contenido-{{ $categoria->id }}" type="button" role="tab"
                aria-controls="contenido-{{ $categoria->id }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                {{ $categoria->nombre }}
            </button>
        </li>
    @endforeach
</ul>

<div class="tab-content" id="categoriaTabsContent">
    @foreach ($categorias as $index => $categoria)
        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="contenido-{{ $categoria->id }}" role="tabpanel"
            aria-labelledby="tab-{{ $categoria->id }}">

            <div class="row row-cols-1 row-cols-md-4 g-4">
                @forelse ($categoria->computadores as $comp)
                    <div class="col">
                        <div class="card h-100 text-center">
                            <img src="{{ asset('storage/' . $comp->imagen) }}" class="card-img-top" alt="Imagen del computador">
                            <div class="card-body">
                                <h5 class="card-title">{{ $comp->nombre }}</h5>
                                <p class="card-text">{{ $comp->marca }} - {{ $comp->modelo }}</p>
                                <p class="fw-bold text-primary">${{ number_format($comp->precio, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">No hay computadores registrados en esta categoría.</p>
                @endforelse
            </div>
        </div>
    @endforeach
</div>


@endsection
