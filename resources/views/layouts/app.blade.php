<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'TechStock') | Inventario SENATI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

     @include('layouts._responsive')
     @include('layouts._temporada')

    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="brand">Tech<span>Stock</span></div>

    <nav>
        <a class="nav-item-link" href="{{ route('dashboard') }}">
            <i class="bi bi-grid-1x2-fill"></i> Inicio
        </a>

        <a class="nav-item-link {{ request()->routeIs('productos.*') ? 'active' : '' }}"
        href="{{ route('productos.index') }}">
            <i class="bi bi-box-seam"></i> Productos
        </a>

        <a class="nav-item-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}" href="{{ route('categorias.index') }}">
            <i class="bi bi-tags"></i> Categorías
        </a>

        <a class="nav-item-link {{ request()->routeIs('proveedores.*') ? 'active' : '' }}" href="{{route('proveedores.index') }}">
            <i class="bi bi-truck"></i> Proveedores
        </a>

        <a class="nav-item-link {{ request()->routeIs('movimientos.*') ? 'active' : '' }}" href="{{ route('movimientos.index') }}">
            <i class="bi bi-arrow-left-right"></i> Movimientos
        </a>

        <a class="nav-item-link {{request()->routeIs('reportes.*') ? 'active' : '' }}" href="{{ route('reportes.index') }}">
            <i class="bi bi-bar-chart"></i> Reportes
        </a>
    </nav>
    
    <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="nav-link-custom w-100 border-0 bg-transparent">
            <i class="bi bi-box-arrow-left"></i> Cerrar sesión
        </button>
    </form>
</aside>

<main class="main">
    @yield('content')

    <footer class="footer">
        TechStock · Sistema de Inventario · Proyecto académico SENATI
    </footer>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>