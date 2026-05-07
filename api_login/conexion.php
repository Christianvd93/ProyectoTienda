<?php

// Mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DATOS MYSQL
$host = "localhost";
$user = "root";
$pass = "";
$db = "api_login";

// CREAR CONEXIÓN
$conn = new mysqli(
    $host,
    $user,
    $pass,
    $db
);

// VALIDAR CONEXIÓN
if($conn->connect_error){

    die(json_encode([
        "estado" => false,
        "mensaje" => "Error conexión BD"
    ]));
}

?>