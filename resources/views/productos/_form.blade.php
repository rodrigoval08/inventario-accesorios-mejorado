@php
    $producto = $producto ?? null;

    $categoriaActual = old('categoria', $producto?->categoria);
    $proveedorActual = old('proveedor', $producto?->proveedor);
@endphp

<div class="row g-3">
    <div class="col-md-8">
        <label for="nombre" class="form-label">Nombre del producto *</label>
        <input type="text" id="nombre" name="nombre"
               class="form-control @error('nombre') is-invalid @enderror"
               value="{{ old('nombre', $producto?->nombre) }}"
               maxlength="150" required>
        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="sku" class="form-label">Código SKU *</label>
        <input type="text" id="sku" name="sku"
               class="form-control @error('sku') is-invalid @enderror"
               value="{{ old('sku', $producto?->sku) }}"
               maxlength="50" required>
        @error('sku')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="categoria" class="form-label">Categoría *</label>
        <select id="categoria" name="categoria"
                class="form-select @error('categoria') is-invalid @enderror"
                required>
            <option value="">Selecciona una categoría</option>
            @foreach($categorias as $nombreCategoria)
                <option value="{{ $nombreCategoria }}"
                    {{ $categoriaActual === $nombreCategoria ? 'selected' : '' }}>
                    {{ $nombreCategoria }}
                </option>
            @endforeach
        </select>
        @error('categoria')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if($categorias->isEmpty())
            <div class="form-text text-danger">
                No hay categorías registradas.
                <a href="{{ route('categorias.create') }}">Crea una aquí</a>.
            </div>
        @elseif($categoriaActual && ! $categorias->contains($categoriaActual))
            <div class="form-text text-warning">
                La categoría actual «{{ $categoriaActual }}» no está registrada.
                Elige una de la lista.
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="proveedor" class="form-label">Proveedor *</label>
        <select id="proveedor" name="proveedor"
                class="form-select @error('proveedor') is-invalid @enderror"
                required>
            <option value="">Selecciona un proveedor</option>
            @foreach($proveedores as $nombreProveedor)
                <option value="{{ $nombreProveedor }}"
                    {{ $proveedorActual === $nombreProveedor ? 'selected' : '' }}>
                    {{ $nombreProveedor }}
                </option>
            @endforeach
        </select>
        @error('proveedor')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if($proveedores->isEmpty())
            <div class="form-text text-danger">
                No hay proveedores registrados.
                <a href="{{ route('proveedores.create') }}">Crea uno aquí</a>.
            </div>
        @elseif($proveedorActual && ! $proveedores->contains($proveedorActual))
            <div class="form-text text-warning">
                El proveedor actual «{{ $proveedorActual }}» no está registrado.
                Elige uno de la lista.
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <label for="precio" class="form-label">Precio (S/) *</label>
        <input type="number" id="precio" name="precio"
               class="form-control @error('precio') is-invalid @enderror"
               value="{{ old('precio', $producto?->precio) }}"
               min="0" max="99999999.99" step="0.01" required>
        @error('precio')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="stock" class="form-label">Stock actual *</label>
        <input type="number" id="stock" name="stock"
               class="form-control @error('stock') is-invalid @enderror"
               value="{{ old('stock', $producto?->stock ?? 0) }}"
               min="0" step="1" required>
        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="stock_minimo" class="form-label">Stock mínimo *</label>
        <input type="number" id="stock_minimo" name="stock_minimo"
               class="form-control @error('stock_minimo') is-invalid @enderror"
               value="{{ old('stock_minimo', $producto?->stock_minimo ?? 5) }}"
               min="0" step="1" required>
        @error('stock_minimo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="4"
                  class="form-control @error('descripcion') is-invalid @enderror"
                  maxlength="5000">{{ old('descripcion', $producto?->descripcion) }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="imagen" class="form-label">Imagen del producto</label>
        <input type="file" id="imagen" name="imagen"
               class="form-control @error('imagen') is-invalid @enderror"
               accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
        <div class="form-text">JPG, PNG o WEBP. Tamaño máximo: 2 MB.</div>
        @error('imagen')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if($producto?->imagen)
            <div class="mt-3">
                <p class="small muted">Imagen actual:</p>
                <img src="{{ asset('storage/'.$producto->imagen) }}"
                     alt="{{ $producto->nombre }}"
                     style="max-width:150px;max-height:120px;object-fit:contain">
            </div>
        @endif
    </div>
</div>

<div class="d-flex flex-wrap gap-2 mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-lg"></i> {{ $boton }}
    </button>

    <a href="{{ route('productos.index') }}"
       class="btn btn-outline-secondary">
        Cancelar
    </a>
</div>