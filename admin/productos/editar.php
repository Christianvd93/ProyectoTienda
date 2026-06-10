<?php
require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

// 1. Verificar si existe el ID en la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// 2. Obtener los datos actuales del producto
$queryProducto = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
$queryProducto->bind_param("i", $id);
$queryProducto->execute();
$resultado = $queryProducto->get_result();
$producto = $resultado->fetch_assoc();

// Si el producto no existe, redirigir
if (!$producto) {
    header("Location: index.php");
    exit();
}

// 3. Obtener todas las categorías para el menú desplegable
$categorias = $conexion->query("SELECT * FROM categorias");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4 mb-5">
    <h2>Editar Producto</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Volver al Listado</a>

    <form action="actualizar.php" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="id" value="<?= $producto['id']; ?>">
        <input type="hidden" name="imagen_actual" value="<?= $producto['imagen']; ?>">

        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria_id" class="form-control" required>
                <option value="">Seleccione una categoría</option>
                <?php while($cat = $categorias->fetch_assoc()) : ?>
                    <option value="<?= $cat['id']; ?>" <?= $cat['id'] == $producto['categoria_id'] ? 'selected' : ''; ?>>
                        <?= $cat['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre del Producto</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="4"><?= htmlspecialchars($producto['descripcion']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['precio']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="<?= $producto['stock']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label d-block">Imagen Actual del Accesorio</label>
            <?php if (!empty($producto['imagen'])) : ?>
                <div class="mb-2">
                    <img src="../../uploads/productos/<?= $producto['imagen']; ?>" width="150" height="150" style="object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                </div>
            <?php else : ?>
                <span class="badge bg-secondary mb-2 d-inline-block">Sin imagen asignada</span>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label class="form-label">Subir Nueva Imagen (Opcional)</label>
            <input type="file" name="imagen" class="form-control" accept="image/*">
            <small class="text-muted">Deje este campo vacío si desea conservar la foto que ya tiene el producto.</small>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
    </form>
</div>

</body>
</html>