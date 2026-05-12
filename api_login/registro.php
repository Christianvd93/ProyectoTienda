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
$nombre = $input["nombre"] ?? "";
$apellidos = $input["apellidos"] ?? "";
$telefono = $input["telefono"] ?? "";

// VALIDAR CAMPOS
if(empty($usuario) || empty($password)){

    echo json_encode([
        "estado" => false,
        "mensaje" => "Todos los campos son obligatorios"
    ]);

    exit();
}

// VALIDAR PASSWORD
if(strlen($password) < 6){

    echo json_encode([
        "estado" => false,
        "mensaje" =>
        "La contraseña debe tener mínimo 6 caracteres"
    ]);

    exit();
}

// VERIFICAR USUARIO
$sqlVerificar =
"SELECT * FROM usuarios
 WHERE usuario='$usuario'";

$resultado =
$conn->query($sqlVerificar);

// USUARIO EXISTE
if($resultado->num_rows > 0){

    echo json_encode([
        "estado" => false,
        "mensaje" => "Usuario ya existe"
    ]);

    exit();
}

// ENCRIPTAR PASSWORD
$passwordHash =
password_hash(
    $password,
    PASSWORD_DEFAULT
);

// INSERTAR USUARIO
$sql =
"INSERT INTO usuarios(usuario,password)
 VALUES('$usuario','$passwordHash')";

// EJECUTAR
if($conn->query($sql)){

    echo json_encode([
        "estado" => true,
        "mensaje" =>
        "Usuario registrado correctamente"
    ]);

}else{

    echo json_encode([
        "estado" => false,
        "mensaje" => "Error al registrar"
    ]);
}

?>