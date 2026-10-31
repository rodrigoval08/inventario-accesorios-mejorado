@extends('layouts.app')

@section('title', 'Detalle del producto')

@section('content')
<header class="page-heading">
    <div>
        <h1 class="mb-1">Detalle del producto</h1>
        <p class="muted mb-0">Información registrada en el inventario.</p>
    </div>

    <a href="{{ route('productos.index') }}"
       class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</header>

<section class="panel">
    <div class="row g-4">
        <div class="col-md-4">
            @if($producto->imagen)
                <img src="{{ asset('storage/'.$producto->imagen) }}"
                     alt="{{ $producto->nombre }}"
                     class="img-fluid rounded"
                     style="max-height:280px;object-fit:contain">
            @else
                <div class="bg-light rounded p-5 text-center">
                    <i class="bi bi-box-seam display-1 text-primary"></i>
                </div>
            @endif
        </div>

        <div class="col-md-8">
            <span class="badge bg-primary mb-2">{{ $producto->sku }}</span>
            <h2 class="h3 fw-bold">{{ $producto->nombre }}</h2>
            <p class="muted">{{ $producto->descripcion ?: 'Sin descripción.' }}</p>

            <hr>

            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="muted small">Categoría</div>
                    <strong>{{ $producto->categoria }}</strong>
                </div>

                <div class="col-sm-6">
                    <div class="muted small">Proveedor</div>
                    <strong>{{ $producto->proveedor }}</strong>
                </div>

                <div class="col-sm-6">
                    <div class="muted small">Precio</div>
                    <strong>S/ {{ number_format((float) $producto->precio, 2) }}</strong>
                </div>

                <div class="col-sm-6">
                    <div class="muted small">Stock actual</div>
                    <strong>{{ $producto->stock }} unidades</strong>
                </div>

                <div class="col-sm-6">
                    <div class="muted small">Stock mínimo</div>
                    <strong>{{ $producto->stock_minimo }} unidades</strong>
                </div>

                <div class="col-sm-6">
                    <div class="muted small">Estado</div>
                    @if($producto->stock_bajo)
                        <span class="badge stock-low">Requiere reposición</span>
                    @else
                        <span class="badge stock-ok">Disponible</span>
                    @endif
                </div>
            </div>

            <a href="{{ route('productos.edit', $producto) }}"
               class="btn btn-primary mt-4">
                <i class="bi bi-pencil"></i> Editar producto
            </a>
        </div>
    </div>
</section>
@endsection