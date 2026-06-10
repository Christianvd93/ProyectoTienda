<?php

require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

$categoria_id = $_POST['categoria_id'];
$nombre = trim($_POST['nombre']);
$descripcion = trim($_POST['descripcion']);
$precio = $_POST['precio'];
$stock = $_POST['stock'];


// Procesar imagen
$nombreImagen = "";

if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0){

    $nombreImagen = time() . "_" . $_FILES['imagen']['name'];

    $rutaTemporal = $_FILES['imagen']['tmp_name'];

    $rutaDestino =
        "../../uploads/productos/" . $nombreImagen;

    move_uploaded_file(
        $rutaTemporal,
        $rutaDestino
    );
}

$sql = "INSERT INTO productos
(
    categoria_id,
    nombre,
    descripcion,
    precio,
    stock,
    imagen,
    estado,
    fecha_creacion
)
VALUES
(
    ?, ?, ?, ?, ?, ?, 'ACTIVO', NOW()
)";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "issdis",
    $categoria_id,
    $nombre,
    $descripcion,
    $precio,
    $stock,
    $nombreImagen
);

if($stmt->execute()){

    header("Location: index.php");
    exit();

}else{

    echo "Error al guardar producto.";

}