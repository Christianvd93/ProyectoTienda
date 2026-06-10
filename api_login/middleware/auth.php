<?php

session_start();

// Verificar si existe una sesión activa
if (!isset($_SESSION['id'])) {

    header("Location: /Proyectotienda/api_login/login.php");
    exit();
}
?>