<?php
require_once "../../api_login/middleware/admin.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Registrar Categoría</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Volver</a>

    <form action="guardar.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre de la Categoría</label>
            <input type="text" name="nombre" class="form-control" required placeholder="Ej. Arcos Ecológicos, Ramos, etc.">
        </div>
        <button type="submit" class="btn btn-success">Guardar Categoría</button>
    </form>
</div>

</body>
</html>