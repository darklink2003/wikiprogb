<?php
/**
 * guardar_curso.php
 * Procesa el formulario para agregar un nuevo curso con sus respectivas lecciones y archivos.
 * 
 * Este script recibe datos del formulario POST para agregar un nuevo curso a la base de datos 'wikiprog'.
 * Verifica la existencia de la categoría seleccionada, sube los archivos de lección al servidor,
 * inicia una transacción para asegurar la integridad de los datos y realiza inserciones en las tablas
 * 'curso' y 'leccion'. Si ocurre algún error durante la inserción, revierte la transacción y muestra
 * un mensaje de error.
 *
 * @version 1.0
 * @author Pablo Alexander Mondragon Acevedo
 */

// Obtener los datos del formulario
$titulo_curso = $_POST['titulo_curso'];
$descripcion = $_POST['descripcion'];
$categoria_id = $_POST['categoria'];
$titulos_leccion = $_POST['titulo_leccion'];
$contenidos_leccion = $_POST['contenido_leccion'];
$archivos_leccion = $_FILES['archivo_leccion']; // Array de archivos

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
        header("Location: login.php");
        exit(); // Finalizar la ejecución del script después de redirigir
    }
}

// Función para obtener el rango_id del usuario actual (simulada)
function obtenerRangoIdUsuario($usuario_id)
{
    // Conexión a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'wikiprog');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta para obtener el rango_id del usuario
    $sql = "SELECT rango_id FROM usuario WHERE usuario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->bind_result($rango_id);
    $stmt->fetch();

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conexion->close();

    // Devolver el rango_id obtenido
    return $rango_id;
}


// Obtener el usuario_id del usuario actual
$usuario_id = obtenerUsuarioId();

// Verificar el rango_id del usuario
$rango_id_permitidos = [2, 3]; // Rangos permitidos para agregar cursos
$rango_id_usuario = obtenerRangoIdUsuario($usuario_id);

if (!in_array($rango_id_usuario, $rango_id_permitidos)) {
    die("No tienes permisos suficientes para agregar un curso.");
}

// Conexión a la base de datos
include 'db_config.php';

// Verificar si la categoría existe
$sql_categoria = "SELECT categoria_id FROM categoria WHERE categoria_id = ?";
$stmt_categoria = $conn->prepare($sql_categoria);
$stmt_categoria->bind_param("i", $categoria_id);
$stmt_categoria->execute();
$stmt_categoria->store_result();

if ($stmt_categoria->num_rows == 0) {
    echo "Error: La categoría seleccionada no existe.";
    $stmt_categoria->close();
    $conn->close();
    exit();
}
$stmt_categoria->close();

// Directorio donde se guardarán los archivos de lección
$uploadDir = '../archivos_leccion/';

// Verificar y mover cada archivo de lección
$archivos_leccion_paths = array(); // Para almacenar rutas de los archivos subidos

foreach ($archivos_leccion['tmp_name'] as $index => $tmpName) {
    $titulo_leccion = $titulos_leccion[$index];
    $contenido_leccion = $contenidos_leccion[$index];
    $archivo_name = $archivos_leccion['name'][$index];
    $archivo_tmp_name = $archivos_leccion['tmp_name'][$index];
    $archivo_size = $archivos_leccion['size'][$index];
    $archivo_type = $archivos_leccion['type'][$index];

    // Generar un nombre único para el archivo
    $archivo_path = $uploadDir . uniqid() . '_' . $archivo_name;

    // Mover el archivo a la carpeta de archivos de lección
    if (move_uploaded_file($archivo_tmp_name, $archivo_path)) {
        $archivos_leccion_paths[] = $archivo_path;
    } else {
        echo "Error al subir el archivo '$archivo_name'.";
    }
}

// Iniciar una transacción
$conn->begin_transaction();

try {
    // Insertar los datos en la tabla curso
    $sql_curso = "INSERT INTO curso (titulo_curso, descripcion, categoria_id, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt_curso = $conn->prepare($sql_curso);
    if (!$stmt_curso) {
        throw new Exception("Error en la preparación de la consulta de curso: " . $conn->error);
    }
    $stmt_curso->bind_param("ssii", $titulo_curso, $descripcion, $categoria_id, $usuario_id);
    $stmt_curso->execute();
    if ($stmt_curso->errno) {
        throw new Exception("Error en la ejecución de la consulta de curso: " . $stmt_curso->error);
    }

    // Obtener el ID del curso recién insertado
    $curso_id = $conn->insert_id;

    // Insertar los datos en la tabla lección
    $sql_leccion = "INSERT INTO leccion (curso_id, titulo_leccion, contenido, archivo_leccion) VALUES (?, ?, ?, ?)";
    $stmt_leccion = $conn->prepare($sql_leccion);
    if (!$stmt_leccion) {
        throw new Exception("Error en la preparación de la consulta de lección: " . $conn->error);
    }

    // Iterar sobre las lecciones y guardarlas
    foreach ($titulos_leccion as $index => $titulo_leccion) {
        $contenido_leccion = $contenidos_leccion[$index];
        $archivo_leccion = $archivos_leccion_paths[$index]; // Obtener la ruta del archivo

        $stmt_leccion->bind_param("isss", $curso_id, $titulo_leccion, $contenido_leccion, $archivo_leccion);
        $stmt_leccion->execute();
        if ($stmt_leccion->errno) {
            throw new Exception("Error en la ejecución de la consulta de lección: " . $stmt_leccion->error);
        }
    }

    // Confirmar la transacción
    $conn->commit();
    // Redirigir a otra página si es necesario
    header("Location: ../index.php");
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    echo "Error al guardar el curso y las lecciones: " . $e->getMessage();
}

// Cerrar las conexiones
if (isset($stmt_curso)) {
    $stmt_curso->close();
}
if (isset($stmt_leccion)) {
    $stmt_leccion->close();
}
$conn->close();
?>