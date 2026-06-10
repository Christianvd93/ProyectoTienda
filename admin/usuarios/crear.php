<?php
require_once "../../api_login/middleware/admin.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Registrar Usuario</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Volver</a>

    <form action="guardar.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Correo Electrónico (Email)</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>

        <div class="mb-3">
            <label class="form-label">Rol del Usuario</label>
            <select name="rol" class="form-control" required>
                <option value="">Seleccione un rol...</option>
                <option value="admin">Administrador</option>
                <option value="cliente">Cliente</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar Usuario</button>
    </form>
</div>

</body>
</html>