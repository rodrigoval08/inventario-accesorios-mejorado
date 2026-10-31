<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Controller
{
    public function index()
    {
        $movimientos = Movimiento::with(['producto', 'proveedor'])
            ->latest()
            ->paginate(10);

        return view('movimientos.index', compact('movimientos'));
    }

    public function create()
    {
        $productos   = Producto::orderBy('nombre')->get();
        $proveedores = Proveedor::orderBy('nombre')->get();

        return view('movimientos.create', compact('productos', 'proveedores'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'producto_id'  => 'required|exists:productos,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'tipo'         => 'required|in:entrada,salida',
            'cantidad'     => 'required|integer|min:1',
            'motivo'       => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($datos) {
                $producto = Producto::lockForUpdate()->findOrFail($datos['producto_id']);

                if ($datos['tipo'] === 'salida' && $producto->stock < $datos['cantidad']) {
                    throw new \RuntimeException(
                        "Stock insuficiente: «{$producto->nombre}» solo tiene {$producto->stock} unidades."
                    );
                }

                // withoutEvents evita que el observer duplique este movimiento
                Producto::withoutEvents(function () use ($producto, $datos) {
                    if ($datos['tipo'] === 'entrada') {
                        $producto->increment('stock', $datos['cantidad']);
                    } else {
                        $producto->decrement('stock', $datos['cantidad']);
                    }
                });

                // Las entradas toman el proveedor del producto si no se eligió uno
                if ($datos['tipo'] === 'entrada') {
                    $datos['proveedor_id'] = $datos['proveedor_id']
                        ?? Proveedor::where('nombre', $producto->proveedor)->value('id');
                } else {
                    $datos['proveedor_id'] = null;
                }

                Movimiento::create($datos + ['usuario' => auth()->user()?->name ?? 'admin']);
            });
        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('movimientos.index')
            ->with('success', 'Movimiento registrado correctamente.');
    }
}