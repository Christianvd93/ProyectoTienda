<?php

// Conexión a la base de datos
require_once "../config/conexion.php";

// Verificar que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recibir datos del formulario
    $nombre     = trim($_POST['nombre']);
    $apellidos  = trim($_POST['apellidos']);
    $telefono   = trim($_POST['telefono']);
    $email      = trim($_POST['email']);
    $usuario    = trim($_POST['usuario']);
    $password   = $_POST['password'];

    // Validar campos obligatorios
    if (
        empty($nombre) ||
        empty($apellidos) ||
        empty($email) ||
        empty($usuario) ||
        empty($password)
    ) {
        die("Todos los campos obligatorios son requeridos.");
    }

    // Verificar correo existente
    $sql = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        die("El correo ya se encuentra registrado.");
    }

    // Verificar usuario existente
    $sql = "SELECT id FROM usuarios WHERE usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        die("El usuario ya existe.");
    }

    // Encriptar contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario
    $sql = "INSERT INTO usuarios
    (
        nombre,
        apellidos,
        telefono,
        email,
        usuario,
        password,
        rol
    )
    VALUES
    (
        ?, ?, ?, ?, ?, ?, 'CLIENTE'
    )";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "ssssss",
        $nombre,
        $apellidos,
        $telefono,
        $email,
        $usuario,
        $passwordHash
    );

    if ($stmt->execute()) {

        echo "
        <script>
            alert('Usuario registrado correctamente');
            window.location='login.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Error al registrar usuario');
            history.back();
        </script>
        ";
    }

} else {

    header("Location: registro.php");
    exit();
}