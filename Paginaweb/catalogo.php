<?php
session_start();
// Protección: Solo usuarios logueados pueden ver el catálogo
if (!isset($_SESSION['id'])) {
    header("Location: ../api_login/login.php");
    exit();
}

require_once "../config/conexion.php";

// Capturar parámetros
$categoria_id = isset($_GET['categoria']) ? intval($_GET['categoria']) : null;
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : null;
$max_precio = isset($_GET['max_precio']) ? floatval($_GET['max_precio']) : null;

// Construir consulta base
$sql = "SELECT * FROM productos WHERE estado = 'ACTIVO'";
$params = [];
$types = "";

if ($categoria_id) {
    $sql .= " AND categoria_id = ?";
    $params[] = $categoria_id;
    $types .= "i";
}

if ($max_precio) {
    $sql .= " AND precio <= ?";
    $params[] = $max_precio;
    $types .= "d";
}

if ($busqueda) {
    $sql .= " AND (nombre LIKE ? OR descripcion LIKE ?)";
    $busqueda_like = "%$busqueda%";
    $params[] = $busqueda_like;
    $params[] = $busqueda_like;
    $types .= "ss";
}

$stmt = $conexion->prepare($sql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$productos = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo | Accesorios Florales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<div class="container mt-5 pt-5">
    <h2 class="mb-4 text-dark fw-bold">
        <?php echo $busqueda ? "Resultados para: " . htmlspecialchars($busqueda) : "Catálogo de Productos"; ?>
    </h2>
    <div class="container mt-5 pt-5">
    <div class="row">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="gridProductos">
         <?php if ($productos->num_rows > 0): ?>
         <?php endif; ?>
</div>
        <aside class="col-lg-3 mb-4">
            <div class="card p-3 border-0 shadow-sm rounded-4">
                <h5 class="fw-bold mb-3">Filtros</h5>
                <form action="catalogo.php" method="GET">
                    <?php if($categoria_id): ?> <input type="hidden" name="categoria" value="<?= $categoria_id ?>"> <?php endif; ?>
                    
                    <div class="mb-3">
                        <label class="form-label small">Precio máximo</label>
                        <input type="range" class="form-range" name="max_precio" id="rangePrecio" min="0" max="1000000" step="50000">
                        <div class="d-flex justify-content-between small">
                            <span>$0</span>
                            <span id="valorPrecio">$500.000</span>
                        </div>
                    </div>
                    
                    <hr>
                    <button type="submit" class="btn btn-accent w-100">Aplicar Filtros</button>
                    <a href="catalogo.php" class="btn btn-outline-secondary w-100 mt-2">Limpiar</a>
                </form>
            </div>
        </aside>

        <main class="col-lg-9">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                </div>
        </main>
       
   </body>
</html>
    </div>
</div>

<script>
    // Dinámica simple para el rango de precio
    document.getElementById('rangePrecio').oninput = function() {
        document.getElementById('valorPrecio').innerText = '$' + parseInt(this.value).toLocaleString();
    };
</script>
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        <?php if ($productos->num_rows > 0): ?>
            <?php while($prod = $productos->fetch_assoc()): ?>
                <div class="col">
                    <div class="card card-producto h-100 shadow-sm">
                        <img src="../uploads/productos/<?= htmlspecialchars($prod['imagen']) ?>" class="card-img-top" alt="...">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($prod['nombre']) ?></h5>
                            <p class="price-tag">$<?= number_format($prod['precio'], 2) ?></p>
                            <button class="btn btn-outline-accent mt-auto" onclick="agregarAlCarrito(event, <?= $prod['id'] ?>)">Añadir al Carrito</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">No se encontraron productos con esos criterios.</p>
                <a href="../index.php" class="btn btn-accent">Volver al inicio</a>
            </div>
        <?php endif; ?>
    </div>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../script.js"></script>
</body>
</html>