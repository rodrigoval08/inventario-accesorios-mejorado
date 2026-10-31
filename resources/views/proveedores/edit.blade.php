@extends('layouts.app')

@section('title', 'Editar proveedor')

@section('content')

    <header class="topbar">
        <div>
            <h1>Editar proveedor</h1>
            <div class="subtitle">Modifica los datos de «{{ $proveedor->nombre }}»</div>
        </div>

        <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </header>

    <section class="panel">
        <form action="{{ route('proveedores.update', $proveedor) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label fw-semibold">
                        Nombre del proveedor <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="nombre"
                           name="nombre"
                           value="{{ old('nombre', $proveedor->nombre) }}"
                           maxlength="100"
                           placeholder="Ej: Logitech"
                           class="form-control @error('nombre') is-invalid @enderror"
                           required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email', $proveedor->email) }}"
                           maxlength="100"
                           placeholder="ventas@proveedor.com"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                    <input type="text"
                           id="telefono"
                           name="telefono"
                           value="{{ old('telefono', $proveedor->telefono) }}"
                           maxlength="20"
                           placeholder="987654321"
                           class="form-control @error('telefono') is-invalid @enderror">
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="direccion" class="form-label fw-semibold">Dirección</label>
                    <input type="text"
                           id="direccion"
                           name="direccion"
                           value="{{ old('direccion', $proveedor->direccion) }}"
                           maxlength="255"
                           placeholder="Av. Principal 123"
                           class="form-control @error('direccion') is-invalid @enderror">
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Actualizar
                </button>
                <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </section>

@endsection