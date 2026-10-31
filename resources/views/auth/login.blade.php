<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión | TechStock</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Creepster&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --fondo: #12081f;
            --morado: #2b1148;
            --naranja: #ff7a1a;
            --naranja-claro: #ffa24d;
            --texto: #f3e9ff;
            --suave: #b9a6d6;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--fondo);
            color: var(--texto);
            font-family: "Segoe UI", Arial, sans-serif;
            overflow-x: hidden;
        }

        .login-wrap {
            min-height: 100vh;
            display: flex;
        }

        /* ---------- Panel izquierdo ---------- */
        .login-brand {
            position: relative;
            flex: 1 1 45%;
            overflow: hidden;
            background:
                radial-gradient(ellipse at 50% 110%, #5a2a00 0%, transparent 55%),
                linear-gradient(180deg, #1a0b2e 0%, #2b1148 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px;
        }

        .brand-content {
            position: relative;
            z-index: 2;
        }

        .calabaza {
            display: inline-block;
            font-size: 84px;
            line-height: 1;
            cursor: pointer;
            user-select: none;
            filter: drop-shadow(0 0 18px var(--naranja));
            animation: flotar 4s ease-in-out infinite, parpadeo-luz 3.5s infinite;
        }

        .calabaza.salto { animation: salto .6s ease-out; }

        .brand-content h1 {
            font-family: "Creepster", "Segoe UI", cursive;
            font-size: 56px;
            letter-spacing: 2px;
            margin: 8px 0 6px;
        }

        .brand-content h1 span {
            color: var(--naranja);
            text-shadow: 0 0 14px rgba(255, 122, 26, .7);
            animation: parpadeo 4s infinite;
        }

        .brand-content p {
            color: var(--suave);
            max-width: 290px;
            margin: 0 auto;
        }

        .luna {
            position: absolute;
            top: 9%;
            right: 12%;
            width: 92px;
            height: 92px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, #fff9de, #f6d56b 60%, #c9a227);
            box-shadow: 0 0 40px 10px rgba(246, 213, 107, .35);
            animation: latido 5s ease-in-out infinite;
            z-index: 1;
        }

        .fantasma {
            position: absolute;
            left: 12%;
            top: 24%;
            font-size: 52px;
            z-index: 2;
            filter: drop-shadow(0 0 12px rgba(255, 255, 255, .6));
            animation: fantasma 8s ease-in-out infinite;
        }

        .niebla {
            position: absolute;
            left: -20%;
            bottom: -50px;
            width: 140%;
            height: 190px;
            background: radial-gradient(ellipse at center, rgba(255, 255, 255, .16), transparent 70%);
            filter: blur(18px);
            animation: niebla 16s ease-in-out infinite alternate;
            z-index: 1;
        }

        .niebla.dos {
            bottom: -80px;
            opacity: .7;
            animation-duration: 22s;
            animation-direction: alternate-reverse;
        }

        /* ---------- Panel derecho ---------- */
        .login-form-side {
            position: relative;
            flex: 1 1 55%;
            display: grid;
            place-items: center;
            padding: 30px 20px;
            background: radial-gradient(ellipse at 50% 0%, #2a1346 0%, #12081f 70%);
        }

        .login-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 400px;
            background: rgba(32, 15, 54, .88);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 122, 26, .45);
            border-radius: 14px;
            padding: 34px 32px 32px;
            box-shadow: 0 0 28px rgba(255, 122, 26, .22), 0 12px 40px rgba(0, 0, 0, .5);
            animation: aparecer .9s cubic-bezier(.2, .8, .2, 1) both,
                       brillo 4s ease-in-out 1s infinite;
        }

        .login-card.shake {
            animation: aparecer .9s both, temblor .5s .9s;
        }

        .login-card h2 {
            font-family: "Creepster", "Segoe UI", cursive;
            font-size: 38px;
            letter-spacing: 1.5px;
            color: var(--naranja);
            text-shadow: 0 0 12px rgba(255, 122, 26, .55);
            margin-bottom: 4px;
            animation: parpadeo 5s infinite;
        }

        .login-card .sub { color: var(--suave); }

        .form-label { color: var(--texto); }

        .form-control {
            background: #241338;
            border: 1px solid #4a2a6e;
            color: #fff;
            transition: border-color .25s, box-shadow .25s;
        }

        .form-control::placeholder { color: #8a76a8; }

        .form-control:focus {
            background: #2b1848;
            color: #fff;
            border-color: var(--naranja);
            box-shadow: 0 0 0 .2rem rgba(255, 122, 26, .25);
        }

        /* Evita el fondo celeste del autocompletado del navegador */
        .form-control:-webkit-autofill {
            -webkit-text-fill-color: #fff;
            -webkit-box-shadow: 0 0 0 1000px #241338 inset;
            caret-color: #fff;
        }

        .btn-ojo {
            background: #241338;
            border: 1px solid #4a2a6e;
            color: var(--suave);
        }

        .btn-ojo:hover {
            background: #3a2060;
            color: #fff;
            border-color: var(--naranja);
        }

        .form-check-input {
            background-color: #241338;
            border-color: #4a2a6e;
        }

        .form-check-input:checked {
            background-color: var(--naranja);
            border-color: var(--naranja);
        }

        .form-check-label { color: var(--suave); }

        .btn-embrujado {
            background: linear-gradient(135deg, var(--naranja), #ff9b3d);
            border: 0;
            color: #1a0b2e;
            font-weight: 700;
            letter-spacing: .3px;
            transition: transform .2s, box-shadow .2s;
            animation: pulso 2.6s ease-in-out infinite;
        }

        .btn-embrujado:hover {
            color: #1a0b2e;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 0 22px rgba(255, 122, 26, .75);
        }

        .btn-embrujado:active { transform: scale(.98); }

        .invalid-feedback { color: #ff8a8a; }

        /* ---------- Araña colgante ---------- */
        .arana {
            position: absolute;
            top: -125px;
            right: 38px;
            width: 2px;
            z-index: 3;
            transform-origin: top center;
            animation: balanceo 3.2s ease-in-out infinite;
            pointer-events: none;
        }

        .arana .hilo {
            display: block;
            width: 1px;
            margin: 0 auto;
            background: rgba(255, 255, 255, .55);
            animation: bajar 6s ease-in-out infinite;
        }

        .arana .cuerpo {
            display: block;
            font-size: 30px;
            line-height: 1;
            margin-left: -14px;
            margin-top: -4px;
        }

        /* ---------- Cielo: estrellas y murciélagos ---------- */
        .cielo {
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
        }

        .estrella {
            position: absolute;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: #fff;
            animation: titilar 3s ease-in-out infinite;
        }

        .murcielago {
            position: absolute;
            left: 0;
            top: var(--top);
            font-size: var(--tam);
            animation: volar var(--dur) linear var(--delay) infinite;
        }

        .murcielago i {
            display: inline-block;
            font-style: normal;
            filter: drop-shadow(0 0 6px rgba(0, 0, 0, .8));
            animation: aletear .3s ease-in-out infinite alternate;
        }

        /* ---------- Animaciones ---------- */
        @keyframes flotar {
            0%, 100% { transform: translateY(0) rotate(-3deg); }
            50%      { transform: translateY(-14px) rotate(3deg); }
        }
        @keyframes salto {
            0%   { transform: translateY(0) scale(1); }
            35%  { transform: translateY(-36px) scale(1.18) rotate(12deg); }
            70%  { transform: translateY(0) scale(.92); }
            100% { transform: translateY(0) scale(1); }
        }
        @keyframes parpadeo-luz {
            0%, 100% { filter: drop-shadow(0 0 18px var(--naranja)); }
            45%      { filter: drop-shadow(0 0 30px #ffb066); }
            50%      { filter: drop-shadow(0 0 10px var(--naranja)); }
        }
        @keyframes parpadeo {
            0%, 18%, 22%, 25%, 53%, 57%, 100% { opacity: 1; }
            20%, 24%, 55%                     { opacity: .45; }
        }
        @keyframes latido {
            0%, 100% { box-shadow: 0 0 40px 10px rgba(246, 213, 107, .30); }
            50%      { box-shadow: 0 0 60px 18px rgba(246, 213, 107, .48); }
        }
        @keyframes fantasma {
            0%   { transform: translate(0, 0);       opacity: .9; }
            25%  { transform: translate(34px, -26px); opacity: .45; }
            50%  { transform: translate(8px, -50px);  opacity: .9; }
            75%  { transform: translate(-26px, -22px); opacity: .5; }
            100% { transform: translate(0, 0);       opacity: .9; }
        }
        @keyframes niebla {
            from { transform: translateX(-8%); }
            to   { transform: translateX(8%); }
        }
        @keyframes aparecer {
            from { opacity: 0; transform: translateY(40px) scale(.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes brillo {
            0%, 100% { box-shadow: 0 0 22px rgba(255, 122, 26, .18), 0 12px 40px rgba(0, 0, 0, .5); }
            50%      { box-shadow: 0 0 38px rgba(255, 122, 26, .38), 0 12px 40px rgba(0, 0, 0, .5); }
        }
        @keyframes temblor {
            0%, 100% { transform: translateX(0); }
            15%, 45%, 75% { transform: translateX(-10px); }
            30%, 60%, 90% { transform: translateX(10px); }
        }
        @keyframes pulso {
            0%, 100% { box-shadow: 0 0 0 0 rgba(255, 122, 26, .5); }
            50%      { box-shadow: 0 0 0 10px rgba(255, 122, 26, 0); }
        }
        @keyframes balanceo {
            0%, 100% { transform: rotate(-7deg); }
            50%      { transform: rotate(7deg); }
        }
        @keyframes bajar {
            0%, 100% { height: 60px; }
            50%      { height: 112px; }
        }
        @keyframes titilar {
            0%, 100% { opacity: .15; transform: scale(.8); }
            50%      { opacity: .95; transform: scale(1.3); }
        }
        @keyframes volar {
            0%   { transform: translate(-12vw, 0); }
            25%  { transform: translate(25vw, -34px); }
            50%  { transform: translate(55vw, 22px); }
            75%  { transform: translate(85vw, -28px); }
            100% { transform: translate(112vw, 0); }
        }
        @keyframes aletear {
            from { transform: scaleX(1) scaleY(1); }
            to   { transform: scaleX(.55) scaleY(1.12); }
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 800px) {
            .login-wrap { flex-direction: column; }
            .login-brand { flex: 0 0 auto; padding: 28px 20px 36px; }
            .calabaza { font-size: 56px; }
            .brand-content h1 { font-size: 40px; }
            .luna { width: 56px; height: 56px; top: 12%; right: 8%; }
            .fantasma { font-size: 36px; left: 8%; top: 18%; }
            .login-form-side { padding-top: 70px; }
            .arana { right: 24px; }
        }

    </style>
</head>

<body>

<div class="login-wrap">

    <div class="login-brand">
        <div class="luna"></div>
        <div class="fantasma">👻</div>

        <div class="brand-content">
            <span class="calabaza" id="calabaza" title="¡Tócame!">🎃</span>
            <h1>Tech<span>Stock</span></h1>
            <p>Sistema de Inventario de Accesorios Informáticos</p>
        </div>

        <div class="niebla"></div>
        <div class="niebla dos"></div>
    </div>

    <div class="login-form-side">
        <div class="login-card {{ $errors->any() ? 'shake' : '' }}">

            <div class="arana">
                <span class="hilo"></span>
                <span class="cuerpo">🕷️</span>
            </div>

            <h2>Iniciar sesión</h2>
            <p class="sub mb-4">Ingresa tus credenciales para continuar.</p>

            <form action="{{ route('login.store') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="admin@techstock.com"
                           autocomplete="username"
                           autofocus
                           class="form-control @error('email') is-invalid @enderror"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Contraseña</label>
                    <div class="input-group">
                        <input type="password"
                               id="password"
                               name="password"
                               placeholder="••••••••"
                               autocomplete="current-password"
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        <button type="button"
                                class="btn btn-ojo"
                                id="togglePassword"
                                aria-label="Mostrar u ocultar contraseña">
                            <i class="bi bi-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input"
                           type="checkbox"
                           id="remember"
                           name="remember"
                           value="1"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>

                <button type="submit" class="btn btn-embrujado w-100 py-2">
                    🎃 Ingresar
                </button>
            </form>
        </div>
    </div>

</div>

{{-- Estrellas y murciélagos (decorativo) --}}
<div class="cielo" aria-hidden="true">
    @for ($i = 0; $i < 28; $i++)
        <span class="estrella"
              style="left: {{ ($i * 37) % 100 }}%;
                     top: {{ ($i * 53) % 70 }}%;
                     animation-delay: {{ ($i % 7) * 0.45 }}s;"></span>
    @endfor

    <span class="murcielago" style="--top: 10%; --tam: 30px; --dur: 15s; --delay: -2s;"><i>🦇</i></span>
    <span class="murcielago" style="--top: 26%; --tam: 22px; --dur: 20s; --delay: -9s;"><i>🦇</i></span>
    <span class="murcielago" style="--top: 52%; --tam: 26px; --dur: 17s; --delay: -5s;"><i>🦇</i></span>
    <span class="murcielago" style="--top: 70%; --tam: 20px; --dur: 23s; --delay: -14s;"><i>🦇</i></span>
    <span class="murcielago" style="--top: 38%; --tam: 18px; --dur: 26s; --delay: -18s;"><i>🦇</i></span>
</div>

<script>
    // Mostrar / ocultar contraseña
    const campo = document.getElementById('password');
    const boton = document.getElementById('togglePassword');

    boton.addEventListener('click', function () {
        const visible = campo.type === 'text';
        campo.type = visible ? 'password' : 'text';
        boton.innerHTML = visible
            ? '<i class="bi bi-eye"></i>'
            : '<i class="bi bi-eye-slash"></i>';
    });

    // La calabaza salta al hacerle clic
    const calabaza = document.getElementById('calabaza');

    calabaza.addEventListener('click', function () {
        calabaza.classList.remove('salto');
        void calabaza.offsetWidth;          // reinicia la animación
        calabaza.classList.add('salto');
    });

    calabaza.addEventListener('animationend', function (e) {
        if (e.animationName === 'salto') {
            calabaza.classList.remove('salto');
        }
    });
</script>
</body>
</html>