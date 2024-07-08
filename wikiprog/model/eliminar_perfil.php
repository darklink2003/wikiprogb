<?php
/**
 * Manejo de eliminación de cuenta de usuario usando consulta preparada.
 * 
 * Este script verifica la sesión del usuario, establece una conexión a la base de datos
 * MySQL, y elimina el usuario correspondiente al usuario actualmente autenticado usando
 * una consulta preparada para mejorar la seguridad y rendimiento. Si la eliminación es exitosa,
 * destruye la sesión del usuario y lo redirige a la página de inicio con un mensaje de éxito.
 * En caso de error, muestra un mensaje de error detallado.
 *
 * @version 1.0
 * @author Pablo Alexander Mondragon Acevedo
 * @author Keiner Yamith Tarache Parra
 */

// Inicia la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../controller/controlador.php?seccion=seccion2&error=not_logged_in");
    exit();
}

// Incluir el archivo de configuración de la base de datos
include '../model/db_config.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


// Obtener el usuario_id de la sesión
$usuario_id = $_SESSION['usuario_id'];

// Consulta SQL para eliminar el usuario usando una consulta preparada
$sql = "DELETE FROM usuario WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);

// Ejecutar la consulta preparada y verificar si fue exitosa
if ($stmt->execute()) {
    // Eliminación exitosa, destruir la sesión para desconectar al usuario
    session_destroy();
    header("Location: ../controller/controlador.php?seccion=seccion1&message=account_deleted"); // Redirigir con mensaje de éxito
    exit();
} else {
    // Mostrar mensaje de error si la eliminación falla
    echo "Error al eliminar la cuenta: " . $conn->error;
}

// Cerrar la conexión y liberar recursos
$stmt->close();
$conn->close();
?>