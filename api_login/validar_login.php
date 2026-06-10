<?php

session_start();

require_once "../config/conexion.php";

// Verificar que venga del formulario
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: Paginaweb/catalogo.php");
    exit();
}

// Recibir datos
$usuario = trim($_POST['usuario']);
$password = $_POST['password'];

// Buscar por usuario o email
$sql = "SELECT * FROM usuarios
        WHERE usuario = ?
        OR email = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $usuario, $usuario);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    echo "
    <script>
        alert('Usuario no encontrado');
        window.location='login.php';
    </script>
    ";
    exit();
}

$user = $resultado->fetch_assoc();

// Verificar contraseña
if (!password_verify($password, $user['password'])) {

    echo "
    <script>
        alert('Contraseña incorrecta');
        window.location='login.php';
    </script>
    ";
    exit();
}

// Crear variables de sesión
$_SESSION['id'] = $user['id'];
$_SESSION['nombre'] = $user['nombre'];
$_SESSION['usuario'] = $user['usuario'];
$_SESSION['rol'] = $user['rol'];

// Redirección según rol
if ($user['rol'] == 'ADMIN') {
    header("Location: ../admin/dashboard.php");
} else {
    // CAMBIO: Ahora el cliente vuelve a la página principal
    header("Location: ../index.php");
}

exit();
?>
