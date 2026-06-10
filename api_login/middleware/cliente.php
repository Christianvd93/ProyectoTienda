<?php

require_once "auth.php";

if ($_SESSION['rol'] != 'CLIENTE') {

    header("Location: /Proyectotienda/admin/dashboard.php");
    exit();
}
?>