@extends('layouts.app')

@section('title', 'Movimientos de stock')

@section('content')

    <header class="topbar">
        <div>
            <h1>Movimientos de Stock</h1>
            <div class="subtitle">Historial de entradas y salidas del inventario</div>
        </div>

        <a href="{{ route('movimientos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Registrar movimiento
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
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Cantidad</th>
                        <th>Proveedor</th>
                        <th>Usuario</th>
                        <th>Motivo</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($movimientos as $movimiento)
                        <tr>
                            <td class="text-nowrap">{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                            <td class="fw-semibold">
                                {{ $movimiento->producto->nombre ?? 'Producto eliminado' }}
                            </td>
                            <td class="text-center">
                                @if ($movimiento->tipo === 'entrada')
                                    <span class="badge bg-success-subtle text-success">Entrada</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Salida</span>
                                @endif
                            </td>
                            <td class="text-center fw-semibold
                                {{ $movimiento->tipo === 'entrada' ? 'text-success' : 'text-danger' }}">
                                {{ $movimiento->tipo === 'entrada' ? '+' : '-' }}{{ $movimiento->cantidad }}
                            </td>
                            <td>{{ $movimiento->proveedor->nombre ?? '—' }}</td>
                            <td>{{ $movimiento->usuario }}</td>
                            <td class="text-secondary">{{ $movimiento->motivo ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-4">
                                Aún no hay movimientos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($movimientos->total() > 0)
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                <small class="text-secondary">
                    Mostrando {{ $movimientos->firstItem() }} - {{ $movimientos->lastItem() }}
                    de {{ $movimientos->total() }} registros
                </small>

                {{ $movimientos->links() }}
            </div>
        @endif
    </section>

@endsection