<?php

require_once "../../api_login/middleware/admin.php";
require_once "../../config/conexion.php";

$categorias = $conexion->query("SELECT * FROM categorias");

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Nuevo Producto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

    <h2>Registrar Producto</h2>

    <a href="index.php" class="btn btn-secondary mb-3">
        Volver
    </a>

        <form
            action="guardar.php"
            method="POST"
            enctype="multipart/form-data">

        <div class="mb-3">

            <label class="form-label">
                Categoría
            </label>

            <select
                name="categoria_id"
                class="form-control"
                required>

                <option value="">
                    Seleccione una categoría
                </option>

                <?php while($cat = $categorias->fetch_assoc()) : ?>

                    <option value="<?= $cat['id']; ?>">
                        <?= $cat['nombre']; ?>
                    </option>

                <?php endwhile; ?>

            </select>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Nombre
            </label>

            <input
                type="text"
                name="nombre"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Descripción
            </label>

            <textarea
                name="descripcion"
                class="form-control"
                rows="4"></textarea>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Precio
            </label>

            <input
                type="number"
                step="0.01"
                name="precio"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Stock
            </label>

            <input
                type="number"
                name="stock"
                class="form-control"
                required>

        </div>

       
        <div class="mb-3">

            <label class="form-label">
                Imagen del Producto
            </label>

        <input
            type="file"
            name="imagen"
            class="form-control"
            accept="image/*">

</div>
     <button
            type="submit"
            class="btn btn-success">

            Guardar Producto

        </button>
    </form>

</div>

</body>

</html>