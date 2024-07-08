<?php
// Iniciar sesión
session_start();

// Incluir la conexión a la base de datos
include '../model/db_config.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    echo "Acceso denegado.";
    exit;
}

// Verificar si los datos han sido enviados por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y sanitizar los datos enviados
    $curso_id = $_POST['curso_id'];
    $titulo_curso = !empty($_POST['titulo_curso']) ? trim(mysqli_real_escape_string($conn, $_POST['titulo_curso'])) : null;
    $descripcion = !empty($_POST['descripcion']) ? trim(mysqli_real_escape_string($conn, $_POST['descripcion'])) : null;
    $categoria_id = !empty($_POST['categoria_id']) ? $_POST['categoria_id'] : null;

    // Validar que al menos uno de los campos del curso no esté vacío
    if (is_null($titulo_curso) && is_null($descripcion) && is_null($categoria_id)) {
        echo "Debe proporcionar al menos un campo para actualizar.";
        exit;
    }

    // Iniciar la consulta de actualización
    $updates = [];
    $params = [];
    $types = '';

    if (!is_null($titulo_curso)) {
        $updates[] = 'titulo_curso = ?';
        $params[] = $titulo_curso;
        $types .= 's';
    }
    if (!is_null($descripcion)) {
        $updates[] = 'descripcion = ?';
        $params[] = $descripcion;
        $types .= 's';
    }
    if (!is_null($categoria_id)) {
        $updates[] = 'categoria_id = ?';
        $params[] = $categoria_id;
        $types .= 'i';
    }

    $params[] = $curso_id;
    $types .= 'i';

    $sql = "UPDATE curso SET " . implode(', ', $updates) . " WHERE curso_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincular los parámetros
        $stmt->bind_param($types, ...$params);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            header("Location: ../index.php");
        } else {
            echo "Error al actualizar el curso: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    // Verificar y mover cada archivo de lección
    if (isset($_FILES['lecciones'])) {
        $uploadDir = '../archivos_leccion/';
        
        // Recorrer cada lección enviada
        foreach ($_FILES['lecciones']['tmp_name'] as $index => $tmpNames) {
            foreach ($tmpNames as $field => $tmpName) {
                $leccion_id = $_POST['lecciones'][$index]['leccion_id'];
                $titulo_leccion = !empty($_POST['lecciones'][$index]['titulo_leccion']) ? $_POST['lecciones'][$index]['titulo_leccion'] : null;
                $contenido_leccion = !empty($_POST['lecciones'][$index]['contenido']) ? $_POST['lecciones'][$index]['contenido'] : null;

                // Generar un nombre único para el archivo si se ha subido uno
                if ($field === 'archivo_leccion' && is_uploaded_file($tmpName)) {
                    $archivo_name = $_FILES['lecciones']['name'][$index][$field];
                    $archivo_tmp_name = $tmpName;
                    $archivo_path = $uploadDir . uniqid() . '_' . $archivo_name;

                    // Mover el archivo a la carpeta de archivos de lección
                    if (move_uploaded_file($archivo_tmp_name, $archivo_path)) {
                        $sql_update_archivo = "UPDATE leccion SET archivo_leccion = ? WHERE leccion_id = ?";
                        $stmt_update_archivo = $conn->prepare($sql_update_archivo);
                        $stmt_update_archivo->bind_param('si', $archivo_path, $leccion_id);
                        $stmt_update_archivo->execute();
                        $stmt_update_archivo->close();
                    } else {
                        echo "Error al subir el archivo '$archivo_name'.";
                    }
                }

                // Actualizar el título y contenido de la lección en la base de datos
                if (!is_null($titulo_leccion) || !is_null($contenido_leccion)) {
                    $leccion_updates = [];
                    $leccion_params = [];
                    $leccion_types = '';

                    if (!is_null($titulo_leccion)) {
                        $leccion_updates[] = 'titulo_leccion = ?';
                        $leccion_params[] = $titulo_leccion;
                        $leccion_types .= 's';
                    }
                    if (!is_null($contenido_leccion)) {
                        $leccion_updates[] = 'contenido = ?';
                        $leccion_params[] = $contenido_leccion;
                        $leccion_types .= 's';
                    }

                    $leccion_params[] = $leccion_id;
                    $leccion_types .= 'i';

                    $sql_update_leccion = "UPDATE leccion SET " . implode(', ', $leccion_updates) . " WHERE leccion_id = ?";
                    $stmt_update_leccion = $conn->prepare($sql_update_leccion);
                    $stmt_update_leccion->bind_param($leccion_types, ...$leccion_params);
                    $stmt_update_leccion->execute();
                    $stmt_update_leccion->close();
                }
            }
        }
    }

} else {
    echo "Método de solicitud no permitido.";
}

// Cerrar la conexión
$conn->close();
?>
