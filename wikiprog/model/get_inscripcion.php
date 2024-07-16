<?php
/**
 * get_inscripciones.php
 * Consulta y devuelve las inscripciones asociadas a un usuario específico en formato JSON,
 * incluyendo detalles como el nombre del curso, nota y fecha de registro.
 */

// Incluir el archivo de configuración de la base de datos
include 'db_config.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el usuario_id desde los parámetros GET
if (isset($_GET['usuario_id'])) {
    $usuario_id = $_GET['usuario_id'];

    // Query para obtener las inscripciones del usuario
    $sql = "SELECT i.inscripción_id, i.nombre, i.correo, i.genero, i.pais, i.cursos_anteriores, i.nota, i.fecha_registro, c.titulo_curso
            FROM inscripción i
            INNER JOIN curso c ON i.curso_id = c.curso_id
            WHERE i.usuario_id = $usuario_id";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Arreglo para almacenar las inscripciones
        $inscripciones = array();

        // Iterar sobre las inscripciones
        while ($row = $result->fetch_assoc()) {
            $inscripciones[] = array(
                'inscripción_id' => $row['inscripción_id'],
                'nombre' => $row['nombre'],
                'correo' => $row['correo'],
                'genero' => $row['genero'],
                'pais' => $row['pais'],
                'cursos_anteriores' => $row['cursos_anteriores'],
                'nota' => $row['nota'],
                'fecha_registro' => $row['fecha_registro'],
                'titulo_curso' => $row['titulo_curso']
            );
        }

        // Devolver las inscripciones como JSON
        header('Content-Type: application/json');
        echo json_encode($inscripciones);
    } else {
        // Si no se encontraron inscripciones
        echo json_encode(array()); // Devolver un arreglo vacío
    }
} else {
    // Si no se proporcionó el usuario_id
    echo "Error: No se proporcionó el parámetro usuario_id.";
}

// Cerrar la conexión
$conn->close();
?>
