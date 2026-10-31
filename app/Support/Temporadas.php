<?php

namespace App\Support;

use Carbon\Carbon;

class Temporadas
{
    /**
     * Devuelve la temporada que corresponde a hoy, o null si no hay ninguna.
     */
    public static function actual(?Carbon $hoy = null): ?array
    {
        if (! config('temporadas.activo', true)) {
            return null;
        }

        $catalogo = self::catalogo();

        // 1) Temporada forzada desde .env
        $forzada = config('temporadas.forzada');
        if ($forzada && isset($catalogo[$forzada])) {
            return self::formatear($forzada, $catalogo[$forzada]);
        }

        // 2) Vista previa en local: http://127.0.0.1:8000/?tema=navidad
        if (app()->environment('local')) {
            $prueba = request()->query('tema');
            if ($prueba && isset($catalogo[$prueba])) {
                return self::formatear($prueba, $catalogo[$prueba]);
            }
        }

        // 3) Por fecha
        $hoy = ($hoy ?? now())->copy()->startOfDay();

        foreach (self::ventanas($hoy->year) as [$clave, $inicio, $fin]) {
            if ($hoy->betweenIncluded($inicio, $fin)) {
                return self::formatear($clave, $catalogo[$clave]);
            }
        }

        return null;
    }

    /**
     * ¿Hay que mostrar la escena de bienvenida en esta página?
     * Se activa justo después de iniciar sesión (lo marca AuthController).
     * En local también se puede ver con:  ?tema=navidad&bienvenida=1
     */
    public static function mostrarBienvenida(): bool
    {
        if (! config('temporadas.bienvenida', true)) {
            return false;
        }

        if (session()->has('bienvenida')) {
            return true;
        }

        return app()->environment('local') && request()->boolean('bienvenida');
    }

    /**
     * Fechas de cada temporada (se repiten todos los años).
     * Para agregar una nueva: añade su ficha en catalogo() y una línea aquí.
     */
    private static function ventanas(int $anio): array
    {
        $d = fn (int $mes, int $dia, ?int $a = null) => Carbon::create($a ?? $anio, $mes, $dia)->startOfDay();

        // Fechas móviles: 2.º domingo de mayo, 3.er domingo de junio y 3.er domingo de julio
        $madre = Carbon::create($anio, 5, 1)->nthOfMonth(2, Carbon::SUNDAY)->startOfDay();
        $padre = Carbon::create($anio, 6, 1)->nthOfMonth(3, Carbon::SUNDAY)->startOfDay();
        $pollo = Carbon::create($anio, 7, 1)->nthOfMonth(3, Carbon::SUNDAY)->startOfDay();

        // Semana Santa: del Domingo de Ramos al Domingo de Resurrección
        $pascua = self::pascua($anio);

        // Si dos fechas coinciden, gana la que aparece primero en esta lista
        return [
            ['ano_nuevo',        $d(12, 27, $anio - 1), $d(1, 3)],
            ['san_valentin',     $d(2, 10),             $d(2, 14)],
            ['semana_santa',     $pascua->copy()->subDays(7), $pascua],
            ['dia_trabajo',      $d(4, 28),             $d(5, 1)],
            ['dia_madre',        $madre->copy()->subDays(6), $madre],
            ['dia_padre',        $padre->copy()->subDays(6), $padre],
            ['dia_maestro',      $d(7, 4),              $d(7, 6)],
            ['dia_pollo_brasa',  $pollo,                $pollo],
            ['fiestas_patrias',  $d(7, 20),             $d(7, 31)],
            ['santa_rosa',       $d(8, 29),             $d(8, 30)],
            ['angamos',          $d(10, 7),             $d(10, 8)],
            ['halloween',        $d(10, 24),            $d(10, 31)],
            ['todos_los_santos', $d(11, 1),             $d(11, 1)],
            ['inmaculada',       $d(12, 8),             $d(12, 8)],
            ['navidad',          $d(12, 1),             $d(12, 26)],
            ['ano_nuevo',        $d(12, 27),            $d(1, 3, $anio + 1)],
        ];
    }

    /**
     * Domingo de Pascua (algoritmo gregoriano anónimo).
     */
    private static function pascua(int $anio): Carbon
    {
        $a = $anio % 19;
        $b = intdiv($anio, 100);
        $c = $anio % 100;
        $d = intdiv($b, 4);
        $e = $b % 4;
        $f = intdiv($b + 8, 25);
        $g = intdiv($b - $f + 1, 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $mes = intdiv($h + $l - 7 * $m + 114, 31);
        $dia = (($h + $l - 7 * $m + 114) % 31) + 1;

        return Carbon::create($anio, $mes, $dia)->startOfDay();
    }

    /**
     * Ficha de cada temporada.
     * modo: cae | sube | vuela  (movimiento de las partículas suaves del fondo)
     * particulas: [] = sin partículas
     * esquinas: emojis flotantes en las 4 esquinas (arriba-izq, arriba-der, abajo-izq, abajo-der)
     * escena: escena de bienvenida tras iniciar sesión (bruja | trineo | null)
     */
    private static function catalogo(): array
    {
        return [
            'halloween' => [
                'nombre'        => 'Halloween',
                'mensaje'       => 'Feliz Halloween, equipo. Que el inventario no dé sustos.',
                'emoji'         => '🎃',
                'acento'        => '#e8710a',
                'acento_oscuro' => '#c25e08',
                'menu'          => '#1a0b2e',   // color del menú lateral (arriba)
                'menu_fin'      => '#2b1148',   // color del menú lateral (abajo)
                'particulas'    => ['🦇'],
                'modo'          => 'vuela',
                'particulas_negras' => true,
                'esquinas'      => ['🍬', '🍭', '🍭', '🍬'],
                'escena'        => 'bruja',   // bruja | trineo | null
                'frase'         => '¡Muajajajá!',
                'subfrase'      => 'Bienvenido, :nombre',
            ],
            'todos_los_santos' => [
                'nombre'        => 'Día de Todos los Santos',
                'mensaje'       => 'Hoy es feriado en el Perú: Día de Todos los Santos.',
                'emoji'         => '🕯️',
                'acento'        => '#6f5b9e',
                'acento_oscuro' => '#574784',
                'menu'          => '#241a3a',   // color del menú lateral (arriba)
                'menu_fin'      => '#3a2c5c',   // color del menú lateral (abajo)
                'particulas'    => [],
                'modo'          => 'cae',
                'particulas_negras' => false,
                'esquinas'      => [],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
            'navidad' => [
                'nombre'        => 'Navidad',
                'mensaje'       => 'Felices fiestas. Gracias por un año de buen trabajo.',
                'emoji'         => '🎄',
                'acento'        => '#1f8a4c',
                'acento_oscuro' => '#176a3a',
                'menu'          => '#0e3b25',   // color del menú lateral (arriba)
                'menu_fin'      => '#14532d',   // color del menú lateral (abajo)
                'particulas'    => ['❄️'],
                'modo'          => 'cae',
                'particulas_negras' => false,
                'esquinas'      => ['🎁', '⭐', '⭐', '🎁'],
                'escena'        => 'trineo',   // bruja | trineo | null
                'frase'         => '¡Jo, jo, jo!',
                'subfrase'      => '¡Felices fiestas, :nombre!',
            ],
            'ano_nuevo' => [
                'nombre'        => 'Año Nuevo',
                'mensaje'       => 'Feliz Año Nuevo. Que este año traiga muy buenos resultados.',
                'emoji'         => '🎆',
                'acento'        => '#b8860b',
                'acento_oscuro' => '#8f6808',
                'menu'          => '#1d1b2f',   // color del menú lateral (arriba)
                'menu_fin'      => '#3a3320',   // color del menú lateral (abajo)
                'particulas'    => ['✨'],
                'modo'          => 'sube',
                'particulas_negras' => false,
                'esquinas'      => ['🎆', '✨', '✨', '🎆'],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
            'san_valentin' => [
                'nombre'        => 'San Valentín',
                'mensaje'       => 'Feliz Día del Amor y la Amistad.',
                'emoji'         => '❤️',
                'acento'        => '#d6336c',
                'acento_oscuro' => '#b0285a',
                'menu'          => '#4a1230',   // color del menú lateral (arriba)
                'menu_fin'      => '#6b1a45',   // color del menú lateral (abajo)
                'particulas'    => ['❤️'],
                'modo'          => 'sube',
                'particulas_negras' => false,
                'esquinas'      => ['💝', '💌', '💌', '💝'],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
            'semana_santa' => [
                'nombre'        => 'Semana Santa',
                'mensaje'       => 'Semana Santa. El Jueves y el Viernes Santo son feriados en el Perú.',
                'emoji'         => '✝️',
                'acento'        => '#5b2a86',
                'acento_oscuro' => '#45206a',
                'menu'          => '#2a1442',   // color del menú lateral (arriba)
                'menu_fin'      => '#3b1d5e',   // color del menú lateral (abajo)
                'particulas'    => [],
                'modo'          => 'cae',
                'particulas_negras' => false,
                'esquinas'      => [],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
            'dia_trabajo' => [
                'nombre'        => 'Día del Trabajo',
                'mensaje'       => 'Feliz Día del Trabajo a todo el equipo.',
                'emoji'         => '🛠️',
                'acento'        => '#c0392b',
                'acento_oscuro' => '#9c2e22',
                'menu'          => '#3a1410',   // color del menú lateral (arriba)
                'menu_fin'      => '#5a1d16',   // color del menú lateral (abajo)
                'particulas'    => [],
                'modo'          => 'cae',
                'particulas_negras' => false,
                'esquinas'      => [],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
            'dia_madre' => [
                'nombre'        => 'Día de la Madre',
                'mensaje'       => 'Feliz Día de la Madre.',
                'emoji'         => '🌸',
                'acento'        => '#e0457b',
                'acento_oscuro' => '#bd3363',
                'menu'          => '#4a1a33',   // color del menú lateral (arriba)
                'menu_fin'      => '#6b2548',   // color del menú lateral (abajo)
                'particulas'    => ['🌸'],
                'modo'          => 'cae',
                'particulas_negras' => false,
                'esquinas'      => ['🌸', '🌷', '🌷', '🌸'],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
            'dia_padre' => [
                'nombre'        => 'Día del Padre',
                'mensaje'       => 'Feliz Día del Padre.',
                'emoji'         => '👔',
                'acento'        => '#3b5bdb',
                'acento_oscuro' => '#2f49b3',
                'menu'          => '#17224d',   // color del menú lateral (arriba)
                'menu_fin'      => '#233470',   // color del menú lateral (abajo)
                'particulas'    => [],
                'modo'          => 'cae',
                'particulas_negras' => false,
                'esquinas'      => [],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
            'dia_maestro' => [
                'nombre'        => 'Día del Maestro',
                'mensaje'       => 'Feliz Día del Maestro.',
                'emoji'         => '📚',
                'acento'        => '#7048e8',
                'acento_oscuro' => '#5a3bc0',
                'menu'          => '#25194f',   // color del menú lateral (arriba)
                'menu_fin'      => '#3a2a78',   // color del menú lateral (abajo)
                'particulas'    => [],
                'modo'          => 'cae',
                'particulas_negras' => false,
                'esquinas'      => [],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
            'dia_pollo_brasa' => [
                'nombre'        => 'Día del Pollo a la Brasa',
                'mensaje'       => 'Hoy es el Día del Pollo a la Brasa. ¡Buen provecho!',
                'emoji'         => '🍗',
                'acento'        => '#c2410c',
                'acento_oscuro' => '#9a3412',
                'menu'          => '#3d1a0a',   // color del menú lateral (arriba)
                'menu_fin'      => '#6a2a0c',   // color del menú lateral (abajo)
                'particulas'    => ['🍗'],
                'modo'          => 'cae',
                'particulas_negras' => false,
                'esquinas'      => [],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
            'fiestas_patrias' => [
                'nombre'        => 'Fiestas Patrias',
                'mensaje'       => 'Felices Fiestas Patrias.',
                'emoji'         => '🎉',
                'acento'        => '#d91023',
                'acento_oscuro' => '#b00d1c',
                'menu'          => '#4a0d14',   // color del menú lateral (arriba)
                'menu_fin'      => '#7a1420',   // color del menú lateral (abajo)
                'particulas'    => ['🎊', '✨'],
                'modo'          => 'sube',
                'particulas_negras' => false,
                'esquinas'      => ['🎊', '🎉', '🎉', '🎊'],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
            'santa_rosa' => [
                'nombre'        => 'Santa Rosa de Lima',
                'mensaje'       => 'Santa Rosa de Lima, patrona de América. El 30 de agosto es feriado en el Perú.',
                'emoji'         => '🌹',
                'acento'        => '#b83280',
                'acento_oscuro' => '#92276a',
                'menu'          => '#44133a',   // color del menú lateral (arriba)
                'menu_fin'      => '#6a1d5a',   // color del menú lateral (abajo)
                'particulas'    => [],
                'modo'          => 'cae',
                'particulas_negras' => false,
                'esquinas'      => [],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
            'angamos' => [
                'nombre'        => 'Combate de Angamos',
                'mensaje'       => 'Combate de Angamos (8 de octubre): feriado en el Perú y Día de la Marina de Guerra.',
                'emoji'         => '⚓',
                'acento'        => '#1d4e89',
                'acento_oscuro' => '#163b69',
                'menu'          => '#0b2545',   // color del menú lateral (arriba)
                'menu_fin'      => '#13396a',   // color del menú lateral (abajo)
                'particulas'    => [],
                'modo'          => 'cae',
                'particulas_negras' => false,
                'esquinas'      => [],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
            'inmaculada' => [
                'nombre'        => 'Inmaculada Concepción',
                'mensaje'       => 'Hoy es feriado en el Perú: Inmaculada Concepción.',
                'emoji'         => '🌟',
                'acento'        => '#3d6fd8',
                'acento_oscuro' => '#3058ab',
                'menu'          => '#14305c',   // color del menú lateral (arriba)
                'menu_fin'      => '#1f4a8f',   // color del menú lateral (abajo)
                'particulas'    => [],
                'modo'          => 'cae',
                'particulas_negras' => false,
                'esquinas'      => [],
                'escena'        => null,   // bruja | trineo | null
                'frase'         => '',
                'subfrase'      => '',
            ],
        ];
    }

    /**
     * Busca un archivo en /public con cualquiera de las extensiones dadas.
     * Devuelve su URL (con la fecha de modificación para evitar caché) o null.
     */
    private static function archivo(string $base, array $extensiones): ?string
    {
        foreach ($extensiones as $ext) {
            $ruta = public_path("{$base}.{$ext}");

            if (is_file($ruta)) {
                return asset("{$base}.{$ext}") . '?v=' . filemtime($ruta);
            }
        }

        return null;
    }

    private static function formatear(string $clave, array $ficha): array
    {
        [$r, $g, $b] = sscanf($ficha['acento'], '#%02x%02x%02x');

        // Archivos propios (opcionales). Se detectan solos si existen:
        //   public/audio/bienvenida-{clave}.mp3   (también .ogg .wav .m4a)
        //   public/img/bienvenida/{clave}.png     (también .webp .gif .svg .jpg)
        $audio  = self::archivo("audio/bienvenida-{$clave}", ['mp3', 'ogg', 'wav', 'm4a']);
        $imagen = self::archivo("img/bienvenida/{$clave}", ['png', 'webp', 'gif', 'svg', 'jpg', 'jpeg']);

        return $ficha + [
            'clave'   => $clave,
            'suave'   => "rgba($r, $g, $b, .16)",
            'brillo'  => "rgba($r, $g, $b, .38)",
            'audio'   => $audio,
            'imagen'  => $imagen,
            'sonido'  => (bool) config('temporadas.sonido', true),
            'respetar_movimiento' => (bool) config('temporadas.respetar_movimiento_reducido', true),
        ];
    }
}