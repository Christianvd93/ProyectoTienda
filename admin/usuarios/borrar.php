<?php
require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?status=deleted");
    } else {
        echo "Error al eliminar: " . $conexion->error;
    }
} else {
    header("Location: index.php");
}
exit();
?>