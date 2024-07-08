<?php
/**
 * Consulta y devuelve información de cursos en formato JSON.
 * 
 * Este script realiza una conexión a la base de datos MySQL, consulta la tabla 'curso' para obtener
 * el ID del curso, título y descripción de cada curso disponible. Luego, cierra la conexión y
 * devuelve los datos obtenidos en formato JSON.
 *
 * @version 1.0
 * @autor Pablo Alexander Mondragon Acevedo
 */

// Incluir el archivo de configuración de la base de datos
include 'db_config.php';

// Consulta SQL para obtener cursos
$sql = "SELECT curso_id, titulo_curso, descripcion, categoria_id FROM curso";
$result = $conn->query($sql);

$courses = array();

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    // Recorrer cada fila de resultados y guardar en un array
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

// Establecer encabezado para indicar que se devolverá JSON
header('Content-Type: application/json');

// Devolver los datos en formato JSON
echo json_encode($courses);
?>
