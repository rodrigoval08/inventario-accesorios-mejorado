<?php

return [

    /*
    | Activa o desactiva por completo los temas por fechas.
    | En .env:  TEMPORADAS_ACTIVAS=false
    */
    'activo' => env('TEMPORADAS_ACTIVAS', true),

    /*
    | Fuerza una temporada sin importar la fecha (útil para probar).
    | En .env:  TEMPORADA_FORZADA=navidad
    | Claves: halloween, todos_los_santos, navidad, ano_nuevo, san_valentin,
    |         semana_santa, dia_trabajo, dia_madre, dia_padre, dia_maestro,
    |         dia_pollo_brasa, fiestas_patrias, santa_rosa, angamos, inmaculada
    */
    'forzada' => env('TEMPORADA_FORZADA'),

    /*
    | true  = si el sistema operativo tiene "reducir movimiento", las
    |         animaciones decorativas se quedan quietas (recomendado).
    | false = siempre se animan.
    */
    'respetar_movimiento_reducido' => env('TEMPORADAS_RESPETAR_MOVIMIENTO', true),

    /*
    | Escena de bienvenida después de iniciar sesión (bruja, Papá Noel...).
    | En .env:  TEMPORADAS_BIENVENIDA=false
    */
    'bienvenida' => env('TEMPORADAS_BIENVENIDA', true),

    /*
    | Sonido de la escena de bienvenida (risa de la bruja, "jo, jo, jo").
    | En .env:  TEMPORADAS_SONIDO=false
    */
    'sonido' => env('TEMPORADAS_SONIDO', true),

];