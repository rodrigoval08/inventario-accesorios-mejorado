@extends('layouts.app')
 
@section('title', 'Proveedores')
 
@section('content')
 
    <header class="topbar">
        <div>
            <h1>Proveedores</h1>
            <div class="subtitle">Gestión de proveedores</div>
        </div>
 
        <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nuevo proveedor
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
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
 
                <tbody>
                    @forelse ($proveedores as $proveedor)
                        <tr>
                            <td class="fw-semibold">{{ $proveedor->nombre }}</td>
                            <td>{{ $proveedor->email ?? '—' }}</td>
                            <td>{{ $proveedor->telefono ?? '—' }}</td>
                            <td class="text-secondary">{{ $proveedor->direccion ?? '—' }}</td>
                            <td class="text-center">
                                <a href="{{ route('proveedores.edit', $proveedor) }}"
                                   class="btn btn-sm btn-primary" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
 
                                <form action="{{ route('proveedores.destroy', $proveedor) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar al proveedor «{{ $proveedor->nombre }}»?');">
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
                            <td colspan="5" class="text-center text-secondary py-4">
                                Aún no hay proveedores registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
 
        @if ($proveedores->total() > 0)
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                <small class="text-secondary">
                    Mostrando {{ $proveedores->firstItem() }} - {{ $proveedores->lastItem() }}
                    de {{ $proveedores->total() }} registros
                </small>
 
                {{ $proveedores->links() }}
            </div>
        @endif
    </section>
 
@endsection