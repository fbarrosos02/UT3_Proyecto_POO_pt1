<?php
spl_autoload_register(function ($nombreClase) {
    // Obtiene el nombre de la clase
    $nombreArchivo = basename(str_replace("\\", "/", $nombreClase)) . ".php";
    
    // Rutas donde buscar (directorio app y subdirectorio Util)
    $rutas = [
        __DIR__ . "/app/" . $nombreArchivo,
        __DIR__ . "/app/Util/" . $nombreArchivo,
    ];
    
    foreach ($rutas as $ruta) {
        if (file_exists($ruta)) {
            include_once $ruta;
            return;
        }
    }
});
