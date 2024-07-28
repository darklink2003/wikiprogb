<?php
/**
 * ../model/guardar_interacion.php
 * Guarda una interacción de like o dislike para un curso específico.
 * 
 * Este script procesa la solicitud POST para guardar la interacción del usuario
 * en la base de datos y devuelve una respuesta JSON con el estado de la operación.
 *
 * @version 1.1
 * @author Pablo Alexander Mondragon Acevedo
 */

// Incluir el archivo de configuración de la base de datos
include 'db_config.php';

// Reportar errores de MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Obtener los datos de la solicitud POST
$curso_id = isset($_POST['curso_id']) ? intval($_POST['curso_id']) : 0;
$usuario_id = isset($_POST['usuario_id']) ? intval($_POST['usuario_id']) : 0;
$tipo_interaccion = isset($_POST['tipo_interaccion']) ? $_POST['tipo_interaccion'] : '';

// Validar los datos
if ($curso_id <= 0 || $usuario_id <= 0 || !in_array($tipo_interaccion, ['like', 'dislike'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

try {
    // Verificar si ya existe una interacción del mismo usuario para este curso
    $stmt = $conn->prepare("SELECT COUNT(*) FROM interaccioncurso WHERE curso_id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $curso_id, $usuario_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Actualizar la interacción existente
        $stmt = $conn->prepare("UPDATE interaccioncurso SET tipo_interaccion = ?, fecha = NOW() WHERE curso_id = ? AND usuario_id = ?");
        $stmt->bind_param("sii", $tipo_interaccion, $curso_id, $usuario_id);
    } else {
        // Insertar nueva interacción
        $stmt = $conn->prepare("INSERT INTO interaccioncurso (curso_id, usuario_id, tipo_interaccion, fecha) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $curso_id, $usuario_id, $tipo_interaccion);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Interacción guardada correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar la interacción']);
    }
    $stmt->close();
} catch (Exception $e) {
    // Manejar errores
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
    error_log("Error en guardar_interacion.php: " . $e->getMessage()); // Registrar el error en el archivo de log
} finally {
    $conn->close();
}
?>
