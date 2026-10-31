@extends('layouts.app')

@section('title', 'Editar categoría')

@section('content')

    <header class="topbar">
        <div>
            <h1>Editar categoría</h1>
            <div class="subtitle">Modifica los datos de «{{ $categoria->nombre }}»</div>
        </div>

        <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </header>

    <section class="panel">
        <form action="{{ route('categorias.update', $categoria) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label fw-semibold">
                        Nombre de la categoría <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre', $categoria->nombre) }}"
                            maxlength="100"
                            placeholder="Ej: Laptops"
                            class="form-control @error('nombre') is-invalid @enderror"
                            required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                    <textarea id="descripcion"
                                name="descripcion"
                                rows="3"
                                maxlength="255"
                                placeholder="Describe brevemente la categoría..."
                                class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Actualizar
                </button>
                <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </section>

@endsection