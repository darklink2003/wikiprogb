<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../controller/controlador.php?seccion=seccion2&error=not_logged_in");
    exit();
}

include '../model/db_config.php';

if ($conn->connect_error) {
    error_log("Error de conexión: " . $conn->connect_error);
    die("Error de conexión. Por favor, intente nuevamente más tarde.");
}

$usuario_id = (int)$_SESSION['usuario_id'];

// Iniciar una transacción
$conn->begin_transaction();

try {
    // Desactivar las restricciones de claves foráneas temporalmente
    $conn->query("SET foreign_key_checks = 0");

    // Eliminar datos de la tabla `respuesta`
    $sql = "DELETE FROM respuesta WHERE inscripción_id IN (SELECT inscripción_id FROM inscripción WHERE usuario_id = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();

    // Eliminar datos de la tabla `prueba`
    $sql = "DELETE FROM prueba WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();

    // Eliminar datos de la tabla `leccion`
    $sql = "DELETE FROM leccion WHERE curso_id IN (SELECT curso_id FROM curso WHERE usuario_id = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();

    // Eliminar datos de la tabla `inscripción`
    $sql = "DELETE FROM inscripción WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();

    // Eliminar datos de la tabla `curso`
    $sql = "DELETE FROM curso WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();

    // Eliminar datos de la tabla `interaccioncurso`
    $sql = "DELETE FROM interaccioncurso WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();

    // Eliminar datos de la tabla `comentario`
    $sql = "DELETE FROM comentario WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();

    // Eliminar datos de la tabla `archivo`
    $sql = "DELETE FROM archivo WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();

    // Finalmente, eliminar el usuario
    $sql = "DELETE FROM usuario WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();

    // Confirmar la transacción si todo fue bien
    $conn->commit();

    // Volver a activar las restricciones de claves foráneas
    $conn->query("SET foreign_key_checks = 1");

    session_destroy();
    header("Location: ../controller/controlador.php?seccion=seccion1&message=account_deleted");
    exit();
} catch (Exception $e) {
    // Revertir la transacción si hay un error
    $conn->rollback();
    error_log("Error al eliminar el usuario: " . $e->getMessage());
    echo "Error al eliminar la cuenta. Por favor, intente nuevamente más tarde.";
    $conn->query("SET foreign_key_checks = 1"); // Asegurarse de restaurar las restricciones
}

$conn->close();
?>
