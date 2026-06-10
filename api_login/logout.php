<?php
session_start();
session_unset();
session_destroy();

// Redirigir siempre a la página principal pública
header("Location: ../index.php");
exit();
?>