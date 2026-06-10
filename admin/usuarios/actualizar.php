<?php
require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $rol = $_POST['rol'];
    $password_nueva = $_POST['password'];

    if (!empty($password_nueva)) {
        // Si escribió una contraseña nueva, la encriptamos y actualizamos todo
        $password_encriptada = password_hash($password_nueva, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nombre = ?, email = ?, password = ?, rol = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $email, $password_encriptada, $rol, $id);
    } else {
        // Si dejó la contraseña vacía, actualizamos todo MENOS la contraseña
        $sql = "UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $email, $rol, $id);
    }

    if ($stmt->execute()) {
        header("Location: index.php?status=updated");
        exit();
    } else {
        echo "Error al actualizar el usuario: " . $conexion->error;
    }
}
?>