<?php
require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

// Consultar los usuarios registrados
$query = "SELECT id, nombre, email, rol FROM usuarios ORDER BY id DESC";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Gestión de Usuarios</h2>
    
    <div class="mb-3">
        <a href="../dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        <a href="crear.php" class="btn btn-success">Nuevo Usuario</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = $resultado->fetch_assoc()) : ?>
            <tr>
                <td><?= $user['id']; ?></td>
                <td><?= htmlspecialchars($user['nombre']); ?></td>
                <td><?= htmlspecialchars($user['email']); ?></td>
                <td>
                    <span class="badge <?= $user['rol'] == 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                        <?= strtoupper($user['rol']); ?>
                    </span>
                </td>
                <td>
                    <a href="editar.php?id=<?= $user['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="eliminar.php?id=<?= $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>