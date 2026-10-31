{{-- ============================================================
     _temporada.blade.php
     Ambiente según la fecha: colores del menú, partículas suaves,
     detalles en las esquinas y escena de bienvenida tras el login.
     Se incluye en el <head> con:  @include('layouts._temporada')
     La lógica de fechas y las fichas están en app/Support/Temporadas.php
     ============================================================ --}}
@php
    $temporada = \App\Support\Temporadas::actual();
    $datosTema = $temporada
        ? $temporada + [
            'usuario'    => auth()->user()?->name,
            'bienvenida' => \App\Support\Temporadas::mostrarBienvenida(),
        ]
        : null;
@endphp

<style>
    /* Todo lo de abajo solo actúa cuando el <body> tiene la clase "tema-activo" */

    /* ---------- Menú lateral con el color de la temporada ---------- */
    body.tema-activo .sidebar {
        border-top: 3px solid var(--tema-acento);
        background:
            radial-gradient(ellipse at 50% 112%, var(--tema-brillo) 0%, transparent 58%),
            linear-gradient(180deg, var(--tema-menu) 0%, var(--tema-menu-fin) 100%);
    }

    body.tema-activo .barra-movil { background: var(--tema-menu); }

    body.tema-activo .nav-link-custom:hover,
    body.tema-activo .nav-link-custom.active,
    body.tema-activo .nav-item-link:hover,
    body.tema-activo .nav-item-link.active {
        background: var(--tema-acento);
    }

    body.tema-activo .btn-primary {
        --bs-btn-bg: var(--tema-acento);
        --bs-btn-border-color: var(--tema-acento);
        --bs-btn-hover-bg: var(--tema-oscuro);
        --bs-btn-hover-border-color: var(--tema-oscuro);
        --bs-btn-active-bg: var(--tema-oscuro);
        --bs-btn-active-border-color: var(--tema-oscuro);
        --bs-btn-disabled-bg: var(--tema-acento);
        --bs-btn-disabled-border-color: var(--tema-acento);
    }

    body.tema-activo .form-control:focus,
    body.tema-activo .form-select:focus {
        border-color: var(--tema-acento);
        box-shadow: 0 0 0 .2rem var(--tema-suave);
    }

    /* ---------- Emoji junto al logo ---------- */
    .tema-brand {
        display: inline-block;
        margin-left: 4px;
        font-size: .8em;
    }

    body.tema-anima .tema-brand { animation: tema-flotar 4s ease-in-out infinite; }

    /* ---------- Aviso discreto de la temporada ---------- */
    .tema-cinta {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        padding: 8px 12px;
        border-radius: 10px;
        border-left: 4px solid var(--tema-acento);
        background: var(--tema-suave);
        color: #26384d;
        font-size: 13px;
    }

    .tema-cinta-texto { flex: 1; }

    .tema-cinta-cerrar {
        border: 0;
        background: transparent;
        color: #5b6b7f;
        font-size: 20px;
        line-height: 1;
        padding: 0 4px;
        cursor: pointer;
    }

    .tema-cinta-cerrar:hover { color: #1c2a3a; }

    /* ---------- Partículas de fondo ---------- */
    .tema-capa {
        position: fixed;
        inset: 0;
        z-index: -1;                 /* detrás de las tarjetas */
        pointer-events: none;
        overflow: hidden;
    }

    .tema-capa span {
        position: absolute;
        top: 0;
        left: var(--x);
        font-size: var(--tam);
        opacity: .22;
        animation-duration: var(--dur);
        animation-delay: var(--delay);
        animation-iteration-count: infinite;
        animation-timing-function: linear;
    }

    .tema-cae span   { animation-name: tema-cae; }
    .tema-sube span  { animation-name: tema-sube; }

    /* Murciélagos: negros, grandes y por encima del contenido (sin bloquear clics) */
    .tema-capa.tema-vuela { z-index: 20; }

    .tema-vuela span {
        left: 0;
        top: var(--y);
        animation-name: tema-vuela;
    }

    .tema-vuela span i {
        display: inline-block;
        font-style: normal;
        animation: tema-aletear .28s ease-in-out infinite alternate;
    }

    .tema-capa.tema-negras span { opacity: .5; }
    .tema-capa.tema-negras span i { filter: brightness(0); }

    /* ---------- Detalles en las esquinas (como la calabaza del login) ---------- */
    .tema-esquinas {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 1005;
        pointer-events: none;
    }

    @media (min-width: 992px) {
        .tema-esquinas { display: block; }
    }

    .tema-esquina {
        position: absolute;
        font-size: 38px;
        line-height: 1;
        filter: drop-shadow(0 0 12px var(--tema-acento));
    }

    body.tema-anima .tema-esquina {
        animation: tema-flotar-esq 4s ease-in-out infinite, tema-luz 3.5s infinite;
    }

    .tema-esquina.e1 { top: 16px;    left: 12px; }
    .tema-esquina.e2 { top: 16px;    right: 18px; }
    .tema-esquina.e3 { bottom: 16px; left: 12px; }
    .tema-esquina.e4 { bottom: 16px; right: 18px; }

    body.tema-anima .tema-esquina.e2 { animation-delay: -1s, -1s; }
    body.tema-anima .tema-esquina.e3 { animation-delay: -2s, -2s; }
    body.tema-anima .tema-esquina.e4 { animation-delay: -3s, -3s; }

    @media (max-height: 640px) {
        .tema-esquina.e3 { display: none; }
    }

    /* ---------- Escena de bienvenida (después del login) ---------- */
    .tema-intro {
        position: fixed;
        inset: 0;
        z-index: 3000;
        overflow: hidden;
        background: rgba(8, 4, 18, .5);
        cursor: pointer;
        animation: tema-intro-in .5s ease both;
    }

    .tema-intro.tema-trineo-fondo { background: rgba(4, 14, 28, .5); }
    .tema-intro.saliendo { animation: tema-intro-out .5s ease forwards; }

    .tema-intro-botones {
        position: absolute;
        top: 14px;
        right: 16px;
        z-index: 5;
        display: flex;
        gap: 8px;
    }

    .tema-intro-botones button {
        border: 0;
        border-radius: 20px;
        padding: 6px 14px;
        background: rgba(255, 255, 255, .2);
        color: #fff;
        font-size: 13px;
        backdrop-filter: blur(4px);
        cursor: pointer;
    }

    .tema-intro-botones button:hover { background: rgba(255, 255, 255, .32); }
    .tema-intro-botones button.pulsa { animation: tema-luz 1.4s infinite; }

    .tema-burbuja {
        position: absolute;
        left: 50%;
        bottom: 100%;
        margin-bottom: 8px;
        transform: translateX(-50%);
        min-width: 210px;
        padding: 10px 18px;
        border-radius: 16px;
        background: #fff;
        color: #2a1a3d;
        font-size: 15px;
        line-height: 1.3;
        text-align: center;
        box-shadow: 0 8px 28px rgba(0, 0, 0, .4);
        animation: tema-pop .45s cubic-bezier(.2, 1.4, .4, 1) 2.4s both;
    }

    .tema-burbuja strong {
        display: block;
        font-size: 22px;
        color: var(--tema-oscuro);
    }

    .tema-burbuja::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -8px;
        border: 8px solid transparent;
        border-top-color: #fff;
    }

    /* Bruja */
    .bruja-caja {
        position: absolute;
        left: var(--bruja-x, calc(50% - 60px));
        top: 26vh;
        font-size: 112px;
        line-height: 1;
        animation: tema-bruja-vuelo 3s ease-out both, tema-bob 2.2s ease-in-out 3s infinite;
    }

    /* Imagen propia de la bruja (public/img/bienvenida/halloween.png) */
    .bruja-img {
        display: block;
        width: var(--bruja-ancho, 190px);   /* cambia 190px para hacerla más grande o pequeña */
        max-width: 60vw;
        height: auto;
        filter: drop-shadow(0 8px 18px rgba(0, 0, 0, .5));
    }

    .bruja-caja.con-imagen { --bruja-x: calc(50% - var(--bruja-ancho, 190px) / 2); }

    .bruja-caja .chispa {
        position: absolute;
        font-size: 28px;
        animation: tema-chispa 1.4s ease-in-out infinite;
    }

    .intro-calabaza {
        position: absolute;
        left: calc(50% - 250px);
        bottom: 12vh;
        font-size: 96px;
        line-height: 1;
        animation: tema-asoma 1.1s ease-out 1.2s both;
    }

    .intro-calabaza span {
        display: inline-block;
        filter: drop-shadow(0 0 18px var(--tema-acento));
        animation: tema-flotar 4s ease-in-out infinite, tema-luz 3.5s infinite;
    }

    .intro-arana {
        position: absolute;
        top: 0;
        left: calc(50% + 160px);
        width: 2px;
        transform-origin: top center;
        animation: tema-balanceo 3.2s ease-in-out 1s infinite;
    }

    .intro-arana .hilo {
        display: block;
        width: 1px;
        height: 30vh;
        margin: 0 auto;
        background: rgba(255, 255, 255, .6);
        animation: tema-hilo 1.8s ease-out .7s both;
    }

    .intro-arana .cuerpo {
        display: block;
        margin-left: -22px;
        font-size: 46px;
        line-height: 1;
    }

    /* Papá Noel */
    .trineo {
        position: absolute;
        top: 28vh;
        left: var(--trineo-x, calc(50% - 250px));
        display: flex;
        align-items: flex-end;
        gap: 2px;
        animation: tema-trineo 6.8s ease-in-out both;
    }

    /* Imagen propia del trineo (public/img/bienvenida/navidad.png) */
    .trineo-img {
        display: block;
        height: var(--trineo-alto, 200px);  /* cambia 200px para ajustar el tamaño */
        width: auto;
        max-width: 80vw;
        filter: drop-shadow(0 8px 18px rgba(0, 0, 0, .5));
    }

    .trineo.con-imagen { --trineo-x: calc(50% - 200px); }
    .trineo.con-imagen .tema-burbuja { margin-bottom: 10px; }

    .trineo .carro {
        position: relative;
        font-size: 104px;
        line-height: 1;
    }

    .trineo .santa {
        position: absolute;
        left: 20px;
        top: -38px;
        font-size: 66px;
    }

    .trineo .reno {
        display: inline-block;
        font-size: 78px;
        line-height: 1;
        transform: scaleX(var(--giro-reno, -1));  /* cambia a 1 si los renos se ven al revés */
        animation: tema-bob2 .6s ease-in-out infinite alternate;
    }

    .trineo .tema-burbuja {
        margin-bottom: 50px;
        animation: tema-pop-temp 3s ease-out 2.2s both;
    }

    .tema-intro .tema-capa {
        position: absolute;
        z-index: 0;
    }

    .tema-intro .tema-capa span { opacity: .7; }

    /* Si el sistema pide poco movimiento, la escena se queda quieta */
    .tema-intro.tema-quieta *,
    .tema-intro.tema-quieta *::before,
    .tema-intro.tema-quieta *::after {
        animation: none !important;
    }

    /* ---------- Animaciones ---------- */
    @keyframes tema-flotar {
        0%, 100% { transform: translateY(0) rotate(-4deg); }
        50%      { transform: translateY(-3px) rotate(4deg); }
    }
    @keyframes tema-flotar-esq {
        0%, 100% { transform: translateY(0) rotate(-4deg); }
        50%      { transform: translateY(-10px) rotate(4deg); }
    }
    @keyframes tema-luz {
        0%, 100% { filter: drop-shadow(0 0 10px var(--tema-acento)); }
        45%      { filter: drop-shadow(0 0 24px var(--tema-acento)); }
        50%      { filter: drop-shadow(0 0 8px var(--tema-acento)); }
    }
    @keyframes tema-cae {
        0%   { transform: translate(0, -10vh) rotate(0deg); }
        50%  { transform: translate(26px, 50vh) rotate(90deg); }
        100% { transform: translate(-10px, 112vh) rotate(180deg); }
    }
    @keyframes tema-sube {
        0%   { transform: translate(0, 112vh) scale(.85); }
        50%  { transform: translate(-22px, 50vh) scale(1); }
        100% { transform: translate(10px, -12vh) scale(.85); }
    }
    @keyframes tema-vuela {
        0%   { transform: translate(-10vw, 0); }
        25%  { transform: translate(25vw, -26px); }
        50%  { transform: translate(55vw, 18px); }
        75%  { transform: translate(85vw, -22px); }
        100% { transform: translate(112vw, 0); }
    }
    @keyframes tema-aletear {
        from { transform: scaleX(1) scaleY(1); }
        to   { transform: scaleX(.55) scaleY(1.12); }
    }
    @keyframes tema-intro-in  { from { opacity: 0; } to { opacity: 1; } }
    @keyframes tema-intro-out { from { opacity: 1; } to { opacity: 0; } }
    @keyframes tema-bruja-vuelo {
        from { left: -20vw; top: 70vh; rotate: -14deg; }
        55%  { left: 38vw;  top: 20vh; rotate: 8deg; }
        to   { left: var(--bruja-x, calc(50% - 60px)); top: 26vh; rotate: 0deg; }
    }
    @keyframes tema-bob   { 50% { translate: 0 -12px; } }
    @keyframes tema-bob2  { to  { translate: 0 -8px; } }
    @keyframes tema-chispa {
        0%, 100% { opacity: .2; scale: .7; }
        50%      { opacity: 1;  scale: 1.2; }
    }
    @keyframes tema-pop {
        from { opacity: 0; scale: .5; }
        to   { opacity: 1; scale: 1; }
    }
    @keyframes tema-pop-temp {
        0%   { opacity: 0; scale: .5; }
        12%  { opacity: 1; scale: 1; }
        86%  { opacity: 1; scale: 1; }
        100% { opacity: 0; scale: .9; }
    }
    @keyframes tema-asoma {
        from { opacity: 0; transform: translateY(40vh); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes tema-hilo {
        from { height: 0; }
        to   { height: 30vh; }
    }
    @keyframes tema-balanceo {
        0%, 100% { rotate: -6deg; }
        50%      { rotate: 6deg; }
    }
    @keyframes tema-trineo {
        0%   { transform: translate(-60vw, 40px); }
        32%  { transform: translate(0, 0); }
        62%  { transform: translate(0, -14px); }
        100% { transform: translate(78vw, 30px); }
    }

    @media (max-width: 767.98px) {
        .tema-capa { display: none; }
        .tema-intro .tema-capa { display: block; }
        .bruja-caja   { font-size: 84px; --bruja-x: calc(50% - 44px); }
        .intro-calabaza { font-size: 70px; left: 8%; }
        .intro-arana  { left: 82%; }
        .trineo { --trineo-x: calc(50% - 190px); }
        .trineo-img { height: 130px; }
        .trineo .carro { font-size: 74px; }
        .trineo .santa { font-size: 48px; left: 14px; top: -28px; }
        .trineo .reno  { font-size: 56px; }
    }

    @media print {
        .tema-cinta,
        .tema-capa,
        .tema-esquinas,
        .tema-intro { display: none !important; }
    }
</style>

@if ($datosTema)
<script>
    window.TEMPORADA = @json($datosTema);

    document.addEventListener('DOMContentLoaded', function () {
        var T = window.TEMPORADA;
        if (!T) { return; }

        var body = document.body;
        body.classList.add('tema-activo');
        body.style.setProperty('--tema-acento', T.acento);
        body.style.setProperty('--tema-oscuro', T.acento_oscuro);
        body.style.setProperty('--tema-suave', T.suave);
        body.style.setProperty('--tema-brillo', T.brillo);
        body.style.setProperty('--tema-menu', T.menu);
        body.style.setProperty('--tema-menu-fin', T.menu_fin);

        // ¿Se pueden usar animaciones?
        var reducido = window.matchMedia &&
            window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var animar = !(T.respetar_movimiento && reducido);
        if (animar) { body.classList.add('tema-anima'); }

        function crearParticulas(contenedor, cantidad, modo, lista, extraClase) {
            var capa = document.createElement('div');
            capa.className = 'tema-capa tema-' + modo + (extraClase ? ' ' + extraClase : '');
            capa.setAttribute('aria-hidden', 'true');

            for (var i = 0; i < cantidad; i++) {
                var p = document.createElement('span');
                var texto = lista[i % lista.length];

                if (modo === 'vuela') {
                    var interior = document.createElement('i');
                    interior.textContent = texto;
                    p.appendChild(interior);
                } else {
                    p.textContent = texto;
                }

                var grande = modo === 'vuela';
                p.style.setProperty('--x', ((i * 14 + 6) % 92) + '%');
                p.style.setProperty('--y', (8 + (i * 19) % 62) + '%');
                p.style.setProperty('--tam', (grande ? 38 + (i * 6) % 18 : 18 + (i * 3) % 10) + 'px');
                p.style.setProperty('--dur', ((grande ? 30 : 18) + (i * 5) % 14) + 's');
                p.style.setProperty('--delay', '-' + ((i * 7) % 20) + 's');
                capa.appendChild(p);
            }

            contenedor.appendChild(capa);
        }

        // Emoji junto al logo (menú lateral y barra del móvil)
        ['.sidebar .brand', '.barra-marca'].forEach(function (selector) {
            var el = document.querySelector(selector);
            if (el) {
                var emoji = document.createElement('span');
                emoji.className = 'tema-brand';
                emoji.setAttribute('aria-hidden', 'true');
                emoji.textContent = ' ' + T.emoji;
                el.appendChild(emoji);
            }
        });

        // Aviso discreto arriba del contenido (se puede cerrar)
        var clave = 'tema-cinta-' + T.clave + '-' + new Date().getFullYear();
        var oculto = false;
        try { oculto = localStorage.getItem(clave) === '1'; } catch (e) {}

        var main = document.querySelector('main, .main');
        if (main && !oculto) {
            var cinta = document.createElement('div');
            cinta.className = 'tema-cinta';
            cinta.setAttribute('role', 'status');
            cinta.innerHTML =
                '<span class="tema-cinta-emoji" aria-hidden="true"></span>' +
                '<span class="tema-cinta-texto"></span>' +
                '<button type="button" class="tema-cinta-cerrar" aria-label="Cerrar aviso">&times;</button>';
            cinta.querySelector('.tema-cinta-emoji').textContent = T.emoji;
            cinta.querySelector('.tema-cinta-texto').textContent = T.mensaje;
            cinta.querySelector('button').addEventListener('click', function () {
                cinta.remove();
                try { localStorage.setItem(clave, '1'); } catch (e) {}
            });
            main.insertBefore(cinta, main.firstChild);
        }

        // Partículas de fondo (murciélagos negros en Halloween)
        if (animar && T.particulas && T.particulas.length && window.innerWidth >= 768) {
            crearParticulas(
                body,
                T.modo === 'vuela' ? 4 : 7,
                T.modo,
                T.particulas,
                T.particulas_negras ? 'tema-negras' : ''
            );
        }

        // Detalles flotantes en las 4 esquinas
        if (T.esquinas && T.esquinas.length) {
            var esquinas = document.createElement('div');
            esquinas.className = 'tema-esquinas';
            esquinas.setAttribute('aria-hidden', 'true');

            T.esquinas.slice(0, 4).forEach(function (emoji, i) {
                var e = document.createElement('span');
                e.className = 'tema-esquina e' + (i + 1);
                e.textContent = emoji;
                esquinas.appendChild(e);
            });

            body.appendChild(esquinas);
        }

        /* =====================================================
           Escena de bienvenida (solo justo después de iniciar sesión)
           ===================================================== */
        if (!T.bienvenida || !T.escena) { return; }

        var intro = document.createElement('div');
        var nombre = T.usuario || 'equipo';
        var cerrado = false;
        var temporizador = null;
        var ctx = null;
        var audioEl = null;
        var esperando = false;   // true cuando el navegador bloqueó el sonido automático
        var mudo = false;
        try { mudo = localStorage.getItem('tema-mudo') === '1'; } catch (e) {}

        intro.className = 'tema-intro' +
            (T.escena === 'trineo' ? ' tema-trineo-fondo' : '') +
            (animar ? '' : ' tema-quieta');
        intro.setAttribute('role', 'dialog');
        intro.setAttribute('aria-label', 'Bienvenida de ' + T.nombre);

        var botones =
            '<div class="tema-intro-botones">' +
            (T.sonido ? '<button type="button" class="tema-intro-sonido" aria-label="Sonido"></button>' : '') +
            '<button type="button" class="tema-intro-omitir">Omitir &times;</button>' +
            '</div>';

        var escena = '';
        if (T.escena === 'bruja') {
            escena =
                '<div class="bruja-caja' + (T.imagen ? ' con-imagen' : '') + '">' +
                (T.imagen ? '<img class="bruja-img" alt="">' : '🧙‍♀️') +
                '<span class="chispa" style="left:-20px;top:34px">✨</span>' +
                '<span class="chispa" style="left:104px;top:74px;animation-delay:-.6s">✨</span>' +
                '<div class="tema-burbuja"><strong class="b1"></strong><span class="b2"></span></div>' +
                '</div>' +
                '<div class="intro-calabaza"><span>🎃</span></div>' +
                '<div class="intro-arana"><span class="hilo"></span><span class="cuerpo">🕷️</span></div>';
        } else if (T.escena === 'trineo' && T.imagen) {
            escena =
                '<div class="trineo con-imagen"><div class="carro">' +
                '<img class="trineo-img" alt="">' +
                '<div class="tema-burbuja"><strong class="b1"></strong><span class="b2"></span></div>' +
                '</div></div>';
        } else if (T.escena === 'trineo') {
            escena =
                '<div class="trineo">' +
                '<div class="carro">🛷<span class="santa">🎅</span>' +
                '<div class="tema-burbuja"><strong class="b1"></strong><span class="b2"></span></div>' +
                '</div>' +
                '<span class="reno">🦌</span>' +
                '<span class="reno" style="animation-delay:-.3s">🦌</span>' +
                '</div>';
        }

        intro.innerHTML = botones + escena;
        var imagenPropia = intro.querySelector('.bruja-img, .trineo-img');
        if (imagenPropia) {
            imagenPropia.addEventListener('error', function () { imagenPropia.style.display = 'none'; });
            imagenPropia.src = T.imagen;
        }

        intro.querySelector('.b1').textContent = T.frase;
        intro.querySelector('.b2').textContent = (T.subfrase || '').replace(':nombre', nombre);

        if (T.escena === 'trineo' && animar) {
            crearParticulas(intro, 12, 'cae', ['❄️'], '');
        }

        document.body.appendChild(intro);

        /* ---------- Sonido ---------- */
        function detener() {
            try { if (ctx) { ctx.close(); ctx = null; } } catch (e) {}
            try { if (audioEl) { audioEl.pause(); audioEl = null; } } catch (e) {}
        }

        function cacareoBruja(c, t0, destino) {
            for (var i = 0; i < 8; i++) {
                var t = t0 + i * 0.17;
                var f0 = 640 - i * 30;

                var osc = c.createOscillator();
                osc.type = 'sawtooth';
                osc.frequency.setValueAtTime(f0, t);
                osc.frequency.exponentialRampToValueAtTime(f0 * 0.6, t + 0.14);

                var lfo = c.createOscillator();
                var lfoGanancia = c.createGain();
                lfo.frequency.value = 11;
                lfoGanancia.gain.value = 22;
                lfo.connect(lfoGanancia);
                lfoGanancia.connect(osc.frequency);

                var filtro = c.createBiquadFilter();
                filtro.type = 'bandpass';
                filtro.frequency.value = 1150;
                filtro.Q.value = 2.4;

                var g = c.createGain();
                g.gain.setValueAtTime(0.0001, t);
                g.gain.exponentialRampToValueAtTime(1, t + 0.02);
                g.gain.exponentialRampToValueAtTime(0.0001, t + 0.15);

                osc.connect(filtro);
                filtro.connect(g);
                g.connect(destino);

                osc.start(t); osc.stop(t + 0.16);
                lfo.start(t); lfo.stop(t + 0.16);
            }
        }

        function joJoJo(c, t0, destino) {
            // Campanitas del trineo
            for (var k = 0; k < 12; k++) {
                var tc = t0 + k * 0.1 + Math.random() * 0.04;
                [2093, 3136].forEach(function (frec, idx) {
                    var o = c.createOscillator();
                    var gc = c.createGain();
                    o.type = 'sine';
                    o.frequency.value = frec * (1 + Math.random() * 0.02);
                    gc.gain.setValueAtTime(0.0001, tc);
                    gc.gain.exponentialRampToValueAtTime(idx ? 0.2 : 0.4, tc + 0.01);
                    gc.gain.exponentialRampToValueAtTime(0.0001, tc + 0.35);
                    o.connect(gc);
                    gc.connect(destino);
                    o.start(tc); o.stop(tc + 0.4);
                });
            }

            // "Jo, jo, jo" grave
            for (var i = 0; i < 3; i++) {
                var t = t0 + 2.3 + i * 0.45;

                var osc = c.createOscillator();
                osc.type = 'sawtooth';
                osc.frequency.setValueAtTime(150, t);
                osc.frequency.exponentialRampToValueAtTime(100, t + 0.3);

                var grave = c.createBiquadFilter();
                grave.type = 'lowpass';
                grave.frequency.value = 650;

                var g = c.createGain();
                g.gain.setValueAtTime(0.0001, t);
                g.gain.exponentialRampToValueAtTime(1.6, t + 0.04);
                g.gain.exponentialRampToValueAtTime(0.0001, t + 0.36);

                osc.connect(grave);
                grave.connect(g);
                g.connect(destino);
                osc.start(t); osc.stop(t + 0.4);
            }
        }

        function sonar() {
            if (!T.sonido || mudo || cerrado) { return; }

            try {
                // Si existe public/audio/bienvenida-{clave}.mp3 se usa ese archivo
                if (T.audio) {
                    audioEl = new Audio(T.audio);
                    audioEl.volume = 0.7;
                    audioEl.addEventListener('loadedmetadata', function () {
                        if (cerrado || !isFinite(audioEl.duration)) { return; }
                        var hastaQueTermine = Math.min(audioEl.duration * 1000 + 800, 15000);
                        if (hastaQueTermine > duracionBase) {
                            clearTimeout(temporizador);
                            temporizador = setTimeout(cerrar, hastaQueTermine);
                        }
                    });
                    audioEl.play().catch(function () { pedirToque(); });
                    return;
                }

                var AC = window.AudioContext || window.webkitAudioContext;
                if (!AC) { return; }

                ctx = new AC();
                var master = ctx.createGain();
                master.gain.value = 0.28;
                master.connect(ctx.destination);

                var t0 = ctx.currentTime + 0.15;
                if (T.escena === 'trineo') { joJoJo(ctx, t0, master); }
                else { cacareoBruja(ctx, t0, master); }

                if (ctx.state === 'suspended') { ctx.resume().catch(function () {}); }
                setTimeout(function () {
                    if (ctx && ctx.state !== 'running') { pedirToque(); }
                }, 350);
            } catch (e) {}
        }

        var botonSonido = intro.querySelector('.tema-intro-sonido');

        function pedirToque() {
            esperando = true;
            if (botonSonido) {
                botonSonido.textContent = '🔊 Toca para escuchar';
                botonSonido.classList.add('pulsa');
            }
        }

        if (botonSonido) {
            botonSonido.textContent = mudo ? '🔇' : '🔊';

            botonSonido.addEventListener('click', function (e) {
                e.stopPropagation();

                if (esperando) {
                    esperando = false;
                    if (audioEl) { audioEl.play().catch(function () {}); }
                    else if (ctx) { ctx.resume(); }
                    botonSonido.textContent = '🔊';
                    botonSonido.classList.remove('pulsa');
                    return;
                }

                mudo = !mudo;
                try { localStorage.setItem('tema-mudo', mudo ? '1' : '0'); } catch (err) {}
                botonSonido.classList.remove('pulsa');

                if (mudo) {
                    detener();
                    botonSonido.textContent = '🔇';
                } else {
                    botonSonido.textContent = '🔊';
                    sonar();
                }
            });
        }

        /* ---------- Cerrar la escena ---------- */
        function cerrar() {
            if (cerrado) { return; }
            cerrado = true;
            clearTimeout(temporizador);
            detener();
            intro.classList.add('saliendo');
            setTimeout(function () { intro.remove(); }, 520);
        }

        intro.addEventListener('click', cerrar);
        intro.querySelector('.tema-intro-omitir').addEventListener('click', function (e) {
            e.stopPropagation();
            cerrar();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { cerrar(); }
        });

        var duracionBase = animar ? (T.escena === 'trineo' ? 7600 : 7200) : 4500;
        temporizador = setTimeout(cerrar, duracionBase);

        sonar();
    });
</script>
@endif