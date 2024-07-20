<?php
// Incluir la configuración de la base de datos
include '../model/db_config.php';

// Verificar si se han recibido los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo_respuesta']) && isset($_POST['prueba_id']) && isset($_POST['inscripcion_id'])) {
    // Obtener datos del formulario
    $prueba_id = intval($_POST['prueba_id']);
    $inscripcion_id = intval($_POST['inscripcion_id']);
    
    // Validar y manejar el archivo subido
    $archivo_respuesta = $_FILES['archivo_respuesta'];
    $archivo_nombre = basename($archivo_respuesta['name']);
    $archivo_temporal = $archivo_respuesta['tmp_name'];
    $archivo_destino = "../archivos_respuesta/" . $archivo_nombre;

    // Verificar si el archivo se subió correctamente
    if (move_uploaded_file($archivo_temporal, $archivo_destino)) {
        // Preparar la consulta SQL para insertar los datos en la base de datos
        $query = "INSERT INTO respuesta (prueba_id, archivo_respuesta, inscripcion_id, fec_reg) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("isi", $prueba_id, $archivo_nombre, $inscripcion_id);
            if ($stmt->execute()) {
                echo "Respuesta guardada correctamente.";
            } else {
                echo "Error al guardar la respuesta en la base de datos: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $conn->error;
        }
    } else {
        echo "Error al subir el archivo.";
    }
} else {
    echo "Datos del formulario incompletos.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
