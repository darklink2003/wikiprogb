<?php
/**
 * Controlador principal de la aplicación.
 * Este archivo gestiona el enrutamiento y la seguridad de las secciones del sitio web.
 */

// Iniciar la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener la sección de la URL, si no está presente, se usa 'seccion1' como predeterminada
$seccion = $_GET['seccion'] ?? 'seccion1';
// Limpiar el nombre de la sección para evitar inclusiones maliciosas
$seccion = preg_replace('/[^a-zA-Z0-9_]/', '', $seccion);
// Obtener el ID de usuario de la sesión, si no está iniciada, se establece como vacío
$usuario_id = $_SESSION['usuario_id'] ?? '';

// Redirigir a la página de inicio de sesión si no ha iniciado sesión y trata de acceder a una sección restringida
$public_sections = ['seccion5', 'seccion2']; // Agregar aquí las secciones públicas
if (empty($usuario_id) && !in_array($seccion, $public_sections)) {
    session_regenerate_id(true); // Regenerar ID de sesión para seguridad adicional
    header("Location: controlador.php?seccion=seccion2");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($seccion); ?></title>

    <!-- Estilos -->
    <link rel="icon" href="../css/img/logo.png" type="image/png">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Tag Manager -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GQJG3209SE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-GQJG3209SE');
    </script>
</head>

<body>

<!-- Barra de navegación -->
<?php if ($seccion !== 'seccion2'): ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="controlador.php?seccion=seccion1">WikiProg</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="controlador.php?seccion=seccion1">Explorar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="controlador.php?seccion=seccion2">Visual Code</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="controlador.php?seccion=seccion3">Foro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="controlador.php?seccion=seccion4">Cursos</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../css/img/usuario.png" alt="Usuario" class="img-fluid" style="width: 30px;">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><b>ESTADO</b>
                                <?php echo isset($_SESSION['usuario_id']) ? 'Activo' : 'Inactivo'; ?>
                            </li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion9">Tu Perfil</a></li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion6">Lista De Usuarios</a></li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion3">Tus Cursos</a></li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion12">Tu Nube</a></li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion5"><b>Registro</b></a></li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion10">Configuración</a></li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion11">Ayuda</a></li>
                            <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
<?php endif; ?>

    <!-- Contenido de la sección -->
    <div class="container" style="margin-top:50px;">
        <?php include ($seccion . ".php"); ?>
    </div>

    <!-- Pie de página -->
    <div class="container2" style="margin-top:50px;">
        <footer>
            <p>© WikiProg 2024</p>
        </footer>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="../js/load_comments.js"></script>
    <script src="../js/mensaje.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/perfil.js"></script>
    <script src="../js/funciones.js"></script>

</body>

</html>