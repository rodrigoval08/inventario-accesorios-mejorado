{{-- ============================================================
     _responsive.blade.php
     Todo el CSS y JS del sistema en un solo archivo.
     Se incluye con:  @include('layouts._responsive')
     Orden: 1) CSS del dashboard  2) CSS de app.blade.php  3) Responsive
     (en CSS, lo que va después gana cuando hay reglas repetidas)
     ============================================================ --}}

{{-- 1. CSS que estaba en dashboard.blade.php --}}
<style>
        :root {
            --azul-oscuro: #102b4e;
            --azul-principal: #0875e1;
            --fondo: #f3f6fb;
            --texto: #24364b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--fondo);
            color: var(--texto);
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .sidebar {
            width: 235px;
            min-height: 100vh;
            position: fixed;
            inset: 0 auto 0 0;
            background: var(--azul-oscuro);
            color: white;
            padding: 24px 14px;
            z-index: 1000;
        }

        .brand {
            font-size: 23px;
            font-weight: 800;
            padding: 8px 12px 25px;
        }

        .brand span {
            color: #69b5ff;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin-bottom: 5px;
            border-radius: 7px;
            color: #c7d5e8;
            text-decoration: none;
            transition: .2s;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            background: #0875e1;
            color: white;
        }

        .main {
            margin-left: 235px;
            padding: 28px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 28px;
        }

        .topbar h1 {
            font-size: 27px;
            font-weight: 750;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #718096;
            font-size: 14px;
        }

        .stat-card,
        .panel {
            background: white;
            border: 1px solid #e5eaf2;
            border-radius: 12px;
            box-shadow: 0 4px 15px #18395d08;
        }

        .stat-card {
            padding: 20px;
            height: 100%;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            font-size: 22px;
        }

        .stat-number {
            font-size: 29px;
            font-weight: 800;
            margin-top: 14px;
        }

        .stat-label {
            color: #718096;
            font-size: 13px;
        }

        .panel {
            padding: 22px;
            margin-bottom: 24px;
        }

        .panel h2 {
            font-size: 17px;
            font-weight: 750;
            margin-bottom: 20px;
        }

        .table {
            font-size: 13px;
            vertical-align: middle;
        }

        .table thead th {
            color: #64748b;
            background: #f7f9fc;
            font-weight: 650;
            white-space: nowrap;
        }

        .badge-stock {
            background: #fff0d6;
            color: #a66300;
        }

        .footer {
            text-align: center;
            color: #8492a6;
            font-size: 12px;
            padding: 15px;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 70px;
                padding: 18px 8px;
            }

            .brand {
                font-size: 0;
                padding: 10px 12px 25px;
            }

            .brand span {
                font-size: 20px;
            }

            .nav-link-custom {
                justify-content: center;
                padding: 13px 5px;
                font-size: 0;
            }

            .nav-link-custom i {
                font-size: 19px;
            }

            .main {
                margin-left: 70px;
                padding: 18px;
            }
        }

        @media (max-width: 520px) {
            .main {
                padding: 12px;
            }

            .topbar h1 {
                font-size: 21px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-number {
                font-size: 24px;
            }

            .panel {
                padding: 14px;
            }
        }
</style>

{{-- 2. CSS que estaba en layouts/app.blade.php --}}
<style>
        :root {
            --navy: #102b4e;
            --blue: #0875e1;
            --background: #f3f6fb;
            --text: #26384d;
        }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 235px;
            padding: 24px 14px;
            background: var(--navy);
            color: white;
            z-index: 1000;
        }

        .brand {
            font-size: 23px;
            font-weight: 800;
            padding: 8px 12px 25px;
        }

        .brand span { color: #69b5ff; }

        .nav-item-link {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 12px 14px;
            margin-bottom: 5px;
            border-radius: 7px;
            color: #c7d5e8;
            text-decoration: none;
        }

        .nav-item-link:hover,
        .nav-item-link.active {
            background: var(--blue);
            color: white;
        }

        .main {
            margin-left: 235px;
            padding: 28px;
            min-height: 100vh;
        }

        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 24px;
        }

        .page-heading h1 {
            font-size: 27px;
            font-weight: 750;
        }

        .muted { color: #718096; }

        .panel, .stat-card {
            background: white;
            border: 1px solid #e5eaf2;
            border-radius: 12px;
            box-shadow: 0 4px 15px #18395d08;
        }

        .panel { padding: 22px; }

        .stat-card { padding: 18px; height: 100%; }

        .stat-number {
            font-size: 27px;
            font-weight: 800;
        }

        .form-label { font-weight: 600; }

        .form-control, .form-select {
            border-color: #dbe3ee;
            padding: 10px 12px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 .2rem #0875e120;
        }

        .table { vertical-align: middle; }

        .table thead th {
            background: #f6f8fc;
            color: #53657a;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .product-image {
            width: 48px;
            height: 42px;
            object-fit: contain;
            background: #f5f7fb;
            border-radius: 7px;
        }

        .stock-low {
            background: #fff0d6;
            color: #9b5a00;
        }

        .stock-ok {
            background: #dcfce7;
            color: #166534;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            color: #8492a6;
            font-size: 12px;
        }

        @media (max-width: 900px) {
            .sidebar { width: 70px; padding: 18px 8px; }
            .brand { font-size: 0; padding: 10px 12px 25px; }
            .brand span { font-size: 20px; }
            .nav-item-link { justify-content: center; padding: 13px 5px; font-size: 0; }
            .nav-item-link i { font-size: 19px; }
            .main { margin-left: 70px; padding: 18px; }
        }

        @media (max-width: 520px) {
            .main { padding: 12px; }
            .page-heading h1 { font-size: 21px; }
            .panel { padding: 14px; }
        }
</style>

{{-- 3. Responsive: menú tipo cajón, tablas en tarjetas y ajustes de móvil/tableta --}}
<style>
    /* ---------- Base: nada debe desbordar horizontalmente ---------- */
    html, body { max-width: 100%; overflow-x: hidden; }
    img, canvas, svg, video { max-width: 100%; }

    /* Elementos que solo existen en móvil/tableta */
    .barra-movil,
    .fondo-menu { display: none; }

    /* ---------- Tableta y móvil: menú lateral tipo cajón ---------- */
    @media (max-width: 991.98px) {

        body { padding-top: 58px; }

        /* Barra superior con el botón de menú */
        .barra-movil {
            display: flex;
            align-items: center;
            gap: 12px;
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 58px;
            padding: 0 14px;
            background: #102b4e;
            color: #fff;
            z-index: 1100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .25);
        }

        .btn-menu {
            display: grid;
            place-items: center;
            width: 42px; height: 42px;
            border: 0;
            border-radius: 8px;
            background: rgba(255, 255, 255, .1);
            color: #fff;
            font-size: 26px;
            line-height: 1;
        }

        .btn-menu:active { background: rgba(255, 255, 255, .22); }

        .barra-marca { font-size: 21px; font-weight: 800; }
        .barra-marca span { color: #69b5ff; }

        /* El menú lateral se oculta fuera de pantalla */
        .sidebar {
            width: 270px !important;
            max-width: 82vw;
            height: 100vh;
            height: 100dvh;
            min-height: 0 !important;
            padding: 20px 14px !important;
            overflow-y: auto;
            transform: translateX(-100%);
            transition: transform .28s ease;
            z-index: 1200 !important;
            box-shadow: none;
        }

        body.menu-abierto .sidebar {
            transform: translateX(0);
            box-shadow: 8px 0 30px rgba(0, 0, 0, .45);
        }

        /* Anula la versión "solo iconos" que traía el diseño anterior */
        .sidebar .brand { font-size: 23px !important; padding: 8px 12px 20px !important; }
        .sidebar .brand span { font-size: inherit !important; }
        .sidebar a,
        .sidebar button {
            font-size: 15px !important;
            justify-content: flex-start !important;
            padding: 12px 14px !important;
        }
        .sidebar a i,
        .sidebar button i { font-size: 18px !important; }

        .fondo-menu {
            display: block;
            position: fixed;
            inset: 0;
            background: rgba(8, 14, 28, .55);
            opacity: 0;
            visibility: hidden;
            transition: opacity .28s ease, visibility .28s;
            z-index: 1150;
        }

        body.menu-abierto .fondo-menu { opacity: 1; visibility: visible; }
        body.menu-abierto { overflow: hidden; }

        /* El contenido usa todo el ancho */
        main, .main {
            margin-left: 0 !important;
            padding: 18px !important;
        }
    }

    /* ---------- Tableta ---------- */
    @media (min-width: 768px) and (max-width: 991.98px) {
        main, .main { padding: 22px !important; }
    }

    /* ---------- Móvil ---------- */
    @media (max-width: 767.98px) {

        main, .main { padding: 14px !important; }

        /* Encabezados de página: apilados y con botones cómodos */
        .topbar,
        .page-heading {
            flex-wrap: wrap;
            gap: 12px !important;
        }
        .topbar h1,
        .page-heading h1 { font-size: 22px !important; }
        .topbar > .btn,
        .page-heading > .btn,
        .topbar > a.btn { width: 100%; }

        /* Tarjetas e indicadores */
        .panel,
        .rep-card { padding: 16px !important; }
        .stat-number,
        .rep-number { font-size: 22px !important; }

        /* Campos de filtros y formularios a todo el ancho */
        main .form-control,
        main .form-select { max-width: 100%; }
        main form .row > [class*="col-"] { width: 100%; }
        main form .d-flex.gap-2 .btn { flex: 1 1 auto; }

        /* Botones más fáciles de tocar */
        .table .btn-sm { padding: .5rem .75rem; }

        /* Paginación centrada y sin desbordar */
        .pagination { flex-wrap: wrap; justify-content: center; }
        .panel > .d-flex.justify-content-between.flex-wrap {
            flex-direction: column;
            align-items: center !important;
            text-align: center;
        }

        /* Gráficos de reportes más bajos */
        .rep-chart { height: 230px !important; }

        /* Tablas anchas -> tarjetas (la clase la agrega el script) */
        .table.tabla-cards thead { display: none; }
        .table.tabla-cards,
        .table.tabla-cards tbody,
        .table.tabla-cards tr,
        .table.tabla-cards td { display: block; width: 100%; }

        .table.tabla-cards tr {
            background: #fff;
            border: 1px solid #e5eaf2;
            border-radius: 12px;
            margin-bottom: 12px;
            padding: 6px 14px;
            box-shadow: 0 2px 8px rgba(24, 57, 93, .06);
        }

        .table.tabla-cards td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            text-align: right !important;
            padding: .55rem 0 !important;
            border: 0 !important;
            border-bottom: 1px dashed #e8edf5 !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .table.tabla-cards td:last-child { border-bottom: 0 !important; }

        .table.tabla-cards td[data-label]::before {
            content: attr(data-label);
            flex: 0 0 38%;
            text-align: left;
            font-weight: 600;
            color: #64748b;
        }

        .table.tabla-cards td[colspan] {
            display: block;
            text-align: center !important;
        }
    }

    /* Pantallas muy pequeñas */
    @media (max-width: 380px) {
        .barra-marca { font-size: 18px; }
        main, .main { padding: 10px !important; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        /* ----- Menú tipo cajón para tableta y móvil ----- */
        var sidebar = document.querySelector('.sidebar');

        if (sidebar) {
            var barra = document.createElement('div');
            barra.className = 'barra-movil';
            barra.innerHTML =
                '<button type="button" class="btn-menu" aria-label="Abrir menú" aria-expanded="false">' +
                '<i class="bi bi-list"></i></button>' +
                '<span class="barra-marca">Tech<span>Stock</span></span>';
            document.body.insertBefore(barra, document.body.firstChild);

            var fondo = document.createElement('div');
            fondo.className = 'fondo-menu';
            document.body.appendChild(fondo);

            var boton = barra.querySelector('.btn-menu');

            function fijarMenu(abierto) {
                document.body.classList.toggle('menu-abierto', abierto);
                boton.setAttribute('aria-expanded', abierto ? 'true' : 'false');
            }

            boton.addEventListener('click', function () {
                fijarMenu(!document.body.classList.contains('menu-abierto'));
            });

            fondo.addEventListener('click', function () { fijarMenu(false); });

            sidebar.querySelectorAll('a').forEach(function (enlace) {
                enlace.addEventListener('click', function () { fijarMenu(false); });
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') { fijarMenu(false); }
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth >= 992) { fijarMenu(false); }
            });
        }

        /* ----- Tablas: etiquetas para verlas como tarjetas en móvil ----- */
        document.querySelectorAll('table.table').forEach(function (tabla) {
            var cabeceras = Array.prototype.map.call(
                tabla.querySelectorAll('thead th'),
                function (th) { return th.textContent.trim(); }
            );

            // Las tablas de 3 columnas o menos se quedan como tabla
            if (cabeceras.length > 3) {
                tabla.classList.add('tabla-cards');
            }

            tabla.querySelectorAll('tbody tr').forEach(function (fila) {
                Array.prototype.forEach.call(fila.children, function (celda, i) {
                    if (celda.colSpan === 1 && cabeceras[i]) {
                        celda.setAttribute('data-label', cabeceras[i]);
                    }
                });
            });
        });
    });
</script>