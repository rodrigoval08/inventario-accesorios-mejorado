<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $fillable = ['nombre', 'descripcion'];

    // Los productos guardan el NOMBRE de la categoría en la columna "categoria"
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'categoria', 'nombre');
    }
}