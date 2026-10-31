@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<header class="page-heading">
    <div>
        <h1 class="mb-1">Gestión de productos</h1>
        <p class="muted mb-0">Administra los accesorios informáticos del inventario.</p>
    </div>

    <a href="{{ route('productos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nuevo producto
    </a>
</header>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <strong>No se pudo completar la operación.</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<section class="row g-3 mb-4">
    <div class="col-6 col-xl-4">
        <div class="stat-card">
            <div class="muted small">Productos registrados</div>
            <div class="stat-number">{{ $totalProductos }}</div>
        </div>
    </div>

    <div class="col-6 col-xl-4">
        <div class="stat-card">
            <div class="muted small">Productos con stock bajo</div>
            <div class="stat-number text-danger">{{ $stockBajo }}</div>
        </div>
    </div>

    <div class="col-12 col-xl-4">
        <div class="stat-card">
            <div class="muted small">Valor del inventario</div>
            <div class="stat-number text-primary">
                S/ {{ number_format((float) $valorInventario, 2) }}
            </div>
        </div>
    </div>
</section>

<section class="panel">
    <form method="GET" action="{{ route('productos.index') }}"
          class="row g-2 align-items-end mb-4">

        <div class="col-12 col-lg-5">
            <label for="buscar" class="form-label">Buscar producto</label>
            <input type="text" id="buscar" name="buscar"
                   class="form-control"
                   placeholder="Nombre, SKU o proveedor..."
                   value="{{ $buscar }}">
        </div>

        <div class="col-12 col-md-4 col-lg-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select name="categoria" id="categoria" class="form-select">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $nombreCategoria)
                    <option value="{{ $nombreCategoria }}"
                        @selected($categoria === $nombreCategoria)>
                        {{ $nombreCategoria }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md-4 col-lg-2">
            <label for="estado" class="form-label">Stock</label>
            <select name="estado" id="estado" class="form-select">
                <option value="">Todos</option>
                <option value="bajo" @selected($estado === 'bajo')>
                    Stock bajo
                </option>
                <option value="disponible" @selected($estado === 'disponible')>
                    Disponible
                </option>
            </select>
        </div>

        <div class="col-6 col-md-2">
            <button class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>

        <div class="col-6 col-md-2">
            <a href="{{ route('productos.index') }}"
               class="btn btn-outline-secondary w-100">
                Limpiar
            </a>
        </div>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 fw-bold mb-0">Listado de productos</h2>
        <span class="muted small">{{ $productos->total() }} registros</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto / SKU</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($productos as $producto)
                    <tr>
                        <td>
                            @if($producto->imagen)
                                <img class="product-image"
                                     src="{{ asset('storage/'.$producto->imagen) }}"
                                     alt="{{ $producto->nombre }}">
                            @else
                                <div class="product-image d-grid place-items-center
                                            text-primary">
                                    <i class="bi bi-box-seam fs-4"></i>
                                </div>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('productos.show', $producto) }}"
                               class="fw-semibold text-decoration-none">
                                {{ $producto->nombre }}
                            </a>
                            <div class="muted small">{{ $producto->sku }}</div>
                        </td>

                        <td>{{ $producto->categoria }}</td>

                        <td class="fw-semibold">
                            S/ {{ number_format((float) $producto->precio, 2) }}
                        </td>

                        <td>
                            {{ $producto->stock }}
                            <span class="muted small">
                                / mín. {{ $producto->stock_minimo }}
                            </span>
                        </td>

                        <td>
                            @if($producto->stock_bajo)
                                <span class="badge stock-low">Stock bajo</span>
                            @else
                                <span class="badge stock-ok">Disponible</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('productos.show', $producto) }}"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('productos.edit', $producto) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('productos.destroy', $producto) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger"
                                            title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-secondary"></i>
                            <p class="fw-semibold mt-2 mb-1">No hay productos</p>
                            <p class="muted small">
                                Registra un producto o cambia los filtros de búsqueda.
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $productos->links('pagination::bootstrap-5') }}
    </div>
</section>
@endsection