<?php
        // Verificación básica para asegurar que se ha proporcionado un id válido
        if (!isset($_GET['curso_id']) || !is_numeric($_GET['curso_id'])) {
            die('Parámetro de ID inválido.');
        }

        $curso_id = $_GET['curso_id'];

        // Incluir el archivo de configuración de la base de datos
        include '../model/db_config.php';


        // Consulta SQL para obtener los datos del usuario por su ID usando declaraciones preparadas
        $sql = "SELECT curso_id, titulo_curso, descripcion, categoria_id, fecha_registro FROM curso WHERE curso_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('Error en la preparación de la consulta: ' . $conn->error);
        }
        $stmt->bind_param("i", $curso_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if (!$resultado) {
            die('Error en la ejecución de la consulta: ' . $stmt->error);
        }

        // Verificar si se encontró el usuario
        if ($resultado->num_rows == 1) {
            // Obtener los datos del usuario
            $fila = $resultado->fetch_assoc();
            $curso_id = $fila['curso_id'];
            $titulo_curso = htmlspecialchars($fila['titulo_curso']);
            $descripcion = htmlspecialchars($fila['descripcion']);
            $categoria_id = htmlspecialchars($fila['categoria_id']);
            $fecha_registro = $fila['fecha_registro'];}

?>

<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Formulario de Inscripción
                    </div>
                    <div class="card-body">
                        <form action="procesar_inscripcion.php" method="POST">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>

                            <div class="form-group">
                                <label for="curso">Curso de Interés:</label>
                                <p><?php echo $titulo_curso; ?></p>
                                <p><?php echo $descripcion; ?></p>

                            </div>
                            <button type="submit" class="btn btn-primary">Enviar Inscripción</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>