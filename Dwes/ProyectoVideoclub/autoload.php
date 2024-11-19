<?php
spl_autoload_register(function ($class) {
    // Eliminar el prefijo 'Dwes\ProyectoVideoclub\' del namespace
    $prefix = 'Dwes\\ProyectoVideoclub\\';

    // Verifica si la clase pertenece al espacio de nombres 'Dwes\ProyectoVideoclub'
    if (strpos($class, $prefix) === 0) {
        // Elimina el prefijo 'Dwes\ProyectoVideoclub\' del nombre de la clase
        $className = substr($class, strlen($prefix));

        // Convierte las barras invertidas del namespace en directorios
        $classFile = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        // Define el directorio base donde están tus clases
        $baseDir = __DIR__ . '/app/';

        // Intenta cargar el archivo de la clase si existe
        if (file_exists($baseDir . $classFile)) {
            include_once $baseDir . $classFile;
        } else {
            // Si no se encuentra, lanza una excepción
            throw new Exception("No se pudo cargar la clase: $class");
        }
    }
});






