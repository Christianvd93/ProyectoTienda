<?php

require_once "../api_login/middleware/admin.php";
require_once "../config/conexion.php";

// Contar productos
$sqlProductos = "SELECT COUNT(*) AS total FROM productos";
$resProductos = $conexion->query($sqlProductos);
$totalProductos = $resProductos->fetch_assoc()['total'];

// Contar categorías
$sqlCategorias = "SELECT COUNT(*) AS total FROM categorias";
$resCategorias = $conexion->query($sqlCategorias);
$totalCategorias = $resCategorias->fetch_assoc()['total'];

// Contar usuarios
$sqlUsuarios = "SELECT COUNT(*) AS total FROM usuarios";
$resUsuarios = $conexion->query($sqlUsuarios);
$totalUsuarios = $resUsuarios->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-dark text-white">
            <h3>Accesorios Ipiales - Administrador</h3>
        </div>

        <div class="card-body">

            <h5>
                Bienvenido:
                <?php echo $_SESSION['nombre']; ?>
            </h5>

    <div class="mb-4">

        <a href="productos/index.php" class="btn btn-primary">
        
    Productos
        </a>        

            <a href="categorias/" class="btn btn-success">
                Categorías
            </a>

                <a href="usuarios/" class="btn btn-warning">
                    Usuarios
                </a>

</div>

            <hr>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h2><?php echo $totalProductos; ?></h2>
                            <p>Productos</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h2><?php echo $totalCategorias; ?></h2>
                            <p>Categorías</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h2><?php echo $totalUsuarios; ?></h2>
                            <p>Usuarios</p>
                        </div>
                    </div>
                </div>

            </div>

            <hr>

            <a href="../api_login/logout.php" class="btn btn-danger">
                Cerrar Sesión
            </a>

        </div>

    </div>

</div>

</body>
</html>