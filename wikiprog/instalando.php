<?php
// instalando.php

$host = $_POST['host'];
$db_name = $_POST['db_name'];
$username = $_POST['username'];
$password = $_POST['password'];

// Conexión a la base de datos
$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Crear la base de datos
$sql = "CREATE DATABASE IF NOT EXISTS $db_name";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos $db_name creada con éxito.<br>";
} else {
    die("Error creando la base de datos: " . $conn->error);
}

// Seleccionar la base de datos
$conn->select_db($db_name);

// Leer el archivo de volcado de datos
$dump_file = 'dump.sql'; // Asegúrate de tener el archivo dump.sql en el mismo directorio
$sql = file_get_contents($dump_file);

if ($conn->multi_query($sql)) {
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->next_result());
    echo "Base de datos instalada con éxito.<br>";
} else {
    die("Error instalando la base de datos: " . $conn->error);
}

$conn->close();

echo '<a href="index.php">Volver a la página principal</a>';
?>
