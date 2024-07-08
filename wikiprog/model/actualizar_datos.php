<?php
// Inicia la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../controller/controlador.php?seccion=seccion2&error=not_logged_in");
    exit();
}

// Incluir archivo de configuración de la base de datos
include 'db_config.php';

// Obtener el usuario_id de la sesión
$usuario_id = $_SESSION['usuario_id'];

// Obtener y validar datos del formulario
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$biografia = isset($_POST['biografia']) ? trim($_POST['biografia']) : '';

$errores = [];

// Validar nombre
if (empty($nombre)) {
    $errores[] = 'El nombre es obligatorio.';
}

// Validar correo
if (empty($correo)) {
    $errores[] = 'El correo es obligatorio.';
} elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'El correo no es válido.';
}

// Permitir biografía vacía
if (empty($biografia)) {
    $biografia = null;
}

// Manejo de la imagen de perfil
$directorio_destino = '../img_usuario/';
$nombre_archivo = '';

if (!empty($_FILES['perfil_imagen']['name'])) {
    $nombre_archivo = basename($_FILES['perfil_imagen']['name']);
    $ruta_archivo = $directorio_destino . $nombre_archivo;

    // Validar tipo de archivo e imagen
    $tipo_archivo = pathinfo($ruta_archivo, PATHINFO_EXTENSION);
    $tipos_permitidos = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($tipo_archivo, $tipos_permitidos)) {
        $errores[] = 'Tipo de archivo no permitido. Solo se permiten JPG, JPEG, PNG y GIF.';
    }

    // Validar tamaño del archivo
    if ($_FILES['perfil_imagen']['size'] > 500000) { // 500 KB
        $errores[] = 'El tamaño del archivo es demasiado grande. Máximo 500 KB.';
    }

    // Mover el archivo de la carpeta temporal al destino final
    if (count($errores) === 0 && !move_uploaded_file($_FILES['perfil_imagen']['tmp_name'], $ruta_archivo)) {
        $errores[] = 'Error al subir la imagen.';
    }
}

// Si hay errores, guardarlos en la sesión y redirigir a la página de errores
if (count($errores) > 0) {
    $_SESSION['errores'] = $errores;
    header("Location: ../controller/controlador.php?seccion=seccion10");
    exit();
}

// Consulta SQL para actualizar datos en la base de datos
if (!empty($nombre_archivo)) {
    $sql = "UPDATE usuario SET usuario = ?, correo = ?, biografia = ?, img_usuario = ? WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $correo, $biografia, $nombre_archivo, $usuario_id);
} else {
    $sql = "UPDATE usuario SET usuario = ?, correo = ?, biografia = ? WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $correo, $biografia, $usuario_id);
}

// Ejecutar la actualización y verificar si tuvo éxito
if ($stmt->execute()) {
    $_SESSION['exito'] = 'Datos actualizados con éxito.';
} else {
    $_SESSION['errores'] = ['Error al actualizar los datos.'];
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();

// Redirigir a la página de éxito
header("Location: ../controller/controlador.php?seccion=seccion9");
exit();
?>
