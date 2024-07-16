<?php
/**
 * ../model/delete_archivo.php
 * Script para eliminar un archivo de la base de datos y del sistema de archivos.
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

// Consulta SQL para obtener la información del archivo antes de eliminarlo
$sql_select = "SELECT nombre_archivo FROM archivo WHERE archivo_id = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $archivo_id);

if (!$stmt_select->execute()) {
    http_response_code(500); // Internal server error
    die("Error al ejecutar la consulta para obtener el nombre del archivo: " . $stmt_select->error);
}

$stmt_select->bind_result($nombre_archivo);

if (!$stmt_select->fetch()) {
    http_response_code(404); // Not found
    die("No se encontró el archivo con ID: " . $archivo_id);
}

$stmt_select->close();

// Consulta SQL para eliminar el archivo por su ID
$sql_delete = "DELETE FROM archivo WHERE archivo_id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $archivo_id);

if (!$stmt_delete->execute()) {
    http_response_code(500); // Internal server error
    die("Error al eliminar el archivo de la base de datos: " . $stmt_delete->error);
}

// Éxito al eliminar el archivo de la base de datos
http_response_code(204); // No content
echo "El archivo se eliminó correctamente.";

// Eliminar el archivo físico de la carpeta archivos_usuarios
$archivo_path = '../archivos_usuarios/' . $nombre_archivo;
if (file_exists($archivo_path)) {
    if (!unlink($archivo_path)) {
        http_response_code(500); // Internal server error
        die("Error al eliminar el archivo físico: No se pudo eliminar el archivo.");
    }
}

// Cerrar las declaraciones y la conexión
$stmt_delete->close();
$conn->close();
?>
