<?php
// Verificar si se ha enviado el parámetro 'id' por la URL
if (isset($_GET['id'])) {
    // Obtener el id del usuario desde la URL y asegurarse de que sea un entero válido
    $usuario_id = intval($_GET['id']);

    // Conexión a la base de datos
    require_once 'db_config.php'; // Asegúrate de que el archivo de conexión esté incluido correctamente

    // Consulta SQL para eliminar el usuario
    $sql = "DELETE FROM usuario WHERE usuario_id = ?";

    // Preparar la declaración SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página principal de usuarios después de eliminar
        header("Location: ../controller/controlador.php?seccion=seccion6");
        exit; // Finalizar el script después de la redirección
    } else {
        echo "Error al intentar eliminar el usuario: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    // Si no se proporcionó el parámetro 'id', mostrar un mensaje de error o redirigir a otra página
    echo "No se ha proporcionado el parámetro 'id' para eliminar el usuario.";
}
?>
