<?php
require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$query = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$usuario = $query->get_result()->fetch_assoc();

if (!$usuario) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Editar Usuario</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Volver</a>

    <form action="actualizar.php" method="POST">
        <input type="hidden" name="id" value="<?= $usuario['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Correo Electrónico (Email)</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nueva Contraseña (Opcional)</label>
            <input type="password" name="password" class="form-control" minlength="6">
            <small class="text-muted">Deje este campo vacío si NO desea cambiar la contraseña actual.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Rol del Usuario</label>
            <select name="rol" class="form-control" required>
                <option value="admin" <?= $usuario['rol'] == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                <option value="cliente" <?= $usuario['rol'] == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>

</body>
</html>