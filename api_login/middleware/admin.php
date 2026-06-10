<?php

require_once "auth.php";

if ($_SESSION['rol'] != 'ADMIN') {

    header("Location: /Proyectotienda/Paginaweb/catalogo.php");
    exit();
}
?>