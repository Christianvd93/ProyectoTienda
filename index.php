<?php
session_start();

require_once "config/conexion.php"; 

$usuario_logueado = isset($_SESSION['id']);
$nombre_usuario = $usuario_logueado ? $_SESSION['nombre'] : '';
$rol_usuario = $usuario_logueado ? $_SESSION['rol'] : ''; 

// Consulta productos aleatorios
$query_random = "SELECT id, nombre, precio, imagen FROM productos WHERE estado = 'ACTIVO' ORDER BY RAND() LIMIT 8";
$resultado_random = $conexion->query($query_random);

// Consulta categorías
$query_categorias = "SELECT id, nombre FROM categorias ORDER BY nombre ASC";
$resultado_categorias = $conexion->query($query_categorias);
$categorias = [];
if ($resultado_categorias) {
    while($cat = $resultado_categorias->fetch_assoc()) {
        $categorias[] = $cat;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesorios Florales | Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand text-dark" href="index.php">
            <span class="text-accent">✿</span> Accesorios Florales
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link text-dark" href="index.php">Inicio</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" data-bs-toggle="dropdown">Categorías</a>
                    <ul class="dropdown-menu shadow border-0 rounded-3">
                        <?php foreach($categorias as $cat): ?>
                            <li><a class="dropdown-item" href="#" onclick="verificarAccesoCategoria(<?= $cat['id'] ?>)"><?= htmlspecialchars($cat['nombre']) ?></a></li>
                        <?php endforeach; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item fw-bold text-accent" href="#" onclick="verificarAcceso('Paginaweb/catalogo.php')">Ver todo el catálogo</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link text-dark" href="#contacto">Contacto</a></li>
            </ul>

            <form class="d-flex mx-3" action="Paginaweb/catalogo.php" method="GET" onsubmit="return verificarBusqueda(event)">
                <input class="form-control rounded-pill px-3 border-1 border-secondary-subtle shadow-sm" type="search" name="buscar" placeholder="Buscar diseños..." aria-label="Search" required>
            </form>

<ul class="navbar-nav align-items-center">
    <li class="nav-item me-4">
        <a class="nav-link text-dark position-relative" href="#" onclick="verificarAcceso('Paginaweb/carrito.php')">
            🛒 Carrito 
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="background-color: var(--rosa-curuba) !important;" id="contadorCarrito">0</span>
        </a>
    </li>

               <?php if ($usuario_logueado): ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                👤 <?= htmlspecialchars($nombre_usuario); ?>
            </a>

        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                <?php if ($rol_usuario === 'ADMIN'): ?>
                    <li><a class="dropdown-item" href="admin/dashboard.php">Mi Panel Admin</a></li>
                    <li><hr class="dropdown-divider"></li>
                <?php endif; ?>
                <li><a class="dropdown-item text-danger" href="api_login/logout.php">Cerrar Sesión</a></li>
            </ul>
        </li>      
        <?php else: ?>
        <li class="nav-item">
            <a class="btn btn-outline-accent px-4" href="api_login/login.php">Iniciar Sesión</a>
        </li>
    <?php endif; ?>
</ul>          
  
                    
        </div>
    </div>
</nav>

<section class="hero-section">
    <div class="container text-center">
        <span class="badge rounded-pill mb-3 px-3 py-2" style="background-color: #f8bbd0; color: #ad1457;">Colección Botánica</span>
            <h1 class="display-4 hero-title">Accesorios y Productos <span class="text-accent">Ipiales</span></h1>
                <p class="lead text-muted mt-3 mx-auto" style="max-width: 600px;">
            Descubre nuestra selección exclusiva de accesorios florales y arcos ecológicos elaborados con especies nativas.
        </p>

        <div class="category-rail-container">
            <div class="category-rail">
                <?php if (count($categorias) > 0): ?>
                    <?php foreach($categorias as $cat): ?>
                        <div class="category-card shadow-sm" onclick="verificarAccesoCategoria(<?= $cat['id'] ?>)">
                            <h4 class="m-0"><?= htmlspecialchars($cat['nombre']) ?></h4>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Aún no hay categorías registradas.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="container mt-5 pt-4">
    <div class="d-flex justify-content-between align-items-end mb-4 px-4">
        <h2 class="text-dark fw-bold mb-0">Piezas Destacadas</h2>
        <a href="#" onclick="verificarAcceso('Paginaweb/catalogo.php')" class="text-accent text-decoration-none fw-bold">Ver todo ➔</a>
    </div>
    
    <div class="rail-container">
        <button class="rail-btn btn-left" onclick="moverRiel(-320)">&#10094;</button>
        <div class="product-rail" id="rielProductos">
            <?php if ($resultado_random && $resultado_random->num_rows > 0): ?>
                <?php while($prod = $resultado_random->fetch_assoc()): ?>
                    <div class="card card-producto shadow-sm">
                        <?php 
                        $imagen = !empty($prod['imagen']) ? "uploads/productos/" . $prod['imagen'] : "assets/img/sin-imagen.png";
                        ?>
                        <img src="<?= $imagen ?>" class="card-img-top" alt="<?= htmlspecialchars($prod['nombre']) ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-dark fw-bold mb-1"><?= htmlspecialchars($prod['nombre']) ?></h5>
                            <p class="price-tag mt-auto mb-3">$<?= number_format($prod['precio'], 2) ?></p>
                            <button class="btn btn-outline-accent w-100 mt-auto" onclick="agregarAlCarrito(event, <?= $prod['id'] ?>)">Añadir al Carrito</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center w-100 text-muted">Aún no hay productos disponibles.</p>
            <?php endif; ?>
        </div>
        <button class="rail-btn btn-right" onclick="moverRiel(320)">&#10095;</button>
    </div>
</section>

<footer id="contacto" class="text-center py-5 mt-5">
    <div class="container">
        <h5 class="text-white mb-3">Accesorios Florales</h5>
        <p class="mb-1 text-muted">Tel: +57 123 456 7890 | Email: contacto@accesoriosflorales.com</p>
        <p class="text-muted small mt-4">&copy; 2026. Todos los derechos reservados.</p>
    </div>
</footer>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCarrito" aria-labelledby="offcanvasCarritoLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasCarritoLabel">Tu Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div id="listaProductosCarrito"></div>
        
        <hr>
        <div id="resumenCarrito" class="mt-4">
            <p>Productos: <span id="countItems">0</span></p>
            <p>Subtotal: <span id="subtotalCarrito">$0</span></p>
            <p><strong>Total: <span id="totalCarrito">$0</span></strong></p>
            <button class="btn btn-accent w-100">Finalizar Compra</button>
        </div>
    </div>
</div>

<script>
    const usuarioLogueado = <?= $usuario_logueado ? 'true' : 'false' ?>;
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>
<script src="script.js?v=<?= time(); ?>"></script>
</body>
</html>