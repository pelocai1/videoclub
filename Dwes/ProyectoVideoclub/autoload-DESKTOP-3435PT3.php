<?php
spl_autoload_register(function ($nombreClase) {
    // Directorio base donde se encuentran las clases
    $directorioBase = __DIR__ . '/app/';

    // Verificar si la clase pertenece al namespace "Dwes\ProyectoVideoclub\Util"
    if (strpos($nombreClase, 'Dwes\\ProyectoVideoclub\\Util\\') === 0) {
        // Si es del namespace "Util", buscar en la subcarpeta 'app/Util/'
        $directorioBase .= 'Util/';
        // Eliminar el prefijo del namespace "Dwes\ProyectoVideoclub\Util"
        $nombreClase = str_replace('Dwes\\ProyectoVideoclub\\Util\\', '', $nombreClase);
    } else {
        // Si no es del namespace "Util", buscar en el directorio principal 'app/'
        $nombreClase = str_replace('Dwes\\ProyectoVideoclub\\', '', $nombreClase);
    }

    // Convertir el nombre de la clase a una ruta de archivo
    $archivoClase = $directorioBase . str_replace('\\', '/', $nombreClase) . '.php';

    // Intentar cargar la clase desde el archivo
    if (file_exists($archivoClase)) {
        include_once $archivoClase;
    } else {
        // Si no se encuentra la clase, lanzar una excepción
        throw new Exception("No se pudo cargar la clase: $nombreClase");
    }
});
