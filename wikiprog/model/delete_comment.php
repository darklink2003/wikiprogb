<?php
// ../model/delete_comment.php

// Incluir el archivo de configuración para la conexión a la base de datos
include '../model/db_config.php';

// Obtener el ID del comentario desde la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);
$comentario_id = isset($data['id']) ? intval($data['id']) : 0;

// Inicializar la respuesta
$response = ['success' => false, 'message' => 'Error desconocido.'];

if ($comentario_id > 0) {
    // Preparar y ejecutar la consulta para eliminar el comentario
    $stmt = $conn->prepare("DELETE FROM comentario WHERE comentario_id = ?");
    $stmt->bind_param("i", $comentario_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Comentario eliminado exitosamente
            $response['success'] = true;
            $response['message'] = 'Comentario eliminado exitosamente.';
        } else {
            // Comentario no encontrado
            $response['message'] = 'No se encontró el comentario para eliminar.';
        }
    } else {
        // Error al ejecutar la consulta
        $response['message'] = 'Error al ejecutar la consulta: ' . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    // ID no válido
    $response['message'] = 'ID del comentario no válido.';
}

// Cerrar la conexión
$conn->close();

// Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
