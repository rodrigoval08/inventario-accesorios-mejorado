<?php

namespace App\Observers;

use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Proveedor;

class ProductoObserver
{
    /**
     * Al crear un producto con stock, se registra la entrada inicial.
     */
    public function created(Producto $producto): void
    {
        if ((int) $producto->stock > 0) {
            Movimiento::create([
                'producto_id'  => $producto->id,
                'proveedor_id' => $this->proveedorId($producto),
                'tipo'         => 'entrada',
                'cantidad'     => (int) $producto->stock,
                'motivo'       => 'Stock inicial',
                'usuario'      => auth()->user()?->name ?? 'admin',
            ]);
        }
    }

    /**
     * Si al editar un producto cambia el stock, se registra la diferencia
     * como entrada (si sube) o salida (si baja).
     */
    public function updated(Producto $producto): void
    {
        if (! $producto->wasChanged('stock')) {
            return;
        }

        $diferencia = (int) $producto->stock - (int) $producto->getOriginal('stock');

        if ($diferencia === 0) {
            return;
        }

        Movimiento::create([
            'producto_id'  => $producto->id,
            'proveedor_id' => $diferencia > 0 ? $this->proveedorId($producto) : null,
            'tipo'         => $diferencia > 0 ? 'entrada' : 'salida',
            'cantidad'     => abs($diferencia),
            'motivo'       => 'Ajuste de stock desde productos',
            'usuario'      => auth()->user()?->name ?? 'admin',
        ]);
    }

    /**
     * El producto guarda el nombre del proveedor; aquí se busca su id.
     */
    private function proveedorId(Producto $producto): ?int
    {
        return Proveedor::where('nombre', $producto->proveedor)->value('id');
    }
}