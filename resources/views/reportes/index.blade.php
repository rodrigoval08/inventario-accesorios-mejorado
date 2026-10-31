@extends('layouts.app')

@section('title', 'Reportes')

@section('content')

<style>
    .rep-card {
        background: #fff;
        border: 1px solid #e5eaf2;
        border-radius: 12px;
        box-shadow: 0 4px 15px #18395d08;
        padding: 20px;
        height: 100%;
    }
    .rep-card h2 {
        font-size: 17px;
        font-weight: 750;
        margin-bottom: 16px;
    }
    .rep-icon {
        width: 46px;
        height: 46px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        font-size: 22px;
    }
    .rep-number {
        font-size: 28px;
        font-weight: 800;
        margin-top: 12px;
    }
    .rep-label {
        color: #718096;
        font-size: 13px;
    }
    .rep-chart {
        position: relative;
        height: 280px;
    }

    @media print {
        aside,
        .sidebar,
        .no-print {
            display: none !important;
        }
        main,
        .main {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        body {
            background: #fff !important;
        }
        .rep-card {
            box-shadow: none;
            break-inside: avoid;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h1 class="mb-1" style="font-size:27px;font-weight:750;">Reportes</h1>
        <div class="text-secondary" style="font-size:14px;">
            Resumen del inventario al {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    <div class="d-flex gap-2 no-print">
        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
            <i class="bi bi-printer"></i> Imprimir
        </button>
        <a href="{{ route('reportes.exportar') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-spreadsheet"></i> Exportar CSV
        </a>
    </div>
</div>

{{-- Indicadores --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="rep-card">
            <div class="rep-icon text-primary bg-primary-subtle"><i class="bi bi-box-seam"></i></div>
            <div class="rep-number">{{ $totalProductos }}</div>
            <div class="rep-label">Productos registrados</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="rep-card">
            <div class="rep-icon text-success bg-success-subtle"><i class="bi bi-cash-coin"></i></div>
            <div class="rep-number">S/ {{ number_format($valorInventario, 2) }}</div>
            <div class="rep-label">Valor del inventario</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="rep-card">
            <div class="rep-icon text-warning bg-warning-subtle"><i class="bi bi-exclamation-triangle"></i></div>
            <div class="rep-number">{{ $stockBajo }}</div>
            <div class="rep-label">Productos con stock bajo</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="rep-card">
            <div class="rep-icon text-danger bg-danger-subtle"><i class="bi bi-x-octagon"></i></div>
            <div class="rep-number">{{ $sinStock }}</div>
            <div class="rep-label">Productos sin stock</div>
        </div>
    </div>
</div>

{{-- Gráficos --}}
<div class="row g-3 mb-4">
    <div class="col-lg-5">
        <div class="rep-card">
            <h2>Productos por categoría</h2>
            @if($porCategoria->isEmpty())
                <p class="text-secondary mb-0">Aún no hay productos registrados.</p>
            @else
                <div class="rep-chart"><canvas id="graficoCategorias"></canvas></div>
            @endif
        </div>
    </div>

    <div class="col-lg-7">
        <div class="rep-card">
            <h2>Entradas y salidas (últimos 7 días)</h2>
            <div class="rep-chart"><canvas id="graficoMovimientos"></canvas></div>
        </div>
    </div>
</div>

{{-- Tablas --}}
<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="rep-card">
            <h2>Productos por reponer</h2>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:13px;">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Mínimo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productosStockBajo as $producto)
                            <tr>
                                <td class="fw-semibold">{{ $producto->nombre }}</td>
                                <td>{{ $producto->categoria }}</td>
                                <td class="text-center text-danger fw-semibold">{{ $producto->stock }}</td>
                                <td class="text-center">{{ $producto->stock_minimo }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-secondary py-3">
                                    Todo el inventario está por encima del stock mínimo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="rep-card">
            <h2>Más salidas (últimos 30 días)</h2>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:13px;">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Unidades</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($masSalidas as $fila)
                            <tr>
                                <td class="fw-semibold">{{ $fila->producto->nombre ?? 'Producto eliminado' }}</td>
                                <td class="text-center text-danger fw-semibold">-{{ $fila->total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-secondary py-3">
                                    Aún no hay salidas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
    const paleta = ['#0875e1', '#198754', '#ffc107', '#dc3545', '#6f42c1', '#20c997', '#fd7e14', '#6c757d'];

    const canvasCategorias = document.getElementById('graficoCategorias');
    if (canvasCategorias) {
        new Chart(canvasCategorias, {
            type: 'doughnut',
            data: {
                labels: @json($porCategoria->pluck('categoria')),
                datasets: [{
                    data: @json($porCategoria->pluck('total')),
                    backgroundColor: paleta,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    new Chart(document.getElementById('graficoMovimientos'), {
        type: 'bar',
        data: {
            labels: @json($etiquetas),
            datasets: [
                { label: 'Entradas', data: @json($entradas), backgroundColor: '#198754' },
                { label: 'Salidas',  data: @json($salidas),  backgroundColor: '#dc3545' }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>

@endsection