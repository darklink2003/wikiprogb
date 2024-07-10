<?php
// Inicia la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: controlador.php?seccion=seccion2&error=not_logged_in");
    exit();
}

// Conexión a la base de datos
include '../model/db_config.php';

$archivos = [];
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM archivo WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $archivos[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sección 12 - Subir y Mostrar Archivos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
        .container-archivos {
            margin-top: 20px;
        }

        .archivo-container {
            background-color: #232230;
            color: white;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container-fluid"
        style="background-color: #232230; color: white; padding-top: 20px; padding-bottom: 20px;">
        <div class="container">
            <div class="row">
                <!-- Primera columna con enlaces -->
                <div class="col-md-3">
                    <h2>Enlaces</h2>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Enlace 1</a></li>
                        <li><a href="#" class="text-white">Enlace 2</a></li>
                        <li><a href="#" class="text-white">Enlace 3</a></li>
                    </ul>
                </div>
                <!-- Segunda columna con formulario de subida de archivos -->
                <div class="col-md-9">
                    <div class="row">
                        <h2>Subir Archivos</h2>
                        <form action="../model/guardar_archivo.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="archivo" class="form-label text-white">Selecciona un archivo</label>
                                <input type="file" class="form-control" id="archivo" name="archivo"
                                    style="color: white;">
                            </div>
                            <div class="mb-3">
                                <label for="privacidad" class="form-label text-white">Privacidad</label>
                                <select class="form-select" id="privacidad" name="privacidad">
                                    <option value="1">Pública</option>
                                    <option value="2">Privada</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Subir Archivo</button>
                        </form>
                    </div>
                    <div class="row">
                        <div class="container-archivos">
                            <h1>Mostrar Archivos</h1>
                            <?php foreach ($archivos as $archivo): ?>
                                <div class="archivo-container">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p><strong>Nombre:</strong> <?= htmlspecialchars($archivo['nombre_archivo']) ?>
                                            </p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><strong>Tamaño:</strong> <?= htmlspecialchars($archivo['tamaño']) ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><strong>Fecha de Registro:</strong>
                                                <?= htmlspecialchars($archivo['fecha_registro']) ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><strong>Privacidad:</strong>
                                                <?= $archivo['privacidad_id'] == 1 ? 'Pública' : 'Privada' ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Privacidad:</strong>
                                                <?= $archivo['privacidad_id'] == 1 ? 'Pública' : 'Privada' ?></p>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>