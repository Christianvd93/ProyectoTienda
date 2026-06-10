<?php
require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

// 1. Recibir los datos del formulario
$id = $_POST['id'];
$categoria_id = $_POST['categoria_id'];
$nombre = trim($_POST['nombre']);
$descripcion = trim($_POST['descripcion']);
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$imagen_actual = $_POST['imagen_actual'];

// Por defecto, asumimos que se mantiene la imagen que ya existía
$nombreImagen = $imagen_actual; 

// 2. Evaluar si se subió una nueva imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
    
    // Generar un nombre único para la nueva imagen para evitar duplicados
    $nombreImagen = time() . "_" . $_FILES['imagen']['name'];
    $rutaTemporal = $_FILES['imagen']['tmp_name'];
    $rutaDestino = "../../uploads/productos/" . $nombreImagen;

    // Mover el archivo físico a la carpeta del servidor
    if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
        
        // Si se subió la nueva imagen con éxito, eliminamos la anterior del servidor
        $rutaVieja = "../../uploads/productos/" . $imagen_actual;
        
        // Verificamos que el campo no estuviera vacío y que el archivo realmente exista antes de borrarlo
        if (!empty($imagen_actual) && file_exists($rutaVieja)) {
            unlink($rutaVieja); // unlink() elimina el archivo físico
        }
    }
}

// 3. Preparar la consulta de actualización en la base de datos
$sql = "UPDATE productos SET 
            categoria_id = ?, 
            nombre = ?, 
            descripcion = ?, 
            precio = ?, 
            stock = ?, 
            imagen = ? 
        WHERE id = ?";

$stmt = $conexion->prepare($sql);

if ($stmt) {
    // Definición de tipos para bind_param:
    // i = integer (categoria_id)
    // s = string (nombre)
    // s = string (descripcion)
    // d = double/decimal (precio)
    // i = integer (stock)
    // s = string (imagen)
    // i = integer (id del producto para el WHERE)
    $stmt->bind_param(
        "issdisi", 
        $categoria_id, 
        $nombre, 
        $descripcion, 
        $precio, 
        $stock, 
        $nombreImagen, 
        $id
    );

    // 4. Ejecutar y redireccionar
    if ($stmt->execute()) {
        // Redirecciona de vuelta al listado de productos si todo sale bien
        header("Location: index.php?status=updated");
        exit();
    } else {
        echo "Error al ejecutar la actualización en la base de datos: " . $stmt->error;
    }
} else {
    echo "Error al preparar la consulta SQL: " . $conexion->error;
}
?>