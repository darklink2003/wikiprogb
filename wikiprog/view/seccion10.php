<?php
// Inicia la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: controlador.php?seccion=seccion2&error=not_logged_in");
    exit();
}

// Incluir el archivo de configuración de la base de datos
include '../model/db_config.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el usuario_id de la sesión
$usuario_id = $_SESSION['usuario_id'];

// Consulta SQL para obtener los datos del usuario
$sql = "SELECT usuario, correo, biografia FROM usuario WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    // Manejar el caso en que no se encuentren datos del usuario
    $user_data = [
        'usuario' => '',
        'correo' => '',
        'biografia' => ''
    ];
}

$stmt->close();
$conn->close();
?>

<!-- actualizar perfil -->
<div class="container2">
    <!-- fila y columnas izquierdas -->
    <div class="row">
        <div id="formulario" class="col-md-7">
            <div id="linea" class="row">
                <h1>Perfil Público</h1>
                <hr style="color: white; font-size: 20px;">
            </div>
            <div class="row">
                <div id="formulario2" class="col-md-6">
                    <form action="../model/actualizar_datos.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="formGroupExampleInput">Nombre</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" name="nombre" value="<?php echo htmlspecialchars($user_data['usuario']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Correo Público</label>
                            <input type="email" class="form-control" id="formGroupExampleInput2" name="correo" value="<?php echo htmlspecialchars($user_data['correo']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="biografia">Biografía</label>
                            <textarea class="form-control" id="biografia" name="biografia" rows="3"><?php echo htmlspecialchars($user_data['biografia']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="perfil_imagen">Imagen de Perfil</label>
                            <input type="file" class="form-control-file" id="perfil_imagen" name="perfil_imagen" >
                        </div>
                        <button id="boton_perfil" type="submit" class="btn btn-primary">Actualizar Perfil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
