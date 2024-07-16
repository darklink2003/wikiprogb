<?php
/**
 * ../model/manejar_like_dislike.php
 * Procesa el formulario para guardar la interacción asociada a un comentario.
 * 
 * @version 1.0
 * @author Pablo Alexander Mondragon Acevedo
 */

// Obtener los datos del formulario
$usuario_id = $_POST['usuario_id'];
$comentario_id = $_POST['comentario_id'];
$accion = $_POST['accion']; // acción puede ser 'like' o 'dislike'

// Validar que el comentario_id sea un número entero válido
if (!is_numeric($comentario_id)) {
    die("Error: El ID del comentario no es válido.");
}

// Función para obtener el usuario_id del usuario actual (simulada)
function obtenerUsuarioId()
{
    // Iniciar o continuar la sesión
    session_start();

    // Verificar si hay una sesión de usuario activa y obtener el usuario_id
    if (isset($_SESSION['usuario_id'])) {
        return $_SESSION['usuario_id'];
    } else {
        // Redirigir al usuario a la página de inicio de sesión si no hay sesión activa
        header("Location: seccion2.php");
        exit(); // Finalizar la ejecución del script después de redirigir
    }
}

// Obtener el usuario_id del usuario actual
$usuario_id = obtenerUsuarioId();

// Conexión a la base de datos
include 'db_config.php';

// Iniciar una transacción
$conn->begin_transaction();

try {
    // Insertar la interacción en la tabla de interacciones
    $sql_interaccion = "INSERT INTO interaccion (usuario_id, comentario_id, accion) VALUES (?, ?, ?)";
    $stmt_interaccion = $conn->prepare($sql_interaccion);
    if (!$stmt_interaccion) {
        throw new Exception("Error en la preparación de la consulta de interacción: " . $conn->error);
    }
    $stmt_interaccion->bind_param("iis", $usuario_id, $comentario_id, $accion);
    $stmt_interaccion->execute();
    if ($stmt_interaccion->errno) {
        throw new Exception("Error en la ejecución de la consulta de interacción: " . $stmt_interaccion->error);
    }

    // Confirmar la transacción
    $conn->commit();
    
    // Respuesta JSON opcional para el frontend
    echo json_encode(array('success' => true));
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    
    // Respuesta JSON opcional para el frontend
    echo json_encode(array('success' => false, 'message' => 'Error al guardar la interacción: ' . $e->getMessage()));
}

// Cerrar las conexiones
if (isset($stmt_interaccion)) {
    $stmt_interaccion->close();
}
$conn->close();
?>
