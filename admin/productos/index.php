<?php

require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

$sql = "SELECT p.*, c.nombre AS categoria
        FROM productos p
        LEFT JOIN categorias c
        ON p.categoria_id = c.id
        ORDER BY p.id DESC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <h2>Gestión de Productos</h2>

    <a href="../dashboard.php" class="btn btn-secondary mb-3">
        Volver al Dashboard
    </a>

    <a href="crear.php" class="btn btn-success mb-3">
        Nuevo Producto
    </a>

    <table class="table table-bordered">

        <thead class="table-dark">

            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>

        </thead>

        <tbody>

        <?php while($producto = $resultado->fetch_assoc()) : ?>

            <tr>

                <td><?= $producto['id']; ?></td>
                <td>
                    <?php if (!empty($producto['imagen'])) : ?>
                        <img src="../../uploads/productos/<?= $producto['imagen']; ?>" width="80" height="80" style="object-fit: cover; border-radius: 8px;">
                    <?php else : ?>
                        <span class="badge bg-secondary">Sin imagen</span>
                    <?php endif; ?>
                </td>

                <td><?= $producto['categoria']; ?></td>

                <td><?= $producto['nombre']; ?></td>

                <td>$<?= number_format($producto['precio']); ?></td>

                <td><?= $producto['stock']; ?></td>

                <td><?= $producto['estado']; ?></td>
                <td>

            <a
                href="editar.php?id=<?= $producto['id']; ?>"
                class="btn btn-warning btn-sm">

                Editar

            </a>

            <a
                href="eliminar.php?id=<?= $producto['id']; ?>"
                class="btn btn-danger btn-sm"
                onclick="return confirm('¿Desea eliminar este producto?');">

                Eliminar

            </a>

        </td>

            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

</body>
</html>