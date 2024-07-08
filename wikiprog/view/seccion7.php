<?php
// Obtener el curso_id desde la URL
if (isset($_GET['curso_id'])) {
    $curso_id = $_GET['curso_id'];
} else {
    // Manejar el caso donde no se proporciona un curso_id válido
    die("Error: No se ha proporcionado un ID de curso válido.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sección 7 - Curso <?php echo $curso_id; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        /* Estilos CSS personalizados */
        .leccion-container,
        .comentario-container {
            background-color: #171717;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .col {
            flex: 0 0 calc(33.33% - 30px);
            max-width: calc(33.33% - 30px);
            padding: 0 15px;
        }

        /* Estilos responsivos */
        @media (max-width: 768px) {
            .col {
                flex: 0 0 calc(50% - 30px);
                max-width: calc(50% - 30px);
            }
        }

        @media (max-width: 576px) {
            .col {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Contenedor de información del curso -->
        <div id="info-curso" class="mt-4 bg-dark p-3 text-white rounded">
            <!-- Aquí se cargará dinámicamente la información del curso y el enlace de inscripción -->
        </div>

        <!-- Contenedor de lecciones del curso -->
        <div id="lecciones-container" class="mt-4 row">
            <!-- Aquí se cargarán dinámicamente las lecciones del curso -->
        </div>

        <!-- Formulario para enviar comentarios -->
        <div id="formulario-comentario-container" class="mt-4 row">
            <form action="../model/guardar_comentario.php" method="POST">
                <!-- Campo oculto con el ID del curso -->
                <input type="hidden" name="curso_id" value="<?php echo htmlspecialchars($curso_id); ?>">
                <div class="form-group">
                    <h2><b>Comentario</b></h2>
                    <textarea class="form-control" id="comentario" name="comentario" rows="4"></textarea>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>

        <!-- Contenedor de comentarios del curso -->
        <div id="comentario-container" class="mt-4 row">
            <!-- Aquí se cargarán dinámicamente los comentarios del curso -->
        </div>
    </div>

</body>

</html>