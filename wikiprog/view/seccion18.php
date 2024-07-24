<?php
// Incluir la configuración de la base de datos y la clase necesaria
include("../model/clase.php");

// Iniciar la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../controller/controlador.php?seccion=seccion2&error=not_logged_in");
    exit();
}

// Obtener el usuario_id de la sesión
$usuario_id = $_SESSION['usuario_id'];

// Verificar si se ha proporcionado un curso_id válido
if (!isset($_GET['curso_id']) || !is_numeric($_GET['curso_id'])) {
    echo "<p>ID de curso inválido.</p>";
    exit();
}

$curso_id = intval($_GET['curso_id']);

// Verificar si la clase y el método existen antes de llamarlos
if (class_exists('login') && method_exists('login', 'verUsuariosInscritos')) {
    $usuarios = login::verUsuariosInscritos($curso_id);
} else {
    $usuarios = "<p>Error al cargar los usuarios inscritos.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Inscritos</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container" style="margin-top:50px;">
        <h1>Usuarios Inscritos en el Curso</h1>
        <div class="table-responsive">
            <?php echo $usuarios; ?>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
