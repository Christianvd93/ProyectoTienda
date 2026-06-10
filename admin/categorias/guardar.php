<?php
require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);

    if (!empty($nombre)) {
        $sql = "INSERT INTO categorias (nombre) VALUES (?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $nombre);

        if ($stmt->execute()) {
            header("Location: index.php?status=created");
            exit();
        } else {
            echo "Error al guardar la categoría: " . $conexion->error;
        }
    } else {
        echo "El nombre de la categoría no puede estar vacío.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>