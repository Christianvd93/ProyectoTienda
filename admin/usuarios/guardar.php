<?php
require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password_plana = $_POST['password'];
    $rol = $_POST['rol'];

    // Encriptar la contraseña antes de guardarla (CRÍTICO)
    $password_encriptada = password_hash($password_plana, PASSWORD_DEFAULT);

    // Preparar la consulta
    $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    
    // Bind_param: ssss (4 strings)
    $stmt->bind_param("ssss", $nombre, $email, $password_encriptada, $rol);

    if ($stmt->execute()) {
        header("Location: index.php?status=created");
        exit();
    } else {
        echo "Error al guardar el usuario: " . $conexion->error;
    }
} else {
    header("Location: index.php");
    exit();
}
?>