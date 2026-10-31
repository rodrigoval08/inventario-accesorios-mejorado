<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimiento extends Model
{
    protected $fillable = [
        'producto_id',
        'proveedor_id',
        'tipo', 
        'cantidad',
        'motivo',
        'usuario'
        ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }
}