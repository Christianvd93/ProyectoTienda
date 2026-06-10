<?php
session_start();
require_once "../config/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tu Carrito | Accesorios Florales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container mt-5 pt-5">
        <h2 class="fw-bold mb-4">Detalle de tu carrito</h2>
        <div class="row">
            <div class="col-lg-8">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tablaCarritoDetallada">
                        </tbody>
                </table>
            </div>
            
            <div class="col-lg-4">
                <div class="card p-4 shadow-sm border-0 rounded-4">
                    <h4>Resumen del Pedido</h4>
                    <ul class="list-unstyled mt-3">
                        <li class="d-flex justify-content-between">Productos: <span id="resumenCount">0</span></li>
                        <li class="d-flex justify-content-between">Subtotal: <span id="resumenSubtotal">$0</span></li>
                        <li class="d-flex justify-content-between text-muted">Envío: <span>$10.000</span></li>
                        <hr>
                        <li class="d-flex justify-content-between fs-4 fw-bold">Total: <span id="resumenTotal">$0</span></li>
                    </ul>
                    <button class="btn btn-accent w-100 py-3 mt-3">Finalizar Compra</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>