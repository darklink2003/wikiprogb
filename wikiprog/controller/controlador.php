<?php
/**
 * Este script inicia la sesión y gestiona la carga dinámica de secciones.
 * controlador.php
 * Sección por defecto: 'seccion2'. Si se proporciona una sección válida a través de GET,
 * se carga esa sección. Finalmente, se incluye la plantilla 'plantilla.php' para la interfaz.
 *
 * @version 1.0
 * @author Pablo Alexander Mondragon Acevedo
 */

// Iniciar sesión
session_start();

// Definir la ruta base de las vistas (considerando que este archivo está en controller/)
$vistas_path = "../view/";

// Sección por defecto
$seccion = "seccion2";

// Verificar si se ha proporcionado una sección válida a través de GET
if (isset($_GET['seccion'])) {
    // Obtener la sección desde el GET
    $seccion = $_GET['seccion'];

    // Validar que la sección exista para evitar vulnerabilidades de inclusión de archivos
    $secciones_disponibles = [
        'seccion1',
        'seccion2',
        'seccion3',
        'seccion4',
        'seccion5',
        'seccion6',
        'seccion7',
        'seccion8',
        'seccion9',
        'seccion10',
        'seccion11',
        'seccion12',
        'seccion13',
        'seccion14'
    ];

    // Verificar si la sección solicitada está en el arreglo de secciones disponibles
    if (!in_array($seccion, $secciones_disponibles)) {
        // Si la sección no es válida, redirigir o manejar el error según la lógica de la aplicación
        $seccion = 'seccion2'; // Cargar sección por defecto
    }
}

// Incluir la plantilla para la interfaz
include ($vistas_path . "plantilla.php");
?>