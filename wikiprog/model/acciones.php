<?php
// Incluir la configuración de la base de datos
include 'db_config.php';

// Iniciar sesión
session_start(); // Asegúrate de que la sesión esté iniciada

// Verificar que se recibió la acción, el ID del curso y el usuario_id
if (!isset($_GET['accion']) || !isset($_GET['id']) || !isset($_SESSION['usuario_id'])) {
    die("Falta información necesaria.");
}

$accion = $_GET['accion'];
$curso_id = intval($_GET['id']);
$usuario_id = intval($_SESSION['usuario_id']); // Suponiendo que el ID del usuario está en la sesión

// Verificar que la acción es válida
if ($accion !== 'like' && $accion !== 'dislike') {
    die("Acción no válida.");
}

// Preparar la consulta para insertar o actualizar la interacción
$sql = "INSERT INTO interaccioncurso (curso_id, usuario_id, tipo_interaccion) 
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE tipo_interaccion = VALUES(tipo_interaccion)";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('iis', $curso_id, $usuario_id, $accion);

    if ($stmt->execute()) {
        header('Location: ../controller/controlador.php?seccion=seccion6');
    } else {
        echo "Error al registrar la interacción: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error en la preparación de la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();

// Opcional: redirigir a una página específica después de registrar la interacción
// header('Location: ../ruta_a_tu_pagina.php');
// exit();
?>