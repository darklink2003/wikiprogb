<!-- iniciar.php -->
<?php
session_start();

// Configuración de la base de datos
include '../model/db_config.php'; // Incluir el archivo de configuración de la base de datos

// Obtener los datos del formulario
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Verificar si se han enviado datos de inicio de sesión
if (!empty($username) && !empty($password)) {
    // Consulta para obtener el usuario por nombre de usuario
    $stmt = $conn->prepare("SELECT usuario_id, contraseña, intentos_fallidos FROM usuario WHERE usuario = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar si el usuario está bloqueado por intentos fallidos
        if ($user['intentos_fallidos'] >= 3) {
            // Usuario bloqueado
            echo "Tu cuenta ha sido bloqueada debido a múltiples intentos fallidos. Por favor, contacta al administrador.";
            exit();
        }

        // Verificar la contraseña
        if ($password === $user['contraseña']) {
            // Inicio de sesión exitoso
            $_SESSION['usuario_id'] = $user['usuario_id'];
            $_SESSION['logged_in'] = true;  // Variable de sesión para el estado de inicio de sesión
            
            // Reiniciar intentos fallidos
            $stmt_reset_attempts = $conn->prepare("UPDATE usuario SET intentos_fallidos = 0 WHERE usuario_id = ?");
            $stmt_reset_attempts->bind_param("i", $user['usuario_id']);
            $stmt_reset_attempts->execute();
            $stmt_reset_attempts->close();
            
            // Redireccionar a la sección correspondiente
            header("Location: controlador.php?seccion=seccion1");
            exit();
        } else {
            // Contraseña incorrecta
            incrementarIntentosFallidos($conn, $user['usuario_id']);
            header("Location: controlador.php?seccion=seccion2");
            exit();
        }
    } else {
        // Usuario no encontrado
        echo "Usuario no encontrado: $username";
    }

    $stmt->close();
} else {
    // Datos de inicio de sesión no enviados
    echo "Por favor, ingresa nombre de usuario y contraseña.";
}

$conn->close();

// Función para incrementar los intentos fallidos del usuario
function incrementarIntentosFallidos($conn, $usuario_id) {
    $stmt_increment_attempts = $conn->prepare("UPDATE usuario SET intentos_fallidos = intentos_fallidos + 1 WHERE usuario_id = ?");
    $stmt_increment_attempts->bind_param("i", $usuario_id);
    $stmt_increment_attempts->execute();
    $stmt_increment_attempts->close();
}
?>
