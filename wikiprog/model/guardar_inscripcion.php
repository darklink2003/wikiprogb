<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * guardar_inscripcion.php
 * Procesa el formulario para agregar una inscripción de un usuario a un nuevo curso.
 *
 * @version 1.0
 */

// Incluir el archivo de configuración de la base de datos
include 'db_config.php';

// Validar y sanitizar las entradas del formulario
$curso_id = filter_input(INPUT_POST, 'curso_id', FILTER_SANITIZE_NUMBER_INT);
$usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_SANITIZE_NUMBER_INT);
$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
$correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
$genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_STRING);
$pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);
$cursos_anteriores = filter_input(INPUT_POST, 'cursos_anteriores', FILTER_SANITIZE_STRING);

// Verificar que todas las variables requeridas tienen valores válidos
if (!$curso_id || !$usuario_id || !$nombre || !$correo || !$genero || !$pais || !$cursos_anteriores) {
    die('Error: Datos del formulario inválidos.');
}

// Verificar si el usuario ya está inscrito en el curso
$sql_verificar = "SELECT COUNT(*) AS num_inscripciones FROM inscripción WHERE curso_id = ? AND usuario_id = ?";
$stmt_verificar = $conn->prepare($sql_verificar);
if (!$stmt_verificar) {
    die('Error en la preparación de la consulta de verificación: ' . $conn->error);
}
$stmt_verificar->bind_param("ii", $curso_id, $usuario_id);
$stmt_verificar->execute();
$resultado_verificar = $stmt_verificar->get_result();

if (!$resultado_verificar) {
    die('Error en la ejecución de la consulta de verificación: ' . $stmt_verificar->error);
}

$fila_verificar = $resultado_verificar->fetch_assoc();
$num_inscripciones = $fila_verificar['num_inscripciones'];

if ($num_inscripciones > 0) {
    die('Error: El usuario ya está inscrito en este curso.');
}

// Preparar la consulta SQL para insertar los datos en la base de datos
$sql = "INSERT INTO inscripción (curso_id, usuario_id, nombre, correo, genero, pais, cursos_anteriores, fecha_registro) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Error en la preparación de la consulta de inserción: ' . $conn->error);
}
$stmt->bind_param("iisssss", $curso_id, $usuario_id, $nombre, $correo, $genero, $pais, $cursos_anteriores);
$ejecucion = $stmt->execute();

if ($ejecucion) {
    header("Location: ../controller/controlador.php?seccion=seccion3&usuario_id=${usuario_id}");
    exit(); // Asegura que el script se detenga después de la redirección
} else {
    die('Error en la ejecución de la consulta de inserción: ' . $stmt->error);
}
?>
