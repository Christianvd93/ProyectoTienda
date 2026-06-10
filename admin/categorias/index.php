<?php
require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

// Consultar todas las categorías
$query = "SELECT * FROM categorias ORDER BY id DESC";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Gestión de Categorías</h2>
    
    <div class="mb-3">
        <a href="../dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        <a href="crear.php" class="btn btn-success">Nueva Categoría</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($cat = $resultado->fetch_assoc()) : ?>
            <tr>
                <td><?= $cat['id']; ?></td>
                <td><?= htmlspecialchars($cat['nombre']); ?></td>
                <td>
                    <a href="editar.php?id=<?= $cat['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="eliminar.php?id=<?= $cat['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta categoría?');">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>