<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TechStock | Inventario SENATI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

        @include('layouts._responsive')
        @include('layouts._temporada')
</head>

<body>

<aside class="sidebar">
    <div class="brand">Tech<span>Stock</span></div>

    <nav class="nav flex-column">
        <a href="{{ route('dashboard') }}"
            class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Inicio
        </a>

        <a href="{{ route('productos.index') }}"
            class="nav-link-custom {{ request()->routeIs('productos.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Productos
        </a>

        <a href="{{ route('categorias.index') }}"
            class="nav-link-custom {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Categorías
        </a>

        <a href="{{ route('proveedores.index') }}"
            class="nav-link-custom {{ request()->routeIs('proveedores.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i> Proveedores
        </a>

        <a href="{{ route('movimientos.index') }}"
            class="nav-link-custom {{ request()->routeIs('movimientos.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right"></i> Movimientos
        </a>

        <a href="#reportes" class="nav-link-custom">
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

    <header class="topbar">
        <div>
            <h1>Dashboard principal</h1>
            <div class="subtitle">
                Sistema de Inventario de Accesorios Informáticos
            </div>
        </div>

        <div class="text-end">
            <div class="fw-bold">
                <i class="bi bi-person-circle"></i> Administrador
            </div>
            <small class="text-secondary">Panel de gestión</small>
        </div>
    </header>

    <!-- Indicadores principales -->
    <section class="row g-3 mb-4">

        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon text-primary bg-primary-subtle">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stat-number">24</div>
                <div class="stat-label">Productos registrados</div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon text-success bg-success-subtle">
                    <i class="bi bi-tags"></i>
                </div>
                <div class="stat-number">5</div>
                <div class="stat-label">Categorías</div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon text-info bg-info-subtle">
                    <i class="bi bi-truck"></i>
                </div>
                <div class="stat-number">4</div>
                <div class="stat-label">Proveedores</div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon text-danger bg-danger-subtle">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stat-number">3</div>
                <div class="stat-label">Productos con stock bajo</div>
            </div>
        </div>

    </section>

    <!-- Productos con stock bajo -->
    <section class="panel" id="productos">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Productos con stock bajo</h2>
            <a href="{{ route('productos.index') }}" class="btn btn-sm btn-outline-primary">
                Ver productos
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Stock mínimo</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Mouse inalámbrico</td>
                        <td>Accesorios</td>
                        <td>2</td>
                        <td>5</td>
                        <td>
                            <span class="badge badge-stock">Bajo</span>
                        </td>
                    </tr>

                    <tr>
                        <td>Teclado mecánico</td>
                        <td>Periféricos</td>
                        <td>3</td>
                        <td>5</td>
                        <td>
                            <span class="badge badge-stock">Bajo</span>
                        </td>
                    </tr>

                    <tr>
                        <td>Memoria RAM 8 GB</td>
                        <td>Componentes</td>
                        <td>1</td>
                        <td>4</td>
                        <td>
                            <span class="badge badge-stock">Bajo</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Resumen de movimientos -->
    <section class="panel" id="movimientos">
        <h2>Resumen de movimientos</h2>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="p-3 rounded-3 bg-success-subtle">
                    <i class="bi bi-box-arrow-in-down text-success"></i>
                    <strong> Entradas</strong>
                    <p class="mb-0 mt-2 text-secondary">
                        Recepciones de productos y reposiciones.
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 rounded-3 bg-danger-subtle">
                    <i class="bi bi-box-arrow-up text-danger"></i>
                    <strong> Salidas</strong>
                    <p class="mb-0 mt-2 text-secondary">
                        Ventas y retiros de productos del inventario.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        TechStock · Sistema de Inventario · Proyecto académico SENATI
    </footer>

</main>
@include('layouts._responsive')
</body>
</html>