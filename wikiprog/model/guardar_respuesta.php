<?php
// Incluir la configuración de la base de datos
include '../model/db_config.php';

// Verificar si se han recibido los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo_respuesta']) && isset($_POST['prueba_id']) && isset($_POST['inscripción_id'])) {
    // Obtener datos del formulario
    $prueba_id = intval($_POST['prueba_id']);
    $inscripción_id = intval($_POST['inscripción_id']);
    
    // Validar y manejar el archivo subido
    $archivo_respuesta = $_FILES['archivo_respuesta'];
    $archivo_nombre = basename($archivo_respuesta['name']);
    $archivo_temporal = $archivo_respuesta['tmp_name'];
    $archivo_destino = "../archivos_respuesta/" . $archivo_nombre;

    // Verificar si el archivo es válido
    if (is_uploaded_file($archivo_temporal)) {
        if (move_uploaded_file($archivo_temporal, $archivo_destino)) {
            // Preparar la consulta SQL para insertar los datos en la base de datos
            $query = "INSERT INTO respuesta (prueba_id, archivo_respuesta, inscripción_id, fec_reg) VALUES (?, ?, ?, NOW())";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("isi", $prueba_id, $archivo_nombre, $inscripción_id);
                if ($stmt->execute()) {
                    header("Location: ../index.php");
                    echo "Respuesta guardada correctamente.";
                } else {
                    echo "Error al guardar la respuesta en la base de datos: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error en la preparación de la consulta: " . $conn->error;
            }
        } else {
            echo "Error al mover el archivo subido.";
        }
    } else {
        echo "Archivo no válido o no subido.";
    }
} else {
    echo "Datos del formulario incompletos.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
