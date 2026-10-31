<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReporteController extends Controller
{
    public function index()
    {
        // Indicadores generales
        $totalProductos  = Producto::count();
        $valorInventario = (float) Producto::selectRaw('COALESCE(SUM(precio * stock), 0) as total')
            ->value('total');
        $stockBajo = Producto::whereColumn('stock', '<=', 'stock_minimo')->count();
        $sinStock  = Producto::where('stock', 0)->count();

        // Productos por categoría
        $porCategoria = Producto::select('categoria', DB::raw('COUNT(*) as total'))
            ->groupBy('categoria')
            ->orderByDesc('total')
            ->get();

        // Productos que necesitan reposición
        $productosStockBajo = Producto::whereColumn('stock', '<=', 'stock_minimo')
            ->orderBy('stock')
            ->limit(10)
            ->get();

        // Entradas y salidas de los últimos 7 días
        $dias = collect(range(6, 0))->map(fn ($i) => now()->subDays($i)->startOfDay());

        $movimientos = Movimiento::where('created_at', '>=', $dias->first())
            ->get()
            ->groupBy(fn ($m) => $m->created_at->format('Y-m-d'));

        $etiquetas = $dias->map(fn ($d) => $d->format('d/m'))->values();
        $entradas  = $dias->map(fn ($d) => (int) ($movimientos[$d->format('Y-m-d')] ?? collect())
            ->where('tipo', 'entrada')->sum('cantidad'))->values();
        $salidas   = $dias->map(fn ($d) => (int) ($movimientos[$d->format('Y-m-d')] ?? collect())
            ->where('tipo', 'salida')->sum('cantidad'))->values();

        // Productos con más salidas en los últimos 30 días
        $masSalidas = Movimiento::with('producto')
            ->select('producto_id', DB::raw('SUM(cantidad) as total'))
            ->where('tipo', 'salida')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('producto_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('reportes.index', compact(
            'totalProductos',
            'valorInventario',
            'stockBajo',
            'sinStock',
            'porCategoria',
            'productosStockBajo',
            'etiquetas',
            'entradas',
            'salidas',
            'masSalidas'
        ));
    }

    /**
     * Descarga el inventario completo en CSV (se abre bien en Excel).
     */
    public function exportar(): StreamedResponse
    {
        $archivo = 'inventario_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $salida = fopen('php://output', 'w');

            // BOM para que Excel respete las tildes y la ñ
            fwrite($salida, "\xEF\xBB\xBF");

            fputcsv($salida, [
                'SKU', 'Producto', 'Categoría', 'Proveedor',
                'Precio', 'Stock', 'Stock mínimo', 'Estado', 'Valor en stock',
            ], ',', '"', '\\');

            Producto::orderBy('nombre')->chunk(200, function ($productos) use ($salida) {
                foreach ($productos as $p) {
                    fputcsv($salida, [
                        $p->sku,
                        $p->nombre,
                        $p->categoria,
                        $p->proveedor,
                        number_format((float) $p->precio, 2, '.', ''),
                        $p->stock,
                        $p->stock_minimo,
                        $p->stock <= $p->stock_minimo ? 'Bajo' : 'Disponible',
                        number_format((float) $p->precio * $p->stock, 2, '.', ''),
                    ], ',', '"', '\\');
                }
            });

            fclose($salida);
        }, $archivo, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}