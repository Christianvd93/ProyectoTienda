<?php

// ACTIVAR ERRORES
error_reporting(E_ALL);
ini_set('display_errors', 1);

// PERMITIR CORS
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: Content-Type");

header("Access-Control-Allow-Methods: POST");

// RESPUESTA JSON
header("Content-Type: application/json");

// CONEXIÓN
include("conexion.php");

// OBTENER JSON
$data =
json_decode(
    file_get_contents("php://input"),
    true
);

// VALIDAR DATOS
if(!$data){

    echo json_encode([
        "estado" => false,
        "mensaje" => "No se recibieron datos"
    ]);

    exit();
}

// OBTENER DATOS
$usuario = trim($data["usuario"]);
$password = trim($data["password"]);

// VALIDAR VACÍOS
if(empty($usuario) || empty($password)){

    echo json_encode([
        "estado" => false,
        "mensaje" => "Todos los campos son obligatorios"
    ]);

    exit();
}

// CONSULTAR USUARIO
$sql =
"SELECT * FROM usuarios
 WHERE usuario='$usuario'";

$resultado =
$conn->query($sql);

// USUARIO NO EXISTE
if($resultado->num_rows == 0){

    echo json_encode([
        "estado" => false,
        "mensaje" => "Usuario no encontrado"
    ]);

    exit();
}

// OBTENER DATOS USUARIO
$fila =
$resultado->fetch_assoc();

// VALIDAR PASSWORD
if(password_verify($password,$fila["password"])){

    echo json_encode([
        "estado" => true,
        "mensaje" => "Ingreso exitoso"
    ]);

}else{

    echo json_encode([
        "estado" => false,
        "mensaje" => "Contraseña incorrecta"
    ]);
}

?>