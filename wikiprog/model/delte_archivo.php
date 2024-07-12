<?php
/**
 * ../model/delete_archivo.php
 * Script para eliminar un archivo de la base de datos.
 * 
 * Este script recibe el ID del archivo a eliminar mediante una solicitud DELETE.
 * Se conecta a la base de datos y ejecuta la eliminación del archivo.
 */

// Verificar si se recibió el ID del archivo a eliminar
if (!isset($_GET['archivo_id'])) {
    http_response_code(400); // Bad request
    die("Error: No se proporcionó el ID del archivo.");
}

$archivo_id = $_GET['archivo_id'];

// Incluir el archivo de configuración de la base de datos
require_once 'db_config.php';

// Consulta SQL para eliminar el archivo por su ID
$sql = "DELETE FROM archivos WHERE archivo_id = ?";

// Preparar la consulta
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    http_response_code(500); // Internal server error
    die("Error al preparar la consulta: " . $conn->error);
}

// Vincular parámetros
$stmt->bind_param("i", $archivo_id);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Éxito al eliminar el archivo
    http_response_code(204); // No content
    echo "El archivo se eliminó correctamente.";
} else {
    // Error al ejecutar la consulta
    http_response_code(500); // Internal server error
    echo "Error al eliminar el archivo: " . $stmt->error;
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
