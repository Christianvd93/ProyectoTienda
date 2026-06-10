<?php
require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

// 1. Verificar que se haya enviado un ID válido por la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    $id = $_GET['id'];

    // 2. Consultar el nombre de la imagen antes de eliminar el registro
    $query = "SELECT imagen FROM productos WHERE id = ?";
    $stmtSelect = $conexion->prepare($query);
    $stmtSelect->bind_param("i", $id);
    $stmtSelect->execute();
    $resultado = $stmtSelect->get_result();
    $producto = $resultado->fetch_assoc();

    if ($producto) {
        
        // 3. Borrar la imagen física del servidor si es que existe
        $nombreImagen = $producto['imagen'];
        
        if (!empty($nombreImagen)) {
            $rutaImagen = "../../uploads/productos/" . $nombreImagen;
            
            // Comprueba si el archivo realmente está en la carpeta antes de intentar borrarlo
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen); // unlink() es la función de PHP para borrar archivos
            }
        }

        // 4. Eliminar el registro de la base de datos
        $sqlDelete = "DELETE FROM productos WHERE id = ?";
        $stmtDelete = $conexion->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id);

        if ($stmtDelete->execute()) {
            // Redireccionar al panel principal con un mensaje de éxito silencioso en la URL
            header("Location: index.php?status=deleted");
            exit();
        } else {
            echo "Error al eliminar el registro de la base de datos: " . $conexion->error;
        }

    } else {
        // Si el producto no se encuentra en la base de datos, simplemente redirecciona
        header("Location: index.php");
        exit();
    }

} else {
    // Si no llega ningún ID por la URL, redirecciona por seguridad
    header("Location: index.php");
    exit();
}
?>