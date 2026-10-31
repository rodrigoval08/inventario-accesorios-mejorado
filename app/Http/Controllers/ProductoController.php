<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $categoria = $request->input('categoria');
        $estado = $request->input('estado');

        $consulta = Producto::query();

        if ($buscar) {
            $consulta->where(function ($query) use ($buscar) {
                $query->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('sku', 'like', "%{$buscar}%")
                    ->orWhere('proveedor', 'like', "%{$buscar}%");
            });
        }

        if ($categoria) {
            $consulta->where('categoria', $categoria);
        }

        if ($estado === 'bajo') {
            $consulta->whereColumn(
                'stock',
                '<=',
                'stock_minimo'
            );
        } elseif ($estado === 'disponible') {
            $consulta->whereColumn(
                'stock',
                '>',
                'stock_minimo'
            );
        }

        $productos = $consulta
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $categorias = Producto::query()
            ->select('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        $totalProductos = Producto::count();

        $stockBajo = Producto::whereColumn(
            'stock',
            '<=',
            'stock_minimo'
        )->count();

        $valorInventario = Producto::selectRaw(
            'COALESCE(SUM(precio * stock), 0) as total'
        )->value('total');

        return view('productos.index', compact(
            'productos',
            'categorias',
            'buscar',
            'categoria',
            'estado',
            'totalProductos',
            'stockBajo',
            'valorInventario'
        ));
    }

    public function create()
    {
        return view('productos.create', $this->listasParaFormulario());
    }

    public function store(Request $request)
    {
        $datos = $request->validate($this->reglas());

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')
                ->store('productos', 'public');
        }

        Producto::create($datos);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', array_merge(
            compact('producto'),
            $this->listasParaFormulario()
        ));
    }

    public function update(Request $request, Producto $producto)
    {
        $datos = $request->validate($this->reglas($producto));

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $datos['imagen'] = $request->file('imagen')
                ->store('productos', 'public');
        }

        $producto->update($datos);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    /**
     * Listas de nombres para los selectores del formulario.
     */
    private function listasParaFormulario(): array
    {
        return [
            'categorias'  => Categoria::orderBy('nombre')->pluck('nombre'),
            'proveedores' => Proveedor::orderBy('nombre')->pluck('nombre'),
        ];
    }

    /**
     * Reglas de validación compartidas por store y update.
     */
    private function reglas(?Producto $producto = null): array
    {
        return [
            'nombre' => ['required', 'string', 'max:150'],
            'sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('productos', 'sku')->ignore($producto?->id),
            ],
            // Deben ser nombres registrados en las tablas correspondientes
            'categoria' => ['required', 'string', 'max:100', Rule::exists('categorias', 'nombre')],
            'proveedor' => ['required', 'string', 'max:150', Rule::exists('proveedores', 'nombre')],
            'precio' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'stock' => ['required', 'integer', 'min:0'],
            'stock_minimo' => ['required', 'integer', 'min:0'],
            'descripcion' => ['nullable', 'string', 'max:5000'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}