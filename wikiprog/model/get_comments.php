<?php
/**
 * get_comments.php
 * Consulta y devuelve los comentarios asociados a un curso específico en formato JSON.
 *
 * @version 1.1
 * author Pablo Alexander Mondragon Acevedo
 */

// Incluir el archivo de configuración de la base de datos
include 'db_config.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el curso_id de la solicitud GET
$curso_id = isset($_GET['curso_id']) ? intval($_GET['curso_id']) : 0;

// Preparar la consulta para obtener los comentarios asociados a un curso_id específico
$query = "SELECT c.comentario_id, c.usuario_id, c.curso_id, c.comentario, c.fecha_registro, c.megustac, c.dislike, u.usuario AS nombre_usuario 
          FROM comentario c
          INNER JOIN usuario u ON c.usuario_id = u.usuario_id
          WHERE c.curso_id = ?";
$stmt = $conn->prepare($query);

// Verificar si la preparación fue exitosa
if ($stmt) {
    $stmt->bind_param("i", $curso_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $comentarios = array();
    while ($comentario = $resultado->fetch_assoc()) {
        $comentarios[] = $comentario;
    }

    // Establecer encabezado para indicar que se devolverá JSON
    header('Content-Type: application/json');

    // Devolver los datos en formato JSON
    echo json_encode($comentarios);

    // Cerrar el statement
    $stmt->close();
} else {
    // Devolver un mensaje de error en formato JSON si la preparación de la consulta falla
    echo json_encode(array('error' => 'Error en la preparación de la consulta: ' . $conn->error));
}

// Cerrar conexión
$conn->close();
?>
