<?php
// Incluir el archivo de configuración de la base de datos
include('../model/db_config.php');

// Verificar si se recibieron los datos a través del método GET
if (isset($_GET['nombre']) && isset($_GET['correo'])) {
    $nombre = $_GET['nombre'];
    $correo = $_GET['correo'];

    // Verificar que no estén vacíos
    if (!empty($nombre) && !empty($correo)) {
        // Preparar y ejecutar la consulta SQL
        $stmt = $conn->prepare("SELECT contraseña FROM usuario WHERE usuario = ? AND correo = ?");
        $stmt->bind_param("ss", $nombre, $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se encontró el usuario
        if ($result->num_rows > 0) {
            // Obtener la fila de resultados
            $row = $result->fetch_assoc();
            $contraseña = $row['contraseña'];

            // Redirigir a otro archivo PHP con los datos
            header("location: ../controller/contraseña.php?nombre=$nombre&correo=$correo&contraseña=$contraseña");
            exit(); // Asegúrate de terminar el script después de redirigir
        } else {
            echo "Usuario o correo incorrectos.";
        }

        // Cerrar la declaración y la conexión
        $stmt->close();
    } else {
        echo "Por favor, complete todos los campos.";
    }
} else {
    echo "Datos no recibidos correctamente.";
}

$conn->close();
?>
