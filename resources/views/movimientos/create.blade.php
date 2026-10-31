@extends('layouts.app')

@section('title', 'Registrar movimiento')

@section('content')

    <header class="topbar">
        <div>
            <h1>Registrar movimiento</h1>
            <div class="subtitle">Registra una entrada o salida de stock</div>
        </div>

        <a href="{{ route('movimientos.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </header>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle-fill me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <section class="panel">
        <form action="{{ route('movimientos.store') }}" method="POST" novalidate>
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="producto_id" class="form-label fw-semibold">
                        Producto <span class="text-danger">*</span>
                    </label>
                    <select id="producto_id"
                            name="producto_id"
                            class="form-select @error('producto_id') is-invalid @enderror"
                            required>
                        <option value="">Selecciona un producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}"
                                {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                {{ $producto->nombre }} (stock: {{ $producto->stock }})
                            </option>
                        @endforeach
                    </select>
                    @error('producto_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="tipo" class="form-label fw-semibold">
                        Tipo <span class="text-danger">*</span>
                    </label>
                    <select id="tipo"
                            name="tipo"
                            class="form-select @error('tipo') is-invalid @enderror"
                            required>
                        <option value="entrada" {{ old('tipo', 'entrada') === 'entrada' ? 'selected' : '' }}>
                            Entrada
                        </option>
                        <option value="salida" {{ old('tipo') === 'salida' ? 'selected' : '' }}>
                            Salida
                        </option>
                    </select>
                    @error('tipo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="cantidad" class="form-label fw-semibold">
                        Cantidad <span class="text-danger">*</span>
                    </label>
                    <input type="number"
                           id="cantidad"
                           name="cantidad"
                           value="{{ old('cantidad') }}"
                           min="1"
                           placeholder="0"
                           class="form-control @error('cantidad') is-invalid @enderror"
                           required>
                    @error('cantidad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="proveedor_id" class="form-label fw-semibold">Proveedor</label>
                    <select id="proveedor_id"
                            name="proveedor_id"
                            class="form-select @error('proveedor_id') is-invalid @enderror">
                        <option value="">Sin proveedor / el habitual del producto</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}"
                                {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                {{ $proveedor->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Solo se usa en las entradas.</div>
                    @error('proveedor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="motivo" class="form-label fw-semibold">Motivo</label>
                    <input type="text"
                           id="motivo"
                           name="motivo"
                           value="{{ old('motivo') }}"
                           maxlength="255"
                           placeholder="Ej: Compra a proveedor, Venta, Merma..."
                           class="form-control @error('motivo') is-invalid @enderror">
                    @error('motivo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Guardar
                </button>
                <a href="{{ route('movimientos.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </section>

@endsection