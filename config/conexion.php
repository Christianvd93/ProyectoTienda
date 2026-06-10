<?php
/*
|--------------------------------------------------------------------------
| CONEXIÓN A LA BASE DE DATOS
|--------------------------------------------------------------------------
| Proyecto: Accesorios Ipiales
| Motor BD: MySQL
| Entorno: XAMPP
|--------------------------------------------------------------------------
*/

/* Datos de conexión */
$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "proyectotienda";

/* Crear conexión */
$conexion = new mysqli(
    $host,
    $usuario,
    $password,
    $base_datos
);

/* Verificar conexión */
if ($conexion->connect_error) {
    die(
        "Error de conexión: " .
        $conexion->connect_error
    );
}

/* Configurar caracteres UTF-8 */
$conexion->set_charset("utf8mb4");
?>