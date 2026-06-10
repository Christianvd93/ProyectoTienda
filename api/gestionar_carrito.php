<?php
session_start();
require_once "../config/conexion.php";

// Inicializar sesión de carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$action = $_GET['action'] ?? 'obtener';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lógica de acciones
if ($action == 'agregar' && $id > 0) {
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]++;
    } else {
        $_SESSION['carrito'][$id] = 1;
    }
} elseif ($action == 'aumentar' && $id > 0) {
    $_SESSION['carrito'][$id]++;
} elseif ($action == 'disminuir' && $id > 0) {
    if (isset($_SESSION['carrito'][$id]) && $_SESSION['carrito'][$id] > 1) {
        $_SESSION['carrito'][$id]--;
    }
} elseif ($action == 'eliminar' && $id > 0) {
    unset($_SESSION['carrito'][$id]);
}

// Obtener datos reales de la BD
$productos_carrito = [];
$subtotal = 0;
$envio = 10000; // Costo fijo de envío

if (!empty($_SESSION['carrito'])) {
    $ids = implode(',', array_keys($_SESSION['carrito']));
    $sql = "SELECT id, nombre, precio, imagen FROM productos WHERE id IN ($ids)";
    $res = $conexion->query($sql);
    
    while ($p = $res->fetch_assoc()) {
        $cantidad = $_SESSION['carrito'][$p['id']];
        $total_producto = $p['precio'] * $cantidad;
        $subtotal += $total_producto;
        
        $p['cantidad'] = $cantidad;
        $p['subtotal'] = $total_producto;
        $productos_carrito[] = $p;
    }
}

// Retornar JSON para JavaScript
header('Content-Type: application/json');
echo json_encode([
    'productos' => $productos_carrito,
    'total_articulos' => array_sum($_SESSION['carrito']),
    'subtotal' => $subtotal,
    'total' => $subtotal + $envio
]);
?>