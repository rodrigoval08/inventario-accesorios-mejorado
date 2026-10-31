@extends('layouts.app')

@section('title', 'Categorías')

@section('content')

    <header class="topbar">
        <div>
            <h1>Categorías</h1>
            <div class="subtitle">Gestión de categorías de productos</div>
        </div>

        <a href="{{ route('categorias.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nueva categoría
        </a>
    </header>

    {{-- Mensajes de éxito / error --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle-fill me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <section class="panel">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-center">Productos</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td class="fw-semibold">{{ $categoria->nombre }}</td>
                            <td class="text-secondary">{{ $categoria->descripcion ?? '—' }}</td>
                            <td class="text-center">{{ $categoria->productos_count }}</td>
                            <td class="text-center">
                                <a href="{{ route('categorias.edit', $categoria) }}"
                                    class="btn btn-sm btn-primary" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('categorias.destroy', $categoria) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('¿Eliminar la categoría «{{ $categoria->nombre }}»?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-secondary py-4">
                                Aún no hay categorías registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categorias->total() > 0)
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                <small class="text-secondary">
                    Mostrando {{ $categorias->firstItem() }} - {{ $categorias->lastItem() }}
                    de {{ $categorias->total() }} registros
                </small>

                {{ $categorias->links() }}
            </div>
        @endif
    </section>

@endsection