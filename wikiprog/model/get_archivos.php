<?php
/**
 * get_archivos.php
 * Consulta y devuelve los archivos asociados a un usuario específico en formato JSON,
 * incluyendo detalles como el nombre del archivo, tamaño y privacidad.
 *
 * @version 1.0
 * author Pablo Alexander Mondragon Acevedo
 */

// Incluir el archivo de configuración de la base de datos
include 'db_config.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener usuario_id del parámetro GET
$usuario_id = isset($_GET['usuario_id']) ? intval($_GET['usuario_id']) : 0;

// Preparar la consulta para obtener los archivos asociados a un usuario_id específico
$query = "SELECT nombre_archivo, tamaño, privacidad_id 
          FROM archivo 
          WHERE usuario_id = ?
          ORDER BY nombre_archivo";

$stmt = $conn->prepare($query);

// Verificar si la preparación fue exitosa
if ($stmt) {
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $archivos = array();
    while ($archivo = $resultado->fetch_assoc()) {
        $archivos[] = $archivo;
    }

    // Establecer encabezado para indicar que se devolverá JSON
    header('Content-Type: application/json');

    // Devolver los datos en formato JSON
    echo json_encode($archivos);

    // Cerrar el statement
    $stmt->close();
} else {
    // Devolver un mensaje de error en formato JSON si la preparación de la consulta falla
    echo json_encode(array('error' => 'Error en la preparación de la consulta: ' . $conn->error));
}

// Cerrar conexión
$conn->close();
?>
