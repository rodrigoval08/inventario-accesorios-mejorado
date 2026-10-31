<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Proveedor extends Model
{
    // Laravel pluraliza en inglés ("proveedors"), por eso se indica la tabla
    protected $table = 'proveedores';
 
    protected $fillable = ['nombre', 'email', 'telefono', 'direccion'];
}