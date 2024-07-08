<?php
// Incluir la conexión a la base de datos
include('../model/db_config.php');

// Verificar si se recibió el parámetro 'id' por GET
if(isset($_GET['id'])) {
    // Sanitizar y validar el ID del curso
    $curso_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Iniciar transacción para asegurar la integridad de los datos
    $conn->begin_transaction();

    try {
        // Eliminar las lecciones asociadas al curso
        $sql_lecciones = "DELETE FROM leccion WHERE curso_id = ?";
        $stmt_lecciones = $conn->prepare($sql_lecciones);
        $stmt_lecciones->bind_param('i', $curso_id);
        $stmt_lecciones->execute();
        $stmt_lecciones->close();

        // Eliminar el curso
        $sql_curso = "DELETE FROM curso WHERE curso_id = ?";
        $stmt_curso = $conn->prepare($sql_curso);
        $stmt_curso->bind_param('i', $curso_id);
        $stmt_curso->execute();
        $stmt_curso->close();

        // Confirmar la transacción
        $conn->commit();

        // Redirigir de vuelta a donde sea necesario
        header("Location: ../index.php?eliminado=true");
        exit();
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();

        // Manejar el error
        echo "Error al intentar eliminar el curso: " . $e->getMessage();
    }
    
    // Cerrar la conexión
    $conn->close();
} else {
    // Manejar el caso donde no se proporcionó el ID del curso
    echo "No se proporcionó un ID de curso válido.";
}
?>
