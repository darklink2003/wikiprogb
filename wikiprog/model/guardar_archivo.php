<?php
/**
 * guardar_archivo.php
 * Procesa la subida de archivos y la inserción de datos en la base de datos.
 * 
 * Este script maneja la subida de archivos al servidor y la inserción de información relacionada
 * en la base de datos utilizando la conexión configurada en 'db_config.php'.
 *
 * @version 1.0
 * @author pablo mondragon acevedo
 */

// Incluir el archivo de configuración de la base de datos
include '../model/db_config.php';

// Función para obtener el usuario_id del usuario actual
function obtenerUsuarioId()
{
    // Iniciar o continuar la sesión
    session_start();

    // Verificar si hay una sesión de usuario activa y obtener el usuario_id
    if (isset($_SESSION['usuario_id'])) {
        return $_SESSION['usuario_id'];
    } else {
        // Redirigir al usuario a la página de inicio de sesión si no hay sesión activa
        header("Location: login.php");
        exit(); // Finalizar la ejecución del script después de redirigir
    }
}

// Directorio donde se guardarán los archivos subidos
$uploadDir = '../archivos_usuarios/';

// Verificar si se envió algún archivo
if ($_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    // Obtener información del archivo
    $archivo_name = $_FILES['archivo']['name'];
    $archivo_tmp_name = $_FILES['archivo']['tmp_name'];
    $archivo_size = $_FILES['archivo']['size'];
    $archivo_type = $_FILES['archivo']['type'];

    // Construir la ruta completa del archivo en el directorio de subida
    $archivo_path = $uploadDir . $archivo_name;

    // Mover el archivo al directorio de archivos subidos
    if (move_uploaded_file($archivo_tmp_name, $archivo_path)) {
        echo "Archivo subido correctamente.";

        // Obtener el usuario_id del usuario actual
        $usuario_id = obtenerUsuarioId();

        // Verificar si el usuario existe en la tabla usuario antes de insertar en archivo
        $sql_verificar_usuario = "SELECT usuario_id FROM usuario WHERE usuario_id = ?";
        $stmt_verificar_usuario = $conn->prepare($sql_verificar_usuario);
        $stmt_verificar_usuario->bind_param("i", $usuario_id);
        $stmt_verificar_usuario->execute();
        $stmt_verificar_usuario->store_result();

        if ($stmt_verificar_usuario->num_rows == 0) {
            echo "Error: El usuario con ID $usuario_id no existe en la base de datos.";
            $stmt_verificar_usuario->close();
            $conn->close();
            exit();
        }

        // Obtener la privacidad seleccionada
        $privacidad_id = $_POST['privacidad'];

        // Preparar la consulta para insertar los datos del archivo en la tabla archivo
        $sql = "INSERT INTO archivo (usuario_id, nombre_archivo, tamaño, privacidad_id, archivo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        // Obtener el tamaño del archivo en formato legible
        $tamaño_archivo = formatBytes($archivo_size);

        // Bind parameters y ejecutar la consulta
        $stmt->bind_param("isssi", $usuario_id, $archivo_name, $tamaño_archivo, $privacidad_id, $archivo_path);
        $stmt->execute();
        if ($stmt->errno) {
            die("Error al ejecutar la consulta: " . $stmt->error);
        }

        // Redirigir a otra página si es necesario
        header("Location: ../controller/controlador.php?seccion=seccion12&usuario_id=" . urlencode($usuario_id));

        // Cerrar la conexión
        $stmt->close();

    } else {
        echo "Error al subir el archivo.";
    }
} else {
    echo "Error al subir el archivo: " . $_FILES['archivo']['error'];
}

// Función para convertir el tamaño del archivo en formato legible
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}
?>
