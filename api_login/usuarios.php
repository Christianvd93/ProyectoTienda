<?php
// http://localhost/Proyectotienda/api_login/usuarios.php

/* ======================================================
   MOSTRAR ERRORES
====================================================== */

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ======================================================
   CORS
====================================================== */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

/* ======================================================
   RESPUESTA JSON
====================================================== */

header("Content-Type: application/json");

/* ======================================================
   CONEXIÓN
====================================================== */

include("conexion.php");

/* ======================================================
   MÉTODO HTTP
====================================================== */

$metodo = $_SERVER['REQUEST_METHOD'];

/* ======================================================
   SWITCH MÉTODOS
====================================================== */

switch($metodo){

    /* ==================================================
       GET -> LISTAR
    ================================================== */

    case 'GET':

        $sql = "SELECT id, usuario FROM usuarios";

        $resultado = $conn->query($sql);

        $usuarios = [];

        while($fila = $resultado->fetch_assoc()){
            $usuarios[] = $fila;
        }

        if(count($usuarios) > 0){

            echo json_encode([
                "estado" => true,
                "cantidad" => count($usuarios),
                "usuarios" => $usuarios
            ]);

        }else{

            echo json_encode([
                "estado" => false,
                "mensaje" => "No existen usuarios"
            ]);
        }

    break;


    /* ==================================================
       POST -> INSERTAR
    ================================================== */

    case 'POST':

        $datos = json_decode(file_get_contents("php://input"), true);

        $usuario = $datos['usuario'];
        $password = $datos['password'];

        $sql = "INSERT INTO usuarios(usuario, password)
                VALUES('$usuario','$password')";

        if($conn->query($sql)){

            echo json_encode([
                "estado" => true,
                "mensaje" => "Usuario registrado correctamente"
            ]);

        }else{

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error al registrar usuario"
            ]);
        }

    break;


    /* ==================================================
       PUT -> ACTUALIZAR
    ================================================== */

    case 'PUT':

        $datos = json_decode(file_get_contents("php://input"), true);

        $id = $datos['id'];
        $usuario = $datos['usuario'];
        $password = $datos['password'];

        $sql = "UPDATE usuarios
                SET usuario='$usuario',
                    password='$password'
                WHERE id=$id";

        if($conn->query($sql)){

            echo json_encode([
                "estado" => true,
                "mensaje" => "Usuario actualizado correctamente"
            ]);

        }else{

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error al actualizar usuario"
            ]);
        }

    break;


    /* ==================================================
       DELETE -> ELIMINAR
    ================================================== */

    case 'DELETE':

        $id = $_GET['id'];

        $sql = "DELETE FROM usuarios WHERE id=$id";

        if($conn->query($sql)){

            echo json_encode([
                "estado" => true,
                "mensaje" => "Usuario eliminado correctamente"
            ]);

        }else{

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error al eliminar usuario"
            ]);
        }

    break;


    /* ==================================================
       MÉTODO NO PERMITIDO
    ================================================== */

    default:

        echo json_encode([
            "estado" => false,
            "mensaje" => "Método no permitido"
        ]);

    break;
}

?>